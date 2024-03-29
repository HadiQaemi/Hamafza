<div class="row opacity-7" style="margin-top: -10px;background: #eee">
    <form id="form_filter_priority">
        <div class="row padding-bottom-20">
            <i class="fa fa-calendar-minus-o int-icon3"></i>
            <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                <input type="text" class="form-control int-btm-brd" style="padding: 6px 20px;" id="title" name="title" placeholder="{{trans('tasks.search_title')}}" autocomplete="off">
            </div>
            <i class="fa fa-tags int-icon2"></i>
            <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                <select id="new_task_keywords" class="select2_auto_complete_keywords" name="keywords[]"
                        data-placeholder="{{trans('tasks.search_keyword_task')}}"
                        multiple="multiple"></select>
            </div>
            <i class="fa fa-users int-icon1"></i>
            <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                <select id="new_task_users_all_tasks" name="users[]" class="select2_auto_complete_user col-xs-12"
                        data-placeholder="{{trans('tasks.search_some_persons')}}" multiple>
                    <option value=""></option>
                </select>
            </div>
        </div>
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
        {{--<div class="pull-right" style="margin-top: 10px;">--}}
            {{--<label class="container-checkmark">--}}
                {{--<input type="checkbox" checked="checked" class="form-check-input" name="task_final[]" value="1" checked>--}}
                {{--<span class="checkmark"></span>--}}
            {{--</label>--}}
        {{--</div>--}}
        {{--<div class="pull-right" style="margin-top: 10px;">--}}
            {{--<span>{{trans('tasks.final')}}</span>--}}
        {{--</div>--}}
        {{--<div class="pull-right" style="margin-top: 10px;">--}}
            {{--<label class="container-checkmark">--}}
                {{--<input type="checkbox" checked="checked" class="form-check-input" name="task_final[]" value="0" checked>--}}
                {{--<span class="checkmark"></span>--}}
            {{--</label>--}}
        {{--</div>--}}
        <div class="pull-right" style="margin-top: 10px;">
            {{--<span>{{trans('tasks.draft')}}</span>--}}
        </div>
        @if(isset($filter_subject_id))
            <input type="hidden" value="{{$filter_subject_id}}" name="filter_subject_id" id="filter_subject_id"/>
        @endif
        {{--<div class="checkbox pull-right margin-right-20" style="margin-top: 0px;">--}}
            {{--<div class="pull-right">--}}
                {{--<span style="margin-top: 10px;display: block;">{{trans('tasks.stage')}}</span>--}}
            {{--</div>--}}
            {{--<div class="checkboxVertical pull-right margin-right-10">--}}
                {{--<input type="checkbox" class="form-check-input" value="0" name="task_status[]" id="not_started_tasks" data-toggle="tooltip" title="{{trans('tasks.status_not_started')}}" checked/>--}}
                {{--<label for="not_started_tasks" data-toggle="tooltip" title="{{trans('tasks.status_not_started')}}"></label>--}}
            {{--</div>--}}
            {{--<div class="checkboxVertical pull-right margin-right-10">--}}
                {{--<input type="checkbox" class="form-check-input" value="1" name="task_status[]" id="started_tasks" data-toggle="tooltip" title="{{trans('tasks.status_started')}}" checked/>--}}
                {{--<label for="started_tasks" data-toggle="tooltip" title="{{trans('tasks.status_started')}}"></label>--}}
            {{--</div>--}}
            {{--<div class="checkboxVertical pull-right margin-right-10">--}}
                {{--<input type="checkbox" class="form-check-input" value="2" name="task_status[]" data-toggle="tooltip" title="{{trans('tasks.status_done')}}" id="done_tasks"/>--}}
                {{--<label for="done_tasks" data-toggle="tooltip" title="{{trans('tasks.status_done')}}"></label>--}}
            {{--</div>--}}
            {{--<div class="checkboxVertical pull-right margin-right-10">--}}
                {{--<input type="checkbox" class="form-check-input" value="2" name="task_status[]" data-toggle="tooltip" title="{{trans('tasks.status_finished')}}" id="completed_tasks"/>--}}
                {{--<label for="completed_tasks" data-toggle="tooltip" title="{{trans('tasks.status_finished')}}"></label>--}}
            {{--</div>--}}
            {{--<div class="checkboxVertical pull-right margin-right-10">--}}
                {{--<input type="checkbox" class="form-check-input" value="2" name="task_status[]" data-toggle="tooltip" title="{{trans('tasks.status_suspended')}}" id="stoped_tasks"/>--}}
                {{--<label for="stoped_tasks" data-toggle="tooltip" title="{{trans('tasks.status_suspended')}}"></label>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="checkbox pull-right margin-right-20">
            <div class="pull-right">
                <span style="margin-top: 10px;display: block;">{{trans('tasks.stage')}}</span>
            </div>
            <div class="checkboxVertical draft pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.draft')}}">
                <input type="checkbox" class="form-check-input draft_tasks" value="10" name="draft_tasks" id="draft_tasks" />
                <label for="draft_tasks" class="draft"></label>
            </div>
            <div class="checkboxVertical not_started pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_not_started')}}">
                <input type="checkbox" class="form-check-input" value="0" name="task_status[]" id="not_started_tasks" checked/>
                <label for="not_started_tasks" class="not_started"></label>
            </div>
            <div class="checkboxVertical started pull-right margin-right-10" data-toggle="tooltip" title="{{trans('tasks.status_started')}}">
                <input type="checkbox" class="form-check-input" value="1" name="task_status[]" id="started_tasks" checked/>
                <label for="started_tasks" class="started"></label>
            </div>
            <div class="checkboxVertical done pull-right margin-right-10 background-gray" data-toggle="tooltip" title="{{trans('tasks.status_done')}}">
                <input type="checkbox" class="form-check-input" value="2" name="task_status[]" id="done_tasks"/>
                <label for="done_tasks" class="done background-gray"></label>
            </div>
            <div class="checkboxVertical completed pull-right margin-right-10 background-gray" data-toggle="tooltip" title="{{trans('tasks.status_finished')}}">
                <input type="checkbox" class="form-check-input" value="3" name="task_status[]" id="completed_tasks"/>
                <label for="completed_tasks" class="completed background-gray"></label>
            </div>
            <div class="checkboxVertical pull-right margin-right-10 background-gray" data-toggle="tooltip" title="{{trans('tasks.status_suspended')}}">
                <input type="checkbox" class="form-check-input" value="4" name="task_status[]" id="stoped_tasks"/>
                <label for="stoped_tasks" class="background-gray"></label>
            </div>
        </div>
        <script>

            $('.form-check-input').click(function () {
                // $(document).on('click','')
                if($('label[for="'+$(this).attr('id')+'"]').hasClass('background-gray')){
                    $('label[for="'+$(this).attr('id')+'"]').removeClass('background-gray');
                    $(this).parent().removeClass('background-gray');
                }
                else{
                    $(this).parent().addClass('background-gray');
                    $('label[for="'+$(this).attr('id')+'"]').addClass('background-gray');
                }
                // $(document).on('click', 'input[name="task_status[]"]', function () {
                //     if($(this).checked)
                //     {
                //         alert('hi hadi');
                //     }
                // });
            });
        </script>
        {{--</div>--}}
    </form>
</div>
