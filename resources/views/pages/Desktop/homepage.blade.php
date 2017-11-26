@extends('pages.Desktop.DesktopFunctions')
@section('content')
<label>اسلایدهای اصلی</label>
<script>
    function FileNameNS(obj, event)
    {
        var fileName = $(obj).val();
        var fragment = fileName;
        var array_fragment = fragment.split(/\\|\//);
        fileName = $(array_fragment).last()[0];
        pos = fileName.lastIndexOf('.');
        fileName = fileName.substring(0, pos);
        var top = $(obj).closest('span');
        top.css("color", "red");
        top.next('span').children('input').val(fileName);
        var output = document.getElementById('DefimgSrc');
        output.src = URL.createObjectURL(event.target.files[0]);
        $("#defimage").trigger("click");
        $("#DefimgSrc").show();

        $("#showDefpic").show();

    }
</script>
<form action="{{ route('hamafza.main_slide_save') }}" method="post" id="form_group" enctype="multipart/form-data">

    <table class="table">
        <tr>
            <td>ردیف</td>
            <td>عنوان</td>
            <td>متن</td>
            <td>تصویر</td>
        </tr>  
        <?php $i = 1; ?>
        @if(is_array($mainSlide) && count($mainSlide))

        @foreach($mainSlide as $item)
        <tr>
            <td>{{$i}}</td>
            <td><input type="text" value="{{$item->title}}" name="title[{{$i}}]" class="form-control"></td>
            <td><textarea name="descr[{{$i}}]" class="form-control">{{$item->descr}}</textarea> </td>
            <td><img name="pic[{{$i}}]" src="{{App::make('url')->to('/')}}/Content/slide/{{$item->pic}}" style="width: 100px; ">
                <input type="hidden" value="{{$item->pic}}" name="pic[{{$i}}]" >
                <span class="btn btn-default btn-file">
                    انتخاب تصویر جدید <input type="file" onchange="FileNameNS(this, event);" class="form-control" name="deimagefile{{$i}}">
                </span>
            </td>
        </tr>  
        <?php $i++; ?>
        @endforeach
        @endif
        @if($i<7)
        @for(;$i<7;$i++)
        <tr>
            <td>{{$i}}</td>
            <td><input type="text" value="" name="title[{{$i}}]" class="form-control"></td>
            <td><textarea name="descr[{{$i}}]" class="form-control"></textarea> </td>

            <td>
                <span class="btn btn-default btn-file">
                    انتخاب تصویر  <input type="file" onchange="FileNameNS(this, event);" class="form-control" name="deimagefile{{$i}}">
                </span></td>
        </tr>  
        @endfor
        @endif
        <tr>
            <td colspan="4">
                <button name="addasubject" class="btn btn-primary FloatLeft" type="submit">تایید</button>
                <input type="hidden" value="main" name="type" >

            </td>
        </tr>
    </table>
    {{ Form::close() }}
    <br>
    <label>اسلایدهای قسمت پایین</label>

    <form action="{{ route('hamafza.main_slide_save') }}" method="post" id="form_group" enctype="multipart/form-data">

        <table class="table">
            <tr style="border:none;">
                <td>ردیف</td>     
                <td>لینک</td>


                <td>عنوان</td>
                <td>متن</td>
                <td>تصویر</td>
            </tr>  
            <?php $i = 1; ?>
            @if(is_array($otherSlide) && count($otherSlide))

            @foreach($otherSlide as $item)
            <tr>
                <td>{{$i}}</td>
                <td><input type="text" value="{{$item->title}}" name="title[{{$i}}]" class="form-control"></td>
                                <td><input type="text" placeholder="http://www.hamafza.ir/1" value="{{$item->url}}" name="url[{{$i}}]" class="form-control"></td>
                <td><textarea name="descr[{{$i}}]" class="form-control">{{$item->descr}}</textarea> </td>
                <td><img name="pic[{{$i}}]" src="{{App::make('url')->to('/')}}/Content/slide/{{$item->pic}}" style="width: 100px; ">
                    <input type="hidden" value="{{$item->pic}}" name="pic[{{$i}}]" >
                    <span class="btn btn-default btn-file">
                        انتخاب تصویر جدید <input type="file" onchange="FileNameNS(this, event);" class="form-control" name="deimagefile{{$i}}">
                    </span>
                </td>
            </tr>  
            <?php $i++; ?>
            @endforeach
            @endif
            @if($i<7)
            @for(;$i<7;$i++)
            <tr>
                <td>{{$i}}</td>
                <td><input type="text" value="" name="title[{{$i}}]" class="form-control"></td>
                <td><input type="text" placeholder="http://www.hamafza.ir/1" value="" name="url[{{$i}}]" class="form-control"></td>
                <td><textarea name="descr[{{$i}}]" class="form-control"></textarea> </td>

                <td>
                    <span class="btn btn-default btn-file">
                        انتخاب تصویر  <input type="file" onchange="FileNameNS(this, event);" class="form-control" name="deimagefile{{$i}}">
                    </span></td>
            </tr>  
            @endfor
            @endif
            <tr>
                <td colspan="4">
                    <button name="addasubject" class="btn btn-primary FloatLeft" type="submit">تایید</button>
                    <input type="hidden" value="other" name="type" >
                </td>
            </tr>
        </table>
        {{ Form::close() }}
        <br><br><br>
        @stop