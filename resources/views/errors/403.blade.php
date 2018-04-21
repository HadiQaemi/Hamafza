@extends('layouts.errors.index')
@section('specific_plugin_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/error_pages.css')}}">
@stop
@section('html_class','banader banader_homepage')
@section('content')
    <!DOCTYPE html>
    <html lang="en" dir="rtl">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>

    <body class="login-container">

    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="content" style="padding-top: 50px;">

                    <!-- Error title -->
                    <div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3">

                        <h1 class="error-title" style="text-align: center;">403</h1>
                        <h2 style="text-align: center">{{ trans('errors.unfortunately_accessing_to_this_page_is_impossible') }}</h2>
                        <span style="font-size: 14px;">{{ trans('errors.this_happens_because_off') }}</span>

                        <ul style="text-align: right;"><br/>
                            <li>{{ trans('errors.your_profile_dont_have_access_this_page') }}</li><br/>
                            <li>{{ trans('errors.your_ip_address_is_banned') }}</li>
                            <li>{{ trans('errors.you_wanna_see_our_403') }}</li>
                            <br/>
                        </ul>

                    </div>
                    <!-- /error title -->


                    <!-- Error content -->
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3" style="text-align: center;">
                            <form action="#" class="main-search panel panel-body">
                                <span>{{ trans('errors.your_info_registered_back_to_link_403') }}</span>
                                <div class="text-center" style="padding-top: 10px;">
                                    <a href="{{ route('home') }}" class="btn bg-pink-400">
                                        <i class="icon-circle-left2 position-left"></i>{{ trans('app.home_page') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /error wrapper -->


                    <!-- Footer -->

                    <!-- /footer -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
    <!-- /page container -->

    </body>
    </html>
@stop
