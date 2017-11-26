@if($btn_type=='addRole')
    <div >
        <button type="button" name="saveRole" id="saveRole" value="save" class="btn btn-info"'+
        type="button">
        <i class="glyphicon  glyphicon-save-file bigger-125"></i>
        <span>{{trans('app.save')}}</span>
        </button>
        </div>
    @elseif($btn_type=='new_permission')
    <button type="button" name="savePermission" id="savePermission"
            class="btn btn-info"
            type="button">
        <i class="glyphicon  glyphicon-save-file bigger-125"></i>
        <span>{{ trans('app.register') }}</span>
    </button>
@elseif($btn_type=='new_user_role')
    <button type="button" name="saveUser-Role" id="saveUser-Role"
            class="btn btn-info"
            type="button">
        <i class="glyphicon  glyphicon-save-file bigger-125"></i>
        <span>{{ trans('app.register') }}</span>
    </button>
@elseif($btn_type=='new_user_role')
    <button type="button" name="savePermission-Role" id="savePermission-Role"
            class="btn btn-info"
            type="button">
        <i class="glyphicon  glyphicon-save-file bigger-125"></i>
        <span>{{ trans('app.register') }}</span>
    </button>
@endif