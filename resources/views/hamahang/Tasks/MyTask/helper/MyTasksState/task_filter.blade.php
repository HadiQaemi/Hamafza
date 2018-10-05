<div class="col-xs-12">
    <div class="row form_filter_priority_div">
        <form id="form_filter_priority">
            <div class="row padding-bottom-20 opacity-7">
                <i class="fa fa-calendar-minus-o int-icon3"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <input type="text" class="form-control int-btm-brd" style="padding: 6px 20px;" id="title" name="title" placeholder="{{trans('tasks.search_title')}}" autocomplete="off">
                </div>
                <i class="fa fa-tags int-icon2"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="new_task_keywords" class="select2_auto_complete_keywords" name="keywords[]"
                            data-placeholder="{{trans('tasks.search_keyword_task')}}" multiple="multiple"></select>
                </div>
                <i class="fa fa-users int-icon1"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="new_task_users_all_tasks" name="users[]" class="select2_auto_complete_user col-xs-12"
                            data-placeholder="{{trans('tasks.search_some_persons')}}" multiple>
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="row opacity-7">
                <div class="form-inline" style="" >
                    <div class="checkbox pull-right">
                        <div class="form-inline">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="form-check-input official_type" name="official_type[]" value="0" id="official" checked>
                                    <span>{{trans('tasks.official')}}</span>
                                </label>
                                <label>
                                    <input type="checkbox" class="form-check-input official_type" name="official_type[]" value="1" id="unofficial" checked>
                                    <span>{{trans('tasks.unofficial')}}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="checkbox pull-right margin-right-50">
                        <label>
                            {{--<input type="checkbox" class="form-check-input" value="0" name="task_important[]" id="not_started_tasks" checked>--}}
                            <input type="checkbox" class="form-check-input task_important" value="1" name="task_important[]" checked>
                            <span>{{trans('tasks.important')}}</span>
                        </label>
                        <label>
                            {{--<input type="checkbox" class="form-check-input" value="1" name="task_important[]" id="not_started_tasks" checked>--}}
                            <input type="checkbox" class="form-check-input task_important" value="0" name="task_important[]" checked>
                            <span>{{trans('tasks.non-important')}}</span>
                        </label>
                    </div>
                    <div class="checkbox pull-right margin-right-50">
                        <label>
                            {{--<input type="checkbox" class="form-check-input" value="0" name="task_immediate[]" id="not_started_tasks" checked>--}}
                            <input type="checkbox" class="form-check-input task_immediate" value="1" name="task_immediate[]" checked>
                            <span>{{trans('tasks.immediate')}}</span>
                        </label>
                        <label>
                            {{--<input type="checkbox" class="form-check-input" value="1" name="task_immediate[]" id="not_started_tasks" checked>--}}
                            <input type="checkbox" class="form-check-input task_immediate" value="0" name="task_immediate[]" checked>
                            <span>{{trans('tasks.non-immediate')}}</span>
                        </label>
                    </div>
                    <div class="checkbox pull-right margin-right-50">
                        <label>
                            <input type="checkbox" class="form-check-input task_status" value="0" name="task_status[]" id="not_started_tasks" checked>
                            <span>{{trans('tasks.status_not_started')}}</span>
                        </label>
                        <label>
                            <input type="checkbox" class="form-check-input task_status" value="1" name="task_status[]" id="started_tasks" checked>
                            <span>{{trans('tasks.status_started')}}</span>
                        </label>
                        <label>
                            <input type="checkbox" class="form-check-input task_status" value="2" name="task_status[]" id="done_tasks" checked>
                            <span>{{trans('tasks.status_done')}}</span>
                        </label>
                        <label>
                            <input type="checkbox" class="form-check-input task_status" value="3" name="task_status[]" id="completed_tasks" checked>
                            <span>{{trans('tasks.status_finished')}}</span>
                        </label>
                        <label>
                            <input type="checkbox" class="form-check-input task_status" value="4" name="task_status[]" id="stoped_tasks">
                            <span>{{trans('tasks.status_suspended')}}</span>
                        </label>
                    </div>
                    {{--</div>--}}
                </div>
            </div>
        </form>
    </div>
    {{--<form id="form_filter_priority">--}}
        {{--<div class="form-inline">--}}
            {{--<input type="text" class="form-control mx-sm-3" placeholder="{{trans('tasks.search_in_task_title_placeholder')}}" name="task_title" id="task_title">--}}
            {{--<input type="number" placeholder="مهلت" class="form-control " style="width: 80px;" name="respite" id="respite">--}}
            {{--<div class="checkbox">--}}
                {{--<label>--}}
                    {{--<input type="checkbox" class="form-check-input" name="official_type[]" value="0" id="official" checked>--}}
                    {{--<span>{{trans('tasks.official')}}</span>--}}
                {{--</label>--}}
                {{--<label>--}}
                    {{--<input type="checkbox" class="form-check-input" name="official_type[]" value="1" id="unofficial" checked>--}}
                    {{--<span>{{trans('tasks.unofficial')}}</span>--}}
                {{--</label>--}}
            {{--</div>--}}
            {{--<div class="checkbox" style="margin-right: 15px;">--}}
            {{--<label>--}}
                {{--<input type="checkbox" class="form-check-input" value="0" name="task_important[]" id="not_started_tasks" checked>--}}
                {{--<input type="checkbox" class="form-check-input" value="1" name="task_important[]" checked>--}}
                {{--<span>{{trans('tasks.important')}}</span>--}}
            {{--</label>--}}
            {{--<label>--}}
                {{--<input type="checkbox" class="form-check-input" value="1" name="task_important[]" id="not_started_tasks" checked>--}}
                {{--<input type="checkbox" class="form-check-input" value="0" name="task_important[]" checked>--}}
                {{--<span>{{trans('tasks.non-important')}}</span>--}}
            {{--</label>--}}
            {{--</div>--}}
            {{--<div class="checkbox" style="margin-right: 15px;">--}}
            {{--<label>--}}
                {{--<input type="checkbox" class="form-check-input" value="0" name="task_immediate[]" id="not_started_tasks" checked>--}}
                {{--<input type="checkbox" class="form-check-input" value="1" name="task_immediate[]" checked>--}}
                {{--<span>{{trans('tasks.immediate')}}</span>--}}
            {{--</label>--}}
            {{--<label>--}}
                {{--<input type="checkbox" class="form-check-input" value="1" name="task_immediate[]" id="not_started_tasks" checked>--}}
                {{--<input type="checkbox" class="form-check-input" value="0" name="task_immediate[]" checked>--}}
                {{--<span>{{trans('tasks.non-immediate')}}</span>--}}
            {{--</label>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</form>--}}
</div>



