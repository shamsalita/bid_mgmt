<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('UsersModel'));
    }

    /*
    * Function for login
    */
    public function index()
    {
        if($this->input->post()){
            $post_data = $this->input->post();
            $find_user = $this->UsersModel->find_user_by_email($post_data['email']);
            if(empty($find_user)){
                $this->session->set_flashdata('error', 'User details does not match!');
                redirect(base_url(), 'refresh');
            }
            if($find_user['password'] != md5($post_data['password'])){
                $this->session->set_flashdata('error', 'User details does not match!');
                redirect(base_url(), 'refresh');
            }
            $session_data['user'] = $find_user;
            unset($session_data['password']);
            unset($session_data['created']);
            unset($session_data['modified']);
            $this->session->set_userdata($session_data);
            if($find_user['role'] == 1){
                redirect(base_url() . 'admin/bids', 'refresh');
            }else{
                redirect(base_url() . 'user/bids', 'refresh');
            }
        }else{
            if($this->session->userdata('email')){
                if($this->session->userdata('role') == 1){
                    redirect(base_url() . 'admin/home', 'refresh');
                }else{
                    redirect(base_url() . 'user/home', 'refresh');
                }
                
            }
        }

        $data['title'] = SITE_NAME;
        $this->template->load('login_template', 'users/login', $data);
        
    }

    public function list_users()
    {
        if($this->session->userdata('user')['role'] != 1){
            redirect(base_url() . 'user/bids', 'refresh');
        }
        $data['title'] = SITE_NAME . ' | Users';
        $data['users'] = $this->UsersModel->find_user();
        $data['user_role'] = 'admin/';
        $this->template->load('default_template', 'users/user_list', $data);
    }
    
    public function add_users()
    {
        $tls = $this->UsersModel->find_tls();
        $data['tls'] = $tls;
        if($this->input->post()){
            $store_user_data = $this->input->post();
            $store_user_data['password'] = md5($store_user_data['password']);
            $add_user = $this->UsersModel->add_user($store_user_data);
            if($add_user > 0){
                $this->session->set_flashdata('success', 'User added successfully!');
            }else{
                $this->session->set_flashdata('error', 'Something went wrong. User was not added!');
            }
            redirect(base_url() . 'admin/users', 'refresh');
        }
        $data['title'] = SITE_NAME . ' | Add users';
        $data['user_role'] = 'admin/';
        $this->template->load('default_template', 'users/add_user', $data);
    }

    public function edit_user()
    {
        $tls = $this->UsersModel->find_tls();
        $data['tls'] = $tls;
        $user_id = $this->uri->segment(3);
        if($this->input->post()){
            $user_data = $this->input->post();
            if(!isset($user_data['role'])){
                $user_data['role'] = 2;
            }
            $update_user = $this->UsersModel->update_user($user_data, $user_id);
            if($update_user){
                $this->session->set_flashdata('success', 'User updated successfully!');
            }else{
                $this->session->set_flashdata('error', 'Something went wrong. User was not updated!');
            }
            redirect(base_url() . 'admin/users', 'refresh');
        }
        $data['title'] = SITE_NAME . ' | Edit users';
        $data['user_role'] = 'admin/';
        $data['user'] = $this->UsersModel->find_user($user_id);
        $this->template->load('default_template', 'users/edit_user', $data);
    }

    public function delete_user()
    {
        if($this->input->post()){
            $user_id = $this->input->post('user_id');
            $user_details = $this->UsersModel->find_user($user_id);
            if(empty($user_details)){
                echo 'fail';
                exit;
            }
            $delete_data['is_active'] = 0;
            $delete_user = $this->UsersModel->update_user($delete_data, $user_id);
            if($delete_user){
                echo 'success';
            }else{
                echo 'fail';
            }
            exit;
        }
    }

    public function change_password(Type $var = null)
    {
        $data['title'] = SITE_NAME . ' | Change Password';
        if($this->session->userdata('user')['role'] == 1){
            $data['user_role'] = 'admin/';
        }else{
            $data['user_role'] = 'user/';
        }
        if($this->input->post()){
            $user_id = $this->session->userdata('user')['role'];
            $post_data = $this->input->post();
            if($post_data['new_password'] != $post_data['confirm_password']){
                $this->session->set_flashdata('error', 'Password does not match!');
                redirect(base_url() .  $data['user_role'] . 'change_password', 'refresh');
            }
            if($post_data['current_password'] == '' || $post_data['new_password'] == '' || $post_data['confirm_password'] == ''){
                $this->session->set_flashdata('error', 'Something went wrong. Password was not updated!');
                redirect(base_url() .  $data['user_role'] . 'change_password', 'refresh');
            }
            $user = $this->UsersModel->find_user($user_id);
            if(empty($user)){
                $this->session->set_flashdata('error', 'Something went wrong. Password was not updated!');
                redirect(base_url() .  $data['user_role'] . 'change_password', 'refresh');
            }
            if($user['password'] != md5($post_data['current_password'])){
                $this->session->set_flashdata('error', 'Something went wrong. Password was not updated!');
                redirect(base_url() .  $data['user_role'] . 'change_password', 'refresh');
            }
            $update['password'] = md5($post_data['new_password']);
            $update_password = $this->UsersModel->update_user($update, $user_id);
            if($update_password){
                $this->session->set_flashdata('success', 'Your password was updated successfully!');
            }else{
                $this->session->set_flashdata('error', 'Something went wrong. Password was not updated!');
            }
            redirect(base_url() .  $data['user_role'] . 'change_password', 'refresh');
        }
        
        $this->template->load('default_template', 'users/change_password', $data);
    }
    
    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url(), 'refresh');
    }
}