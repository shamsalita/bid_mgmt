<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class BidsModel extends CI_Model{
    public function __construct() {
        parent::__construct();
    }

    public function find_bid($user_id = null, $bid_id = null, $from_date = null, $to_date = null){
        $rst = $this->db->select('b.*, u.first_name, u.last_name, c.country_name');
        if(!empty($user_id)){
            $this->db->where('u.id', $user_id);
        }
        if(!empty($bid_id)) {
            $this->db->where('b.id', $bid_id);
        }
        $this->db->where('b.status > ', 0);
        if(!empty($from_date) && !empty($to_date)) {
            $this->db->where('b.created >= ' , date('Y-m-d', strtotime($from_date)));
            $this->db->where('b.created <= ' , date('Y-m-d', strtotime($to_date)));
        }
        $this->db->from('bids b');
        $this->db->order_by('b.id', 'DESC');
        $this->db->join('users u', 'u.id = b.user_id');
        $this->db->join('countries c', 'c.id = b.country_id');
        $query = $this->db->get();

        if(empty($bid_id)) {
            return $query->result_array();
            // echo $this->db->last_query(); exit;
        } else {
            return $query->row_array();
        }
    }

    public function add_bid($data){
        $this->db->insert('bids', $data);
        return $this->db->insert_id();
    }

    public function update_bid($data, $id){
        foreach($data as $data_key => $data_val){
            $this->db->Set($data_key, $data_val);
        }
        $this->db->where('id', $id);
        return $this->db->update('bids');
    }

    public function search_filtered_bid($selected_user, $selected_date_filter, $selected_technology = null, $selected_end_date = null, $selected_status_filter = 0) {
        $this->db->select('b.*, u.first_name, u.last_name, c.country_name');
        if(!empty($selected_user)) {
            $this->db->where('u.id', $selected_user);
        }

        if(!empty($selected_end_date)){
            if(!empty($selected_date_filter)){
                if(empty($selected_status_filter)){
                    $this->db->where('(b.created >= "' .  $selected_date_filter . '" OR b.lead_date >= "' . $selected_date_filter . '" OR b.conversion_date >= "' . $selected_date_filter . '")');
                    // $this->db->where('b.created >= ' , $selected_date_filter);
                    // $this->db->or_where('b.lead_date >= ' , $selected_date_filter);
                    // $this->db->or_where('b.conversion_date >= ' , $selected_date_filter);
                }else{
                    if($selected_status_filter == 1){
                        $this->db->where('b.created >= "' . $selected_date_filter . '"');
                    }if($selected_status_filter == 2){
                        $this->db->where('(b.lead_date >= "' . $selected_date_filter . '" OR b.conversion_date >= "' . $selected_date_filter . '")');
                        // $this->db->or_where('b.conversion_date >= ' , $selected_date_filter);
                    }elseif($selected_status_filter == 3){
                        $this->db->where('b.conversion_date >= "' . $selected_date_filter . '"');
                    }
                }
                    
            }
            if($selected_status_filter == 1){
                $this->db->where('b.created <= "' . $selected_end_date . '"');
            }if($selected_status_filter == 2){
                $this->db->where('(b.lead_date <= "' . $selected_end_date . '" OR b.conversion_date <= "' . $selected_end_date . '")');
                // $this->db->or_where('b.conversion_date <= ' , $selected_end_date);
            }elseif($selected_status_filter == 3){
                $this->db->where('b.conversion_date <= "' . $selected_end_date . '"');
            }
        }else{
            if(!empty($selected_date_filter)) {
                if(empty($selected_status_filter)){
                    $this->db->where('(b.created LIKE "' . $selected_date_filter . '%" OR b.lead_date LIKE "' . $selected_date_filter . '%" OR b.conversion_date LIKE "'. $selected_date_filter . '%")');
                    // $this->db->or_where('b.lead_date LIKE "' . $selected_date_filter . '%"');
                    // $this->db->or_where('b.conversion_date LIKE "' . $selected_date_filter . '%"');
                }else{
                    if($selected_status_filter == 1){
                        $this->db->where('b.created LIKE "' . $selected_date_filter . '%"');
                    }if($selected_status_filter == 2){
                        $this->db->where('(b.lead_date LIKE "' . $selected_date_filter . '%" OR b.conversion_date LIKE "' . $selected_date_filter . '%")');
                        // $this->db->or_where('b.conversion_date LIKE "' . $selected_date_filter . '%"');
                    }elseif($selected_status_filter == 3){
                        $this->db->where('b.conversion_date LIKE "' . $selected_date_filter . '%"');
                    }
                }
                    
            }
        }
        

        if($selected_status_filter > 0){
            if($selected_status_filter == 2){
                $this->db->where_in('b.status', [2,3]);
            }elseif($selected_status_filter == 3){
                $this->db->where('b.status', 3);
            }
        }

        if(!empty($selected_technology)) {
            $this->db->where('b.technology', $selected_technology);
        }
        $this->db->where('b.status > ', 0);
        $this->db->from('bids b');
        $this->db->order_by('b.id', 'DESC');
        $this->db->join('users u', 'u.id = b.user_id');
        $this->db->join('countries c', 'c.id = b.country_id');
        $query = $this->db->get();
        return $query->result_array();
        // $query->result_array();
        // echo $this->db->last_query(); exit;
    }

    public function total_bids($type, $selected_user, $selected_date_filter, $selected_technology = null, $selected_end_date = null, $user_id = null, $selected_status_filter = 0){
        $this->db->select('count(b.id) as total_items');

        if(!empty($selected_user)) {
            $this->db->where('u.id', $selected_user);
        }
        if(!empty($user_id)) {
            $this->db->where('u.id', $user_id);
        }


        if(!empty($selected_end_date)){
            if(!empty($selected_date_filter)){
                if($type == 1){
                    $this->db->where('b.created >= "' . $selected_date_filter . '"');
                }if($type == 2){
                    $this->db->where('(b.lead_date >= "' . $selected_date_filter . '" OR b.conversion_date >= "' . $selected_date_filter . '")');
                    // $this->db->or_where('b.conversion_date >= ' , $selected_date_filter);
                }elseif($type == 3){
                    $this->db->where('b.conversion_date >= "' . $selected_date_filter . '"');
                }
            }
            if($type == 1){
                $this->db->where('b.created <= "' . $selected_end_date . '"');
            }if($type == 2){
                $this->db->where('(b.lead_date <= "' . $selected_end_date . '" OR b.conversion_date <= "' . $selected_end_date . '")');
                // $this->db->or_where('b.conversion_date <= ' , $selected_end_date);
            }elseif($type == 3){
                $this->db->where('b.conversion_date <= "' . $selected_end_date . '"');
            }
        }else{
            if(!empty($selected_date_filter)) {
                if(!empty($selected_date_filter)){
                    if($type == 1){
                        $this->db->where('b.created LIKE "' . $selected_date_filter . '%"');
                    }if($type == 2){
                        $this->db->where('(b.lead_date LIKE "' . $selected_date_filter . '%" OR b.conversion_date LIKE "' . $selected_date_filter . '%")');
                        // $this->db->or_where('b.conversion_date LIKE "' . $selected_date_filter . '%"');
                    }elseif($type == 3){
                        $this->db->where('(b.conversion_date LIKE "' . $selected_date_filter . '%")');
                    }
                }
            }
        }
        
        if($type > 0){
            if($type == 1){
                $this->db->where_in('b.status', [1,2,3]);
            }elseif($type == 2){
                $this->db->where_in('b.status', [2,3]);
            }elseif($type == 3){
                $this->db->where('b.status', 3);
            }
        }
        if(!empty($selected_technology)) {
            $this->db->where('b.technology', $selected_technology);
        }
        // $this->db->where('b.status', $type);
        $this->db->from('bids b');
        $this->db->order_by('b.id', 'DESC');
        $this->db->join('users u', 'u.id = b.user_id');
        $query = $this->db->get();
        return $query->row_array()['total_items'];
    }


    public function get_countries(){
        $this->db->select('id, country_name');
        $this->db->where('id <>', 247);
        $this->db->from('countries');
        $qry = $this->db->get();
        return $qry->result_array();
    }
}