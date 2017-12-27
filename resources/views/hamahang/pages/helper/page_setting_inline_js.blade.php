<script>
    $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute; left: 116px; top: -3px;"><a href="" title="راهنمای اینجا" class="jsPanels icon-help HelpIcon" style="float: left; padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');
    $('.HelpIcon').hide();
    $(document).ready(function () {
        $(".token-input-list-pages").tokenInput("{{App::make('url')->to('/')}}/Pagesearch", {
            preventDuplicates: true,
            hintText: "عبارتی را وارد کنید",
            noResultsText: "نتیجه‌ای یافت نشد، با زدن دکمه اینتر کلیدواژه جدیدی ایجاد می‌شود",
            searchingText: "در حال جستجو",
        });
    });

    $("#select_user").select2({
        ajax: {
            type: "POST",
            url: '{!! route('auto_complete.users') !!}',
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: $.map(data, function (item, i) {
                        return {
                            text: item.text,
                            id: item.id
                        }
                    })
                };
            },

        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
    });
    $("#select_user_m").select2({
        ajax: {
            type: "POST",
            url: '{!! route('auto_complete.users') !!}',
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: $.map(data, function (item, i) {
                        return {
                            text: item.text,
                            id: item.id
                        }
                    })
                };
            },

        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
    });


    $(document).ready(function () {
        $(".subject_help").tokenInput("{{App::make('url')->to('/')}}/Helpsearch", {
            preventDuplicates: true,
            hintText: "عبارتی را وارد کنید",
            noResultsText: "نتیجه‌ای یافت نشد، با زدن دکمه اینتر کلیدواژه جدیدی ایجاد می‌شود",
            searchingText: "در حال جستجو",
            onAdd: function (item) {
                //add the new label into the database
                if (parseInt(item.id) == 0) {
                    name = $("tester").text();
                    if (name != null) {
                        $.ajax({
                            type: "POST",
                            url: "tagmergeaction.php",
                            dataType: 'html',
                            data: ({New: 'OK', Name: name}),
                            success: function (theResponse) {
                                if (theResponse != 'NOK')
                                    alert('بر چسب جدید با موفقیت تعریف شد');
                                $("#input-plugin-methods").tokenInput("remove", {name: name});
                                $("#input-plugin-methods").tokenInput("add", {id: theResponse, name: name});
                            }
                        });
                    }
                }
            },
            onResult: function (item) {
                if ($.isEmptyObject(item)) {

                    return [{id: '0', name: $("tester").text()}]
                } else {
                    return item
                }

            }
        });
        $("#RadioGroup0_1").click(function () {
            $("#limit_view_panel").show();
            $("#limit_view_panel").css('display', 'inline-block');
        });
        $("#RadioGroup0_0").click(function () {
            $("#limit_view_panel").hide();
        });
        $("#RadioGroup1_1").click(function () {
            $("#limit_edit_panel").show();
            $("#limit_edit_panel").css('display', 'inline-block');
        });
        $("#RadioGroup1_0").click(function () {
            $("#limit_edit_panel").hide();
        });
    });


            @if (is_array($Helps) && count($Helps) > 0)
            @foreach($Helps as $hlp)
            @if ($hlp->id == $tab->pid && $hlp->help_tag != '')
    var x = "{{$hlp->help_tag}}";
    var y = "{{$hlp->help_name}}";
    $("#subject_help_{{$tab->pid}}").tokenInput("add", {id: x, name: y});
    @endif
