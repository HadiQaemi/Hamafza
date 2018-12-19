<script>
    $('.first-fix-box').removeClass('height-100');
</script>
<div class="col-xs-12 col-md-3 col-sm-6 pdrl-2">
   <div class="text-center div_title_not_started"><h6>{{trans('tasks.status_not_started')}}</h6></div>
    <div class="div_groups_task state_container droppable" id="task_notstarted" >
        <ul class="ul_dropp">
            @if(!empty($not_started))
                @foreach($not_started as $project)
                    <li class="draggable" data-task_id="{{$project->id}}">
                        <div class="header_div_list_task container-fluid prl-1">
                            <div class="div_img">
                            </div>
                            <div class="span_title" >
                                <span data-toggle="tooltip" title="{{$project->title}}">
                                    <a class='cursor-pointer jsPanels' href='/modals/ShowAssignTaskForm?tid={{enCode($project->id)}}'>
                                        @php
                                            $msgTrimmed = mb_substr($project->title,0,25);
                                            $lastSpace = strrpos($msgTrimmed, ' ', 0);
                                            $lastSpace = $lastSpace > 0 ? $lastSpace : 20;
                                            $title = mb_substr($msgTrimmed,0,$lastSpace);
                                        @endphp
                                        {{$title.(mb_strlen($title)<mb_strlen($project->title) ? '...' : '')}}
                                    </a>
                                </span>
                            </div>
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
            @if(!empty($started))
                @foreach($started as $project)
                    <li class="draggable" data-task_id="{{$project->id}}">
                        <div class="header_div_list_task container-fluid prl-1">
                            <div class="span_title" >
                                <span data-toggle="tooltip" title="{{$project->title}}">
                                    <a class='cursor-pointer jsPanels' href='/modals/ShowAssignTaskForm?tid={{enCode($project->id)}}'>
                                        @php
                                            $msgTrimmed = mb_substr($project->title,0,25);
                                            $lastSpace = strrpos($msgTrimmed, ' ', 0);
                                            $lastSpace = $lastSpace > 0 ? $lastSpace : 20;
                                            $title = mb_substr($msgTrimmed,0,$lastSpace);
                                        @endphp
                                        {{$title.(mb_strlen($title)<mb_strlen($project->title) ? '...' : '')}}
                                    </a>
                                </span>
                            </div>
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
            @if(!empty($done))
                @foreach($done as $project)
                    <li class="draggable" data-task_id="{{$project->id}}">
                        <div class="header_div_list_task container-fluid prl-1">
                            <div class="div_img">
                            <div class="span_title" >
                                <span data-toggle="tooltip" title="{{$project->title}}">
                                    <a class='cursor-pointer jsPanels' href='/modals/ShowAssignTaskForm?tid={{enCode($project->id)}}'>
                                        @php
                                            $msgTrimmed = mb_substr($project->title,0,25);
                                            $lastSpace = strrpos($msgTrimmed, ' ', 0);
                                            $lastSpace = $lastSpace > 0 ? $lastSpace : 20;
                                            $title = mb_substr($msgTrimmed,0,$lastSpace);
                                        @endphp
                                        {{$title.(mb_strlen($title)<mb_strlen($project->title) ? '...' : '')}}
                                    </a>
                                </span>
                            </div>
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
            @if(!empty($ended))
                @foreach($ended as $project)
                    <li class="draggable" data-task_id="{{$project->id}}">
                        <div class="header_div_list_task container-fluid prl-1">
                            <div class="span_title" >
                                <span data-toggle="tooltip" title="{{$project->title}}">
                                    <a class='cursor-pointer jsPanels' href='/modals/ShowAssignTaskForm?tid={{enCode($project->id)}}'>
                                        @php
                                            $msgTrimmed = mb_substr($project->title,0,25);
                                            $lastSpace = strrpos($msgTrimmed, ' ', 0);
                                            $lastSpace = $lastSpace > 0 ? $lastSpace : 20;
                                            $title = mb_substr($msgTrimmed,0,$lastSpace);
                                        @endphp
                                        {{$title.(mb_strlen($title)<mb_strlen($project->title) ? '...' : '')}}
                                    </a>
                                </span>
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>