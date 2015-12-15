<?php
namespace unit\crud;

include_once APPPATH . 'libraries/crud/ServiceCrud.php';
include_once APPPATH . 'libraries/crud/UserCrudModel.php';

class ServiceTest extends \unit\BaseTest
{
    public function setUp() {
        $this->CI =  &get_instance();
    }

    public function test_delete(){
    	$ServiceCrud = new \ServiceCrud(new \UserCrudModel());
    	$ServiceCrud->delete(4);
    }

}