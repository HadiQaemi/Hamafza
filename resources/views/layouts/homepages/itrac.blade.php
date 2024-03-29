<!DOCTYPE html>
<html ng-app="hamafza" class="@yield('html_class')">
<head lang="en">
@php($csrf = csrf_token())
<!---------------**Meta**-------------->
    <meta name="csrf-token" content="{{ $csrf}}">
@include('layouts.helpers.common.sections.meta')

<!---------------**Main Style**-------------->
@include('layouts.homepages.helpers.itrac.assets.style.main_style')
@include('layouts.homepages.helpers.itrac.assets.style.after_main_style')

<!---------------**Specific Plugin Style**-------------->
@include('layouts.homepages.helpers.itrac.assets.style.specific_plugin_style')

<!---------------**Inline Style**-------------->
@include('layouts.homepages.helpers.itrac.assets.style.inline_style')

<!---------------**Main Scripts**-------------->
    @include('layouts.helpers.common.assets.script.main_scripts')
    @include('hamahang.master.alert')
    @include('hamahang.master.confirm')
    @include('layouts.homepages.helpers.itrac.assets.script.after_main_scripts')

</head>
<body dir="rtl" class="mstr-clr" hmfz-ui-thm="" style="overflow: auto;">
<div class="h_sidenav_main" id="h_sidenav_main" style="padding: 0; margin: 0; transition: margin-left 1s;">
    <div hmfz-main-header="">
        <nav id="header" class="navbar navbar-default">
            <div class="container-fluid">
                @include('layouts.helpers.common.sections.helpers.nav_bar.menu')
                @include('layouts.helpers.common.sections.nav_bar')
            </div>
        </nav>
    </div>
    <div id="main">
        <!-- New HTMl -->
        {{--<div id="scrollReset">--}}
            {{--<a href="#" class="up glyphicon glyphicon-chevron-up"></a>--}}
            {{--<a href="#" class="down glyphicon glyphicon-chevron-down"></a>--}}
        {{--</div>--}}
        <!--End New HTMl -->

        <div hmfz-ui-view="">
            <!-- start of Main Template -->

        @include('layouts.homepages.helpers.itrac.index_content')
        {{--    @include('layouts.homepages.helpers.hamafza.index_content')--}}
        <!-- end of Main Template -->
            @include('layouts.helpers.common.sections.footer_helper')
        </div>
    </div>

    <!---------------**Specific Plugin Scripts**-------------->
    @include('layouts.homepages.helpers.itrac.assets.script.specific_plugin_scripts')

    <!---------------**Inline Scripts**-------------->
    @include('layouts.homepages.helpers.itrac.assets.script.inline_scripts')

    @if(session('message')!='')
        <script>
            jQuery.noticeAdd({
                text: '{{ session('message') }}',
                stay: false,
                type: '{{ session("mestype") }}'
            });
        </script>
    @endif

    @include('layouts.homepages.helpers.itrac.assets.script.inline_scripts')
    @include('layouts.helpers.common.sections.helpers.nav_bar.auth_modals')
</div>
</body>
</html>
