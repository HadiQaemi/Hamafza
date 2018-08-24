<!DOCTYPE html>
<html ng-app="hamafza" class="@yield('html_class')">
<head lang="en">
    <!---------------**Meta**-------------->
    <meta name="csrf-token" content="{{ csrf_token()}}">

{{--@include('sections.meta')--}}

<!---------------**Main Style**-------------->
@include('layouts.errors.index_helper.style')
@yield('after_main_style')
<!---------------**Specific Plugin Style**-------------->
    @yield('specific_plugin_style')
    <link rel="stylesheet" type="text/css" href="{{url('layouts/banader/css/banader_style.css')}}"/>
    <!---------------**Inline Style**-------------->
    @yield('inline_style')
<!---------------**Main Scripts**-------------->
    {{--    @include('sections.main_scripts')--}}
    @yield('after_main_scripts')

</head>
<body dir="rtl" class="mstr-clr" hmfz-ui-thm="" style="overflow: auto;">
<div hmfz-main-header="">
    {{--    @if($index == 'index')--}}
    {{--<nav id="header" class="navbar navbar-default" style="position: fixed;z-index: 10000;width: 100%;">--}}
    <nav id="header" class="navbar navbar-default">
        {{--    @elseif($index == 'index.banader')--}}
        {{--<nav id="header" class="navbar navbar-default" style="background-color: #4C99BF; position: fixed;z-index: 10000;width: 100%;">--}}
        {{--@endif--}}
        <div class="container-fluid">
            {{--                @include('layouts.errors.index_helper.menu')--}}
        </div>
    </nav>
</div>
<div id="main">
    @yield('content')
    @include('layouts.errors.index_helper.footer')
</div>

<!---------------**Specific Plugin Scripts**-------------->
@yield('specific_plugin_scripts')

<!---------------**Inline Scripts**-------------->
@yield('inline_scripts')

</body>
</html>
