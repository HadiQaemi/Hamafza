@extends('layouts.master')
@section('content')
@if(Session::has('Login') && Session::get('Login')=='TRUE')
@if(is_array($Slides ) && count($Slides)>0)
<table class="table col-md-9 col-sm-9 col-sx-9" ><tr><td style="width: 20px;">ردیف</td><td>عنوان</td><td>مدت زمان</td><td>حذف </td></tr>
    <?php $n = 1; ?>
    @foreach($Slides as $Slide)
    <tr id="FilmRow_{{$Slide['id']}}">
        <td>{{$n}}</td>
                <td>{{$Slide['title']}}</td>
        <td>{{$Slide['length']}}</td>
        <td>
            <div class="fonts icon-hazv DelicnS" page="PageFilm" action="delete" id="{{$Slide['id']}}" style="border:0px; cursor:pointer;height:10px;"></div>
        </td>
    </tr>
    <?php $n++; ?>
    @endforeach
</table>

<div class="row"></div>
@endif

<form action="{{ route('hamafza.add_page_film') }}" method="post" enctype="multipart/form-data" name="defismgpic" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
       
<div id ="FilmsDiv">
    <input type="hidden" name="pid" value="{{$pid}}">

    <input type="hidden" id="Counter" value="1">
    <div style="direction: rtl; font-weight: bold;">
        اضافه کردن فیلم جدید
    </div>
    <img id="add2" src="{{App::make('url')->to('/')}}/theme/Content/icons/add.png" style="cursor:pointer" />
    <img src="{{App::make('url')->to('/')}}/theme/Content/icons/remove.png" id="remove2" style="cursor:pointer" />

    <table class="table" style="direction: rtl;">
        <tr>
            <td>
                نوع عنوان
                <select  class="form-control" name="PreTitle[1]" id="SelectDD_1">  <option value="1">موضوع 1</option>  <option value="2">موضوع 2</option>  <option value="3">موضوع 3</option></select>
            </td> 
            <td>
                عنوان
                <input   id="Titles_1" class="form-control" name="Title[1]" type="text">
            </td> 
            <td>
                مدت زمان
                <input name="Time[1]" class="form-control" type="text">
            </td> 
        </tr>
        <tr>
            <td>
                عکس پیش فرض

                <span class="btn btn-default btn-file">

                    انتخاب فایل <input type="file" name="Picfile[1]" onchange="FileName(this);">
                    </td> 
                    <td>
                        فیلم
                        <span class="btn btn-default btn-file">
                            انتخاب فایل <input type="file" name="Filmfile[1]" onchange="FileName(this);">
                        </span>
                    </td> 
                    <td>
                        توضیحات
                        <textarea class="form-control" id="Descr[1]" name="Desce[1]" rows="3" ></textarea>

                    </td> 
        </tr>

    </table>

</div>
<button style="float:left;margin-left: 10px;" name="addasubject" id="defimage" class="btn btn-primary">تایید</button>
</form>
@endif
<script type="text/javascript">
function ShowModeChange(e)
    {
        var sel='0';
        var pid={{$pid}};
        var view=e.id;
        if(document.getElementById(e.id).checked)
             sel='1';
         
           $.ajax({
                type: "POST",
                url: '{{ route('hamafza.change_page_view') }}',
                dataType: 'html',
                data: ({sel: sel, pid: pid,view:view}),
                success: function(theResponse) {
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                }
            });
    }
    $(function() {
        var j = parseInt($('#Counter').val());

        $('img#add2').click(function() {
            j++;

            $('<table class="table"><tr>' + '<td>نوع عنوان <select class="form-control" name="PreTitle[' + j + ']" id="SelectDD[' + j + ']">  <option value="1">موضوع 1</option>  <option value="2">موضوع 2</option>  <option value="3">موضوع 3</option></select></td><td>عنوان<input class="form-control" name="Title[' + j + ']" type="text"></td> <td>مدت زمان<input class="form-control" name="Time[' + j + ']" type="text"></td> </tr><tr><td>عکس پیش فرض<span class="btn btn-default btn-file"> انتخاب فایل <input type="file" name="Picfile[' + j + ']" onchange="FileName(this);"></td><td>فیلم<span class="btn btn-default btn-file">انتخاب فایل <input type="file" name="Filmfile[' + j + ']" onchange="FileName(this);"></span></td> <td> توضیحات<textarea class="form-control" id="Descr[1]" name="Desce[' + j + ']" rows="3" ></textarea></td> </tr></table>').appendTo('#FilmsDiv');
            $('#Counter').val(j);


        });



        $('img#remove2').click(function() {
            if (j > 1) {
                $('div#FilmsDiv table:last').remove();
                j--;
                $('#Counter').val(j);
            }
        });



    });
