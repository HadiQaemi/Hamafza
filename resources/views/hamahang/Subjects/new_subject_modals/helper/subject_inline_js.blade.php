<script type="text/javascript">
    $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute;left: 116px;top: -3px;"><a href="{{App::make('url')->to('/')}}/modals/helpview?code=kdZm7cimONw" title="راهنمای اینجا" href="#" class="jsPanels icon-help HelpIcon" style="float: left;padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');

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
                url: Baseurl + "api/GetsubjectFields",
                dataType: 'html',
                data: ({kind: kind, _token: token}),
                success: function (theResponse) {
                    $("#FieldDiv").html(theResponse);
                    newh = $("#FieldDiv").height();
                    he = $(".jsPanel").height();

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

    $("#PublicSel").change(function () {
        ChageSel($(this), $("#PublicSel option:selected"));
        LoadFields($("#PublicSel option:selected").attr('kind'));
    });
    $("#PrivatSel").change(function () {
        ChageSel($(this), $("#PrivatSel option:selected"));
        LoadFields($("#PrivatSel option:selected").attr('kind'));
    });


    @if($subject_type_policies_personal_check == true)
        $('#PrivatSel').show();
    $('#PublicSel').hide();
    $('#PriRad').prop('checked', true);
    ChageSel($("#PrivatSel"), $("#PrivatSel option:selected"));
    LoadFields($("#PrivatSel option:selected").attr('kind'));
    @endif
    @if($subject_type_policies_Official_check == true)
        LoadFields($("#PublicSel option:selected").attr('kind'));
    @endif

    $(".users_list_subject_view").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '95%',
        ajax: {
            url: "{{ route('auto_complete.users') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                console.log(data);
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });

    $(".roles_list_subject_view").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '95%',
        ajax: {
            url: "{{ route('auto_complete.roles') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                console.log(data);
                var a = true;
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });
    $(".roles_list_subject_view").html('<option selected="selected" value="3">public عمومی</option>');

    $(".users_list_subject_edit").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '95%',
        ajax: {
            url: "{{ route('auto_complete.users') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });

    $(".roles_list_subject_edit").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '95%',
        ajax: {
            url: "{{ route('auto_complete.roles') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                console.log(data);
                var a = true;
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });
    $(".roles_list_subject_edit").html('<option selected="selected" value="1">administrator مدیر ارشد</option>');
    //$(".roles_list_subject_edit").html('<option selected="selected" value="3">public عمومی</option>');

    $(".keywords_list_subject").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '95%',
        ajax: {
            url: "{{ route('auto_complete.keywords') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                console.log(data);
                var a = true;
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });

    $(document).click(function () {

        $("#taed_add_page").off();
        $("#taed_add").off();
        $("#taed_edit").off();
        $(".close").off();

        $('#taed_add_page').click(function () {
            $.ajax({
                type: 'post',
                url: '{{ route('hamafza.add_subject') }}',
                data: $('#form_new_subject').serialize(),
                dataType: 'json',
                success: function (data) {
                    console.log(data.success);
                    if (data.success == false) {
                        messageBox('error', '', data.error.title, {'id': 'alert_subjects_in_jspanel'});
                    } else {
                        //var url = "{{ url('') }}/page_edit/" + data.pid + "/text";
                        messageBox('success', 'ثبت صفحه جدید', data.Alert, {'id': 'alert_subjects_in_jspanel'});
                        $('.keywords_list_subject').val('').trigger('change');
                        $('.users_list_subject_view').val('').trigger('change');
                        $('.roles_list_subject_view').val('').trigger('change');
                        $('.users_list_subject_edit').val('').trigger('change');
                        $('.roles_list_subject_edit').val('').trigger('change');
                        $('#name').val('');
                        $(".roles_list_subject_view").html('<option selected="selected" value="3">public عمومی</option>');
                        $(".roles_list_subject_edit").html('<option selected="selected" value="1">administrator مدیر ارشد</option>');
                    }
                },
            })

        });

        $('#taed_add').click(function () {
            $.ajax({
                type: 'post',
                url: '{{ route('hamafza.add_subject') }}',
                data: $('#form_new_subject').serialize(),
                dataType: 'json',
                success: function (data) {
                    if (data.success == false) {
                        messageBox('error', '', data.error.title, {'id': 'alert_subjects_in_jspanel'});
                    } else {
                        //messageBox('success', 'ثبت', data.Alert, {'id': 'alert_subjects_in_jspanel'}, 'hide_modal');
                        jQuery.noticeAdd({
                            text: data.Alert,
                            stay: false,
                            type: 'success'
                        });
                        window.location.href = "{{url('/')}}/" + data.pid;
                        //hide_modal();
                    }
                },
            })

        });

        $('#taed_edit').click(function () {
            $.ajax({
                type: 'post',
                url: '{{ route('hamafza.add_subject') }}',
                data: $('#form_new_subject').serialize(),
                dataType: 'json',
                success: function (data) {
                    window.location = "{{ url('') }}/page_edit/" + data.pid + "/text";
                },
            })

        });

        $('.close').click(function () {
            $("[data-role=panel]").on("close");
        });

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

        $('#submit').click(function () {
            $('#submit_hide').click();
        });

        $('#submit_edit').click(function () {
            $('#submit_edit_hide').click();
        });


    });

    function hide_modal() {
        $('.jsglyph-close').click();
    }

    $(document).on('change', 'input[type=radio][name=radio_check]', function () {
        if (this.value == '1') {
            $('#taed_add_page').show();
            $('#taed_edit').hide();
            $('#taed_add').show();
        }
        else if (this.value == '2') {
            $('#taed_add_page').hide();
            $('#taed_edit').show();
            $('#taed_add').hide();
        }
    });

    @if($subject_type_policies_Official_check == true)
        $('#PriRad').click();
    @endif
    $(document).ready(function()
    {
        $('.sectype_sel1').click();
    });
</script>