<?php
namespace crud\schema;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once __DIR__ . DIRECTORY_SEPARATOR . 'ServiceSchema.php';

class UserSchema extends ServiceSchema {

	protected $table_name = 'user';
	protected $primary_key_name = 'user_id';

}

/* End of file UserSchema.php */
/* Location: ./application/libraries/crud/UserSchema.php */