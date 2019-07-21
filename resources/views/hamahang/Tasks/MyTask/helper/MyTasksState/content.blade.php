<div class="col-xs-12 col-md-3 col-sm-6 pdrl-2">
    <div class="text-center div_title_not_started"><h6>{{trans('tasks.status_not_started').' ('.(isset($myTasks['not_started']) ? count($myTasks['not_started']) : 0).')'}}</h6></div>
    <div class="div_groups_task state_container droppable" id="task_notstarted">
        <ul class="ul_dropp">
            @if(!empty($myTasks['not_started']))
                @foreach($myTasks['not_started'] as $task)
                    <li class="draggable {{$task->RespiteRemain['border_color_class']}}" data-task_id="{{$task->id}}" style="background-color: {{$task->PriorityColor()}} !important;">
                        <div class="header_div_list_task container-fluid prl-1">
                            <div class="div_img">
                                <span class="pull-right" data-toggle="tooltip"
                                      title="{{trans('tasks.reffered').': '.(isset($task->Assignment->Assigner->Name) ? $task->Assignment->Assigner->Name : '') }} {{isset($task->Assignment->Assigner->Family) ? $task->Assignment->Assigner->Family : ''}}">
                                    {!! isset($task->Assignment->Assigner->BetweenSmallandBig) ? $task->Assignment->Assigner->BetweenSmallandBig : '' !!}
                                    {{--{!!$user->SmallAvatar!!}--}}
                                </span>
                            </div>
                            <div class="span_title text_ellipsis" >
                                <span data-toggle="tooltip" title="{{$task->title."\n".$task->desc}}" class="">
                                    <a class='cursor-pointer jsPanels' href='/modals/ViewTaskForm?tid={{enCode($task->id)}}&aid={{isset($task->Assignment->id) ? $task->Assignment->id : ''}}'>
                                        {{$task->title}}
                                    </a>
                                </span>
                            </div>
                             <div style="" class="respite_number_task_state  {{$task->RespiteRemain['bg_color_class']}} {{$task->AllStatus->where('type', '>=', 1)->count()>0 ? 'task-redo' : ''}}">{{$task->RespiteRemain['days']}}</div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
<div class="col-xs-12 col-md-3 col-sm-6 pdrl-2">
    <div class="text-center"><h6>{{trans('tasks.status_started').' ('.(isset($myTasks['started']) ? count($myTasks['started']) : 0).')'}}</h6></div>
    <div class="div_groups_task state_container droppable" id="task_started">
        <ul class="ul_dropp">
            @if(!empty($myTasks['started']))
                @foreach($myTasks['started'] as $task)
                    <li class="draggable {{$task->RespiteRemain['border_color_class']}}" data-task_id="{{$task->id}}" style="background-color: {{$task->PriorityColor()}} !important;">
                        <div class="header_div_list_task container-fluid prl-1">
                            <div class="div_img">
                                <span class="pull-right" data-toggle="tooltip"
                                      title="{{trans('tasks.reffered').': '.(isset($task->Assignment->Assigner->Name) ? $task->Assignment->Assigner->Name : '') }} {{isset($task->Assignment->Assigner->Family) ? $task->Assignment->Assigner->Family : ''}}">
                                    {!! isset($task->Assignment->Assigner->BetweenSmallandBig) ? $task->Assignment->Assigner->BetweenSmallandBig : '' !!}
                                    {{--{!!$user->SmallAvatar!!}--}}
                                </span>
                            </div>
                            <div class="span_title text_ellipsis" >
                                <span data-toggle="tooltip" title="{{$task->title."\n".$task->desc}}" class="">
                                    <a class='cursor-pointer jsPanels' href='/modals/ViewTaskForm?tid={{enCode($task->id)}}&aid={{isset($task->Assignment->id) ? $task->Assignment->id : ''}}'>
                                        <span>{{$task->title}}</span>
                                    </a>
                                </span>
                            </div>
                            <div style="" class="respite_number_task_state {{$task->RespiteRemain['bg_color_class']}} {{$task->AllStatus->where('type', '>=', 2)->count()>0 ? 'task-redo' : ''}}">{{$task->RespiteRemain['days']}}</div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
