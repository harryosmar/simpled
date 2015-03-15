<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/controllers/datatable.php';

class Jurnal_entry extends  Datatable{
    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model("Coa_model");
        $this->load->model("Currency_model");
    }

    protected function init(){
        $this->load->model('User_model');
        parent::init();
    }

    protected function datatable_customize_columns() {
        $this->load->model("User_group_model");

        $this->columns[0]["visible"] = FALSE;
        $this->columns[4]["label"] = 'Input By';
        $this->columns[4]["type"] = 'enum';
        $this->columns[4]["enums"] = $this->User_model->get_options('user_fullname', 'user_id');
        //$this->columns[7]["visible"] = FALSE;
        //echo "<pre>"; print_r($this->columns); die;
        return $this->columns;
    }

    protected function datatable_field_record_formatter($field, $val, $column_index) {
        //echo "<pre>"; print_r($this->columns); die;
        if ($field == 'created_by') {
            return $this->db->query("SELECT user_fullname FROM user WHERE user_id = ?", array($val))->row()->user_fullname;
        } elseif($field == 'posted'){
            return sprintf('%s %s', $val == 'YES' ? '<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>' : '', $val);
        }else {
            return parent::datatable_field_record_formatter($field, $val, $column_index);
        }
    }

    protected function datatable_customize_actions($row) {
        return $this->view->load("pages/jurnal_entry/action", array('primary_key' => $this->primary_key, 'row' => $row), TRUE);
    }

    public function index(){
    	//$this->page_css[] = $this->_assets_css."pages/jurnal_entry.css";
    	//$this->page_js[] = $this->_assets_js."pages/jurnal_entry.js";
    	parent::index();
    }

    public function edit($primary_key = 0){
        $this->load->library('form_validation');
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
        }else{
            $this->page_css[] = $this->_assets_css."pages/jurnal_entry.css";
            $this->page_js[] = $this->_assets_js."pages/jurnal_entry.js";
            
            $this->set_assets();

            $jurnal_head = $this->Jurnal_entry_model->get_row_by_primary_key($primary_key)->row_array();
            $jurnal_detail = $this->Jurnal_entry_model->get_jurnal_detail_by_primary_key($primary_key)->result_array();
            $json_data = array(
                    'dropdown_coa' => form_dropdown('coa_id[]', create_form_dropdown_options($this->db->query("SELECT coa_id, CONCAT(coa_number, '-', description, '-', crdr) AS `coa_label` FROM coa")->result_array(), 'coa_id', 'coa_label'), 'coa_id', 'class="form-control"'),
                    'disabled_amount' => '<input type="text" class="form-control" name="amount[]" disabled="disabled" placeholder="Enter Amount" data-a-sign="" data-a-dec="." data-a-sep=",">',
                    'enabled_amount' => '<div class="input-group"><div class="input-group-addon">{0}</div><input type="text" class="form-control" name="amount[]" placeholder="Amount" data-currency-id="{1}" data-crdr="{2}" data-a-sign="" data-a-dec="." data-a-sep=","></div>',
                    'enabled_amount_with_value' => '<div class="input-group"><div class="input-group-addon">{0}</div><input type="text" class="form-control" name="amount[]" placeholder="Amount" data-currency-id="{1}" data-crdr="{2}" value="{3}" data-a-sign="" data-a-dec="." data-a-sep=","></div>',
                    'currencies' => $this->Currency_model->get_result_pk_as_index(),
                    'coas' => $this->Coa_model->get_result_pk_as_index(),
                    'action' => 'edit',
                    'dropdown_transaction_status' => form_dropdown('transaction_status', $this->Jurnal_entry_model->get_enum_values('transaction_status'), $jurnal_head['transaction_status'], 'id="transaction_status" class="form-control"'),
                    'db' => array(
                        'head' =>  $jurnal_head,
                        'detail' => $jurnal_detail
                    )
            );

            $this->view->set(array(
                'json_data' => $json_data
            ));

            $this->view->content("pages/jurnal_entry_edit");
        }
        unset($_POST["{$this->primary_key}"]);
    }

    public function add(){
        if($this->input->is_ajax_request()){
            header('Content-Type: application/json');
            $this->load->library('form_validation');
            $config = array(
                array(
                    'field' => 'transaction_date',
                    'label' => 'Jurnal Date',
                    'rules' => 'xss_clean|trim|required'
                ),
                array(
                    'field' => 'ref_number',
                    'label' => 'Ref Number',
                    'rules' => 'xss_clean|trim|required|is_unique[jurnal.ref_number]'
                ),
                array(
                    'field' => 'remarks',
                    'label' => 'Remarks',
                    'rules' => 'xss_clean|trim|required'
                ),
                array(
                    'field' => 'detail',
                    'label' => 'Remarks',
                    'rules' => 'xss_clean|required'
                )
            );
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => 'error', 'msg' => validation_errors()));
            }else{
                $this->db->trans_begin();
                $this->db->insert('jurnal', array(
                    'transaction_date' => $this->input->post('transaction_date'),
                    'ref_number' => $this->input->post('ref_number'),
                    'remarks' => $this->input->post('remarks'),
                    'created_by' => $this->session_user->user_id
                ));
                $transaction_id = $this->db->insert_id();

                foreach($this->input->post('detail') as $crdr=>$detail){
                    foreach($detail as $coa_id=>$coa){
                        $currency_rate = $coa['currency_rate'];
                        foreach($coa['amounts'] as $amount=>$count){
                            for($i=1; $i<=$count; $i++){
                                 $this->db->insert('jurnal_detail', array(
                                    'transaction_id' => $transaction_id,
                                    'coa_id' => $coa_id,
                                    'amount' => $amount,
                                    'crdr' => $crdr,
                                    'current_currency_rate' => $currency_rate
                                ));
                            }
                        }
                    }
                }

                if ($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    echo json_encode(array('status'=>'error', 'msg' => log_message()));
                }
                else{
                    $this->db->trans_commit();
                    $this->log->addInfo('add jurnal', array('session' => $this->session->userdata('user'), 'query' => $this->db->last_query())); //record query in log data
                    echo json_encode(array('status'=>'success', 'msg' => 'Successfully add new jurnal'));
                }
            }
        }else{
        	$this->page_css[] = $this->_assets_css."pages/jurnal_entry.css";
        	$this->page_js[] = $this->_assets_js."pages/jurnal_entry.js";
            
        	$this->set_assets();

        	$json_data = array(
        			'dropdown_coa' => form_dropdown('coa_id[]', create_form_dropdown_options($this->db->query("SELECT coa_id, CONCAT(coa_number, '-', description, '-', crdr) AS `coa_label` FROM coa")->result_array(), 'coa_id', 'coa_label'), 'coa_id', 'class="form-control"'),
        			'disabled_amount' => '<input type="text" class="form-control" name="amount[]" disabled="disabled" placeholder="Enter Amount" data-a-sign="" data-a-dec="." data-a-sep=",">',
        			'enabled_amount' => '<div class="input-group"><div class="input-group-addon">{0}</div><input type="text" class="form-control" name="amount[]" placeholder="Amount" data-currency-id="{1}" data-crdr="{2}" data-a-sign="" data-a-dec="." data-a-sep=","></div>',
        			'currencies' => $this->Currency_model->get_result_pk_as_index(),
        			'coas' => $this->Coa_model->get_result_pk_as_index(),
        			'action' => 'add'
        	);

        	//$row_detail = $this->view->load("pages/jurnal_entry/jurnal_entry_row_detail", array('json_data' => $json_data), true);
        	//$json_data['row_detail'] = $row_detail;

        	$this->view->set(array(
        		'json_data' => $json_data
        	));

        	$this->view->content("pages/jurnal_entry_add");
        }
    }

    public function save_header_jurnal(){
        header('Content-Type: application/json');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'transaction_id',
                'label' => 'Id',
                'rules' => 'xss_clean|trim|required|callback_primary_id_check[transaction_id]'
            ),
            array(
                'field' => 'transaction_date',
                'label' => 'Jurnal Date',
                'rules' => 'xss_clean|trim|required'
            ),
            array(
                'field' => 'ref_number',
                'label' => 'Ref Number',
                'rules' => 'xss_clean|trim|required|callback_ref_number_for_edit'
            ),
            array(
                'field' => 'remarks',
                'label' => 'Remarks',
                'rules' => 'xss_clean|trim|required'
            ),
            array(
                'field' => 'transaction_status',
                'label' => 'Status',
                'rules' => 'xss_clean|required|callback_check_field_enums_values[transaction_status]'
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 'error', 'msg' => validation_errors()));
        }else{
            $this->db->trans_begin();
            $this->db->update('jurnal', array(
                'transaction_date' => $this->input->post('transaction_date'),
                'ref_number' => $this->input->post('ref_number'),
                'remarks' => $this->input->post('remarks'),
                'transaction_status' => $this->input->post('transaction_status')
            ), array('transaction_id' => $this->input->post('transaction_id')));

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                echo json_encode(array('status'=>'error', 'msg' => log_message()));
            }
            else{
                $this->db->trans_commit();
                $this->log->addInfo('save header jurnal', array('session' => $this->session->userdata('user'), 'query' => $this->db->last_query())); //record query in log data
                echo json_encode(array('status'=>'success', 'msg' => 'Successfully update jurnal'));
            }
        }
    }

    public function ref_number_for_edit($ref_number){
        $this->load->model('Coa_model');
        $jurnal = $this->Jurnal_entry_model->get_by_field(array(
            'ref_number' => $ref_number,
            'transaction_id <> ' => $this->input->post('transaction_id')
        ))->row();

        if (!empty($jurnal)) {
            $this->form_validation->set_message('ref_number_for_edit', 'The %s field is already used');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function save_detail_jurnal(){
        header('Content-Type: application/json');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'transaction_id',
                'label' => 'Id',
                'rules' => 'xss_clean|trim|required|callback_primary_id_check[transaction_id]'
            ),
            array(
                'field' => 'detail',
                'label' => 'Remarks',
                'rules' => 'xss_clean|required'
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 'error', 'msg' => validation_errors()));
        }else{
            $this->db->trans_begin();
            $transaction_id = $this->input->post('transaction_id');

            $this->db->delete('jurnal_detail', array('transaction_id' => $transaction_id));

            foreach($this->input->post('detail') as $crdr=>$detail){
                foreach($detail as $coa_id=>$coa){
                    $currency_rate = $coa['currency_rate'];
                    foreach($coa['amounts'] as $amount=>$count){
                        for($i=1; $i<=$count; $i++){
                             $this->db->insert('jurnal_detail', array(
                                'transaction_id' => $transaction_id,
                                'coa_id' => $coa_id,
                                'amount' => $amount,
                                'crdr' => $crdr,
                                'current_currency_rate' => $currency_rate
                            ));
                        }
                    }
                }
            }

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                echo json_encode(array('status'=>'error', 'msg' => log_message()));
            }
            else{
                $this->db->trans_commit();
                $this->log->addInfo('save detail jurnal', array('session' => $this->session->userdata('user'), 'query' => $this->db->last_query())); //record query in log data
                echo json_encode(array('status'=>'success', 'msg' => 'Successfully update jurnal'));
            }
        }
    }

     public function delete($primary_key = 0) {
        if ($this->input->is_ajax_request()){
            header('Content-Type: application/json');
            $this->load->library('form_validation');
            $_POST[$this->primary_key] = $primary_key;
            $this->form_validation->set_rules($this->primary_key, ucwords(preg_replace("/_/", " ", $this->primary_key)), 'required|callback_primary_id_check['.$this->primary_key.']|callback_is_already_used');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array(
                    'status' => 'error',
                    'msg' => validation_errors(),
                    'action' => 'show_delete_msg'
                ));
            } else {
                $this->db->delete('jurnal', array(
                    'transaction_id' => $primary_key
                ));
                $this->log->addInfo('delete jurnal', array('session' => $this->session->userdata('user'), 'query' => $this->db->last_query())); //record query in log data
                echo json_encode(array(
                    'status' => 'success',
                    'msg' => 'Successfully delete record',
                    'action' => 'show_delete_msg'
                ));
            }
            unset($_POST[$this->primary_key]);
        }
    }

    public function view($primary_key = 0){
        $this->load->library('form_validation');
        $_POST["{$this->primary_key}"] = $primary_key; //set primary key value from method segment to POST data, so form_validation runs it process
        $this->form_validation->set_rules($this->primary_key, ucwords(preg_replace("/_/", " ", $this->primary_key)), 'required|callback_primary_id_check'); //Check if the primary key value is valid or not
        if ($this->form_validation->run() == FALSE) { //Primary Key Value is not valid
            $responce = array(
                'status' => 'error',
                'msg' => validation_errors('<p class="text-error">', '</p>')
            );
            $this->view->set(array('err_title' => 'Invalid Data', 'err_msg' => 'Page not found Invalid data'));
            $this->view->content("error");
        }else{
            $this->load->model('User_model');
            $this->page_css[] = $this->_assets_css."pages/jurnal_entry.css";
            $this->page_js[] = $this->_assets_js."pages/jurnal_entry.js";
            
            $this->set_assets();

            $jurnal_head = $this->Jurnal_entry_model->get_row_by_primary_key($primary_key)->row_array();
            $jurnal_head['input_by'] = $this->User_model->get_row_by_primary_key($jurnal_head['created_by'])->row()->user_fullname;
            $jurnal_detail = $this->Jurnal_entry_model->get_jurnal_detail_by_primary_key_complete($primary_key)->result_array();
            $json_data = array(
                    //'dropdown_coa' => form_dropdown('coa_id[]', create_form_dropdown_options($this->db->query("SELECT coa_id, CONCAT(coa_number, '-', description, '-', crdr) AS `coa_label` FROM coa")->result_array(), 'coa_id', 'coa_label'), 'coa_id', 'class="form-control"'),
                    //'disabled_amount' => '<input type="text" class="form-control" name="amount[]" disabled="disabled" placeholder="Enter Amount" data-a-sign="" data-a-dec="." data-a-sep=",">',
                    //'enabled_amount' => '<div class="input-group"><div class="input-group-addon">{0}</div><input type="text" class="form-control" name="amount[]" placeholder="Amount" data-currency-id="{1}" data-crdr="{2}" data-a-sign="" data-a-dec="." data-a-sep=","></div>',
                    //'enabled_amount_with_value' => '<div class="input-group"><div class="input-group-addon">{0}</div><input type="text" class="form-control" name="amount[]" placeholder="Amount" data-currency-id="{1}" data-crdr="{2}" value="{3}" data-a-sign="" data-a-dec="." data-a-sep=","></div>',
                    'currencies' => $this->Currency_model->get_result_pk_as_index(),
                    'coas' => $this->Coa_model->get_result_pk_as_index(),
                    'action' => 'view',
                    //'dropdown_transaction_status' => form_dropdown('transaction_status', $this->Jurnal_entry_model->get_enum_values('transaction_status'), $jurnal_head['transaction_status'], 'id="transaction_status" class="form-control"'),
                    'db' => array(
                        'head' =>  $jurnal_head,
                        'detail' => $jurnal_detail
                    )
            );

            $this->view->set(array(
                'json_data' => $json_data
            ));

            $this->view->content("pages/jurnal_entry_detail");
        }
        unset($_POST["{$this->primary_key}"]);
    }

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

    public function is_already_used($value){
        $this->db->select("posted");
        $this->db->from($this->_table);
        $this->db->where(array($this->primary_key => $this->input->post($this->primary_key)));
        if ($this->db->get()->row()->posted == 'YES') {
            $this->form_validation->set_message('is_already_used', 'The %s field is already posted');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

/* End of file jurnal_entry.php */
/* Location: ./application/controllers/baseadmin/jurnal_entry.php */