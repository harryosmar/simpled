<?php
namespace unit\crud;

include_once APPPATH . 'libraries/crud/ServiceCrud.php';
include_once APPPATH . 'libraries/crud/schema/ServiceSchema.php';
include_once APPPATH . 'libraries/crud/schema/UserSchema.php';

use \crud\ServiceCrud;
use \crud\schema\UserSchema;
use \crud\schema\ServiceSchema;

class ServiceTest extends \unit\BaseTest
{
    public function test_delete(){
    	$ServiceCrud = new ServiceCrud(new UserSchema(), $this->CI);
    	$ServiceCrud->delete(15);
    }

    public function test_delete_using_service_crud_model_directly(){
    	$ServiceSchema = new ServiceSchema(['table_name' => 'user', 'primary_key_name' => 'user_id'], $this->CI);
    	$ServiceCrud = new ServiceCrud($ServiceSchema);
    	$ServiceCrud->delete(15);
    }
}