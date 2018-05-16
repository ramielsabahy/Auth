<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;

class ApiAuthController extends Controller
{
    public function authenticate() {
		// get user data
		$credentials = request()->only('email', 'password');

		// check if user credentials are correct
		try {
			// using the facade
			$token = \JWTAuth::attempt($credentials);

			if (!$token) {
			// unauthorized access
			return response()->json(['error' => 'invalid_credentials'], 401);
			}
		}catch(\Tymon\JWTAuth\Exceptions\JWTException $e) {
			// internal server error
			return response()->json(['error' => 'something_went_wrong'], 500);
		}

		// generate a token
		// successful
		return response()->json(['token' => $token], 200);
	}

	public function register() {
		// create user
		$email = request()->email;
		$name = request()->name;
		$password = request()->password;

		$user = User::create([
			'name' => $name,
			'email' => $email,
			'password' => bcrypt($password)
		]);

		// generate token
		$token = \JWTAuth::fromUser($user);

		// return response
		return response()->json([
			'message' => 'Registered successfully.'
		], 200);
	}

}
