<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require 'vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * @author : Harry Osmar Sitohang
 * @date : 16 Sept 2014
 * @desc : The Core  COntroller - extended by : frontend & backend
 */
class Core extends CI_Controller {

    protected $log;
    protected $class_name, $class_url;
    protected $_general_assets, $_general_assets_css, $_general_assets_js;
    protected $_assets, $_assets_css, $_assets_js;
    protected $page_css, $page_js;
    protected $template_path = '', $template_url;
    protected $privilege_status = TRUE;

    public function __construct() {
        parent::__construct();
        $this->logChannel();
        $this->init();
    }

    protected function logChannel(){
        // create a log channel
        $this->log = new Logger('my_log');
        $this->log->pushHandler(new StreamHandler(APPPATH.'logs/monolog.log', Logger::DEBUG)); //Logger::WARNING

        // add records to the log
        // $this->log->addWarning('Foo');
        // $this->log->addError('Bar');
    }

    protected function init() {
        //load libary 'template' and set template value
        $this->load->library('template');
        $this->template->set_template($this->template_path);
        $this->view->set('template_path', $this->template_path);
        $this->template_url = base_url("{$this->template_path}") . "/";
        $this->view->set('template_url', $this->template_url);

        //General Asset ./assets, ./assets/css, ./assets/js
        $this->_general_assets = $this->view->get('_general_assets');
        $this->_general_assets_css = $this->view->get('_general_assets_css');
        $this->_general_assets_js = $this->view->get('_general_assets_js');

        //Template Asset ./assets/TEMPLATENAME, ./assets/TEMPLATENAME/css, ./assets/TEMPLATENAME/js
        $this->_assets = $this->view->get('_assets');
        $this->_assets_css = $this->view->get('_assets_css');
        $this->_assets_js = $this->view->get('_assets_js');

        //set global variable
        $this->class_name = strtolower(get_class($this));
        $this->view->set('class_name', $this->class_name);
        $this->class_url = "{$this->template_url}{$this->class_name}/";
        $this->view->set('class_url', $this->class_url);
    }

    public function index() {
        if(!$this->privilege_status){
            return FALSE;
        }
        
        $this->set_assets();
        $this->view->content("pages/{$this->class_name}_view");
    }

     public function set_assets() {
        $this->view->set("page_css", $this->page_css);
        $this->view->set("page_js", $this->page_js);
    }

}

/* End of file core.php */
/* Location: ./application/core/controllers/core.php */