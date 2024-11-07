<?php
namespace App\Http\Controllers;
use hash;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    public function register(Request $request)
    {
        $validatedData = $request->validate(rules: [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:20'],
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "Success" => true,
            "errors" => [
                "code" => 0,
                "msg" => ""
            ],
            "data" => [
                "access_token" => $token,
                "token_type" => "Bearer"
            ],
            "msg" => "Usuario creado satisfactoriamente",
            "count" => 1
        ]);
    }

}