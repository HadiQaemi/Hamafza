<div class="modal fade" id="modal_minutes_dialog">
    <div class="modal-dialog modal-lg" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span>{{trans('calendar_events.ce_modal_minutes_header_title')}}</span>:
                    <span class="bg-warning"
                          style="padding:2px 10px; margin-right: 10px;"></span>
                </h4>
            </div><!-- end modal header -->
            <div class="modal-body">

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#decisions">{{trans('calendar_events.ce_modal_minutes_navbar_nav1')}}</a></li>
                    <li><a href="#tasks" data-toggle="tab">{{trans('calendar_events.ce_modal_minutes_navbar_nav2')}}</a></li>
                    <li><a href="#absent" data-toggle="tab">{{trans('calendar_events.ce_modal_minutes_navbar_nav3')}}</a></li>
                    <li><a href="#guest" data-toggle="tab"> {{trans('calendar_events.ce_modal_minutes_navbar_nav4')}} </a></li>
                </ul>

                <div class="tab-content">
                    <div id="decisions" class="tab-pane fade in active">
                        <div class="col-md-12" id="decisionBreadCrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active"><a href="#">{{trans('calendar_events.ce_modal_minutes_desicion_title')}}</a></li>

                            </ol>

                            </div>
                        <button id="addDecisionBtn" class="center-block btn btn-info    pull-left" onclick="newDecision()" type="button">
                            {{trans('calendar_events.ce_modal_minutes_desicion_add')}}
                        </button>

                        <table class="table table-bordered table-striped col-md-12" id="decisionGrid">
                            <thead>
                            <th>  {{trans('calendar_events.ce_rowindex_label')}}</th>
                            <th> {{trans('calendar_events.ce_title')}}</th>
                            <th> {{trans('calendar_events.ce_action_label')}}</th>
                            </thead>
                        </table>
                        <div id="addAecision">

                            <form class="decisionForm">
                                <table class="table table-bordered table-striped col-md-12">
                                    <tbody>
                                    <tr>
                                        <td class="col-md-2">{{trans('calendar_events.ce_title')}}</td>
                                        <td class="col-md-10"><input type="text" class="form-control" name="title"/></td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-2">{{trans('calendar_events.ce_description_label')}}</td>
                                        <td class="col-md-10"><textarea name="desc" class="form-control"></textarea></td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td class="col-md-12" colspan="2">
                                            <button class="center-block btn btn-danger  fa fa-close  pull-left" onclick="backtoDecistionList()" type="button">
                                                {{trans('calendar_events.ce_dissuasion')}}
                                            </button>
                                            <button class="center-block btn btn-info  fa fa-floppy-o  pull-left" onclick="saveDecision()" type="button">
                                                 {{trans('calendar_events.saved')}}
                                            </button>

                                        </td>
                                    </tr>

                                    </tfoot>


                                </table>
                            </form>

                        </div>

                        <div id="tasklist" >
                            <div class="row-fluid " >
                                <div class="col-md-12 decisionTitle"/>
                                <span> {{trans('calendar_events.ce_modal_minutes_desicion')}}</span>
                                <span style="font-weight: 800px; font-size: 16px;"></span>
                            </div>
                            <div id="taskForm">
                                <form action="user_tasks" method="POST" id="add_task_form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="event_id" value="">
                                    <input type="hidden" name="decision_id" value="">
                                    <table class="table table-bordered table-striped col-md-12">
                                        <tbody>
                                        <tr>
                                            <td class="col-md-6">
                                                <input type="text" class="form-control " placeholder="{{trans('calendar_events.ce_modal_minutes_task_title')}}" name='task_title'
                                                       id="new_task_title"/>
                                            </td>
                                            <td class="col-md-6">
                                                <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class=""></i>
                                                </span>
                                                    <select id="states-multi-select-users"
                                                            name="users[]"
                                                            class="chosen-rtl col-xs-12"
                                                            data-placeholder="{{trans('tasks.select_some_options')}}"
                                                            multiple>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-4">
                                                <div class="input-group">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                                    <input type="text" class="DatePicker form-control col-md-4" placeholder="{{trans('calendar_events.ce_modal_minutes_respite')}}" dir="rtl"
                                                           id="DatePicker" name='respite_date'/>
                                                </div>
                                            </td>
                                            <td class="col-md-8">
                                                <div class=" form-inline" id="t_radio" style="">
                                                    <span style="background-color: #eeeeee;">
                                                        <input type="radio" class="form-control" name="importance" id="importance" value="1"/>
                                                        <label for="">{{trans('calendar_events.ce_modal_minutes_importance1')}}</label>

                                                        <input type="radio" class="form-control" name="importance" id="importance" value="0"/>
                                                        <label for="">{{trans('calendar_events.ce_modal_minutes_importance2')}}</label>
                                                    </span>
                                                    <span style="">|</span>
                                                    <span style="background-color: #eeeeee">

                                                    <input type="radio" class="form-control" name="immidiate" id="immidiate" value="1"/>
                                                    <label for="">{{trans('calendar_events.ce_modal_minutes_immidiate1')}}</label>

                                                    <input type="radio" class="form-control" name="immidiate" id="immidiate" value="0"/>
                                                    <label for="">{{trans('calendar_events.ce_modal_minutes_immidiate2')}}</label>
                                                </span>
                                                </div>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="col-md-12" colspan="2">
                                                <button class="center-block btn btn-danger  fa fa-close  pull-left" onclick="backtotaskDecisionGrid()" type="button">
                                                    انصراف
                                                </button>
                                                <button class="center-block btn btn-info fa fa-floppy-o  pull-left"  onclick="addNewTask();" type="button">
                                                    ذخیره
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </form>


                            </div>

                            <div class="taskGridDecision">
                                <button  id="addtaskBtn" class="center-block btn btn-info    pull-left" onclick="newTask()" type="button">
                                    افزودن وظیفه
                                </button>
                                <table class="table table-bordered table-striped col-md-12" id="taskGrid">
                                    <thead>
                                    <th> ردیف</th>
                                    <th> #</th>
                                    <th>عنوان</th>
                                    </thead>
                                </table>
                                <div id="addtask-to-decisionbtn">
                                    <button class="center-block btn btn-danger  fa fa-close  pull-left" onclick="backtoDecistionList()" type="button">
                                        انصراف
                                    </button>
                                    <button class="center-block btn btn-info  fa fa-floppy-o  pull-left" id="addtasktoDecision" onclick="addtasktoDecision()" type="button">
                                        اتصال به تصمیم
                                    </button>
                                    <div class="clearfixed"></div>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>
                <div id="tasks" class="tab-pane fade">

                    <table class="table table-bordered table-striped col-md-12" id="taskDecisionGrid">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>تصمیم</th>
                            <th>وظیفه</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                    </table>
                </div>


                <div id="absent" class="tab-pane fade">
                    <table class="table table-bordered table-striped col-md-12" id="sessionUserList">
                        <thead>
                        <tr>
                            <th class="col-md-1">ردیف</th>
                            <th class="col-md-8">نام کاربری</th>
                            <th class="col-md-3">حاضر /غايب</th>

                        </tr>
                        <tbody>

                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="3" class="col-md-12">
                                <button class="center-block btn btn-info  fa fa-floppy-o  pull-left" onclick="savePersentUsers()" type="button">
                                    ثبت
                                </button>
                            </td>
                        </tr>
                        </tfoot>
                        </thead>
                    </table>
                </div>
                <div id="guest" class="tab-pane fade">
                    <div>
                        <table class="table table-bordered table-striped col-md-12">
                            <tbody>
                            <tr>
                                <td class="col-md-4">
                                    <label>داخل سازمان<input name="sp" type="radio" value="1" checked="true"/></label>
                                    <label>خارج سازمان<input name="sp" type="radio" value="2"/></label>
                                </td>
                                <td class="col-md-6">
                                    <div id="inOrganization">
                                        <div class="input-group">
                    <span class="input-group-addon">
                        <i class=""></i>
                    </span>
                                            <select id="states-multi-select-users"
                                                    name="user"
                                                    class="chosen-rtl col-xs-12 form-control"
                                                    data-placeholder="{{trans('tasks.select_some_options')}}"
                                            >
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="outOrganization">
                                        <input
                                                type="text"
                                                name="user"
                                                placeholder="نام و نام خانوادگی مهمان"
                                                class="form-control"
                                        >
                                    </div>

                                </td>
                                <td class="col-md-2">
                                    <button class="center-block btn btn-info  fa fa-floppy-o  pull-left" onclick="saveGuest()" type="button">
                                        ذخیره
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div>
                            <table class="table table-bordered table-striped col-md-12" id="guestGrid">
                                <thead>
                                <th> ردیف</th>
                                <th>نام کاربری/نام نام خانوادگی</th>
                                <th>عملیات</th>
                                </thead>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div><!-- end body  -->
        <div class="modal-footer">
        </div><!-- end footer  -->
    </div><!-- end modal content -->
</div><!-- end role  -->
</div><!-- end modl -->