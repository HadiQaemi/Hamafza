@php
    $package_type = '';
    if(Request::input('package_type')=='persons')
    {
        $package_type = 'urid';
    }else if(Request::input('package_type')=='pages')
    {
        $package_type = 'sid';
    }else if(Request::input('package_type')=='keywords')
    {
        $package_type = 'kdid';
    }
@endphp

@foreach($result_packages as $list_task)
    <div class="col-xs-12 col-md-3 col-sm-6 pdrl-2">
        <div class="text-center div_title_not_started">
            <h6>
                {{--<span style="margin-left: 10px"><i class="fa fa-sort-up pointer font-large"></i><i class="fa fa-sort-down pointer font-large"></i></span>--}}
                @if(Request::input('package_type')=='persons')
                    <a href='{{url('/' . $list_task['tasks'][0]->uname)}}' target='_blank'>{{$list_task['name']}}</a>
                @else
                    {{$list_task['name']}}
                @endif
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
                            <div class="header_div_list_task container-fluid prl-1 text_ellipsis">
                                <div class="span_title text_ellipsis" style="margin: 0px 10px" >
                                    <span data-toggle="tooltip" title="{{$task->title}}">
                                        <a class='cursor-pointer jsPanels' href='/modals/ViewTaskForm?tid={{enCode($task->task_id)}}'>
                                            {{--@php--}}
                                                {{--$msgTrimmed = preg_split('/ /',$task->title);--}}
                                                {{--$cnt = 0;--}}
                                                {{--$sub_title = '';--}}
                                                {{--foreach($msgTrimmed as $word){--}}
                                                    {{--if($cnt++ <=5){--}}
                                                        {{--$sub_title .= " $word";--}}
                                                    {{--}else{--}}
                                                        {{--$sub_title .= '...';--}}
                                                        {{--break;--}}
                                                    {{--}--}}
                                                {{--}--}}
                                            {{--@endphp--}}
                                            {{$task->title}}
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
