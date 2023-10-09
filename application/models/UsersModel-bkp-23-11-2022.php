<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class UsersModel extends CI_Model{
    public function __construct() {
        parent::__construct();
    }

    public function find_user_by_email($email){
        $condition = array('email' => $email, 'is_active' => 1);
        $rst = $this->db->select('*');
        $this->db->where($condition);
        $this->db->from('users');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function find_user($user_id = null)
    {
        $this->db->select('*');
        $this->db->from('users');
        if(!empty($user_id)){
            $this->db->where('id', $user_id);
        }
        $this->db->where('is_active', 1);
        $this->db->where('role <>', 1);
        $query = $this->db->get();
        if(!empty($user_id)){
            return $query->row_array();
        }else{
            return $query->result_array();
        }
    }
    
    public function find_tls()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('is_active', 1);
        $this->db->where('role', 3);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function find_team_members($tl_id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('tl', $tl_id);
        $this->db->where('is_active', 1);
        $this->db->where('role <>', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_user($data){
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function update_user($user_data, $user_id){
        foreach($user_data as $user_key => $user_details){
            $this->db->set($user_key, $user_details);
        }
        $this->db->set('modified', date('Y-m-d H:i:s'));
        $this->db->where('id', $user_id);
        return $this->db->update('users');
    }
}