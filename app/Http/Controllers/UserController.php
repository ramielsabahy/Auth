<?php

namespace App\Http\Controllers;
use App\Transformers\UsersTransformer;
use Illuminate\Support\Collection;

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

    public function transform(){
    	// Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

    	$users = \App\User::first();

    	return response(
			UsersTransformer::transform( \App\User::all() )
		);
    }
}
