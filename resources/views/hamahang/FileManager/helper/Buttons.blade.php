<!-- _Btn______ File Manager ______Btn_ -->
<div class="row-fluid">
    <div class="filemanager-buttons-client">
        <div class="btn btn-default pull-left HFM_ModalOpenBtn" data-section="{{$section}}" data-multi_file="{{$multi_file}}" style="margin-right: 5px;">
            <i class="glyphicon glyphicon-plus-sign" style="color: skyblue"></i>
            <span>{{trans('filemanager.add_attachs')}}</span>
        </div>
        <div data-section="{{$section}}"  class="HFM_RemoveAllFileFSS_SubmitBtn btn btn-default pull-left" style=" color:#555;">
            <!--onclick="HFM_RemoveAllFFS('{{$section}}')"-->
            <i class="glyphicon glyphicon-remove-sign" style=" color:#FF6600;"></i>
            <span>{{trans('filemanager.remove_all_attachs')}}</span>
        </div>
    </div>
    <div class="pull-right filemanager-title-client">
        <h4 class="filemanager-title">{{trans('filemanager.attachs')}}</h4>
    </div>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>