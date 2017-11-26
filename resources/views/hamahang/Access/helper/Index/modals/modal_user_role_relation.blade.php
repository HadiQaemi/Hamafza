<div id='user-role-error-msg'>

</div>
<form class="form" id="user-role-form">
    <table class="table">
        <tr>
            <td class="col-xs-3">
                <label>{{trans('access.user')}}</label>
            </td>
            <td class="col-xs-9">
                <select style="width:100px" name="user"></select>
            </td>
        </tr>
        <tr>
            <td class="col-xs-3">
                <label>{{trans('access.role')}}</label>
            </td>
            <td class="col-xs-9">
                <select multiple="multiple" name="roles"></select>
            </td>
        </tr>
    </table>
</form>

<script>
    $("select[name='user']").select2({
        minimumInputLength: 3,
        dir: "rtl",
        width: "100%",
        tags: false,
        ajax: {
            url: "{{route('auto_complete.users')}}",
            dataType: "json",
            type: "POST",
            quietMillis: 150,
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
    $.ajax({
        url: '{{ route('auto_complete.roles') }}',
        method: 'POST',
        dataType: 'json',
        success: function (data) {
            $('select[name="role_search"]').select2({
                placeholder: '{{trans('app.select_a_option')}}',
                dir: "rtl",
                width: '100%',
                data: data
            }).val(null).trigger('change');
            $('select[name="roles"]').select2({
                placeholder: '{{trans('app.select_a_option')}}',
                dir: "rtl",
                width: '100%',
                data: data
            }).val(null).trigger('change');
        }
    });
</script>
