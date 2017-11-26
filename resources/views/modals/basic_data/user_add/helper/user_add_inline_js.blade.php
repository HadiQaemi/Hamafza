<script>
    var success_msg_area_id = '';
    var error_msg_area_id = '';
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
                //console.log(data);
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });
    $(".roles_list").select2("trigger", "select", {
        data: {id: "2", text: 'registerd کاربر عادی'}
    });
    $(document).on('click', '#form_created_new_btn', function () {
        $("#success_msg_area_id").show();
        $.ajax({
            type: 'post',
            url: '{{ route('hamahang.users.add_user') }}',
            data: $('#form_created_new').serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.success == true) {
                    success_msg_area_id = 'success_msg_add_user';

                    messageBox('success','',data.message,{ 'id' :'success_msg_area_id'});
                   // ajax_success_msg(data.message);
                } else if (data.success == false) {
                    error_msg_area_id = 'error_msg_add_user';
                    messageBox('error','',data.error,{ 'id' :'success_msg_area_id'});
                   // ajax_error(data.error);
                }
                $(".base_add_user").scrollTop(0);
                setTimeout(function(){ $("#success_msg_area_id").hide(); }, 5000);
            },
        });
    });


    {{-- function ajax_success_msg(messages) {

        empty_all_msg_area();
        var row = document.createElement('div');
        row.setAttribute('class', 'row');
        var target = messages;
        for (var k in target) {
            if (target.hasOwnProperty(k)) {
                var div = document.createElement('div');
                div.setAttribute("class", "alert alert-success alert-styled-left");
                div.setAttribute("style", "height: 24px;padding-top: 3px;margin-bottom: 5px;");
                var button = document.createElement('button');
                button.setAttribute('type', 'button');
                button.setAttribute('class', 'close');
                button.setAttribute('data-dismiss', 'alert');
                var in_b_span_x = document.createElement('span');
                in_b_span_x.setAttribute("style", "font-size: 15px;position: absolute;");
                in_b_span_x.append('x');
                var in_b_span = document.createElement('span');
                in_b_span.setAttribute('class', 'sr-only');
                in_b_span.append('Close');
                button.append(in_b_span_x);
                button.append(in_b_span);
                var span_text = document.createElement('span');
                span_text.append(target[k]);
                div.append(button);
                div.append(span_text);
                row.append(div);
            }
        }
        $('#' + success_msg_area_id).append(row);
        $('#' + success_msg_area_id).show();
        setTimeout(function () {
            $('#' + success_msg_area_id).toggle();
        }, 5000);

    } --}}
    function empty_all_msg_area() {
        $('#' + error_msg_area_id).empty();
        $('#' + success_msg_area_id).empty();
    }



</script>
