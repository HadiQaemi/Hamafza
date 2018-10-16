@php
    $package_type = '';
    if(Request::input('package_type')=='persons')
    {
        $package_type = 'pid';
    }else if(Request::input('package_type')=='pages')
    {
        $package_type = 'pgid';
    }else if(Request::input('package_type')=='keywords')
    {
        $package_type = 'kid';
    }
@endphp
@foreach($result_packages as $list_task)
    <div class="col-xs-12 col-md-3 col-sm-6 pdrl-2">
        <div class="text-center div_title_not_started">
            <h6>
                <span style="margin-left: 10px"><i class="fa fa-sort-up pointer font-large"></i><i class="fa fa-sort-down pointer font-large"></i></span>
                {{$list_task['name']}}
                {{--(<span>{{(isset($list_task['tasks']) ? count($list_task['tasks']) : 0)}}</span>)--}}
                <span style="margin-right: 10px">
                    <a href="{{url('/modals/CreateNewTask?uid='.auth()->id().'&'.$package_type.'='.$list_task['object_id'])}}" title="وظیفه جدید" class="jsPanels fa fa-plus-square pointer font-large"></a>
                </span>
            </h6>
        </div>
        <div class="div_groups_task state_container droppable" id="task_notstarted" >
            <ul class="ul_dropp">
                @if(!empty($list_task['tasks']))
                    @foreach($list_task['tasks'] as $task)
                        <li>
                            <div class="header_div_list_task container-fluid prl-1">
                                <div class="span_title" >
                                    <span data-toggle="tooltip" title="{{$task->title}}">
                                        <a class='cursor-pointer jsPanels' href='/modals/ShowTaskForm?tid={{enCode($task->task_id)}}'>
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
