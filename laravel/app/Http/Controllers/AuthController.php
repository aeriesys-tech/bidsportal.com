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

class AuthController extends Controller
{
    // Register a new user
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
            $data['LastId'] = $user->user_id;  
            $data['name'] = $user->name;  
            $data['email'] = $user->email;
            $data['resetPassLink'] = config('app.url');
            $msg = $this->sendEmailToRegisterUser($data); 
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

        //    $email1="brosissoft@gmail.com";   
        //    $name="Olya Kuharuk";
        //    $lastID="191";

        $email = $data['email'];
        $name = $data['name'];
        $lastID = $data['LastId'];
        $link = $data['link'];


        $API_USER_ID = "8a9e82cd3ee45365c3469c0bb743ec4f";
        $API_SECRET = "49ecf3e11bab7b32af9360eba7ddb2c7";
        $BASE_URL = config('app.url')."/";
        

        //$link = $SITE_URL.'activate?id=' .base64_encode($lastID);
        

        //$SPApiClient = new ApiClient($API_USER_ID, $API_SECRET, new FileStorage()); //not require in laravel
        //define('PATH_TO_ATTACH_FILE', __FILE__);
        $htmlPart ='
        <body style="background:#eee;">

        <center style="background-color:#eee; width:100%; " align="center" >
        <!--<div class="innerViewContainer" style="overflow: hidden; display: block; height: 596px;">
        <div class="email-overflow">
        <div class="email-subject">
        <div id="actionItem_flag" class="message-body-mark bravoimg Mail_Image_Rich_Desktop_icon-star-disabled_png">&nbsp;</div>

        </div>
        <div class="email-scrolling" style="height: 553px;">

        <div id="msgOuterContainer" class="email-content-wrap">
        <div id="messageBody" class="email-content">
        <div class="messageBody" style="width: auto; height: auto;">-->
        <table border="0" width="100%" cellspacing="0" cellpadding="0" style="table-layout: fixed;">
        <tbody>
        <tr>
        <td style="background: url("https://email19.asia.godaddy.com/download.php?header=635496179&amp;part=2.4&amp;inline=1"); padding-bottom: 25px;" align="center"><!-- Letter -->
        <table border="0" width="600" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
        <td style="padding: 30px 0px;" align="center"><!-- Letter -->
        <table border="0" width="556" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
        <td style="padding: 15px 15px 30px; border-width: 1px 1px 0px; border-top-style: solid; border-right-style: solid; border-left-style: solid; border-top-color: #cccccc; border-right-color: #cccccc; border-left-color: #cccccc; border-image: initial; border-bottom-style: initial; border-bottom-color: initial; border-top-left-radius: 6px; border-top-right-radius: 6px;" align="center" bgcolor="#ffffff"><!-- Logo -->
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
        <td style="padding: 0px 0px 20px; font-family: arial; font-size: 18px; line-height: 1.5; color: #000000;" align="center"><a href="'.$BASE_URL.'"><img style="padding: 0px; border-width: 0px; border-style: none; display: block;width:150px;" src="https://bidsportal.com/storage/images/logo.png" alt="BidsPortal" height="70" /><hr style="width: 50%;margin: 0px;"></a><span style="color: #21e040;font-size: 12px;"><em><b>Welcome to Bidsportal</b></em></span></td>
        </tr>
        </tbody>
        </table>

        <table style="height: 146px;" border="0" width="520" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
        <td style="padding: 0px 10px 0px; text-align: left;" align="center">
        <p><span style="font-family: arial; font-size: 12px; line-height: 18px; color: #787878;">Hi '.$name.',</span></p>
        <p><span style="font-family: arial; font-size: 12px; line-height: 18px; color: #787878;">Thank you for joining BidsPortal we are excited to have you on board. To finish signing up, you just need to confrm that we got your email right.&nbsp;</span></p>
        <p><span style="font-family: arial; font-size: 12px; line-height: 18px; color: #787878;">To confirm your email, Please click this link:</span></p>
        </td>
        </tr>
        <tr>
        <td style="padding: 10px 60px 0px;" align="center">
        <table style="height: 25px;" border="0" width="186" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
        <td style="padding: 0px; border-radius: 5px; background: #21e040;" align="center" width="184" height="40"><a style="vertical-align: middle; width: 184px; height: 40px; display: inline-block; font-family: arial; font-size: 14px; line-height: 40px; color: #ffffff; font-weight: bold; text-decoration: none; " href='.$link.' target="_blank"> CONFIRM EMAIL</a></td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>

