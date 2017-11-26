<style>
    .remove_avater{
        color: red;
        font-size: 17px;
        cursor: pointer;
    }
</style>
<div class="show_avatar_image" style="width:300px; margin: 10px auto">
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('profile.your_avatar_image') }}</div>
        <div class="panel-body" style="padding-top:6px;" >
            @if(isset($user->avatar) &&!empty($user->avatar) &&($user->avatar!=null) &&($user->avatar!=0) )
                <span class="fa fa-times remove_avater remove_avatar_image"></span>

            @endif

            <img class="img_avatar" style="width: 100%; height: 100%; position: relative;cursor: pointer; cursor:{{URL('img/pen_edit.png')}}"  title="@if($user->avatar_info){{ $user->avatar_info->originalName }}@endif" src="{{$user->AvatarLink}}">
        </div>
        <div class="panel-footer">
            {{-- <a class="btn btn-danger fa fa-remove remove_avatar_image" title="{{ trans('profile.remove_profile_avatar') }}" style="margin-right: 10px;"></a>--}}
            <input type="hidden" class="avatar_image_id" value="@if($user->avatar_info){{ $user->avatar_info->id }}@endif">
           <span style="font-size: 11px;">{{ trans('profile.avatar_title') }}:</span> <span value="">
                @if(isset($user->avatar) &&!empty($user->avatar) &&($user->avatar!=null) &&($user->avatar!=0) )
                    @if($user->avatar_info){{ $user->avatar_info->originalName }}@else تصویر پیش‌فرض @endif
                    @else {{ trans('profile.no_select_picture') }}
                @endif
            </span>
           {{--  <a class="btn btn-info fa fa-edit edit_avatar_image_originalName" title="@if($user->avatar_info){{ trans('profile.change_profile_avatar_name') }}@endif" style="margin-right: 10px;"></a>--}}
        </div>
    </div>
</div>

<div class="upload_form" style="width:300px; margin: 10px auto">

    <div class="panel panel-default ">
        <div class="panel-body">
            <h5 style="padding-bottom: 10px">{{ trans('profile.select_new_avatar_image') }}</h5>
            <form method="Post" enctype="multipart/form-data" id="avatar_form" action="#">
                <input id="input_file_avatar" class="form-control filestyle" type="file" name="avatar">
            </form>
        </div>
    </div>
</div>

@include('modals.helper.avatar.inline_js.user_avatar_inline_js')