<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'libraries/crud/AbstractCrudModel.php';

class UserCrudModel extends AbstractCrudModel {

	protected $table = 'user';
	protected $primary_key = 'user_id';

}

/* End of file UserCrudModel.php */
/* Location: ./application/libraries/crud/UserCrudModel.php */