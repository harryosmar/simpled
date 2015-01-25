<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/models/core_model.php';

class Menu_model extends Core_model {

    //Datatables Attribute
    public $primary_key = "menu_id";
    public $_table = "menu";
    public $_view = "menu";

    /**
     * @author Harry <if07087@gmail.com>
     * @since 10 Oct 2014 
     * @todo call recursive method to generate option, to avoid 'select $current_menu_id' placed in recursive function
     */
    public function generate_menu_option_dropdown($menu_parent_id = 0, $current_menu_id = '', $menu_name_prefiks = '') {
        //get $menu_parent_id for $current_menu_id
        $current_menu_parent_id = 0;
        if ($current_menu_id) {
            $this->db->select("menu_parent_id");
            $this->db->from($this->_table);
            $this->db->where(array('menu_id' => $current_menu_id));
            $current_menu_parent_id = $this->db->get()->row()->menu_parent_id;
        }
        return $this->generate_menu_option_dropdown_recursive($menu_parent_id, $current_menu_id, $menu_name_prefiks, $current_menu_parent_id);
    }

    /**
     * @author Harry <if07087@gmail.com>
     * @since 10 Oct 2014 
     * @todo option stuctured as tree menu
     */
    public function generate_menu_option_dropdown_recursive($menu_parent_id = 0, $current_menu_id = '', $menu_name_prefiks = '', $current_menu_parent_id = 0) {
        //declare variable
        $return = '';

        //get all menu result where menu_parent_id = 0
        $this->db->select("*");
        $this->db->from($this->_table);
        $this->db->where(array('menu_parent_id' => $menu_parent_id, 'menu_id <> ' => $current_menu_id));
        $result = $this->db->get()->result();

        //echo '<pre>'; print_r($result);
        foreach ($result as $row) {
            $this->db->select("COUNT(1) AS `count`");
            $this->db->from($this->_table);
            $this->db->where(array("menu_parent_id" => $row->menu_id, 'menu_id <> ' => $current_menu_id));
            $count = $this->db->get()->row()->count;
            $return .= sprintf('<option value="%d" %s>%s%s</option>', $row->menu_id, $current_menu_parent_id == $row->menu_id ? 'selected="TRUE"' : '', $menu_name_prefiks, $row->menu_name);
            if ($count > 0) { //have child menu
                $return .= $this->generate_menu_option_dropdown_recursive($row->menu_id, $current_menu_id, " ----- {$menu_name_prefiks}", $current_menu_parent_id);
            }
        }
        return $return;
    }

    /**
     * @author Harry <if07087@gmail.com>
     * @since 9 Oct 2014 
     * @todo generate sidebar menu for backend template
     */
    /*public function generate_sidebar_menu($menu_parent_id = 0) {
        //declare variable
        $return = $menu_parent_id == 0 ? '<li>' : '';

        //get all menu result where menu_parent_id = 0
        $this->db->select("m.*");
        $this->db->from("{$this->_table} m");
        $this->db->join('privilege p', "m.menu_id = p.menu_id AND p.user_group_id = {$this->session_user->user_group_id} AND p.privilege_action IS NOT NULL AND p.privilege_action <> ''");
        $this->db->where(array('m.menu_parent_id' => $menu_parent_id, "m.menu_active" => "YES"));
        $result = $this->db->get()->result();

        foreach ($result as $row) {
            $this->db->select("COUNT(1) AS `count`");
            $this->db->from("{$this->_table} m");
            $this->db->join('privilege p', "m.menu_id = p.menu_id AND p.user_group_id = {$this->session_user->user_group_id} AND p.privilege_action IS NOT NULL AND p.privilege_action <> ''");
            $this->db->where(array("m.menu_parent_id" => $row->menu_id, "m.menu_active" => "YES"));
            $count = $this->db->get()->row()->count;

            if ($row->menu_parent_id == 0) {
                $return .= sprintf('<a href="%s" class="sidebar-menu-link"><i class="fa fa-folder-open"></i> <span class="title">%s</span>%s</a>', preg_match("/^YES$/i", $row->menu_link) ? "{$this->view->get('template_url')}{$row->menu_segment}" : 'javascript:;', $row->menu_name, $count > 0 ? '<span class="arrow"></span>' : '');
            } else if ($count == 0) {//have no child menu
                $return .= sprintf('<li><a href="%s" class="sidebar-menu-link"><i class="fa fa-folder-open"></i> %s</a></li>', preg_match("/^YES$/i", $row->menu_link) ? "{$this->view->get('template_url')}{$row->menu_segment}" : 'javascript:,', $row->menu_name);
            }

            //recursive function call, if have child menu
            if ($count > 0) {
                if ($row->menu_parent_id == 0) { //to remove duplicate li for menu_parent_id = 0
                    $return .= sprintf('<ul class="sub-menu">' . $this->generate_sidebar_menu($row->menu_id) . '</ul>');
                } else { //menu which not menu_id <> 0, but have child
                    $return .= sprintf('<li><a href="%s" class="sidebar-menu-link"><i class="fa fa-folder-open"></i> %s<span class="arrow"></span></a>%s</li>', preg_match("/^YES$/i", $row->menu_link) ? "{$this->view->get('template_url')}{$row->menu_segment}" : 'javascript:;', $row->menu_name, '<ul class="sub-menu">' . $this->generate_sidebar_menu($row->menu_id) . '</ul>');
                }
            }
        }

        $return .= $menu_parent_id == 0 ? '</li>' : '';
        return $return;
    }*/


