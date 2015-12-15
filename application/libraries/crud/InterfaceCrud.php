<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

interface InterfaceCrud {
    public function edit($id);

    public function add();

    public function delete($id);
}

/* End of file InterfaceCrud.php */
/* Location: ./application/libraries/crud/InterfaceCrud.php */