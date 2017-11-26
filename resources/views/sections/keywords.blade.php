@section('keywords')
    <div class="text-content" style="margin: 10px 20px 0 0; padding: 0 0 20px 10px;">
        @foreach($keywords as $item)
            <span style="background-color: #E8E8E8; padding: 5px; margin-left: 5px; border-radius: 5px;"><i class="fa fa-tag"></i> {!! $item->title !!}</span>
        @endforeach
    </div>
@stop

