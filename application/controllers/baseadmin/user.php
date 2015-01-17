<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/controllers/crud.php';

/**
 * @author Harry <if07087@gmail.com>
 * @since 12 Oct 2014 
 * @todo Menu management : User CRUD
 */
class User extends Crud {

    public function __construct() {
        parent::__construct();
    }

    protected function set_input_form($row, $field) {
        //echo "<pre>"; print_r($field); die;
        if (!$row) {
            $row = new stdClass();
            $row->user_group_id = isset($row->user_group_id) ? $row->user_group_id : 0;
            $row->user_email = isset($row->user_email) ? $row->user_email : $field['field_data']['default'];
            $row->user_password = isset($row->user_password) ? $row->user_password : $field['field_data']['default'];
        }

        if (preg_match("/^user_group_id$/", $field["db"])) {
            return form_dropdown($field['db'], create_form_dropdown_options($this->db->query("SELECT * FROM user_group")->result_array(), 'user_group_id', 'user_group_type'), $row->{$field['db']}, 'id="' . $field['db'] . '" class="form-control" placeholder="' . ucwords(preg_replace("/_/", " ", $field['db'])) . '"');
        } else if (preg_match("/^user_email$/", $field["db"])) {
            return form_input(array('name' => $field['db'], 'id' => $field['db'], 'value' => $row->user_email, 'type' => 'email', 'class' => 'form-control', 'placeholder' => ucwords(preg_replace("/_/", " ", $field['db']))));
        } else if (preg_match("/^user_password$/", $field["db"])) {
            return form_password(array('name' => $field['db'], 'id' => $field['db'], 'value' => $row->user_email, 'type' => 'password', 'class' => 'form-control', 'placeholder' => ucwords(preg_replace("/_/", " ", $field['db']))));
        } else {
            return parent::set_input_form($row, $field);
        }
    }

    protected function datatable_customize_columns() {
        $this->load->model("User_group_model");

        $this->columns[0]["visible"] = FALSE;
        $this->columns[1]["label"] = 'User Group';
        $this->columns[1]["type"] = 'enum';
        $this->columns[1]["enums"] = $this->User_group_model->get_enum_user_group();
        $this->columns[2]["label"] = 'Email';
        $this->columns[3]["visible"] = FALSE;
        $this->columns[4]["label"] = 'Fullname';
        $this->columns[5]["label"] = 'Activation Status';
        //echo "<pre>"; print_r($this->columns); die;
        return $this->columns;
    }

    protected function datatable_field_record_formatter($field, $val, $column_index) {
        $this->load->model("User_group_model");

        //echo "<pre>"; print_r($this->columns); die;
        if ($field == 'user_group_id') {
            return $this->User_group_model->get_row_by_primary_key($val)->row()->user_group_type;
        } else {
            return parent::datatable_field_record_formatter($field, $val, $column_index);
        }
    }

    public function add() {
        $this->set_crud_asset();
        $this->load->library('form_validation');
        if (!$this->input->is_ajax_request() && !isset($_POST['submit'])) { //Direct View
            $this->generate_form();

            //echo "<pre>"; print_r($this->columns); die;
            $this->view->set(array(
                'columns' => $this->columns,
                'primary_key' => $this->primary_key
            ));
            $this->view->content("pages/{$this->class_name}_add");
        } else if (($this->input->is_ajax_request() && !isset($_POST['submit']))) { //JSON View
            return FALSE;
        } else { //POST submitted
            $this->generate_form_validation('add');
            if ($this->form_validation->run() == TRUE) { //Validation Success
                //Unset POST 'primary key' & 'submit'
                //unset($_POST["{$this->primary_key}"]);
                unset($_POST["submit"]);
                unset($_POST['password_confirmation']);
                $_POST['user_password'] = encrypt_password($this->input->post("user_password"));

                //Update database
                $this->db->insert($this->_table, $_POST);
                $insert_id = $this->db->insert_id();

                //Return responce in json format
                echo json_encode(array(
                    'status' => 'success',
                    'msg' => '<span class="glyphicon glyphicon-ok-sign"></span>&nbsp;Successfully Submit Your Data',
                    'insert_id' => $insert_id
                ));
            } else { //Validation Error
                //Setting error validation foreach field
                $form_error = array();
                foreach ($this->form_validation_rules('add') as $field) {
                    $form_error[$field['field']] = form_error($field['field'], '<span class="help-inline error block text-danger">', '</span>');
                }
                //Return responce in json format
                echo json_encode(array(
                    'status' => 'error',
                    'msg' => validation_errors('<p class="text-left">', '</p>'),
                    'form_error' => $form_error
                ));
            }
        }
    }

