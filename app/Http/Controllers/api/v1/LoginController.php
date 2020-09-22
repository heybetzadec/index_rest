<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $login = $request->validate([
                'email' => 'required|string',
                'password' => 'required|string'
            ]);

            if (!Auth::attempt($login)) {
                return response([
                    'message' => 'Invalid login credentials.',
                    'status'=>'error',
                ]);
            }

            $authUser = Auth::user();
            $accessToken = $authUser->createToken('authToken')->accessToken;
            $authUser->token = $accessToken;

            return response([
                'user'=>$authUser->only(['name', 'email', 'logo', 'token']),
                'status'=>'ok'
            ]);

        } catch (\Exception $e) {
            return response([
               'message'=>$e->getMessage()
            ]);
        }



    }

}
