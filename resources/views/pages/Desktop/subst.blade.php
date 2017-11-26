@extends('pages.Desktop.DesktopFunctions')
@section('content')
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
                    </tr>
                </table>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" class="btn btn-primary FloatLeft" value="تایید" name="circle_add" id="submit">
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop