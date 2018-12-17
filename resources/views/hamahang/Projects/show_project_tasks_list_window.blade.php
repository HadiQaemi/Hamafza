@php
    $ordered_project_tasks = $ProjectInfo['ordered_project_tasks'];
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
<div style="position: absolute;top:10px; width: 250px;left:0px;">
    @include('hamahang.Tasks.projects.project_related_pages')
</div>
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

    {{--<div class="pull-right line-height-35 margin-top-20 margin-right-50">--}}
        {{--<div class="pull-right">{{trans('projects.pages')}}: </div>--}}
        {{--<div class="pull-right margin-right-10">--}}
            {{--@if(!empty($pages->pages))--}}
                {{--@foreach($pages->pages as $page_res)--}}
                    {{--<a class="margin-right-10" href="/{{ $page_res->subject_id }}0" target="_blank">{{ $page_res->title }}</a>--}}
                {{--@endforeach--}}
            {{--@endif--}}
        {{--</div>--}}
    {{--</div>--}}
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
        <div class="pull-right"> درصد پیشرفت: </div>
        <div class="pull-right margin-right-10">
            0
        </div>
    </div>
    {{--<div class="pull-right line-height-35 margin-top-20 margin-right-50">--}}
        {{--<div class="pull-right">{{trans('projects.keywords')}}: </div>--}}
        {{--<div class="pull-right margin-right-10">--}}
            {{--@if(!empty($project_keywords->project_keywords))--}}
                {{--@foreach($project_keywords->project_keywords as $project_keyword)--}}
                    {{--<span class="bottom_keywords one_keyword" data-id="{{ $project_keyword->id }}" data-title="{{ $project_keyword->title }}"><i class="fa fa-tag"></i> <span style="color: #6391C5;">{{ $project_keyword->title }}</span></span>--}}
                {{--@endforeach--}}
            {{--@endif--}}
        {{--</div>--}}
    {{--</div>--}}
</div>
<div class="col-xs-12 line-height-35 margin-top-20 border-top-lg" style="height: 500px;overflow: auto">
    {{--<table id="ProjectList" class="table dt-responsive nowrap display dataTable no-footer"--}}
           {{--style="text-align: center" cellspacing="0" width="100%">--}}
        {{--<thead>--}}
        <div class="row col-xs-12 noLeftPadding noRightPadding margin-top-10 padding-bottom-10 border-bottom">
            <div class="col-xs-1">شماره</div>
            <div class="col-xs-6">عنوان</div>
            <div class="col-xs-2">وزن</div>
            <div class="col-xs-2">درصد پیشرفت</div>
            <div class="col-xs-1">عملیات</div>
        </div>
        {{--</thead>--}}
        <?php
        foreach($ordered_project_tasks as $task)
        {
            if(!in_array($task->id,$childs))
            {
                if(!isset($parents[$task->id]))
                {
                    echo '<div class="row col-xs-12 noLeftPadding noRightPadding margin-top-10 padding-bottom-10 border-bottom">';
                }else{
                    echo '<div class="row col-xs-12 noLeftPadding noRightPadding">';
                }
                echo '<div class="col-xs-1">'.$task->id.'</div>';
                echo '<div class="col-xs-6">'.$task->title.'</div>';
                echo '<div class="col-xs-2"><input type="text" value="'.(isset($task->weight) ? $task->weight : '').'" rel="'.$task->id.'" name="task_project_weight[]"/></div>';
                echo '<div class="col-xs-2"><input type="text" value="'.(isset($task->progress) ? $task->progress : '').'" rel="'.$task->id.'" name="task_project_progress[]"/></div>';
                echo '<div class="col-xs-1"><i class="fa fa-remove task_project_remove pointer margin-left-10" rel="'.$task->id.'"></i><i class="fa fa-check task_project_check pointer" rel="'.$task->id.'"></i></div>';
                if(isset($parents[$task->id]))
                {
                    show_project($parents,$ordered_project_tasks,$task->id);
                }
                echo '</div>';
            }
        }
        ?>
    </table>
</div>
<?php
function show_project($parents,$ordered_project_tasks,$id)
{
    foreach($parents[$id] as $sub_task)
    {
//        echo '<div class="row col-xs-12 padding-right-30 noLeftPadding noRightPadding margin-top-10 padding-bottom-10 border-bottom">';
        if(isset($parents[$ordered_project_tasks[$sub_task]->id]))
        {
            echo '<div class="row col-xs-12 noLeftPadding padding-right-30 noRightPadding margin-top-10 padding-bottom-10 border-bottom">';
        }else{
            echo '<div class="row col-xs-12 noLeftPadding padding-right-30 noRightPadding margin-top-10">';
        }
        echo '<div class="col-xs-1">'.$ordered_project_tasks[$sub_task]->id.'</div>';
        echo '<div class="col-xs-6">'.$ordered_project_tasks[$sub_task]->title.'</div>';
        echo '<div class="col-xs-2"><input type="text" value="'.(isset($ordered_project_tasks[$sub_task]->weight) ? $ordered_project_tasks[$sub_task]->weight : '').'" rel="'.$ordered_project_tasks[$sub_task]->id.'" name="task_project_weight[]"/></div>';
        echo '<div class="col-xs-2"><input type="text" value="'.(isset($ordered_project_tasks[$sub_task]->progress) ? $ordered_project_tasks[$sub_task]->progress : '').'" rel="'.$ordered_project_tasks[$sub_task]->id.'" name="task_project_progress[]"/></div>';
        echo '<div class="col-xs-1"><i class="fa fa-remove task_project_remove pointer margin-left-10" rel="'.$ordered_project_tasks[$sub_task]->id.'"></i><i class="fa fa-check task_project_check pointer" rel="'.$ordered_project_tasks[$sub_task]->id.'"></i></div>';
        if(isset($parents[$ordered_project_tasks[$sub_task]->id]))
        {
            show_project($parents,$ordered_project_tasks,$ordered_project_tasks[$sub_task]->id);
        }
        echo '</div>';
    }
}
?>