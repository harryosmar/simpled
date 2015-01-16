<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/controllers/baseadmin.php';

/**
 *
 * @author Harry
 * @since Mei 30, 2014
 * @desc datatable
 * @versi-datatable 1.10.0
 * @how to use this class :
 * 1. Extends this class then override attibute '$primary_key' and '$columns', and set '$enable_datatable = TRUE'
 * 2. Load asset css and js datatables : $this->page_css[] = $this->view->get("_assets") . 'DataTables/1.10.0/css/jquery.dataTables.css'; $this->page_css[] = $this->view->get("_assets") . 'DataTables/1.10.0/css/fix.dataTables.css'; $this->page_css[] = $this->view->get("_assets_css_theme") . 'store/sales.css'; $this->page_js[] = $this->view->get("_assets") . 'DataTables/1.10.0/js/jquery.dataTables.js'; $this->page_js[] = $this->view->get("_assets_js") . 'datatable.init.js'; $this->page_js[] = $this->view->get("_assets") . 'DataTables/plug-ins/api/pipeline.js';;
 * 3. Load datatable table-view : $this->view->load("pages/datatable/table");
 */
class Datatable extends Baseadmin {

    protected $primary_key = "";
    protected $_table;
    protected $_view;
    protected $columns;
    protected $visible_actions = TRUE; //set to 'TRUE' to show actions field at then end of the columns foreach row, to customize call function 'datatable_customize_actions()'
    protected $enable_datatable = TRUE; //set this to 'TRUE' to enable datatable
    protected $model_name = "";

    public function __construct() {
        parent::__construct();
    }

    protected function init() {
        parent::init();
        $this->model_name = ucfirst($this->class_name)."_model"; //set model_name controller attribute
        $this->load->model($this->model_name); //load model controllers
        $this->_view = $this->{$this->model_name}->_view; //get 'view' name from controller model
        $this->_table = $this->{$this->model_name}->_table; //get 'table' name from controller model
        $this->primary_key = $this->{$this->model_name}->primary_key; //get 'primary key' from controller model

        $this->load->helper('text');

        $this->view->set("enable_datatable", $this->enable_datatable);

        if ($this->enable_datatable === TRUE) {
            $this->datatable_set_columns();  //Set Datatable column defenition
        }
    }

    protected function set_datatable_asset() {
        if ($this->enable_datatable === TRUE) {//load datatable js|css when only when is used
            $this->page_css[] = "{$this->_general_assets}plugins/DataTables/1.10.0/css/jquery.dataTables.css";
            $this->page_css[] = "{$this->_general_assets}plugins/DataTables/1.10.0/css/fix.dataTables.css";
            $this->page_js[] = "{$this->_general_assets}plugins/DataTables/1.10.0/js/jquery.dataTables.js";
            $this->page_js[] = "{$this->_general_assets}plugins/DataTables/custom/datatable.init.js";
            $this->page_js[] = "{$this->_general_assets}plugins/DataTables/plug-ins/api/pipeline.js";
            $this->page_js[] = "{$this->_assets_js}pages/{$this->class_name}_datatable.js"; //current page js
            //$this->page_js[] = "{$this->_general_assets}crud/js/crud.js";
        }
    }

    public function index() {
        $this->set_datatable_asset();
        parent::index();
    }

    /**
     * @author Harry
     * @since Mei 30, 2014
     * @desc calculate total rows of datatable
     */
    protected function datatable_total_rows() {
        return $this->db->query("SELECT COUNT(1) AS `count` FROM {$this->_table}")->row()->count;
    }

    /**
     * @author Harry
     * @since Mei 30, 2014
     * @desc custom query datatable
     * @override
     */
    protected function datatable_custom_query($where = "", $limit = 10, $offset = 0, $order = "") {
        $query = "SELECT * FROM {$this->_view} ";
        $query .= (!empty($where)) ? " WHERE {$where} " : ""; //Where
        $query .= (!empty($order)) ? " ORDER BY {$order} " : ""; //Order
        if ($limit >= 0) {
            $query .= ($limit == -1) ? "" : " LIMIT {$limit} OFFSET {$offset} "; //limit Offfset
        }
        return $this->db->query($query);
    }

