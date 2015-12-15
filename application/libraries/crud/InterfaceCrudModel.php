<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

interface InterfaceCrudModel {

    public function get_table_name();

    public function get_primary_key();

    public function delete($id);

}

/* End of file InterfaceCrudModel.php */
/* Location: ./application/libraries/crud/InterfaceCrudModel.php */