@extends('modals.modalmaster')
@section('content')
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
        <td><a target="_blank" href="{{ $h->Uname }}">{{ $h->Name}} {{ $h->Family}}</a></td>
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
        <td>{{ $h->Name}} {{ $h->Family}}</td>
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
    @stop