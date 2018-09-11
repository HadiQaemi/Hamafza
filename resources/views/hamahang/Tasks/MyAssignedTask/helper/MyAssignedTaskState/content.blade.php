<script>
    $('.first-fix-box').removeClass('height-100');
</script>
<div class="col-xs-12 col-md-3 col-sm-6 pdrl-2">
   <div class="text-center div_title_not_started"><h6>{{trans('tasks.status_not_started')}}</h6></div>
    <div class="div_groups_task state_container droppable" id="task_notstarted" >
        <ul class="ul_dropp">
            @if(!empty($myTasks['not_started']))
                @foreach($myTasks['not_started'] as $task)
                    <li class="draggable {{$task->RespiteRemain['border_color_class']}}" data-task_id="{{$task->id}}">
                        <div class="header_div_list_task container-fluid prl-1">
                            <div class="div_img">
                                <span class="pull-right" data-toggle="tooltip"
                                      title="{{$task->Assignment->Assigner->Name }} {{$task->Assignment->Assigner->Family}}">
                                    {!! $task->Assignment->Assigner->BetweenSmallandBig !!}{{-- {!!$user->SmallAvatar!!}--}}
                                </span>
                            </div>
                            <div class="span_title" >
                                <span data-toggle="tooltip" title="{{$task->title}}">
                                    <a class='cursor-pointer jsPanels' href='/modals/ShowAssignTaskForm?tid={{enCode($task->id)}}&aid={{$task->Assignment->id}}'>
                                        @php
                                            $msgTrimmed = mb_substr($task->title,0,30);
                                            $lastSpace = strrpos($msgTrimmed, ' ', 0);
                                            $title = mb_substr($msgTrimmed,0,$lastSpace);
                                        @endphp
                                        {{$title.(mb_strlen($title)<mb_strlen($task->title) ? '...' : '')}}
                                    </a>
                                </span>
                            </div>
                            <div style="" class="respite_number_task_state  {{$task->RespiteRemain['bg_color_class']}}">{{$task->RespiteRemain['days']}}</div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
<div class="col-xs-12 col-md-3 col-sm-6 pdrl-2">
    <div class="text-center"><h6>{{trans('tasks.status_started')}}</h6></div>
    <div class="div_groups_task state_container droppable" id="task_started" >
        <ul class="ul_dropp">
            @if(!empty($myTasks['started']))
                @foreach($myTasks['started'] as $task)
                    <li class="draggable {{$task->RespiteRemain['border_color_class']}}" data-task_id="{{$task->id}}">
                        <div class="header_div_list_task container-fluid prl-1">
                            <div class="div_img">
                                <span class="pull-right" data-toggle="tooltip"
                                      title="{{$task->Assignment->Assigner->Name }} {{$task->Assignment->Assigner->Family}}">{!! $task->Assignment->Assigner->BetweenSmallandBig !!}{{-- {!!$user->SmallAvatar!!}--}}</span>
                            </div>
                            <div class="span_title" >
                                <span data-toggle="tooltip" title="{{$task->title}}">
                                    <a class='cursor-pointer jsPanels' href='/modals/ShowAssignTaskForm?tid={{enCode($task->id)}}&aid={{$task->Assignment->id}}'>
                                        @php
                                            $msgTrimmed = mb_substr($task->title,0,30);
                                            $lastSpace = strrpos($msgTrimmed, ' ', 0);
                                            $title = mb_substr($msgTrimmed,0,$lastSpace);
                                        @endphp
                                        {{$title.(mb_strlen($title)<mb_strlen($task->title) ? '...' : '')}}
                                    </a>
                                </span>
                            </div>
                            <div style="" class="respite_number_task_state  {{$task->RespiteRemain['bg_color_class']}}">{{$task->RespiteRemain['days']}}</div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
<div class="col-xs-12 col-md-3 col-sm-6 pdrl-2">
    <div class="text-center"><h6>{{trans('tasks.status_done')}}</h6></div>
    <div class="div_groups_task state_container droppable" id="task_done">
        <ul class="ul_dropp">
            @if(!empty($myTasks['done']))
                @foreach($myTasks['done'] as $task)
                    <li class="draggable {{$task->RespiteRemain['border_color_class']}}" data-task_id="{{$task->id}}">
                        <div class="header_div_list_task container-fluid prl-1">
                            <div class="div_img">
                            <span class="pull-right" data-toggle="tooltip"
                                  title="{{$task->Assignment->Assigner->Name }} {{$task->Assignment->Assigner->Family}}">{!! $task->Assignment->Assigner->BetweenSmallandBig !!}{{-- {!!$user->SmallAvatar!!}--}}</span>
                            </div>
                            <div class="span_title" >
                                <span data-toggle="tooltip" title="{{$task->title}}">
                                    <a class='cursor-pointer jsPanels' href='/modals/ShowAssignTaskForm?tid={{enCode($task->id)}}&aid={{$task->Assignment->id}}'>
                                        @php
                                            $msgTrimmed = mb_substr($task->title,0,30);
                                            $lastSpace = strrpos($msgTrimmed, ' ', 0);
                                            $title = mb_substr($msgTrimmed,0,$lastSpace);
                                        @endphp
                                        {{$title.(mb_strlen($title)<mb_strlen($task->title) ? '...' : '')}}
                                    </a>
                                </span>
                            </div>
                            <div style="" class="respite_number_task_state  {{$task->RespiteRemain['bg_color_class']}}">{{$task->RespiteRemain['days']}}</div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
<div class="col-xs-12 col-md-3 col-sm-6 pdrl-2">
    <div class="text-center"><h6>{{trans('tasks.status_finished')}}</h6></div>
    <div class="div_groups_task state_container droppable" id="task_ended">
        <ul class="ul_dropp">
            @if(!empty($myTasks['ended']))
                @foreach($myTasks['ended'] as $task)
                    <li class="draggable {{$task->RespiteRemain['border_color_class']}}" data-task_id="{{$task->id}}">
                        <div class="header_div_list_task container-fluid prl-1">
                            <div class="div_img">
                                <span class="pull-right" data-toggle="tooltip"
                                      title="{{$task->Assignment->Assigner->Name }} {{$task->Assignment->Assigner->Family}}">{!! $task->Assignment->Assigner->BetweenSmallandBig !!}{{-- {!!$user->SmallAvatar!!}--}}</span>
                            </div>
                            <div class="span_title" >
                                <span data-toggle="tooltip" title="{{$task->title}}">
                                    <a class='cursor-pointer jsPanels' href='/modals/ShowAssignTaskForm?tid={{enCode($task->id)}}&aid={{$task->Assignment->id}}'>
                                        @php
                                            $msgTrimmed = mb_substr($task->title,0,30);
                                            $lastSpace = strrpos($msgTrimmed, ' ', 0);
                                            $title = mb_substr($msgTrimmed,0,$lastSpace);
                                        @endphp
                                        {{$title.(mb_strlen($title)<mb_strlen($task->title) ? '...' : '')}}
                                    </a>
                                </span>
                            </div>
                            <div style="" class="respite_number_task_state  {{$task->RespiteRemain['bg_color_class']}}">{{$task->RespiteRemain['days']}}</div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>