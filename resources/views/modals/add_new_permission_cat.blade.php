<form id="form_add_new_role" class="" action="#">
    <div class="row">
        <table class="table">
            <th>
                <td class="col-xs-2">
                <span class="col-lg-3 control-label">{{trans('acl.parent')}}</span>
                </td>
                <td class="col-xs-10">
                    <select id="modal_add_parent_list" class="select" name="parent_id">
                        <option value="0">{{trans('app.no_parent')}}</option>
                        @foreach($cats as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                        @endforeach
                    </select>
                </td>
            </th>
        </table>
        <table class="table">
            <tr>
                <td class="col-xs-2">
                    <span class="col-lg-3 control-label">{{trans('app.title)}}</span>
                </td>
                <td class="col-xs-10">
                    <input id="modal_add_" name="title" type="text" class="form-control">
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