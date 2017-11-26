@extends('pages.Desktop.DesktopFunctions')
@section('content')
    <div class='text-content'>
        <form class="form-horizontal" action="{{ route('hamafza.subst_save') }}" method="post" enctype="multipart/form-data" name="form">
            <br>
            <div style="padding: 10px;">
                <div class='text-content'>
                    <input type="hidden" name="substid" value="{{$id}}">
                    <table class="table">
                        <tr>
                            <td>
                                عبارت
                                <input type="text" name="first" class="form-control" value="{{$fist}}">
                            </td>
                            <td>
                                جایگزین
                                <input type="text" name="second" value="{{$second}}" class="form-control">
                            </td>
                            <td>
                                <input style="margin-top: 15px;" type="submit" class="btn btn-primary FloatLeft" value="تایید" name="circle_add" id="submit">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
        <hr>
        <form method="get" action="{{url(Session::get('Uname').'/desktop/subst?sr=')}}">
            <div style="padding: 5px;">
                <input type="text" value="{{$sr}}" id="list-search" name="sr" placeholder="غربال بر اساس کلمه یا جایگزین" style="display: inline-block ;max-width: 300px;">
                <button type="submit" class="btn" name="search" value="ok">بیاب</button>
            </div>
        </form>
        {!!$content!!}
    </div>
@stop