<!DOCTYPE html>
<html ng-app="hamafza" lang="fa-IR" class="banader">
<head lang="fa-IR">
    @php($csrf = csrf_token())
    <meta name="csrf-token" content="{{$csrf}}">
    <!---------------**Meta**-------------->
    @include('layouts.helpers.common.sections.meta')
    @include('hamahang.master.alert')
    @include('hamahang.master.confirm')
<!---------------**Main Style**-------------->
    @include('layouts.helpers.common.assets.style.main_style')
    @yield('after_main_style')
    @yield('scripts_plugin')

<!---------------**Specific Plugin Style**-------------->
    @yield('specific_plugin_style')
    <link rel="stylesheet" type="text/css" href="{{url('layouts/banader/css/banader_style.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/auth_helper.css')}}">

    <!---------------**Inline Style**-------------->
    @yield('inline_style')

</head>
<body dir="rtl">
<div hmfz-main-header="">
    <nav id="header" class="navbar navbar-default">
        <div class="container-fluid">
            @include('layouts.helpers.common.sections.helpers.nav_bar.menu')
            {{--@include('layouts.helpers.common.sections.nav_bar')--}}
        </div>
    </nav>
</div>
<div id="main">
    <!--End New HTMl -->
    <div>
        <!-- start of Main Template -->
        <div>
            <div id="">
                <div class="">
                    <div class="row">
                        <div>
                            <div style="direction: rtl">
                                <div class="col-md-12">
                                    <div style="direction: rtl">
                                        @yield('content')
                                        @include('layouts.helpers.auth_master.helper.footer_helper')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.dsply-tbl-rw -->
                <!--Right Menu  -->
            </div>
            <!-- end of Main Template -->
        </div>
    </div>
</div>
</body>
</html>
