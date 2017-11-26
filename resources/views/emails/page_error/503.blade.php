<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- If you delete this meta tag, Half Life 3 will never be released. -->
    <meta name="viewport" content="width=device-width"/>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>هم‌افزا</title>

    <style>
        * {
            font-family: tahoma;
            color: black;
        }

        *:hover {
            color: #222222;
        }

        *:visited {
            color: #5e5e5e;
        }

        p.callout {
            padding: 15px;
            background-color: #ECF8FF;
            margin-bottom: 15px;
        }

        table.body-wrap {
            width: 100%;
        }

        .container {
            display: block !important;
            max-width: 600px !important;
            margin: 0 auto !important; /* makes it centered */
            clear: both !important;
        }

        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
            max-width: 600px;
            margin: 0 auto;
            display: block;
        }

        .collapse {
            width: 100%;
        }
    </style>

</head>

<body bgcolor="#FFFFFF">

<!-- HEADER -->
<table class="head-wrap" bgcolor="#999999" width="100%" style="background-color: #999999">
    <tr>
        <td></td>
        <td class="header container">

            <div class="content">
                <table bgcolor="#999999">
                    <tr>
                        <td align="right"><h2 style="margin-right: 100px; text-align: center;" class="collapse">هم‌افزا - گزارش خطای 503</h2></td>
                        <td><img style="padding-left: 30px;" src="{{ 'srfatemi.ir/img/hamafza_mail_banner.jpg' }}" /></td>
                    </tr>
                </table>
            </div>

        </td>
        <td></td>
    </tr>
</table><!-- /HEADER -->


<!-- BODY -->
<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" bgcolor="#FFFFFF">

            <div class="content" style="direction: rtl">
                <table>
                    <tr>
                        <td>
                            <h3><span>یک خطای صفحه در وب‌سایت هم‌افزا رخ داده است. شرح گزارش این خطا:</span></h3>
                            <ul>
                                <li><h3> خطای صفحه: {{ $logged_info['error_code'] }}</h3></li>
                                <li><h3> تاریخ خطا: {{ $logged_info['error_date'] }}</h3></li>
                                <li><h3> صفحه خطا: {{ $logged_info['error_route'] }}</h3></li>
                                <li><h3> آی‌پی شخص: {{ $logged_info['client_ip'] }}</h3></li>
                                <li><h3> مرورگر شخص: {{ $logged_info['client_browser'] }}</h3></li>
                                <li><h3> مراجعه از: {{ $logged_info['referrer'] }}</h3></li>
                                @if($logged_info['user_id'] == null)
                                    <li><h3> آی دی کاربر: کاربر مهمان </h3></li>
                                @else
                                    <li><h3> آی دی کاربر: {{ $logged_info['user_id'] }}</h3></li>
                                @endif

                            </ul>
                        </td>
                    </tr>
                </table>
            </div><!-- /content -->

        </td>
        <td></td>
    </tr>
</table><!-- /BODY -->

<!-- FOOTER -->
<table class="footer-wrap">
    <tr>
        <td></td>
        <td class="container">

            <!-- content -->
            <div class="content">
                <table>
                    <tr>
                        <td align="center" style="text-align: center">
                            <p>
                                <a href="{{ route('home') }}">صفحه اصلی</a> |
                                <a href="{{ route('login') }}">ورود به ‌هم‌افزا</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </div><!-- /content -->

        </td>
        <td></td>
    </tr>
</table><!-- /FOOTER -->

</body>
</html>