<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'password' => 'required|string',
                'email' => 'required|email',
            ]);
        
            if ($validator->fails()){
                $result = [
                    'success' => false,
                    'error' => "Wrong input data!",
                    'errors' => $validator->errors()->all()
                ];

                return response()->json($result);
            }

            $user = User::create([
                'name' =>  $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'api_token' => Str::random(30)
            ]);

            $result = [
                'succes' => true,
                "api_token" => $user['api_token']
            ];

            return response()->json($result);

        }catch(Throwable $e){
            $result = [
                "success" => false,
                "error" => $e->getMessage()
            ];

            return response()->json($result);
        }
    }
}
