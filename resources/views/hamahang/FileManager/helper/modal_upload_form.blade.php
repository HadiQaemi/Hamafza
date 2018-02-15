<!-- Modal Upload Form -->
<div class="modal fade" id="HFM_Modal" role="dialog" data-section="" data-field="">
    <input id="HFM_InputSectionName" type="hidden" name="Section" value="">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{trans('filemanager.select_and_upload_file')}}</h4>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#HFM_GridMyFiles">{{trans('filemanager.selectd_file')}}</a></li>
                    <li><a data-toggle="tab" href="#HFM_UploadNewFiles"> فایل های جدید</a></li>
                </ul>
                <div class="tab-content">
                    <div id="HFM_GridMyFiles" class="tab-pane fade in active">
                        <fieldset style="margin-top:25px;">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12" >
                                        <form id="HFM_Form_GridMyFile">
                                            <table id="HFM_GridMyFile" class="display table table-bordered " cellspacing="0" width="100%" >
                                                <thead>
                                                <tr>
                                                    <th><input name="select_all" value="1" type="checkbox"></th>
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
                            </div>
                            <div class="clearfix"></div>
                        </fieldset>
                        <div class="row-fluid" style="margin-top: 15px;">
                            <hr>
                            <div class="col-xs-12">
                                <button id="HFM_AddSelectedFilesSubmitBtn" name="upload_files" value="upload" class="btn btn-primary pull-left" type="button">
                                    <span>{{trans('filemanager.add_files_selected')}}</span>
                                </button>
                                <!--
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{trans('filemanager.cancel')}}</button>
                                -->
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div id="HFM_UploadNewFiles" class="tab-pane fade">
                        <fieldset style="margin-top:25px;">
                            <form method="post" id="HFM_UploadForm" enctype="multipart/form-data">
                                <div class="col-xs-12">
                                    {{
                                        Form::file(
                                            'Attachments[]',
                                            array(
                                                'multiple'              => true,
                                                'id'                    => 'id_input_files',
                                                'class'                 => 'filestyle',
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
                            <div id="HFM_UploadProgress" class="progress" style="display: none;">
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
                                <button id="HFM_UploadFormSubmitBtn" name="upload_files" value="upload" class="btn btn-primary pull-left" type="button">
                                    <span>{{trans('filemanager.upload_files_selected')}}</span>
                                </button>
                                <!--
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{trans('filemanager.cancel')}}</button>
                                -->
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="HFM_ResultUploadFiles" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{trans('filemanager.file_uploaded_result')}}</h4>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <div class="col-xs-12">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#success_upload_content">{{trans('filemanager.uploded')}}</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#error_upload_content">خطاها</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="error_upload_content" class="tab-pane fade " style="max-height: 300px;
							overflow-y: scroll;">
                                {{--<div class="space-10"></div>--}}
                                <table id="failed_upload_files" class="table table-striped table-bordered dt-responsive nowrap display" width="100%">
                                    <thead style="visibility: hidden; display: none;">
                                    <tr style="visibility: hidden; display: none;">
                                        <th style="visibility: hidden; display: none;">{{trans('filemanager.error')}}</th>
                                    </tr>
                                    </thead>
                                </table>
                           </div>
                            <div id="success_upload_content" class="tab-pane fade in active" style="max-height:
							300px; overflow-y: scroll;">
                                <div class="space-10"></div>
                                <table id="success_upload_files" class="table table-striped table-bordered dt-responsive nowrap display" width="100%">
                                    <thead>
                                    <tr>
                                        <th>{{trans('filemanager.title')}}</th>
                                        <th>{{trans('filemanager.file_postfix')}}</th>
                                        <th>{{trans('filemanager.file_size')}}</th>
                                        <th>{{trans('filemanager.download')}}</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="clearfixed"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">
                    <span>{{trans('filemanager.accept')}}</span>
                </button>
            </div>
        </div>
    </div>
</div>