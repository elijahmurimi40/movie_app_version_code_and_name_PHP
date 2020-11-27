<?php
class HelperFunctions {
    public static function enable_cors() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        header('Access-Control-Allow-Headers: '
                . 'X-Requested-With, token, Content-Type'
        );
    }
    public static function return_message($type, $code, $message) {
        header('content-type: application/json');
        $errorMessage = json_encode(
                [$type => ['status' => $code, 'message' => $message]]);
        echo $errorMessage;
        die();
    }
    
    public static function verify_method_post() {
        $request_method = filter_input(\INPUT_SERVER, 'REQUEST_METHOD', 
        \FILTER_SANITIZE_SPECIAL_CHARS);
        
        if($request_method == 'POST') {
            return true;
        } else {
            self::return_message(ERROR_M, ERROR, 'Only POST requests');
            return false;
        }
    }
    
    public static function verify_content_json() {
        $content_type = filter_input(\INPUT_SERVER, 'CONTENT_TYPE', 
                \FILTER_SANITIZE_SPECIAL_CHARS);
        
        if($content_type != 'application/json') {
            self::return_message(ERROR_M, REQUEST_CONTENT_TYPE_NOT_VALID, 
                    'Request content type is not valid. JSON REQUIRED');
        } else {
            return true;
        }
    }
    
    public static function check_empty($data, $key) {
        $message_value = $key.' cannot be empty';
        empty(trim($data)) ? self::return_message(ERROR_M, MUST_CONTAIN_VALUE, 
                $message_value) : '';
        
        return $data;
    }
    
    public static function not_set($key) {
        $message_key = $key.' key must be present';
        self::return_message(ERROR_M, KEY_MUST_EXIST, $message_key);
    }
}

