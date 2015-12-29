<?php
namespace unit\controllers;

include_once 'unit' . DS . 'BaseTest.php';

// require_once(APPPATH.'controllers/baseadmin/Privilege.php');
// use Privilege;

class PrivilegeTest extends \unit\BaseTest
{
    public function setUp() {
        parent::setUp();
        // $this->controllers = new Privilege();

        // $this->CI =  Privilege::get_instance();

        // var_dump($this->CI->db->query('SELECT * FROM user')->result_array()); die;

        // $this->CI->session->set_userdata('session_user', [
        //     'user_id' => '1',
        //     'user_group_id' => '1',
        //     'user_email' => 'if07087@gmail.com',
        //     'user_password' => 'b39b2b3dc81ed59a16c531c44b5160da92fccd72',
        //     'user_fullname' =>  'Harry Osmar Sitohang',
        //     'user_active' => 'YES',
        //     'user_group_type' => 'DEVELOPER',
        //     'user_group_desc' => 'Grant All Access For Developer, Cause Responsible To Create New Feature'
        // ]);
    }

    // public function test_check_menu_id()
    // {die();
    //     // var_dump($this->CI); die;
    //     call_user_func_array(array(&$this->CI, 'check_menu_id'), []);
    // 	// var_dump($this->CI->check_menu_id()); die;
    // }
}