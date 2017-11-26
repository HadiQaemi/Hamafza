@extends('layouts.master')
@section('specific_plugin_style')
@stop
@section('content')
    <div class="container-fluid">
        <div class="space-14"></div>
        <fieldset>
            <div class="row">
                <div class="col-md-12">
                    <table id="packages" class="table table-condensed table-hover table-striped">
                        <thead>
                        <tr>
                            <th data-column-id="id" data-type="numeric" data-width='70' align="right">شناسه</th>
                            <th data-column-id="keyword" class="text-right" align="right">عنوان</th>
                            <th data-column-id="Scount" data-width='100'>اصطلاح نامه</th>

                            <th data-column-id="Scount" data-width='70'>کاربرد</th>
                            <th data-column-id="edit" data-formatter="edit" data-sortable="false" data-width='70'>ویرایش</th>
                            <th data-column-id="delete" data-formatter="delete" data-sortable="false" data-width='70'>حذف</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </fieldset>
    </div>
@stop

@section('specific_plugin_scripts')
@stop
@section('inline_scripts')
    <script>

    </script>
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
