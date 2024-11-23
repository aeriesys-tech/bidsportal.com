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
    $successURL = config("app.url") . "/api/paypal_success_common_func";
    $cancelURL = config("app.url") . "/api/subscriptionCancelpage_func?type=subscription";
    $notifyURL = config("app.url") . "/api/paypal_ipn_common_func";

    $loggedInUserID = $request->loggedInUserID;
    $itemName = $request->itemName;
    $itemNumber = $request->itemNumber;
    $currency_code = "USD";
    $paypalAmt = $request->paypalAmt;
    $paypalValid = $request->paypalValid;
@endphp

<form name="myform" action="<?php echo $paypalURL; ?>" method = "post" >
    <input type="hidden" name="business" value="<?php echo $paypalID; ?>">
    <input type="hidden" name="cmd" value="_xclick-subscriptions">
    <input type="hidden" name="item_name" value="<?php echo $itemName; ?>">
    <input type="hidden" name="item_number" value="<?php echo $itemNumber; ?>">
    <input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>">
    <input type="hidden" name="a3" id="paypalAmt" value="<?php echo $paypalAmt; ?>">
    <input type="hidden" name="p3" id="paypalValid" value="<?php echo $paypalValid; ?>">
    <input type="hidden" name="t3" value="M">
    <input type="hidden" name="custom" value="<?php echo $loggedInUserID; ?>">
    <input type="hidden" name="cancel_return" value="<?php echo $cancelURL; ?>">
    <input type="hidden" name="return" value="<?php echo $successURL; ?>">
    <input type="hidden" name="notify_url" value="<?php echo $notifyURL; ?>">
</form>

<script type="text/javascript">
    document.myform.submit();
</script>

<!--
Email: nazim.buyer1@yahoo.com
Pswd: login123
-->