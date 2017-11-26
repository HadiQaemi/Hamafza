@extends('layouts.master')

@section('specific_plugin_style') @stop

@section('inline_style')
    @include('hamahang.Bazaar.helper.bazaar-css')
    @include('hamahang.Bazaar.helper.cart-css')
@stop

@section('inline_scripts')
    @include('hamahang.Bazaar.helper.bazaar-js')
    @include('hamahang.Bazaar.helper.cart-js')
@stop

{{--@section('position_right_col_3')
    @include('hamahang.Bazaar.helper.bazaar-sidebar')
@stop--}}

@section('content')
    <div class="content">
        @if (false)
            @include('hamahang.Bazaar.helper.cart-content')
        @endif
    </div>
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop