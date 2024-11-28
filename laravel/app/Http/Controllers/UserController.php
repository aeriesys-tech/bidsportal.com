<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserSetAside;
use App\Http\resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    public function getUser(Request $request){
    	$data = $reqeust->validate([
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
	    if (!$user)) {
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

	public function register(Request $request)
    {
         $data = $request->validate([
            'name' => 'required|min:3|max:100',
            'email' => 'required|email|max:50|unique:users',		
			'password' => ['required','min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).*$/'],
			'confirm_password' => 'required|same:password',
            'position'=>'required',
			'phone' => 'required|regex:/[0-9]{10}/|digits:10|unique:users',
			'city' => 'required',
			//'address' => 'required',
			'company_name' => 'required',
			'mailing_address' => 'required',
			'web_address' => 'required',
			'zipcode' => 'required',
			'state' => 'required',
			'socioeconomic_status' => 'required',
			'set_asides' => 'required|array',
            'checked' => 'accepted'            
        ]); 

        $user = User::updateOrCreate(
         	[
         		'email' => $data['email']
         	],
         	[
         		'name' => $data['name'],
         		'password' => Hash::make($data['password']),
         		'pw' => $data['password'],
         		'position' => $data['position'],
         		'phone' => $data['phone'],
         		'city' => $data['city'],
         		'company_name' => $data['company_name'],
         		'mailing_address' => $data['mailing_address'],
         		'web_address' => $data['web_address'],
         		'pin_code' => $data['zipcode'],
         		'state' => $data['state'],
         		'status' => false
         	]
        );
        if($user){
        	foreach ($request->set_asides as $set_aside_id) {
        		UserSetAside::updateOrCreate([
        			'user_id' => $user->user_id,
        			'set_aside_id' => $set_aside_id
        		]);
        	}
        }
        return $user;
        //-----------------------------------------------------------------
         // $desc_for_socioeconomic="";
         // $socioeconomic_status_array = explode(',', $request->socioeconomic_status);
         // for($i=0;$i<sizeof($socioeconomic_status_array);$i++)
         // {
         //    if($socioeconomic_status_array[$i]!='nosetaside')
         //    {
         //        $desc=SetAsideStatus::where('status_id','=',$socioeconomic_status_array[$i])->first();            
         //        $desc_for_socioeconomic=$desc_for_socioeconomic.$desc->status_name.",";
         //    }
         // }
         // $desc_for_socioeconomic = rtrim($desc_for_socioeconomic, ',');
         //-----------------------------------------------------------------
         // $data['socioeconomic_status_description'] =$desc_for_socioeconomic;   
         
        
        // $data['password'] = Hash::make($request->password);
      //   if(strcmp($request->password, $request->confirm_password) != 0)
      //   {
      //       return response()->json([
      //           'errors' => [
      //               'confirm_password' => ['The password confirmation does not match'],
      //           ]
      //       ], 422);
      //   }
      //   else
      //   {
      //    $tblUser = TblUser::create($data); 

      //    $msg2 = "<div style='color:#000;'><strong>Please follow the email instructions sent to <span style='color:blue'>$tblUser->email</span> for confirming your registered email address with us</strong></div>";
      //    $data1['msgType']="info";
         
      //    $data['LastId']= $tblUser->id;  
      //    $data['name']= $tblUser->name;  
      //    $data['email']= $tblUser->email;
      //    $data['resetPassLink']= env('APP_URL');
      //    $msg=$this->sendEmailToRegisterUser($data);         
      //    if($msg=="SUCCESS")
      //    {
      //      $data1['msg']=$msg2;
      //    }
      //    else
      //    {
      //      $data1['msg']=$msg;
      //    }
      //    return $this->genToken($tblUser,$data1);        
      // }sssssss
    }

}
