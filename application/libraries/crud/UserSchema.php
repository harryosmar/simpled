<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'libraries/crud/ServiceSchema.php';

class UserSchema extends ServiceSchema {

	protected $table_name = 'user';
	protected $primary_key_name = 'user_id';

}

/* End of file UserSchema.php */
/* Location: ./application/libraries/crud/UserSchema.php */