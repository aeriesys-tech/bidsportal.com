<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <style>
            .myfa.fa-facebook {
                background: #3b5998;
                color: #fff;
            }
            .myfa.fa-twitter {
                background: #1da1f2;
                color: #fff;
            }
            .myfa.fa-linkedin {
                background: #544bc2;
                color: #fff;
            }
            .fa-phone {
                background: #808080;
                color: #fff;
                padding: 1px;
                margin-top: 3px;
                font-size: 12px;
                text-decoration: none;
            }
            .myfa.fa-youtube-play {
                background: red;
                color: #fff;
            }
            .fa.myfa {
                margin-top: 3px;
                padding: 5px;
                font-size: 14px;
                width: 14px;
                vertical-align: middle;
                text-decoration: none;
                border-radius: 50%;
                border-color: black;
            }
            .fa {
                display: inline-block;
                font: normal normal normal 14px/1 FontAwesome;
                font-size: inherit;
                text-rendering: auto;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
        </style>
    </head>
<body style="background:#eee;">
    <center style="background-color:#eee; width:100%; " align="center" >
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td style="background: url("https://email19.asia.godaddy.com/download.php?header=635496179&amp;part=2.4&amp;inline=1"); padding-bottom: 25px;" align="center">
                        <table border="0" width="600" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td style="padding: 30px 0px;" align="center">
                                        <table border="0" width="556" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 15px 15px 30px; border-width: 1px 1px 0px; border-top-style: solid; border-right-style: solid; border-left-style: solid; border-top-color: #cccccc; border-right-color: #cccccc; border-left-color: #cccccc; border-image: initial; border-bottom-style: initial; border-bottom-color: initial; border-top-left-radius: 6px; border-top-right-radius: 6px;" align="center" bgcolor="#ffffff">
                                                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding: 0px 0px 20px; font-family: arial; font-size: 18px; line-height: 1.5; color: #000000;" align="center"><a href="'.$BASE_URL.'"><img style="padding: 0px; border-width: 0px; border-style: none; display: block;width: 206px;height: 86px;" src="'.$BASE_URL.'assets/images/BidsPortal_logo.png" alt="BidsPortal" width="70" height="70" /><hr style="width: 50%;margin: 0px;"></a><span style="color: #21e040;font-size: 12px;"><em><b>Subscription Payment Successfull</b></em></span></td>
                                                                </tr>
                                                        </tbody>
                                                    </table>

                                                    <table style=" style="line-height: 0.7em;" height: 146px; margin-bottom: -25px;" border="0" width="520" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                            <tr>
                                                                <td style="padding: 0px 10px 0px; text-align: left;" align="center">
                                                                    <p style="line-height: 0.7em;"><span style="font-family: sans-serif; font-size: 11px; line-height: 18px; color: #787878;">Hi {{ $name }}</span></p>
                                                                    <p style="line-height: 0.7em;"><span style="font-family: sans-serif; font-size: 11px; line-height: 18px; color: #787878;">Thank you for making payment online!&nbsp;</span></p>

                                                                    <p style="margin-top: -16px;"><span style="font-family: sans-serif; font-size: 11px; line-height: 18px; color: #787878;">We\'have received a payment of ${{$amt}} against {{ $plan }} Subscription Plan. </b>&nbsp;</span></p>


                                                                    <span style="font-family: sans-serif; font-size: 11px; line-height: 18px; color: #787878;"><b>Here are the Details:</b>&nbsp;</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table style="line-height: 0.7em;">
                                                        <tr>

                                                            <td style="width: 40%; font-family: sans-serif; font-size: 11px; color: #787878;">Order ID</td>
                                                            <td style="width: 50%; font-family: sans-serif; font-size: 11px;  text-align:left;color: #787878;">{{ $order_id }}</td>
                                                            <td style="width: 10%; font-family: sans-serif; font-size: 11px; color: #787878;">&nbsp;</td>
                                                        </tr>
                                                        <tr>

                                                            <td style=" font-family: sans-serif; font-size: 11px;color: #787878;">Transaction ID</td>
                                                            <td style=" font-family: sans-serif; font-size: 11px;text-align:left; color: #787878;">{{ $txn_id }}</td>
                                                            <td>&nbsp;</td>

                                                        </tr>
                                                        <tr>

                                                            <td style="font-family: sans-serif; font-size: 11px; color: #787878;" >Payment Type</td>
                                                            <td style="font-family: sans-serif; font-size: 11px; text-align:left;color: #787878;">{{ $payment_type }}</td>
                                                            <td >&nbsp;</td>
                                                        </tr>
                                                        <tr>

                                                            <td style="font-family: sans-serif; font-size: 11px; color: #787878;">Transaction Time</td>
                                                            <td style="font-family: sans-serif; font-size: 11px; text-align:left;color: #787878;">{{ $tran_date }} at  {{ $tran_time }}</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        </table>

                                                        <hr>
                                                        <table style="line-height: 1.0em;">
                                                            <tr>
                                                                <td style="width: 70%;">&nbsp;</td>
                                                                <td style="width: 25%; font-family: sans-serif; font-size: 11px; color: #787878;">Subtotal</td>
                                                                <td style="width: 10%; font-family: sans-serif; font-size: 11px; color: #787878; text-align:right">${{$subtotal }}</td>
                                                            </tr>
                                                            <tr>

                                                                <td style="width: 70%; font-family: sans-serif; font-size: 11px; color: #787878;">&nbsp;</td>
                                                                <!--<td style="width: 25%; font-family: sans-serif; font-size: 11px; color: #787878;">Coupon Discount</td>-->
                                                                <td style="width: 25%; font-family: sans-serif; font-size: 11px; color: #787878;">Discount</td>
                                                                <td style="text-align:right; font-family: sans-serif; font-size: 11px; color: #787878;">${{ $discount }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 70%;">&nbsp;</td>
                                                                <td style="width: 25%; font-family: sans-serif; font-size: 11px; color: #000; "><b>Total</b></td>
                                                                <td style="text-align:right;font-family: sans-serif; font-size: 11px; color: #000;">${{ $total }}</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table style="height: 120px; margin-top: -20px;" border="0" width="520" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td style="padding: 20px 10px 0px; text-align: left;" align="center">
                                    <p style="margin:0px;"><span style="font-family: arial; font-size: 12px; line-height: 18px; color: #787878;">Please not that you may need to wait 1-2 minutes before logging in as we finalize your order and complete account activation.</span></p>


                                    <p style="margin:0px;"><span style="font-family: arial; font-size: 12px; line-height: 18px; color: #787878;">If you have any questions, just drop us an email to <a href="mailto:support@bidsportal.com">support@bidsportal.com</a></span></p>
                                    <br>


                                    <p style="margin:0px;"><span style="font-family: arial; font-size: 12px; line-height: 18px; color: #787878;">Thanks!<br>BidsPortal Team</span></p>
                                    <hr style="margin-bottom:0px;">
                                    <p style="margin:0px; text-align:center;"><span style="font-family: arial; font-size: 10px; line-height: 18px; color: #787878;">**<em>This is a sysytem generated email - Please do not reply to it. If you have any queries, please email <a href="mailto:support@bidsportal.com">support@bidsportal.com</a>&nbsp;or call +1 512-588-5101. We are happy to help!</em></span></p>
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
                        <img class="" style="line-height: 0; border: 0px none; padding: 0px; display: block;" src="'.$BASE_URL.'assets/images/mail.png"  alt="" width="600" height="17">
                            <table class="" border="0" width="600" cellspacing="0" cellpadding="0" style="">
                                <tbody class="" style="">
                                    <tr class="" style="">
                                        <td class="" style="background: rgb(246, 246, 246); border-width: 0px 1px 1px; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-color: rgb(204, 204, 204); border-bottom-color: rgb(204, 204, 204); border-left-color: rgb(204, 204, 204); border-image: initial; border-top-style: initial; border-top-color: initial; padding: 20px 0px;" align="center"><a style="line-height: 1.5; font-size: 11px; font-family: Arial; color: rgb(136, 136, 136); text-decoration: none;" href="https://bidsportal.com" target="_blank" class="">www.BidsPortal.com</a></td>
                                    </tr>
                                </tbody>
                            </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </center>
</body>
</html>