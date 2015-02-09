<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/controllers/datatable.php';

class Ledger extends  Datatable{

    protected $enable_datatable = FALSE;
    protected $enable_crud = FALSE;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
    }

    public function index() {
        $this->page_css[] = $this->_assets_css."pages/ledger.css";
        $this->page_js[] = $this->_assets_js."pages/ledger.js";

        $this->view->set(array(
            'dropdown_coa' => form_dropdown('coa_id', $this->create_form_dropdown_options($this->db->query("SELECT coa_id, CONCAT(coa_number, '-', description, '-', crdr) AS `coa_label` FROM coa")->result_array(), 'coa_id', 'coa_label'), 'coa_id', 'class="form-control col-md-4 col-sm-12"'),
        ));
        parent::index();
    }

    private function create_form_dropdown_options($arr = array(), $field_key = '', $field_val = '') {
        $options = array('0'=>'Please Select COA');
        foreach ($arr as $field) {
            $options[$field[$field_key]] = $field[$field_val];
        }
        return $options;
    }

    public function get_list_ledger(){
        header('Content-Type: application/json');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'coa_id',
                'label' => 'COA',
                'rules' => 'xss_clean|trim|required|callback_check_coa_id'
            ),
            array(
                'field' => 'from',
                'label' => 'Date From',
                'rules' => 'xss_clean'
            ),
            array(
                'field' => 'to',
                'label' => 'Date Range',
                'rules' => 'xss_clean|callback_check_date_range'
            ),
            // array(
            //     'field' => 'action',
            //     'label' => 'Action',
            //     'rules' => 'xss_clean|callback_check_posting_action'
            // )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 'error', 'msg' => validation_errors()));
        }else{
            $coa_id = $this->input->post('coa_id');
            $this->db->select('c.*, cu.currency_label ');
            $this->db->from('coa c');
            $this->db->join('currency cu', 'cu.currency_id = c.currency_id');
            if($coa_id != 0){
                $this->db->where('coa_id', $coa_id);
            }
            $coas = $this->db->get()->result();

            foreach($coas as $key=>$coa){
                $_POST['coa_id'] = $coa->coa_id;
                $ledgers = $this->Ledger_model->get_list_ledger($_POST)->result();
                if($this->input->post('from')){
                    $coa->balance = $this->db->query("SELECT fx_get_opening_balance(?, ?) AS `balance`", array($this->input->post('from'), $coa->coa_id))->row()->balance;
                }else{
                    $coa->balance = 0;
                }
                $coa->table = $this->view->load('pages/ledger/list_jurnal', array('ledgers' => $ledgers, 'coa' => $coa),  TRUE);
            }
            echo json_encode(array(
                'status' => 'success', 
                'data' => $coas,
                'query' => $this->db->last_query()
            ));
        }
    }


    public function check_coa_id($value){
        if($value == 0){
            return TRUE;
        }

        $this->db->select("COUNT(1) AS `count`");
        $this->db->from('coa');
        $this->db->where(array('coa_id' => $value));
        if($this->db->get()->row()->count == 0){
            $this->form_validation->set_message('check_coa_id', 'The %s field is not valid');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    // public function check_transaction_detail_id($value){
    //     $this->db->select("COUNT(1) AS `count`");
    //     $this->db->from('jurnal_detail');
    //     $this->db->where(array('transaction_detail_id' => $value));
    //     if($this->db->get()->row()->count == 0){
    //         $this->form_validation->set_message('check_transaction_detail_id', 'The %s field is not valid');
    //         return FALSE;
    //     }else{
    //         return TRUE;
    //     }
    // }

    public function check_date_range($value) {
        if($this->input->post('from') == '' && $this->input->post('to') == ''){
            $this->form_validation->set_message('check_date_range', 'Please select %s field');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    // public function check_posting_action($value) {
    //     if(!preg_match("/^(posting|unposting)$/i", $value)){
    //         $this->form_validation->set_message('check_posting_action', 'The %s field is not valid');
    //         return FALSE;
    //     }else{
    //         return TRUE;
    //     }
    // }


}

/* End of file ledger.php */
/* Location: ./application/controllers/baseadmin/ledger.php */