@extends('layouts.master')
@section('specific_plugin_style')
    <link href="{{App::make('url')->to('/')}}/theme/Content/css/textassist.css" rel="stylesheet" type="text/css"/>
@stop
@section('specific_plugin_scripts')
    <script src="{{App::make('url')->to('/')}}/theme/Scripts/textassist.js" type="text/javascript"></script>
@stop
@section('content')
    @include('scripts.publicpages')
    <div class="panel-body text-decoration">
        <div class='text-content'>
            {!! $content !!}
        </div>
    </div>
@stop
{{--
@include('sections.keywords')
@include('sections.files')
--}}
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.rightcol')
@stop

