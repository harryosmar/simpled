<?php
namespace unit\crud;

include_once APPPATH . 'libraries/crud/ServiceCrud.php';
include_once APPPATH . 'libraries/crud/ServiceSchema.php';
include_once APPPATH . 'libraries/crud/UserSchema.php';

class ServiceTest extends \unit\BaseTest
{
    public function setUp() {
        $this->CI =  &get_instance();
    }

    public function test_delete(){
    	$ServiceCrud = new \ServiceCrud(new \UserSchema(), $this->CI);
    	$ServiceCrud->delete(15);
    }

    public function test_delete_using_service_crud_model_directly(){
    	$ServiceSchema = new \ServiceSchema(['table_name' => 'user', 'primary_key_name' => 'user_id'], $this->CI);
    	$ServiceCrud = new \ServiceCrud($ServiceSchema);
    	var_dump($ServiceSchema->get_fields());
    	$ServiceCrud->delete(15);
    }
}