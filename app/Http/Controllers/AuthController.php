<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login;
use App\Http\Requests\Register;
use App\Models\User;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $apiResponse;

    public function __construct(ApiResponseService $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }

    // Register new user
    public function register(Register $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        $token = $user->createToken('MyApp')->accessToken;

        return $this->apiResponse->success(['token' => $token, 'user' => $user], 'User registered successfully');
    }

    // User login
    public function login(Login $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $token = auth()->user()->createToken('MyApp')->accessToken;
            return $this->apiResponse->success(['token' => $token], 'User logged successfully');
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    // User logout
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->apiResponse->success(null, 'User logged out successfully');
    }
}
