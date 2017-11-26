@if(Session::has('Files'))
    <?php $Files = Session::get('Files'); $i=1;  //var_dump($Files["$section"]); die;//die(var_dump($Files)); ?>
    @if ( isset($Files[$section]) && count($Files[$section]) !=0 )
        @foreach( $Files["$section"] as $file )
            <div class="well well-sm tooltip_area" style="margin: 2px 5px; float: right; position: relative;">
                <div style="position: absolute; left: -8px; bottom: -8px; cursor: pointer;"
                    href="{{URL::route('FileManager.RemoveFileFromSession',array('section'=> enCode($section),'record'=>enCode($file['ID'])))}}"
                    onclick="RemoveFileFS('ID_UploadedFile_{{++$i}}','{{enCode($section)}}','{{enCode($file['ID'])}}')"
                    class="text-danger RemoveFFS-Btn" 
                    id="ID_UploadedFile_{{$i}}">
                    <i class="glyphicon glyphicon-remove"></i>
                </div>
                <div class="tooltip_text">
                    @if( isset($file['Icon']) && $file['Icon'] == "glyphicon glyphicon-picture" )
                    <div> <img style="height:120px; width:170px;" src="{{URL::route('FileManager.DownloadFile', array('type'=>'ID','id'=>enCode($file['ID'])))}}"></div>
                    @else
                    <div style="height:45px; width:170px; direction:ltr;"><h5> <span>{{$file['Size']}}</span></h5><h5>{{$file['MimeType']}}</h5></div>
                    @endif
                </div>
                <i style="cursor: default;" class="{{isset($file['Icon'])?$file['Icon']:'glyphicon glyphicon-file'}}"></i>
                <span>{{$file['OrginalFileName']}}</span>
            </div>
        @endforeach
    @else
        <div style="color: #888a85;">{{trans('filemanager.attachment_not_found')}}</div>
    @endif
@else
    <div style="color: #888a85;">{{trans('filemanager.attachment_not_found')}}</div>
@endif