<div class="col-xs-12 col-md-3 col-sm-6 pdrl-2">
    <div class="text-center"><h6>{{trans('tasks.status_done').' ('.(isset($myTasks['done']) ? count($myTasks['done']) : 0).')'}}</h6></div>
    <div class="div_groups_task state_container droppable" id="task_done">
        <ul class="ul_dropp">
            @if(!empty($myTasks['done']))
                @foreach($myTasks['done'] as $task)
                    <li class="draggable {{$task->RespiteRemain['border_color_class']}}" data-task_id="{{$task->id}}" style="background-color: {{$task->PriorityColor()}} !important;">
                        <div class="header_div_list_task container-fluid prl-1">
                            <div class="div_img">
                                <span class="pull-right" data-toggle="tooltip"
                                      title="{{trans('tasks.reffered').': '.(isset($task->Assignment->Assigner->Name) ? $task->Assignment->Assigner->Name : '') }} {{isset($task->Assignment->Assigner->Family) ? $task->Assignment->Assigner->Family : ''}}">
                                    {!! isset($task->Assignment->Assigner->BetweenSmallandBig) ? $task->Assignment->Assigner->BetweenSmallandBig : '' !!}
                                    {{--{!!$user->SmallAvatar!!}--}}
                                </span>
                            </div>
                            <div class="span_title text_ellipsis" >
                                <span data-toggle="tooltip" title="{{$task->title."\n".$task->desc}}" class="">
                                    <a class='cursor-pointer jsPanels' href='/modals/ViewTaskForm?tid={{enCode($task->id)}}&aid={{isset($task->Assignment->id) ? $task->Assignment->id : ''}}'>
                                        {{$task->title}}
                                    </a>
                                </span>
                            </div>
                            <div style="" class="respite_number_task_state  {{$task->RespiteRemain['bg_color_class']}} {{$task->AllStatus->where('type', '>=', 3)->count()>0 ? 'task-redo' : ''}}">{{$task->RespiteRemain['days']}}</div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
<div class="col-xs-12 col-md-3 col-sm-6 pdrl-2">
    <div class="text-center"><h6>{{trans('tasks.status_finished').' ('.(isset($myTasks['ended']) ? count($myTasks['ended']) : 0).')'}}</h6></div>
    <div class="div_groups_task state_container droppable" id="task_ended">
        <ul class="ul_dropp">
            @if(!empty($myTasks['ended']))
                @foreach($myTasks['ended'] as $task)
                    <li class="draggable {{$task->RespiteRemain['border_color_class']}}" data-task_id="{{$task->id}}" style="background-color: {{$task->PriorityColor()}} !important;">
                        <div class="header_div_list_task container-fluid prl-1">
                            <div class="div_img">
                                <span class="pull-right" data-toggle="tooltip"
                                      title="{{trans('tasks.reffered').': '.(isset($task->Assignment->Assigner->Name) ? $task->Assignment->Assigner->Name : '') }} {{isset($task->Assignment->Assigner->Family) ? $task->Assignment->Assigner->Family : ''}}">
                                    {!! isset($task->Assignment->Assigner->BetweenSmallandBig) ? $task->Assignment->Assigner->BetweenSmallandBig : '' !!}
                                    {{--{!!$user->SmallAvatar!!}--}}
                                </span>
                            </div>
                            <div class="span_title text_ellipsis" >
                                <span data-toggle="tooltip" title="{{$task->title."\n".$task->desc}}" class="">
                                    <a class='cursor-pointer jsPanels' href='/modals/ViewTaskForm?tid={{enCode($task->id)}}&aid={{isset($task->Assignment->id) ? $task->Assignment->id : ''}}'>
                                        {{$task->title}}
                                    </a>
                                </span>
                            </div>
                            <div style="" class="respite_number_task_state  {{$task->RespiteRemain['bg_color_class']}} {{$task->AllStatus->where('type', '>=', 4)->count()>0 ? 'task-redo' : ''}}">{{$task->RespiteRemain['days']}}</div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
{{--{{dd($myTasks)}}--}}