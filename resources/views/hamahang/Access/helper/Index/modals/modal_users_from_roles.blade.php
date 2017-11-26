<div class="modal fade" id="show_user_role" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span>{{trans('access.user_role')}}</span>:
                    <span class="bg-warning" id="modal_header_item_title" style="padding:2px 10px; margin-right: 10px;"></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="show_user_role_msgBox"></div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="col-md-9">
                            <select name="users">

                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="button" name="add-user" id="add-user" value="save"
                                    class="btn btn-info"
                                    type="button">
                                <i class="glyphicon  glyphicon-save-file bigger-125"></i>
                                <span>{{trans('access.add_to_user')}} </span>
                            </button>
                        </div>
                    </div>
                    <div class="clearfixed"></div>
                    <hr style="width: 100%;border: 1px solid">
                    <span style="margin: 4px;">{{trans('access.user_get_this_role')}}</span>

                    <div class="col-md-12 selectd-users">
                        <table width="100%" id="userRoleById" class="table col-xs-12 table-striped table-bordered dt-responsive nowrap display">
                            <thead>
                            <tr>

                                <th>{{ trans('access.row') }} </th>
                                <th>{{ trans('access.username') }}</th>
                                <th>{{ trans('access.action') }}</th>
                            </tr>
                            </table>
                    </div>
                </div>
                <div class="clearfixed"></div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="role_id" value=""/>
            </div>
        </div>
    </div>
</div>
