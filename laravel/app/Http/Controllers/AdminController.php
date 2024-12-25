<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\ApiKey;
use Storage;
use App\Http\Resources\AdminResource;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\AdminSetting;

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

     public function adminLogout(Request $request)
    {
        $admin = Admin::where('admin_id', $request->admin_id)->first();
        if($admin)
        {
            $admin->tokens()->delete();
            return response([
                'message'=>'Logged out Successfully'
            ],200);
        }
        else{
            return response([
                'error'=>'Unable to Log Out. Please try again later!'
            ],404);
        }
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

    public function paginateAdmins(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric',
            'keyword' => 'required'
        ]);
        $query = Admin::query();
          
        if($request->search!='')
        {
            $query->where('first_name', 'like', "%$request->search%")->orWhere('last_name', 'like', "$request->search%")
                ->orWhere('email', 'like', "$request->search%")->orWhere('mobile1', 'like', "$request->search%")->orWhere('mobile2', 'like', "$request->search%");
        }
        $users = $query->orderBy($request->keyword,$request->order_by)->paginate($request->per_page);
        return AdminResource::collection($users);
    }

    public function addAdmin(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'mobile1' => 'required|digits:10',
            'mobile2' => 'required|digits:10',
            'role' => 'required',
            'real_password' => 'nullable'
        ]);
        $password = '1qaz2wsx';
        $data['password'] = Hash::make($password);
        $data['created_on'] = Carbon::now();
        $data['last_login'] = Carbon::now();
        $data['last_seen'] = Carbon::now();
        $data['last_edited'] = Carbon::now();
        $data['status'] = true;
        $data['real_password'] = $password;

        $admin = Admin::create($data);
        return new AdminResource($admin);
    }

    public function getAdmin(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,admin_id'
        ]);

        $admin = Admin::where('admin_id', $request->admin_id)->first();
        return new AdminResource($admin);
    }

    public function updateAdmin(Request $request)
    {
        $data = $request->validate([
            'admin_id' => 'required|exists:admins,admin_id',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'mobile1' => 'required|digits:10',
            'mobile2' => 'required|digits:10',
            'role' => 'required',
        ]);
        $data['status'] = true;

        $admin = Admin::where('admin_id', $request->admin_id)->first();
        $admin->update($data);
        return new AdminResource($admin);
    }

    public function deleteAdmin(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,admin_id'
        ]);

        Admin::where('admin_id', $request->admin_id)->delete();
        return response()->json([
            "message" => 'Admin Deleted Successfully'
        ]);
    }

    public function toggleAdmin(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,admin_id'
        ]);

        $admin = Admin::where('admin_id', $request->admin_id)->first();
        if($admin->status){
            $admin->update([
                'status' => false
            ]);
            return response()->json([
                "message" => 'Admin user deactivated successfully'
            ]);
        }else{
            $admin->update([
                'status' => true
            ]);

            return response()->json([
                "message" => 'Admin user activated successfully'
            ]);
        }
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

    public function showS3BucketFiles(Request $request)
    {
        $data = $request->validate([
            'folder'=> 'required'
        ]);

        $folderPath = rtrim('State/attachments/'.$request->folder, '/') . '/';
        $files = Storage::disk('s3')->files($folderPath);
        $excel_files = array_map(function ($file) 
        {
            return pathinfo($file, PATHINFO_EXTENSION) === 'xlsx' ? basename($file) : null;
        }, $files);

        return array_values(array_filter($excel_files));
    }

    public function deleteS3BucketFiles(Request $request)
    {
        $data = $request->validate([
            'folder'=> 'required',
            'delete_files'=> 'required|array'
        ]);

        $folderPath = 'State/attachments/' . trim($request->folder, '/') . '/';
        foreach ($data['delete_files'] as $file) {
            $filePath = $folderPath . $file;
            
            // Check if the file exists before attempting to delete
            if (Storage::disk('s3')->exists($filePath)) {
                Storage::disk('s3')->delete($filePath);
                $deleted_files[] = $file; // Add to the list of deleted files
            }
        }

        // Return a response with the list of deleted files
        return response()->json([
            'deleted_files' => $deleted_files,
            'message' => count($deleted_files) > 0 ? 'Files deleted successfully.' : 'No files deleted.',
        ]);
    }

    public function uploadS3BucketFile(Request $request)
    {
        $data = $request->validate([
            'folder' => 'required|string',
            'file' => 'required|file|mimes:xlsx|max:2048'
        ]);
        $folderPath = 'State/attachments/' . trim($request->folder, '/') . '/';
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = $folderPath . $fileName;
        if (Storage::disk('s3')->exists($filePath)) {
            return response()->json([
                'errors' => ['duplicate' => 'File already exists in the bucket'],
                'message' => 'File already exists in the bucket',
            ], 409);  // HTTP status code 409 Conflict
        }

        Storage::disk('s3')->put($filePath, file_get_contents($file));
        return response()->json([
            'file_name' => $fileName,
            'message' => 'File uploaded successfully.',
        ]);
    }

    public function meAdmin(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,admin_id'
        ]);
        $user = Admin::where('admin_id', $request->admin_id)->first();
        return new AdminResource($user);
    }

    public function updateAdminProfile(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required',
            'mobile1' => 'required|regex:/^\+?[1-9]\d{9}$/',
            'email' => 'required|email|max:100|unique:users,email,'.$request->user_id.',user_id',
            'role' => 'required'
        ]);

        $admin = Admin::where('admin_id', $request->admin_id)->first();
        if ($request->hasFile('avatar')) {
            $avatar = time().'.'.$request->file('avatar')->getClientOriginalExtension();
            $request->avatar->move(public_path('storage/users'), $avatar);
            $data['avatar'] = $avatar;
        } 
        else {
            $data['avatar'] = $user->avatar;
        }
        $admin->update($data);
        return new AdminResource($admin);
    }
    
    public function updateAdminPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);
        $user = Admin::where('admin_id', $request->admin_id)->first();
        if (!(Hash::check($request->current_password, $user->password)))
        {
            return response()->json([
                'errors' => [
                    'current_password' => ['Your current password does not matches with the password you provided. Please try again'],
                ]
            ], 422);
        }
        else if(strcmp($request->new_password, $user->first_name) == 0)
        {
            return response()->json([
                'errors' => [
                    'new_password' => ['New Password cannot be same as username'],
                ]
            ], 422);
        }
        else if(strcmp($request->current_password, $request->new_password) == 0)
        {
            return response()->json([
                'errors' => [
                    'new_password' => ['New Password cannot be same as your current password. Please choose a different password.'],
                ]
            ], 422);
        }
        else if(strcmp($request->new_password, $request->confirm_password) != 0)
        {
            return response()->json([
                'errors' => [
                    'confirm_password' => ['The password confirmation does not match'],
                ]
            ], 422);
        }
        else
        {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            return response()->json([
                'message' => ['Password is successfully updated'],
            ], 200);
        }
    }

    public function dashboardCounts(Request $request)
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        //Counts
        $registered_users = User::count();
        $confirm_user_emails = User::whereNotNull('email_verified_at')->count();
        $notconfirm_user_emails = User::whereNull('email_verified_at')->count();
        $actual_subscritions = UserSubscription::where('active_status', 'active')->where('valid_to', '>', Carbon::today())->count();
        $expired_subscritions = UserSubscription::where('active_status', '!=', 'active')->where('valid_to', '<', Carbon::today())->count();
        $total_trial_actives = UserSubscription::where('active_status', 'active')->whereHas('SubscriptionPlan', function($que) {
            $que->where('plan', "Trial");
        })->count();
        $total_trial_Inactives = UserSubscription::where('active_status', 'inactive')->whereHas('SubscriptionPlan', function($que) {
            $que->where('plan', "Trial");
        })->count();
       
        $subs_purchase_inmonth = UserSubscription::whereBetween('valid_from', [$startOfMonth, $endOfMonth])->count();
        $subs_expire_inmonth = UserSubscription::whereBetween('valid_to', [$startOfMonth, $endOfMonth])->count();

        return response()->json([
            'registered_users' => $registered_users,
            'confirm_user_emails' => $confirm_user_emails,
            'notconfirm_user_emails' => $notconfirm_user_emails,
            'actual_subscritions' => $actual_subscritions,
            'expired_subscritions' => $expired_subscritions,
            'subs_purchase_inmonth' => $subs_purchase_inmonth,
            'subs_expire_inmonth' => $subs_expire_inmonth,
            'total_trial_actives' => $total_trial_actives,
            'total_trial_Inactives' => $total_trial_Inactives 
        ]);
    }

    public function addAdminSetting(Request $request)
    {
        $request->validate([
            'is_trial' => 'required|boolean',
            'no_of_days' => 'required|integer'
        ]);
    
        $existingSetting = AdminSetting::first();
        if ($existingSetting) 
        {
            $existingSetting->update([
                'is_trial' => $request->is_trial,
                'no_of_days' => $request->no_of_days
            ]);
    
            $data = $existingSetting;
        } 
        else {
            $data = AdminSetting::create([
                'is_trial' => $request->is_trial,
                'no_of_days' => $request->no_of_days
            ]);
        }
    
        return response()->json([
            'subscription' => $data,  
            'message' => "Subscription Created/Updated Successfully"  
        ]);
    }

    public function getAdminSetting() 
    {
        $existingSetting = AdminSetting::first();
        if ($existingSetting) {
            return response()->json([
                'subscription' => array_merge(
                    $existingSetting->toArray(),
                    ['is_trial' => $existingSetting->is_trial ? true : false]
                )
            ]);
        } else {
            return response()->json([
                'subscription' => null,
                'message' => "No subscription settings found, default values will be used."
            ]);
        }
    }
}
