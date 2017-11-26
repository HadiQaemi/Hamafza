@extends('layouts.master')
@section('specific_plugin_style')
    <style>
        #Tdxcre .scrlbig {
            overflow-y: hidden !important;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div id="jstree-tree" class=" col-sm-7">
            <div class="panel">
                <div class="panel-heading">درخت کلید واژه</div>
                <div id="thesaurus_tree_area" class="panel-body" style="overflow-y: auto;direction: ltr">
                    <div class="tree_area" style="direction: rtl"></div>
                </div>
            </div>
        </div>
        <div id="jstree-result" class="col-sm-5">
            <div class="panel">
                <div class="panel-heading" style="font-weight:bold; font-size: 12px; line-height: 24px; "></div>
                <div class="panel-body">
                    <div class="loader"></div>
                </div>
            </div>
        </div>

    </div>
@stop
@section('specific_plugin_scripts')
    {{--<script type="text/javascript" src="{{URL::asset('assets/Packages/DataTables/datatables.js')}}"></script>--}}
@stop
@section('inline_scripts')
    {{--@include('hamahang.Tools.helper.Index.JS.inlineJS')--}}
    <script>
        $('.loader').hide();
        $('#jstree-result').hide();
        $('#jstree-tree #thesaurus_tree_area').find('.tree_area')
            .on('changed.jstree', function (e, data) {
                $('.loader').show();
                $('#jstree-result').find('.panel-body').html("");
                var objNode = data.instance.get_node(data.selected);
                $.ajax({
                    type: 'post',
                    dataType: "json",
                    data: {id: objNode.id},
                    url: "{{route('hamafza.get_keywords_for_tree')}}",
                    success: function (data) {
                        // $('#jstree-result').html('Selected: <br/><strong>' + objNode.id+'-'+objNode.text+'</strong>');
                        var res = '';
                        $('#jstree-result').show();
                        $.each(data, function (key, value) {
                            res = res + '<ul class="list-group"><b>' + key + '</b>';
                            $.each(value, function (key2, value2) {
                                res = res + '<li style="padding: 10px;">&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;' + value2 + '</li>';
                            });
                            res = res + '</ul>';
                        });
                        $('#jstree-result').find('.panel-body').html(res);
                        $('.loader').hide();
                    }
                });
                $('#jstree-result').find('.panel-heading').html('<span>'+objNode.text+'</span>');
                $('.jstree-container-ul').attr('style', 'direction: rtl;');
            })
            .jstree({
                core: {
                    data:{!! $trees !!},
                    'rtl': true,
                    "themes": {
                        "icons": false
                    },
                    "state": {"selected": true, "opened": true}
                },
                plugins: ["wholerow"]
            })
            .bind("loaded.jstree", function (event, data) {
                // you get two params - event & data - check the core docs for a detailed description
                $(this).jstree("open_all");
            });
        $(window).on('resize', function () {
            //console.log('tree_hight = ' + (window.dcrl2 - 315));
            $("#thesaurus_tree_area").height(window.dcrl2 - 280);
        });
    </script>
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop