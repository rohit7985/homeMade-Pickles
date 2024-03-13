<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Varification</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    body {
        background-color: rgb(225, 223, 210);
        justify-content: center;
        align-items: center;
        display: inline-flex;
        margin: 70px 480px;
    }

    .box {
        width: 600px;
        height: 500px;
        background-color: rgb(181, 131, 228);
        border: 2px solid black;
        border-radius: 20px;
        text-align: center;
        padding: 10px;
    }

    h1,
    h4,
    h5 {
        padding-top: 70px;
    }

    h1 {
        text-decoration: underline;
    }
</style>

<body>
    @if (isset($mailData['otp']))
        <div class="box">
            <h1>Verify Your Account</h1>
            <h4>Hi {{ $mailData['name'] }},</h4>
            <h4>Thank you for choosing us</h4>
            <h5>Use the following OTP to complete the Registration process. OTP is valid for 10 minutes. Do not share
                this code with others.</h5>
            <h4>Your OTP is : {{ $mailData['otp'] }}</h4>
        </div>
    @else
        <div class="box">
            <h3>Account Status Change</h3>
            <h4>Hi {{ $mailData['name'] }},</h4>
            <h5>Your account status are changed! Your account status of varification are @if ($mailData['status'] == '0')
                    Pending
                @elseif($mailData['status'] == '1')
                    Approved
                @elseif($mailData['status'] == '2')
                    Disapproved
                @else
                    Unknown Status
                @endif. </h5>
        </div>
    @endif

</body>

</html>
