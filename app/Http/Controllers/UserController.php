<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\ApiResponseService;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $apiResponse;

    public function __construct(ApiResponseService $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }

    // Get all users
    public function index()
    {
        $users = User::all();
        return $this->apiResponse->success($users, 'Users fetched successfully');
    }

    // Get a specific user
    public function show(User $user)
    {
        return $this->apiResponse->success($user, 'User fetched successfully');
    }

    // Create new user
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return $this->apiResponse->success($user, 'User saved successfully', 201);
    }

    // Update user
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return $this->apiResponse->success($user, 'User updated successfully');
    }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();
        return $this->apiResponse->success(null, 'User deleted successfully', 200);
    }
}
