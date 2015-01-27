<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/controllers/datatable.php';

/**
 *
 * @author Harry
 * @since Jul 7, 2014
 * @desc 
 */
class Crud extends Datatable {

    protected $enable_crud = TRUE;

    public function __construct() {
        parent::__construct();
    }

    protected function init() {
        parent::init();
        $this->load->helper('form');
        $this->view->set("enable_crud", $this->enable_crud);
    }

    protected function set_crud_asset() {
        //set asset css & js
        if ($this->enable_crud === TRUE) {//load crud js|css when only when is used
            $this->page_css[] = "{$this->_general_assets}plugins/jquery-ui/addon/jquery-ui-timepicker-addon.css";
            $this->page_js[] = "{$this->_general_assets}plugins/jquery-ui/addon/jquery-ui-timepicker-addon.js";
            $this->page_css[] = "{$this->_general_assets}plugins/crud/css/crud.css";
            $this->page_css[] = "{$this->_general_assets}plugins/tinymce/tinymce.upload.css";
            $this->page_js[] = "{$this->_general_assets}plugins/tinymce/4.1.4/tinymce.min.js";
            $this->page_js[] = "{$this->_general_assets}plugins/tinymce/tinymce.init.js";
            $this->page_js[] = "{$this->_general_assets}plugins/tinymce/tinymce.upload.js";
            $this->page_js[] = "{$this->_general_assets}plugins/crud/js/crud.js";
            $this->page_js[] = "{$this->_assets_js}pages/{$this->class_name}_crud.js"; //current page js
            $this->view->set("page_css", $this->page_css);
            $this->view->set("page_js", $this->page_js);
        }
    }

    /**
     * @author Harry
     * @since Jun 06, 2014
     * @desc : EDIT, Form & Process POST
     * @param : POST variable
     */
    public function edit($primary_key = 0) {
        if(!$this->privilege_status){
            return FALSE;
        }

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

                echo json_encode($this->on_sucess('edit'));

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

    /**
     * @author Harry
     * @since Nov 06, 2014
     * @desc : ADD, Form & Process POST
     * @param : POST variable
     */
    public function add() {
        if(!$this->privilege_status){
            return FALSE;
        }
        
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

                //Update database
                $this->db->insert($this->_table, $_POST);
                $insert_id = $this->db->insert_id();

                $return = $this->on_sucess('add');
                $return['insert_id'] = $insert_id;
                echo json_encode($return);
              
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

    /**
     * @author Harry
     * @since Jun 06, 2014
     * @desc : REMOVE, Form & Process POST
     * @param : POST variable
     */
    public function delete($primary_key = 0) {
        if ($this->input->is_ajax_request()){
            header('Content-Type: application/json');
            $this->load->library('form_validation');
            $_POST[$this->primary_key] = $primary_key;
            $this->form_validation->set_rules($this->primary_key, ucwords(preg_replace("/_/", " ", $this->primary_key)), 'required|callback_primary_id_check['.$this->primary_key.']');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array(
                    'status' => 'error',
                    'msg' => validation_errors()
                ));
            } else {
                $this->db->delete($this->_table, array(
                    $this->primary_key => $primary_key
                ));

                echo json_encode($this->on_sucess('delete'));

               
            }
            unset($_POST[$this->primary_key]);
        }
    }

    protected function on_sucess($action){
        switch ($action) {
            case 'delete':
                return array(
                    'status' => 'success',
                    'msg' => 'Successfully delete record',
                    'action' => 'show_delete_msg'
                );
                break;
            case 'add':
                return array(
                    'status' => 'success',
                    'msg' => '<span class="glyphicon glyphicon-ok-sign"></span>&nbsp;Successfully Submit Your Data'
                );
                break;
             case 'edit':
                return array(
                    'status' => 'success',
                    'msg' => '<span class="glyphicon glyphicon-ok-sign"></span>&nbsp;Successfully Update Your Data'
                );
                break;
            default:
                return array(
                    'status' => 'error',
                    'msg' => 'Invalid Action'
                );
                break;
        }
    }

    /**
     * @author Harry
     * @since Jun 06, 2014
     * @desc customize column actions : 'view|edit|delete', suited to crud event
     */
    protected function datatable_customize_actions($row) {
        if ($this->enable_crud === TRUE) {
            //$modal_title = ucfirst($row->{$this->primary_key});
//            $view = sprintf('<a href="#" data-action="view" data-group="crud-action" data-primary-field="%s" data-primary-val="%s" data-modal-title="View Record : %s" class="prevent-default btn btn-default btn-action"><span class="glyphicon glyphicon-search"></span>&nbsp;View</a>', $this->primary_key, $row->{$this->primary_key}, $modal_title);
//            $edit = sprintf('<a href="#" data-action="edit" data-group="crud-action" data-primary-field="%s" data-primary-val="%s" data-modal-submit-text="Save changes" data-modal-title="Edit Record : %s"  class="prevent-default btn btn-default btn-action"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a>', $this->primary_key, $row->{$this->primary_key}, $modal_title);
//            $remove = sprintf('<a href="#" data-action="remove" data-group="crud-action" data-primary-field="%s" data-primary-val="%s" data-modal-submit-text="Remove" data-modal-title="Remove Record : %s" class="prevent-default btn btn-default btn-action"><span class="glyphicon glyphicon-remove"></span>&nbsp;Remove</a>', $this->primary_key, $row->{$this->primary_key}, $modal_title);
//            return "{$view}{$edit}{$remove}";
            return $this->view->load_path_reset("plugins/crud/action", array('primary_key' => $this->primary_key, 'row' => $row), TRUE);
        } else {
            parent::datatable_customize_actions($row);
        }
    }

