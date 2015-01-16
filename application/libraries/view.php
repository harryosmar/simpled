<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class View {

    private $variables = array();
    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function __destruct() {
        unset($this->CI);
    }

    public function set($key, $val = '') {
        if (is_array($key)) { //multiple set varibles
            foreach ($key as $k => $v) {
                $this->variables[$k] = $v;
            }
        } else { //single set variable
            $this->variables[$key] = $val;
        }
    }

    public function get($key = '') {
        if (!empty($key) && array_key_exists($key, $this->variables)) { // if key not empty and variable keys exist in $variables attribute : return value of key-index
            $return = $this->variables[$key];
        } else if (!empty($key) && !array_key_exists($key, $this->variables)) { // if key empty bit variable keys doesnt exist in $variables attribute : return empty string
            $return = "";
        } else { // key empty and keys doesnt exist in $variables attribute : return $variables
            $return = $this->variables;
        }
        return $return;
    }

    public function load($view = '', $view_data = array(), $return = FALSE) {
        $view_data = (!is_array($view_data)) ? array($view_data) : $view_data;
        $arr = array_merge($this->get(), $view_data);
        if ($return === TRUE) {
            return $this->CI->load->view($this->get('_path') . $view, $arr, $return);
        } else {
            $this->CI->load->view($this->get('_path') . $view, $arr, $return);
        }
    }

    public function load_path_reset($view = '', $view_data = array(), $return = FALSE) {
        $view_data = (!is_array($view_data)) ? array($view_data) : $view_data;
        $arr = array_merge($this->get(), $view_data);
        if ($return === TRUE) {
            return $this->CI->load->view($view, $arr, $return);
        } else {
            $this->CI->load->view($view, $arr, $return);
        }
    }

    public function content($view) {
        $this->set('_pages', $view);
        $this->load("layout");
    }

}

/* End of file view.php */
/* Location: ./application/libraries/themes.php */