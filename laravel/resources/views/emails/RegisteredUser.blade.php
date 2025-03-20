<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Your Email</title>
</head>
<body style="background: #f9f9f9; font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; background: #ffffff; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <div style="text-align: center;">
            <img src="https://bidsportal.com/images/logo.png" alt="BidsPortal" style="width: 150px; height: auto;">
            <hr style="margin: 20px 0;">
        </div>
        <p>Hi {{ $data['name'] }},</p>
        <p>Thank you for joining BidsPortal! We're excited to have you on board. To finish signing up, please confirm that we got your email right.</p>
        <p style="text-align: center;">
            <a href="{{ $data['link'] }}" style="background: #21e040; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Confirm Email</a>
        </p>
        <p>If you have any questions, feel free to email us at <a href="mailto:support@bidsportal.com">support@bidsportal.com</a>.</p>
        <p>Thanks!<br>BidsPortal Team</p>
        <hr>
        <p style="font-size: 12px; color: #888;">This is an automated message. Please do not reply.</p>
    </div>
</body>
</html>
