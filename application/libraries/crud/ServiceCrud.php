<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'libraries/crud/AbstractCrud.php';

class ServiceCrud extends AbstractCrud {

    private $CI, $schema;

    public function __construct(InterfaceSchema $schema) {
        $this->schema = $schema;
        $this->CI = $this->schema->get_CI_instance();
        $this->CI->load->library('form_validation');
    }

    public function edit($id) {
        if (!$this->input->is_ajax_request() && !isset($_POST['submit'])) { //View
            $this->handle_edit($id);
        } else { //POST submitted
            $this->post_edit($id);
        }
    }

    protected function handle_edit($id){
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
    }

    protected function generate_form_validation($action) {
        //echo "<pre>"; print_r($this->columns); die;
        foreach ($this->columns as $index_field => $field) {
            $this->columns[$index_field]['validation'] = $this->set_form_validation($field, $action); //set form validation foreach field
            $this->form_validation->set_rules($field['db'], $field['label'], $this->columns[$index_field]['validation']);
        }
        //echo "<pre>"; print_r($this->columns); die;
    }

    protected function post_edit($id){
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

    public function add(){

    }

    public function delete($id){
        $_POST[$this->schema->get_primary_key_name()] = $id;
        
        $this->CI->form_validation->set_rules($this->schema->get_primary_key_name(), ucwords(preg_replace("/_/", " ", $this->schema->get_primary_key_name())), 'required|callback_primary_id_check['.$this->schema->get_primary_key_name().']');
        $valid = $this->CI->form_validation->run();
        
        unset($_POST[$this->schema->get_primary_key_name()]);
        
        if ($valid == FALSE) {
            return [ 'status' => 'error', 'msg' => validation_errors()];
        } else {
            $this->CI->db->delete($this->schema->get_table_name(), [
                $this->schema->get_primary_key_name() => $id
            ]);
            return ['status' => 'success', 'msg' => 'Successfully delete record', 'action' => 'show_delete_msg'];
        }
    }
}

/* End of file ServiceCrud.php */
/* Location: ./application/libraries/crud/ServiceCrud.php */