<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use Session;

class AjaxController extends Controller
{

    public static function success($params = [])
    {
        $status = [];
        $status['response'] = "ok";
        $status['user_language_id'] = Session::get('user_language_id',1);
        return Response::json(array_merge($status, $params));
    }

    public static function fail($message)
    {
        return Response::json(['response' => 'error', 'message' => $message]);
    }

    public static function validationError($message)
    {
        return Response::json($message, 422);
    }

    public static function unauthorized($message)
    {
        return Response::json($message, 422);
    }
}