    /**
     * @author Harry
     * @since Jun 06, 2014
     * @desc : generate form-input for each field in a row
     * @param : row
     */
    protected function generate_form($row = '') {
        //echo "<pre>"; print_r($this->columns); die;
        foreach ($this->columns as $index_field => $field) {
            $this->columns[$index_field]['form'] = $this->set_input_form($row, $field); //set input-form foreach field
        }
    }

    /**
     * @author Harry
     * @since Jun 06, 2014
     * @desc : set all input form, used in add & edit
     * @param : row
     */
    protected function set_input_form($row, $field) {
        $field_name = $field["db"];
        $field_val = $row && isset($row->{$field_name}) ? $row->{$field_name} : $field['field_data']['default'];
        $placeholder = $field["label"];

        if ($this->primary_key == $field_name) {
            return sprintf('<input type="hidden" name="%s" id="%s" value="%s" class="form-control">', $field_name, $field_name, $field_val);
        } else if (preg_match("/^enum$/i", $field['field_data']['type'])) {
            return form_dropdown($field_name, $this->{$this->model_name}->get_enum_values($field_name), $field_val, 'id="' . $field_name . '" class="form-control" placeholder="' . $placeholder . '"');
        } else if (preg_match("/^datetime$/i", $field['field_data']['type'])) {
            return sprintf('%s', form_input(array('name' => $field_name, 'id' => $field_name, 'value' => $field_val, 'class' => 'form-control datetimepicker')));
        } else if (preg_match("/^date$/i", $field['field_data']['type'])) {
            return sprintf('%s', form_input(array('name' => $field_name, 'id' => $field_name, 'value' => $field_val, 'class' => 'form-control datepicker'))); //sprintf('<div class="input-group datepicker-input-group">%s<span class="input-group-addon datatable-datepicker-open"><span class="glyphicon glyphicon-calendar"></span></span></div>', form_input(array('name' => $field_name, 'id' => $field_name, 'value' => $field_val, 'class' => 'form-control datepicker', 'disabled' => TRUE)));
        } else if (preg_match("/^text$/i", $field['field_data']['type'])) {
            return form_textarea(array('name' => $field_name, 'id' => $field_name, 'value' => $field_val, 'class' => 'form-control', 'placeholder' => $placeholder)); //tinymce for RTE
        } else {
            return form_input(array('name' => $field_name, 'id' => $field_name, 'value' => $field_val, 'class' => 'form-control', 'max_length' => $field['field_data']['max_length'], 'placeholder' => $placeholder));
        }
    }

    /**
     * @author Harry
     * @since Jun 06, 2014
     * @desc : generate validation rules for each field in a row
     * @param : row
     */
    protected function generate_form_validation($action) {
        //echo "<pre>"; print_r($this->columns); die;
        foreach ($this->columns as $index_field => $field) {
            $this->columns[$index_field]['validation'] = $this->set_form_validation($field, $action); //set form validation foreach field
            $this->form_validation->set_rules($field['db'], $field['label'], $this->columns[$index_field]['validation']);
        }
        //echo "<pre>"; print_r($this->columns); die;
    }

    /**
     * @author Harry
     * @since Jun 06, 2014
     * @desc : set form validation @field
     * @param : field
     */
    protected function set_form_validation($field, $action) {
        //set input form validation
        if ($this->primary_key == $field['db']) {
            return preg_match("/^add$/i", $action) ? "xss_clean" : "xss_clean|required|callback_primary_id_check[{$field["db"]}]";
        } else if (preg_match("/^enum$/i", $field["field_data"]["type"])) {
            return "xss_clean|required|callback_check_field_enums_values[{$field["db"]}]";
        } else if (preg_match("/int$/i", $field["field_data"]["type"])) {
            return "xss_clean|required|integer";
        } else if (preg_match("/^(double|float|decimal)$/i", $field["field_data"]["type"])) {
            return "xss_clean|required|callback_is_valid_decimal";
        } else if (preg_match("/^(varchar)$/i", $field["field_data"]["type"])) {
            return "xss_clean|required|max_length[{$field["field_data"]["max_length"]}]";
        } else {
            return "xss_clean|required";
        }
    }

    public function is_valid_decimal($str){
        if(preg_match('/^[\-+]?[0-9]+\.[0-9]+$/', $str) || preg_match('/^[\-+]?[0-9]+$/', $str)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    /**
     * @author Harry
     * @since Jun 06, 2014
     * @desc : callback check is valid primary id ?
     * @param : field
     */
    public function primary_id_check($value) {
        $this->db->select("COUNT(1) AS `count`");
        $this->db->from($this->_table);
        $this->db->where(array($this->primary_key => $value));
        $count = $this->db->get()->row()->count;
        if ($count == 0) {
            $this->form_validation->set_message('primary_id_check', 'The %s field is not valid');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * @author Harry
     * @since Jun 06, 2014
     * @desc : callback check enum value is valid or not?
     * @param : field
     */
    public function check_field_enums_values($value, $field) {
        $enums = $this->{$this->model_name}->get_enum_values($field);
        $match = implode('|', $enums);
        if (!preg_match("/^({$match})$/i", $value)) {
            $this->form_validation->set_message('check_field_enums_values', 'The %s field is not valid');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

/* End of file crud.php */
/* Location: ./application/core/controllers/crud.php */
