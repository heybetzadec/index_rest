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

            $accessToken = Auth::user()->createToken('authToken')->accessToken;

            return response([
                'user'=>Auth::user(),
                'access_token' => $accessToken,
                'status'=>'ok'
            ]);

        } catch (\Exception $e) {
            return response([
               'message'=>$e->getMessage()
            ]);
        }



    }

}
