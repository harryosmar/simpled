<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ServiceDatatable {
    private $columnDefs, $visible_actions;
    private $dom = '<"top"pl>rt<"bottom"ip><"clear">';
    private $stateSave = FALSE;
    private $lengthMenu = array(array(5, 10, 25, 50, -1), array(5, 10, 25, 50, "All"));
    private $iDisplayLength = 10;
    private $oLanguage = [
        "lengthMenu" => "Display _MENU_ records per page",
        "zeroRecords" => "Nothing found - sorry",
        "info" => "Showing page _PAGE_ of _PAGES_",
        "infoEmpty" => "No records available",
        "infoFiltered" => "(filtered from _MAX_ total records)",
        "sProcessing" => "<img src='{$this->view->get("_assets")}img/loading-spinner-grey.gif'/><span>&nbsp;&nbsp;Loading...</span>"
    ];
    private $order = array([0, "desc"]);

    public function __construct($config = array(), CI_Controller $CI = NULL){
        if($CI === NULL){
            $this->CI = &get_instance();
        }else{
            $this->CI = $CI;
        }

        if (count($config) > 0){
            $this->initialize($config);
        }
    }

    public function initialize($config = array())
    {
        foreach ($config as $key => $val)
        {
            if (property_exists($this, $key))
            {
                $method = 'set_'.$key;

                if (method_exists($this, $method))
                {
                    $this->$method($val);
                }
                else
                {
                    $this->$key = $val;
                }
            }
        }

        return $this;
    }

    public function get_settings() {
        $this->view->set("datatable_setting", array(
            'columnDefs' => $this->columnDefs,
            'visible_actions' => $this->visible_actions,
            'dom' => $this->dom,
            'stateSave' => $this->stateSave,
            'lengthMenu' => $this->lengthMenu,
            'iDisplayLength' => $this->iDisplayLength,
            'oLanguage' => $this->oLanguage,
            "order" => $this->order
        ));
    }
}

/* End of file ServiceDatatable.php */
/* Location: ./application/libraries/crud/ServiceDatatable.php */