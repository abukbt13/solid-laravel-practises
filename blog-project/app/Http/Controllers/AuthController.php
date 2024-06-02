<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function register(UserRequest $request){

        $user = $this->userService->createUser($request->all());

        return response()->json(['status'=>'success','message' => 'User created successfully','user'=>$user], 201);
    }


    public function login(LoginRequest $request)
    {
            // Attempt to log in the user
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

            // Optionally, generate a token for the user (if using Sanctum or Passport)
            $token = $user->createToken('auth_token')->plainTextToken;


            // Optionally, generate a token for the user (if using Sanctum or Passport)
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }
    public function users(){
        $user = $this->userService->GetUsers();
        return response()->json(['status'=>'success','message' => 'User retrieved successfully','user'=>$user], 201);

    }
}
