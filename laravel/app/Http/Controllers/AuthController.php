<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'position' => 'required',
            'company' => 'required',
            'phone' => 'required',
            'web_address' => 'required',
            'mailing_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pin_code' => 'required',
            'set_asides' => 'required|array'
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json([
            'user' => $user
        ]);
    }

    // Login user and create token
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::with('UserSubscription')->where('email', $request->email)->where('pw', $request->password)->first();

        // if (!$user || !Hash::check($request->password, $user->password)) {
        //     throw ValidationException::withMessages([
        //         'email' => ['The provided credentials are incorrect.'],
        //     ]);
        // }
        if($user){

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        }else{
            return response()->json(['message' => 'These credentials donot match']);
        }
    }

    // Logout user (revoke token)
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    // Get user details
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function paginateActiveUsers(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required',
            'keyword' => 'required'
        ]);

        $query = User::query();
        $query->whereNull('deleted_at');
        
        if($request->search!='')
        {
            $query->where('name', 'like', "%$request->search%")->orWhere('email', 'like', "$request->search%")
                ->orWhere('phone', 'like', "$request->search%")->orWhere('company', 'like', "$request->search%");
        }
        $user = $query->orderBy($request->keyword,$request->order_by)->paginate($request->per_page); 
        return UserResource::collection($user);
    }
}
