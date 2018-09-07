<div class="row">
    <form id="form_filter_priority">
        <div class="form-inline" style="padding-right: 5px;" >
            <div class="checkbox hidden" style="margin-right: 30px;">
                <label>
                    {{--<input type="checkbox" class="form-check-input" value="0" name="task_important[]" id="not_started_tasks" checked>--}}
                    <input type="checkbox" class="form-check-input" value="1" name="task_important[]" checked>
                    <span>{{trans('tasks.important')}}</span>
                </label>
                <label>
                    {{--<input type="checkbox" class="form-check-input" value="1" name="task_important[]" id="not_started_tasks" checked>--}}
                    <input type="checkbox" class="form-check-input" value="0" name="task_important[]" checked>
                    <span>{{trans('tasks.non-important')}}</span>
                </label>
            </div>
            <div class="checkbox hidden" style="margin-right: 30px;">
                <label>
                    {{--<input type="checkbox" class="form-check-input" value="0" name="task_immediate[]" id="not_started_tasks" checked>--}}
                    <input type="checkbox" class="form-check-input" value="1" name="task_immediate[]" checked>
                    <span>{{trans('tasks.immediate')}}</span>
                </label>
                <label>
                    {{--<input type="checkbox" class="form-check-input" value="1" name="task_immediate[]" id="not_started_tasks" checked>--}}
                    <input type="checkbox" class="form-check-input" value="0" name="task_immediate[]" checked>
                    <span>{{trans('tasks.non-immediate')}}</span>
                </label>
            </div>
            {{--<div class="checkbox">--}}
                {{--<div class="form-inline">--}}
                    {{--<input type="text" class="form-control mx-sm-3" placeholder="{{trans('tasks.search_in_task_title_placeholder')}}" name="task_title" id="task_title">--}}

                    {{--<input type="number" class="form-control " placeholder="مهلت" style="width: 80px;" name="respite" id="respite">--}}
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
                {{--</div>--}}
            {{--</div>--}}
            <div class="checkbox" style="margin-right: 30px;">
                <label>
                    {{--<input type="checkbox" class="form-check-input" value="0" name="task_immediate[]" id="not_started_tasks" checked>--}}
                    <input type="checkbox" class="form-check-input" value="1" name="task_fianl[]" checked>
                    <span>{{trans('tasks.final')}}</span>
                </label>
                <label>
                    {{--<input type="checkbox" class="form-check-input" value="1" name="task_immediate[]" id="not_started_tasks" checked>--}}
                    <input type="checkbox" class="form-check-input" value="0" name="task_fianl[]" checked>
                    <span>{{trans('tasks.draft')}}</span>
                </label>
            </div>
            <div class="checkbox" style="margin-right: 20px;">
                <label>
                    <input type="checkbox" class="form-check-input" value="0" name="task_status[]" id="not_started_tasks" checked>
                    <span>{{trans('tasks.status_not_started')}}</span>
                </label>
                <label>
                    <input type="checkbox" class="form-check-input" value="1" name="task_status[]" id="started_tasks" checked>
                    <span>{{trans('tasks.status_started')}}</span>
                </label>
                <label>
                    <input type="checkbox" class="form-check-input" value="2" name="task_status[]" id="done_tasks">
                    <span>{{trans('tasks.status_done')}}</span>
                </label>
                <label>
                    <input type="checkbox" class="form-check-input" value="3" name="task_status[]" id="completed_tasks">
                    <span>{{trans('tasks.status_finished')}}</span>
                </label>
                    @if(Route::currentRouteName()=='ugc.desktop.hamahang.tasks.my_assigned_tasks.priority')
                        <input type="hidden" class="form-check-input" name="source" id="source" value="my_assigned">
                    @else
                        <input type="hidden" class="form-check-input" name="source" id="source" value="my_tasks">
                    @endif
              {{--   <label>
                    <input type="checkbox" class="form-check-input" value="4" name="task_status[]" id="stoped_tasks">
                    <span>{{trans('tasks.status_suspended')}}</span>
                </label>
            </div>--}}
        </div>
    </form>
    <div class="clearfixed"></div>
    <hr class="hr-2">
</div>