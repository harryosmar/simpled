<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/models/core_model.php';

class User_model extends Core_model {

    //Datatables Attribute
    public $primary_key = "user_id";
    public $_table = "user";
    public $_view = "user";

    /**
     * @todo Check is valid user is valid
     * @param varchar $email, varchar $password
     */
    public function check_valid_user($email, $password) {
        $this->db->select("u.*, g.user_group_type, g.user_group_desc");
        $this->db->from("user u");
        $this->db->join("user_group g", "g.user_group_id = u.user_group_id");
        $this->db->where(array("u.user_email" => $email, 'u.user_password' => encrypt_password($password)));
        return $this->db->get();
    }

    public function get_detailed_user($user_id) {
        $this->db->select("u.*, g.user_group_type, g.user_group_desc");
        $this->db->from("user u");
        $this->db->join("user_group g", "g.user_group_id = u.user_group_id");
        $this->db->where(array("u.user_id" => $user_id));
        return $this->db->get();
    }

}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */