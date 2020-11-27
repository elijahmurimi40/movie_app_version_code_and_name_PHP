<?php
require_once 'postgresql_database.php';

class DatabaseFunctions {
    public static function find_row($sql, $data) {
        $results_array = self::find_by_sql($sql, $data);
        return !empty($results_array) ? array_shift($results_array) : false;   
    }

    public static function find_by_sql($sql, $data) {
        global $database;
        $results_set = $database->query_sql($sql, $data); 
        $object_array = array();
        while ($rows = $database->fetch_assoc_sql($results_set)) {
            $object_array[] = self::instantiate($rows);
        }
        return !empty($object_array) ? $object_array : false;
    }

    private static function instantiate($record) {
        $object = new self;
        foreach ($record as $attribute => $value) {
            if ($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    private function has_attribute($attribute) {
        $object_vars = 	get_object_vars($this);
        return array_key_exists($attribute, $object_vars);
    }
    
    public $version_code;
    public $version_name;
    public $password;
}