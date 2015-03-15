<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/controllers/datatable.php';

class Posting extends  Datatable{

    protected $enable_datatable = FALSE;
    protected $enable_crud = FALSE;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
    }

   	public function index() {
        $this->page_css[] = $this->_assets_css."pages/posting.css";
        $this->page_js[] = $this->_assets_js."pages/posting.js";

        $this->view->set(array(
            //'dropdown_coa' => form_dropdown('coa_id', $this->create_form_dropdown_options($this->db->query("SELECT coa_id, CONCAT(coa_number, '-', description, '-', crdr) AS `coa_label` FROM coa")->result_array(), 'coa_id', 'coa_label'), 'coa_id', 'class="form-control col-md-4 col-sm-12"'),
        ));
        parent::index();
    }

    // private function create_form_dropdown_options($arr = array(), $field_key = '', $field_val = '') {
    //     $options = array('0'=>'Please Select COA');
    //     foreach ($arr as $field) {
    //         $options[$field[$field_key]] = $field[$field_val];
    //     }
    //     return $options;
    // }

    public function get_list_jurnal(){
        header('Content-Type: application/json');
        $this->load->library('form_validation');
        $config = array(
            // array(
            //     'field' => 'coa_id',
            //     'label' => 'COA',
            //     'rules' => 'xss_clean|trim|required|callback_check_coa_id'
            // ),
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
            array(
                'field' => 'action',
                'label' => 'Action',
                'rules' => 'xss_clean|callback_check_posting_action'
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 'error', 'msg' => validation_errors()));
        }else{
            $jurnals = $this->Posting_model->get_list_jurnal($_POST)->result();
            echo json_encode(array(
                'status' => 'success', 
                'data' => $this->view->load('pages/posting/list_jurnal', array('jurnals' => $jurnals, 'action' => $this->input->post('action')),  TRUE),
                'query' => $this->db->last_query()
            ));
        }
    }

    public function posting_item_process(){
        header('Content-Type: application/json');
        $this->load->library('form_validation');
        $config = array(
            // array(
            //     'field' => 'transaction_detail_id',
            //     'label' => 'COA',
            //     'rules' => 'xss_clean|trim|required|callback_check_transaction_detail_id'
            // ),
            array(
                'field' => 'transaction_id',
                'label' => 'COA',
                'rules' => 'xss_clean|trim|required|callback_check_transaction_id'
            ),
            array(
                'field' => 'action',
                'label' => 'Action',
                'rules' => 'xss_clean|callback_check_posting_action'
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 'error', 'msg' => validation_errors()));
        }else{
            $this->db->update('jurnal', array(
                'posted' =>  $this->input->post('action') == 'posting' ? 'YES' : 'NO'
            ), array('transaction_id' => $this->input->post('transaction_id')));
            $this->log->addInfo('posting single item', array('session' => $this->session->userdata('user'), 'query' => $this->db->last_query())); //record query in log data
            
            echo json_encode(array(
                'status' => 'success',
                'msg'   => 'Successfully '.($this->input->post('action') == 'posting' ? 'Posted' : 'Unposted')
            ));
        }
    }

    public function posting_selected_item_process(){
        header('Content-Type: application/json');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'transactions_id',
                'label' => 'Transaction',
                'rules' => 'xss_clean|required|callback_check_transactions_id'
            ),
            array(
                'field' => 'action',
                'label' => 'Action',
                'rules' => 'xss_clean|callback_check_posting_action'
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_error_delimiters('', '');
            echo json_encode(array('status' => 'error', 'msg' => validation_errors()));
        }else{
            $this->db->where_in('transaction_id', $this->input->post('transactions_id'));
            $this->db->update('jurnal', array(
                'posted' =>  $this->input->post('action') == 'posting' ? 'YES' : 'NO'
            )); 
            $this->log->addInfo('posting multiple item', array('session' => $this->session->userdata('user'), 'query' => $this->db->last_query())); //record query in log data
            echo json_encode(array(
                'status' => 'success',
                'msg'   => 'Successfully '.($this->input->post('action') == 'posting' ? 'Posted' : 'Unposted')
            ));
        }
    }

    // public function check_coa_id($value){
    //     if($value == 0){
    //         return TRUE;
    //     }

    //     $this->db->select("COUNT(1) AS `count`");
    //     $this->db->from('coa');
    //     $this->db->where(array('coa_id' => $value));
    //     if($this->db->get()->row()->count == 0){
    //         $this->form_validation->set_message('check_coa_id', 'The %s field is not valid');
    //         return FALSE;
    //     }else{
    //         return TRUE;
    //     }
    // }

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

    public function check_transactions_id($value){
        foreach($value as $transaction_id){
            $this->db->select("COUNT(1) AS `count`");
            $this->db->from('jurnal');
            $this->db->where(array('transaction_id' => $transaction_id));
            if($this->db->get()->row()->count == 0){
                $this->form_validation->set_message('check_transactions_id', $transaction_id);
                return FALSE;
            }
        }   
        return TRUE;
    }

    public function check_transaction_id($value){
        $this->db->select("COUNT(1) AS `count`");
        $this->db->from('jurnal');
        $this->db->where(array('transaction_id' => $value));
        if($this->db->get()->row()->count == 0){
            $this->form_validation->set_message('check_transaction_id', 'The %s field is not valid');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function check_date_range($value) {
        if($this->input->post('from') == '' && $this->input->post('to') == ''){
            $this->form_validation->set_message('check_date_range', 'Please select %s field');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function check_posting_action($value) {
        if(!preg_match("/^(posting|unposting)$/i", $value)){
            $this->form_validation->set_message('check_posting_action', 'The %s field is not valid');
            return FALSE;
        }else{
            return TRUE;
        }
    }


}

/* End of file posting.php */
/* Location: ./application/controllers/baseadmin/posting.php */