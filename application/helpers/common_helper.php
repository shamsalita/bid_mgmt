<?php

/**
 * Common Helper
 * Common functions used
 * @author SG
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


/**
 * Print array/string.
 * @param array $data - data which is going to be printed
 * @param boolean $is_die - if set to true then excecution will stop after print. 
 */
function p($data, $is_die = false) {

    if (is_array($data)) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    } else {
        echo $data;
    }

    if ($is_die)
        die;
}

/**
 * Print last executed query
 * @param boolean $bool - if set to true then excecution will stop after print
 */
function qry($bool = false) {
    $CI = & get_instance();
    echo $CI->db->last_query();
    if ($bool)
        die;
}

/**
 * Set up configuration array for pagination
 * @return array - Configuration array for pagination
 */
function front_pagination() {
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['first_link'] = 'First';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li style="display:none"></li><li class="active"><a data-type="checked" style="background-color:#62a0b4;color:#ffffff; pointer-events: none;">';
    $config['cur_tag_close'] = '</a></li><li style="display:none"></li>';
    $config['prev_link'] = '&laquo;';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = '&raquo;';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['last_link'] = 'Last';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    return $config;
}

/**
 * Common Send Email Function
 * @param string $to - To Email ID
 * @param string $template - Email Template file
 * @param Array $data - Data to be passed
 * @return boolean
 */
function send_mail($to = '', $data = []) {
    if (empty($to) || empty($data)) {
        return false;
    }
    $ci = &get_instance();
    $ci->load->library('email');

    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.gmail.com';
    $config['smtp_port'] = '465';
    $config['smtp_user'] = 'aaaalim92@gmail.com';
    $config['smtp_pass'] = 'nadipehathi';
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['mailtype'] = 'html';
    $config['validation'] = TRUE;

    $ci->email->initialize($config);

    $ci->email->to($to);
    $ci->email->from('noreply@imager.com', 'Imager');
    $ci->email->subject($data['subject']);
    $ci->email->message($data['message']);
    $ci->email->send();
}

/**
 * Common password string generator
 * @param int length
 * @return string
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}