<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Models\UserPayment;
use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Models\CartItem;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionMail;

class PaypalController extends Controller
{
    public function callPaypalSubscripton(Request $request)
    {
        return view('paypal.Subscription', compact('request'));
    }

    public function paypalSubscriptionSuccess(Request $request)
	{
		
		$item_number_user = $request->query('item_number');
		$item_number_arr = explode("_", $item_number_user);
		$item_number = $item_number_arr[0];
		$user_id = $item_number_arr[1];
		UserSubscription::where('user_id', $user_id)->where('active_status', 'like', 'active')->update([ 
            'active_status' => 'inactive'
        ]);
		$order_id_no =$this->getNextSubscriptionOrderId();
        $order_id="BPSB-".$order_id_no."-".date("mdy");
        $subscription_plan = SubscriptionPlan::where('subscription_plan_id', $item_number)->first();
        $subscr_date_from = Carbon::now();
        $subscr_month = $subscription_plan->month;
        $valid_to = $subscr_date_from->copy()->addMonths($subscr_month);
        $update_user_subscription = UserSubscription::updateOrcreate([ 
            'user_id' => $user_id,
            'txn_id' => $request->query('tx')
        ],
        [
            'valid_from' => $subscr_date_from,
            'valid_to' => $valid_to,
            'order_id' => $order_id,
            'payment_method' => 'online',
            'active_status' => 'active',
            'validity' => $subscr_month,
            'item_number' => $item_number,
            'payment_gross' => $request->query('amt'),
            'currency_code' => $request->query('cc'),
            'subscription_plan_id' => $item_number,
            'payer_email' => null,
            'payment_status' => $request->query('st'),
            'subscr_month' => $subscr_month,
            'payment_date' => date('Y-m-d H:i e'),
            'created_date' => date('Y-m-d H:i:s')
        ]); 

        if($update_user_subscription){
        	$user = User::where('user_id', $user_id)->first();
	        if($user && $subscription_plan){
	        	$amount = $subscription_plan->price;
	        	$discount = $subscription_plan->discount;
	        	$subtotal = $amount - $discount;
	        	$data = ([
	        		'amt' => $amount,
	        		'plan' => $subscription_plan->plan,
	        		'order_id' => $order_id,
	        		'txn_id' => $request->query('tx'),
	        		'payment_type' => 'Online',
	        		'tran_date' => date('Y-m-d'),
	        		'tran_time' => date('H:i'),
	        		'subtotal' => $subtotal,
	        		'coupon_discout' => $discount,
	        		'total' => $subtotal
	        	]);
		        Mail::to($user->email)->send(new SubscriptionMail($user, $data));
		    }
        	$valid_upto = $valid_to->format('M d - Y');
        	return Redirect::to(config('app.base_url').'/#/subscription-payment'.'/'.$item_number.'/'.$request->query('amt').'/'.$request->query('tx').'/'.$valid_upto);
        }
	}