    public function edit($primary_key = 0) {
        $this->set_crud_asset();
        $this->load->library('form_validation');
        if (!$this->input->is_ajax_request() && !isset($_POST['submit'])) { //Direct View
            $_POST["{$this->primary_key}"] = $primary_key; //set primary key value from method segment to POST data, so form_validation runs it process
            $this->form_validation->set_rules($this->primary_key, ucwords(preg_replace("/_/", " ", $this->primary_key)), 'required|callback_primary_id_check'); //Check if the primary key value is valid or not
            if ($this->form_validation->run() == FALSE) { //Primary Key Value is not valid
                $responce = array(
                    'status' => 'error',
                    'msg' => validation_errors('<p class="text-error">', '</p>'),
                    'data' => ''
                );
                $this->view->set(array('err_title' => 'Invalid Data', 'err_msg' => 'Page not found Invalid data'));
                $this->view->content("error");
            } else { //Primary Key Value is valid
                $this->db->select("*");
                $this->db->from($this->_table);
                $this->db->where(array($this->primary_key => $this->input->post($this->primary_key)));
                $row = $this->db->get()->row();

                $this->generate_form($row);

                //echo "<pre>"; print_r($this->columns); die;
                $this->view->set(array(
                    'row' => $row,
                    'columns' => $this->columns,
                    'primary_key' => $this->primary_key
                ));
                $this->view->content("pages/{$this->class_name}_edit");
            }
        } else if (($this->input->is_ajax_request() && !isset($_POST['submit']))) { //JSON View
            return FALSE;
        } else { //POST submitted
            $this->generate_form_validation('edit');
            if ($this->form_validation->run() == TRUE) { //Validation Success
                //Unset POST 'primary key' & 'submit'
                //unset($_POST["{$this->primary_key}"]);
                unset($_POST["submit"]);

                //Update database
                $this->db->update($this->_table, $_POST, array($this->primary_key => $this->input->post("{$this->primary_key}")));

                //Reset Session Data
                if ($this->session_user->user_id == $this->input->post('user_id')) {
                    $this->session_user->user_group_id = $this->input->post('user_group_id');
                    $this->session_user->user_email = $this->input->post('user_email');
                    $this->session_user->user_fullname = $this->input->post('user_fullname');
                    $this->session_user->user_active = $this->input->post('user_active');
                    $this->session->set_userdata('user', $this->session_user);
                }

                //Return responce in json format
                echo json_encode(array(
                    'status' => 'success',
                    'msg' => '<span class="glyphicon glyphicon-ok-sign"></span>&nbsp;Successfully Update Your Data'
                ));
            } else { //Validation Error
                //Setting error validation foreach field
                $form_error = array();
                foreach ($this->columns as $field) {
                    $form_error[$field['db']] = form_error($field['db'], '<span class="help-inline error block text-danger">', '</span>');
                }
                //Return responce in json format
                echo json_encode(array(
                    'status' => 'error',
                    'msg' => validation_errors('<p class="text-left">', '</p>'),
                    'form_error' => $form_error
                ));
            }
        }
    }

