<?php
namespace unit\crud\field;

include_once 'unit' . DS . 'BaseTest.php';
include_once APPPATH . 'libraries' . DS . 'crud' . DS . 'field' . DS . 'ServiceField.php';

use \crud\field\ServiceField;
use \Mockery;
use \CI_Controller;
use \CI_DB_driver;
use \CI_DB_mysql_result;

class FIeldServiceTest extends \unit\BaseTest
{

	public function setUp(){
		parent::setUp();
		$this->enums = ['YES' => 'YES', 'NO' => 'NO'];
		$this->enums_with_select_option = array_merge(["Select..." => ""], $this->enums);
		$this->table_name = 'user';
		$this->name = 'user_actie';
		$this->type = 'enum';
	}

	public function tearDown() {
        parent::tearDown();
        Mockery::close();
    }


   	public function test_initialize(){
   		$ServiceFieldMock = Mockery::mock('\crud\field\ServiceField[get_enum_values]');
   		$ServiceFieldMock->shouldReceive('get_enum_values')->once()->andReturn($this->enums);
   		$ServiceFieldMock->initialize(['type' => $this->type, 'name' => $this->name, 'table_name' => $this->table_name]);
   		$this->assertEquals($this->enums_with_select_option, $ServiceFieldMock->getAttribute('enums'));
   		$this->assertEquals($this->table_name, $ServiceFieldMock->getAttribute('table_name'));
   		$this->assertEquals($this->name, $ServiceFieldMock->getAttribute('name'));
   		$this->assertEquals($this->type, $ServiceFieldMock->getAttribute('type'));
   	}

   	public function test_set_type(){
   		$ServiceField = new ServiceField([], $this->CI);
   		$ServiceField->set_type('Date');
   		$this->assertEquals('date', $ServiceField->getAttribute('type'));

   		$ServiceField->set_type('Datetime');
   		$this->assertEquals('datetime', $ServiceField->getAttribute('type'));

   		$ServiceField->set_type('Timestamp');
   		$this->assertEquals('datetime', $ServiceField->getAttribute('type'));

   		$ServiceField->set_type('varchar');
   		$this->assertEquals('text', $ServiceField->getAttribute('type'));

   		$ServiceField->set_type('Enum');
   		$this->assertEquals('enum', $ServiceField->getAttribute('type'));
   	}

	public function test_get_enum_values(){
		$CI_DB_mysql_resultMock = Mockery::mock('CI_DB_mysql_result');
   		$row = new \stdClass();
   		$row->Type = "enum('YES','NO')";
   		$CI_DB_mysql_resultMock->shouldReceive('row')->andReturn($row);

   		$CI_DB_driverMock = Mockery::mock('CI_DB_driver');
   		$CI_DB_driverMock->shouldReceive('query')->andReturn($CI_DB_mysql_resultMock);

   		$CI_ControllerMock = Mockery::mock('CI_Controller');
   		$CI_ControllerMock->db = $CI_DB_driverMock;

   		$ServiceField = new ServiceField(['type' => 'enum'], $CI_ControllerMock);

		$this->assertEquals($this->enums, $ServiceField->get_enum_values());
	}
}