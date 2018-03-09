<div>
    <div class="space-4"></div>
    <form id="tools_new_roles_form">

        <table class="table table-condensed table-bordered table-striped table-hover td-center-align">
            <tr>
                <td class="col-md-1">
                    <label>{{trans('tools.tools')}}</label>
                </td>
                <td class="col-md-5">
                    <select id="new_tools_list" class="select" name="new_tools_id" placeholder="{{ trans('tools.choose') }}"><option value="0">{{ trans('tools.choose') }}</option></select>
                </td>
                <td class="col-md-1">
                    <label>{{trans('tools.roles')}}</label>
                </td>
                <td class="col-md-5">
                    <select id="new_roles_list" class="select" name="new_tools_role_id" placeholder="{{ trans('tools.choose') }}"><option value="0">{{ trans('tools.choose') }}</option></select>
                </td>
                {{--<td class="col-md-3 btn_holder" style="vertical-align: middle">--}}

                {{--</td>--}}
            </tr>
        </table>
    </form>
</div>
<script>
    $(document).ready(function () {
        $(".jsPanel-content").css("height", "100px");
        $(".jsPanel").css("height", "200px");
        $('#new_tools_list').select2({
            dir: "rtl",
            width: '100%',
            placeholder: "{{ trans('tools.choose') }}",
            allowClear: true,
            data: {!! $all_tools !!}
        });

        $('#new_roles_list').select2({
            dir: "rtl",
            width: '100%',
            placeholder: "{{ trans('tools.choose') }}",
            allowClear: true,
            data: {!! $roles !!}
        });

    });
</script>