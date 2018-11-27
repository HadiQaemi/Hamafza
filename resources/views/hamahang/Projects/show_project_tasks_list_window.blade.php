@php
    $ordered_project_tasks = $ProjectInfo['ordered_project_tasks'];
    $end_start = $ProjectInfo['end_start'];
    $project_task_relations_begins = $ProjectInfo['project_task_relations_begins'];
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
            {{trans('projects.title')}}.
        </div>
    </div>
    <div class="pull-right line-height-35 margin-top-20 margin-right-50">
        <div class="pull-right">{{trans('projects.describe')}}: </div>
        <div class="pull-right margin-right-10">
            {{$project_info->desc}}
        </div>
    </div>
    <div class="pull-right line-height-35 margin-top-20 margin-right-50">
        <div class="pull-right">{{trans('projects.pages')}}: </div>
        <div class="pull-right margin-right-10">
            @if(!empty($pages->pages))
                @foreach($pages->pages as $page_res)
                    <a class="margin-right-10" href="/{{ $page_res->subject_id }}0" target="_blank">{{ $page_res->title }}</a>
                @endforeach
            @endif
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
        <div class="pull-right">{{trans('projects.keywords')}}: </div>
        <div class="pull-right margin-right-10">
            @if(!empty($project_keywords->project_keywords))
                @foreach($project_keywords->project_keywords as $project_keyword)
                    <span class="bottom_keywords one_keyword" data-id="{{ $project_keyword->id }}" data-title="{{ $project_keyword->title }}"><i class="fa fa-tag"></i> <span style="color: #6391C5;">{{ $project_keyword->title }}</span></span>
                @endforeach
            @endif
        </div>
    </div>
</div>
<div class="col-xs-12 line-height-35 margin-top-20 border-top-lg" style="height: 500px;overflow: auto">
    <table id="ProjectList" class="table dt-responsive nowrap display dataTable no-footer"
           style="text-align: center" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>شماره</th>
            <th>عنوان</th>
            <th>وزن</th>
            <th>درصد پیشرفت</th>
        </tr>
        </thead>
        <?php
        foreach($ordered_project_tasks as $task)
        {
            echo '<tr>';
                echo '<td>'.$task->id.'</td>';
                echo '<td>'.$task->title.'</td>';
                echo '<td>'.(isset($end_start[$task->id]->task_id2) ? $end_start[$task->id]->task_id2 : '').'</td>';
                echo '<td>'.(isset($end_start[$task->id]->task_id2) ? $end_start[$task->id]->task_id2 : '').'</td>';
            echo '</tr>';
        }
        ?>
    </table>
</div>