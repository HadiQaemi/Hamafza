<div class="modal fade" id="select_tasks" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">پنجره انتخاب وظایف</h4>
            </div>
            <div class="modal-body">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span>انتخاب وظایف</span>
                        </div>
                        <div class="panel-body">
                            <div class="row row-fluid">
                                <div class="col-xs-3" style="border-left: 1px solid gainsboro ">
                                    <div>
                                        <p>انتخاب شده ها : </p><span id="selected_tasks_count">0</span>
                                    </div>
                                    <hr/>
                                    <div>
                                        <a onclick="refresh_data(1)" class="">همه</a><br/>
                                        <a onclick="refresh_data(2)" class="">وظایف {{trans('tasks.status_started')}}</a><br/>
                                        <a onclick="refresh_data(3)" class="">وظایف {{trans('tasks.status_not_started')}}</a><br/>
                                        <a onclick="refresh_data(11)" class="">مهم و فوری</a><br/>
                                        <a onclick="refresh_data(22)" class="">مهم و غیرفوری</a><br/>
                                        <a onclick="refresh_data(33)" class="">فوری و غیرمهم</a><br/>
                                        <a onclick="refresh_data(44)" class="">غیرفوری و غیرمهم</a><br/>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h6>کلمات کلیدی : </h6>
                                            <select onchange="" id="keywords"
                                                    name="keywords[]"
                                                    class="col-xs-12"
                                                    data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-9">
                                    <div class="row-fluid">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table id="MyTasksGrid" class="table table-condensed table-hover table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th data-column-id="id" data-type="numeric" data-identifier="true">شماره وظیفه</th>
                                                            <th data-column-id="title">نام وظیفه</th>
                                                            <th data-column-id="ass_id">پسوند</th>
                                                            <th data-column-id="link" data-formatter="link" data-sortable="false">عملیات</th>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="pull-left"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('filemanager.cancel')}}</button>
                <a class="btn btn-default" onclick="add_task_to_package()">درج موارد انتخاب شده در بسته کاری</a>
            </div>
        </div>
    </div>
</div>