<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0; 
        }

        @page {
            size: A4;
            margin: 20mm;
        }

        .content-container {
            background-color: #f2f2f2;
            padding: 20px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
            border-radius: 8px;
        }

        h2 {
            color: #4CAF50;
            text-align: center; 
            font-size: 30px;
        }

        p {
            font-size: 16px;
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        table, th, td {
            border: none;
        }

        th, td {
            padding: 12px;
            text-align: left;
            font-size: 18px;
        }

        hr {
            margin-top: 20px;
            border: 0;
            border-top: 2px solid #ddd;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .content-container {
                margin-top: 20mm;
                margin-bottom: 20mm;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="content-container">
        <h2>Payment Successful!</h2>
        <p>Your payment has been processed. Details of the transaction are included below:</p>
        <hr>
        <p style="text-align: left; margin-left: 10px;">
                <strong style="font-size: 17px;">Dear</strong> {{ $user }},
        </p>

        <table>
            <tr>
                <th>Amount</th>
                <td style="text-align: right;">{{ $amount }}</td>
            </tr>
            <tr>
                <th>Payment Type</th>
                <td style="text-align: right;">{{ $payment_type }}</td>
            </tr>
            <tr>
                <th>Valid Upto</th>
                <td style="text-align: right;">{{ $valid_upto }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