        <table style="height: 120px;" border="0" width="520" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
        <td style="padding: 20px 10px 0px; text-align: left;" align="center">
        <p style="margin:0px;"><span style="font-family: arial; font-size: 12px; line-height: 18px; color: #787878;">If you have any questions, just drop us an email to <a href="mailto:support@bidsportal.com">support@bidsportal.com</a></span></p>
        <br>
        <p style="margin:0px;"><span style="font-family: arial; font-size: 12px; line-height: 18px; color: #787878;">Thanks!<br>BidsPortal Team</span></p>
        <hr style="margin-bottom:0px;">
        <p style="margin:0px; text-align:center;"><span style="font-family: arial; font-size: 10px; line-height: 18px; color: #787878;">**<em>This is a sysytem generated email - Please do not reply to it. If you have any queries, please email <a href="mailto:support@bidsportal.com">support@bidsportal.com</a>&nbsp;or call (913)232-2255. We are happy to help!</em></span></p>
        </td>
        </tr>

        </tbody>
        </table>

        </td>
        </tr>
        </tbody>
        </table>

        <table class="" border="0" width="600" cellspacing="0" cellpadding="0" style="">
        <tbody class="" style="">
        <tr class="" style="">
        <td style="line-height: 0;" align="center" class="">
        <img class="" style="line-height: 0; border: 0px none; padding: 0px; display: block;" src="https://bidsportal.com/storage/images/mail.png"  alt="" width="600" height="17">
         <table class="" border="0" width="600" cellspacing="0" cellpadding="0" style="">
        <tbody class="" style="">
        <tr class="" style="">
        <td class="" style="background: rgb(246, 246, 246); border-width: 0px 1px 1px; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-color: rgb(204, 204, 204); border-bottom-color: rgb(204, 204, 204); border-left-color: rgb(204, 204, 204); border-image: initial; border-top-style: initial; border-top-color: initial; padding: 20px 0px;" align="center"><a style="line-height: 1.5; font-size: 11px; font-family: Arial; color: rgb(136, 136, 136); text-decoration: none;" href="https://bidsportal.com" target="_blank" class="">www.bidsportal.com</a></td>
        </tr>
        </tbody>
        </table> 
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        <center>
        </body>
        ';

        $request = array(
            'html' => $htmlPart,
            'text' => '',
            'subject' => 'Confirm Your Email Address - BidsPortal ',
            'from' => array(
                'name' => 'BidsPortal',
                'email' => 'support@bidsportal.com'
            ),
            'to' => array(
                array(
                    'name' => $name,
                    'email' => $email
                )
            ),
            /*'bcc' => array(
                array(
                    'name' => 'Notifications',
                    'email' => 'notifications@bidsportal.com'
                )
            )*/
            /*
            'attachments' => array(
                'file.txt' => file_get_contents(PATH_TO_ATTACH_FILE),
            ),*/
        );
        //var_dump($SPApiClient->smtpSendMail($request));

        $msg="";
        try
        {
            
            //$retval = $SPApiClient->smtpSendMail($request);//codeigniter
            //$retval = app('SendPulse')->smtpSendMail($request) //in laravel 8

            $retval = app('SendPulse')->smtpSendMail($request);
            print_r($retval);
            $retval=json_decode(json_encode($retval),true);
            //print_r($retval);
            //echo "<br>".$retval['result'];
            if ($retval['result']==1)
            {
                $msg="SUCCESS";
            }
            else
            { 
                $msg="Contact to administator";
            }
        }
        catch(Exception $e)
        {
        $msg=$e->getMessage();
        }
        return $msg;
        //echo $msg;
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