</script>

@stop
@section('Files')
@stop
@section('tabs')
    <li><a c href="{{route('page.edit',['id'=>$pid,'Type'=>'text'])}}">نمای نوشتار</a></li>
    <li><a href="{{route('page.edit',['id'=>$pid,'Type'=>'slide'])}}">نمای اسلاید</a></li>
    <li class="active"><a href="{{route('page.edit',['id'=>$pid,'Type'=>'films'])}}">نمای فیلم</a></li>
@stop
@section('Tree')


@if(Session::has('Login') && Session::get('Login')=='TRUE')

<div class="panel-heading panel-heading-darkblue">تصویر صفحه </div>
<div class="panel-body searching-cntnt" style="margin-bottom: 10px">
    <div accordion="" class="panel-group accordion" id="accordion">
        <div class="panel-heading panel-heading-darkblue">  </div>
        @if($defimage !='')
        <img src="{{App::make('url')->to('/')}}/{{$defimage}}" style="width: 150px;">
        @endif
<form action="{{ route('hamafza.def_image_page') }}" method="post" enctype="multipart/form-data" name="defimgpic" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input name="pid" type="hidden" value="{{$pid}}">

        <table  class="atable" style="border:none;" width="100%" border="0" cellspacing="0" cellpadding="0" id="pics">
            <tr>
                <td style="text-align:right;direction:rtl;border:none;">
                    <br>
                    <span class="btn btn-default btn-file">
                        انتخاب تصویر <input type="file" name="deimagefile" class="form-control" onchange="FileNameNS(this);">
                    </span>
                    <span class="descr" style="display: none;"> عنوان فایل <input class="form-control" name="ftitle[1]" class="text" style="width:150px" value="" /></span>
                    <br>
                    <input style="margin-top: 10px;" type="checkbox" name="showDefpic" id="showDefpic"
                           @if($showDefimg)
                           checked
                           value="1"
                           @else
                           value="0"
                           @endif
                           >
                           نمایش
                </td>
            </tr>
        </table>
</form>
        <button  class="btn btn-primary" id="defimage" name="addasubject" style="float:left;margin-left: 10px;display: none;">تایید</button>

    </div>  
</div>


  <div class="panel-heading panel-heading-darkblue">نمایش </div>
    <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
        <div accordion="" class="panel-group accordion" id="accordion">
            <div style="float: right;">

                <input type="checkbox" pid="{{$pid}}"  value="OK" id="ShowText" onclick="ShowModeChange(this);" class="ShowModeChange" @if($viewtext=='1') checked="" @endif>نمای نوشتار
                       <input type="checkbox" pid="{{$pid}}" value="OK" id="ShowSlide" onclick="ShowModeChange(this);" class="ShowModeChange" @if($viewslide=='1') checked="" @endif>نمای اسلاید
                       <input type="checkbox" pid="{{$pid}}" value="OK" id="ShowFilm" onclick="ShowModeChange(this);" class="ShowModeChange" @if($viewfilm=='1') checked="" @endif>نمای فیلم
            </div>
        </div>  
    </div>
@endif

@stop
