@extends('layouts.master')
@section('after_main_style')
    <link href="{{URL::to('assets/Packages/fancytree-master/dist/skin-bootstrap/ui.fancytree.css')}}" rel="stylesheet" class="skinswitcher">

    <style type="text/css">
        #treetable {
            table-layout: fixed;
        }

        #treetable tr td:nth-of-type(1) {
            text-align: center;
        }

        #treetable tr td:nth-of-type(2) {
            text-align: left;
        }

        #treetable tr th {
            text-align: center;
        }

        #treetable tr td:nth-of-type(3) {
            min-width: 100px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@stop

@section('content')
    <table id="treetable" class="table table-condensed table-hover table-striped fancytree-fade-expander table-bordered fancytree-colorize-selected">
        <colgroup>
            <col width="30px">
            </col>
            <col width="80px">
            </col>
            <col width="*">
            </col>
            <col width="180px">
            </col>
            <col width="70px">
            </col>
            <col width="100px">
            </col>
        </colgroup>
        <thead>
        <tr>
            <th></th>
            <th>{{ trans('app.id') }}</th>
            <th>{{ trans('projects.task_title') }}</th>
            <th>{{ trans('projects.operator') }}</th>
            <th>{{ trans('projects.due_date') }}</th>
            <th>{{ trans('app.action') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>
@stop

@section('specific_plugin_scripts')
    <script src="{{URL::to('assets/Packages/fancytree-master/dist/src/jquery.fancytree.js')}}"></script>
    <script src="{{URL::to('assets/Packages/fancytree-master/dist/src/jquery.fancytree.dnd.js')}}"></script>
    <script src="{{URL::to('assets/Packages/fancytree-master/dist/src/jquery.fancytree.edit.js')}}"></script>
    <script src="{{URL::to('assets/Packages/fancytree-master/dist/src/jquery.fancytree.glyph.js')}}"></script>
    <script src="{{URL::to('assets/Packages/fancytree-master/dist/src/jquery.fancytree.table.js')}}"></script>
    <script src="{{URL::to('assets/Packages/fancytree-master/dist/src/jquery.fancytree.wide.js')}}"></script>
@stop

@section('inline_scripts')
    <script type="text/javascript">
        glyph_opts = {
            map: {
                doc: "fa fa-file-text-o",
                docOpen: "fa fa-file-o",
                checkbox: "glyphicon glyphicon-unchecked",
                checkboxSelected: "glyphicon glyphicon-check",
                checkboxUnknown: "glyphicon glyphicon-share",
                dragHelper: "glyphicon glyphicon-play",
                dropMarker: "glyphicon glyphicon-arrow-right",
                error: "fa fa-exclamation-triangle",
                expanderClosed: "fa fa-caret-left",
                expanderLazy: "fa fa-caret-left",  // glyphicon-plus-sign
                expanderOpen: "fa fa-caret-down",  // glyphicon-collapse-down
                folder: "fa fa-folder-o",
                folderOpen: "fa fa-folder-open-o",
                loading: "glyphicon glyphicon-refresh glyphicon-spin"
            }
        };
        $(function () {
            $("#treetable").fancytree({
                extensions: ["dnd", "edit", "glyph", "table"],
                checkbox: true,
                dnd: {
                    focusOnClick: true,
                    dragStart: function (node, data) {
                        console.log(node);
                        return true;
                    },
                    dragEnter: function (node, data) {
                        console.log(node);
                        return true;
                    },
                    dragDrop: function (node, data) {
                        data.otherNode.copyTo(node, data.hitMode);
                    }
                },
                glyph: glyph_opts,
                rtl: true,
                source: JSON.parse('{!! $Tasks !!}')
                ,
                table: {
                    checkboxColumnIdx: 0,
                    nodeColumnIdx: 2
                },

                activate: function (event, data) {
                },
                lazyLoad: function (event, data) {
                    data.result = {url: "ajax-sub2.json", debugDelay: 1000};
                },
                renderColumns: function (event, data) {
                    var node = data.node,
                        $tdList = $(node.tr).find(">td");
                    console.log(data);
                    $tdList.eq(1).text(node.getIndexHier());
                    $tdList.eq(3).text(node.data.user_responsible_name);
                    $tdList.eq(4).text(node.data.duration);
                    $tdList.eq(5).text(node.data.desc);
                }
            });
        });
    </script>
    <script>
        $(function () {
            $("#fontSize").change(function () {
                $("#tree .fancytree-container").css("font-size", $(this).prop("value") + "pt");
            });//.prop("value", 12);

            $("#plainTreeStyles").on("change", "input", function (e) {
                $("#tree ul").toggleClass($(this).data("class"), $(this).is(":checked"));
            });
            $("#bootstrapTableStyles").on("change", "input", function (e) {
                $("#treetable").toggleClass($(this).data("class"), $(this).is(":checked"));
            });
        });
    </script>
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop


{{--@section('CustomRightMenu')
    <div class="panel-heading panel-heading-darkblue">{{ trans('app.list') }}</div>
    <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
        <div accordion="" class="panel-group accordion" id="accordion">
            {!!$RightContent!!}
        </div>
    </div>
@stop--}}