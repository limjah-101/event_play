<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthLoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                "email" => "email|required",
                "password" => "required"
            ]);

            $credentials = request(["email", "password"]);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    "status_code" => 500,
                    "message" => "Unauthorized"
                ]);
            }

            $user = User::where("email", $request->email)->first();

            if ( !Hash::check($request->password, $user->password, [])) {
                throw new \Exception("login error");
            }

            $tokenResult = $user->createToken("authToken")->plainTextToken;
            return response()->json([
                "status_code" => 200,
                "access_token" => $tokenResult,
                "token_type" => "Bearer",
            ]);

        } catch (Exception $error) {
            return response()->json([
                "status_code" => 500,
                "message" => "errror log in",
                "error" => $error,
            ]);
        }
    }


    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'password'
        ]);

       User::create([
           'name' => $request->name,
           'email' => $request->email,
           'password' => Hash::make($request->password)
       ]);

       return response()->json(["success" => "Account created"]);
    }
}
