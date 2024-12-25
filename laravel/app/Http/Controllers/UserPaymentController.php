<?php

namespace App\Http\Controllers;
use App\Models\UserPayment;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use App\Http\Resources\UserPaymentResource;
use Auth;
use PDF;

class UserPaymentController extends Controller
{
    public function getUserPayment(Request $request){
    	$user_payment = UserPayment::where('user_payment_id', $request->user_payment_id)->first();
    	return new UserPaymentResource($user_payment);
    }

    public function getUserPayments(Request $request){
        $data = $request->validate([
            'user_id' => 'required'
        ]);
    	$user_payments = UserPayment::where('user_id', $request->user_id)->get();
		return UserPaymentResource::collection($user_payments);
    }

    public function generateSubscriptionPdf(Request $request)
    {
        // $request->validate([
        //     'user_id' => 'required|exists:users,user_id'
        // ]);

        // $subscriptions = UserSubscription::where('user_id', $request->user_id)->where('txn_id', $request->txn_id)->orderBy('created_at', 'desc')->first();
        $subscriptions = UserSubscription::where('user_id', $request->user_id)->orderBy('created_at', 'desc')->first();
        $data = [
            'user' => $subscriptions->User->name,
            'amount' => $subscriptions->payment_gross,
            'payment_type' => $subscriptions->payment_method,
            'valid_upto' => $subscriptions->valid_to,
            // 'user' => "Sammed Teerth",
            // 'amount' => 365,
            // 'payment_type' => "Online",
            // 'valid_upto' => "2025-01-25",
        ];

        $pdf = PDF::loadView('subscription_pdf', $data);
        return $pdf->download('subscription_receipt.pdf');
    }
}
