<style>
    #related_links {
        padding: 1px;
        left: 15px;
        position: absolute;
        top: -9px;
        left:27px;
        z-index:11;
    }
    #related_links a {
        padding: 1px;
        float: left;
        margin-left: 3px;
    }
    #related_links span {
        font-size: 15px;
        color: black;
    }
    .current_page {
        padding-left: 5px;
        background-color: limegreen;
    }
</style>
    <div id="related_links" >
        @if(isset($filter_subject_id))
            <a class="@if( Route::currentRouteName() == 'pgs.desktop.hamahang.tasks.my_tasks.all_task_state') current_page @endif" href="{{ route('pgs.desktop.hamahang.tasks.my_tasks.all_task_state',['username'=>$uname]) }}"><span><i class="steps-icon related-icons" data-toggle="tooltip" title="{{ trans('tasks.MyTasksState') }}"></i></span></a>
            <a class="@if( Route::currentRouteName() == 'pgs.desktop.hamahang.tasks.my_tasks.all_task_priority') current_page @endif" href="{{ route('pgs.desktop.hamahang.tasks.my_tasks.all_task_priority',['username'=>$uname]) }}"><span><i class="priority-icon related-icons" data-toggle="tooltip" title="{{ trans('tasks.MyTasksPriority') }}"></i></span></a>
            <a class="@if( Route::currentRouteName() == 'pgs.desktop.hamahang.tasks.my_tasks.all_task_list') current_page @endif" href="{{ route('pgs.desktop.hamahang.tasks.my_tasks.all_task_list',['username'=>$uname]) }}"><span><i class="table-icon related-icons" data-toggle="tooltip" title="{{ trans('tasks.MyTasksList') }}"></i></span></a>
        @else

            <a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.tasks.my_tasks.all_task_state') current_page @endif" href="{{ route('ugc.desktop.hamahang.tasks.my_tasks.all_task_state',['username'=>$uname]) }}"><span><i class="steps-icon related-icons" data-toggle="tooltip" title="{{ trans('tasks.MyTasksState') }}"></i></span></a>
            <a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.tasks.my_tasks.all_task_priority') current_page @endif" href="{{ route('ugc.desktop.hamahang.tasks.my_tasks.all_task_priority',['username'=>$uname]) }}"><span><i class="priority-icon related-icons" data-toggle="tooltip" title="{{ trans('tasks.MyTasksPriority') }}"></i></span></a>
            <a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.tasks.my_tasks.all_task_list') current_page @endif" href="{{ route('ugc.desktop.hamahang.tasks.my_tasks.all_task_list',['username'=>$uname]) }}"><span><i class="table-icon related-icons" data-toggle="tooltip" title="{{ trans('tasks.MyTasksList') }}"></i></span></a>
        @endif
    </div>
