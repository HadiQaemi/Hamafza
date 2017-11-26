@section('Files')
    @if (isset($Files) && is_array($Files) && count($Files)>0)
        <div class="spacer">
            <div class="panel panel-light fix-box1">
                <div class="fix-inr1">
                    <div style="padding: 0;" class="panel-heading panel-heading-darkblue"></div>
                    <div class="panel-body text-decoration">
                        <b>{{ trans('label.Files')  }}</b>
                        @foreach($Files as $item)
                            <li><a href="{{ $item['id'] }}">{{ $item['ext']}} -><span>{{ $item['title']}}</span>:{{ $item['size']}}ک.ب</a></li>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop