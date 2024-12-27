<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\UserResource;
use App\Models\AdminSetting;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Carbon\Carbon;
use App\Mail\RegistrationEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\UserSetAside;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|same:confirm_password',
            'position' => 'required',
            'confirm_password' => 'required',
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

        $data['pw'] = $data['password'];
        $data['password'] = Hash::make($data['password']);
        $data['pin_code'] = $data['zipcode'];

        $user = User::create($data);
        if($user){
            foreach ($request->set_asides as $set_aside_id) {
                UserSetAside::updateOrCreate([
                  'user_id' => $user->user_id,
                  'set_aside_id' => $set_aside_id
                ]);
            }
            $subscription_plan = SubscriptionPlan::where('plan', 'like', 'Trial')->first();
            if ($subscription_plan && $subscription_plan->is_default) {
                $validity_from = Carbon::today();
                $validity_to = $validity_from->copy()->addDays($subscription_plan->days);
                $user_subscription = UserSubscription::create([
                    'user_id' => $user->user_id,
                    'active_status' => 'active',
                    'validity' => $subscription_plan->days,
                    'validity_from' => $validity_from,
                    'validity_to' => $validity_to,
                    'subscription_plan_id' => $subscription_plan->subscription_plan_id
                ]);
                if($user_subscription){
                    $data['link'] = config('app.url')."/#/bids/state-opportunities/".base64_encode($user->user_id);
                }else{
                    $data['link'] = config('app.url')."/#/subscription_plans/".base64_encode($user->user_id);
                }
            }else{
                $data['link'] = config('app.url')."/#/subscription_plans/".base64_encode($user->user_id);
            }

            $emailData = [
                'name' => $user->name,
                'email' => $user->email,
                'link' => $data['link']
            ];
    
            Mail::to($user->email)->send(new RegistrationEmail($emailData));
        }

        return response()->json([
            'user' => $user
        ]);
    }

    public function resendEmail(Request $request){
        $data = $request->validate([
            'user_id' => 'required'
        ]);
        $user = User::where('user_id', $request->user_id)->first();
        $user_subscription = UserSubscription::where('user_id', $request->user_id)->where('active_status', 'like', 'active')->first();
        if($user_subscription){
            $data['link'] = config('app.url')."/#/bids/state-opportunities/".base64_encode($user->user_id);
        }else{
            $data['link'] = config('app.url')."/#/subscription_plans/".base64_encode($user->user_id);
        }

        if($user){
            $data['LastId'] = $user->user_id;  
            $data['name'] = $user->name;  
            $data['email'] = $user->email;
            $data['resetPassLink'] = config('app.url');
            $msg = $this->sendEmailToRegisterUser($data); 

            return $msg;
        }else{
            return response()->json(['error' => 'User not found']);
        }
    }

    public function sendEmailToRegisterUser($data)
    {
        $html = view('emails.RegisteredUser', $data)->render();

        Mail::send([], [], function ($message) use ($data, $html) {
            $message->to($data['email'], $data['name'])
                ->subject('Confirm Your Email Address - BidsPortal')
                ->setBody($html, 'text/html');
        });
        return "SUCCESS";
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
                'user' => new UserResource($user)
            ]);
        }else{
            return response()->json([
                'errors' => [
                    'email' => ['These credentials do not match our records'],
                ],
                'message' => 'These credentials do not match our records'
            ], 422);
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
