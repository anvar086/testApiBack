<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(RegisterRequest $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return $this->success($user);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error('These credentials do not match our records.', 404, 'text');
        }

        Auth::login($user);

        $token = $user->createToken('my-app-token');

        $user = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];

        $response = [
            'user' => $user,
            'token' => $token->plainTextToken,
            'token_expiration' => $token->accessToken->created_at->addMinutes(60),
            'current_time' => now(),
        ];

        return $this->success($response, 201);
    }



    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->currentAccessToken()->delete();
            return response()->json('success', 200);
        }
        return response()->json('error', 404);
    }

}
