<?php

namespace App\Helpers;

class Helper {
    public static function getResponse($data,$message,$code){
        return response()->json([
            'data' => $data,
            'status' => [
                'message' => $message,
                'code' => $code
            ]
        ],$code);
    }
}
