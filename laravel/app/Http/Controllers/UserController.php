<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserSetAside;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    public function getUser(Request $request){
    	$data = $request->validate([
    		'user_id' => 'required'
    	]);
    	$user = User::where('user_id', $request->user_id)->first();
    	return new UserResource($user);
    }

    public function changePassword(Request $request)
	{
	    // Validate the input
	    $data = $this->validate($request, [
          'user_id' => 'required',
	        'current_password' => 'required|min:8',
	        'new_password' => 'required|min:8|confirmed', // 'confirmed' ensures new_password == confirm_password
	    ]);

	    $user = User::where('user_id', $request->user_id)->where('password', $request->current_password)->first();
	    if (!$user) {
	        return response()->json([
	            'errors' => [
	                'current_password' => ['Your current password does not match.'],
	            ]
	        ], 422);
	    }

	    if ($request->current_password === $request->new_password) {
	        return response()->json([
	            'errors' => [
	                'new_password' => ['New Password cannot be the same as your current password.'],
	            ]
	        ], 422);
	    }
	    
	    User::where('email', $user->email)->update([
	    	'password' => Hash::make($request->new_password)
	    ]);

	    return response()->json([
	        'message' => ['Password has been successfully updated.']
	    ], 200);
	}

    public function updateUser(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'position' => 'required',
            'company_name' => 'required',
            'phone' => 'required',
            'web_address' => 'required',
            'mailing_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required',
            'set_asides' => 'required|array',
            'terms' => 'accepted',
        ]);
        $data['pin_code'] = $data['zipcode'];

        $user = User::where('user_id', $request->user_id)->first();
        if($user){
            $user->update($data);
            foreach ($request->set_asides as $set_aside_id) {
                UserSetAside::updateOrCreate([
                  'user_id' => $user->user_id,
                  'set_aside_id' => $set_aside_id
                ]);
            }
        }

        return response()->json([
            'user' => $user
        ]);
    }

    public function toggleUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id'
        ]);

        $user = User::where('user_id', $request->user_id)->first();
        if($user->status){
            $user->update([
                'status' => false
            ]);
            return response()->json([
                "message" => 'User deactivated successfully'
            ]);
        }else{
            $user->update([
                'status' => true
            ]);

            return response()->json([
                "message" => 'User activated successfully'
            ]);
        }
    }

    public function activateUser(Request $request){
        $data = $request->validate([
            'user_id' => 'required'
        ]);
        $activate_user = User::where('user_id', $request->user_id)->update([
            'status' => true
        ]);
        if($activate_user){
            $user = User::where('user_id', $request->user_id)->first();
            return new UserResource($user);
        }else{
            return response()->json(['error' => 'Unbale to activate'], 422);
        }
    }

}
