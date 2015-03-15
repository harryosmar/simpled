<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/controllers/baseadmin.php';

/**
 * @author Harry <if07087@gmail.com>
 * @since 23 Oct 2014 
 * @todo setting privilege menu foreach user group
 */
class Privilege extends Baseadmin {

    public function __construct() {
        parent::__construct();
        $this->load->model("User_group_model");
        //echo preg_match("/(remove,|remove$)/i", ''); die;
    }

    public function index() {
        $this->page_js[] = "{$this->_assets_js}pages/privilege.js";
        $this->page_css[] = "{$this->_assets_css}pages/privilege.css";
        $this->view->set(array(
            'user_groups' => $this->User_group_model->get_result()->result()
        ));
        parent::index();
    }

    public function load_privilege() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_group_id', 'User Group', 'xss_clean|trim|required|callback_check_user_group_id');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 'error', 'msg' => validation_errors('<p class="text-danger">', '</p>')));
        } else {
            echo json_encode(array('status' => 'success', 'data' => $this->view->load("pages/privilege/privilege_per_user_group", array('result' => $this->Privilege_model->get_privilege_per_user_group_id($this->input->post('user_group_id'))->result()), TRUE)));
        }
    }

    public function set_privilege_per_user_group_per_menu() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_group_id', 'User Group', 'xss_clean|trim|required|callback_check_user_group_id');
        $this->form_validation->set_rules('menu_id', 'Menu', 'xss_clean|trim|required|callback_check_menu_id');
        $this->form_validation->set_rules('privilege_action', 'Privilege Action', 'xss_clean|trim');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 'error', 'msg' => validation_errors('<p class="text-danger">', '</p>')));
        } else {
            $this->db->update("privilege", array('privilege_action' => $this->input->post("privilege_action")), array("user_group_id" => $this->input->post("user_group_id"), "menu_id" => $this->input->post("menu_id")));
            $this->log->addInfo('set_privilege_per_user_group_per_menu ', array('session' => $this->session->userdata('user'), 'query' => $this->db->last_query())); //record query in log data
            echo json_encode(array("status" => "success", "msg" => "Successfully update your privilege"));
        }
    }

    public function set_privilege_per_user_group() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_group_id', 'User Group', 'xss_clean|trim|required|callback_check_user_group_id');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 'error', 'msg' => validation_errors('<p class="text-danger">', '</p>')));
        } else {
            $privilege = $this->input->post('privilege');
            foreach ($privilege as $menu_id => $privilege_action) {
                $this->db->update("privilege", array('privilege_action' => $privilege_action), array("user_group_id" => $this->input->post("user_group_id"), "menu_id" => $menu_id));
            }
            $this->log->addInfo('set_privilege_per_user_group ', array('session' => $this->session->userdata('user'), 'query' => $this->db->last_query())); //record query in log data
            echo json_encode(array("status" => "success", "msg" => "Successfully update your privilege"));
        }
    }

    public function check_user_group_id($user_group_id) {
        $row = $this->User_group_model->get_row_by_primary_key($user_group_id)->row();
        if (empty($row)) {
            $this->form_validation->set_message('check_user_group_id', 'The %s is not valid');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_menu_id($menu_id) {
        $row = $this->Menu_model->get_row_by_primary_key($menu_id)->row();
        if (empty($row)) {
            $this->form_validation->set_message('check_menu_id', 'The %s is not valid');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

/* End of file privilege.php */
/* Location: ./application/controllers/baseadmin/privilege.php */