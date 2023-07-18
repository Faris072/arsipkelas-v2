<?php

namespace App\Helpers;
use App\Models\user;

class Helper {
    public static function getResponse($data = null, $message = null, $code = 200){
        return response()->json([
            'data' => $data,
            'status' => [
                'message' => $message,
                'code' => $code
            ]
        ],$code);
    }

    public static function getActor($data, $action = 'created'){
        switch($action){
            case 'created':
                return User::find($data->created_by);
                break;
            case 'updated':
                return User::find($data->updated_by);
                break;
            case 'deleted':
                return User::find($data->deleted_by);
                break;
            default:
                return User::find($data->created_by);
                break;
        }
    }
}
