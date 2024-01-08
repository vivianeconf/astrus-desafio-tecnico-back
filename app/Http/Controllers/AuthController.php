<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password')))
        {
            return response()->json([
                'message' => 'Autorizado.', 
                'token' => $request->user()->createToken('token-name')
            ], Response::HTTP_ACCEPTED);
        } 

        return response()->json(['message'=>'Não autorizado.'], Response::HTTP_UNAUTHORIZED);
    }
}
