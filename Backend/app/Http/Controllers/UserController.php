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
        return $this->responseHandler("User created successfully😎", 201, true);
    }



    private function responseHandler($message, $statusCode, $successStatus)
    {
        return response()->json([
            "message" => $message,
            "success" => $successStatus
        ], $statusCode);
    }
}
