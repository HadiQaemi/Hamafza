@section('tabs')
    @if (isset($tabs) && is_array($tabs))
        @foreach($tabs as $item)
            @if(is_array($item))
                @if (isset($current_tab) && trim($item['link']) === trim($current_tab))
                    <li class="active{{$current_tab=='desktop' ? '' : '-white'}}"><a href="{{App::make('url')->to('/')}}/{{ $item['href'] }}">{{ $item['title'] }}</a></li>
                @else
                    <li><a href="{{App::make('url')->to('/')}}/{{ $item['href'] }}">{{ $item['title']}}</a></li>
                @endif
            @else
                @if (isset($current_tab) && trim($item->link) === trim($current_tab))
                    <li class="active"><a href="{{App::make('url')->to('/')}}/{{ $item->href }}">{{ $item->title }}</a></li>
                @else
                    <li><a href="{{App::make('url')->to('/')}}/{{ $item->href }}">{{ $item->title}}</a></li>
                @endif
            @endif
        @endforeach
    @endif
@stop