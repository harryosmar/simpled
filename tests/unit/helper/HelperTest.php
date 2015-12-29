<?php
namespace unit\helper;

include_once 'unit' . DS . 'BaseTest.php';

class HelperTest extends \unit\BaseTest
{
    public function test_create_form_dropdown_options()
    {
    	$arr = [
    		['user_group_id' => '1', 'user_group_type' => 'DEVELOPER'],
    		['user_group_id' => '2', 'user_group_type' => 'SUPERADMIN'],
    		['user_group_id' => '3', 'user_group_type' => 'ADMIN']
    	];

    	$dropdown_options = create_form_dropdown_options($arr, 'user_group_id', 'user_group_type');
    	$this->assertEquals([0 => 'Please Select', 1 => 'DEVELOPER', 2 => 'SUPERADMIN', 3 => 'ADMIN'], $dropdown_options);
    }
}