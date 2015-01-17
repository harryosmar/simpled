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

    public function index(){
    	//$this->page_css[] = $this->_assets_css."pages/jurnal_entry.css";
    	//$this->page_js[] = $this->_assets_js."pages/jurnal_entry.js";
    	parent::index();
    }

    public function edit($primary_key = 0){
        if($this->input->is_ajax_request()){
            header('Content-Type: application/json');
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
                    'action' => 'add',
                    'db' => array(
                        'head' => $this->Jurnal_entry_model->get_row_by_primary_key($primary_key)->row_array() ,
                        'detail' => $this->Jurnal_entry_model->get_jurnal_detail_by_primary_key($primary_key)->result_array()
                    )
            );

            $this->view->set(array(
                'json_data' => $json_data
            ));

            $this->view->content("pages/jurnal_entry_edit");
        }
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

     protected function datatable_customize_actions($row) {
        return $this->view->load_path_reset("plugins/crud/action", array('primary_key' => $this->primary_key, 'row' => $row), TRUE);
    }

}

/* End of file jurnal_entry.php */
/* Location: ./application/controllers/baseadmin/jurnal_entry.php */