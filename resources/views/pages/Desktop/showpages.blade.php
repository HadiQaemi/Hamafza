@extends('layouts.master')
@section('specific_plugin_style')
    <link href="{{URL::to('assets/Packages/Grid/dist/jquery.bootgrid.css')}}" rel="stylesheet"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/TagsInput/css/jquery.tagsinput.rtl.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/css/one-page-wonder.css')}}">
@stop
@section('inline_style')
    <style>
        .text-left {
            text-align: right !important;
        }
    </style>
@stop
@section('content')
    <div class="container-fluid">
        <div style="margin: 15px;">
          {{--<form id="myForm">
                <table class="table">
                    <tbody>
                    <tr>
                        <td style="text-align: right;border:none;">
                            <input type="radio" checked="" value="my" class="TypeSel" id="TypeSel" name="TypeSel">صفحاتی که من
                            <select class="form-control" style="width: 300px;display: inline;" id="MeCombo" name="MeCombo">
                                <option value="Created_ME" @if($pname=='Created_ME') selected @endif>ایجاد کرده ام</option>
                                <option value="Edited_ME" @if($pname=='Edited_ME') selected @endif>ویرایش کرده ام</option>
                                <option value="follow_ME" @if($pname=='follow_ME') selected @endif>دنبال میکنم</option>
                                <option value="like_ME" @if($pname=='like_ME') selected @endif>پسندیده ام</option>
                                <option value="ano_ME" @if($pname=='ano_ME') selected @endif>یاداشت گذاشته ام</option>
                                <option value="highlight_ME" @if($pname=='highlight_ME') selected @endif>علامت گذاری کرده ام</option>
                                <option value="Proc_ME" @if($pname=='Proc_ME') selected @endif>دارای نقش هستم</option>
                                <option value="visited_ME" @if($pname=='visited_ME') selected @endif>بازدید کرده ام</option>
                                <option value="Sug_ME" @if($pname=='Sug_ME') selected @endif>معرفی کرده ام</option>
                                <option value="ALL_ME" @if($pname=='ALL_ME') selected @endif>همه</option>
                            </select>
                        </td>
                        <td style="text-align: right;border:none;">
                            <input type="radio" value="ALL_Other" @if($pname=='ALL_Other') checked @endif name="TypeSel">همه
                        </td>
                        <td style="text-align: right;border:none;">
                            <input type="radio" value="Deleted_pages" @if($pname=='Deleted_pages') checked @endif  name="TypeSel">حذف شده‌ها
                        </td>
                        <td style="text-align: left;border:none;">
                            <input class="btn btn-primary floatLeft" value="بیاب" id="submitPage" name="submit" style="width: 50px;">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
            --}}
        </div>
        <fieldset>
            <div class="row">
                <div class="col-md-12">
                    <table id="packages" class="table table-condensed table-hover table-striped">
                        <thead>
                        <tr>
                            <th data-column-id="id" data-type="numeric" data-width='70' align="right">شناسه</th>
                            <th data-column-id="title" data-formatter="edit" class="text-right" align="right">عنوان</th>
                            <th data-column-id="subjectkind" data-width='150'>نوع</th>
                            <th data-column-id="visit" data-width='70'>بازدید</th>
                            <th data-column-id="like" data-width='70'>پسند</th>
                            <th data-column-id="follow" data-width='70'>دنبال</th>
                            <th data-column-id="reg_date" data-width='90'>ثبت</th>
                            <th data-column-id="edit_date" data-width='90'>ویرایش</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(is_array($content) && count($content)>0)
                            @foreach($content as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->subjectkind}}</td>
                                    <td>{{$item->visit}}</td>
                                    <td>{{$item->like}}</td>
                                    <td>{{$item->follow}}</td>
                                    <td>{{$item->reg_date}}</td>
                                    <td>{{$item->edit_date}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </fieldset>
    </div>
@stop

@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.ajaxaddition.jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/TagsInput/js/jquery.tagsinput.js')}}"></script>
    <script src="{{URL::asset('assets/Packages/Grid/js/moderniz.2.8.1.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('assets/Packages/Grid/dist/jquery.bootgrid.js')}}"></script>
    <script src="{{URL::asset('assets/Packages/Grid/dist/jquery.bootgrid.fa.js')}}"></script>
@stop
@section('inline_scripts')
    <script>
        $("#packages").bootgrid({
                rowCount: 20,
                formatters: {
                    "edit": function (column, row) {
                        return "<a target='_blank' href='{{$precoe}}" + row.id + "'>" + row.title + "</a>";
                    }
                }
            }
        );
    </script>
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
