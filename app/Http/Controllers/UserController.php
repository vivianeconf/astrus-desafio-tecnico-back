<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('token-name');

        return response()->json(['token' => $token, 'user' => $user]);
    }

    public function read($id)
    {
        $user = User::find($id);
        return response()->json(['user'=>$user], Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email',
            'password' => 'sometimes|required|string',
        ]);

        try {
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->password = $request->password;
            $user->save();

            return response()->json(['message'=>'Usuário atualizado com sucesso.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message'=>'Não foi possível editar o usuário.', 'error'=>$e], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete($id)
    {
        $user = User::find($id);

        if (!$user)
        {
            return response()->json(['message'=>'Não foi possível excluir o usuário.'], Response::HTTP_BAD_REQUEST);
        }
        
        $user->delete();
        
        return response()->json(['message'=>'Usuário excluido com sucesso.'], Response::HTTP_OK);
    }
}