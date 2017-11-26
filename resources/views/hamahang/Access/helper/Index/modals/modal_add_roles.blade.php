{{--<div class="modal fade" tabindex="-1" id="add_role" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span> نقش جدید</span>:
                    <span class="bg-warning" id="modal_header_item_title" style="padding:2px 10px; margin-right: 10px;"></span>
                </h4>
            </div>
            <div class="modal-body">--}}

                  <div id="roleErrorMsg">

                  </div>
                  <form id="roles-form" class="form">
                      <table class="table  col-xs-12">
                          <tr>
                            <td class="col-xs-3">

                              <label>{{trans('access.role_title')}}</label>
                            </td>
                            <td class="col-xs-9"><input name="name" value="" class="form-control"/>
                              <p  class="form-text text-muted">
                           {{trans('access.permission_desc')}}
                              </p>
                            </td>
                          </tr>
                          <tr>
                            <td class="col-xs-3"><label>{{trans('access.show_title')}}</label></td>
                            <td class="col-xs-9"><input name="display_name" class="form-control" value=""/></td>
                          </tr>
                      </table>
                      <input type="hidden" name="edit_id" value=""/>
                  </form>

              </div>

           {{-- <div class="modal-footer">
              <div class="modal-footer">
                  <button type="button" name="saveRole" id="saveRole" value="save"
                          class="btn btn-success"
                          type="button">
                      <i class="glyphicon  glyphicon-save-file bigger-125"></i>
                      <span>ذخیره</span>
                  </button>
            </div>
          </div>
        </div>
      </div>
    </div>--}}
<script>

    $(document).on('click','#saveRole',function () {
        var obj = {};
        $('#roles-form input').each(function(){
            obj[this.name] = this.value;

        });

        if ($('#roles-form input[name="edit_id"]').val()) {
            obj.id = $('#roles-form input[name="edit_id"]').val();
        }
        $.ajax({
            url: '{!! route('Access.saveRole')!!}',
            method: 'POST',
            data: obj,
            success: function (data) {
                res = JSON.parse(data);
                if (res.success == true) {

                    //$('#add_role').modal('hide');
                    roleModal.close();
                    $('#rolesGrid').DataTable().ajax.reload();
                    messageModal('success', '{{trans('app.save')}}', {0:'{{trans('access.saved_successfully')}}'});
                } else if (res.success == false) {
                    errorsFunc('{{trans('app.error')}}', res.error, {id: 'roleErrorMsg'}, 'roles-form');

                }
            }
        });
    });
</script>