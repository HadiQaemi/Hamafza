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
            {{--<a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.project.listss') current_page @endif" href="{{ route('ugc.desktop.hamahang.tasks.my_assigned_tasks.package',['username'=>auth()->user()->Uname]) }}"><span><i class="fa fa-dropbox" title="{{ trans('projects.table_view') }}"></i></span></a>--}}
            <a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.project.state') current_page @endif" href="{{ route('ugc.desktop.hamahang.project.state',['username'=>auth()->user()->Uname]) }}"><span class="steps-icon related-icons" data-toggle="tooltip" title="{{ trans('projects.step_view') }}"></span></a>
            <a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.project.priority') current_page @endif" href="{{ route('ugc.desktop.hamahang.project.priority',['username'=>auth()->user()->Uname]) }}"><span class="priority-icon related-icons" data-toggle="tooltip" title="{{ trans('projects.priority_view') }}"></span></a>
            <a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.project.list') current_page @endif" href="{{ route('ugc.desktop.hamahang.project.list',['username'=>auth()->user()->Uname]) }}"><span><i class="table-icon related-icons" data-toggle="tooltip" title="{{ trans('projects.table_view') }}"></i></span></a>
        @else
            {{--<a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.project.listss') current_page @endif" href="{{ route('pgs.desktop.hamahang.tasks.my_assigned_tasks.package',['username'=>auth()->user()->Uname]) }}"><span><i class="fa fa-dropbox" title="{{ trans('projects.MyAssignedTaskPackages') }}"></i></span></a>--}}
            <a class="@if( Route::currentRouteName() == 'pgs.desktop.hamahang.tasks.my_assigned_tasks.state') current_page @endif" href="{{ route('pgs.desktop.hamahang.tasks.my_assigned_tasks.state',['username'=>auth()->user()->Uname]) }}"><span class="steps-icon related-icons" data-toggle="tooltip" title="{{ trans('projects.step_view') }}"></span></a>
            <a class="@if( Route::currentRouteName() == 'pgs.desktop.hamahang.tasks.my_assigned_tasks.priority') current_page @endif" href="{{ route('pgs.desktop.hamahang.tasks.my_assigned_tasks.priority',['username'=>auth()->user()->Uname]) }}"><span class="priority-icon related-icons" data-toggle="tooltip" title="{{ trans('projects.chart_task_projects') }}"></span></a>
            <a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.project.list') current_page @endif" href="{{ route('ugc.desktop.hamahang.project.list',['username'=>auth()->user()->Uname]) }}"><span class="table-icon related-icons" data-toggle="tooltip" title="{{ trans('projects.table_view') }}"></span></a>
        @endif
    </div>