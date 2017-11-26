<!DOCTYPE html>
<html ng-app="hamafza" lang="fa-IR" class="banader">
<head lang="fa-IR">
    @php($csrf = csrf_token())
    <meta name="csrf-token" content="{{$csrf}}">
    <!---------------**Meta**-------------->
    @include('layouts.helpers.common.sections.meta')

    @if(Config::get('constants.Addstyle')!='')
        <link rel="stylesheet" href="{{url('/theme/Content/css/'.Config::get('constants.Addstyle'))}}"/>
    @endif

<!---------------**Main Style**-------------->
    @include('layouts.helpers.common.assets.style.main_style')
    @yield('after_main_style')

<!---------------**Specific Plugin Style**-------------->
    @yield('specific_plugin_style')
    {!! index_view_style(config('constants.IndexView')) !!}

<!---------------**Inline Style**-------------->
    @yield('inline_style')

<!---------------**Main Scripts**-------------->
    @include('layouts.helpers.common.assets.script.main_scripts')
    @yield('after_main_scripts')
</head>
<body dir="rtl" style="background-color: white;">
    @include('hamahang.master.alert')
    @include('hamahang.master.confirm')
    @include('hamahang.master.loading')
    @yield('content')
    <script type="text/javascript" src="{{URL::to('assets/Packages/bootstrap/js/bootstrap-filestyle.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/js_tree/dist/jstree.min.js')}}"></script>
    @yield('specific_plugin_scripts')
    @yield('inline_scripts')
    <script type="text/javascript" src="{{URL::asset('assets/Packages/bootstrap/js/bootstrap-filestyle.js')}}"></script>
</body>
</html>
