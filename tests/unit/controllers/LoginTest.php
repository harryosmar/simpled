<?php
namespace unit\controllers;

include_once 'unit' . DS . 'BaseTest.php';

use Login;

class LoginTest extends \unit\BaseTest
{
    public function setUp() {
        $this->CI =  Login::get_instance();
    }

    // public function test_testing()
    // {
    //     $mock = $this->getMock('Login');
    //     $mock->expects($this->once())->method('testing')->will($this->returnValue(TRUE));
    // 	var_dump($mock::get_instance()->testing()); die;
    // }
}