    public function paypal_success_common_func()
	{
	    Log::info(" paypal_success_common_func called : "); 
	    if(!empty($_GET['item_number']) && !empty($_GET['tx']) && !empty($_GET['amt']))
	    {
	        $this->data="";       
	       $item_number = $_GET['item_number'];      
	       $txn_id = $_GET['tx'];
	       $payment_gross = $_GET['amt'];
	       $currency_code = $_GET['cc'];
	       $payment_status = $_GET['st'];
	       
	       Log::info(" item_number  : ".$item_number); 
	       Log::info(" txn_id  : ".$txn_id); 
	       Log::info(" payment_gross  : ".$payment_gross); 
	       Log::info(" currency_code  : ".$currency_code); 
	       Log::info(" payment_status  : ".$payment_status); 

	       $IsSubscription=substr($item_number,0,2);
	       $user_id = $_GET('loggedInUserID');
	     

	       if($IsSubscription=="M_" || $IsSubscription=="SA" || $IsSubscription=="Y_" )
	       {
	            Log::info(" ** inside IsSubscription ** "); 
	            $order_id_no =$this->getNextSubscriptionOrderId();
	            $order_id="BPSB-".$order_id_no."-".date("mdy");                
	            Log::info(" order_id  : ".$order_id); 
	               
	            $prices = SubscriptionPlan::where('price', $payment_gross)->first();
	            $subscr_month=$prices['month'];               
	            $subscr_days=$prices['days'];            
	           
	            $subscr_date_from = date("Y-m-d H:i:s");
	            $subscr_date_to = date("Y-m-d H:i:s", strtotime($subscr_date_from. ' + '.$subscr_days.' days'));
	            $custom=167; //required
	            $subscr_id="temp-sub-id";
	            $payer_email="temp-email";
	            $payment_date= date('[Y-m-d H:i e]'); //22:06:22 Jan 09, 2022 PST
	            $created_date =  date("Y-m-d H:i:s");
	            $payment_type="temp-instant";

	           $data = ([ 
	                'user_id' => $user_id,
	                'order_id' => $order_id,
	                'payment_method' => $payment_type,
	                'active_status' => 'active',
	                'validity' => $subscr_month,
	                'valid_from' => $subscr_date_from,
	                'valid_to' => $subscr_date_to,
	                'item_number' => $item_number,
	                'txn_id' => $txn_id,
	                //'ipn_track_id' => $ipn_track_id,
	                'payment_gross' => $payment_gross,
	                'currency_code' => $currency_code,
	                'subscr_id' => $subscr_id,
	                'payer_email' => $payer_email,
	                'payment_status' => $payment_status,
	                'subscr_month' => $subscr_month,
	                'payment_date' => $payment_date,
	                'created_date' => $created_date
	            ]); 
	            $userSubscriptions = UserSubscription::updateOrcreate([ 
	                'user_id' => $user_id,
	                'txn_id' => $txn_id
	            ],
	            [
	                'valid_from' => $subscr_date_from,
	                'valid_to' => $subscr_date_to,
	                'order_id' => $order_id,
	                'payment_method' => $payment_type,
	                'active_status' => 'active',
	                'validity' => $subscr_month,
	                'item_number' => $item_number,
	                'payment_gross' => $payment_gross,
	                'currency_code' => $currency_code,
	                'subscr_id' => $subscr_id,
	                'payer_email' => $payer_email,
	                'payment_status' => $payment_status,
	                'subscr_month' => $subscr_month,
	                'payment_date' => $payment_date,
	                'created_date' => $created_date
	            ]);
	             
	            $user_subscription = UserSubscription:: where('txn_id', $txn_id)->where('user_id', $user_id)->first();

	            if($user_subscription)
	            {
	                $data['item_number'] = $item_number;
	                $data['order_id'] = $user_subscription->order_id;
	                $data['valid_from'] = $user_subscription->valid_from;
	                $data['valid_to'] = $user_subscription->valid_to;
	                $data['months'] = $user_subscription->subscr_month;
	                $data['txn_id'] = $txn_id;
	                $data['amount'] = $payment_gross;
	                $data['payment_status'] = $payment_status;
	                $data['getECResponse'] = "Success";
	                $data['currency_code'] = $currency_code; 

	                return Redirect::to(config('app.base_url').'/#/subscription-payment'.'/'.$data['item_number'].'/'.$data['amount'].'/'.$data['txn_id']);
	            }
	        }
	       else
	       {        
	            Log::info(" ** inside Normal Payment ** "); 
	            $order_id_no =$this->getNextPaymentOrderId();
	            $order_id="BPSB-".$order_id_no."-".date("mdy");                
	            Log::info(" order_id  : ".$order_id); 
	           
	            $item_number = $_GET['item_number'];
	            $txn_id = $_GET['tx'];
	            $payment_gross = $_GET['amt'];
	            $currency_code = $_GET['cc'];
	            $payment_status = $_GET['st'];
	            $user_id=$_GET['cm']; 
	           
	            Log::info(" item_number  : ".$item_number);
	            $IsSubscription=substr($item_number,0,2);
	            Log::info(" IsSubscription  : ".$IsSubscription);

	            $user = User::where('user_id', $user_id)->first();

	            $data['txn_id'] =$txn_id;
	            $data['user_id'] =$user_id;
	            $data['order_id'] =$order_id;
	            $data['payment_amount'] = $payment_gross; 
	            $data['payment_status'] =$payment_status;
	            $data['first_name'] = $user->name;
	            $data['last_name'] = "temp_last_name";
	            $data['business'] = "temp_business";
	            $data['payer_email'] = "temp_payer_email";
	            $data['payer_id'] = "temp_last_payer_id";
	            $data['receiver_email'] = "temp_receiver_email";
	            $data['receiver_id'] = "temp_receiver_id";
	            $data['item_name'] = "temp_item_name";
	            $data['item_number'] = $item_number;
	            $data['payment_date'] = date("Y-m-d H:i:s");
	            $data['payment_gross'] =$payment_gross;
	            $data['payment_fee'] = 0;
	            $data['mc_currency'] = $currency_code;
	            $data['createdtime']= date("Y-m-d H:i:s");                   

	            $userPayments = UserPayment::create($data); 

	            Log::info(" userPayments inserted  : ".$userPayments); 
	            Log::info("Data inserted in UserPayments : ".print_r($data,true));
	            Log::info("success_page_for_payment_custom will open here");
	            $subscription_plan = SubscriptionPlan::where('price', $payment_gross)->first();
	       		$user = User::where('user_id', $user_id)->first();

		       	if($user && $subscription_plan){
		        	$amount = $subscription_plan->price;
		        	$discount = $subscription_plan->discount;
		        	$subtotal = $amount - $discount;
		        	$subscription = ([
		        		'amt' => $amount,
		        		'plan' => $subscription_plan->plan,
		        		'order_id' => $order_id,
		        		'txn_id' => $request->query('tx'),
		        		'payment_type' => 'Online',
		        		'tran_date' => date('Y-m-d'),
		        		'tran_time' => date('H:i'),
		        		'subtotal' => $subtotal,
		        		'coupon_discout' => $discount,
		        		'total' => $subtotal
		        	]);
			        Mail::to($user->email)->send(new SubscriptionMail($user, $subscription));
			    }
	            return Redirect::to(config('app.base_url').'/#/normal-payment/'.$data['txn_id'].'/'.$data['order_id'].'/'.$data['payment_date'].'/'.$data['first_name'].'/'.$data['item_number'].'/'.$data['payment_amount']);
	       }
	    }   
	}

