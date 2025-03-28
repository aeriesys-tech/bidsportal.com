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

use App\Models\Alert;
use App\Models\AlertKeyword;
use App\Models\FederalAlertNotice;
use App\Models\AlertNaics;
use App\Models\AlertPsc;
use App\Models\AlertState;
use App\Models\AlertSetAside;
use App\Models\FederalAlertAgency;
use App\Models\StateAlertNotice;
use App\Models\AlertCategory;
use App\Models\StateAlertAgency;
use App\Models\PrivateAlertNotice;
use App\Models\PrivateAlertAgency;
use App\Models\InternationalAlertNotice;
use App\Models\InternationalAlertAgency;
use App\Models\StateFilter;
use App\Models\StateFilterKeyword;
use App\Models\StateFilterNotice;
use App\Models\StateFilterState;
use App\Models\StateFilterAgency;
use App\Models\StateFilterCategory;
use App\Models\PrivateFilter;
use App\Models\PrivateFilterKeyword;
use App\Models\PrivateFilterNotice;
use App\Models\PrivateFilterState;
use App\Models\PrivateFilterAgency;
use App\Models\PrivateFilterCategory;
use App\Models\InternationalFilter;
use App\Models\InternationalFilterKeyword;
use App\Models\InternationalFilterNotice;
use App\Models\InternationalFilterState;
use App\Models\InternationalFilterAgency;
use App\Models\InternationalFilterCategory;
use App\Models\FederalFilter;
use App\Models\FederalFilterKeyword;
use App\Models\FederalFilterNotice;
use App\Models\FederalFilterState;
use App\Models\FederalFilterAgency;
use App\Models\FederalFilterStatus;
use App\Models\FederalFilterNaics;
use App\Models\FederalFilterPsc;
use App\Models\UserStateInterest;
use App\Models\UserFederalInterest;
use App\Models\UserPrivateInterest;
use App\Models\UserInternationalInterest;
use App\Models\UserPayment;


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

    public function confirmEmail(Request $request){
        $data = $request->validate([
            'user_id' => 'required|exists:users,user_id'
        ]);
        $user = User::where('user_id', $request->user_id)->update([
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);
        if($user){
            return response()->json([
                'message' => 'Confirm email field updated successfully'
            ]);
        }else{
            return response()->json([
                'message' => 'Unbale to update field'
            ]);
        }
    }

    public function deleteUser(Request $request){
        $data = $request->validate([
            'user_id' => 'required|exists:users,user_id'
        ]);
        $alerts = Alert::where('user_id', $request->user_id)->pluck('alert_id')->toArray();

        try{
            if (!empty($alerts)) {
                AlertKeyword::whereIn('alert_id', $alerts)->delete();
                FederalAlertNotice::whereIn('alert_id', $alerts)->delete();
                AlertNaics::whereIn('alert_id', $alerts)->delete();
                AlertPsc::whereIn('alert_id', $alerts)->delete();
                AlertState::whereIn('alert_id', $alerts)->delete();
                AlertSetAside::whereIn('alert_id', $alerts)->delete();
                FederalAlertAgency::whereIn('alert_id', $alerts)->delete();
                StateAlertNotice::whereIn('alert_id', $alerts)->delete();
                AlertCategory::whereIn('alert_id', $alerts)->delete();
                StateAlertAgency::whereIn('alert_id', $alerts)->delete();
                PrivateAlertNotice::whereIn('alert_id', $alerts)->delete();
                PrivateAlertAgency::whereIn('alert_id', $alerts)->delete();
                InternationalAlertNotice::whereIn('alert_id', $alerts)->delete();
                InternationalAlertAgency::whereIn('alert_id', $alerts)->delete();

                Alert::whereIn('alert_id', $alerts)->delete();
            }

            $state_filters = StateFilter::where('user_id', $request->user_id)->pluck('state_filter_id')->toArray();

            if(!empty($state_filters)){

                StateFilterKeyword::whereIn('state_filter_id', $state_filters)->delete();
                StateFilterNotice::whereIn('state_filter_id', $state_filters)->delete();
                StateFilterState::whereIn('state_filter_id', $state_filters)->delete();
                StateFilterAgency::whereIn('state_filter_id', $state_filters)->delete();
                StateFilterCategory::whereIn('state_filter_id', $state_filters)->delete();
            }



            $federal_filters = FederalFilter::where('user_id', $request->user_id)->pluck('federal_filter_id')->toArray();

            if(!empty($federal_filters)){

                FederalFilterKeyword::whereIn('federal_filter_id', $federal_filters)->delete();
                FederalFilterStatus::whereIn('federal_filter_id', $federal_filters)->delete();
                FederalFilterNotice::whereIn('federal_filter_id', $federal_filters)->delete();
                FederalFilterNaics::whereIn('federal_filter_id', $federal_filters)->delete();
                FederalFilterPsc::whereIn('federal_filter_id', $federal_filters)->delete();
                FederalFilterState::whereIn('federal_filter_id', $federal_filters)->delete();
                FederalFilterSetAside::whereIn('federal_filter_id', $federal_filters)->delete();
                FederalFilterAgency::whereIn('federal_filter_id', $federal_filters)->delete();
            }

            $private_filters = PrivateFilter::where('user_id', $request->user_id)->pluck('private_filter_id')->toArray();

            if(!empty($private_filters)){
                PrivateFilterKeyword::whereIn('private_filter_id', $private_filters)->delete();
                PrivateFilterNotice::whereIn('private_filter_id', $private_filters)->delete();
                PrivateFilterState::whereIn('private_filter_id', $private_filters)->delete();
                PrivateFilterAgency::whereIn('private_filter_id', $private_filters)->delete();
            }

            $international_filters = InternationalFilter::where('user_id', $request->user_id)->pluck('international_filter_id')->toArray();

            if(!empty($international_filters)){
                InternationalFilterKeyword::whereIn('international_filter_id', $international_filters)->delete();
                InternationalFilterNotice::whereIn('international_filter_id', $international_filters)->delete();
                InternationalFilterState::whereIn('international_filter_id', $international_filters)->delete();
                InternationalFilterAgency::whereIn('international_filter_id', $international_filters)->delete();
            }

            UserSubscription::where('user_id', $request->user_id)->delete();
            UserStateInterest::where('user_id', $request->user_id)->delete();
            UserFederalInterest::where('user_id', $request->user_id)->delete();
            UserPrivateInterest::where('user_id', $request->user_id)->delete();
            UserInternationalInterest::where('user_id', $request->user_id)->delete();
            UserSetAside::where('user_id', $request->user_id)->delete();
            UserPayment::where('user_id', $request->user_id)->delete();
            User::where('user_id', $request->user_id)->delete();

            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
    }
}
