<ul class="nav navbar-nav navbar-right">
    @foreach($menus as $menu)
    <li><a href="{{$menu->href}}">{{$menu->title }}</a></li>
    @endforeach
</ul>