<div>
                <!---------------->
                <div id="tab" class="container table-bordered" style="width: 95%">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#t1" data-toggle="tab">اطلاعات</a>
                        </li>
                        <li>
                            <a href="#t2" data-toggle="tab"> وظایف مرتبط</a>
                        </li>
                        <li><a href="#t4" data-toggle="tab">افزودن رابطه</a>
                        </li>
                        <li><a href="#t5" data-toggle="tab">نمایش سلسله مراتبی وظایف</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" style="padding-top: 8px" id="t1">
                            <table class="table table-bordered col-md-12">
                                <tr>
                                    <td>{{ trans('general.title') }}</td>
                                    <td>
                                        <input type="text" id="project_title" class="form-control" disabled/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('general.type') }}</td>
                                    <td>
                                        <input type="text" id="project_type" class="form-control" disabled/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('general.description') }}</td>
                                    <td>
                                        <input type="text" id="project_desc" class="form-control" disabled/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('general.page') }}</td>
                                    <td>
                                        <input type="text" id="project_page" class="form-control" disabled/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('projects.project_manager') }}</td>
                                    <td>
                                        <input type="text" id="project_manager" class="form-control" disabled/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('projects.schedule_base') }}</td>
                                    <td>
                                        <input type="text" id="project_schedule_base" class="form-control"
                                               disabled/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('projects.start_date') }}</td>
                                    <td>
                                        <input type="text" id="project_start_date" class="form-control" disabled/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('projects.end_date') }}</td>
                                    <td>
                                        <input type="text" id="project_end_date" class="form-control" disabled/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('projects.base_calendar') }}</td>
                                    <td>
                                        <input type="text" id="project_base_calendar" class="form-control"
                                               disabled/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('general.keywords') }}</td>
                                    <td>
                                        <input type="text" id="project_keywords" class="form-control" disabled/>
                                    </td>
                                </tr>
                            </table>


                        </div>
                        <div class="tab-pane" id="t2" style="padding-top: 8px">
                            <div class="row" id="linked_tasks">

                            </div>
                        </div>
                        <div class="tab-pane" id="t4">
                            <div class="row-fluid" style="padding: 8px">
                                <div id="f_task"></div>
                                <div id="r_type"></div>
                                <div id="s_task"></div>
                                <div><a class="btn btn-default" onclick="SaveRelation()">درج رابطه</a></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="grid3"
                                           class="table table-striped table-bordered dt-responsive nowrap display"
                                           style="text-align: center" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>ردیف</th>
                                            <th>عنوان وظیفه مشروط</th>
                                            <th>نوع رابطه</th>
                                            <th>عنوان وظیفه شرط</th>
                                            <th>عملیات</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="t5">
                            <div class="row">
                                <table id="hirerical_view"
                                       class="table table-striped table-bordered dt-responsive nowrap display"
                                       style="text-align: center" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>نام وظیفه</th>
                                        <th>مسئول انجام</th>
                                        <th>درصد پیشرفت</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!---------------->
            </div>

@include('hamahang.Projects.helper.ProjectInfoWindow_js')