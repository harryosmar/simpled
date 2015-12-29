<?php
namespace crud\schema;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

interface InterfaceSchema {
    public function get_table_name();

    public function get_primary_key_name();

    public function get_fields();
}

/* End of file InterfaceSchema.php */
/* Location: ./application/libraries/crud/InterfaceSchema.php */