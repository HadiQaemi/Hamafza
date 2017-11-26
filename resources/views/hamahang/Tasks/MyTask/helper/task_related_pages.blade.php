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
            <a class="@if( Route::currentRouteName() == 'pgs.desktop.hamahang.tasks.my_tasks.package') current_page @endif" href="{{ route('pgs.desktop.hamahang.tasks.my_tasks.package',['username'=>$uname]) }}"><span><i class="fa fa-dropbox" title="{{ trans('tasks.MyTaskPackages') }}"></i></span></a>
            <a class="@if( Route::currentRouteName() == 'pgs.desktop.hamahang.tasks.my_tasks.state') current_page @endif" href="{{ route('pgs.desktop.hamahang.tasks.my_tasks.state',['username'=>$uname]) }}"><span><i class="fa fa-bar-chart" title="{{ trans('tasks.MyTasksState') }}"></i></span></a>
            <a class="@if( Route::currentRouteName() == 'pgs.desktop.hamahang.tasks.my_tasks.priority') current_page @endif" href="{{ route('pgs.desktop.hamahang.tasks.my_tasks.priority',['username'=>$uname]) }}"><span><i class="fa fa-retweet" title="{{ trans('tasks.MyTasksPriority') }}"></i></span></a>
            <a class="@if( Route::currentRouteName() == 'pgs.desktop.hamahang.tasks.my_tasks.list') current_page @endif" href="{{ route('pgs.desktop.hamahang.tasks.my_tasks.list',['username'=>$uname]) }}"><span><i class="fa fa-list-alt" title="{{ trans('tasks.MyTasksList') }}"></i></span></a>
        @else
            <a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.tasks.my_tasks.package') current_page @endif" href="{{ route('ugc.desktop.hamahang.tasks.my_tasks.package',['username'=>$uname]) }}"><span><i class="fa fa-dropbox" title="{{ trans('tasks.MyTaskPackages') }}"></i></span></a>
            <a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.tasks.my_tasks.state') current_page @endif" href="{{ route('ugc.desktop.hamahang.tasks.my_tasks.state',['username'=>$uname]) }}"><span><i class="fa fa-bar-chart" title="{{ trans('tasks.MyTasksState') }}"></i></span></a>
            <a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.tasks.my_tasks.priority') current_page @endif" href="{{ route('ugc.desktop.hamahang.tasks.my_tasks.priority',['username'=>$uname]) }}"><span><i class="fa fa-retweet" title="{{ trans('tasks.MyTasksPriority') }}"></i></span></a>
            <a class="@if( Route::currentRouteName() == 'ugc.desktop.hamahang.tasks.my_tasks.list') current_page @endif" href="{{ route('ugc.desktop.hamahang.tasks.my_tasks.list',['username'=>$uname]) }}"><span><i class="fa fa-list-alt" title="{{ trans('tasks.MyTasksList') }}"></i></span></a>
        @endif
    </div>
