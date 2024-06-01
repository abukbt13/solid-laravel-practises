<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function register(BlogRequest $request){

        $user = $this->userService->createUser($request->all());

        return response()->json(['status'=>'success','message' => 'User created successfully','user'=>$user], 201);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }
    public function users(){
        $user = $this->userService->GetUsers();
        return response()->json(['status'=>'success','message' => 'User retrieved successfully','user'=>$user], 201);

    }
}
