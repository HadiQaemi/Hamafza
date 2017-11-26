@extends('layouts.master')


@section('specific_plugin_style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/one-page-wonder.css')}}">
    <link rel="stylesheet" href="{{URL::to('assets/Packages/js_tree/dist/themes/default/style.css')}}" />
@stop

@section('content')
    <div id="home" class="tab-pane fade in active">
        @include('hamahang.Tasks.helper.SelectTaskWindow.select_task_window_modal')
    </div>
@stop




@section('specific_plugin_scripts')


    <script src="{{URL::asset('assets/Packages/Grid/js/moderniz.2.8.1.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/js_tree/dist/jstree.min.js')}}"></script>
    @include('hamahang.Tasks.helper.SelectTaskWindow.select_task_window_js')
    <script>
    $(document).ready(function () {
        $('#select_task_window_modal').modal({show: true});
    });

</script>


@stop

@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop

