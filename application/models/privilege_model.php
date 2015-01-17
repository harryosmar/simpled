<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/models/core_model.php';

/**
 * @author Harry <if07087@gmail.com>
 * @copyright (c) 2014, Harry
 */
class Privilege_model extends Core_model {

    //Datatables Attribute
    public $primary_key = "privilege_id";
    public $_table = "privilege";
    public $_view = "privilege";
    
    /**
     * @param type $user_group_id
     * @return type
     * @todo Load privilege according to $user_group_id parameter
     */
    public function get_privilege_per_user_group_id($user_group_id) {
        $this->db->select("p.*, m.menu_name, m.menu_action, m.menu_segment");
        $this->db->from("{$this->_table} p");
        $this->db->join("menu m", "m.menu_id = p.menu_id");
        if ($user_group_id == '1') {
            $this->db->where(array('user_group_id' => $user_group_id));
        } else {
            $this->db->where(array('user_group_id' => $user_group_id, 'm.menu_segment <> ' => 'menu')); //only 'DEVELOPER' can setting 'menu' privilege
        }
        return $this->db->get();
    }

    /**
     * @param type $user_group_id
     * @return type
     * @todo Load privilege according to $user_group_id parameter
     */
    public function check_user_privilege($menu_segment, $action) {
        $user = $this->session->userdata('user');
        $this->db->select("p.*");
        $this->db->from("{$this->_table} p");
        $this->db->join("menu m", "m.menu_id = p.menu_id AND m.menu_segment = \"{$menu_segment}\"");
        $this->db->where(array('p.user_group_id' => $user->user_group_id));
        $privilege = $this->db->get()->row();
        if (!empty($privilege) && preg_match("/({$action},|{$action}$)/i", $privilege->privilege_action)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

/* End of file privilege_model.php */
/* Location: ./application/models/privilege_model.php */