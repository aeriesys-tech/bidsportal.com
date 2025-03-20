<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\CartItem;
use App\Models\FederalTender;
use App\Models\StateTender;
use Auth;
use App\Http\Resources\CartItemResource;

class CartItemController extends Controller
{
    public function addCartItem(Request $request){
    	$data = $request->validate([
    		'federal_tender_id' => 'nullable|required_without:state_tender_id',
        	'state_tender_id' => 'nullable|required_without:federal_tender_id',
        	'region' => 'required',
            'user_id' => 'required'
    	]);
    	CartItem::create([
    		'user_id' => $request->user_id,
    		'federal_tender_id' => $data['federal_tender_id'],
    		'state_tender_id' => $data['state_tender_id'],
    		'region' => $data['region'],
    		'cart_item_date' => now()
    	]);
	    
    }

    public function getCartItemsCount(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required'
        ]);

        $cutoff_date = Carbon::now()->subDays(30);

        $cart_items_count = CartItem::where('user_id', $request->user_id)
            ->where('cart_item_date', '>=', $cutoff_date)
            ->count();

        $federal_fees = FederalTender::whereHas('CartItem', function ($que) use ($request, $cutoff_date) {
            $que->where('user_id', $request->user_id)
                ->where('cart_item_date', '>=', $cutoff_date);
        })->sum('fees');

        $state_fees = StateTender::whereHas('CartItem', function ($que) use ($request, $cutoff_date) {
            $que->where('user_id', $request->user_id)
                ->where('cart_item_date', '>=', $cutoff_date);
        })->sum('fees');

        $federal_fees = $federal_fees ?? 0;
        $state_fees = $state_fees ?? 0;
        $total = $federal_fees + $state_fees;

        return response()->json([
            'items' => $cart_items_count,
            'total' => $total,
        ]);
    }


    public function getCartItems(Request $request){
        $data = $request->validate([
            'user_id' => 'required'
        ]);    	

        $cutoff_date = Carbon::now()->subDays(30);
    	$cart_items = CartItem::where('user_id', $request->user_id)->where('cart_item_date', '>=', $cutoff_date)->get();
    	return CartItemResource::collection($cart_items);
    }

    public function removeCartItem(Request $request){
    	$data = $request->validate([
    		'cart_item_id' => 'required'
    	]);
    	return CartItem::where('cart_item_id', $request->cart_item_id)->delete();
    }

    public function clearCart(Request $request){
        $data = $request->validate([
            'user_id' => 'required'
        ]);  
        return CartItem::where('user_id', $request->user_id)->delete();
    }
}
