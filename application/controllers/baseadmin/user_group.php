<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/controllers/crud.php';

/**
 * @author Harry <if07087@gmail.com>
 * @since 10 Oct 2014 
 * @todo Menu management : User Group CRUD
 */
class User_group extends Crud {

    public function __construct() {
        parent::__construct();
    }

    public function init() {
        parent::init();
    }

}

/* End of file user_group.php */
/* Location: ./application/controllers/baseadmin/user_group.php */