    public function reset_password() {
        $this->load->library('form_validation');
        $this->generate_form_validation('reset_password');
        if ($this->form_validation->run() == TRUE) { //Validation Success
            $new_password = encrypt_password($this->input->post("new_password"));

            //Update database
            $this->db->update($this->_table, array(
                'user_password' => $new_password
                    ), array($this->primary_key => $this->input->post("{$this->primary_key}")));

            //Reset Session Data
            if ($this->session_user->user_id == $this->input->post('user_id')) {
                $this->session_user->user_password = $new_password;
                $this->session->set_userdata('user', $this->session_user);
            }

            //Return responce in json format
            echo json_encode(array(
                'status' => 'success',
                'msg' => '<span class="glyphicon glyphicon-ok-sign"></span>&nbsp;Successfully Reset Your Password'
            ));
        } else { //Validation Error
            //Setting error validation foreach field
            $form_error = array();
            foreach ($this->form_validation_rules('reset_password') as $field) {
                $form_error[$field['field']] = form_error($field['field'], '<span class="help-inline error block text-danger">', '</span>');
            }
            //Return responce in json format
            echo json_encode(array(
                'status' => 'error',
                'msg' => validation_errors('<p class="text-left">', '</p>'),
                'form_error' => $form_error
            ));
        }
    }

    public function admin_password_check($admin_password) {
        if ($this->session_user->user_password == encrypt_password($admin_password)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('admin_password_check', 'Wrong %s');
            return FALSE;
        }
    }

    protected function generate_form_validation($action) {
        $this->form_validation->set_rules($this->form_validation_rules($action));
    }

    protected function form_validation_rules($action) {
        $config = array();

        if ($action == 'reset_password') {
            $config[] = array(
                'field' => 'user_id',
                'label' => 'User Id',
                'rules' => 'xss_clean|required|callback_primary_id_check[user_id]'
            );
            $config[] = array(
                'field' => 'admin_password',
                'label' => 'Your Admin Password',
                'rules' => 'xss_clean|required|callback_admin_password_check'
            );
            $config[] = array(
                'field' => 'new_password',
                'label' => 'New Password',
                'rules' => 'xss_clean|required|matches[new_password_confirmation]'
            );
            $config[] = array(
                'field' => 'new_password_confirmation',
                'label' => 'New Password Confirmation',
                'rules' => 'xss_clean|required'
            );
            return $config;
        }

        if ($action == 'edit') {
            $config[] = array(
                'field' => 'user_id',
                'label' => 'User Id',
                'rules' => 'xss_clean|required|callback_primary_id_check[user_id]'
            );
        }
        $config[] = array(
            'field' => 'user_group_id',
            'label' => 'User Group',
            'rules' => 'xss_clean|required|callback_check_user_group_id'
        );
       
        if ($action == 'add') {
            $config[] = array(
                'field' => 'user_password',
                'label' => 'Password',
                'rules' => 'xss_clean|required|matches[password_confirmation]'
            );
            $config[] = array(
                'field' => 'password_confirmation',
                'label' => 'Password Confirmation',
                'rules' => 'xss_clean|required'
            );
            $config[] = array(
                'field' => 'user_email',
                'label' => 'Email',
                'rules' => 'xss_clean|required|max_length[500]|valid_email|is_unique[user.user_email]'
            );
        }else{
            $config[] = array(
                'field' => 'user_email',
                'label' => 'Email',
                'rules' => 'xss_clean|required|max_length[500]|valid_email|callback_check_email_for_edit'
            );
        }

        $config[] = array(
            'field' => 'user_fullname',
            'label' => 'Fullname',
            'rules' => 'xss_clean|required|max_length[250]'
        );
        $config[] = array(
            'field' => 'user_active',
            'label' => 'Active',
            'rules' => 'xss_clean|required|callback_check_field_enums_values[user_active]'
        );

        return $config;
    }

    public function check_user_group_id($user_group_id) {
        if ($user_group_id == 0) {
            $this->form_validation->set_message('check_user_group_id', 'Please Select %s field');
            return FALSE;
        }

        $this->load->model('User_group_model');
        $user_group = $this->User_group_model->get_row_by_primary_key($user_group_id)->row();
        if (empty($user_group)) {
            $this->form_validation->set_message('check_user_group_id', 'The %s field is not valid');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_email_for_edit($user_email){
        $this->load->model('User_model');
        $user = $this->User_model->get_by_field(array(
            'user_email' => $user_email,
            'user_id <> ' => $this->input->post('user_id')
        ))->row();

        if (!empty($user)) {
            $this->form_validation->set_message('check_email_for_edit', 'The %s field is already used');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

/* End of file user.php */
/* Location: ./application/controllers/baseadmin/user.php */