<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <style>
        /* Base Resets */
        body { margin: 0; padding: 0; font-family: sans-serif; background-color: #F5F5F5; }
        table { border-spacing: 0; width: 100%; }
        td { padding: 0; }
        img { border: 0; }

        /* Theme Classes (Inline for Email Compatibility) */
        .wrapper { width: 100%; table-layout: fixed; background-color: #F5F5F5; padding-bottom: 60px; }
        .main-table { background-color: #ffffff; margin: 0 auto; width: 100%; max-width: 600px; border-spacing: 0; font-family: sans-serif; color: #333333; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { padding: 40px 40px 20px 40px; text-align: center; }
        .content { padding: 0 40px 40px 40px; text-align: center; }
        .footer { padding: 20px; text-align: center; font-size: 12px; color: #888888; }

        /* Typography & Components */
        h1 { font-family: serif; color: #333333; font-size: 28px; font-weight: bold; margin-bottom: 20px; }
        p { font-size: 16px; line-height: 1.6; color: #555555; margin-bottom: 30px; }

        /* The Button - Rima Style */
        .button {
            display: inline-block;
            background-color: #5c4d42;
            color: #ffffff;
            text-decoration: none;
            padding: 14px 30px;
            border-radius: 9999px; /* Rounded Full */
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 14px;
        }
        .button:hover { background-color: #4a3b32; }
    </style>
</head>
<body>

    <center class="wrapper">
        <table class="main-table" width="100%">
            <tr>
                <td class="header">
                    <h1 style="margin:0;">Rima Girnius</h1>
                </td>
            </tr>

            <tr>
                <td class="content">
                    <h1>Verify Your Email</h1>

                    <p>
                        Hello {{ $user->first_name }},<br>
                        Thank you for registering. To access your digital library and purchase books, please verify your email address.
                    </p>

                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center">
                                <a href="{{ $url }}" class="button" target="_blank">Verify Email Address</a>
                            </td>
                        </tr>
                    </table>

                    <p style="margin-top: 30px; font-size: 14px; color: #999;">
                        If you did not create an account, no further action is required.
                    </p>
                </td>
            </tr>
        </table>

        <div class="footer">
            &copy; {{ date('Y') }} Rima Girnius. All rights reserved.
        </div>
    </center>

</body>
</html>
