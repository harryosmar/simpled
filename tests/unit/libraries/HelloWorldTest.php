<?php
class HelloWorldTest extends PHPUnit_Framework_TestCase
{
    public function setUp() {
        $this->CI = &get_instance();
    }

    public function test_hello_world()
    {
        $string = 'Hello World';
        $this->assertEquals('Hello World', $string);
    }
}