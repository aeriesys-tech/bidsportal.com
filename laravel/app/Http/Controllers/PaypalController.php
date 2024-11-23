<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Models\UserPayment;
use App\Models\User;
use App\Models\SubscriptionPlans;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{
    public function callPaypalSubscripton(Request $request)
    {
        return view('paypal.Subscription', compact('request'));
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
	       $user_id = substr($item_number, strpos($item_number, "_") + 1); 
	     

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
	            $user = $userSubscriptions = UserSubscription::updateOrcreate([ 
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

	            Log::info(" userSubscriptions  : ".$userSubscriptions); 
	            Log::info("Data inserted in UserSubscriptions : ".print_r($data,true));
	            $subscriptions_count = UserSubscription::where('txn_id', $txn_id)->where('user_id', $user_id)->count();  

	            Log::info(" subscriptions_count  : ".$subscriptions_count); 
	            $subscriptions_details = UserSubscription:: where('txn_id', $txn_id)->where('user_id', $user_id)->orderBy('id', 'DESC')->first();  
	            Log::info("subscriptions_details : ".print_r($subscriptions_details,true));

	            if($subscriptions_count>0)
	            {
	                $data['item_number']=$item_number;
	                $data['order_id']=$subscriptions_details['order_id'];
	                $data['valid_from']=$subscriptions_details['valid_from'];
	                $data['valid_to']=$subscriptions_details['valid_to'];
	                $data['months']=$subscriptions_details['subscr_month'];
	                $data['txn_id']=$txn_id;
	                $data['amount']=$payment_gross;
	                $data['payment_status']=$payment_status;
	                $data['getECResponse']="Success";
	                $data['currency_code']=$currency_code;
	                 
	                if($subscriptions_details->payment_date!='')
	                {
	                    $paymentDateInFormat = date("M d, y", strtotime($subscriptions_details->payment_date));
	                    $data['payment_date']=$paymentDateInFormat;
	                }
	                else
	                {
	                    $data['payment_date']=""; 
	                }
	                $updateData=array(
	                    'subscription_id'=> $subscriptions_details->id,
	                    'status'=>'approved'
	                );
	                $UpdateUserSubscription=User::where('id', $user_id)->update($updateData); 
	                 
	                Log::info("data before call success_page_for_subscription_func : ".print_r($data,true));
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

	            $user = User::where('id', $user_id)->first();

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
	            $data['payment_fee'] = 'temp_payment_fee';
	            $data['mc_currency'] = $currency_code;
	            $data['createdtime']= date("Y-m-d H:i:s");                   

	            $userPayments = UserPayment::create($data); 

	            Log::info(" userPayments inserted  : ".$userPayments); 
	            Log::info("Data inserted in UserPayments : ".print_r($data,true));
	            Log::info("success_page_for_payment_custom will open here");
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

}
