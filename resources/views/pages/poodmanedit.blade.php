@extends('layouts.master')
@section('content')
<script type="text/javascript">
    $(document).ready(function() {
    $("#Selected_subject").tokenInput("{{App::make('url')->to('/')}}/Pagesearch", {
    preventDuplicates: true,
            hintText: "عبارتی را وارد کنید",
            searchingText: "در حال جستجو",
            onResult: function(item) {
            if ($.isEmptyObject(item)) {
            return [{id: '0', name: $("tester").text()}]
            } else {
            return item
            }


            },
    });
    });</script>

<script>
            function FileName(obj)
            {
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
            }
    function FileNameNS(obj)
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
    }
</script>
<div class="panel-body text-decoration">
    @if(session('Login') && session('Login')=='TRUE')


    <link rel="stylesheet" type="text/css" media="all" href="{{App::make('url')->to('/')}}/theme/jsclender/skins/aqua/theme.css" title="Aqua" />

    <script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/jsclender/jalali.js"></script>

    <!-- import the calendar script -->
    <script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/jsclender/calendar.js"></script>
    <!-- import the calendar script -->
    <script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/jsclender/calendar-setup.js"></script>
    <!-- import the language module -->
    <script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/jsclender/lang/calendar-fa.js"></script>
    <script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/pageedit.js"></script>

    <div class='text-content'>
        {{ Form::open(array('url' => 'EditPageSend')) }}
        <input type="hidden" value="{{$pid}}" name="pid">

        <div class="txtsearch">
            <input type="text" placeholder="جستجو ..." id="list-search" />
        </div>
        <div accordion="" class="panel-group accordion" id="accordion">
            <div id="Fehresrt" class="v"></div>
        </div>

        @include('scripts.poodmanScript')

        <script src="{{App::make('url')->to('/')}}/theme/Scripts/jstree.contextmenu.js" type="text/javascript"></script>
        <script>
            $(function () {
            $("#Fehresrt").jstree({
            "plugins" : ["checkbox",
                    "contextmenu", "search"
            ]
            });
                    var to = false;
                    $('#list-search').keyup(function () {
            if (to) { clearTimeout(to); }
            to = setTimeout(function () {
            var v = $('#list-search').val();
                    $('#Fehresrt').jstree(true).search(v);
            }, 250);
            });
            });
            $('#Fehresrt').jstree({
    "plugins" : ["checkbox",
            "contextmenu", "dnd", "search",
            "state", "types", "wholerow"
    ],
            'core': {
            'data': [
            {{$Tree}}
            ],
                    'rtl': true,
                    "themes": {
                    "icons": false
                    }
            }
    });
            $("#Fehresrt").bind("select_node.jstree", function (e, data) {

    //            $('#jstree').jstree('save_state');
    //            history.pushState("", document.title, window.location.pathname + window.location.search);
    })

            .on("activate_node.jstree", function (e, data) {
            window.location.href = data.node.a_attr.href;
                    history.pushState("", document.title, window.location.pathname + window.location.search);
            });</script>

        <div id="Addpanel" style="background-color: #EFEFEF;width: 90%;
             text-align: right;
             margin: 20px;"><span id="nodeprename">اضافه کردن به  :ریشه </span>
            <span id="nodename" style="font-weight:bold;"> </span>
            <table class="table">
                <tr>
                    <td style="width: 120px;" >
                        عنوان :
                    </td>
                    <td  >
                        <input class="form-control" style="float: right;" type="text" id="Title_Text">
                    </td>
                </tr> <tr>
                    <td  style="width: 120px;vertical-align: top;text-align: right" >
                        توضیح:

                    </td>
                    <td align="right">
                        <img id="tozihclick" style="width: 20px;float:right;" src="{{App::make('url')->to('/')}}/theme/Content/images/left.png">

                        <span style="display:none;"id="tozihshow">
                            <br>
                            <textarea id="Matn_Text"  style="width:100%" class="specific_textareas form-control" ></textarea>
                        </span>
                    </td>
                </tr>
                <tr style="display: none;">
                    <td style="width: 120px;" >
                        موضوع نمایش
                    </td>
                    <td >
                        <input type="radio" name="sel" id="sel_saf" value="1" checked >صفحه
                        <input disabled type="radio" name="sel" id="sel_rep" value="1" >گزارش
                    </td>

                </tr>
                <tr id="Sel_Page" >
                    <td style="width: 120px;" >
                        صفحه
                    </td>


                    <td >
                        <div style="display: inline-block;float: right;">
                            <input type="hidden" id="Retval">
                            <input type="text"  class="Auto-com token-input-list" id="Selected_subject" name="Commentkeywords" ttype="12"   /> </div>
                        <input id="SafheTR2" type="hidden">
                    </td>

                </tr>

                <tr id="Sel_Report" style="display: none;">

                    <td>گزارش</td>
                    <td>    
                        <div style="display: inline-block;float: right;"> 
                            <input type="text" class="token-input-list" id="Selected_Reports"  style="width:250px !important;" />
                        </div>
                    </td>
                </tr>
                <tr style="display: none;border:none;" id="ReportTR">
                    <td style="text-align: right;" >
                        انتخاب گزارش 

                    </td>
                    <td style="text-align: right;" >
                        <span id="Reports"></span>   

                    </td>
                </tr>
                <tr style="display: none;border:none;" id="SafheTR">
                    <td style="text-align: right;" colspan="2">
                        <table class="table">
                            <tr>
                                <td id="Radio"> 

                                    <input class="SelRad" type="radio" name="sex" value="all" id="all" >کل صفحه </td>

                                <td><input class="SelRad" type="radio" name="sex" id="matnpart" value="matnpart" >قسمتی ازمتن </td>
                                <td> <input class="SelRad" style="margin-right: 10px;" type="radio" name="sex" id="tozih" value="tozih" checked> توضیح درمورد محتوای صفحه</td>
                                <td><input class="SelRad" type="radio" name="sex" value="mosh" id="mosh"> مشخصه ها </td>
                                <td><input class="SelRad" type="radio" name="sex" value="male"  value="alamat" id="alamat">علامت گذاری ها</td>

                            </tr>
                        </table>


                        <span id="tabs"></span>
                        <span id="alamatres"></span>
                        <textarea id="Matn_Part"  style="display: none;width:100%;" class="specific_textareas">قسمت مورد نظر را از متن زیر انتخاب و در اینجا درج نمایید</textarea>



                    </td>

                </tr>


                <tr>
                    <td style="text-align: right;" colspan="2">
                        <input id="PishShomare_select" type="checkbox" name="vehicle" value="1">عناوین شماره گذاری شوند
                        <div id="pishshomareshow" style="display: none;">
                            پیش شماره:
                            <input type="text" id="PishShomare"  style="width:250px !important;"  />
                        </div>

                    </td>
                </tr>

                <tr>
                    <td style="text-align: right;vertical-align: top;" colspan="2">
