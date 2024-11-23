<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\ApiKey;
use Storage;

class AdminController extends Controller
{
    public function adminLogin(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|max:50',
            'password' => 'required|min:8', 
        ]);

        $admin = Admin::where('email', $request->email)->first();
        
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response([
                'errors' => [
                    'email' => ['These credentials do not match our records.'],
                    'password' => ['These credentials do not match our records.'],
                ],
                'message' => 'These credentials do not match our records.'
            ], 422);
        }
        
        $token = $admin->createToken('my-app-token')->plainTextToken;

        return response([
            'admin' => $admin,
            'token' => $token
        ], 200);
    }

    public function getApiKey(Request $request)
    { 
        return ApiKey::first(); 
    }

    public function updateApiKey(Request $request)
    {
    	$request->validate([
    		'api_key_id' => 'required',
    		'api_key' => 'required'
    	]); 
        return ApiKey::where('api_key_id', $request->api_key_id)->update([
        	'api_key' => $request->api_key
        ]); 
    }

    public function getAwsFolders(Request $request){
		$folders  = Storage::disk('s3')->directories('State/attachments/');
		$folders = array_reverse($folders);

		$files = [];
		foreach ($folders as $folder_path) {
			$parts = explode('/', $folder_path);
			array_push($files, end($parts));
		}

		return $files;
	}
}
