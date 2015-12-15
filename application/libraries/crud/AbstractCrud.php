<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'libraries/crud/InterfaceCrud.php';

abstract class AbstractCrud implements InterfaceCrud {

    abstract public function edit($id);

    abstract public function add();
    
    abstract public function delete($id);
}

/* End of file AbstractCrud.php */
/* Location: ./application/libraries/crud/AbstractCrud.php */