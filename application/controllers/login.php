<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    protected $class_name, $class_url;

    public function __construct() {
        parent::__construct();
        //check login status
        $this->check_authenticate();
        
        //set global variable
        $this->class_name = strtolower(get_class($this));
        $this->class_url = base_url("{$this->class_name}") . '/';
        
    }
    
    public function index() {
        if($this->input->is_ajax_request()){
            header('Content-Type: application/json');
            $this->load->library('form_validation');
            $config = array(
                array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'xss_clean|trim|required|valid_email'
                ),
                array(
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'xss_clean|trim|required|callback_check_valid_user'
                )
            );
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                $form_error = array();
                foreach ($config as $index => $field) {
                    $form_error[$field['field']] = form_error($field['field'], '<span for=' . $field['field'] . ' class="help-block">', '</span>');
                }
                echo json_encode(array('status' => 'error', 'msg' => validation_errors('<p class="text-error">', '</p>'), 'form_error' => $form_error));
            } else {
                echo json_encode(array('status' => 'success', 'msg' => 'Successfully login', 'action' => 'reload'));
            }
        }else{
            $this->load->view("login_view", array('class_name' => $this->class_name, 'class_url' => $this->class_url));
        }
    }

    protected function check_authenticate(){
        if($this->session->userdata('user')){
            if($this->input->is_ajax_request()){
                header('Content-Type: application/json');
                die(json_encode(array(
                    'status'=>'error', 
                    'action' => 'reload', 
                    'msg' => 'Anda sudah login'
                ))); //reload current page
            }else{
                redirect($this->input->get('urlredirect') ? $this->input->get('urlredirect') : base_url('baseadmin'));
            }
        }
    }

    public function check_valid_user() {
        $this->load->helper('function');
        $this->load->model('User_model');
        $row = $this->User_model->check_valid_user($this->input->post('email'), $this->input->post('password'))->row();
        if (empty($row)) {
            $this->form_validation->set_message('check_valid_user', 'Invalid email or password');
            return FALSE;
        } else if ($row->user_active != 'YES') {
            $this->form_validation->set_message('check_valid_user', 'Your account is not active');
            return FALSE;
        } else {
            //$row->user_group_id = 2;
            $this->session->set_userdata('user', $row);
            return TRUE;
        }
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */