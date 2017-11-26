@extends('layouts.master')
@section('inline_scripts')
    @include('scripts.publicpages')
    @if(Session::get('message')!='')
        <script>
            jQuery.noticeAdd({
                text: '{{ Session::get('message') }}',
                stay: false,
                type: '{{ Session::get("mestype") }}'
            });
        </script>
    @endif
    <script>
        function DelKeys(e) {
            id = $(e).attr("keyid");
            if (id != '') {
                var r = confirm("آیا مایل به حذف کلید واژه هستید؟\n\
در صورت حذف کلیه ارتباط ها نیز حذف می شود");
                if (r == true) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('hamafza.keyword_delete') }}',
                        dataType: 'html',
                        data: ({keyid: id}),
                        success: function (theResponse) {
                            jQuery.noticeAdd({
                                text: theResponse,
                                stay: false,
                                type: 'success'
                            });
                        }
                    });
                } else {
                    txt = "You pressed Cancel!";
                }
            }
        }
        function loadKeyDet(id) {
            if (id == '')
                alert("محتوا خالی است");
            else {
                $("#KeywordDetails").html("");
                $("#mynetwork").html("");
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamafza.key_rel') }}',
                    dataType: 'html',
                    data: ({keyid: id}),
                    success: function (theResponse) {
                        var obj = JSON.parse(theResponse);
                        res = obj.table;
                        res2 = obj.keywords;
                        res3 = obj.relations;
                        $("#KeywordDetails").html(res);
                        startNetwork(res2, res3);
                        $("#EditKeybut").attr("href", "{{url('modals/editkeyword?sid=')}}" + id);

                        $("#MergeKeyBut").attr("href", "{{url('modals/mergkeyword?sid=')}}" + id);
                        $("#ThesBut").show();
                        $(".ThesBut").attr("keyid", id);
                    }
                });
            }
        }
        function startNetwork(res20, res30) {
            var options = {
                autoResize: true,
            }
            var container = document.getElementById('mynetwork');
            var data = {
                nodes: res20,
                edges: res30
            };
            network = new vis.Network(container, data, options);
        }
    </script>
@stop
@section('content')
    <div class="space-12"></div>
    <div class="row">
        <div class="col-xs-8">
            <div style="padding: 0;" class="panel-heading panel-heading-gold"></div>
            <div class="panel panel-light">
                <div class='text-content'>
                    {!! $content !!}
                </div>
            </div>
            <div class="clearfixed"></div>
        </div>
        <div class="col-md-4 scrl-3">
            <div class="panel panel-light">
                <div style="padding: 0;" class="panel-heading panel-heading-gold"></div>
                <div id="KeywordDetails" class="panel-body text-decoration"></div>
                <div id="mynetwork"></div>
                <div class="row" id="ThesBut" Style="margin: 10px;display: none;">
                    @if($allowdeltag)
                        <div class="col-md-4">
                            <a onclick="DelKeys(this)" class="btn btn-primary ThesBut" keyid="">حذف</a>
                        </div>
                    @endif
                    @if($allowedittag)
                        <div class="col-md-4">
                            <a id="EditKeybut" title="ویرایش کلیدواژه" class="btn btn-primary ThesBut jsPanels" keyid="">ویرایش</a>
                        </div>
                    @endif
                    @if($allowedittag)
                        <div class="col-md-4">
                            <a id="MergeKeyBut" title="ادغام کلیدواژه" class="btn btn-primary ThesBut jsPanels" keyid="">ادغام</a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="clearfixed"></div>
        </div>
        <div class="clearfixed"></div>
    </div>
@stop
@include('sections.tabs')