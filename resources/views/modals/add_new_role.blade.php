<form id="form_add_roleform_add_role" class="" action="#">
    <div class="row">
        <table class="table">
            <th>
                <td class="col-xs-2">
                    <span class="col-xs-2">{{trans('auth.name')}}</span>
                </td>
                <td class="col-xs-10">
                    <input id="modal_add_name" name="modal_add_name" type="text" class="form-control">
                </td>
            </th>
        </table>
        <table class="table">
            <tr>
                <td class="col-xs-2">
                    <span class="col-lg-3 control-label">{{trans('acl.display_name')}}</span>
                </td>
                <td class="col-xs-10">
                    <input id="modal_add_display_name" name="modal_add_display_name" type="text" class="form-control">
                </td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td class="col-xs-2">
                    <span class="col-lg-3 control-label">{{trans('app.description')}}</span>
                </td>
                <td class="col-xs-10">
                    <input id="modal_add_description" name="modal_add_description" type="text" class="form-control">
                </td>
            </tr>
        </table>
    </div>
</form>

@include('hamahang.ACL.helper.uac_inline_js')