<?php
require_once 'core/database_functions.php';
require_once 'core/constants.php';

$request_method = filter_input(\INPUT_SERVER, 'REQUEST_METHOD', 
        \FILTER_SANITIZE_SPECIAL_CHARS);
HelperFunctions::verify_method_post($request_method);

function get_results() {
    $sql = "SELECT * FROM version_code_name ORDER BY id ASC";
    $results = DatabaseFunctions::find_by_sql($sql, null);
    $id = 0;
    $version_code = '';
    $version_name = '';
    
    foreach ($results as $key) {
        $id = $key->id;
        $version_code = $key->version_code;
        $version_name = $key->version_name;
    }
    
    $success = array(
        'status' => SUCCESS,
        'id' => $id,
        'version_code' => $version_code,
        'version_name' => $version_name
    );
    
    $data = array(
        'success' => $success
    );
    
    return $data;
}
header("Content-Type: application/json; charset=UTF-8");
$results = get_results();
echo json_encode($results, JSON_FORCE_OBJECT);
