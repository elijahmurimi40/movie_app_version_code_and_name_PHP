<?php
class HelperFunctions {
    public static function return_message($type, $code, $message) {
        header('content-type: application/json');
        $errorMessage = json_encode(
                [$type => ['status' => $code, 'message' => $message]]);
        echo $errorMessage;
        die();
    }
    
    public static function verify_method_post($reqest_method) {
        if($reqest_method == 'POST') {
            return true;
        } else {
            self::return_message('error', ERROR, 'Only POST requests');
            return false;
        }
    }
}

