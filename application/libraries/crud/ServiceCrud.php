<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'libraries/crud/AbstractCrud.php';

class ServiceCrud extends AbstractCrud {

    private $CI, $model, $table, $primary_key;

    public function __construct(InterfaceCrudModel $model) {
        $this->CI = &get_instance();
        $this->model = $model;
        $this->CI->load->library('form_validation');
    }

    public function edit($id){

    }

    public function add(){

    }

    public function delete($id){
            $_POST[$this->model->get_primary_key()] = $id;
            
            $this->CI->form_validation->set_rules($this->model->get_primary_key(), ucwords(preg_replace("/_/", " ", $this->model->get_primary_key())), 'required|callback_primary_id_check['.$this->model->get_primary_key().']');
            $valid = $this->CI->form_validation->run();
            
            unset($_POST[$this->model->get_primary_key()]);
            
            if ($valid == FALSE) {
                return [ 'status' => 'error', 'msg' => validation_errors()];
            } else {
                $this->CI->db->delete($this->model->get_table_name(), [
                    $this->model->get_primary_key() => $id
                ]);
                return ['status' => 'success', 'msg' => 'Successfully delete record','action' => 'show_delete_msg'];
            }
    }

    public function __destruct() {
       unset($this->CI);
    }

}

/* End of file ServiceCrud.php */
/* Location: ./application/libraries/crud/ServiceCrud.php */