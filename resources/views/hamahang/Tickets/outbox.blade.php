@extends('layouts.master')
@section('content')
    <div class="row-fluid">
        <div class="col-xs-12">
            <div class="row">
                <div class="space-10"></div>
                <div id="alert_subject"></div>
                <table id="ticketSendGrid" class="table table-striped table-bordered dt-responsive nowrap display" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>فرستنده</th>
                        <th>عنوان</th>
                        <th>متن پیام</th>
                        <th>پیوست</th>
                        <th>تاریخ</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="clearfixed"></div>
@stop

@section('inline_scripts')
    @include('hamahang.Tickets.helper.outbox_inline_js')
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
