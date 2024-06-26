<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title>Welcome Email</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,500" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">

    <style>
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        table table table {
            table-layout: auto;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        *[x-apple-data-detectors],
        /* iOS */
        .x-gmail-data-detectors,
        /* Gmail */
        .x-gmail-data-detectors *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }

        img.g-img+div {
            display: none !important;
        }

        /* What it does: Prevents underlining the button text in Windows 10 */
        .button-link {
            text-decoration: none !important;
        }

        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            .email-container {
                min-width: 375px !important;
            }
        }
    </style>
    <style>
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }

        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }

        /* Media Queries */
        @media screen and (max-width: 480px) {
            .fluid {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }

            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }

            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }

            table.center-on-narrow {
                display: inline-block !important;
            }

            .email-container p {
                font-size: 17px !important;
                line-height: 22px !important;
            }
        }
    </style>
</head>

<body width="100%" bgcolor="#F1F1F1" style="margin: 0; mso-line-height-rule: exactly;">
    <center style="width: 100%; background: #F1F1F1; text-align: left;">
        <div
            style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">
        </div>
        <div style="max-width: 680px; margin: auto;" class="email-container">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%"
                style="max-width: 680px;" class="email-container">
                <tr>
                    <td bgcolor="#333333">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td style="padding: 30px 40px 30px 40px; text-align: center;"> <span
                                        style="color:#fff; font-size: 30px">Market Place Connect</span> </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td background="https://cdn.create.vista.com/api/media/small/296407238/stock-photo-empty-small-shopping-cart-bright-orange-background"
                        bgcolor="#222222" align="center" valign="top"
                        style="text-align: center; background-position: center center !important; background-size: cover !important;">
                        <div>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center"
                                width="100%" style="max-width:500px; margin: auto;">
                                <tr>
                                    <td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center" valign="middle">
                                        <table>
                                            <tr>
                                                <td valign="top"
                                                    style="text-align: center; padding: 60px 0 10px 20px;">
                                                    <h1
                                                        style="margin: 0; font-family: 'Montserrat', sans-serif; font-size: 30px; line-height: 36px; color: #202126; font-weight: bold;">
                                                        WELCOME {{ $user->name }},</h1>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top"
                                                    style="text-align: center; padding: 10px 20px 15px 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #404040;">
                                                    <p style="margin: 0;" class="justify-center">
                                                        Welcome to Market Place Connect! We're thrilled to
                                                        have you join our community of savvy shoppers.

                                                        At Market Place Connect, we're committed to providing
                                                        you with an exceptional shopping experience, offering a wide
                                                        range of high-quality products at competitive prices.

                                                        As a new member, you now have access to:

                                                        A diverse selection of products from leading brands.
                                                        Secure and seamless online shopping.
                                                        Exclusive discounts and promotions.
                                                        Fast and reliable delivery to your doorstep.
                                                        To start exploring our collection, simply log in to your account
                                                        using the email address and password you provided during
                                                        registration. If you have any questions or need assistance, our
                                                        dedicated customer support team is here to help.

                                                        Thank you for choosing Market Place Connect! We look
                                                        forward to serving you and making your online shopping
                                                        experience enjoyable and convenient.

                                                        Happy shopping!
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" align="center"
                                                    style="text-align: center; padding: 15px 0px 60px 0px;">
                                                    <center>
                                                        <table role="presentation" align="center" cellspacing="0"
                                                            cellpadding="0" border="0" class="center-on-narrow"
                                                            style="text-align: center;">
                                                            <tr>

                                                                <td style="border-radius: 50px; background: #26a4d3; text-align: center;"
                                                                    class="button-td"> <a
                                                                        href="{{ route('customerLogin') }}"
                                                                        style="background: #26a4d3; border: 15px solid #26a4d3; font-family: 'Montserrat', sans-serif; font-size: 14px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 50px; font-weight: bold;"
                                                                        class="button-a"> <span style="color:#ffffff;"
                                                                            class="button-link">&nbsp;&nbsp;&nbsp;&nbsp;ACCESS
                                                                            ACCOUNT&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                        </table>
                                                    </center>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td style="padding: 40px 40px 20px 40px; text-align: left;">
                                    <h1
                                        style="margin: 0; font-family: 'Montserrat', sans-serif; font-size: 20px; line-height: 26px; color: #333333; font-weight: bold;">
                                        YOUR ACCOUNT IS NOW ACTIVE</h1>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="padding: 0px 40px 20px 40px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; text-align: left; font-weight:bold;">
                                    <p style="margin: 0;">Thanks for choosing our product.</p>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr> <!-- INTRO : END -->
                <!-- CTA : BEGIN -->
                <tr>
                    <td bgcolor="#26a4d3">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td style="padding: 40px 40px 5px 40px; text-align: center;">
                                    <h1
                                        style="margin: 0; font-family: 'Montserrat', sans-serif; font-size: 20px; line-height: 24px; color: #ffffff; font-weight: bold;">
                                        YOUR FEEDBACK MOTIVATE US TO MOVE AHEAD</h1>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="padding: 0px 40px 20px 40px; font-family: sans-serif; font-size: 17px; line-height: 23px; color: #aad4ea; text-align: center; font-weight:normal;">
                                    <p style="margin: 0;">Let us know what you think of our product</p>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <br>


                            <tr>
                                <td
                                    style="padding: 0px 40px 10px 40px; font-family: sans-serif; font-size: 12px; line-height: 18px; color: #666666; text-align: center; font-weight:normal;">
                                    <p style="margin: 0;">This email was sent to you from Market_Place_Connect</p>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="padding: 0px 40px 40px 40px; font-family: sans-serif; font-size: 12px; line-height: 18px; color: #666666; text-align: center; font-weight:normal;">
                                    <p style="margin: 0;">Copyright &copy; {{ date('Y') }} <b>Market Place
                                            Connect</b>,
                                        All Rights Reserved.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </center>
</body>

</html>
