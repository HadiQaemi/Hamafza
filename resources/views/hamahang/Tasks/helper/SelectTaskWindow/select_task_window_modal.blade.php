<style>
    #filter_box span {
        float: right;
        font-size: 9px;
    }
    #filter_box input[type=checkbox] {
        transform: scale(0.7);
        padding: 0px;
        margin-left: 0px;
    }
</style>
<div class="row" id="JSPanelContentArea">
    <div id="select_window_content" style="padding: 15px">
        <div class="row" style="height:100%;z-index: 100001">
            <div class="col-md-3">
                <hr/>
                <div class="row" style="text-align: center">
                    <span style="color: royalblue">{{ trans('tasks.selected_items') }} : </span>
                    <span id="selected_items_count">0</span>
                </div>
                <hr/>
                <div class="row">
                    <div>
                        <input type="radio" name="tasks_assign_type" onchange="do_filter()" checked value="1" />
                        <span>ارجاعی ها</span>
                        <input type="radio" name="tasks_assign_type" onchange="do_filter()"  value="2"/>
                        <span>اقدامی ها</span>
                    </div>
                </div>
                <hr/>
                <div id="jstree_div"></div>
            </div>
            <div class="col-md-9">
                <div class="row col-md-12" style="background-color: #efefef">
                    <table>
                        <tr>
                            <td style="padding: 0">
                                <div id="filter_box">
                                    <span><input type="checkbox" onclick="selected_task_status(0)" id="not_started"/> {{trans('tasks.status_not_started')}} </span>
                                    <span><input type="checkbox" onclick="selected_task_status(1)" id="started"/> {{trans('tasks.status_started')}} </span>
                                    <span><input type="checkbox" onclick="selected_task_status(2)" id="was_done"/> {{trans('tasks.status_done')}} </span>
                                    <span><input type="checkbox" onclick="selected_task_status(3)" id="completed"/> {{trans('tasks.status_finished')}} </span>
                                    <span><input type="checkbox" onclick="selected_task_status(4)" id="stopped"/> متوقف </span>
                                    <span style="font-size: 18px;font-weight: bolder;padding: 0px;margin-right: 7px"> | </span>
                                    <span><input type="checkbox" onclick="selected_task_immediate(1)" id="immediate" style="margin-right: 0"/> فوری </span>
                                    <span><input type="checkbox" onclick="selected_task_immediate(0)" id="non_immediate"/> غیرفوری </span>
                                    <span><input type="checkbox" onclick="selected_task_importance(1)" id="important"/> مهم </span>
                                    <span><input type="checkbox" onclick="selected_task_importance(0)" id="non_important"/> غیرمهم </span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="row col-md-12">
                    <input type="text" class="form-control" onkeyup="do_filter()" id="title" name="title" style="margin-top: 8px" placeholder="{{trans('tasks.can_select_some_options')}}"/>
                </div>
                <div class="row col-md-12" style="min-height: 100%;padding: 10px">
                    <table id="select_task_window_table" class="table table-striped table-bordered dt-responsive nowrap display" style="text-align: center;margin-top: 15px;" width="100%">
                        <thead>
                        <tr>
                            <th>انتخاب</th>
                            <th>عنوان وظیفه</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@include('hamahang.Tasks.helper.SelectTaskWindow.select_task_window_js')

