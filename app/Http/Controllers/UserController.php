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

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Users Retrieved successfully.";
        $resp->Status = true;
        $resp->InnerData = UsersTransformer::transform( \App\User::all() );

    	return response()->json($resp,200);
    }

    public function register(Request $request){
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        $name = $request->name;
        $pass = $request->password;
        $mail = $request->email;
        $phone = $request->phone;

        $check = User::where(['email' => $mail])->first();
        if(! $check){
            $checkphone = User::where('phone', $phone)->first();
            if(! $checkphone){
                $register = array('name' => $name, 'password' => bcrypt($pass), 'email' => $mail,
                                  'phone' => $phone);
                $insertGetID = Normal::create($register);

                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = "User has been successfully created.";
                $resp->Status = true;
                $resp->InnerData = (object)[];
                return response()->json($resp, 200);
            }else{
                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = "Soory the phone number is registered before.";
                $resp->Status = false;
                $resp->InnerData = (object)[];
                return response()->json($resp, 200);
            }
        }else{
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Email already exist.";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
    }

    public function login(Request $request){
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        $phone = $request->phone;
        $pass = $request->password;

        $check = User::where('phone', $phone)->first();
        if($check){
            $checkPass = User::where(['phone' => $phone])->first();
            if(Hash::check($pass, $checkPass['password'])){
                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = "Logged in successfully.";
                $resp->Status = true;
                $resp->InnerData = $check;

                return response()->json($resp,200);
            }else{
                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = "Invalid Password.";
                $resp->Status = false;
                $resp->InnerData = (object)[];

                return response()->json($resp,200);
            }
        }else{
            $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = "Invalid phone.";
                $resp->Status = false;
                $resp->InnerData = (object)[];

                return response()->json($resp,200);
        }
    }

    /*
    *
    *$image = base64_decode($imageIn);

        $path = public_path()."/uploads/places/".$image_name;

        // to save the image into the folder 

        file_put_contents($path, $image);

        if(isset($imageIn)){

            $final_path = "/public/uploads/places/" . $image_name;

            $user->image = 'https://ramyelsabahy.000webhostapp.com'.$final_path;

            $user->place_id = $place_id;

            $user->save();

            $resp = new \App\Http\Helpers\ServiceResponse;

            $resp->Message = "Image Added Successfully.";

            $resp->Status = true;

            $resp->InnerData = (object)[];

            return response()->json($resp, 200);

        }
    */
}
