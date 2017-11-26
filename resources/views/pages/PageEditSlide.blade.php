@extends('layouts.master')
@section('content')
    <script>
        function RemoveFile(obj) {
            $(obj).parent().parent().parent().remove();
        }
        function FileName(obj, tar) {
            var fileName = $(obj).val();
            var fragment = fileName;
            var array_fragment = fragment.split(/\\|\//);
            fileName = $(array_fragment).last()[0];
            pos = fileName.lastIndexOf('.');
            fileName = fileName.substring(0, pos);
            var top = $(obj).closest('span');
            top.css("color", "red");
            top.next('span').show();
            top.next('span').children('input').val(fileName);
            $(obj).closest('span').children('div').html('');
            $(obj).closest('span').children('div').removeClass('btn');
            $(obj).closest('span').children('div').removeClass('btn-default');
            $(obj).closest('span').children('div').removeClass('btn-file');
            //       $(obj).closest('span').children('div').addClass('icon-minus');
            $("#add").trigger('click');
        }
        function FileNameNS(obj) {
            var fileName = $(obj).val();
            var fragment = fileName;
            var array_fragment = fragment.split(/\\|\//);
            fileName = $(array_fragment).last()[0];
            pos = fileName.lastIndexOf('.');
            fileName = fileName.substring(0, pos);
            var top = $(obj).closest('span');
            top.css("color", "red");
            top.next('span').children('input').val(fileName);
        }

        function ShowModeChange(e) {
            var sel = '0';
            var pid ={{$pid}};
            var view = e.id;
            if (document.getElementById(e.id).checked)
                sel = '1';
            $.ajax({
                type: "POST",
                url: '{{ route('hamafza.change_page_view') }}',
                dataType: 'html',
                data: ({sel: sel, pid: pid, view: view}),
                success: function (theResponse) {
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                }
            });
        }
    </script>
    <script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/pageedit.js"></script>
    <div class="panel-body text-decoration">
        @if(session('Login') && session('Login')=='TRUE')
            <BR>
            {{--<div style="direction: rtl; font-weight: bold;">--}}
                {{--ویرایش تصاویر :--}}
            {{--</div>--}}
            @if(is_array($Slides ) && count($Slides)>0)
                <table class="table">
                    <tr>
                        <td style="width: 20px;">ردیف</td>
                        <td>پیش نمایش</td>
                        <td>حذف</td>
                    </tr>
                    <?php $n = 1; ?>
                    @foreach($Slides as $Slide)
                        <tr id="SlideRow_{{$Slide['id']}}">
                            <td>{{$n}}</td>
                            <td><img src="{{App::make('url')->to('/')}}/{{$Slide['src']}}" height="100px" width="100px"/></td>
                            <td>
                                <span class="fonts icon-hazv DelicnS" page="PageSlide" action="delete" id="{{$Slide['id']}}" style="border:0px; cursor:pointer"></span>
                            </td>
                        </tr>
                        <?php $n++; ?>
                    @endforeach
                </table>
            @endif
            <br>
            <br>
            <pres class="xdebug-var-dump" dir="ltr" style="padding: 10px;">
                <div style="direction: rtl; font-weight: bold;">
                    اسلاید جدید
                </div>
                <form action="{{ route('hamafza.add_page_slide') }}" method="post" enctype="multipart/form-data" name="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" value="1" id="fileCount">
                    <input type="hidden" value="{{$pid}}" name="pid">
                    <table class="atable" style="border:none;" width="100%" border="0" cellspacing="0" cellpadding="0" id="files">
                        <tr>
                            <td style="text-align:right;direction:rtl;border:none;">
                                <span class="btn-file">
                                    <div id="FileTile[1]" class="btn btn-default btn-file" style="font-size: 12pt;cursor: pointer">انتخاب فایل</div>
                                    <input style="height: 30px;" type="file" name="file[1]" onchange="FileName(this, '#FileTile[1]');">
                                </span>
                                <span class="descr" style="display: none;">
                                    <div class="DelFile icon-hazv" onclick="RemoveFile(this);" style="color: red;cursor: pointer !important;display: inline-block; height: 15px;width: 15px;"></div>
                                    <input name="ftitle[1]" class="form-control" style="display: inline;max-width: 200px;" value=""/>
                                </span>
                            </td>
                        </tr>
                    </table>
                    <div style="display: none;">
                        <img id="add" src="{{App::make('url')->to('/')}}/theme/Content/icons/add.png" style="cursor:pointer"/>&nbsp;<img src="{{App::make('url')->to('/')}}/theme/Content/icons/remove.png" id="remove" style="cursor:pointer"/>
                    </div>
                    <button class="btn btn-primary" id="defimage" name="addasubject" style="float:left;margin-left: 10px;">تایید</button>
                </form>
                <br>
                <br>
            </pres>
            <br>
            <br>
            <br>
        @else
            شما به این قسمت دسترسیندارید
        @endif
    </div>
@stop
@section('tabs')
    <li><a c href="{{route('page.edit',['id'=>$pid,'Type'=>'text'])}}">نمای نوشتار</a></li>
    <li class="active"><a href="{{route('page.edit',['id'=>$pid,'Type'=>'slide'])}}">نمای اسلاید</a></li>
    <li><a href="{{route('page.edit',['id'=>$pid,'Type'=>'films'])}}">نمای فیلم</a></li>
@stop
@section('Tree')
    @if(session('Login') && session('Login')=='TRUE')
        <div class="panel-heading panel-heading-darkblue">تصویر صفحه</div>
        <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
            <div accordion="" class="panel-group accordion" id="accordion">
                <div class="panel-heading panel-heading-darkblue"></div>
                @if($defimage !='')
                    <img src="{{App::make('url')->to('/')}}/{{$defimage}}" style="width: 150px;">
                @endif
                <form action="{{App::make('url')->to('/')}}/DefimagePage" method="post" enctype="multipart/form-data" name="defimgpic">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input name="pid" type="hidden" value="{{$pid}}">

                    <table class="atable" style="border:none;" width="100%" border="0" cellspacing="0" cellpadding="0" id="pics">
                        <tr>
                            <td style="text-align:right;direction:rtl;border:none;">
                                <br>
                                <span class="btn btn-default btn-file">
                        انتخاب تصویر <input type="file" name="deimagefile" class="form-control" onchange="FileNameNS(this);">
                    </span>
                                <span class="descr" style="display: none;"> عنوان فایل <input class="form-control" name="ftitle[1]" class="text" style="width:150px" value=""/></span>
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
                <button class="btn btn-primary" id="defimage" name="addasubject" style="float:left;margin-left: 10px;display: none;">تایید</button>

            </div>
        </div>

        <div class="panel-heading panel-heading-darkblue">نمایش</div>
        <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
            <div accordion="" class="panel-group accordion" id="accordion">
                <div style="float: right;">

                    <input type="checkbox" pid="{{$pid}}" value="OK" id="ShowText" onclick="ShowModeChange(this);" class="ShowModeChange" @if($viewtext=='1') checked="" @endif>نمای نوشتار
                    <input type="checkbox" pid="{{$pid}}" value="OK" id="ShowSlide" onclick="ShowModeChange(this);" class="ShowModeChange" @if($viewslide=='1') checked="" @endif>نمای اسلاید
                    <input type="checkbox" pid="{{$pid}}" value="OK" id="ShowFilm" onclick="ShowModeChange(this);" class="ShowModeChange" @if($viewfilm=='1') checked="" @endif>نمای فیلم
                </div>
            </div>
        </div>

    @endif

@stop
