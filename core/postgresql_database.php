<?php
require_once 'constants.php';
require_once 'helper_functions.php';
class POSTGRESQLDatabase {
    private $connection;
    
    function __construct() {
        $this->open_connection();
    }
    
    private function heroku_db() {
        // heroku
        $dbstr1 = getenv('DATABASE_URL');
	$dbstr2 = substr("$dbstr1", 11);
	$dbstrarruser = explode(":", $dbstr2);
        $dbstrarrport = explode("/", $dbstrarruser[2]);
        $dbstrarrhost = explode("@", $dbstrarruser[1]);
        $dbpassword = $dbstrarrhost[0];
        $dbhost = $dbstrarrhost[1];
        $dbport = $dbstrarrport[0];
        $dbuser = $dbstrarruser[0];
        $dbname = $dbstrarrport[1];
        unset($dbstrarrport);
        unset($dbstrarruser);
        unset($dbstrarrhost);
        unset($dbstr1);
        unset($dbstr2);
        
        $connect = "host=" . $dbhost . ";dbname=" . $dbname . ";user=" . $dbuser
                . ";port=" . $dbport . ";sslmode=require;password=" . $dbpassword 
                . ";";
        return $connect;
    }
    private function open_connection() {
        // local
        $connect = 'host=localhost dbname=movie_app user=postgres password=root';
        // $connect = $this->heroku_db();
        
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
            HelperFunctions::return_message('error', ERROR_WITH_DATA, 'Error with data');
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