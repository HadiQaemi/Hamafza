<div id="priority_content_area">
    <div class="row" style="display: flex">
        <div class="col-xs-6 priority_state_list">
            <h5 class="state_title">مهم و فوری</h5>
            <ul class="task_items droppable" id="important_and_immediate">
                <div style="direction: rtl;">
                @foreach($tasks_immediate_importance as $task)
                    <li class="draggable" data-task_id="{{$task->id}}">

                        <div class="respite_number {{$task->RespiteRemain['bg_color_class']}}">{{$task->RespiteRemain['days']}}</div>
                        <div class="task_title">
                            <h5 class="text_ellipsis">
                                <a class="task_info cursor-pointer" data-t_id="{{$task->id}}" title="{{$task->title}}">{{$task->title}}</a>
                            </h5>
                        </div>
                        <div class="state">
                            {!! $task->Status->StatusIcon !!}
                        </div>
                        <div class="referrer">
                            <a href="{{url($task->Assignment->Assigner->Uname)}}" title="{{$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                <i >{!! $task->Assignment->Assigner->BetweenSmallandBig !!}</i>
                            </a>
                        </div>

                    </li>
                @endforeach
                </div>
            </ul>
        </div>
        <div class="col-xs-6 priority_state_list">
            <h5 class="state_title">مهم و غیر فوری</h5>
            <ul class="task_items droppable" id="important_and_not_immediate">
                <div style="direction: rtl;">
                @foreach($tasks_not_immediate_importance as $task)
                    <li class="draggable" data-task_id="{{$task->id}}">
                        <div class="respite_number {{$task->RespiteRemain['bg_color_class']}}">{{$task->RespiteRemain['days']}}</div>
                        <div class="task_title">
                            <h5 class="text_ellipsis">
                                <a class="task_info cursor-pointer" data-t_id="{{$task->id}}" title="{{$task->title}}">{{$task->title}}</a>
                            </h5>
                        </div>
                        <div class="state">
                            {!! $task->Status->StatusIcon !!}
                        </div>
                        <div class="referrer">
                            <a href="{{url($task->Assignment->Assigner->Uname)}}" title="{{$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                <i >{!! $task->Assignment->Assigner->BetweenSmallandBig !!}</i>
                            </a>
                        </div>
                    </li>
                @endforeach
                </div>
            </ul>
        </div>
    </div>
    <div class="row" style="display: flex">
        <div class="col-xs-6 priority_state_list">
            <h5 class="state_title">غیر مهم و فوری</h5>
            <ul class="task_items droppable" id="not_important_and_immediate">
                <div style="direction: rtl;">
                @foreach($tasks_immediate_not_importance as $task)
                    <li class="draggable" data-task_id="{{$task->id}}">
                        <div class="respite_number {{$task->RespiteRemain['bg_color_class']}}">{{$task->RespiteRemain['days']}}</div>
                        <div class="task_title">
                            <h5 class="text_ellipsis">
                                <a class="task_info cursor-pointer" data-t_id="{{$task->id}}" title="{{$task->title}}">{{$task->title}}</a>
                            </h5>
                        </div>
                        <div class="state">
                            {!! $task->Status->StatusIcon !!}
                        </div>
                        <div class="referrer">
                            <a href="{{url($task->Assignment->Assigner->Uname)}}" title="{{$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                <i >{!! $task->Assignment->Assigner->BetweenSmallandBig !!}</i>
                            </a>
                        </div>
                    </li>
                @endforeach
                </div>
            </ul>
        </div>
        <div class="col-xs-6 priority_state_list">
            <h5 class="state_title">غیر مهم و غیر فوری</h5>
            <ul class="task_items droppable" id="not_important_and_not_immediate">
                <div style="direction: rtl;">
                @foreach($tasks_not_immediate_not_importance as $task)
                    <li class="draggable" data-task_id="{{$task->id}}">
                        <div class="respite_number {{$task->RespiteRemain['bg_color_class']}}">{{$task->RespiteRemain['days']}}</div>
                        <div class="task_title">
                            <h5 class="text_ellipsis">
                                <a class="task_info cursor-pointer" data-t_id="{{$task->id}}" title="{{$task->title}}">{{$task->title}}</a>
                            </h5>
                        </div>
                        <div class="state">
                            {!! $task->Status->StatusIcon !!}
                        </div>
                        <div class="referrer">
                            <a href="{{url($task->Assignment->Assigner->Uname)}}" title="{{$task->Assignment->Assigner->Name . ' ' . $task->Assignment->Assigner->Family}}">
                                <i >{!! $task->Assignment->Assigner->BetweenSmallandBig !!}</i>
                            </a>
                        </div>
                    </li>
                @endforeach
                </div>
            </ul>
        </div>
    </div>
</div>