<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="format-detection" content="Bollore" />
    <meta name="format-detection" content="Bollore" />
    <meta name="format-detection" content="Bollore" />
    <meta name="x-apple-disable-message-reformatting" />
    <title>::Welcome::</title>
</head>

<body
    style="padding: 20px; margin: 0; box-sizing: border-box; background: #ffffff; font-family: 'Proxima Nova Regular';">
    <table cellpadding="0" cellspacing="0" border="0" bgcolor="#fbfbfb">
        <tr>
            <td>
                <p style="color:#000; font-family:Arial; font-size:15pt;">
                  Your OTP code is: {{ $otp }}
                </p>
            </td>
        </tr>
        <tr>
            <td>
                ©
                <?= date("Y"); ?> <b style="font-family: 'Multicolore';">{{ config('app.name', 'eGuests') }}
                    -</b>
                {{ __('All rights reserved')}}
                </p>
            </td>

        <tr>
            <td height="12"></td>
        </tr>
    </table>
</body>

</html>
