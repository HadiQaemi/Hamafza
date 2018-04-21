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

                        <h1 class="error-title" style="text-align: center">404</h1>
                        <h2 style="text-align: center">{{ trans('errors.unfortunately_the_requested_page_not_found') }}</h2>
                        <span style="font-size: 14px;">{{ trans('errors.you_probably_redirected_here_cause') }}</span>

                        <ul style="text-align: right;"><br/>
                            <li>{{ trans('errors.page_deleted') }}</li>
                            <li>{{ trans('errors.page_doesnt_exist') }}</li>
                            <li>{{ trans('errors.address_is_not_correct') }}</li>
                            <li>{{ trans('errors.you_wanna_see_our_404') }}</li>
                            <br/>
                        </ul>

                    </div>
                    <!-- /error title -->


                    <!-- Error content -->
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3 main-search panel panel-body" style="text-align: center;">
                            {{--<form action="#" class="main-search panel panel-body">--}}
                            <span>{{ trans('errors.your_info_registered_back_to_link_404') }}</span>

                            {{--</form>--}}
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
