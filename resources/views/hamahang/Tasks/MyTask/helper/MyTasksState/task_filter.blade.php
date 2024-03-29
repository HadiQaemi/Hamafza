    <div class="row" style="margin-top: -10px;background: #eee">
        <form id="form_filter_priority">
            <div class="row padding-bottom-20 opacity-7">
                <i class="fa fa-calendar-minus-o int-icon3"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <input type="text" class="form-control int-btm-brd" value="{{(Session::get('AllTaskTitle')) ? Session::get('AllTaskTitle') : ''}}" style="padding: 6px 20px;" id="title" name="title" placeholder="{{trans('tasks.search_title')}}" autocomplete="off">
                </div>
                <i class="fa fa-tags int-icon2"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="new_task_keywords" class="select2_auto_complete_keywords" name="keywords[]"
                            data-placeholder="{{trans('tasks.search_keyword_task')}}" multiple="multiple">
                        @if(Session::exists('AllTaskTaskKeywords'))
                            @foreach(Session::get('AllTaskTaskKeywords')  as $key => $value)
                                @foreach($value  as $index => $option)
                                    <option value="{{$index}}" selected>{{$option}}</option>
                                @endforeach
                            @endforeach
                        @endif
                    </select>
                </div>
                <i class="fa fa-users int-icon1"></i>
                <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                    <select id="new_task_users_all_tasks" name="users[]" class="select2_auto_complete_user col-xs-12"
                            data-placeholder="{{trans('tasks.search_some_persons')}}" multiple>
                        @if(Session::exists('AllTaskTaskUsers'))
                            @foreach(Session::get('AllTaskTaskUsers')  as $key => $value)
                                @foreach($value  as $index => $option)
                                    <option value="{{$index}}" selected>{{$option}}</option>
                                @endforeach
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="row opacity-7">
                <div class="form-inline" style="" >
                    <div class="pull-right" style="margin-top: 10px;">
                        <label class="container-checkmark">
                            <input type="checkbox" checked="checked" class="form-check-input" name="official_type[]" value="0" id="official" checked>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="pull-right" style="margin-top: 10px;">
                        <span>{{trans('tasks.official')}}</span>
                    </div>
                    <div class="pull-right" style="margin-top: 10px;">
                        <label class="container-checkmark">
                            <input type="checkbox" checked="checked" class="form-check-input" name="official_type[]" value="1" id="unofficial" checked>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="pull-right" style="margin-top: 10px;">
                        <span>{{trans('tasks.unofficial')}}</span>
                    </div>
                    <div class="checkbox pull-right margin-right-50">
                        <div class="pull-right">
                            <span style="margin-top: 10px;display: block;">{{trans('tasks.priority')}}</span>
                        </div>
                    </div>
                    <div class="checkbox pull-right margin-right-15 ">
                        <label class="container-checkmark">
                            <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="3" name="task_important_immediate[]" checked>
                            <span class="checkmark" style="background: red;" data-toggle="tooltip" title="{{trans('tasks.important').'-'.trans('tasks.immediate')}}"></span>
                        </label>
                        <label class="container-checkmark">
                            <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="2" name="task_important_immediate[]" checked>
                            <span class="checkmark" style="background: #ce8923" data-toggle="tooltip" title="{{trans('tasks.important').'-'.trans('tasks.non-immediate')}}"></span>
                        </label>
                    </div>
                    <div class="checkbox pull-right margin-right-10">
                        <label class="container-checkmark">
                            <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="1" name="task_important_immediate[]" checked>
                            <span class="checkmark" style="background: #caca2b" data-toggle="tooltip" title="{{trans('tasks.non-important').'-'.trans('tasks.immediate')}}"></span>
                        </label>
                        <label class="container-checkmark">
                            <input type="checkbox" checked="checked" class="form-check-input task_important_immediate" value="0" name="task_important_immediate[]" checked>
                            <span class="checkmark" data-toggle="tooltip" title="{{trans('tasks.non-important').'-'.trans('tasks.non-immediate')}}"></span>
                        </label>
                    </div>

                    {{--<div class="checkbox pull-right margin-right-50">--}}
                        {{--<label>--}}
                            {{--<input type="checkbox" class="form-check-input task_status" value="0" name="task_status[]" id="not_started_tasks" checked>--}}
                            {{--<span>{{trans('tasks.status_not_started')}}</span>--}}
                        {{--</label>--}}
                        {{--<label>--}}
                            {{--<input type="checkbox" class="form-check-input task_status" value="1" name="task_status[]" id="started_tasks" checked>--}}
                            {{--<span>{{trans('tasks.status_started')}}</span>--}}
                        {{--</label>--}}
                        {{--<label>--}}
                            {{--<input type="checkbox" class="form-check-input task_status" value="2" name="task_status[]" id="done_tasks" checked>--}}
                            {{--<span>{{trans('tasks.status_done')}}</span>--}}
                        {{--</label>--}}
                        {{--<label>--}}
                            {{--<input type="checkbox" class="form-check-input task_status" value="3" name="task_status[]" id="completed_tasks" checked>--}}
                            {{--<span>{{trans('tasks.status_finished')}}</span>--}}
                        {{--</label>--}}
                        {{--<label>--}}
                            {{--<input type="checkbox" class="form-check-input task_status" value="4" name="task_status[]" id="stoped_tasks">--}}
                            {{--<span>{{trans('tasks.status_suspended')}}</span>--}}
                        {{--</label>--}}
                    {{--</div>--}}
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



