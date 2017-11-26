
                <div class="container " style="width: 95%">

                  <form id="permission-form" class="form">
                      <div id="permissionErrorMsg">

                      </div>
                      <table class="table  col-xs-12">
                          <tr>
                            <td class="col-xs-3">

                              <label>{{trans('access.permission_title')}}</label>
                            </td>
                            <td class="col-xs-9"><input name="name" value="" class="form-control"/>
                              <p  class="form-text text-muted">
                                  {{trans('access.permission_desc')}}
                               </p>
</p>
</td>
                          </tr>
                          <tr>
                            <td class="col-xs-3"><label>{{trans('access.show_title')}}</label></td>
                            <td class"col-xs-9"><input name="display_name" class="form-control" value=""/></td>
                          </tr>
                          <tr>
                            <td class="col-xs-3"><label>{{trans('access.description')}} </label></td>
                            <td class"col-xs-9"><textarea name="description" class="form-control"></textarea></td>
                          </tr>
                      </table>
                      <input type="hidden" name="edit_id" value=""/>
                  </form>
              </div>

            </div>
<script>
    /*################################################################################################################*/
    /*---------------------------------------------------------------------------------------------------------------*/
    /*----------------------------save roles event ------------------------------------------------------------------------------*/
    /*---------------------------------------------------------------------------------------------------------------*/
    $(document).on('click','#savePermission',function () {
        var obj = {};
        obj.name = $('#permission-form input[name="name"]').val();
        obj.display_name = $('#permission-form input[name="display_name"]').val();
        obj.description = $('#permission-form textarea[name="description"]').val();
        if ($('#permission-form input[name="edit_id"]').val()) {
            obj.id = $('#permission-form input[name="edit_id"]').val();
        }
        $.ajax({
            url: '{!! route('Access.savePermission')!!}',
            method: 'POST',
            data: obj,
            success: function (data) {
                res = JSON.parse(data);
                if (res.success == true) {
                    //$('#add_permission').modal('hide');
                    permissionModal.close();
                    $('#permissionGrid').DataTable().ajax.reload();
                    messageModal('success', '{{trans('app.save')}}',{0:'{{trans('access.add_permission')}}' });
                } else if (res.success == false) {
                    $('#permissionErrorMsg').empty();
                    errorsFunc('{{trans('app.error')}}', res.error, {id: 'permissionErrorMsg'}, 'permission-form');


                }
            }
        });
    });
</script>