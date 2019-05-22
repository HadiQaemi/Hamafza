<div id="priority_content_area">
    @if(isset($tasks_immediate_importance))
        @php $do = ''; @endphp
            <div class="row" style="display: flex">
                <div class="col-xs-6 priority_state_list">
                    <h5 class="state_title">
                        مهم و فوری
                        ({{isset($tasks_immediate_importance) ? count($tasks_immediate_importance) : 0}})
                    </h5>
                    <ul class="task_items droppable" id="important_and_immediate">
                        <div style="direction: rtl;">
                            @if(isset($tasks_immediate_importance))
                                @foreach($tasks_immediate_importance as $task)
                                    <li class="draggable {{$task->RespiteRemain['border_color_class']}}" data-action="task" data-task_id="{{$task->id}}">
                                        @if(strstr(\Route::currentRouteName(),'desktop.hamahang.tasks.my_assigned_tasks.priority'))
                                            @php
                                                $do = 'ViewTaskForm?';
                                            @endphp
                                            @if(isset($task->Assignments))
                                                @foreach($task->Assignments as $employee)
                                                    <div class="referrer" style="top: 1px;" data-toggle="tooltip" title="{{trans('tasks.reject_to').': '. (isset($employee->Employee->Name) ? $employee->Employee->Name : '') . ' ' . (isset($employee->Employee->Family) ? $employee->Employee->Family : '')}}">
                                                        <a href="{{url((isset($employee->Employee->Uname) ? $employee->Employee->Uname : ''))}}" title="{{(isset($employee->Employee->Name) ? $employee->Employee->Name : '') . ' ' . (isset($employee->Employee->Family) ? $employee->Employee->Family : '')}}">
                                                            <i >{!! isset($employee->Employee->BetweenSmallandBig) ? $employee->Employee->BetweenSmallandBig : '' !!}</i>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @else
                                                @php
                                                        $do = 'ViewTaskForm?act=do&';
                                                @endphp
                                                <div class="referrer" style="top: 1px;" data-toggle="tooltip" title="{{trans('tasks.reffered').': '.$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                                    <a href="{{url($task->Assignment->Assigner->Uname)}}" title="{{$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                                        <i >{!! $task->Assignment->Assigner->BetweenSmallandBig !!}</i>
                                                    </a>
                                                </div>
                                        @endif
                                        <div class="task_title">
                                            <h5 class="text_ellipsis">
                                                <a class='cursor-pointer jsPanels' data-toggle="tooltip" title="{{$task->title."\n".$task->desc}}" href='/modals/{{$do}}tid={{enCode($task->id)}}&aid={{enCode($task->Assignment->id)}}'>
                                                    {{$task->title}}
                                                </a>
                                            </h5>
                                        </div>
                                        <div class="respite_number {{$task->RespiteRemain['bg_color_class']}}">{{$task->RespiteRemain['days']}}</div>
                                    </li>
                                @endforeach
                            @endif
                        </div>
                    </ul>
                </div>
                <div class="col-xs-6 priority_state_list">
                    <h5 class="state_title">
                        غیر مهم و فوری
                        ({{isset($tasks_immediate_not_importance) ? count($tasks_immediate_not_importance) : 0}})
                    </h5>
                    <ul class="task_items droppable" id="not_important_and_immediate">
                        <div style="direction: rtl;">
                            @if(isset($tasks_immediate_not_importance))
                                @foreach($tasks_immediate_not_importance as $task)
                                    <li class="draggable {{$task->RespiteRemain['border_color_class']}}" data-action="task" data-task_id="{{$task->id}}">
                                        @if(strstr(\Route::currentRouteName(),'desktop.hamahang.tasks.my_assigned_tasks.priority'))
                                            @php
                                                $do = 'ViewTaskForm?';
                                            @endphp
                                            @if(isset($task->Assignments))
                                                @foreach($task->Assignments as $employee)
                                                    <div class="referrer" style="top: 1px;" data-toggle="tooltip" title="{{trans('tasks.reject_to').': '. (isset($employee->Employee->Name) ? $employee->Employee->Name : '') . ' ' . (isset($employee->Employee->Family) ? $employee->Employee->Family : '')}}">
                                                        <a href="{{url((isset($employee->Employee->Uname) ? $employee->Employee->Uname : ''))}}" title="{{(isset($employee->Employee->Name) ? $employee->Employee->Name : '') . ' ' . (isset($employee->Employee->Family) ? $employee->Employee->Family : '')}}">
                                                            <i >{!! isset($employee->Employee->BetweenSmallandBig) ? $employee->Employee->BetweenSmallandBig : '' !!}</i>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @else
                                            @php
                                                $do = 'ViewTaskForm?act=do&';
                                            @endphp
                                            <div class="referrer" style="top: 1px;" data-toggle="tooltip" title="{{trans('tasks.reffered').': '.$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                                <a href="{{url($task->Assignment->Assigner->Uname)}}" title="{{$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                                    <i >{!! $task->Assignment->Assigner->BetweenSmallandBig !!}</i>
                                                </a>
                                            </div>
                                        @endif
                                        <div class="task_title">
                                            <h5 class="text_ellipsis">
                                                <a class='cursor-pointer jsPanels' data-toggle="tooltip" title="{{$task->title."\n".$task->desc}}" href='/modals/{{$do}}tid={{enCode($task->id)}}&aid={{enCode($task->Assignment->id)}}'>
                                                    {{$task->title}}
                                                </a>
                                            </h5>
                                        </div>
                                        <div class="respite_number {{$task->RespiteRemain['bg_color_class']}}">{{$task->RespiteRemain['days']}}</div>
                                    </li>
                                @endforeach
                            @endif
                        </div>
                    </ul>
                </div>
            </div>
            <div class="row" style="display: flex">
                <div class="col-xs-6 priority_state_list">
                        <h5 class="state_title">
                            مهم و غیر فوری
                            ({{isset($tasks_not_immediate_importance) ? count($tasks_not_immediate_importance) : 0}})
                        </h5>
                        <ul class="task_items droppable" id="important_and_not_immediate">
                        <div style="direction: rtl;">
                            @if(isset($tasks_not_immediate_importance))
                                @foreach($tasks_not_immediate_importance as $task)
                                    <li class="draggable {{$task->RespiteRemain['border_color_class']}}" data-action="task" data-task_id="{{$task->id}}">
                                        @if(strstr(\Route::currentRouteName(),'desktop.hamahang.tasks.my_assigned_tasks.priority'))
                                            @php
                                                $do = 'ViewTaskForm?';
                                            @endphp
                                            @if(isset($task->Assignments))
                                                @foreach($task->Assignments as $employee)
                                                    <div class="referrer" style="top: 1px;" data-toggle="tooltip" title="{{trans('tasks.reject_to').': '. (isset($employee->Employee->Name) ? $employee->Employee->Name : '') . ' ' . (isset($employee->Employee->Family) ? $employee->Employee->Family : '')}}">
                                                        <a href="{{url((isset($employee->Employee->Uname) ? $employee->Employee->Uname : ''))}}" title="{{(isset($employee->Employee->Name) ? $employee->Employee->Name : '') . ' ' . (isset($employee->Employee->Family) ? $employee->Employee->Family : '')}}">
                                                            <i >{!! isset($employee->Employee->BetweenSmallandBig) ? $employee->Employee->BetweenSmallandBig : '' !!}</i>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @else
                                            @php
                                                $do = 'ViewTaskForm?act=do&';
                                            @endphp
                                            <div class="referrer" style="top: 1px;" data-toggle="tooltip" title="{{trans('tasks.reffered').': '.$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                                <a href="{{url($task->Assignment->Assigner->Uname)}}" title="{{$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                                    <i >{!! $task->Assignment->Assigner->BetweenSmallandBig !!}</i>
                                                </a>
                                            </div>
                                        @endif
                                        <div class="task_title">
                                            <h5 class="text_ellipsis">
                                                <a class='cursor-pointer jsPanels' data-toggle="tooltip" title="{{$task->title."\n".$task->desc}}" href='/modals/{{$do}}tid={{enCode($task->id)}}&aid={{enCode($task->Assignment->id)}}'>
                                                    {{$task->title}}
                                                </a>
                                            </h5>
                                        </div>
                                        <div class="respite_number {{$task->RespiteRemain['bg_color_class']}}">{{$task->RespiteRemain['days']}}</div>
                                    </li>
                                @endforeach
                            @endif
                        </div>
                    </ul>
                </div>
                <div class="col-xs-6 priority_state_list">
                    <h5 class="state_title">
                        غیر مهم و غیر فوری
                        ({{isset($tasks_not_immediate_not_importance) ? count($tasks_not_immediate_not_importance) : 0}})
                    </h5>
                    <ul class="task_items droppable" id="not_important_and_not_immediate">
                    <div style="direction: rtl;">
                        @if(isset($tasks_not_immediate_not_importance))
                            @foreach($tasks_not_immediate_not_importance as $task)
                                <li class="draggable {{$task->RespiteRemain['border_color_class']}}" data-action="task" data-task_id="{{$task->id}}">
                                    @if(strstr(\Route::currentRouteName(),'desktop.hamahang.tasks.my_assigned_tasks.priority'))
                                        @php
                                            $do = 'ViewTaskForm?';
                                        @endphp
                                        @if(isset($task->Assignments))
                                            @foreach($task->Assignments as $employee)
                                                <div class="referrer" style="top: 1px;" data-toggle="tooltip" title="{{trans('tasks.reject_to').': '. (isset($employee->Employee->Name) ? $employee->Employee->Name : '') . ' ' . (isset($employee->Employee->Family) ? $employee->Employee->Family : '')}}">
                                                    <a href="{{url((isset($employee->Employee->Uname) ? $employee->Employee->Uname : ''))}}" title="{{(isset($employee->Employee->Name) ? $employee->Employee->Name : '') . ' ' . (isset($employee->Employee->Family) ? $employee->Employee->Family : '')}}">
                                                        <i >{!! isset($employee->Employee->BetweenSmallandBig) ? $employee->Employee->BetweenSmallandBig : '' !!}</i>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif
                                    @else
                                        @php
                                            $do = 'ViewTaskForm?act=do&';
                                        @endphp
                                        <div class="referrer" style="top: 1px;" data-toggle="tooltip" title="{{trans('tasks.reffered').': '.$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                            <a href="{{url($task->Assignment->Assigner->Uname)}}" title="{{$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                                <i >{!! $task->Assignment->Assigner->BetweenSmallandBig !!}</i>
                                            </a>
                                        </div>
                                    @endif
                                    <div class="task_title">
                                        <h5 class="text_ellipsis">
                                            <a class='cursor-pointer jsPanels' data-toggle="tooltip" title="{{$task->title."\n".$task->desc}}" href='/modals/{{$do}}tid={{enCode($task->id)}}&aid={{enCode($task->Assignment->id)}}'>
                                                {{$task->title}}
                                            </a>
                                        </h5>
                                    </div>
                                    <div class="respite_number {{$task->RespiteRemain['bg_color_class']}}">{{$task->RespiteRemain['days']}}</div>
                                </li>
                            @endforeach
                        @endif
                    </div>
                </ul>
                </div>
            </div>
        @else
            <div class="row" style="display: flex">
                <div class="col-xs-12 priority_state_list">
                    <ul class="task_items droppable" id="important_and_immediate">
                        <div style="direction: rtl;">
                            @foreach($MyTasksPriorityTime as $task)
                                <li class="draggable task_item_{{$task->id}}" data-action="task_timing" data-title="{{$task->title}}" data-task_id="{{$task->id}}">
                                    <div class="task_title">
                                        <h5 class="text_ellipsis">
                                            <a class='cursor-pointer jsPanels' href='/modals/ViewTaskForm?tid={{enCode($task->id)}}&aid={{$task->Assignment->id}}'>
                                                @php
                                                    $title = $task->title;
                                                    $words = str_word_count($task->title, 2);
                                                    $pos = array_keys($words);
                                                    $min = min(count($words),3);
                                                    if(isset($pos[1]))
                                                        $title = substr($words, 1, $pos[1]) . '...';
                                                @endphp
                                                {{$title}}
                                            </a>
                                        </h5>
                                    </div>
                                </li>
                            @endforeach
                        </div>
                    </ul>
                </div>
            </div>
        @endif
</div>