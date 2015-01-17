<?php

/**
 * 
 * @desc this function used to array $options, contain dropdown-data used for form-helper-function : form_dropdown(array)
 * @param $arr array source
 * @param $field_key field-name which it value will be used as key-value in $options
 * @param $field_val field-name which it value will be used as value in $options
 * @desc for example view this code : http://localhost/core/kliktodaycms/bank_payment
 * @return array
 * @Auth : Harry Osmmar Sitohang 2012-10-10
 * 
 */
function create_form_dropdown_options($arr = array(), $field_key = '', $field_val = '') {
    $options = array('0'=>'Please Select');
    foreach ($arr as $field) {
        $options[$field[$field_key]] = $field[$field_val];
    }
    return $options;
}

/**
 * 
 * @desc this function used to format date to default format
 * @param $date date
 * @param $format with default value 'd M Y' => '01 Jan 2012'
 * @return date-formated
 * @Auth : Harry Osmmar Sitohang 2012-10-25
 * 
 */
function format_date($date = false, $format = 'd M Y') {
    return date($format, strtotime($date));
}

/**
 * 
 * @desc this function used to format number to default number
 * @param $number number
 * @param $format number
 * @return number-formated
 * 
 */
function format_number($number) {
    return number_format(!empty($number) ? $number : 0, 0, '.', ',');
}

/**
 * 
 * @desc this function used to encrypt password
 * @param string $password
 * @return password encrypted
 * 
 */
function encrypt_password($password){
    $CI = &get_instance();
    $encryption_key = $CI->config->item("encryption_key");
    unset($CI);
    return sha1("{$encryption_key}{$password}");
}


function  generate_uniq_id(){
    return md5(microtime());
}


/* End of file function_helper.php */
/* Location: ./application/helper/function_helper.php */