    public function generate_subnavbar_menu($menu_parent_id = 0) {
        //declare variable
        $return = '';

        //get all menu result where menu_parent_id = 0
        $this->db->select("m.*");
        $this->db->from("{$this->_table} m");
        $this->db->join('privilege p', "m.menu_id = p.menu_id AND p.user_group_id = {$this->session_user->user_group_id} AND p.privilege_action IS NOT NULL AND p.privilege_action <> ''");
        $this->db->where(array('m.menu_parent_id' => $menu_parent_id, "m.menu_active" => "YES"));
        $result = $this->db->get()->result();

        foreach ($result as $row) {
            //get count how many child for current menu
            $this->db->select("COUNT(1) AS `count`");
            $this->db->from("{$this->_table} m");
            $this->db->join('privilege p', "m.menu_id = p.menu_id AND p.user_group_id = {$this->session_user->user_group_id} AND p.privilege_action IS NOT NULL AND p.privilege_action <> ''");
            $this->db->where(array("m.menu_parent_id" => $row->menu_id, "m.menu_active" => "YES"));
            $count = $this->db->get()->row()->count;

            $link_url = preg_match("/^YES$/i", $row->menu_link) ? "{$this->view->get('template_url')}{$row->menu_segment}" : 'javascript:;';

            if($row->menu_parent_id == 0 && $count == 0){
                $return .= sprintf('<li class="parentmenu"><a data-menu-segment="%s" href="%s"><i class="icon-home"></i><span>%s</span></a></li>', $row->menu_segment, $link_url, $row->menu_name);
            }else if($row->menu_parent_id == 0 && $count > 0){
                $return .= sprintf('<li class="dropdown parentmenu"><a data-menu-segment="%s" href="%s" class="dropdown-toggle" data-toggle="dropdown"><i class="%s"></i><span>%s</span><b class="caret"></b></a><ul class="dropdown-menu">%s</ul></li>', $row->menu_segment, $link_url, $row->menu_icon, $row->menu_name, $this->generate_subnavbar_menu($row->menu_id));
            }else if($row->menu_parent_id != 0 && $count == 0){
                $return .= sprintf('<li><a data-menu-segment="%s" href="%s"><i class="%s"></i> %s</a></li>', $row->menu_segment, $link_url, $row->menu_icon, $row->menu_name);
            }else if($row->menu_parent_id != 0 && $count > 0){
                $return .= sprintf('<li class="dropdown-submenu"><a data-menu-segment="%s" tabindex="-1" href="%s">%s</a><ul class="dropdown-menu"><i class="%s"></i> %s</ul></li>', $row->menu_segment, $link_url, $row->menu_name, $row->menu_icon, $this->generate_subnavbar_menu($row->menu_id));
            }
        }

        //$return .= $menu_parent_id == 0 ? '</li>' : '';
        return $return;
    }

    /**
     * @author Harry <if07087@gmail.com>
     * @since 9 Oct 2014 
     * @todo generate breadcrumb data
     */
    public function get_breadcrumb_data($menu_segment = '') {
        $menu_segment = !$menu_segment ? $this->view->get('class_name') : $menu_segment;
        $this->db->select("*");
        $this->db->from("{$this->_table}");
        $this->db->where(array("menu_segment" => $menu_segment, "menu_active" => "YES"));
        return $this->db->get()->row();
    }

    /**
     * @author Harry <if07087@gmail.com>
     * @since 9 Oct 2014 
     * @todo generate parent of current breadcrumb
     */
    public function get_breadcrumb_parent($menu_segment = '') {
        $return = '';
        
        //get parent_menu_id
        $this->db->select("menu_parent_id");
        $this->db->from($this->_table);
        $this->db->where(array("menu_segment" => $menu_segment, "menu_active" => "YES"));
        $menu_parent_row = $this->db->get()->row();

        if (!empty($menu_parent_row) && $menu_parent_row->menu_parent_id != 0) {
            //get parent menu row
            $this->db->select("*");
            $this->db->from($this->_table);
            $this->db->where(array("menu_id" => $menu_parent_row->menu_parent_id));
            $row = $this->db->get()->row();

            //set link breadcrumb
            if(preg_match("/^YES$/i", $row->menu_link)){
                $return .= sprintf('<li><a href="%s">%s</a> <i class="fa fa-angle-right"></i> </li>', "{$this->view->get("template_url")}{$row->menu_segment}", ucwords(preg_replace("/_/", "", $row->menu_name)));
            }else{
                $menu_name = sprintf('<div class="dropdown">
                      <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        %s
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                        %s
                      </ul>
                    </div>', $row->menu_name, $this->get_child_dropdown_menu_item($row->menu_id));
                $return .= sprintf('<li>%s <i class="fa fa-angle-right"></i> </li>', $menu_name);
            }

            //call recursive
            if ($row->menu_parent_id != 0) {
                $return .= $this->get_breadcrumb_parent($row->menu_segment);
            }
        }

        return $return;
    }

    public function get_child_dropdown_menu_item($menu_parent_id){
        $this->db->select('*');
        $this->db->from('menu');
        $this->db->where(array('menu_parent_id' => $menu_parent_id));
        $result = $this->db->get()->result();
        $menu_items = '';
        foreach ($result as $row) {
            $menu_items .= sprintf('<li role="presentation"><a role="menuitem" tabindex="-1" href="%s">%s</a></li>', "{$this->view->get("template_url")}{$row->menu_segment}", $row->menu_name);
        }
        return $menu_items;
    }


}

/* End of file menu_model.php */
/* Location: ./application/models/menu_model.php */