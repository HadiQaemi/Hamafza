@extends('modals.modalmaster')
@section('content')
<script>
    $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute; left: 116px; top: -3px;"><a href="{!! url('/modals/helpview?code=mu3dROMxRZE') !!}" title="راهنمای اینجا" class="jsPanels icon-help HelpIcon" style="float: left; padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');
</script>
<table class="table">
    <tr>
        <th width="10px" align="center">ردیف</th>	
        <th align="center">ویرایشگر</th>
        <th align="center">تاریخ</th>
        <th align="center">ویرایش</th>
        <th align="center">شرح ویرایش</th>
        <th  align="center">عملیات</th>

    </tr>
    <?php $i = 1; ?>



    @foreach($H as $h)
    <tr>
        <td>{{ $i}}</td>
        <td><a target="_blank" href="{{ url($h->Uname) }}">{{ $h->Name}} {{ $h->Family}}</a></td>
        <td>{{ $h->edit_date}}</td>
        @if($h->part=='0')
        <td>کلی</td>
        @else
        <td>جزیی</td>

        @endif
        <td>{{ $h->name}}</td>


        <td><a rel="nofollow" href="{{App::make('url')->to('/')}}/history/{{$pid}}/{{ $h->id}}" target="_blank">مشاهده</a></td>
    </tr>
    <?php $i++ ?>
    @endforeach

      @foreach($H1 as $h)
    <tr>
        <td>{{ $i}}</td>
        <td><a target="_blank" href="{{ url($h->Uname) }}">{{ $h->Name}} {{ $h->Family}}</a></td>
        <td>{{ $h->edit_date}}</td>
        @if($h->part=='0')
        <td>کلی</td>
        @else
        <td>جزیی</td>

        @endif
        <td>{{ $h->name}}</td>


        <td>{{--<a rel="nofollow" href="{{App::make('url')->to('/')}}/history/{{$pid}}/{{ $h->id}}" target="_blank">مشاهده</a>--}}</td>
    </tr>
    <?php $i++ ?>
    @endforeach
    @stop