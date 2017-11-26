<div id='permission-role-error-msg'>

</div>
<form class="form" id="permission-role-form">
    <table class="table">
        <tr>
            <td class="col-xs-3">
                <label>{{trans('access.permission')}}</label>
            </td>
            <td class="col-xs-9">
                <select style="width:100px" multiple="multiple" name="permissions">
                </select>
            </td>
        </tr>
        <tr>
            <td class="col-xs-3">
                <label> {{trans('access.role')}}</label>
            </td>
            <td class="col-xs-9">
                <select name="role">
                </select>
            </td>
        </tr>
    </table>
</form>
<script>
    $(document).ready(function () {
        $('select[name="permissions"]').select2({
            minimumInputLength: 3,
            dir: "rtl",
            width: "100%",
            tags: false,
            ajax: {
                url: '{{ route('auto_complete.permissions') }}',
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


                $('select[name="role"]').select2({
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
    });

</script>