<script>
    $('.first-fix-box').removeClass('height-100');
</script>
<style>
    .content_task {
        top: 71px;
    }
</style>
<div class="col-xs-12 col-md-3 col-sm-6 pdrl-2">
   <div class="text-center div_title_not_started"><h6>{{trans('tasks.status_not_started')}}</h6></div>
    <div class="div_groups_task state_container droppable" id="task_notstarted" >
        <ul class="ul_dropp">
            @if(!empty($myTasks['not_started']))
                @foreach($myTasks['not_started'] as $task)
                    <li class="draggable {{$task->RespiteRemain['border_color_class']}}" data-task_id="{{$task->id}}">
                        <div class="header_div_list_task container-fluid prl-1">
                            <span class="div_img">
                                @if(strstr(\Route::currentRouteName(),'hamahang.tasks.my_assigned_tasks.state'))
                                    @php
                                        $do = 'ViewTaskForm';
                                        $employee = $task->Assignments[0];
                                    @endphp
{{--                                    @foreach($task->Assignments as $employee)--}}
                                        <span class="referrer" style="top: 1px;" data-toggle="tooltip" title="{{trans('tasks.reject_to').': '.$employee->Employee->Name . ' ' . $employee->Employee->Family}}">
                                            <a href="{{url($employee->Employee->Uname)}}" title="{{$employee->Employee->Name . ' ' . $employee->Employee->Family}}">
                                                <i >{!! $employee->Employee->BetweenSmallandBig !!}</i>
                                            </a>
                                        </span>
                                    {{--@endforeach--}}
                                @else
                                    @php
                                        $do = 'ViewTaskForm';
                                    @endphp
                                    <span class="referrer" style="top: 1px;" data-toggle="tooltip" title="{{trans('tasks.reffered').': '.$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                        <a href="{{url($task->Assignment->Assigner->Uname)}}" title="{{$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                            <i >{!! $task->Assignment->Assigner->BetweenSmallandBig !!}</i>
                                        </a>
                                    </span>
                                @endif
                            </span>
                            <span >
                                <span data-toggle="tooltip" title="{{$task->title}}">
                                    <a class='cursor-pointer jsPanels' href='/modals/{{$do}}?tid={{enCode($task->id)}}&aid={{$task->Assignment->id}}'>
                                        @php
                                            $msgTrimmed = preg_split('/ /',$task->title);
                                            $cnt = 0;
                                            $sub_title = '';
                                            foreach($msgTrimmed as $word){
                                                if($cnt++ <=5){
                                                    $sub_title .= " $word";
                                                }else{
                                                    $sub_title .= '...';
                                                    break;
                                                }
                                            }
                                        @endphp
                                        {{$sub_title}}
                                    </a>
                                </span>
                            </span>
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
                            <span class="div_img">
                                @if(strstr(\Route::currentRouteName(),'hamahang.tasks.my_assigned_tasks.state'))
                                    @php
                                        $do = 'ViewTaskForm';
                                        $employee = $task->Assignments[0];
                                    @endphp
                                    {{--@foreach($task->Assignments as $employee)--}}
                                        <span class="referrer" style="top: 1px;" data-toggle="tooltip" title="{{trans('tasks.reject_to').': '.$employee->Employee->Name . ' ' . $employee->Employee->Family}}">
                                            <a href="{{url($employee->Employee->Uname)}}" title="{{$employee->Employee->Name . ' ' . $employee->Employee->Family}}">
                                                <i >{!! $employee->Employee->BetweenSmallandBig !!}</i>
                                            </a>
                                        </span>
                                    {{--@endforeach--}}
                                @else
                                    @php
                                        $do = 'ViewTaskForm';
                                    @endphp
                                    <span class="referrer" style="top: 1px;" data-toggle="tooltip" title="{{trans('tasks.reffered').': '.$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                        <a href="{{url($task->Assignment->Assigner->Uname)}}" title="{{$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                            <i >{!! $task->Assignment->Assigner->BetweenSmallandBig !!}</i>
                                        </a>
                                    </span>
                                @endif
                            </span>
                            <span >
                                <span data-toggle="tooltip" title="{{$task->title}}">
                                    <a class='cursor-pointer jsPanels' href='/modals/{{$do}}?tid={{enCode($task->id)}}&aid={{$task->Assignment->id}}'>
                                        @php
                                            $msgTrimmed = preg_split('/ /',$task->title);
                                            $cnt = 0;
                                            $sub_title = '';
                                            foreach($msgTrimmed as $word){
                                                if($cnt++ <=5){
                                                    $sub_title .= " $word";
                                                }else{
                                                    $sub_title .= '...';
                                                    break;
                                                }
                                            }
                                        @endphp
                                        {{$sub_title}}
                                    </a>
                                </span>
                            </span>
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
                            <span class="div_img">
                                @if(strstr(\Route::currentRouteName(),'hamahang.tasks.my_assigned_tasks.state'))
                                    @php
                                        $do = 'ViewTaskForm';
                                        $employee = $task->Assignments[0];
                                    @endphp
                                    {{--@foreach($task->Assignments as $employee)--}}
                                        <span class="referrer" style="top: 1px;" data-toggle="tooltip" title="{{trans('tasks.reject_to').': '.$employee->Employee->Name . ' ' . $employee->Employee->Family}}">
                                            <a href="{{url($employee->Employee->Uname)}}" title="{{$employee->Employee->Name . ' ' . $employee->Employee->Family}}">
                                                <i >{!! $employee->Employee->BetweenSmallandBig !!}</i>
                                            </a>
                                        </span>
                                    {{--@endforeach--}}
                                @else
                                    @php
                                        $do = 'ViewTaskForm';
                                    @endphp
                                    <span class="referrer" style="top: 1px;" data-toggle="tooltip" title="{{trans('tasks.reffered').': '.$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                        <a href="{{url($task->Assignment->Assigner->Uname)}}" title="{{$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                            <i >{!! $task->Assignment->Assigner->BetweenSmallandBig !!}</i>
                                        </a>
                                    </span>
                                @endif
                            </span>
                            <span >
                                <span data-toggle="tooltip" title="{{$task->title}}">
                                    <a class='cursor-pointer jsPanels' href='/modals/{{$do}}?tid={{enCode($task->id)}}&aid={{$task->Assignment->id}}'>
                                        @php
                                            $msgTrimmed = preg_split('/ /',$task->title);
                                            $cnt = 0;
                                            $sub_title = '';
                                            foreach($msgTrimmed as $word){
                                                if($cnt++ <=5){
                                                    $sub_title .= " $word";
                                                }else{
                                                    $sub_title .= '...';
                                                    break;
                                                }
                                            }
                                        @endphp
                                        {{$sub_title}}
                                    </a>
                                </span>
                            </span>
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
                            <span class="div_img">
                                @if(strstr(\Route::currentRouteName(),'hamahang.tasks.my_assigned_tasks.state'))
                                    @php
                                        $do = 'ViewTaskForm';
                                        $employee = $task->Assignments[0];
                                    @endphp
                                    {{--@foreach($task->Assignments as $employee)--}}
                                        <span class="referrer" style="top: 1px;" data-toggle="tooltip" title="{{trans('tasks.reject_to').': '.$employee->Employee->Name . ' ' . $employee->Employee->Family}}">
                                            <a href="{{url($employee->Employee->Uname)}}" title="{{$employee->Employee->Name . ' ' . $employee->Employee->Family}}">
                                                <i >{!! $employee->Employee->BetweenSmallandBig !!}</i>
                                            </a>
                                        </span>
                                    {{--@endforeach--}}
                                @else
                                    @php
                                        $do = 'ViewTaskForm';
                                    @endphp
                                    <span class="referrer" style="top: 1px;" data-toggle="tooltip" title="{{trans('tasks.reffered').': '.$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                        <a href="{{url($task->Assignment->Assigner->Uname)}}" title="{{$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                            <i >{!! $task->Assignment->Assigner->BetweenSmallandBig !!}</i>
                                        </a>
                                    </span>
                                @endif
                            </span>
                            <span >
                                <span data-toggle="tooltip" title="{{$task->title}}">
                                    <a class='cursor-pointer jsPanels' href='/modals/{{$do}}?tid={{enCode($task->id)}}&aid={{$task->Assignment->id}}'>
                                        @php
                                            $msgTrimmed = preg_split('/ /',$task->title);
                                            $cnt = 0;
                                            $sub_title = '';
                                            foreach($msgTrimmed as $word){
                                                if($cnt++ <=5){
                                                    $sub_title .= " $word";
                                                }else{
                                                    $sub_title .= '...';
                                                    break;
                                                }
                                            }
                                        @endphp
                                        {{$sub_title}}
                                    </a>
                                </span>
                            </span>
                            <div style="" class="respite_number_task_state  {{$task->RespiteRemain['bg_color_class']}}">{{$task->RespiteRemain['days']}}</div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>