<!--                                                                            <input type="checkbox" name="sex" value="male"  value="ok" id="showPages">نمایش متن صفحه-->
                        <div id="tabs2"></div>
                        <input type="hidden" id="pageid"   value="{{$pid}}"/>
                        <input type="hidden" id="Addtype"   value="add"/>
                        <input type="hidden" id="ptree_id"   value=""/>
                        <input type="hidden" id="parent_id"   value="0"/>
                <center>
                    <a  id="NewTree" style="-moz-border-bottom-colors: none;
                        -moz-border-left-colors: none;
                        -moz-border-right-colors: none;
                        -moz-border-top-colors: none;
                        -moz-user-select: none;
                        background-color: #337ab7 !important;
                        background-image: none;
                        border-color: #2e6da4 !important;
                        border-image: none;
                        border-radius: 4px;
                        border-style: solid;
                        border-width: 1px;
                        width:100px;
                        color: #fff;
                        cursor: pointer;
                        display: inline-block;

                        font-family: 'Naskh' !important;
                        font-size: 7pt !important;
                        font-weight: 400;
                        height: 30px;
                        line-height: 1.42857;
                        margin: 0 5px 0 2px;
                        padding: 6px 12px;
                        text-align: center;
                        vertical-align: middle;
                        white-space: nowrap; ">تایید</a>
                </center>  
                </td>
                </tr>
            </table>
            <div id='PageContent'  style="margin:10px 20px 20px 20px;">

            </div>
        </div>
        <div class="panel panel-light panel-list padding-remove">
            <div class="panel-body searching-cntnt">

                <table class="table">
                    <tr>
                        <td>
                            توضیح درباره محتوای صفحه
                        </td>
                        <td>
                            <textarea id="description" name="description" rows="3"  class="form-control" ></textarea>

                            <span id="charcount">156</span>
                            باقیمانده از   156 کاراکتر    
                        </td>

                    </tr>

                    <tr>
                        <td>
                            نوع  ویرایش
                        </td>
                        <td>
                            <select dir="rtl" class="form-control text"  id="edit_num" name="edit_num" style="width:  300px;display: inline;">
                                <option value="1">اصلاح نگارشی (ادبی، املایی، فونت، ترازبندی و ...)</option>
                                <option value="2">اصلاح محتوا - اهمیت کم</option><option value="3">اصلاح محتوا - اهمیت زیاد</option>
                                <option value="5">افزودن محتوا - اهمیت زیاد</option>
                                <option value="6">تغییر (اصلاح و افزودن) - اهمیت زیاد</option>
                            </select>
                        </td>

                    </tr>

                    <tr>
                        <td>
                            شرح
                        </td>
                        <td>
                            <input name="edit_com" id="edit_com" class="form-control" value="" />
                        </td>

                    </tr>

                    <tr>
                        <td>
                            نوع ذخیره سازی 
                        </td>
                        <td>
                            <span style=" margin:0px;display: inline;">
                                <label><input  name="workflow" type="radio" class="workflow"  id="RadioGroup2_0" value="0"  />پیش نویس</label>
                                <label><input name="workflow" type="radio" class="workflow" id="RadioGroup2_1" value="1" checked="checked"/>نهایی</label>
                                <label><input name="workflow" type="radio" class="workflow" id="RadioGroup2_3" value="2" />انتشار در تاریخ</label>
                                <div id="datepicker0" style="display: none;display: inline; " >
                                    <input id="date_input_1" type="text" /><img id="date_btn_1" src="{{App::make('url')->to('/')}}/theme/jsclender/cal.png" style="vertical-align: top;" />
                                    <script type="text/javascript">
                                                var Curpid = "{{$pid}}";
                                                Calendar.setup({
                                                inputField: "date_input_1", // id of the input field
                                                        button: "date_btn_1", // trigger for the calendar (button ID)
                                                        ifFormat: "%Y-%m-%d", // format of the input field
                                                        dateType: 'jalali',
                                                        weekNumbers: false
                                                });                                    </script>
                                </div>


                            </span>
                        </td>

                    </tr>
                </table>
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-primary" name="addasubject">تایید</button>
        {{ Form::close() }}
        @else
        شما به این قسمت دسترسیندارید
        @endif
    </div>
    @stop
    @section('Files')
    @stop
    @section('tabs')
    <li ><a href="PageEdit/{{$pid}}/Text">نمای نوشتار</a></li>
    <li><a href="PageEdit/{{$pid}}/Slide">نمای اسلاید</a></li>
    <li><a href="PageEdit/{{$pid}}/Films">نمای فیلم</a></li>
    @stop
    @section('Tree')

    @if(session('Login') && session('Login')=='TRUE')

    <div class="panel panel-light panel-list padding-remove">
        <div class="panel-body searching-cntnt">
            <div class="panel-heading panel-heading-darkblue"> تصویر صفحه </div>
            @if($defimage!='')
            <img src="{{App::make('url')->to('/')}}/{{$defimage}}" style="width: 150px;">
            @endif
            @if($showDefimg)
            نمایش داده می شود
            @else
            نمایش داده نمی شود
            @endif
            {{ Form::open(array('url' => 'DefimagePage','name'=>'defimgpic')) }}
            <input name="pid" type="hidden" value="{{$pid}}">

            <table  class="atable" style="border:none;" width="100%" border="0" cellspacing="0" cellpadding="0" id="files">
                <tr>
                    <td style="text-align:right;direction:rtl;border:none;"><span class="btn btn-default btn-file">
                            انتخاب فایل <input type="file" name="deimagefile" class="form-control" onchange="FileNameNS(this);">
                        </span>
                        <span class="descr" style="display: none;"> عنوان فایل <input class="form-control" name="ftitle[1]" class="text" style="width:150px" value="" /></span>
                        <input type="checkbox" name="showDefpic" value="OK">
                        نمایش
                    </td>
                </tr>
            </table>
            {{ Form::close() }}
            <button  class="btn btn-primary" id="defimage" name="addasubject" style="float:left;margin-left: 10px;">تایید</button>
        </div>
    </div>

    <div class="panel-heading panel-heading-darkblue">تصویر صفحه </div>
    <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
        <div accordion="" class="panel-group accordion" id="accordion">
            <div class="panel-heading panel-heading-darkblue">  </div>

            <img  id="DefimgSrc" src="{{App::make('url')->to('/')}}/{{$defimage}}" style="width: 150px;@if ($defimage =='')display:none; @endif">


            {{ Form::open(array('url' => 'DefimagePage','name'=>'defimgpic')) }}
            <input name="pid" type="hidden" value="{{$pid}}">

            <table  class="atable" style="border:none;" width="100%" border="0" cellspacing="0" cellpadding="0" id="pics">
                <tr>
                    <td style="text-align:right;direction:rtl;border:none;">
                        <span class="btn btn-default btn-file">
                            انتخاب تصویر <input type="file" name="deimagefile" class="form-control" onchange="FileNameNS(this, event);">
                        </span>
                        <span class="descr" style="display: none;"> عنوان فایل <input class="form-control" name="ftitle[1]" class="text" style="width:150px" value="" /></span>
                        <br>

                        <input style="margin-top: 10px;   @if($defimage =='') display:none; @endif" type="checkbox" name="showDefpic" id="showDefpic"
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
            {{ Form::close() }}
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


    <div class="panel-heading panel-heading-darkblue">{{ trans('label.Files')  }} </div>
    <div class="panel-body searching-cntnt" style="margin-bottom: 10px">

        <div accordion="" class="panel-group accordion" >
            @if (is_array($Files) && count($Files)>0)
            @foreach($Files as $item)
            <li>  <input type="checkbox" name="delfile[{{ $item['id'] }}]" /> حذف  <a href="{{ $item['id'] }}"><span>{{ $item['title']}}</span>:{{ $item['size']}}ک.ب</a></li>
            @endforeach
            @endif
            <input type="hidden" value="1" id="fileCount">
            <table  class="atable" style="border:none;" width="100%" border="0" cellspacing="0" cellpadding="0" id="files">
                <tr>
                    <td style="text-align:right;direction:rtl;border:none;">
                        <span  class="btn-file">
                            <div id="FileTile[1]" class="btn btn-default btn-file" style="font-size: 12pt;cursor: pointer" >افزودن فایل</div>  <input style="height: 30px;" type="file" name="file[1]" onchange="FileName(this, '#FileTile[1]');">
                        </span>
                        <span class="descr" style="display: none;"><div class="DelFile icon-hazv" onclick="RemoveFile(this);" style="color: red;cursor: pointer !important;display: inline-block; height: 15px;width: 15px;"></div> <input name="ftitle[1]" class="form-control" style="display: inline;max-width: 200px;" value="" /></span>
                    </td>
                </tr>
            </table>
            <div style="display: none;">
                <img id="add" src="{{App::make('url')->to('/')}}/theme/Content/icons/add.png" style="cursor:pointer" />&nbsp;<img src="{{App::make('url')->to('/')}}/theme/Content/icons/remove.png" id="remove" style="cursor:pointer" />
            </div>
            @else
            شما به این قسمت دسترسی ندارید.
            @endif
        </div>  




    </div>
    @stop
