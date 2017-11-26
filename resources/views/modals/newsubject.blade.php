@extends('modals.modalmaster')
@section('content')
    <script type="text/javascript">
        ChageSel($("#PublicSel"), $("#PublicSel option:selected"));
        function addCheckbox(name, valu) {
            var container = $('#cblist');
            var inputs = container.find('input');
            var id = inputs.length + 1;
            $('<input />', {type: 'radio', name: 'tems', id: 'cb' + id, value: valu}).appendTo(container);
            $('<label />', {'for': 'cb' + id, name: 'tems', text: name}).appendTo(container);
        }
        function LoadFields(kind) {
            if (kind != '') {
                var token = '{{ csrf_token() }}';
                $.ajax({
                    type: "POST",
                    url: Baseurl + "api/GetSubjectFields",
                    dataType: 'html',
                    data: ({kind: kind, _token: token}),
                    success: function (theResponse) {
                        $("#FieldDiv").html(theResponse);
                        newh = $("#FieldDiv").height();
                        he = $(".jsPanel").height();
                        newh = newh + he;
                        if (newh > 550)
                            newh = 550;
                        $(".jsPanel").height(newh);
                        $(".jsPanel-content").height(newh - 10);
                    }
                });
            }
        }
        function ChageSel(e, sel) {
            $("#KindIn").val($(sel).attr("kind"));
            $("#SKIND").val($(sel).val());


            $("#Framework").val($(sel).attr("framework"));
            $("#IsPublic").val($(sel).attr("public"));
            var tems = $(sel).attr('tem');
            $("#Ghaleb").hide();
            tems = $.trim(tems);
            if (tems == '1')
                $("#Ghaleb").show();
            Tems = tems.split(",");
            $('#cblist').html("");
//        for (index = 0; index < Tems.length; index++) {
//            if ($.trim(Tems[index]) != '') {
//                inde = Tems[index];
//                inde = inde.replace(/\s+/g, '');
//                //name = someNumbers[inde];
//                addCheckbox(name, inde);
//                $("#Ghaleb").show();
//            }
//        }
        }

        $('#PubRad').click(function () {
            $('#PublicSel').show();
            $('#PrivatSel').hide();
            ChageSel($("#PublicSel"), $("#PublicSel option:selected"));
        });
        $('#PriRad').click(function () {
            $('#PrivatSel').show();
            $('#PublicSel').hide();
            ChageSel($("#PrivatSel"), $("#PrivatSel option:selected"));
        });

        $("#PublicSel").change(function () {
            ChageSel($(this), $("#PublicSel option:selected"));
            LoadFields($("#PublicSel option:selected").attr('kind'));
        });
        $("#PrivatSel").change(function () {
            ChageSel($(this), $("#PrivatSel option:selected"));
            LoadFields($("#PrivatSel option:selected").attr('kind'));
        });

    </script>
    <span class="help-icon-span">
        <a href="{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=abzarmozoejadid&hid=6" title="راهنمای اینجا" href="#" class="jsPanels icon-help HelpIcon" style="float: left;padding-left: 20px;" title="راهنمای اینجا"
           data-placement="top" data-toggle="tooltip">
        </a>
    </span>
    <form action="{{ route('hamafza.add_subject')}}" method="post" enctype="multipart/form-data" name="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <table class="table" id="FormTable" dir="ltr">
            <tr dir="rtl">
            <tr id="TitleRow">
                <td dir="rtl">
                    <input type="text" required="" class="form-control col-xs-6" name="title">
                </td>
                <td width="120" style="text-align: right;">عنوان</td>
            </tr>
            <td dir="rtl" style="border:none;">
                <input type="hidden" id="Framework" name="Framework" value="0">
                <input type="hidden" id="IsPublic" name="IsPublic" value="1">
                <input type="hidden" id="SKIND" name="SKIND" value="0">
                <input type="hidden" id="KindIn" name="kind" value="0">
                <span style="float: right;margin:0px 5px;">
                    @if($subject_type_policies_Official_check == true)
                        <input style="margin-top: 10px;" id="PubRad" checked="checked" name="sectype" value="1" type="radio"> رسمی
                    @endif
                    @if($subject_type_policies_personal_check == true)
                        <input style="margin-top: 10px;" id="PriRad" name="sectype" value="0" type="radio">شخصی
                    @endif
                </span>
                <script>
                    LoadFields($("#PublicSel option:selected").attr('kind'));
                </script>
                @if($subject_type_policies_personal_check == true)
                    <select class="form-control col-xs-4" id="PublicSel" name="Skind">
                        @foreach($publicSubjects as $item)
                            <option value="{{ $item->id }}"
                                    tem="true"
                                    public="1"
                                    kind="{{ $item->id}}"
                                    framework="{{ $item->Framework}}"
                            >{{ $item->name}}</option>
                        @endforeach
                    </select>
                @endif
                @if($subject_type_policies_Official_check == true)
                    <select class="form-control col-xs-4" id="PrivatSel" name="Skind" style="display: none;">
                        @foreach($privateSubjects as $item)
                            <option value="{{ $item->id }}" public="0" framework="{{ $item->Framework}}"  kind="{{ $item->id}}" >{{ $item->name}}</option>
                        @endforeach
                    </select>
                @endif
                <br>
                <div id="Ghaleb" class="col-xs-12" style="float: right;margin:10px 120px 0;display: none;">
                    <input type="checkbox" checked="" name='tem'> قالب کپی شود.
                </div>
            </td>
            <td style="width:100px;border:none;text-align: right">نوع</td>
            </tr>
        </table>
        <span id="FieldDiv"></span>
        <table class="table ">
            <tr>
                <td colspan="2" style="text-align:left">
                    <input type="hidden" name="fileCount" id="fileCount" value="1"/>
                    <input type="hidden" name="ticket_add" id="ticket_add" value="ticket_add2"/>
                </td>
            </tr>
        </table>
    </form>
@stop