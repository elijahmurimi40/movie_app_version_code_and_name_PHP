<?php
require_once 'constants.php';
require_once 'helper_functions.php';
class POSTGRESQLDatabase {
    private $connection;
    
    function __construct() {
        $this->open_connection();
    }
    
    private function open_connection() {
        // local
        $connect = 'host=localhost dbname=movie_app user=postgres password=root';
        
        try {
            $this->connection = new PDO('pgsql:'.$connect);
        } catch (\PDOException $exc) {
            HelperFunctions::return_message('error', ERROR_CONNECTING_TO_DATABASE, 
                    'Couldn\'t connect to the database. Please refresh.');
            $exc->getTraceAsString();
        }
    }
    
    private function confirm_query($results) {
        if(!$results) {
            HelperFunctions::return_message('error', ERROR_GETTING_DATA, 'Error getting data');
        }
    }
    
    public function fetch_assoc_sql($results) {
        return $results->fetch(PDO::FETCH_ASSOC);
    }
    
    public function query_sql($sql, $data) {
        if($data == null) {
            $results = $this->connection->query($sql);
            $this->confirm_query($results);
            return $results;
        } else {
            $stmt = $this->connection->prepare($sql);
            $results = $stmt->execute($data);
            $this->confirm_query($results);
            return $stmt;
        }
    }
    
    public function update($table, $placeholder, $where, $data) {
        $cols = array();
        foreach ($placeholder as $key => $value) {
            $cols[] = "$key = :$value";
        }
        $val = implode(', ', $cols);
        $sql = "UPDATE $table SET $val WHERE $where";
        $this->query_sql($sql, $data);
    }
}

$database = new POSTGRESQLDatabase();