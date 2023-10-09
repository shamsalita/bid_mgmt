<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bids extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('user')['email']){
            redirect(base_url(), 'refresh');
        }
        $this->load->model(array('BidsModel', 'UsersModel'));
    }

    /*
    * Function for login
    */
    public function index()
    {
        if($this->session->userdata('user')['role'] != 1){
            redirect(base_url() . 'user/bids', 'refresh');
        }
        $status_arr = array(
            1 => 'Inquiry',
            2 => 'Lead',
            3 => 'Project',
        );
        $data['title'] = SITE_NAME .  ' | Bids';
        
        $from_date = null;
        $to_date = null;
        $user_id = null;
        $bid_id = null;
        if($this->input->get('from_date') && $this->input->get('from_date') != ''){
            $from_date = $this->input->get('from_date');
            if($this->input->get('to_date') && $this->input->get('to_date') != ''){
                $to_date = $this->input->get('to_date');
            }else{
                $to_date = date('d-m-Y');
            }
        }
        $data['bids'] = $this->BidsModel->find_bid($user_id, $bid_id, $from_date, $to_date);
        $data['user_role'] = 'admin/';
        $data['status_arr'] = $status_arr;
        $this->template->load('default_template', 'users/bids', $data);
    }
    
    public function user_index()
    {
        if($this->session->userdata('user')['role'] == 1){
            redirect(base_url() . 'admin/bids', 'refresh');
        }
        $status_arr = array(
            1 => 'Inquiry',
            2 => 'Lead',
            3 => 'Project',
        );
        $data['title'] = SITE_NAME . ' | Bids';
        
        $from_date = null;
        $to_date = null;
        $user_id = $this->session->userdata('user')['id'];
        $bid_id = null;
        if($this->input->get('from_date') && $this->input->get('from_date') != ''){
            $from_date = $this->input->get('from_date');
            if($this->input->get('to_date') && $this->input->get('to_date') != ''){
                $to_date = $this->input->get('to_date');
            }else{
                $to_date = date('d-m-Y');
            }
        }

        $data['bids'] = $this->BidsModel->find_bid($user_id, $bid_id, $from_date, $to_date);
        $data['user_role'] = 'user/';
        $data['status_arr'] = $status_arr;
        $this->template->load('default_template', 'users/bids', $data);
    }
    
    public function add_bid()
    {

        $data['title'] = SITE_NAME . ' | Add Bid';
        if($this->session->userdata('user')['role'] == 1){
            $data['user_role'] = 'admin/';
        }else{
            $data['user_role'] = 'user/';
        }
        
        if($this->input->post()){
            $post_data = $this->input->post();
            $store_post = array();
            $store_post['user_id'] = $this->session->userdata('user')['id'];
            $store_post['title'] = $post_data['title'];
            $store_post['description'] = $post_data['title'];
            $store_post['client_name'] = $post_data['client_name'];
            $store_post['url'] = $post_data['url'];
            // $store_post['rate'] = $post_data['rate'];
            $store_post['technology'] = $post_data['technology'];
            $save = $this->BidsModel->add_bid($store_post);
            if($save > 0){
                $this->session->set_flashdata('success', 'Bid added successfully!');
            }else{
                $this->session->set_flashdata('error', 'Something went wrong. Bid was not added!');
            }
            redirect(base_url() . $data['user_role'] . 'bids', 'refresh');
        }

        
        $this->template->load('default_template', 'users/add_bid', $data);
    }

    public function update_status()
    {
        if($this->input->post()){
            $bid_id = $this->input->post('bid_id');
            $status = $this->input->post('status');
            $user_id = null;
            if($this->session->userdata('user')['role'] > 1){
                $user_id = $this->session->userdata('user')['id'];
            }
            $find_bid = $this->BidsModel->find_bid($user_id, $bid_id);
            if(empty($find_bid)){
                echo 'fail';
                exit;
            }
            $update_data['status'] = $status;
            if($status == 0){
                $update_data['modified_by'] = $this->session->userdata('user')['id'];
            }else{
                if($status == 2){
                    $update_data['lead_date'] = date('Y-m-d');
                }elseif($status == 3){
                    $update_data['conversion_date'] = date('Y-m-d');
                }
                $update_data['status_updated_by'] = $this->session->userdata('user')['id'];
            }
            $update = $this->BidsModel->update_bid($update_data, $bid_id);
            if($update == 1){
                echo 'success';
            }else{
                echo 'fail';
            }
            exit;
        }
    }
    
    public function edit_bid()
    {
        $bid_id = $this->uri->segment(4);
        $user_role = 'user/';
        $bid_user_id = $this->session->userdata('user')['id'];
        if($this->session->userdata('user')['role'] == 1){
            $user_role = 'admin/';
            $bid_user_id = null;
        }
        if($bid_id == 0){
            $this->session->set_flashdata('error', 'Something went wrong. Bid was not found!');
            redirect(base_url() . $user_role . 'bids', 'refresh');
        }
        

        if($this->input->post()){
            $find_bid = $this->BidsModel->find_bid($bid_user_id, $bid_id);
            if(empty($find_bid)){
                $this->session->set_flashdata('error', 'Something went wrong. Bid was not found!');
                redirect(base_url() . $user_role . 'bids', 'refresh');
            }
            $post_data = $this->input->post();
            $post_data['modified'] = date('Y-m-d H:i:s');
            $post_data['modified_by'] = $this->session->userdata('user')['id'];
            $update = $this->BidsModel->update_bid($post_data, $bid_id);
            if($update){
                $this->session->set_flashdata('success', 'Bid was updated successfully!');

            }else{
                $this->session->set_flashdata('error', 'Something went wrong. Bid was not updated!');
            }
            redirect(base_url() . $user_role . 'bids', 'refresh');
        }
        $find_bid = $this->BidsModel->find_bid($bid_user_id, $bid_id);
        if(empty($find_bid)){
            $this->session->set_flashdata('error', 'Something went wrong. Bid was not found!');
            redirect(base_url() . $user_role . 'bids', 'refresh');
        }
        $data['title'] = SITE_NAME . ' | Edit Bid';
        $data['bid_details'] = $find_bid;
        $this->template->load('default_template', 'users/edit_bid', $data);
    }

    public function admin_reports()
    {
        $total_bids = 0;
        $total_leads = 0;
        $total_projects = 0;
        $data['tech_arr'] = array("All","PHP","React","Vue","React + Laravel","Laravel","CI","Angular","Node","MERN","MEAN","Laravel + Vue","Need to select","Fullstack","Angular + aravel","Angular + PHP","Wordpress","Front End","Shopify app","React + Node","PERN","React + PHP","QA + Testing","WebFlow","WebFlow + SEO");

        $data['title'] = SITE_NAME . ' | Report';
        if($this->session->userdata('user')['role'] == 1){
            $data['users'] = $this->UsersModel->find_user();
        }elseif($this->session->userdata('user')['role'] == 3){
            $data['users'] = $this->UsersModel->find_team_members($this->session->userdata('user')['id']);
        }
        $selected_user = 0;
        $selected_type_filter = '';
        $date_filter = '';
        $user_id = null;
        $selected_technology_filter = '';
        $selected_end_date = '';
        if($this->input->get('user_filter')){
            $selected_user = $this->input->get('user_filter');
        }
        if($this->input->get('type_filter')){
            $selected_type_filter = $this->input->get('type_filter');
        }
        if($this->input->get('date_filter')){
            $selected_date_filter = $this->input->get('date_filter');
        }
        if($this->input->get('technology_filter')){
            $selected_technology_filter = $this->input->get('technology_filter');
        }
        if($this->input->get('end_date_filter')){
            $selected_end_date = $this->input->get('end_date_filter');
        }

        if($this->input->get('user_filter') && $this->input->get('type_filter') && $this->input->get('date_filter') && $this->input->get('technology_filter') && $this->input->get('end_date_filter')){
            $data['find_bids'] = $this->BidsModel->search_filtered_bid($selected_user, $selected_date_filter, $selected_technology_filter, $selected_end_date);
        }elseif($this->input->get('user_filter') && $this->input->get('type_filter') && $this->input->get('date_filter') && $this->input->get('technology_filter')){
            $data['find_bids'] = $this->BidsModel->search_filtered_bid($selected_user, $selected_date_filter, $selected_technology_filter);
        }elseif($this->input->get('user_filter') && $this->input->get('type_filter') && $this->input->get('date_filter')){
            $data['find_bids'] = $this->BidsModel->search_filtered_bid($selected_user, $selected_date_filter);
        }elseif($this->input->get('user_filter') && $this->input->get('type_filter') && $this->input->get('date_filter')){
            $data['find_bids'] = $this->BidsModel->search_filtered_bid($selected_user, $selected_date_filter);
        }
        if(!$this->input->get('user_filter') || !$this->input->get('type_filter') || !$this->input->get('date_filter') || !$this->input->get('technology_filter') | !$this->input->get('end_date_filter')){
            $total_bids = $this->BidsModel->total_bids(1, $user_id);
            $total_leads = $this->BidsModel->total_bids(2, $user_id);
            $total_projects = $this->BidsModel->total_bids(3, $user_id);
        }
        $data['total_bids'] = $total_bids;
        $data['total_leads'] = $total_leads;
        $data['total_projects'] = $total_projects;
        $data['status_arr'] = array(
            1 => 'Inquiry',
            2 => 'Lead',
            3 => 'Project',
        );
        $this->template->load('default_template', 'users/admin_report', $data);
    }
}