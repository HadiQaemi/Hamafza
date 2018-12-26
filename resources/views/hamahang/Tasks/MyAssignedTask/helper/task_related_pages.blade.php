<style>
        #related_links {
                padding: 1px;
                left: 15px;
                position: absolute;
                top: -8px;
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
    <div id="related_links"  >
        @if(!isset($filter_subject_id))
            <a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.tasks.my_assigned_tasks.package') current_page @endif" href="{{ route('ugc.desktop.hamahang.tasks.my_assigned_tasks.package',['username'=>$uname]) }}"><span><i class="fa fa-dropbox" title="{{ trans('tasks.MyAssignedTaskPackages') }}"></i></span></a>
            <a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.tasks.my_assigned_tasks.state') current_page @endif" href="{{ route('ugc.desktop.hamahang.tasks.my_assigned_tasks.state',['username'=>$uname]) }}"><span><i class="fa fa-bar-chart" title="{{ trans('tasks.MyAssignedTasksState') }}"></i></span></a>
            <a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.tasks.my_assigned_tasks.priority') current_page @endif" href="{{ route('ugc.desktop.hamahang.tasks.my_assigned_tasks.priority',['username'=>$uname]) }}"><span><i class="fa fa-retweet" title="{{ trans('tasks.MyAssignedTasksPriority') }}"></i></span></a>
            <a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.tasks.my_assigned_tasks.list') current_page @endif" href="{{ route('ugc.desktop.hamahang.tasks.my_assigned_tasks.list',['username'=>$uname]) }}"><span><i class="fa fa-list-alt" title="{{ trans('tasks.MyAssignedTasksList') }}"></i></span></a>
{{--            <a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.tasks.my_assigned_tasks.show_drafts') current_page @endif" href="{{ route('ugc.desktop.hamahang.tasks.my_assigned_tasks.show_drafts',['username'=>$uname]) }}"><span><i class="fa fa-align-right" title="{{ trans('tasks.MyAssignedTaskDrafts') }}"></i></span></a>--}}
        @else
            <a class="@if( Route::currentRouteName() == 'pgs.desktop.hamahang.tasks.my_assigned_tasks.package') current_page @endif" href="{{ route('pgs.desktop.hamahang.tasks.my_assigned_tasks.package',['username'=>$uname]) }}"><span><i class="fa fa-dropbox" title="{{ trans('tasks.MyAssignedTaskPackages') }}"></i></span></a>
            <a class="@if( Route::currentRouteName() == 'pgs.desktop.hamahang.tasks.my_assigned_tasks.state') current_page @endif" href="{{ route('pgs.desktop.hamahang.tasks.my_assigned_tasks.state',['username'=>$uname]) }}"><span><i class="fa fa-bar-chart" title="{{ trans('tasks.MyAssignedTasksState') }}"></i></span></a>
            <a class="@if( Route::currentRouteName() == 'pgs.desktop.hamahang.tasks.my_assigned_tasks.priority') current_page @endif" href="{{ route('pgs.desktop.hamahang.tasks.my_assigned_tasks.priority',['username'=>$uname]) }}"><span><i class="fa fa-retweet" title="{{ trans('tasks.MyAssignedTasksPriority') }}"></i></span></a>
            <a class="@if( Route::currentRouteName() == 'pgs.desktop.hamahang.tasks.my_assigned_tasks.list') current_page @endif" href="{{ route('pgs.desktop.hamahang.tasks.my_assigned_tasks.list',['username'=>$uname]) }}"><span><i class="fa fa-list-alt" title="{{ trans('tasks.MyAssignedTasksList') }}"></i></span></a>
{{--            <a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.tasks.my_assigned_tasks.show_drafts') current_page @endif" href="{{ route('ugc.desktop.hamahang.tasks.my_assigned_tasks.show_drafts',['username'=>$uname]) }}"><span><i class="fa fa-align-right" title="{{ trans('tasks.MyAssignedTaskDrafts') }}"></i></span></a>--}}
        @endif
    </div>

