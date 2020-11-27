<?php
require_once 'core/database_functions.php';
require_once 'core/constants.php';

HelperFunctions::verify_method_post();
HelperFunctions::verify_content_json();
HelperFunctions::enable_cors();

function verify_password($password) {
    // $password = '***fortie40###';
    // $username = '40FoRtIe';
    // $username_rev = strrev($username);
    // $actual_password = $password.$username_rev;
    
    $sql = "SELECT password FROM version_code_name";
    $results = DatabaseFunctions::find_by_sql($sql, null);
    foreach ($results as $key) {
        $actual_password = $key->password;
    }
    $verify = password_verify($password, $actual_password);
    
    if(!$verify):
        HelperFunctions::return_message('error', WRONG_PASSWORD, 'Incorrect Password');
    endif;
}

function verify_data() {
    $input_data = file_get_contents('php://input');
    $decoded_data = empty(json_decode($input_data, true)) ? 
            HelperFunctions::return_message(ERROR_M, NO_DATA, 'No data') 
            : json_decode($input_data, true);
    
    $password = isset($decoded_data['password']) 
            ? HelperFunctions::check_empty($decoded_data['password'], 'password') 
            : HelperFunctions::not_set('password');
    verify_password($password);
    
    $data = isset($decoded_data['data']) ? $decoded_data['data'] 
            : HelperFunctions::not_set('data');
    
    $version_code = isset($data['version_code']) 
            ? HelperFunctions::check_empty($data['version_code'], 'version_code')
            : HelperFunctions::not_set('version_code');
    
    $version_name = isset($data['version_name'])
            ? HelperFunctions::check_empty($data['version_name'], 'version_name')
            : HelperFunctions::not_set('version_name');
    
    $version_code_int = is_numeric($version_code) ? $version_code 
            : HelperFunctions::return_message(ERROR_M, ERROR, 'invalid version code');
    
    insert_data($version_code_int, $version_name);
}

function insert_data($version_code, $version_name) {
    global $database;
    $table = 'version_code_name';
    $placeholder = array(
        'version_code' => 'version_code',
        'version_name' => 'version_name'
    );
    $where = 'id = 1';
    $insert_data = array(
        'version_code' => $version_code,
        'version_name' => $version_name
    );
    
    $database->update($table, $placeholder, $where, $insert_data);
    HelperFunctions::return_message(SUCCESS_M, SUCCESS, 'Successfully Updated');
}

verify_data();