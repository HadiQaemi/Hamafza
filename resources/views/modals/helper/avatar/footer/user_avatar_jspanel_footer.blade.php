<div class="col-xs-12">
    <div class="pull-left">
        @if(isset($user->avatar) &&!empty($user->avatar) &&($user->avatar!=null) &&($user->avatar!=0) )
        <button type="button" class="btn btn-primary remove_avatar_image">{{ trans('profile.delete_profile') }}</button>
         @else
            <button type="button" id="footer_selec_avatar" class="btn btn-primary select_file">{{ trans('profile.select_file') }}</button>
        @endif
            <button type="button" class="btn btn-primary btn_save_avatar">{{ trans('profile.change_profile_and_save') }}</button>



    </div>
</div>
<script>
    $('#input_file_avatar').trigger( "click" );
</script>