@endforeach
@endif




    $(".users_list_setting_edit").select2({
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


    var data_r = JSON.parse('{!! $relation !!}');
    $('.form_relations').html('');
    console.log(data_r);
    var i = 2;
    for (var key in  data_r) {

        if (data_r != '') {

            $('.form_relations').append(' <div class="col-xs-6">' +
                '<select disabled name="relations[' + i + '][]" id="relations' + i + '"  class="form-control relations"></select>' +
                '</div>' +
                '<div class="col-xs-6">' +
                '<select name="subject_rel[' + i + '][]" id="subject_rel' + i + '"  class="form-control subject_rel" multiple="multiple"></select>' +
                '</div><br/><br/><br/>');

            i++;
            var array_data = '{!! $rels !!}';
            var data = JSON.parse(array_data);
            $(".relations").select2({
                dir: "rtl",
                width: '95%',
                data: data,
            });

            $(".subject_rel").select2({
                minimumInputLength: 1,
                tags: false,
                dir: "rtl",
                width: '100%',
                ajax: {
                    url: "{{ route('auto_complete.subjects') }}",
                    dataType: 'json',
                    type: "POST",
                    quietMillis: 50,
                    data: function (term) {
                        return {
                            term: term
                        };
                    },
                    results: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.text,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });
        }
    }

    var k = 2;
    //console.log(data_r);
    if (data_r != '') {
        $.each(data_r, function (key, value) {
            console.log(key);
            var rel = key;

            var id = '#relations' + k.toString();
            var id2 = '#subject_rel' + k.toString();
            //console.log(data_r);
            $(id).val([rel]).trigger('change');
            for (var key in  value) {
                $(id2).append('<option selected="selected" value="' + value[key]['left']['id'] + '">' + value[key]['left']['title'] + '</option>');
            }
            k++;
        });
    }


    var i;
    $('.form_relations').append('<br/><br/>');
    for (i = 0; i < 2; i++) {
        $('.form_relations').append(' <div class="col-xs-6">' +
            '<select name="relations[' + i + '][]" id="relations' + i + '"  class="form-control relations"></select>' +
            '</div>' +
            '<div class="col-xs-6">' +
            '<select name="subject_rel[' + i + '][]" id="subject_rel' + i + '"  class="form-control subject_rel" multiple="multiple"></select>' +
            '</div><br/><br/><br/>');
        var array_data = '{!! $rels !!}';
//console.log(JSON.parse(JSON.stringify(array_data)));
        var data = JSON.parse(array_data);
        $(".relations").select2({
            dir: "rtl",
            width: '95%',
            data: data,
        });

        $(".subject_rel").select2({
            minimumInputLength: 1,
            tags: false,
            dir: "rtl",
            width: '100%',
            ajax: {
                url: "{{ route('auto_complete.subjects') }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
    }


    $(".roles_list_setting_edit").select2({
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

    $(".users_list_setting_view").select2({
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
    $(".roles_list_setting_view").select2({
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


    $(document).on('click', '.tab', function()
    {
        $idTab = $(this).attr('id');
        if ($idTab == 'omomi')
        {
            $('.HelpIcon').hide();
            $(this).parent().parent().parent().parent().parent().find('.jsPanel-ftr').html('<input type="submit" class="btn btn-primary omomi_btn" value="تایید " style=" float: left" name="addSubject" >');
        } else if ($idTab == 'ravabet')
        {
            $('.HelpIcon').attr('href', '{!! url('/modals/helpview?code=QjEFk6Js2vY') !!}');
            $('.HelpIcon').show();
            var ravabet_apply = '<input type="submit" class="btn btn-primary btn-footer ravabet_btn" data-apply="apply" value="تایید و ادامه " style=" float: left" >';
            var ravabet_save = '<input type="submit" class="btn btn-primary btn-footer ravabet_btn" value="تایید " style=" float: left" >';
            $(this).parent().parent().parent().parent().parent().find('.jsPanel-ftr').html(ravabet_apply + ravabet_save);
        } else if ($idTab == 'dasrasi')
        {
            $('.HelpIcon').hide();
            var dasrasi_apply = '<input type="submit" class="btn btn-primary btn-footer dasrasi_btn" data-apply="apply" value="تایید و ادامه " style=" float: left" >';
            var dasrasi_save = '<input type="submit" class="btn btn-primary btn-footer dasrasi_btn" value="تایید " style=" float: left" >';
            $(this).parent().parent().parent().parent().parent().find('.jsPanel-ftr').html(dasrasi_apply + dasrasi_save);
        } else if ($idTab == 'bazar')
        {
            $('.HelpIcon').attr('href', '{!! url('/modals/helpview?code=t5BuhBAH018') !!}');
            $('.HelpIcon').show();
            $('#submit_bazzar').hide();
            var bazar_apply = '<input type="button" class="btn btn-primary submit_bazzar" data-apply="apply" id="submit_bazzar" name="submit_bazzar" value="تایید و ادامه" onclick="return do_submit(1);" style="float: left; ">';
            var bazar_save = '<input type="button" class="btn btn-primary submit_bazzar" id="submit_bazzar" name="submit_bazzar" value="تایید" onclick="return do_submit(0);" style="float: left; ">';
            $(this).parent().parent().parent().parent().parent().find('.jsPanel-ftr').html(bazar_apply + bazar_save);
        } else if ($idTab == 'rahnama')
        {
            $('.HelpIcon').hide();
            $(this).parent().parent().parent().parent().parent().find('.jsPanel-ftr').html('<input type="submit"  style=" float: left" value="تایید " class="btn btn-primary rahnama_btn">');
        }
    });

    $(document).click(function () {

        $('.omomi_btn').off();
        $('.omomi_btn').click(function () {
            var $this = $(this);
            var is_apply = $this.data('apply');
            $.ajax({
                type: "POST",
                url: "{{ route('hamahang.subjects.update') }}",
                dataType: 'json',
                data: $('#form_subject_omomi').serialize(),
                success: function (data) {
                    if (data.success == false) {
                        messageBox('error', '', data.error.subject_title, {'id': 'alert_setting_omomi'});
                    } else {
                        if (is_apply == 'apply')
                            jQuery.noticeAdd({
                                text: 'تغییرات با موفقیت انجام شد',
                                stay: false,
                                type: 'success'
                            });
//                        messageModal('success', 'ثبت', theResponse);
                        else
                            location.reload();
                        /*messageBox('success', '', data,{'id': 'alert_setting_omomi'},'hide_modal');*/
//                    $('.jsglyph-close').click();
                    }
                }
            });
        });

        $('.alert-success').hide();
        $('.ravabet_btn').off();
        $('.ravabet_btn').click(function () {
            //$("#form_subject_ravabet").submit();
            var $this = $(this);
            var is_apply = $this.data('apply');
            $('.relations').removeAttr("disabled");
            $.ajax({
                type: "POST",
                url: "{{ route('hamafza.update_relations') }}",
                dataType: 'json',
                data: $('#form_subject_ravabet').serialize(),
                success: function (theResponse) {
                    if (theResponse.success == false) {
                        messageBox('error', '', theResponse.message, {'id': 'alert_setting_ravabet_btn'});
                    } else {
                        if (is_apply == 'apply')
                            jQuery.noticeAdd({
                                text: 'تغییرات با موفقیت انجام شد',
                                stay: false,
                                type: 'success'
                            });
//                        messageModal('success', 'ثبت', theResponse);
                        else
                            location.reload();
                        /*messageBox('success', '', data,{'id': 'alert_setting_omomi'},'hide_modal');*/
//                    $('.jsglyph-close').click();
//                    location.reload();
                    }
                }
            });
        });

        $('.dasrasi_btn').off();
        $('.dasrasi_btn').click(function () {
            var $this = $(this);
            var is_apply = $this.data('apply');
            $.ajax({
                type: "POST",
                url: "{{ route('hamafza.update_access') }}",
                dataType: 'json',
                data: $('#manager_form').serialize(),
                success: function (theResponse) {

                    if (theResponse.success == false) {
                        messageBox('error', '', theResponse.message, {'id': 'alert_setting_ravabet_btn'});
                    } else {
                        if (is_apply == 'apply')
                            jQuery.noticeAdd({
                                text: 'تغییرات با موفقیت انجام شد',
                                stay: false,
                                type: 'success'
                            });
//                        messageModal('success', 'ثبت', theResponse);
                        else
                            location.reload();

//                $('.alert-success').html(theResponse)
//
//                $(".alert-success").fadeTo(2000, 500).slideUp(500, function () {
//                    $(".alert-success").slideUp(500);
//                });
                    }
                }
            });
        });

    });



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

    $(document).on('click', '.rahnama_btn', function(e)
    {
        data =
        {
            'target_type': 'page',
            'target_id': '{!! $pid !!}',
            'help_id': $('.help_relation_add').val()
        };
        $.ajax
        ({
            url: '{{ route('modals.help.relation.add') }}',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(response)
            {
                jQuery.noticeAdd({type: response[0], text: response[1], stay: false});
                $('.jsglyph-close').click();
            }
        });
    });

</script>
