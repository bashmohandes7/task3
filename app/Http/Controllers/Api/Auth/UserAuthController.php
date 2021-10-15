<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    use ApiResponseTrait;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        if($validator->fails()){
            return $this->apiResponse(null, $validator->errors(), 404);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('API Token')->accessToken;
        $user->token = $token;

        return $this->apiResponse($user, 'User successfully registered', 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return $this->apiResponse(null, 'Incorrect Details.Please try again', 404);
        }
        $user = auth()->user();

        $token = $user->createToken('API Token')->accessToken;
        $user->token = $token;
        return $this->apiResponse($user, 'Login Successfully');

    }
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return $this->apiResponse(null, 'User successfully signed out');
    }
}