    /**
     * @author Harry
     * @since Mei 30, 2014
     * @desc set datatable column defenition, send it to view, and render as json_encode, it will be used in js : $('#example').DataTable({  "columnDefs": columnDefs});
     */
    protected function datatable_set_columns() {
        $this->columns = array();
        //die($this->_view);
        //get fields meta data
        $fields = $this->db->field_data(!preg_match("/^(edit|add|remove)$/i", $this->uri->segment(3)) ? $this->_view : $this->_table);

        foreach ($fields as $index_field => $field) {
            /**
             * @singlecolumn_search_type : equal|like, if type in(datetime|enum|currency) automatically use equal
             * @orderable 'true|false', default : 'true'
             * @searchable 'true|false', default : 'true'
             * @type 'text|enum|currency|datetime', default : 'text'
             */
            if (preg_match("/^(enum)$/i", $field->type)) {
                $this->columns[$index_field]['type'] = "enum";
                $this->columns[$index_field]['enums'] = array_merge(array("Select..." => ""), $this->{$this->model_name}->get_enum_values($field->name));
            } else if (preg_match("/^(date)$/i", $field->type)) {
                $this->columns[$index_field]['type'] = "date";
            } else if (preg_match("/^(datetime|timestamp)$/i", $field->type)) {
                $this->columns[$index_field]['type'] = "datetime";
            } else {
                $this->columns[$index_field]['type'] = "text";
            }
            $this->columns[$index_field]['db'] = $field->name;
            $this->columns[$index_field]['label'] = ucwords(preg_replace("/_/", " ", $field->name));
            $this->columns[$index_field]['targets'] = $index_field;
            $this->columns[$index_field]['visible'] = true;
            $this->columns[$index_field]['searchable'] = true;
            $this->columns[$index_field]['orderable'] = true;
            $this->columns[$index_field]['singlecolumn_search_type'] = "like";
            $this->columns[$index_field]['field_data'] = (array) $field;
        }
        $this->datatable_customize_columns();
        $this->set_datatable_setting_parameter();
        //echo '<pre>'; print_r($this->columns); die;
    }

    /**
     * @author Harry
     * @since Jun 3, 2014
     * @desc override this function to customize datatable parameter : send to view 'datatable/table.php', then json_encode(set_datatable_setting_parameter) used for 'datatable object'
     * @override
     */
    protected function set_datatable_setting_parameter() {
        $this->view->set("datatable_setting", array(
            'columnDefs' => $this->columns,
            'visible_actions' => $this->visible_actions,
            'dom' => '<"top"pl>rt<"bottom"ip><"clear">',
            'stateSave' => FALSE,
            'lengthMenu' => array(array(5, 10, 25, 50, -1), array(5, 10, 25, 50, "All")),
            'iDisplayLength' => 10,
            'oLanguage' => array(
                "lengthMenu" => "Display _MENU_ records per page",
                "zeroRecords" => "Nothing found - sorry",
                "info" => "Showing page _PAGE_ of _PAGES_",
                "infoEmpty" => "No records available",
                "infoFiltered" => "(filtered from _MAX_ total records)",
                "sProcessing" => "<img src='{$this->view->get("_assets")}img/loading-spinner-grey.gif'/><span>&nbsp;&nbsp;Loading...</span>",
            ),
            "order" => array(
                array(0, "desc")
            )
        ));
    }

    /**
     * @author Harry
     * @since Mei 30, 2014
     * @desc override this function to customize column defenition before render in view and used in js : $('#example').DataTable({  "columnDefs": columnDefs});
     * @override
     */
    protected function datatable_customize_columns() {
        //$this->columns[0]["visible"] = false;
        return $this->columns;
    }

    /**
     * @author Harry
     * @since Jun 06, 2014
     * @desc override this function to customize column actions : 'view|edit|delete', this function will be automatically called in condition '$this->visible_actions === TRUE'
     * @param row
     * @override
     */
    protected function datatable_customize_actions($row) {
        return '<a href="#" data-primary-id="' . $row->{$this->primary_key} . '" class="btn btn-default prevent-default" style="padding: 5px 10px; font-size:11px;"><span class="glyphicon glyphicon-search"></span> View</a>';
    }

    /**
     * @author Harry
     * @since Mei 30, 2014
     * @desc override this function to customize each row in view datatable
     * @param row
     * @override
     */
    protected function datatable_record_formatter($row) {
        $counter = 0;
        foreach ($row as $field => $val) {
            $row->$field = $this->datatable_field_record_formatter($field, $val, $counter);
            $counter++;
        }
        return $row;
    }

    /**
     * @author Harry
     * @since Mei 30, 2014
     * @desc override this function to customize each field row in view datatable
     * @param field
     * @override
     */
    protected function datatable_field_record_formatter($field, $val, $column_index) {
        if (preg_match("/^date$/i", $this->columns[$column_index]['type'])) {
            return format_date($val);
        } else if (preg_match("/^datetime$/i", $this->columns[$column_index]['type'])) {
            return format_date($val, 'd M Y H:i:s');
        } else if (preg_match("/^currency$/i", $this->columns[$column_index]['type'])) {
            return format_number($val);
        } else {
            return $val;
        }
    }

