<?php
require_once 'core/database_functions.php';
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
    
    $data = array(
        'status' => SUCCESS,
        'id' => $id,
        'version_code' => $version_code,
        'version_name' => $version_name
    );
    
    return $data;
}
header("Content-Type: application/json; charset=UTF-8");
$results = get_results();
echo json_encode($results, JSON_FORCE_OBJECT);
