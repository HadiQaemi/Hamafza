<div id="priority_content_area">
    <div class="row" style="display: flex">
        <div class="col-xs-6 priority_state_list">
            <h5 class="state_title">مهم و فوری</h5>
            <ul class="task_items droppable" id="important_and_immediate">
                <div style="direction: rtl;">
                    @foreach($projects_immediate_importance as $project)

                        <li class="draggable" data-action="project" data-project_id="{{$project->id}}">

                            <div class="project_title">
                                <h5 class="text_ellipsis">
                                    <a class='cursor-pointer ' href='#'>
                                        @php
                                            $title = $project->title;
                                            if(mb_strlen($title,'UTF-8')>30){
                                                $content = mb_substr(strip_tags($title), 0, 30,'UTF-8');
                                                $content .= '…';
                                            }else{
                                                $content = strip_tags($title);
                                            }
                                        @endphp
                                        {{$content}}
                                    </a>
                                </h5>
                            </div>

                        </li>
                    @endforeach
                </div>
            </ul>
        </div>
        <div class="col-xs-6 priority_state_list">
            <h5 class="state_title">غیر مهم و فوری</h5>
            <ul class="task_items droppable" id="not_important_and_immediate">
                <div style="direction: rtl;">
                    @foreach($projects_immediate_not_importance as $project)
                        <li class="draggable" data-action="project" data-project_id="{{$project->id}}">
                            <div class="project_title">
                                <h5 class="text_ellipsis">
                                    <a class='cursor-pointer ' href='#'>
                                        @php
                                            $title = $project->title;
                                            if(mb_strlen($title,'UTF-8')>30){
                                                $content = mb_substr(strip_tags($title), 0, 30,'UTF-8');
                                                $content .= '…';
                                            }else{
                                                $content = strip_tags($title);
                                            }
                                        @endphp
                                        {{$content}}
                                    </a>
                                </h5>
                            </div>

                        </li>
                    @endforeach
                </div>
            </ul>
        </div>
    </div>
    <div class="row" style="display: flex">
        <div class="col-xs-6 priority_state_list">
            <h5 class="state_title">مهم و غیر فوری</h5>
            <ul class="task_items droppable" id="important_and_not_immediate">
                <div style="direction: rtl;">
                    @foreach($projects_not_immediate_importance as $project)
                        <li class="draggable" data-action="project" data-project_id="{{$project->id}}">
                            <div class="project_title">
                                <h5 class="text_ellipsis">
                                    <a class='cursor-pointer ' href='#'>
                                        @php
                                            $title = $project->title;
                                            if(mb_strlen($title,'UTF-8')>30){
                                                $content = mb_substr(strip_tags($title), 0, 30,'UTF-8');
                                                $content .= '…';
                                            }else{
                                                $content = strip_tags($title);
                                            }
                                        @endphp
                                        {{$content}}
                                    </a>
                                </h5>
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
                    @foreach($projects_not_immediate_not_importance as $project)

                        <li class="draggable" data-action="project" data-project_id="{{$project->id}}">
                            <div class="project_title">
                                <h5 class="text_ellipsis">
                                    <a class='cursor-pointer ' href='#'>
                                        @php
                                            $title = $project->title;
                                            if(mb_strlen($title,'UTF-8')>30){
                                                $content = mb_substr(strip_tags($title), 0, 30,'UTF-8');
                                                $content .= '…';
                                            }else{
                                                $content = strip_tags($title);
                                            }
                                        @endphp
                                        {{$content}}
                                    </a>
                                </h5>
                            </div>
                        </li>
                    @endforeach
                </div>
            </ul>
        </div>
    </div>
</div>