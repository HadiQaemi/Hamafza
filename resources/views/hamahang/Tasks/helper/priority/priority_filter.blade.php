<div class="row form_filter_priority_div" style="margin-top: -10px;background: #eee">
    <form id="form_filter_priority">
        <div class="row padding-bottom-20 opacity-7">
            <i class="fa fa-calendar-minus-o int-icon3"></i>
            <div class="pull-right search-task-keywords margin-right-10 width-30-pre">
                <input type="text" value="{{(Session::get('AllTaskTitle')) ? Session::get('AllTaskTitle') : ''}}" class="form-control int-btm-brd" style="padding: 6px 20px;" id="title" name="title" placeholder="{{trans('tasks.search_title')}}" autocomplete="off">
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
                {{--<div class="checkbox pull-right margin-right-50">--}}
                    {{--<label>--}}
                        {{--<input type="checkbox" class="form-check-input" value="0" name="task_important[]" id="not_started_tasks" checked>--}}
                        {{--<input type="checkbox" class="form-check-input task_important" value="1" name="task_important[]" checked>--}}
                        {{--<span>{{trans('tasks.important')}}</span>--}}
                    {{--</label>--}}
                    {{--<label>--}}
                        {{--<input type="checkbox" class="form-check-input" value="1" name="task_important[]" id="not_started_tasks" checked>--}}
                        {{--<input type="checkbox" class="form-check-input task_important" value="0" name="task_important[]" checked>--}}
                        {{--<span>{{trans('tasks.non-important')}}</span>--}}
                    {{--</label>--}}
                {{--</div>--}}
                {{--<div class="checkbox pull-right margin-right-50">--}}
                    {{--<label>--}}
                        {{--<input type="checkbox" class="form-check-input" value="0" name="task_immediate[]" id="not_started_tasks" checked>--}}
                        {{--<input type="checkbox" class="form-check-input task_immediate" value="1" name="task_immediate[]" checked>--}}
                        {{--<span>{{trans('tasks.immediate')}}</span>--}}
                    {{--</label>--}}
                    {{--<label>--}}
                        {{--<input type="checkbox" class="form-check-input" value="1" name="task_immediate[]" id="not_started_tasks" checked>--}}
                        {{--<input type="checkbox" class="form-check-input task_immediate" value="0" name="task_immediate[]" checked>--}}
                        {{--<span>{{trans('tasks.non-immediate')}}</span>--}}
                    {{--</label>--}}
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
            </div>
        </div>
    </form>
</div>