    /**
     * @author Harry
     * @since Mei 30, 2014
     * @desc this function will be call from ajax : $('#example').DataTable({   url: class_url + "datatable_server_processing"});
     * @override
     */
    public function datatable_server_processing() {
        $columns = $this->input->get("columns");
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $limit = $this->input->get("length");
        $offset = $this->input->get("start");
        $draw = $this->input->get("draw");
        $recordsTotal = $this->datatable_total_rows();
        $data = array();

        //Generate global where query
        $global_where_query = "";
        if (!empty($search['value'])) { //not empty global "$search['value']"
            $counter = 0;
            foreach ($columns as $index => $val) { //$val = array("data" => "", "name" => "", "searchable" => "", "orderable" => "", "search" => array("value" => "", "regex" => ""))
                if ($val["searchable"] == true && ($this->visible_actions === FALSE || ($this->visible_actions === TRUE && $counter + 1 < count($columns)))) {  // check actions columns, to not be include in where condition
                    $global_where_query .= "{$this->columns[$index]['db']} LIKE \"%{$search['value']}%\" OR ";
                    $counter ++;
                }
            }
            $global_where_query = $counter != 0 ? substr($global_where_query, 0, -3) : $global_where_query; //remove 'OR ' from end of the line
            $global_where_query = !empty($global_where_query) ? "({$global_where_query})" : ""; //check empty to prevent 'where ()'
        }
        //Generate column where query
        $column_where_query = "";
        $counter = 0;
        foreach ($columns as $index => $val) { //$val = array("data" => "", "name" => "", "searchable" => "", "orderable" => "", "search" => array("value" => "", "regex" => ""))
            if ($val["searchable"] == true && !empty($val["search"]["value"]) && $this->columns[$index]['visible'] == true) {
                if (preg_match("/^(datetime|currency)$/i", $this->columns[$index]['type'])) { //if column type in ('datetime|currency') used 'equal|like'
                    $singlecolumn_search_value = explode(" ", $val["search"]["value"]);
                    $start = isset($singlecolumn_search_value[0]) ? "{$singlecolumn_search_value[0]} 00:00:00" : "";
                    $end = isset($singlecolumn_search_value[1]) ? "{$singlecolumn_search_value[1]} 23:59:59" : "";
                    $singlecolumn_comparison = "=";
                    $column_where_query .=!empty($singlecolumn_search_value[0]) ? "`{$this->columns[$index]['db']}` >= \"{$start}\"" : "";
                    $column_where_query .=!empty($singlecolumn_search_value[0]) ? " AND " : "";
                    $column_where_query .=!empty($singlecolumn_search_value[1]) ? "`{$this->columns[$index]['db']}` <= \"{$end}\"" : "";
                    $column_where_query .=!empty($singlecolumn_search_value[1]) ? " AND " : "";
                } else { //if column type not in ('datetime|currency')
                    if (preg_match("/^(enum)$/i", $this->columns[$index]['type']) || preg_match("/^equal$/i", $this->columns[$index]['singlecolumn_search_type'])) { //singlecolumn_search_type : 'equal|like' or if column type in ('enum')
                        $singlecolumn_search_value = "{$val["search"]["value"]}";
                        $singlecolumn_comparison = "=";
                    } else {
                        $singlecolumn_search_value = "%{$val["search"]["value"]}%";
                        $singlecolumn_comparison = "LIKE";
                    }
                    $column_where_query .= "`{$this->columns[$index]['db']}` {$singlecolumn_comparison} \"{$singlecolumn_search_value}\" AND "; //
                }
                $counter ++;
            }
        }
        $column_where_query = $counter != 0 ? substr($column_where_query, 0, -4) : $column_where_query; //remove 'AND ' from end of the line
        $column_where_query = !empty($column_where_query) ? "({$column_where_query})" : ""; //check empty to prevent 'where ()'
        $where_query = $global_where_query . (!empty($global_where_query) && !empty($column_where_query) ? " AND " : "") . $column_where_query; //join global filtering and single-column-filtering
        //Generate order query
        $order_query = "";
        $counter = 0;
        foreach ($order as $val) { //$val = array("column" => "", "dir" => "")
            if ($columns[$val["column"]]["orderable"] == true) {
                $order_query .= "{$this->columns[$val["column"]]['db']} {$val["dir"]}, ";
                $counter ++;
            }
            $order_query = $counter != 0 ? substr($order_query, 0, -2) : $order_query; //remove ', ' from end of the line
        }
        //Generate data
        $result = $this->datatable_custom_query($where_query, $limit, $offset, $order_query)->result();
        $datatable_query = $this->db->last_query();
        $recordsFiltered = count($this->datatable_custom_query($where_query, -1, 0)->result()); //count row 'with where' condition but 'without limit'

        $index_row = 0;
        foreach ($result as $row) {
            $param_row = clone $row; //use this variable to passing parameter to function
            $data[$index_row] = array();
            foreach ($this->datatable_record_formatter($param_row) as $field_name => $field_val) { //format row before used to fill data json,. using 'datatable_record_formatter()'
                $data[$index_row][] = $field_val;
            }
            if ($this->visible_actions === TRUE) { // call function 'datatable_customize_actions()' in condition '$this->visible_actions === TRUE' 
                $data[$index_row][] = $this->datatable_customize_actions($row);
            }
            $index_row++;
        }

        echo json_encode(array(
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
            'query' => $datatable_query //query to generate json data, comment this for production environment
        ));
    }

}

/* End of file datatable.php */
/* Location: ./application/core/controllers/datatable.php */
