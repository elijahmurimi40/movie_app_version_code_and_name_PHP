<?php
class HelperFunctions {
    public static function return_message($type, $code, $message) {
        header('content-type: application/json');
        $errorMessage = json_encode(
                [$type => ['status' => $code, 'message' => $message]]);
        echo $errorMessage;
        die();
    }
}

