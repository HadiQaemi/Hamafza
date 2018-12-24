@php
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
@endphp

<div class="col-xs-12 margin-top-20" style="border-bottom: solid 1px #555;padding-bottom: 20px">
    <div class="pull-right line-height-35 margin-top-20">
        <div class="pull-right">{{trans('projects.title')}}: </div>
        <div class="pull-right margin-right-10">
            {{$project_info->title}}
        </div>
    </div>
    <div class="pull-right line-height-35 margin-top-20 margin-right-50">
        <div class="pull-right">{{trans('projects.describe')}}: </div>
        <div class="pull-right margin-right-10">
            {{$project_info->desc}}
        </div>
    </div>
    <div class="pull-right line-height-35 margin-top-20 margin-right-50">
        <div class="pull-right">{{trans('projects.project_manager')}}: </div>
        <div class="pull-right margin-right-10">
            @if(!empty($project_responsibles->responsibles))
                @foreach($project_responsibles->responsibles as $project_res)
                    <a class="margin-right-10" href="/{{ $project_res->user_id }}0" target="_blank">{{ $project_res->full_name }}</a>
                @endforeach
            @endif
        </div>
    </div>
    <div class="pull-right line-height-35 margin-top-20 margin-right-50">
        <div class="pull-right">پیشرفت: </div>
        <div class="pull-right margin-right-10">
            <span id="project_progress">{{$project_info->progress}}</span>
        </div>
    </div>
</div>
<div class="col-xs-12 line-height-35 margin-top-20 border-top-lg" style="height: 500px;overflow: auto">
        <div class="row col-xs-12 noLeftPadding noRightPadding margin-top-10 padding-bottom-10 border-bottom">
            <div class="col-xs-1">شماره</div>
            <div class="col-xs-7">عنوان</div>
            <div class="col-xs-1">وزن</div>
            <div class="col-xs-1">پیشرفت</div>
            <div class="col-xs-2">عملیات</div>
        </div>
    <form class="list-project-tasks">
        <?php
        foreach($ordered_project_tasks as $task)
        {
            if(!in_array($task->id,$childs))
            {
                if(!isset($parents[$task->id]))
                {
                    echo '<div class="row col-xs-12 noLeftPadding noRightPadding margin-top-10 padding-bottom-10 border-bottom process'.$task->id.'">';
                }else{
                    echo '<div class="row col-xs-12 noLeftPadding noRightPadding process'.$task->id.'">';
                }
                echo '<div class="col-xs-1">'.$task->id.'</div>';
                echo '<div class="col-xs-7">'.$task->title.'</div>';
                echo '<div class="col-xs-1"><input type="text" class="text-project-weight weight-'.$task->id.'" value="'.(isset($task->weight) ? $task->weight : '').'" rel="'.$task->id.'" name="task_project_weight[parent-'.$task_project[$task->id].'-'.$task->id.']" autocomplete="off"/></div>';
                echo '<div class="col-xs-1"><input type="text" class="text-project-progress progress-'.$task->id.'" value="'.(isset($task->progress) ? $task->progress : '').'" rel="'.$task->id.'" name="task_project_progress['.$task->id.']" autocomplete="off"/></div>';
                echo '<div class="col-xs-2"><i class="fa fa-remove task_project_remove pointer margin-left-10" t="'.$task->id.'"></i><i class="fa fa-trash task_remove pointer margin-left-10" t="'.$task->id.'"></i><i class="fa fa-check task_project_save_status pointer" t="'.$task->id.'" pid="'.$pid.'" rel="'.$task_project[$task->id].'" tp="parent"></i></div>';
                if(isset($parents[$task->id]))
                {
                    show_project($parents,$ordered_project_tasks,$task->id,$pid);
                }
                echo '</div>';
            }
        }
        ?>
    </form>
</div>
<?php
function show_project($parents,$ordered_project_tasks,$id,$pid)
{
    foreach($parents[$id] as $sub_task)
    {
        if(isset($parents[$ordered_project_tasks[$sub_task['id']]->id]))
        {
            echo '<div class="row col-xs-12 noLeftPadding padding-right-30 noRightPadding margin-top-10 padding-bottom-10 border-bottom process'.$ordered_project_tasks[$sub_task['id']]->id.'">';
        }else{
            echo '<div class="row col-xs-12 noLeftPadding padding-right-30 noRightPadding margin-top-10 process'.$ordered_project_tasks[$sub_task['id']]->id.'">';
        }
        echo '<div class="col-xs-1">'.$ordered_project_tasks[$sub_task['id']]->id.'</div>';
        echo '<div class="col-xs-7">'.$ordered_project_tasks[$sub_task['id']]->title.'</div>';
        echo '<div class="col-xs-1"><input type="text" class="text-project-weight child_of_'.$id.' weight-'.$id.'" value="'.(isset($ordered_project_tasks[$sub_task['id']]->weight) ? $ordered_project_tasks[$sub_task['id']]->weight : '').'" rel="'.$ordered_project_tasks[$sub_task['id']]->id.'" name="task_project_weight[child-'.$sub_task['rel'].']" autocomplete="off"/></div>';
        echo '<div class="col-xs-1"><input type="text" class="text-project-progress child_of_'.$id.' progress-'.$sub_task['id'].'" value="'.(isset($ordered_project_tasks[$sub_task['id']]->progress) ? $ordered_project_tasks[$sub_task['id']]->progress : '').'" rel="'.$ordered_project_tasks[$sub_task['id']]->id.'" name="task_project_progress['.$ordered_project_tasks[$sub_task['id']]->id.']" autocomplete="off"/></div>';
        echo '<div class="col-xs-2"><i class="fa fa-remove task_project_remove pointer margin-left-10"  rel="'.$sub_task['rel'].'" t="'.$ordered_project_tasks[$sub_task['id']]->id.'"></i><i class="fa fa-trash task_remove pointer margin-left-10" rel="'.$sub_task['rel'].'" t="'.$ordered_project_tasks[$sub_task['id']]->id.'"></i><i class="fa fa-check task_project_save_status pointer" tp="child" rel="'.$sub_task['rel'].'" t="'.$ordered_project_tasks[$sub_task['id']]->id.'" pid="'.$pid.'" parent="'.$id.'"></i></div>';
        if(isset($parents[$ordered_project_tasks[$sub_task['id']]->id]))
        {
            show_project($parents,$ordered_project_tasks,$ordered_project_tasks[$sub_task['id']]->id,$pid);
        }
        echo '</div>';
    }
}
?>
