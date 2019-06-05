<div id="tab" class="row table-bordered" style="border-bottom: none">
    <ul class="nav nav-tabs">
        <li class="active" id="define">
            <a href="#tab_t1" data-toggle="tab">{{trans('filemanager.selectd_file')}}</a>
        </li>
        <li>
            <a href="#tab_t2" class="tab_t2" data-toggle="tab">{{trans('filemanager.new_file')}}</a>
            {{--<a href="#" data-toggle="tab">تنظیم</a>--}}
        </li>
    </ul>
    <form action="{{ route('hamahang.tasks.save_task') }}" class="" name="HFM_JsFrame" id="HFM_JsFrame" method="post"
          enctype="multipart/form-data">
        <input type="hidden" id="item_id" name="item_id" value="{{ $item }}">
        <div class="tab-content new-task-form">
            <div class="tab-pane active tab-view" id="tab_t1">
                <div class="row-fluid">
                    <div class="col-xs-12">
                        <button id="HFM_AddSelectedFilesSubmitBtn" name="upload_files" value="upload"
                                class="btn btn-primary pull-left" type="button">
                            <span>{{trans('filemanager.add_files_selected')}}</span>
                        </button>
                    </div>
                </div>
                <div class="col-xs-12">
                    <form class="HFM_Form_GridMyFile">
                        <table class="HFM_GridMyFile display table table-bordered" id="HFM_GridMyFile"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                {{--<th><input name="select_all" value="1" type="checkbox"></th>--}}
                                <th></th>
                                <th>{{trans('filemanager.file_name')}} </th>
                                <th> {{trans('filemanager.file_postfix')}} </th>
                                <th>{{trans('filemanager.file_type')}} </th>
                                <th>{{trans('filemanager.file_size')}} </th>
                                <th>{{trans('filemanager.action')}} </th>
                            </tr>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
            <div class="tab-pane tab-view" id="tab_t2">
                <fieldset style="margin-top:25px;">
                    <form method="post" class="HFM_UploadForm" enctype="multipart/form-data">
                        <input type="hidden" id="item_id" name="item_id" value="{{ deCode($item) }}">
                        <div class="col-xs-12">
                            {{
                                Form::file(
                                    (deCode($act)=='page_image' ? 'image' : 'Attachments[]'),
                                    array(
                                        'multiple'              => (deCode($item)=='' ? false : true),
                                        //'id'                    => 'id_input_files',
                                        'class'                 => 'filestyle id_input_files',
                                        'data-buttonText'       => trans('filemanager.select_file'),
                                        //'data-iconName'         => 'fa fa-inbox',
                                        'data-buttonName'       => 'btn btn-primary',
                                        'data-size'             => 'sm',
                                        'buttonBefore'          => 'true',
                                        'data-input'            => 'true',
                                        'data-placeholder'      => trans('filemanager.select_your_files')
                                    )
                                )
                            }}
                        </div>
                        <div class="clearfix"></div>
                    </form>
                    <div class="clearfix"></div>
                    <div id="HFM_UploadProgress" class="progress hidden">
                        <div id="HFM_progress_bar"
                             class="progress-bar progress-bar-striped active"
                             role="progressbar"
                             aria-valuenow="40"
                             aria-valuemin="0"
                             aria-valuemax="100"
                             style="width:0%">
                            <span id="HFM_progress_text"></span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </fieldset>
                <div class="row-fluid" style="margin-top: 15px;">
                    <hr>
                    <div class="col-xs-12">
                        <button id="{{deCode($act) == 'page_image' ? 'btn_save_image' : 'HFM_UploadFormSubmitBtn'}}" name="upload_files" value="upload"
                                class="btn btn-primary pull-left" type="button">
                            <span>{{trans('filemanager.upload_files_selected')}}</span>
                        </button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <input id="HFM_InputSectionName" type="hidden" name="Section" value="{{enCode('page_file')}}">
        </div>
    </form>
</div>
<script type="text/javascript" src="{{URL::to('assets/Packages/bootstrap/js/bootstrap-filestyle.js')}}"></script>
{{--@include('hamahang.FileManager.helper.JavaScripts');--}}
<script>
    $(document).ready(function () {
        $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute; left: 40px; top: -3px;"><a href="{!! url('/modals/helpview?code=').enCode('397') !!}" title="راهنمای اینجا" class="jsPanels icon-help HelpIcon" style="float: left; padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');

        $('.tab_t2').click();
        loadMyFiles();

        function loadMyFiles() {
            window.table_chart_grid2 = $('#HFM_GridMyFile').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    'url': "{!! route('FileManager.LoadMyFiles') !!}",
                    "type": "POST",
                    "data": {'act': '{{isset($act) ? $act : ''}}'},
                },
                "autoWidth": false,
                "language": LangJson_DataTables,
                "processing": true,
                'columns': [
                    {
                        "data": "id",
                        "bSearchable": false,
                        "bSortable": false,
                        "mRender": function (data, type, full) {
                            var id = full.id;
                            return "<input name='select_files[]' class='select_files' value='" + id + "' type='checkbox'>";//"<i class='fa fa-remove margin-left-10'></i> <i class='fa fa-edit'></i>";
                        }
                    },
                    {data: 'originalName'},
                    {data: 'extension'},
                    {data: 'mimeType'},
                    {data: 'size'},
                    {data: 'created_at'}
                ],
            });
        }
    });

</script>