	public function subscriptionCancelpage_func(Request $request)
	{
	    if($request->type=='bids')
	    {
	        return Redirect::to(config('app.base_url').'/#/cart');
	    }
	    else
	    {
	        return Redirect::to(config('app.base_url').'/#/plans_pricing');
	    }
	}

	public function getNextSubscriptionOrderId()
	{
	    $orderId = UserSubscription::max('user_subscription_id') + 1; 
	    $orderIdNo = str_pad($orderId, 5, "0", STR_PAD_LEFT); 
	    return $orderIdNo;
	}

	public function getNextPaymentOrderId()
    {
      	$orderid=UserPayment::max('user_payment_id')+1; 
      	$orderIdNo = str_pad($orderid, 5, "0", STR_PAD_LEFT); 
	    return $orderIdNo;
    }

    public function purchaseTender(Request $request)
    {  
        return view('paypal.PurchaseTender', compact('request'));
    }

    public function paypalPurchaseTenderSuccess(Request $request)
	{
		Log::info(" ** inside Normal Payment ** "); 
            $order_id_no =$this->getNextPaymentOrderId();
            $order_id="BPSB-".$order_id_no."-".date("mdy");                
            Log::info(" order_id  : ".$order_id); 
           
            $txn_id = $_GET['tx'];
            $payment_gross = $_GET['amt'];
            $currency_code = $_GET['cc'];
            $payment_status = $_GET['st'];
            $user_id=$_GET['cm']; 
           
            // Log::info(" item_number  : ".$item_number);
            // $IsSubscription=substr($item_number,0,2);
            // Log::info(" IsSubscription  : ".$IsSubscription);

            $user = User::where('user_id', $user_id)->first();

            $data['txn_id'] =$txn_id;
            $data['user_id'] =$user_id;
            $data['order_id'] =$order_id;
            $data['payment_amount'] = $payment_gross; 
            $data['payment_status'] =$payment_status;
            $data['first_name'] = $user->name;
            $data['last_name'] = "temp_last_name";
            $data['business'] = "temp_business";
            $data['payer_email'] = "temp_payer_email";
            $data['payer_id'] = "temp_last_payer_id";
            $data['receiver_email'] = "temp_receiver_email";
            $data['receiver_id'] = "temp_receiver_id";
            $data['item_name'] = "temp_item_name";
            $data['payment_date'] = date("Y-m-d H:i:s");
            $data['payment_gross'] =$payment_gross;
            $data['payment_fee'] = 0;
            $data['mc_currency'] = $currency_code;
            $data['createdtime']= date("Y-m-d H:i:s");                   

            $user_payment = UserPayment::create($data); 
            $cart_items = CartItem::where('user_id', $user_id)->get();
            foreach ($cart_items as $cart_item) {
            	PurchaseItem::create([
            		'user_payment_id' => $user_payment->user_payment_id,
            		'federal_tender_id' => $cart_item['federal_tender_id'],
            		'state_tender_id' => $cart_item['state_tender_id']
            	]);	
            }
            CartItem::where('user_id', $user_id)->delete();
            return Redirect::to(config('app.base_url').'/#/normal-payment/'.$data['txn_id'].'/'.$data['order_id'].'/'.$data['payment_date'].'/'.$data['first_name'].'/'.$user_payment->user_payment_id);

	}

}
