@foreach($result_packages as $list_task)
    <div class="col-xs-12 col-md-3 col-sm-6 pdrl-2">
        <div class="text-center div_title_not_started"><h6>{{$list_task['user']}}</h6></div>
        <div class="div_groups_task state_container droppable" id="task_notstarted" >
            <ul class="ul_dropp">
                @if(!empty($list_task['tasks']))
                    @foreach($list_task['tasks'] as $task)
                        <li>
                            <div class="header_div_list_task container-fluid prl-1">
                                <div class="span_title" >
                                    <span data-toggle="tooltip" title="{{$task->title}}">
                                        <a class='cursor-pointer jsPanels' href='/modals/ShowAssignTaskForm?tid={{enCode($task->id)}}'>
                                            @php
                                                $msgTrimmed = mb_substr($task->title,0,25);
                                                $lastSpace = strrpos($msgTrimmed, ' ', 0);
                                                $lastSpace = $lastSpace > 0 ? $lastSpace : 20;
                                                $title = mb_substr($msgTrimmed,0,$lastSpace);
                                            @endphp
                                            {{$title.(mb_strlen($title)<mb_strlen($task->title) ? '...' : '')}}
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
@endforeach
