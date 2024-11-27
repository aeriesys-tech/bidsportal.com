@php
    if(config('app.paypal_mode')=='sandbox')
    {
        $paypalID = config('app.paypal_sandbox_id');
        $paypalURL = config('app.paypal_sandbox_url');
    }
    else
    {
        $paypalID = config('app.paypal_live_id');
        $paypalURL = config('app.paypal_live_url');
    }
    $successURL = config("app.url") . "api/paypalPurchaseTenderSuccess";
    $cancelURL = config("app.url") . "api/subscriptionCancelpage_func?type=bids";
    $notifyURL = config("app.url") . "api/paypal_ipn_common_func";

    $loggedInUserID = $request->loggedInUserID;
    $currency_code = "USD";
    $totalITem = $request->totalITem;
    $item_code = $request->item_code;
    $item_total = $request->item_total;
@endphp

    <form name="myform" action="<?php echo $paypalURL; ?>" method = "post" target = "_top">
       <!-- Identify your business so that you can collect the payments. -->
       <input type="hidden" name="business" value="<?php echo $paypalID; ?>">  
       <!-- Specify a Buy Now button. -->
       <input type="hidden" name="cmd" value="_xclick">        
       <!-- Specify details about the item that buyers will purchase. -->
       <input type="hidden" name="item_name" value="<?php echo $totalITem ." items are in cart"; ?>">
       <input type="hidden" name="item_number" value="<?php echo $item_code; ?>">
       <input type="hidden" name="amount" value="<?php echo $item_total; ?>">
       <input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>">  
       <input type="hidden" name="custom" value="<?php echo $loggedInUserID; ?>">    
       <!-- Specify URLs -->
       <input type='hidden' name='cancel_return' value='<?php echo $cancelURL; ?>'>  
       <input type='hidden' name='return' value='<?php echo $successURL; ?>'>
   </form>
<script type="text/javascript">
    document.myform.submit();
</script>