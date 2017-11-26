<form id="form_add_new_permission" class="" action="#">
    <div class="row">
        <input id="add_form_type" type="hidden" name="item_type" value="">
        <table class="table">
            <th>
                <td class="col-xs-2">
                    <span class="col-xs-2">{{trans('auth.name')}}</span>
                </td>
                <td class="col-xs-10">
                    <input id="modal_add_name" name="name" type="text" class="form-control">
                </td>
            </th>
        </table>
        <table class="table">
            <tr>
                <td class="col-xs-2">
                    <span class="col-lg-3 control-label">{{trans('acl.display_name')}}</span>
                </td>
                <td class="col-xs-10">
                    <input id="modal_add_display_name" name="display_name" type="text" class="form-control">
                </td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td class="col-xs-2">
                    <span class="col-lg-3 control-label">{{trans('app.description')}}</span>
                </td>
                <td class="col-xs-10">
                    <input id="modal_add_description" name="description" type="text" class="form-control">
                </td>
            </tr>
        </table>
    </div>
</form>

@include('hamahang.ACL.helper.uac_inline_js')