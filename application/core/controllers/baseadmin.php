<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author : Harry Osmar Sitohang
 * @date : 11 Jan 2015
 * @desc : This File used as parents controller for base-admin template
 */


include_once APPPATH . 'core/controllers/core.php';

class Baseadmin extends Core {

    protected $template_path = 'baseadmin';
    protected $privilege_action;
    protected $session_user;

    public function __construct() {
        parent::__construct();
    }

    public function logout() {
        $this->session->unset_userdata(array('user' => '', 'subnavbar' => ''));
        redirect(sprintf("%s", base_url()));
    }

    protected function init(){
        parent::init();
        $this->check_authenticate();
        $this->load->model("Privilege_model");
        $this->load->model("Menu_model");
        $this->set_subnavbar();
        $this->set_breadcrumb();
        $this->check_privilege();
    }

    protected function set_subnavbar() {
        //die('<ul class="mainnav">'.$this->Menu_model->generate_subnavbar_menu().'</ul>');
        if (!$this->session->userdata('subnavbar')) { //set side bar menu html to session, to reduce database load
            $this->session->set_userdata('subnavbar', '<li class="parentmenu">
                        <a href="'.$this->template_url.'" data-menu-segment="index">
                            <i class="icon-home"></i>
                            <span>Home</span>
                        </a>                        
                    </li>'.$this->Menu_model->generate_subnavbar_menu());
        }
        //$this->view->set("sidebar_menu", $this->Menu_model->generate_sidebar_menu());
        $this->view->set("subnavbar", $this->session->userdata('subnavbar'));
    }

    protected function reset_subnavbar(){
        $this->session->set_userdata('subnavbar', '<li class="parentmenu">
                        <a href="'.$this->template_url.'" data-menu-segment="index">
                            <i class="icon-home"></i>
                            <span>Home</span>
                        </a>                        
                    </li>'.$this->Menu_model->generate_subnavbar_menu());
        $this->view->set("subnavbar", $this->session->userdata('subnavbar'));
    }

    protected function check_authenticate() {
        if (!$this->session->userdata('user')) {
            if ($this->input->is_ajax_request()) {//if ajax request => session not exist, reload current page
                echo json_encode(array('error', 'action' => 'reload'));
                die;
            } else {//if not ajax request => redirect page to login
                $urlredirect = empty($_SERVER['QUERY_STRING']) ? current_url() : sprintf("%s?%s", current_url(), $_SERVER['QUERY_STRING']);
                redirect(sprintf("%s?urlredirect=%s", base_url(), $urlredirect));
            }
        } else {
            $this->session_user = $this->session->userdata('user');
            $this->view->set('session_user', $this->session_user);
        }
    }

    protected function check_privilege() {
        //set variable $action & $menu_segment
        $action = $this->uri->segment(3) ? $this->uri->segment(3) : 'view'; //if action not exist set default to view
        $menu = $this->Menu_model->get_by_field('menu_segment', $this->class_name)->row();

        //set $this->privilege_action
        if (!empty($menu)) {
            $privilege = $this->Privilege_model->get_by_field(array('menu_id' => $menu->menu_id, 'user_group_id' => $this->session_user->user_group_id))->row();
            $this->privilege_action = $privilege->privilege_action;
            $this->view->set('privilege_action', $this->privilege_action); //'action list' for this current menu ex: view,edit,add,remove

            if (!preg_match("/({$action},|{$action}$)/i", $menu->menu_action)) {//for all action that's not defined in menu_action set $action to 'view'
                $action = 'view';
            }
        } else {
            $this->view->set('privilege_action', $this->privilege_action); //leave 'action list' blank
        }

        //check privilege access
        if (!empty($menu) && !$this->Privilege_model->check_user_privilege($this->class_name, $action)) { //FORBIDDEN ACCESS FOR THIS MENU + ACTION
            $this->privilege_status = FALSE;
            if ($this->input->is_ajax_request()) {//if ajax request => session not exist, reload current page
                echo json_encode(array('error', 'action' => 'forbidden_access'));
                die;
            } else {//if not ajax request, set view to error page
                $this->view->set(array('err_title' => 'Access forbidden', 'err_msg' => 'Sorry, but you have no access for this page.'));
                $this->view->content("error");
            }
        } else if (empty($menu)) { //MENU DOESNT EXIST IN DATABASE
            $this->view->set('privilege_action', $action);
        }
    }

    protected function set_breadcrumb() {
        $this->view->set("breadcrumb", $this->Menu_model->get_breadcrumb_data());
        $this->view->set('breadcrumb_parent', $this->Menu_model->get_breadcrumb_parent($this->uri->segment(2)));
    }
}

/* End of file baseadmin.php */
/* Location: ./application/core/controllers/baseadmin.php */