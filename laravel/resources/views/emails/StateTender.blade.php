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
    <body style="background: #eee;" align="center">
        <center style="background-color: #eee; width: 100%;" align="center">
            <div style="background-color: #eee; width: 100%;" align="center">
                <table border="0" width="100%" cellspacing="0" cellpadding="0" style="table-layout: fixed;">
                    <tbody>
                        <tr>
                             <td style="padding: 0px 0px;" align="center">
                                <table border="0" width="920" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td style="padding: 8px;" align="center">
                                                <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                        <tr>
                                                            <td style="padding: 0px 0px 0px; text-align: left;">
                                                                <a href="https://bidsportal.com/#/bids" target="_blank" style="padding: 2px; color: #fff; background: #21e040; font-size: 12px; border: 1px solid #21e040; border-radius: 5px; padding: 5px;">
                                                                    View All
                                                                </a>
                                                            </td>
                                                            <td style="padding: 0px 0px 0px; font-family: arial; font-size: 12px; text-align: right; line-height: 1.5; color: #000;" align="center">
                                                                <img src="{{ $images['phone'] }}" class="imgcol" style="width: 15px;">&nbsp; (913)232-2255 
                                                                <img src="{{ $images['mail_png']}}" class="imgcol" style="width: 15px;">&nbsp; support@bidsportal.com
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 0px 0px;" align="center">
                                <table border="0" width="556" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td
                                                style="border-radius: 20px; overflow: hidden; border-image: initial; border-bottom-style: initial; border-bottom-color: initial; border-top-left-radius: 16px; border-top-right-radius: 16px;"
                                                align="center"
                                                bgcolor="#ffffff"
                                            >
                                                <table style="height: 146px; margin-top: -18px;" width="600" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                        <tr style="background-color: #e4d5d599;">
                                                            <td style="padding: 0px 0px;" align="center">
                                                                <table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-bottom: 1px solid #ddd;">
                                                                    <tbody style="background-color: #fdffff;">
                                                                        <tr>
                                                                            <td style="padding: 0px 12px 0px; text-align: left;"><img src="{{ $images['share'] }}" class="imgcol" style="width: 40px; height: 40px;" /></td>
                                                                            <td style="width: 700px; font-family: sans-serif; font-size: 14px; line-height: 20px; font-weight: 500;">
                                                                                BidsPortal Team,<br />
                                                                                <a style="font-weight: 400; font-size: 16px;"> Has Shared this with you! </a>
                                                                            </td>
                                                                            <td style="padding: 0px; font-family: sans-serif; font-size: 12px; line-height: 1.5; color: #000000;" align="center">
                                                                                <a href="#">
                                                                                    <img style="padding: 25px 12px 25px; border-width: 0px; border-style: none; display: block; width: 150px;" src="{{ $images['logo'] }}" alt="BidsPortal" width="25%" />
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="3"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 15px 30px 0px; text-align: left;" align="center">
                                                                <span style="font-family: sans-serif; font-size: 13px; line-height: 18px; color: #505050; white-space: pre;"><b>Comments: </b> {{ $request->message }}</span>
                                                            </td>
                                                        </tr>
                                                        @foreach($bids as $bid)
                                                            @php $bid_details = $bid->StateTenderDetails() @endphp
                                                            <tr>
                                                                <td style="padding: 10px 30px 10px;" align="center">
                                                                    <table style="height: 82px; border: 1px solid #eee; padding: 5px;" width="850" cellspacing="0" cellpadding="3">
                                                                        <tr style="padding-bottom: 10px;">
                                                                            <td colspan="4">
                                                                                <b style="color: #99cc00; font-size: 16px; font-family: sans-serif;">
                                                                                    <a href="https://bidsportal.com/#/bids" style="color: #02c459;" target="_blank">
                                                                                        {{ $bid->tender_no }} :: {{ $bid->title }}
                                                                                    </a>
                                                                                </b>
                                                                            </td>
                                                                        </tr>
                                                                        <tr style="padding-bottom: 10px;">
                                                                            <td style="width: 35%;">
                                                                                <span style="font-size: 13px; font-family: sans-serif;">
                                                                                    <img src="{{ config('app.base_url') }}/storage/images/cal.png" style="max-height: 13px; vertical-align: middle; image-rendering: pixelated;" />
                                                                                    <b>
                                                                                        <a style="color: #626262;"> Posted : </a>
                                                                                    </b>
                                                                                    {{ date('d M, Y', strtotime($bid->posted_date)) }}
                                                                                </span>
                                                                            </td>
                                                                            <td style="width: 42%;">
                                                                                <span style="font-size: 13px; font-family: sans-serif;">
                                                                                    <img src="{{ config('app.base_url') }}/storage/images/cal.png" style="max-height: 13px; vertical-align: middle; image-rendering: pixelated;" />
                                                                                    <b>
                                                                                        <a style="color: #626262;"> Expired : </a>
                                                                                    </b>
                                                                                    {{ date('d M, Y', strtotime($bid->expiry_date)) }}
                                                                                </span>
                                                                            </td>
                                                                            <td style="width: 0%;"></td>
                                                                            <td style="width: 23%;">
                                                                                <span style="font-family: sans-serif; font-size: 13px;">
                                                                                    <b>
                                                                                        <a style="color: #626262;"> Files : </a>
                                                                                    </b>
                                                                                    <span style="color: #3997ff;">
                                                                                        <a target="_blank" href="{{ config('app.url').'downloadStateAttachments/'.$bid->state_tender_id }}">
                                                                                            Download Attachments
                                                                                        </a>
                                                                                    </span>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr style="padding-bottom: 10px;">
                                                                            <td colspan=4>
                                                                                <span style="font-size: 13px; font-family: sans-serif;">
                                                                                    <img src="{{ config('app.base_url') }}/storage/images/notice-type.png" style="max-height: 12px; vertical-align: middle; image-rendering: pixelated;" />
                                                                                    <b>
                                                                                        <a style="color: #626262;"> Notice Type : {{ $bid_details['notice'] }}</a>
                                                                                    </b>
                                                                                    
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr style="padding-bottom:10px;">
                                                                            <td colspan=4>
                                                                                <span style="font-size: 13px;font-family: sans-serif;">
                                                                                    <img src="{{ config('app.base_url') }}/storage/images/agency.png" style="max-height: 13px;vertical-align:middle;image-rendering: pixelated;">
                                                                                    <b>
                                                                                        <a style="Color: #626262;">  Agency Link : </a>
                                                                                    </b>
                                                                                    <a target="_blank" href="{{ $bid_details['tender_url'] }}" style="color:#3997ff; font-size: 13px;font-family: sans-serif;">
                                                                                        {{ $bid_details['tender_url']}}
                                                                                    </a>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr style="padding-bottom: 10px;">
                                                                            <td colspan="4">
                                                                                <br />
                                                                                <span class="text" style="font-size: 13px;font-family: sans-serif; font-style: italic; color: #808080">
                                                                                    <img src="{{ config('app.base_url') }}/storage/images/description.png" style="max-height: 12px; vertical-align: text-bottom; image-rendering: pixelated; line-height: 0.9;" />
                                                                                    <b> Description : </b><br>
                                                                                    {!! \Illuminate\Support\Str::limit($bid->description, 300, $end='...') !!}
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        
                                                                        <tr>
                                                                            <td colspan="3">
                                                                                <span style="font-size: 13px; font-family: sans-serif;">
                                                                                    <img src="{{ $images['location'] }}" style="max-height: 12px; vertical-align: middle; image-rendering: pixelated;" /><b><a style="color: #626262;"> Location : </a></b>
                                                                                    {{ $bid_details['place_of_performance'] }}
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        
                                                                        <tr style="padding-bottom: 10px; line-height: 1.8;">
                                                                            <td colspan="3">
                                                                                <span style="font-size: 13px; font-family: sans-serif;">
                                                                                    <img src="{{ $images['category'] }}" style="max-height: 12px; vertical-align: middle; image-rendering: pixelated;" /><b><a style="color: #626262;"> Category : {{ $bid_details['category']}}</a></b>
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                       
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td style="padding: 0px 45px 0px; text-align: left;" align="center">
                                                                <span style="font-family: sans-serif; font-size: 11px; color: #787878;">
                                                                    DO NOT FORWARD this message to unauthorized user or another person outside of your company. This information is only intended for the recipient shown at {{ $user->company_name }}.
                                                                </span>
                                                                <br />
                                                                <br />
                                                                <span style="font-family: sans-serif; font-size: 10px; color: #787878;">Please Note : This email message was sent from notification-only address that cannot accept incoming email. Please do not reply to this email.</span>

                                                                <br />
                                                                <hr style="width: 50%; border: 0.5px solid #ddd;" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: center;">
                                                                <span>
                                                                    <a href="https://facebook.com/bidsportal" target="_blank"><img src="{{ $images['facebook'] }}" class="imgcol" style="width: 25px; height: 25px;"></a>
                                                                    <a href="https://twitter.com/BidsPortal" target="_blank"><img src="{{ $images['twitter'] }}" class="imgcol" style="width: 25px; height: 25px;"></a>
                                                                    <a href="https://linkedin.com/company/bidsportal" target="_blank"><img src="{{ $images['twitter'] }}" class="imgcol" style="width: 25px; height: 25px;"></a>
                                                                    <a href="mailto:support@bidsportal.com" target="_blank"><img src="{{ $images['mail'] }}" class="imgcol" style="width: 25px; height: 25px;"></a>
                                                                </span>
                                                                <br />
                                                                <br />
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table width="920">
                                    <tr>
                                        <td>
                                            <p style="margin: 10px; text-align: center; font-family: sans-serif; font-size: 12px; color: #787878;">
                                                You are receiving this mail because {{ $user->name }} shared this with you on Bidsportal.
                                            </p>
                                            <p style="margin: 10px; text-align: center; font-family: sans-serif; font-size: 12px; color: #787878;">
                                                To keep this email coming, add <span style="color: 3997ff;"><strong>BidsPortal Alert </strong></span> to your address book.
                                            </p>
                                            <p style="margin-top: 15px; text-align: center; font-family: sans-serif; font-size: 14px; color: #333;">
                                                Copyrights ©2018 - 2024. All rights reserved | BidsPortal
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </center>
    </body>
</html>
