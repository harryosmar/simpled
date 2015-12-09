<?php
namespace unit;

class BaseTest extends \PHPUnit_Framework_TestCase
{
    public function setUp() {
        $this->CI = &get_instance();
    }

    public function testAssertionTrue(){
        $this->assertTrue(TRUE);
    }

    public function tearDown(){
        unset($this->CI);
    }
}