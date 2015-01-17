<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/models/core_model.php';

class User_group_model extends Core_model {

    //Datatables Attribute
    public $primary_key = "user_group_id";
    public $_table = "user_group";
    public $_view = "user_group";

    public function get_enum_user_group() {
        $this->db->select("*");
        $this->db->from($this->_table);
        $result = $this->db->get()->result();
        $return = array("Select..." => "");
        foreach ($result as $row) {
            $return[$row->user_group_type] = $row->user_group_id;
        }
        return $return;
    }

}

/* End of file user_group_model.php */
/* Location: ./application/models/user_group_model.php */