<div class="">
    @php
        $hashed_id = $ProjectInfo['hashed_id'];
        $pid = $ProjectInfo['pid'];
        $ordered_project_tasks = $ProjectInfo['ordered_project_tasks'];
        $task_project = $ProjectInfo['task_project'];
        $end_start = $ProjectInfo['end_start'];
        $parents = $ProjectInfo['parents'];
        $childs = $ProjectInfo['childs'];
        //$project_task_relations_begins = $ProjectInfo['project_task_relations_begins'];
        $hamahang_project_task = $ProjectInfo['hamahang_project_task']->toArray();
        $project_task_relations = $ProjectInfo['project_task_relations']->toArray();
        $ProjectInfo = json_decode($ProjectInfo['project_info']);
        $project_tasks = $ProjectInfo[0];
        $project_info = $ProjectInfo[1];
        $pages = $ProjectInfo[2];
        $project_keywords = $ProjectInfo[3];
        $project_responsibles = $ProjectInfo[4];
        $role_permission = $ProjectInfo[5];
        $user_permission = $ProjectInfo[6];
        $project_info = $project_info->project_info;
        $project_info = $project_info[0];
        $uname = auth()->user();
    @endphp
    <style>
        .hd-body{
            overflow: hidden !important;
        }
    </style>
    <div id="related_links" class="disabled" style="top: 2px;background: #eee;">
        <a class="@if( Route::currentRouteName() == 'pgs.desktop.hamahang.tasks.my_tasks.package') current_page @endif" href="#"><span><i class="card-icon related-icons" data-toggle="tooltip" title="{{ trans('projects.MyTaskPackages') }}"></i></span></a>
        <a class="@if( Route::currentRouteName() == 'pgs.desktop.hamahang.tasks.my_tasks.state') current_page @endif" href="#"><span><i class="fa fa-bar-chart" data-toggle="tooltip" title="{{ trans('projects.levels') }}"></i></span></a>
        <a class="@if( Route::currentRouteName() == 'pgs.desktop.hamahang.tasks.my_tasks.priority') current_page @endif project_tasks_chart" href="#" data-p_id="{{$hashed_id}}"><span><i class="fa fa-retweet" data-toggle="tooltip" title="{{ trans('projects.gantt') }}"></i></span></a>
        <a class="@if( Route::currentRouteName() == 'hamahang.project.show_project_tasks_list') current_page @endif" data-p_id="{{enCode($pid)}}" href="#"><span><i class="fa fa-list-alt" data-toggle="tooltip" title="{{ trans('projects.hierarchical') }}"></i></span></a>
    </div>
    <div class="col-xs-12">
        <div class="pull-right">{{trans('projects.title')}}: </div>
        <div class="pull-right margin-right-10">
            <a class='pointer project_info cursor-pointer' data-p_id= '{{enCode($pid)}}' data-toggle='tooltip' title='ویرایش'>{{$project_info->title}}</a>
        </div>
    </div>

    <div class="col-xs-12" style="border-bottom: solid 1px #555;">
        {{--<div class="pull-right line-height-35 margin-top-20 margin-right-50">--}}
        {{--<div class="pull-right">{{trans('projects.describe')}}: </div>--}}
        {{--<div class="pull-right margin-right-10">--}}
        {{--{{$project_info->desc}}--}}
        {{--</div>--}}
        {{--</div>--}}
        <div class="pull-right line-height-35">
                @if(!empty($project_responsibles->responsibles))
                    @foreach($project_responsibles->responsibles as $project_res)
                        <div class="pull-right">{{trans("projects.project_responsible_$project_res->permission_type")}}: </div>
                        <div class="pull-right margin-left-10">
                            <a class="margin-right-10" href="/{{ $project_res->user_id }}0" target="_blank">{{ $project_res->full_name }}</a>
                        </div>
                    @endforeach
                @endif
        </div>
        <div class="pull-right line-height-35 margin-right-50">
            <div class="pull-right">پیشرفت: </div>
            <div class="pull-right margin-right-10">
                <span id="project_progress">{{$project_info->progress}}</span>
            </div>
        </div>
    </div>
    <div class="col-xs-12 line-height-35 margin-top-20 border-top-lg" style="height: 500px;overflow: auto">
        <div class="row col-xs-12 noLeftPadding noRightPadding margin-top-10 padding-bottom-10 border-bottom">
            <div class="col-xs-1 noRightPadding noLeftPadding">شماره</div>
            <div class="col-xs-6 noRightPadding noLeftPadding">عنوان</div>
            <div class="col-xs-2 noRightPadding noLeftPadding">مسئول</div>
            <div class="col-xs-1 noRightPadding noLeftPadding">وزن/پیشرفت</div>
            <div class="col-xs-2 noRightPadding noLeftPadding">عملیات</div>
        </div>
        <div class="row col-xs-12 noLeftPadding noRightPadding margin-top-10 padding-bottom-10 task_list_project" style="overflow-y: scroll;height: 400px">
            <form class="list-project-tasks">
                <?php
                foreach($ordered_project_tasks as $task)
                {
                    if($task->title == null)
                        continue;
                    if(!in_array($task->id,$childs))
                    {
                        if(!isset($parents[$task->id]))
                        {
                            echo '<div class="row col-xs-12 noLeftPadding noRightPadding margin-top-10 padding-bottom-10 process'.$task->id.'">';
                        }else{
                            echo '<div class="row col-xs-12 noLeftPadding noRightPadding process'.$task->id.'">';
                        }
                        echo '<div class="col-xs-1 noRightPadding noLeftPadding">'.$task->id.'</div>';
                        echo '<div class="col-xs-6 noRightPadding noLeftPadding">'.(isset($parents[$task->id]) ? '<i class="fa fa-caret-left padding-left-10" aria-hidden="true"></i>' : '' ).
                            '<a class="cursor-pointer jsPanels" href="/modals/ViewTaskForm?tid='.enCode($task->id).'&pid='.enCode($pid).'">'.$task->title.'</a></div>';
                        echo '<div class="col-xs-2 noRightPadding noLeftPadding">'.$task->Assignment->Employee->Name.' '.$task->Assignment->Employee->Family.'</div>';
                        echo '<div class="col-xs-1 noRightPadding noLeftPadding">
                            <input type="text" class="text-project-weight weight-'.$task->id.'" value="'.(isset($task->weight) ? $task->weight : '').'" rel="'.$task->id.'" name="task_project_weight[parent-'.$task_project[$task->id].'-'.$task->id.']" autocomplete="off"/>
                            <input type="text" class="text-project-progress progress-'.$task->id.'" value="'.(isset($task->progress) ? $task->progress : '').'" rel="'.$task->id.'" name="task_project_progress['.$task->id.']" autocomplete="off"/>
                            <i class="fa fa-check color_green task_project_save_status pointer margin-left-10" data-toggle="tooltip" title="'.trans('projects.check_weight_progress').'" t="'.$task->id.'" pid="'.enCode($pid).'" rel="'.$task_project[$task->id].'" tp="parent"></i>
                        </div>';
                        echo '<div class="col-xs-2 noRightPadding noLeftPadding">
                            <i class="fa fa-remove color_red task_project_remove pointer margin-left-10" t="'.enCode($task->id).'" pid="'.enCode($pid).'" data-toggle="tooltip" title="'.trans('projects.delete_task_project').'"></i>
                            <i class="fa fa-trash task_remove pointer margin-left-10" t="'.enCode($task->id).'" data-toggle="tooltip" title="'.trans('projects.delete_task').'"></i></div>';
                        echo '</div>';
                        if(isset($parents[$task->id]))
                        {
                            show_project($parents,$ordered_project_tasks,$task->id,$pid);
                        }
                    }
                }
                ?>
            </form>
        </div>
    </div>
    @include('hamahang.Tasks.MyAssignedTask.helper.RapidCreateTask',['pid'=>@$pid])
    <?php
    function show_project($parents,$ordered_project_tasks,$id,$pid,$cnt=1)
    {
        foreach($parents[$id] as $sub_task)
        {
            if(isset($parents[$ordered_project_tasks[$sub_task['id']]->id]))
            {
                echo '<div class="row col-xs-12 noLeftPadding noRightPadding margin-top-10 padding-bottom-10 process'.$ordered_project_tasks[$sub_task['id']]->id.'">';
            }else{
                echo '<div class="row col-xs-12 noLeftPadding noRightPadding margin-top-10 process'.$ordered_project_tasks[$sub_task['id']]->id.'">';
            }
            echo '<div class="col-xs-1">'.$ordered_project_tasks[$sub_task['id']]->id.'</div>';
            echo '<div class="col-xs-6" style="padding-right: '.(30*$cnt).'px !important">'.(isset($parents[$ordered_project_tasks[$sub_task['id']]->id]) ? '<i class="fa fa-caret-left padding-left-10" aria-hidden="true"></i>' : '' ).
                '<a class="cursor-pointer jsPanels" href="/modals/ViewTaskForm?tid='.enCode($ordered_project_tasks[$sub_task['id']]->id).'&pid='.enCode($pid).'">'.$ordered_project_tasks[$sub_task['id']]->title.'</a></div>';
            echo '<div class="col-xs-2 noRightPadding noLeftPadding">'.$ordered_project_tasks[$sub_task['id']]->Assignment->Employee->Name.' '.$ordered_project_tasks[$sub_task['id']]->Assignment->Employee->Family.'</div>';
            echo '<div class="col-xs-1">
                <input type="text" class="text-project-weight child_of_'.$id.' weight-'.$id.'" value="'.(isset($ordered_project_tasks[$sub_task['id']]->weight) ? $ordered_project_tasks[$sub_task['id']]->weight : '').'" rel="'.$ordered_project_tasks[$sub_task['id']]->id.'" name="task_project_weight[child-'.$sub_task['rel'].']" autocomplete="off"/>
                <input type="text" class="text-project-progress child_of_'.$id.' progress-'.$sub_task['id'].'" value="'.(isset($ordered_project_tasks[$sub_task['id']]->progress) ? $ordered_project_tasks[$sub_task['id']]->progress : '').'" rel="'.$ordered_project_tasks[$sub_task['id']]->id.'" name="task_project_progress['.$ordered_project_tasks[$sub_task['id']]->id.']" autocomplete="off"/></div>
                <i class="fa fa-check task_project_save_status pointer margin-left-10" hp_task="'.enCode($ordered_project_tasks['hp_task']).'" tp="child" rel="'.$sub_task['rel'].'" t="'.enCode($ordered_project_tasks[$sub_task['id']]->id).'" pid="'.enCode($pid).'" parent="'.$id.'"></i>';
            echo '<div class="col-xs-2">
                    <i class="fa fa-remove task_project_remove color_red pointer margin-left-10" rel="'.enCode($sub_task['rel']).'" t="'.enCode($ordered_project_tasks[$sub_task['id']]->id).'" pid="'.enCode($pid).'"></i>
                    <i class="fa fa-trash task_remove pointer margin-left-10" rel="'.enCode($sub_task['rel']).'" t="'.$ordered_project_tasks[$sub_task['id']]->id.'"></i>
            </div>';
            echo '</div>';
            if(isset($parents[$ordered_project_tasks[$sub_task['id']]->id]))
            {
                show_project($parents,$ordered_project_tasks,$ordered_project_tasks[$sub_task['id']]->id,$pid,++$cnt);
            }
        }
    }
    ?>
</div>