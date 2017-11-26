@extends('pages.Desktop.DesktopFunctions')
@section('content')
@if(is_array($content) && count($content)>0)
        <form action="{{ route('hamafza.save_departments') }}" method="post" name="form" id="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

<table class="table" >
    <tr>
        <td>ردیف</td>
        <td>عنوان</td>
        <td>شماره صفحه</td>

    </tr>
    <?php $i = 1; ?> 
    @foreach($content as $item)
    <tr>
        <td>{{$i}}</td>
        <td><input type="text" class="form-control" name="name[{{$i}}]" value="{{$item->name}}"></td>
        <td><input type="text" class="form-control" name="pid[{{$i}}]" value="{{$item->pid}}"></td>

    </tr>
    <?php $i++; ?>
    @endforeach
    
    @if($i<=10)
    @for(;$i<11;$i++)
    <tr>
        <td>{{$i}}</td>
        <td><input type="text" class="form-control" name="name[{{$i}}]" value=""></td>
        <td><input type="text" class="form-control" name="pid[{{$i}}]" value=""></td>

    </tr>
    @endfor
    @endif
    
    <tr>
        <td colspan="3">
            <button name="addasubject" class="btn btn-info FloatLeft" type="submit">تایید</button>
        </td>
    </tr>
</table>
        <p></p>
                <p></p>
        <p></p>

</form>
@endif
@stop

