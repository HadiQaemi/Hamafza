@extends('pages.Desktop.DesktopFunctions')
@section('content')

    <link href="{{App::make('url')->to('/')}}/theme/Content/css/magicsuggest.css" rel="stylesheet">
    <script src="{{App::make('url')->to('/')}}/theme/Scripts/magicsuggest-min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#pageSe").tokenInput("{{App::make('url')->to('/')}}/Pagesearch", {
                preventDuplicates: true,
                hintText: "عبارتی را وارد کنید",
                noResultsText: "نتیجه‌ای یافت نشد، با زدن دکمه اینتر کلیدواژه جدیدی ایجاد می‌شود",
                searchingText: "در حال جستجو",
            });
        });</script>

    <form action="{{ route('hamafza.form_add') }}" method="post" name="form" id="form">
        <table id="Rowd" width="100%" class="table tblBorderLess">

            <tbody>

            <tr>
                <td style=" width: 120px;border: none;">عنوان فرم </td>
                <td style="border: none;">
                    <input  style="display: inline;"  required=""  name="form_name" type="text" class="form-control" id="form_name" dir="rtl" value=""  />
                </td>
            </tr>
            <tr >
                <td  style="border: none;">
                    توضیح
                </td>
                <td  style="border: none;">
                    <textarea name="form_help"  rows="2" id="form_help" class="form-control" dir="rtl"></textarea>
                </td>
            </tr>

            <tr>
                <td style=" width: 120px;border: none;">صفحات مرتبط</td>
                <td style="border: none;">
                    <input  name="pages" type="text" class="form-control " id="pageSe" dir="rtl" value=""  />
                </td>
            </tr>
            <tr>
                <td style=" width: 120px;">زمان آغاز پاسخدهی</td>
                <td >
                    <link rel="stylesheet" href="{{App::make('url')->to('/')}}/theme/jsclender/skins/aqua/theme.css">
                    <script src="{{App::make('url')->to('/')}}/theme/jsclender/jalali.js"></script>
                    <script src="{{App::make('url')->to('/')}}/theme/jsclender/calendar.js"></script>
                    <script src="{{App::make('url')->to('/')}}/theme/jsclender/calendar-setup.js"></script>
                    <script src="{{App::make('url')->to('/')}}/theme/jsclender/lang/calendar-fa.js"></script>
                    <input id="date_input" name='start' value="" class="form-control required" style="width: 150px;display: inline;" type="text">
                    <img  id="date_btn" src='{{App::make('url')->to('/')}}/theme/jsclender/cal.png'/>
                    <script>
                        Calendar.setup({
                            inputField: 'date_input',
                            button: 'date_btn',
                            ifFormat: '%Y/%m/%d - %H:%M',
                            dateType: 'jalali',
                            showsTime:true
                        });                    </script>
                </td>
            </tr>

            <tr>
                <td style=" width: 120px;border: none;">زمان پایان پاسخدهی</td>
                <td style="border: none;">
                    <input id="date_input2" name='end' class="form-control required" style="width: 150px;display: inline;" type="text">
                    <img  id="date_btn2" src='{{App::make('url')->to('/')}}/theme/jsclender/cal.png'/>
                    <script>
                        Calendar.setup({
                            inputField: 'date_input2',
                            button: 'date_btn2',
                            ifFormat: '%Y/%m/%d - %H:%M',
                            dateType: 'jalali',
                            showsTime:true
                        });                    </script>
                </td>
            </tr>

            <tr >
                <td  style="border: none;">
                    پیام قبل از شروع زمان پاسخدهی
                </td>
                <td  style="border: none;">
                    <textarea name="before_start"  rows="2" id="form_help" class="form-control" dir="rtl"></textarea>
                </td>
            </tr>

            <tr >
                <td  style="border: none;">
                    پیام بعد از پایان زمان پاسخدهی

                </td>
                <td  style="border: none;">
                    <textarea name="after_end"  rows="2" id="form_help" class="form-control" dir="rtl"></textarea>
                </td>
            </tr>
            <tr>
                <td style="border: none;" >
                    دفعات پاسخدهی
                </td>
                <td style="border: none;" >
                    <input type="checkbox" name="one" >
                    هر کاربر فقط یکبار
                </td>
            </tr>
            <tr>
                <td style=" width: 120px;border: none;">دسترسی برای پاسخ</td>
                <td style="border: none;">
                    <select  multiple id="manager" name="user_submit" style="width: 350px;display: inline-block;"></select>
                    {{-- <script>
                        $('#manager').magicSuggest({
                            data: "{{App::make('url')->to('/')}}/searchUser",
                            dataUrlParams: { id: 34 },
                            allowFreeEntries: false,
                            allowDuplicates: false,
                            hideTrigger: true
                        });
                        var manager = $('#manager').magicSuggest({});
                    </script>
                    --}}

                    <div style="height: 10px; display: inline-block;">
                        <a href="{!! route('modals.setting_user_view',['id_select'=>'manager']) !!}" title="انتخاب کاربران" class="jsPanels">
                            <span class="icon icon-afzoodane-fard fonts"></span>
                        </a>
                    </div>
                </td>
            </tr>

            <tr>
                <td style=" width: 120px;border: none;">دسترسی به پاسخ‌ها </td>
                <td style="border: none;">
                    <select  id="supporter" multiple name="user_view" style="width: 350px;display: inline-block;"></select>
                   {{--  <script>
                        $('#supporter').magicSuggest({
                            data: "{{App::make('url')->to('/')}}/searchUser",
                            dataUrlParams: { id: 34 },
                            allowFreeEntries: false,
                            allowDuplicates: false,
                            hideTrigger: true
                        });
                        var supporter = $('#supporter').magicSuggest({});
                    </script>
                    --}}
                    <div style="height: 10px; display: inline-block;">
                        <a href="{!! route('modals.setting_user_view',['id_select'=>'supporter']) !!}" title="انتخاب کاربران" class="jsPanels">
                            <span class="icon icon-afzoodane-fard fonts"></span>
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
                <td style=" width: 120px;border: none;">دسترسی  ویرایش</td>
                <td style="border: none;">
                    <select  id="supervisor" multiple name="user_edit" style="width: 350px;display: inline-block;"></select>
                    {{-- <script>
                        $('#supervisor').magicSuggest({
                            data: "{{App::make('url')->to('/')}}/searchUser",
                            dataUrlParams: { id: 34 },
                            allowFreeEntries: false,
                            allowDuplicates: false,
                            hideTrigger: true
                        });
                        var supervisor = $('#supervisor').magicSuggest({});
                    </script>--}}
                    <div style="height: 10px; display: inline-block;">
                        <a href="{!! route('modals.setting_user_view',['id_select'=>'supervisor']) !!}" title="انتخاب کاربران" class="jsPanels">
                            <span class="icon icon-afzoodane-fard fonts"></span>
                        </a>
                    </div>
                </td>
            </tr>
            <tr style="display: none;">
                <td>نوع فرم </td>
                <td >
                    <select class="inputbox form-control" name="form_type">
                        <option value="1">فرم پرسشنامه</option>
                        <option value="2">فرم همکاری</option>
                        <option value="3">فرم اقدام</option>
                    </select>
                </td>
            </tr>

            <tr style="display: none;">
                <td style="border: none;">
                    نمایش گزینه ها در
                </td>
                <td  style="border: none;">
                    <select name="column" class="form-control" style=" width: 120px;display: inline;">
                        <option value="1" >1</option>
                        <option value="2" >2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                    ستون
                </td>

            </tr>


            </tbody>


        </table>
        <div id="Row1">
            <table id="sortable2" class="ProcTable table table-default table-bordered table-striped table-hover">
                <tbody><tr>

                    <th width="100%">پرسش - توضیح<span class="counter"> 1</span>
                        <div style="position: relative;;height: 10px;" class="FloatLeft " onclick="removeRow(this)">
                            <span style="height: 10px;" class="FloatLeft icon  icon icon-hazv" ></span>
                        </div>

                    </th>

                </tr>


                <tr id="id_1">

                    <td>
                        <table class="tblBorderLess">
                            <tbody><tr>

                                <td align="right" colspan="4">

                                    <div style="float:right;width: 250px;">
                                        <input type="radio" checked value="1" class="SelType" name="SelType[1]" onclick="SelType(this)" > پرسش
                                        <input type="radio"  value="0" class="SelType" name="SelType[1]" onclick="SelType(this)"> توضیح (برای مخاطب)
                                    </div>

                                    <div style="float:left;width: 150px;margin-bottom: 10px;">
                                        <span style="display: inline;">
                                            مرحله</span>
                                        <select class="form-control" style="display: inline;width: 80px;" name="level[1]">
                                            <option value = "1">1</option>
                                            <option value = "2">2</option>
                                            <option value = "3">3</option>
                                            <option value = "4">4</option>
                                            <option value = "5">5</option>
                                        </select>
                                    </div>

                                    <textarea class="form-control" style="width: 97%" rows="2" name="field_name[1]" id="comment"></textarea>
                                </td>
                            </tr>


                            <tr  class="Porsesh">
                                <td style="vertical-align: top">
                                    نوع پاسخ
                                    <select class="form-control DD_Sel"  style="display: inline;width: 250px;" name="field_type[1]">
                                        @if(is_array($fields))
                                            @foreach($fields as $item)
                                                <option value = "{{$item['value']}}">{{$item['name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                </td>
                            </tr>
                            <tr  class="Porsesh AlertP">
                                <td style="vertical-align: top">
                                    مقادیر
                                    <input type="text" style="width:400px;display: inline" value="" dir="rtl" class="form-control" name="field_value[1]">
                                    <span style="color:red;">
                                        برای جدا کردن مقادیر از "|" استفاده نمایید .
                                    </span>
                                </td>
                                <td style="vertical-align: top">
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top">

                                    <input type="checkbox"  name="requires[1]">
                                    پاسخ به این پرسش الزامی است
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>

                </tr>
                </tbody>
            </table>
        </div>
        <div id="Rows">
        </div>
        <div style="float: right;cursor: pointer;">
            <span id="Add" class="icon icon-plus-square ">   افزودن</span>
        </div>
        <br>

        <input type="submit" name="newform" id="submit" value="تایید" class="btn btn-primary FloatLeft"/>
        <input type="submit" name="newform" id="submit" value="پیش‌نویس" class="btn btn-primary FloatLeft" style="margin-left: 10px"/></td>



        <script>
            var i = 1;
            $("#Add").click(function() {
                counter = $(".counter:last").html();
                counter = counter * 1 + 1;
                con = $("#Row1").html();
                // con = con.replace('[1]', '[' + counter + ']');
                con = con.replace(/[[1]]/g, '' + counter + ']');
                con = con.replace(/_1/g, '_' + counter);
                $("#Rows").append(con);
                $("#Rows").find(".counter:last").html(counter);
            });
            function SelType(e) {
                var sel = $(e).val()
                if (sel == '1')
                    $(e).closest('tr').next('tr.Porsesh').show();
                else
                    $(e).closest('tr').next('tr.Porsesh').hide();
            }


            $(".DD_Sel").change(function() {
                var sel = $(this).val();
                if (sel == 'select' || sel == 'checkbox' || sel == 'radio')
                    $(this).closest('tr').next('tr.AlertP').show();
                else
                    $(this).closest('tr').next('tr.AlertP').hide();
            });
            function removeRow(e) {
                counter = $(".counter:last").html();
                if (counter > 1)
                    $(e).closest('.ProcTable').remove();
            }
        </script>
    </form>
    <script>
        $("#manager").select2({
            ajax: {
                type: "POST",
                url: '{!! route('auto_complete.users') !!}',
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item, i) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                },

            },
            escapeMarkup: function (markup) {
                return markup;
            }, // let our custom formatter work
        });
        $("#supervisor").select2({
            ajax: {
                type: "POST",
                url: '{!! route('auto_complete.users') !!}',
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item, i) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                },

            },
            escapeMarkup: function (markup) {
                return markup;
            }, // let our custom formatter work
        });
        $("#supporter").select2({
            ajax: {
                type: "POST",
                url: '{!! route('auto_complete.users') !!}',
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item, i) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                },

            },
            escapeMarkup: function (markup) {
                return markup;
            }, // let our custom formatter work
        });
    </script>




@stop

