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

        $data['tech_arr'] = array("All Tech", "PHP", "React", "Vue", "React + Laravel", "Laravel", "CI", "Angular", "Node", "MERN", "MEAN", "Laravel + Vue", "Fullstack", "Angular + Laravel", "Angular + PHP", "Wordpress", "Front End", "React + SEO", "Webflow", "QA", "Shopify app", "Next.js", "Nuxt.js", ".NET MVC", ".NET Core", ".NET", ".NET + React", ".NET + Angular");

        $status_arr = array(
            1 => 'Bid',
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
            $from_date = date('Y-m-d', strtotime($from_date));
            if($this->input->get('to_date') && $this->input->get('to_date') != ''){
                $to_date = $this->input->get('to_date');
                $to_date = date('Y-m-d', strtotime($to_date));
            }else{
                $to_date = date('Y-m-d');
            }
        }
        $data['bids'] = $this->BidsModel->find_bid($user_id, $bid_id, $from_date, $to_date);
        $data['user_role'] = 'admin/';
        $data['status_arr'] = $status_arr;

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // exit;

        $this->template->load('default_template', 'users/bids', $data);
    }
    
    public function user_index()
    {
        if($this->session->userdata('user')['role'] == 1){
            redirect(base_url() . 'admin/bids', 'refresh');
        }

        $data['tech_arr'] = array("All Tech", "PHP", "React", "Vue", "React + Laravel", "Laravel", "CI", "Angular", "Node", "MERN", "MEAN", "Laravel + Vue", "Fullstack", "Angular + Laravel", "Angular + PHP", "Wordpress", "Front End", "React + SEO", "Webflow", "QA", "Shopify app", "Next.js", "Nuxt.js", ".NET MVC", ".NET Core", ".NET", ".NET + React", ".NET + Angular");

        $status_arr = array(
            1 => 'Bid',
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

        $data['countries'] = $this->BidsModel->get_countries();
        
        if($this->input->post()){
            $post_data = $this->input->post();
            $store_post = array();
            $store_post['user_id'] = $this->session->userdata('user')['id'];
            $store_post['title'] = $post_data['title'];
            $store_post['description'] = $post_data['description'];
            $store_post['client_name'] = $post_data['client_name'];
            $store_post['url'] = $post_data['url'];
            $store_post['country_id'] = $post_data['country_id'];
            $store_post['job_type'] = $post_data['job_type'];
            $store_post['rate'] = $post_data['rate'];
            $store_post['technology'] = $post_data['technology'];
            $store_post['created'] = date('Y-m-d');
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
                $find_bid = $this->BidsModel->find_bid(null, $bid_id);
            }else{
                $find_bid = $this->BidsModel->find_bid($user_id, $bid_id);
            }
            
            if(empty($find_bid)){
                echo 'fail';
                exit;
            }
            $update_data['status'] = $status;
            if($status == 0){
                $update_data['modified_by'] = $this->session->userdata('user')['id'];
            }else{
                if($status == 1){
                    $update_data['lead_date'] = null;
                    $update_data['conversion_date'] = null;
                }elseif($status == 2){
                    $update_data['lead_date'] = date('Y-m-d');
                    $update_data['conversion_date'] = null;
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

        $data['countries'] = $this->BidsModel->get_countries();
        

        if($this->input->post()){
            if($this->session->userdata('user')['role'] > 1){
                $user_id = $this->session->userdata('user')['id'];
                $find_bid = $this->BidsModel->find_bid(null, $bid_id);
            }else{
                $find_bid = $this->BidsModel->find_bid($bid_user_id, $bid_id);
            }
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
        if($this->session->userdata('user')['role'] > 1){
            $user_id = $this->session->userdata('user')['id'];
            $find_bid = $this->BidsModel->find_bid(null, $bid_id);
        }else{
            $find_bid = $this->BidsModel->find_bid($bid_user_id, $bid_id);
        }
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
        $data['tech_arr'] = array("All Tech", "PHP", "React", "Vue", "React + Laravel", "Laravel", "CI", "Angular", "Node", "MERN", "MEAN", "Laravel + Vue", "Fullstack", "Angular + Laravel", "Angular + PHP", "Wordpress", "Front End", "React + SEO", "Webflow", "QA", "Shopify app", "Next.js", "Nuxt.js", ".NET MVC", ".NET Core", ".NET", ".NET + React", ".NET + Angular");

        $data['title'] = SITE_NAME . ' | Report';
        
        if($this->session->userdata('user')['role'] == 1){
            $data['users'] = $this->UsersModel->find_user();
        }elseif($this->session->userdata('user')['role'] == 3){
            $data['users'] = $this->UsersModel->find_team_members($this->session->userdata('user')['id']);
        }

        $user_id = $selected_date_filter = $selected_end_date = null;
        $selected_technology_filter = ($this->input->get('technology_filter')) ? ($this->input->get('technology_filter')): null;
        $selected_user = ($this->input->get('user_filter')) ? $this->input->get('user_filter') : null;
        $selected_type_filter = ($this->input->get('type_filter')) ? $this->input->get('type_filter') : null;
        $selected_status_filter = ($this->input->get('status_filter')) ? $this->input->get('status_filter') : null;

        if(!is_null($selected_type_filter)) {
            switch ($selected_type_filter) {
                case 'day':
                    $selected_date_filter = ($this->input->get('date_filter')) ? $this->input->get('date_filter') : date('Y-m-d');
                    $selected_date_filter = date('Y-m-d', strtotime($selected_date_filter));
                    break;
                case 'month':
                    $selected_date_filter = ($this->input->get('date_filter')) ? $this->input->get('date_filter') : date('Y-m');
                    $selected_date_filter = date('Y-m', strtotime('01-' . $selected_date_filter));
                    break;
                case 'year':
                    $selected_date_filter = ($this->input->get('date_filter')) ? $this->input->get('date_filter') : date('Y');
                    $selected_date_filter = date('Y', strtotime($selected_date_filter));
                    break;
                case 'custom':
                    $selected_date_filter = ($this->input->get('date_filter')) ? $this->input->get('date_filter') : date('Y-m-d');
                    $selected_date_filter = date('Y-m-d', strtotime($selected_date_filter));
                    $selected_end_date = ($this->input->get('end_date_filter')) ? $this->input->get('end_date_filter') : date('Y-m-d');
                    $selected_end_date = date('Y-m-d', strtotime($selected_end_date));
                    break;
                default:
                    $selected_end_date = null;
                    break;
            }
        }

        $data['find_bids'] = $this->BidsModel->search_filtered_bid($selected_user, $selected_date_filter, $selected_technology_filter, $selected_end_date, $selected_status_filter);

        if(!$this->input->get('user_filter') || !$this->input->get('type_filter') || !$this->input->get('date_filter') || !$this->input->get('technology_filter') | !$this->input->get('end_date_filter')){
            $total_bids = $this->BidsModel->total_bids(1, $selected_user, $selected_date_filter, $selected_technology_filter, $selected_end_date, $user_id, $selected_status_filter);
            $total_leads = $this->BidsModel->total_bids(2, $selected_user, $selected_date_filter, $selected_technology_filter, $selected_end_date, $user_id, $selected_status_filter);
            $total_projects = $this->BidsModel->total_bids(3, $selected_user, $selected_date_filter, $selected_technology_filter, $selected_end_date, $user_id, $selected_status_filter);
        }
        $data['total_bids'] = $total_bids;
        $data['total_leads'] = $total_leads;
        $data['total_projects'] = $total_projects;
        $data['status_arr'] = array(
            1 => 'Bid',
            2 => 'Lead',
            3 => 'Project',
        );
        $this->template->load('default_template', 'users/admin_report', $data);
    }
}