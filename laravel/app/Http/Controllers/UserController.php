<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserSetAside;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Mail\FederalTenderMail;
use Illuminate\Support\Facades\Mail;
use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;

class UserController extends Controller
{
    public function getUser(Request $request){
    	$data = $request->validate([
    		'user_id' => 'required'
    	]);
    	$user = User::where('user_id', $request->user_id)->first();
    	return new UserResource($user);
    }

    public function updateUserStatus(){
        $excludedEmails = ['ashfaq@bidsportal.com', 'bnw@mvation.com', 'debbieb@linktechconsulting.com', 'Business@FEDecisionStrategies.com', 'tai.khuu@iisolutionsinc.com', 'david.thomas@stsint.com', 'test-60kbp@mail-tester.com', 'testemail@yahoo.com', 'trialsubscription@yahoo.com', 'tyron.works@wsips.net', 'sendpulse007@gmail.com', 'schimpidi@quadyster.com', 'bizops@quadyster.com', 'dsears@hrtec.net', 'csummerfield@sigsum.com', 'kmemon@dynamiccontractsconsultants.com', 'greg.greening@cdotech.com', 'noreply@bidsportal.com', 'dave@seafront.com', 'Paul.keene@unicomgov.com', 'Dan.Barfield@unicomgov.com', 'adhiman@pricesenz.com', 'Jhondoe90@gmail.com', 'kgrimes@kpgglobal.com', 'ma@guaranteeestimation.net', 'af@guaranteeestimation.com', 'Angus@miatlantic.us', 'subcontractorhenryjames@gmail.com', 'vebit26912@cindalle.com', 'mubashir.bashir@lancesoft.com', 'Paul@digitalestimating.com', 'ajit@aeiresys.com', 'snehal@aeriesys.com', 'soragi4301@flexvio.com', 'falozu@closetab.email', 'terdaletri@gufum.com', 'raj@gmail.com', 'ravi@gmail.com', 'snehal@bidsPortal.com', 'neha.b@gmail.com', 'vrushabh@aeriesys.com', 'wogacel489@giratex.com', 'neha.b@aeriesys.com', 'bharatesh@aeriesys.com', 'example@bidsportal.com', 'wn23@bidsportal.com', 'example123@bidsportal.com', 'example12@bidsportal.com', 'hassanali.constructestimates@gmail.com', 'info@usestimation.com', 'servola@motivatepurpose.com', 'david.cooper@radgov.com', 'ktrotter@quickprotectioninc.com', '5349olivedrive@gmail.com', 'jykim@kerec.co.kr', 'kalyani@aeriesys.com', 'shankar@gmail.com' ];

        User::whereNotIn('email', $excludedEmails)->update(['email_verified_at' => date('Y-m-d H:i:s')]);
    }

    public function getUsers(Request $request){
        return User::get();
    }

    public function changePassword(Request $request)
	{
	    // Validate the input
	    $data = $this->validate($request, [
          'user_id' => 'required',
	        'current_password' => 'required|min:8',
	        'new_password' => 'required|min:8|confirmed', // 'confirmed' ensures new_password == confirm_password
	    ]);

        $user = User::where('email', $request->email)->where('pw', $request->current_password)->first();

	    // $user = User::where('user_id', $request->user_id)->where('password', $request->current_password)->first();
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
	    	'password' => Hash::make($request->new_password),
            'pw' => $request->new_password
	    ]);

	    return response()->json([
	        'message' => ['Password has been successfully updated.']
	    ], 200);
	}

    public function sendMail(){
        $emailData = [
                'name' => 'Ajit K',
                'email' => 'ajit@aeriesys.com',
                'link' => 'test'
            ];
    
        Mail::to('ajit@aeriesys.com')->send(new FederalTenderMail($emailData));
    }

    public function updateUser(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'name' => 'required|string|max:255',
            'mailing_address' => 'required',
            'company_name' => 'required',
            'phone' => 'required',
            'web_address' => 'required',
            'set_asides' => 'required|array'
        ]);

        $user = User::where('user_id', $request->user_id)->first();
        if($user){
            $user->update($data);
            UserSetAside::where('user_id', $request->user_id)->delete();
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
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);
        if($activate_user){
            $user = User::where('user_id', $request->user_id)->first();
            return new UserResource($user);
        }else{
            return response()->json(['error' => 'Unbale to activate'], 422);
        }
    }

    public function updateUserSubscription(){
        $user_subscriptions = UserSubscription::whereNull('valid_from')->get();
        foreach ($user_subscriptions as $key => $user_subscription) {
            $subscription_plan = SubscriptionPlan::where('subscription_plan_id', $user_subscription['subscription_plan_id'])->first();
            if($subscription_plan){
                $valid_from = $user_subscription['created_at'];
                UserSubscription::where('user_subscription_id', $user_subscription['user_subscription_id'])->update([
                    'valid_from' => $user_subscription['created_at'],
                    'valid_to' => $valid_from->copy()->addDays($subscription_plan->days),
                    'validity' => $subscription_plan->days
                ]);

            }
        }
    }
}
