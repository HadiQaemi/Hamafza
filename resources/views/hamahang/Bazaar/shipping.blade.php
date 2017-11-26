@extends('layouts.master')

@section('specific_plugin_style') @stop

@section('inline_style')
    @include('hamahang.Bazaar.helper.bazaar-css')
    @include('hamahang.Bazaar.helper.shipping-css')
@stop

@section('inline_scripts')
    @include('hamahang.Bazaar.helper.bazaar-js')
    @include('hamahang.Bazaar.helper.shipping-js')
@stop

{{--
@section('position_right_col_3')
    @include('hamahang.Bazaar.helper.bazaar-sidebar')
@stop
--}}

@section('content')
    <div class="content">
        @if (false)
            @include('hamahang.Bazaar.helper.shipping-content')
        @endif
    </div>
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop