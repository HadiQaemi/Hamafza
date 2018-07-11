<div class="col-xs-12">
    <form id="form_filter_priority">
        <div class="form-inline">
            <input type="text" class="form-control mx-sm-3" placeholder="{{trans('tasks.search_in_task_title_placeholder')}}" name="task_title" id="task_title">
            {{--<input type="number" placeholder="مهلت" class="form-control " style="width: 80px;" name="respite" id="respite">--}}
            <div class="checkbox">
                <label>
                    <input type="checkbox" class="form-check-input" name="official_type[]" value="0" id="official" checked>
                    <span>{{trans('tasks.official')}}</span>
                </label>
                <label>
                    <input type="checkbox" class="form-check-input" name="official_type[]" value="1" id="unofficial" checked>
                    <span>{{trans('tasks.unofficial')}}</span>
                </label>
            </div>
            <div class="checkbox" style="margin-right: 15px;">
            <label>
                {{--<input type="checkbox" class="form-check-input" value="0" name="task_important[]" id="not_started_tasks" checked>--}}
                <input type="checkbox" class="form-check-input" value="0" name="task_important[]" checked>
                <span>{{trans('tasks.important')}}</span>
            </label>
            <label>
                {{--<input type="checkbox" class="form-check-input" value="1" name="task_important[]" id="not_started_tasks" checked>--}}
                <input type="checkbox" class="form-check-input" value="1" name="task_important[]" checked>
                <span>{{trans('tasks.non-important')}}</span>
            </label>
            </div>
            <div class="checkbox" style="margin-right: 15px;">
            <label>
                {{--<input type="checkbox" class="form-check-input" value="0" name="task_immediate[]" id="not_started_tasks" checked>--}}
                <input type="checkbox" class="form-check-input" value="0" name="task_immediate[]" checked>
                <span>{{trans('tasks.immediate')}}</span>
            </label>
            <label>
                {{--<input type="checkbox" class="form-check-input" value="1" name="task_immediate[]" id="not_started_tasks" checked>--}}
                <input type="checkbox" class="form-check-input" value="1" name="task_immediate[]" checked>
                <span>{{trans('tasks.non-immediate')}}</span>
            </label>
            </div>
        </div>
    </form>
</div>



