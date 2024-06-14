<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Password Reset</title>
</head>

<body
    style="
            margin: 0;
            padding: 100px 0;
            background-color: rgba(178, 180, 220, 0.547);
        ">

    <table align="center" cellpadding="0" cellspacing="0" width="80%" style="max-width: 600px;">
        <tr>
            <td bgcolor="aliceblue" style="padding: 40px 20px; border-radius: 20px">
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="left"
                            style="
                                        font-family: Arial, sans-serif;
                                        font-size: 24px;
                                        font-weight: bold;
                                        color: #1d4ed8;
                                        padding-bottom: 20px;
                                    ">
                            Forgot your password?
                        </td>
                    </tr>
                    <tr>
                        <td align="left"
                            style="
                                        font-family: Arial, sans-serif;
                                        font-size: 14px;
                                        color: #444444;
                                        padding-bottom: 20px;
                                    ">
                            We received a request to reset your
                            password. Let's get you a new one!
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <a href="{{ $details['body'] }}"
                                style="
                                            display: inline-block;
                                            background-color: #1d4ed8;
                                            color: white;
                                            padding: 10px 20px;
                                            text-decoration: none;
                                            border-radius: 5px;
                                            margin-bottom: 20px;
                                        ">RESET
                                MY PASSWORD</a>
                        </td>
                    </tr>
                    <tr>
                        <td align="left"
                            style="
                                        font-family: Arial, sans-serif;
                                        font-size: 14px;
                                        color: #444444;
                                        padding-bottom: 20px;
                                    ">
                            If you did not request a password reset, no
                            further action is required.
                        </td>
                    </tr>
                    <tr>
                        <td align="left"
                            style="
                                        font-family: Arial, sans-serif;
                                        font-size: 14px;
                                        color: #444444;
                                    ">
                            If the button does not work, here is the
                            link: <br /><a href="{{ $details['body'] }}"
                                style="color: #1d4ed8">{{ $details['body'] }}</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </center>

    <style>
        @media only screen and (max-width: 600px) {
            table {
                width: 80% !important;
            }

            td[class="reset-button"] {
                padding: 0 10px 20px 10px !important;
            }

            td[class="footer-text"] {
                font-size: 12px !important;
                padding-bottom: 20px !important;
            }
        }
    </style>
</body>

</html>
