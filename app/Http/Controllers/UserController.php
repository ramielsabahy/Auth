<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
    	// Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

    	$users = \App\User::get();
    	return response()->json(['message' => $users]);
    }
}
