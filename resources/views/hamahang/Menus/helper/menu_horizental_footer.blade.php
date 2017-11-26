<div class="row nav_center_footer">
    <ul>
        @if(($menus))
            @foreach($menus as $key => $menu)
                @if($key > 0)
                    <li><span class="icon-2-3"></span></li>
                @endif
                <li><a href="{{$menu->href}}">{{$menu->title }}</a></li>
            @endforeach
        @else
            <span>نوع فهرست یافت نشد</span>
        @endif
    </ul>
</div>