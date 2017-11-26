<script>

    function add_new_tool(){
        $.ajax({
            url: '{{ URL::route('hamahang.tools.save_tools')}}',
            type: 'POST',
            dataType: 'json',
            data: $('#new-tool-form').serialize(),
            success: function (data) {
                if (data.success) {
                    jQuery.noticeAdd({
                        text: 'ابزار با موفقیت افزوده شد.',
                        stay: false,
                        type: 'success'
                    });
                    $('.jsPanel-btn-close').click();
                    $('#toolsGrid').DataTable().ajax.reload();
//                    document.getElementById('new-tool-form').reset();
                }
                else {
                    var errors = '';
                    for(var k in data.error) {
                        errors += '' +
                            '<li>' + data.error[k] +'</li>'
                    }
                    jQuery.noticeAdd({
                        text: errors,
                        stay: false,
                        type: 'error'
                    });
                }
            }
        });
    }

    function edit_tool() {
        $.ajax({
            url: '{{ URL::route('hamahang.tools.edit_tools')}}',
            type: 'POST',
            dataType: 'json',
            data: $('#new-tool-form').serialize(),
            success: function (data) {
                if (data.success) {
                    jQuery.noticeAdd({
                        text: 'ابزار با موفقیت ویرایش شد!',
                        stay: false,
                        type: 'success'
                    });
                    $('.jsPanel-btn-close').click();
                    $('#toolsGrid').DataTable().ajax.reload();
//                    document.getElementById('new-tool-form').reset();
                }
                else {
                    var errors = '';
                    for(var k in data.error) {
                        errors += '' +
                            '<li>' + data.error[k] +'</li>'
                    }
                    jQuery.noticeAdd({
                        text: errors,
                        stay: false,
                        type: 'error'
                    });
                }
            }
        });
    }

    $(".users_list").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '100%',
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

    $(".roles_list").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '100%',
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



    $(document).click(function () {

        $('.btn_add_edit_tool').off();
        $('.btn_add_edit_tool').click(function () {
            @if(isset($tool))
                edit_tool();
            @else
                add_new_tool();
            @endif

        });
    });

    $(document).ready(function () {

        $('.url_from_av').addClass('hide');
        $('.url_from_user').addClass('hide');
        $(document).on('click', '#new-tool-form input[name="url_type"]', function () {
            value = $('#new-tool-form input[name="url_type"]:checked').val();

            if (value == 1) {
                $('.url_from_av').removeClass('hide');
                $('.url_from_user').addClass('hide');
            } else {
                $('.url_from_av').addClass('hide');
                $('.url_from_user').removeClass('hide');
            }
        });

        $("#tools_groups_list").select2({
            dir: "rtl",
            width: '100%',
            placeholder: "بدون دسته",
            allowClear: true,
            data: {!! $tools_groups !!}
        });

        $("#tools_availables_list").select2({
            dir: "rtl",
            width: '100%',
            placeholder: "بدون دسته",
            allowClear: true,
            data: {!! $tools_availables !!}
        });

        @if(isset($tool))
            var tool_group = {!! json_encode($tool->group) !!}
            $("#tools_groups_list").select2("trigger", "select", {
            data: {id: tool_group.id, text: tool_group.name}
            });

            @if($tool->url_type == 1){
//                $('.url_from_av').removeClass('hide');
//                $('.url_from_user').addClass('hide');
                $('#internal').click();
            }
            @else{
//                $('.url_from_av').addClass('hide');
//                $('.url_from_user').removeClass('hide');
                $('#external').click();
            }
            @endif

            if($("#internal").is(':checked')){
                $('.url_from_av').removeClass('hide');
                $('.url_from_user').addClass('hide');
            }
            else{
                $('.url_from_av').addClass('hide');
                $('.url_from_user').removeClass('hide');
            }

        var tool_available = {!! json_encode($tool->available) !!}
            $("#tools_availables_list").select2("trigger", "select", {
                data: {id: tool_available.id, text: tool_group.title}
            });

        var tool_users = {!! json_encode($tool->user_policy) !!}
        for (var k in tool_users) {
            $(".users_list").select2("trigger", "select", {
                data: {id: tool_users[k].id, text: tool_users[k].Name + ' ' + tool_users[k].Family}
            });
        }

        var tool_roles = {!! json_encode($tool->role_policy) !!}
            for (var z in tool_roles) {
            $(".roles_list").select2("trigger", "select", {
                data: {id: tool_roles[z].id, text: tool_roles[z].name + ' (' +tool_roles[z].display_name + ')'}
            });
        }

        @endif

    });

</script>