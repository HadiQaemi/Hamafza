<!DOCTYPE html>
<html ng-app="hamafza" class="@yield('html_class')">
<head lang="en">
@php($csrf = csrf_token())
<!---------------**Meta**-------------->
    <meta name="csrf-token" content="{{ $csrf}}">
@include('layouts.helpers.common.sections.meta')

<!---------------**Main Style**-------------->
@include('layouts.homepages.helpers.shazand.assets.style.main_style')
@include('layouts.homepages.helpers.shazand.assets.style.after_main_style')

<!---------------**Specific Plugin Style**-------------->
@include('layouts.homepages.helpers.shazand.assets.style.specific_plugin_style')

<!---------------**Inline Style**-------------->
@include('layouts.homepages.helpers.shazand.assets.style.inline_style')

<!---------------**Main Scripts**-------------->
    @include('layouts.helpers.common.assets.script.main_scripts')
    @include('hamahang.master.alert')
    @include('hamahang.master.confirm')
    @include('layouts.homepages.helpers.shazand.assets.script.after_main_scripts')

</head>
<body dir="rtl" class="mstr-clr" style="overflow-y: auto;">
<div>
    <nav id="header" class="navbar navbar-default" style="position: fixed; z-index: 10000; width: 100%;">
        <div class="container-fluid">
            @include('layouts.helpers.common.sections.helpers.nav_bar.menu')
            @include('layouts.helpers.common.sections.nav_bar')
        </div>
    </nav>
</div>
<div id="main">
    <div class="transparent_bg">
        @include('layouts.homepages.helpers.shazand.index_content')
        @include('layouts.homepages.helpers.shazand.sections.footer_helper')
    </div>
</div>

<!---------------**Specific Plugin Scripts**-------------->
@include('layouts.homepages.helpers.shazand.assets.script.specific_plugin_scripts')

<!---------------**Inline Scripts**-------------->
@include('layouts.homepages.helpers.shazand.assets.script.inline_scripts')

@if(session('message')!='')
    <script>
        jQuery.noticeAdd({
            text: '{{ session('message') }}',
            stay: false,
            type: '{{ session("mestype") }}'
        });
    </script>
@endif

@include('layouts.homepages.helpers.shazand.assets.script.inline_scripts')
@include('layouts.helpers.common.sections.helpers.nav_bar.auth_modals')

</body>
</html>
