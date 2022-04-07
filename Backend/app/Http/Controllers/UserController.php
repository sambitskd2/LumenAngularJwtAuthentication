<?php

namespace APp\Http\Controllers;

use App\Http\Controllers\Controller;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function register(Request $request)
    {
        $userExist = DB::table('users')->where("email", $request->email)->exists();
        if ($userExist)
            return $this->responseHandler("User already exist.😬", 409, false);

        $newUser = DB::table('users')->insert([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);
        if ($newUser)
            return $this->responseHandler("User created successfully😎", 201, true);
        else   return $this->responseHandler("Something went wrong.😬", 409, false);
    }
    public function login()
    {
        $credentials = request(['email', 'password','name']);
        $customClaims = ['foo' => 'bar', 'baz' => 'bob'];

        if (!$token = auth()->attempt($credentials,$customClaims))
            return response()->json([
                'message' => 'Unauthorized',
                'code' => 401
            ], 200);

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'success' => true,
            "message" => 'Login Successfull',
            'code' => 200
        ], 200);
    }

    private function responseHandler($message, $statusCode, $successStatus)
    {
        return response()->json([
            "message" => $message,
            "success" => $successStatus,
            "code" => $statusCode
        ], 200);
    }
}
