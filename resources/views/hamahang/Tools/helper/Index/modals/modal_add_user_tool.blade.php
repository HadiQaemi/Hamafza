<div>
    <div class="space-4"></div>
    <form id="new_tools_users_form">
        <table class="table table-condensed table-bordered table-striped table-hover td-center-align">
            <tr>
                <td class="col-md-1">
                    <label>{{trans('tools.tools')}}</label>
                </td>
                <td class="col-md-5">
                    <select id="new_tools_user_tools_list" class="select" name="new_datatables_tools_user_tools_id" placeholder="{{ trans('tools.choose') }}"><option value="0">{{ trans('tools.choose') }}</option></select>
                </td>
                <td class="col-md-1">
                    <label>{{trans('tools.users')}}</label>
                </td>
                <td class="col-md-5">
                    <select id="new_tools_user_users_list" class="select" name="new_datatables_tools_user_user_id" placeholder="{{ trans('tools.choose') }}"><option value="0">{{ trans('tools.choose') }}</option></select>
                </td>
                {{--<td class="col-md-3 btn_holder" style="vertical-align: middle">--}}
                    {{--<button type="button" id="add_tools_users" value="save" name="roles_list" class="btn btn-primary" type="button">--}}
                        {{--<i class="fa fa-save bigger-125 "></i>--}}
                        {{--<span>{{trans('app.save')}}</span>--}}
                    {{--</button>--}}
                {{--</td>--}}
            </tr>
        </table>
    </form>
</div>
<script>
    $(document).ready(function () {
        $(".jsPanel-content").css("height", "100px");
        $(".jsPanel").css("height", "200px");
        $('#new_tools_user_tools_list').select2({
            dir: "rtl",
            width: '100%',
            placeholder: "{{ trans('tools.choose') }}",
            allowClear: true,
            data: {!! $all_tools !!}
        });

        $("#new_tools_user_users_list").select2({
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
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        });

    });
</script>