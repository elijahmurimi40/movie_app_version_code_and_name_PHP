<?php
require_once 'core/database_functions.php';
require_once 'core/constants.php';

HelperFunctions::verify_method_post();
HelperFunctions::verify_content_json();

function verify_password($password) {
    // $password = '***fortie40###';
    $username = '40FoRtIe';
    $username_rev = strrev($username);
    $actual_password = $password.$username_rev;
    
    $sql = "SELECT password FROM version_code_name";
    $results = DatabaseFunctions::find_by_sql($sql, null);
    foreach ($results as $key) {
        $password = $key->password;
    }
    $verify = password_verify($actual_password, $password);
    
    if(!$verify):
        HelperFunctions::return_message('error', WRONG_PASSWORD, 'Incorrect Password');
    endif;
}

function insert_data() {
    global $database;
    $input_data = file_get_contents('php://input');
    $decoded_data = json_decode($input_data, true);
    $version_code = $decoded_data["version_code"];
    $version_name = $decoded_data['version_name'];
    $password = $decoded_data['password'];
    
    verify_password($password);
    
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

$results = insert_data();
echo $results;
