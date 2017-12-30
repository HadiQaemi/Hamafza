@extends('layouts.master')
@section('specific_plugin_scripts')
    {!! $HFM_media['UploadForm'] !!}
    {!! $HFM_media['JavaScripts'] !!}
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
        function FileNameNS(obj, event) {
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
        function ShowModeChange(e) {
            var sel = '0';
            var pid = '{{$pid}}';
            var view = e.id;
            token = $("#_Alltoken").val();
            if (document.getElementById(e.id).checked)
                sel = '1';
            $.ajax({
                type: "POST",
                url: '{{ route('hamafza.change_page_view') }}',
                dataType: 'html',
                data: ({sel: sel, pid: pid, view: view, _token: token}),
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
    @if(auth()->check())
        @include('editor.full')
    @endif
@stop
@section('content')
    <textarea id="content_body" name="content_body" class="mceEditor" style="width:100%">
      {!! $content !!}
</textarea>
    <div class="panel-body text-decoration"></div>
@stop
@section('content2')
    <div class="panel-heading panel-heading-darkblue"><label>بهینه‌سازی</label></div>
    <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <input type="hidden" value="{{$pid}}" name="pid">
        @if(!empty($Alert) && $Alert!='')
            <div style="margin:15px;" class="gkCode10"> {{$Alert}}</div>
        @endif
        @if( session('NewAlert')!='')
            <div style="margin:15px;" class="gkCode10"> {{session('NewAlert')}}</div>
            <?php Session::put('NewAlert', ''); ?>
        @endif
        <label for="description">توضیح درباره محتوای صفحه</label>
        <br>
        <textarea id="description" name="description" rows="3" class="form-control" oninput="count_text()">{{$Description}}</textarea>
        <span id="charcount">156</span>
        <span> باقیمانده از 156 کاراکتر</span>
    </div>
@stop
@section('Files')@stop
@section('tabs')
    <li class="active"><a c href="{{route('page.edit',['id'=>$pid,'Type'=>'text'])}}">نمای نوشتار</a></li>
    <li><a href="{{route('page.edit',['id'=>$pid,'Type'=>'slide'])}}">نمای اسلاید</a></li>
    <li><a href="{{route('page.edit',['id'=>$pid,'Type'=>'films'])}}">نمای فیلم</a></li>
@stop
@section('Tree')
    @if(auth()->check())
        <div class="panel-heading panel-heading-darkblue">انتشار</div>
        <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
            <div accordion="" class="panel-group accordion" id="accordion">
                <div style="float: right;">
                    <script src="{{App::make('url')->to('/')}}/theme/jsclender/jalali.js"></script>
                    <script src="{{App::make('url')->to('/')}}/theme/jsclender/calendar.js"></script>
                    <script src="{{App::make('url')->to('/')}}/theme/jsclender/calendar-setup.js"></script>
                    <script src="{{App::make('url')->to('/')}}/theme/jsclender/lang/calendar-fa.js"></script>
                    <link rel="stylesheet" type="text/css" media="all" href="{{App::make('url')->to('/')}}/theme/jsclender/skins/aqua/theme.css" title="Aqua"/>
                    <table class="table">
                        <tr>
                            <td style="border:none;">تاریخ</td>
                            <td style="border:none;">
                                <div id="datepicker0" style="display: none;display: inline; ">
                                    <input id="date_input_1" type="text" class="form-control" style="display: none;display: inline; "/>
                                    <script type="text/javascript">
                                        var Curpid = "{{$pid}}";
                                        Calendar.setup({
                                            inputField: 'date_input_1',
                                            button: 'date_input_1',
                                            ifFormat: '%Y/%m/%d',
                                            dateType: 'jalali'
                                        });
                                    </script>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="border:none;">شماره</td>
                            <td style="border:none;">
                                <input id="publishno" type="text" name="publishno" class="form-control"/>
                            </td>
                        </tr>
                        <tr>
                            <td style="border:none;"> نوع ویرایش</td>
                            <td style="border:none;">
                                <select dir="rtl" class="form-control text" id="edit_num" name="edit_num" style="display: inline;">
                                    <option value="1">اصلاح نگارشی (ادبی، املایی، فونت، ترازبندی و ...)</option>
                                    <option value="2">اصلاح محتوا - اهمیت کم</option>
                                    <option value="3">اصلاح محتوا - اهمیت زیاد</option>
                                    <option value="5">افزودن محتوا - اهمیت زیاد</option>
                                    <option value="6">تغییر (اصلاح و افزودن) - اهمیت زیاد</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td style="border:none;">توضیح</td>
                            <td style="border:none;">
                                <textarea name="edit_com" id="edit_com" class="form-control" value=""></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border:none;">
                                <input type="checkbox" pid="{{$pid}}" value="OK" id="ShowText" onclick="ShowModeChange(this);" class="ShowModeChange" @if($viewtext=='1') checked="" @endif>نمای نوشتار
                                <input type="checkbox" pid="{{$pid}}" value="OK" id="ShowSlide" onclick="ShowModeChange(this);" class="ShowModeChange" @if($viewslide=='1') checked="" @endif>نمای اسلاید
                                <input type="checkbox" pid="{{$pid}}" value="OK" id="ShowFilm" onclick="ShowModeChange(this);" class="ShowModeChange" @if($viewfilm=='1') checked="" @endif>نمای فیلم
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border:none;">
                                <?php $url = \App\HamafzaPublicClasses\FunctionsClass::CratePagelink($pid); ?>

                                <input type="radio" name="publishtype" disabled="">پیش‌نویس
                                <input type="radio" name="publishtype" checked="true">نهایی

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border:none;">
                                <span class="btn btn-primary FloatLeft" id="saveandpublish" url="{{$url}}">ذخیره و نمایش</span>
                                <span class="btn btn-primary FloatLeft" id="savepagedit" style="margin-left: 5px;">ذخیره</span>
                                <span class="btn btn-default " id="backtopage" style="margin-left: 5px;" url="{{$url}}">نمایش</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel-heading panel-heading-darkblue">نماد صفحه</div>
        <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
            <div accordion="" class="panel-group accordion" id="accordion">
                <div class="panel-heading panel-heading-darkblue"></div>

                {!! SIUFormGenerator($item_id, $image, 'savePageImage', 'renamePageImage', 'removePageImage') !!}

                {{--@if($defimage!='')--}}
                {{--<img id="DefimgSrc" src="{{App::make('url')->to('/')}}/{{$defimage}}" style="width: 150px;@if ($defimage =='')display:none; @endif">--}}
                {{--@else--}}
                {{--<img id="DefimgSrc" src="" style="max-width: 150px;max-height: 150px;display:none;">--}}
                {{--@endif--}}
                {{--<form action="{{App::make('url')->to('/')}}/DefimagePage" method="post" enctype="multipart/form-data" name="defimgpic">--}}
                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}"/>--}}
                {{--<input name="pid" type="hidden" value="{{$pid}}">--}}
                {{--<table class="atable" style="border:none;" width="100%" border="0" cellspacing="0" cellpadding="0" id="pics">--}}
                {{--<tr>--}}
                {{--<td style="text-align:right;direction:rtl;border:none;">--}}
                {{--<span class="btn btn-default btn-file">--}}
                {{--<span>  انتخاب تصویر </span>--}}
                {{--<input type="file" name="deimagefile" class="form-control" onchange="FileNameNS(this, event);">--}}
                {{--</span>--}}
                {{--<span class="descr" style="display: none;"> عنوان فایل <input class="form-control" name="ftitle[1]" class="text" style="width:150px" value=""/></span>--}}
                {{--<br>--}}
                {{--@if($defimage!='')--}}
                {{--<input style="margin-top: 10px;   @if($defimage =='') display:none; @endif" type="checkbox" name="showDefpic" id="showDefpic"--}}
                {{--@if($showDefimg)--}}
                {{--checked--}}
                {{--value="1"--}}
                {{--@else--}}
                {{--value="0"--}}
                {{--@endif--}}
                {{-->--}}
                {{--<span>نمایش</span>--}}
                {{--@endif--}}
                {{--</td>--}}
                {{--</tr>--}}
                {{--</table>--}}
                {{--</form>--}}
                {{--<button class="btn btn-primary" id="defimage" name="addasubject" style="float:left;margin-left: 10px;display: none;">تایید</button>--}}
            </div>
        </div>
        <div class="panel-heading panel-heading-darkblue">{{ trans('label.Files')  }} </div>
        {{--        {{ dd(session()->get('page_file')) }}--}}
        {{--<span class="help-block">{{trans('app.valid_mime_type')}}: zip, doc, docx, pdf, mp3, amr</span>--}}
            {{--<span class="help-block">{{trans('app.valid_max_file_size')}}: 2mb</span>--}}
        <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
            <div class="form-group">
                <div class="clearfix"></div>
                <div id="all_files_div"></div>
                {{--<div class="hr hr-double dotted"></div>--}}
                {{--<label class="col-lg-3 control-label">{{trans('app.add_file')}}</label>--}}
                <div class="col-lg-9">
                    <div class="row-fluid">
                        <div class="filemanager-buttons-client">
                            <div class="btn btn-default pull-left HFM_ModalOpenBtn" data-section="{{ enCode('page_file') }}" data-multi_file="Multi" style="margin-right: 5px;">
                                {{--<i class="glyphicon glyphicon-plus-sign" style="color: skyblue"></i>--}}
                                <span>{{trans('app.add_file')}}</span>
                            </div>
                            {{--<div data-section="{{ enCode(session('page_file')) }}"  class="HFM_RemoveAllFileFSS_SubmitBtn btn btn-default pull-left" style=" color:#555;">--}}
                            {{--<i class="glyphicon glyphicon-remove-sign" style=" color:#FF6600;"></i>--}}
                            {{--<span>{{trans('filemanager.remove_all_attachs')}}</span>--}}
                            {{--</div>--}}
                        </div>
                        <div class="pull-right filemanager-title-client">
                            {{--<h4 class="filemanager-title">{{trans('filemanager.attachs')}}</h4>--}}
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                {!! $HFM_media['ShowResultArea']['page_file'] !!}
                <button name="addasubject" class="btn btn-primary FloatLeft add_page_files" type="button">بارگذاری</button>
            </div>
            {{--<form action="{{App::make('url')->to('/')}}/AttachFileinPage" method="post" enctype="multipart/form-data" name="AttachFileinPage">--}}
            {{--<input type="hidden" name="_token" value="{{ csrf_token() }}"/>--}}
            {{--<input type="hidden" name="Fpid" value="{{$pid}}">--}}
            {{--<div accordion="" class="panel-group accordion">--}}
            {{--@if (is_array($Files) && count($Files)>0)--}}
            {{--@foreach($Files as $item)--}}
            {{--<li><input type="checkbox" name="delfile[{{ $item['id'] }}]"/> حذف <a href="{{ $item['id'] }}"><span>{{ $item['title']}}</span>:{{ $item['size']}}ک.ب</a></li>--}}
            {{--@endforeach--}}
            {{--@endif--}}
            {{--<input type="hidden" value="1" id="fileCount">--}}
            {{--<table class="atable" style="border:none;" width="100%" border="0" cellspacing="0" cellpadding="0" id="files">--}}
            {{--<tr>--}}
            {{--<td style="text-align:right;direction:rtl;border:none;overflow: hidden;">--}}
            {{--<span class="btn btn-default btn-file">--}}
            {{--<span id="FileTile[1]"> انتخاب فایل</span>--}}
            {{--<input type="file" name="file[1]" class="form-control" onchange="FileName(this, '#FileTile[1]');">--}}
            {{--</span>--}}
            {{--<span class="descr" style="display: none;">--}}
            {{--<div class="DelFile icon-hazv" onclick="RemoveFile(this);" style="color: red;cursor: pointer !important;display: inline-block; height: 15px;width: 15px;"></div>--}}
            {{--<input name="ftitle[1]" class="form-control" style="display: inline;max-width: 200px;" value=""/>--}}
            {{--</span>--}}
            {{--</td>--}}
            {{--</tr>--}}
            {{--</table>--}}
            {{--<div style="display: none;">--}}
            {{--<img id="add" src="{{App::make('url')->to('/')}}/theme/Content/icons/add.png" style="cursor:pointer"/>&nbsp;--}}
            {{--<img src="{{App::make('url')->to('/')}}/theme/Content/icons/remove.png" id="remove" style="cursor:pointer"/>--}}
            {{--</div>--}}
            {{--<button name="addasubject" class="btn btn-primary FloatLeft" type="submit">تایید</button>--}}
            {{--</div>--}}
            {{--</form>--}}
        </div>
    @else
        شما به این قسمت دسترسی ندارید.
    @endif
    <script type="text/javascript">

            $(document).ready(function () {
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.pages.get_page_files')}}',
                data: {
                    pid: {{ $pid }}
                },
                dataType: "json",
                success: function (result) {
                    if (result.success == true) {
                        console.log(result.page_files);
                        var files_html = '';
                        for (var x in result.page_files) {
                            files_html += '' +
                                '<div class="row" style="margin-bottom: 3px;">' +
                                '   <div style="background-color: #00ACC1;" class="btn btn-xs bg-primary">' +
                                '       <span style="padding: 1px; margin-left: 5px; margin-right: -5px; background-color: #00BCD4; border-radius: 5px;" >' +
                                '           <i title="{{ trans('app.delete') }}" data-file_name="' + result.page_files[x].originalName + '" data-file_id="' + result.page_files[x].id + '" style="padding-left: 5px;" class="fa fa-remove text-danger-400 remove_page_file"></i></a>|' +
                                '           <a title="{{ trans('site.download') }}" href="{{ route('FileManager.DownloadFile',['ID',''])}}/' + result.page_files[x].encoded_file_id + '"><i style="padding-right: 5px;" class="fa fa-download"></i></a>' +
                                '       </span>' +
                                '       <span>' + result.page_files[x].originalName + '.' + result.page_files[x].extension  + '</span>' +
                                '   </div>' +
                                '</div>';
                        }
                        $('#all_files_div').html(files_html);
                    }
                    else {
                        messageModal('error', 'خطا در واکشی اطلاعات', result.error);
                    }
                }
            });

        });

        $(document).on("click", "#saveandpublish", function () {
            content = tinymce.get('content_body').getContent();
            description = $("#description").val();
            date_input = $("#date_input_1").val();
            edit_num = $("#edit_num").val();
            edit_com = $("#edit_com").val();
            url = $(this).attr('url');
            uid = curUid;
            pid = Curpid;
            token = $("_Alltoken").val();
            desc = $("#description").val();
            $.ajax({
                type: "POST",
                url: '{{ route('hamafza.edit_page_send') }}',
                dataType: 'html',
                data: ({uid: uid, pid: pid, content_body: content, date_input: date_input, edit_num: edit_num, edit_com: edit_com, description: description, token: token}),
                success: function (theResponse) {
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                    location.replace(url);
                }
            });
        });
        $(document).on("click", "#savepagedit", function () {
            content = tinymce.get('content_body').getContent();
            description = $("#description").val();
            date_input = $("#date_input_1").val();
            edit_num = $("#edit_num").val();
            edit_com = $("#edit_com").val();
            uid = curUid;
            pid = Curpid;
            token = $("_Alltoken").val();
            desc = $("#description").val();
            $.ajax({
                type: "POST",
                url: '{{ route('hamafza.edit_page_send') }}',
                dataType: 'html',
                data: ({uid: uid, pid: pid, content_body: content, date_input: date_input, edit_num: edit_num, edit_com: edit_com, description: description, token: token}),
                success: function (theResponse) {
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                    window.location.reload();
                }
            });
        });
        $(document).on("click", "#backtopage", function () {
            url = $(this).attr('url');
            location.replace(url);
        })
        function count_text() {
            if ($("#description").val().length > 155) {
                $('#description').keypress(function (e) {
                    return false;
                });
                $("#charcount").text((156 - $("#description").val().length));
            }
            else {
                $("#charcount").text((156 - $("#description").val().length));
                $('#description').unbind('keypress');

            }
        }

        $(document).on("click", ".add_page_files", function () {
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.pages.save_page_files')}}',
                data: {
                    pid: {{ $pid }}
                },
                dataType: "json",
                success: function (result) {
                    if (result.success == true) {
                        messageModal('success', 'افزودن فایل‌ها', result.message);
                        location.reload();
                    }
                    else {
                        messageModal('error', 'خطا در ثبت فایل‌ها', result.error);
                    }
                }
            });
        });

        $(document).on("click", ".remove_page_file", function () {
            var $this = $(this);
            var file_id = $this.data('file_id');
            confirmModal({
                title: 'حذف فایل',
                message: '{{trans('access.are_you_sure')}}',
                onConfirm: function () {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('hamahang.pages.remove_page_files')}}',
                        data: {
                            file_id: file_id
                        },
                        dataType: "json",
                        success: function (result) {
                            if (result.success == true) {
                                $this.parent().parent().remove();
                                messageModal('success', 'حذف فایل', result.message);

                            }
                            else {
                                messageModal('error', 'خطا در حذف فایل', result.error);
                            }
                        }
                    });
                },
                afterConfirm: 'close'
            });
        });

    </script>
@stop
