<link href="{{App::make('url')->to('/')}}/theme/Content/css/magicsuggest.css" rel="stylesheet">
<script src="{{App::make('url')->to('/')}}/theme/Scripts/magicsuggest-min.js"></script>
<script src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.tokeninput.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#pageSe").tokenInput("{{App::make('url')->to('/')}}/Pagesearch", {
            preventDuplicates: true,
            hintText: "عبارتی را وارد کنید",
            noResultsText: "نتیجه‌ای یافت نشد، با زدن دکمه اینتر کلیدواژه جدیدی ایجاد می‌شود",
            searchingText: "در حال جستجو",
        });
    });
</script>
@if($sublink=='copy')
    <form action="{{ route('hamafza.form_add') }}" method="post" name="form" id="form">
 @else
     <form action="{{ route('hamafza.form_edit') }}" method="post" name="form" id="form">

 @endif
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
    <table id="Rowd" width="100%" class="table">
     <tbody>
        <tr>
          <th colspan="2"></th>
        </tr>
        <tr>
      <td style=" width: 120px;">عنوان فرم</td>
       <td>
                            <input name="form_id" type="hidden" value="{{$Form->fid}}"/>
                            <input style="display: inline;" name="form_name" type="text" class="form-control" id="form_name" dir="rtl" value="{{$Form->title}}"/>
                        </td>
                    </tr>
        <tr>
                        <td style="border: none;">
                            توضیح
                        </td>
                        <td style="border: none;">
                            <textarea name="form_help" rows="2" id="form_help" class="form-control" dir="rtl">{{$Form->help}}</textarea>
                        </td>

                    </tr>
        <tr>
                        <td style=" width: 120px;border: none;">صفحات مرتبط</td>
                        <td style="border: none;">
                            <input name="pages" type="text" class="form-control " id="pageSe" dir="rtl" value=""/>
                            <script>
                                $(document).ready(function () {

                                            @if(is_array($Pages)&& count($Pages)>0)
                                            @foreach($Pages as $item)
                                    var keyname = "{{$item->title}}";
                                    var keyid = "{{$item->id}}";
                                    $("#pageSe").tokenInput("add", {id: keyid, name: keyname});
                                    @endforeach
                                    @endif
                                });        </script>
                        </td>
                    </tr>
        <tr>
                        <td style=" width: 120px;">زمان آغاز پاسخدهی</td>
                        <td>
                            <link rel="stylesheet" href="{{App::make('url')->to('/')}}/theme/jsclender/skins/aqua/theme.css">
                            <script src="{{App::make('url')->to('/')}}/theme/jsclender/jalali.js"></script>
                            <script src="{{App::make('url')->to('/')}}/theme/jsclender/calendar.js"></script>
                            <script src="{{App::make('url')->to('/')}}/theme/jsclender/calendar-setup.js"></script>
                            <script src="{{App::make('url')->to('/')}}/theme/jsclender/lang/calendar-fa.js"></script>
                            <input value="" id="date_input" name='start' class="form-control required" style="width: 150px;display: inline;" type="text">
                            <img id="date_btn" src='{{App::make('url')->to('/')}}/theme/jsclender/cal.png'/>
                            <script>
                                Calendar.setup({
                                    inputField: 'date_input',
                                    button: 'date_btn',
                                    ifFormat: '%Y/%m/%d - %H:%M',
                                    dateType: 'jalali',
                                    showsTime: true
                                });</script>
                        </td>
                    </tr>
        <tr>
                        <td style=" width: 120px;border: none;">زمان پایان پاسخدهی</td>
                        <td style="border: none;">
                            <input id="date_input2" value="" name='end' class="form-control required" style="width: 150px;display: inline;" type="text">
                            <img id="date_btn2" src='{{App::make('url')->to('/')}}/theme/jsclender/cal.png'/>
                            <script>
                                Calendar.setup({
                                    inputField: 'date_input2',
                                    button: 'date_btn2',
                                    ifFormat: '%Y/%m/%d - %H:%M',
                                    dateType: 'jalali',
                                    showsTime: true
                                });</script>
                        </td>
                    </tr>
        <tr>
                        <td style="border: none;">
                            پیام قبل از شروع زمان پاسخدهی
                        </td>
                        <td style="border: none;">
                            <textarea name="before_start" rows="2" id="form_help" class="form-control" dir="rtl">{{$Form->before_start}}</textarea>
                        </td>
                    </tr>
        <tr>
                        <td style="border: none;">
                            پیام بعد از پایان زمان پاسخدهی

                        </td>
                        <td style="border: none;">
                            <textarea name="after_end" rows="2" id="form_help" class="form-control" dir="rtl">{{$Form->after_end}}</textarea>
                        </td>
                    </tr>
        <tr>
                        <td style="border: none;">
                            دفعات پاسخدهی
                        </td>
                        <td style="border: none;">
                            <input type="checkbox" name="one" @if($Form->onereport==1) checked @endif >
                            هر کاربر فقط یکبار
                        </td>
                    </tr>
        <tr>
                        <td style=" width: 120px;border: none;">دسترسی برای پاسخ</td>
                        <td style="border: none;">
                            <select id="manager" multiple name="user_submit" style="width: 350px;display: inline-block;"></select>
                            {{--   <script>
                                  $('#manager').magicSuggest({
                                      data: "{{App::make('url')->to('/')}}/searchUser",
                                      dataUrlParams: {id: 34},
                                      allowFreeEntries: false,
                                      allowDuplicates: false,
                                      hideTrigger: true
                                  });

                                  var manager = $('#manager').magicSuggest({});
                                                  @if (is_array($ACC) && count($ACC)>0)
                                                    @foreach($ACC as $item)
                                                    @if ($item->actype=='1')
                                                  na = "{{$item->Name}} {{$item->Family}}";
                                                  ids = {{$item->id}};
                                                  manager.addToSelection([{name:na, id:ids}]);
                                                      @endif

          @endforeach
                                                  @endif


                              </script> --}}

                            <div style="height: 10px; display: inline-block;">
                                <a href="{!! route('modals.setting_user_view',['id_select'=>'manager']) !!}" title="انتخاب کاربران" class="jsPanels">
                                    <span class="icon icon-afzoodane-fard fonts"></span>
                                </a>
                            </div>
                        </td>
                    </tr>
        <tr>
                        <td style=" width: 120px;border: none;">دسترسی به پاسخ‌ها</td>

                        <td style="border: none;">
                            <select multiple id="supporter" name="user_view" style="width: 350px;display: inline-block;"></select>
                            {{--  <script>
                                 $('#supporter').magicSuggest({
                                     data: "{{App::make('url')->to('/')}}/searchUser",
                                     dataUrlParams: {id: 34},
                                     allowFreeEntries: false,
                                     allowDuplicates: false,
                                     hideTrigger: true
                                 });
                                 var manager = $('#supporter').magicSuggest({});
     @if (is_array($ACC) && count($ACC)>0)
     @foreach($ACC as $item)
     @if ($item->actype=='2')
     na = "{{$item->Name}} {{$item->Family}}";
     ids = {{$item->id}};
     manager.addToSelection([{name:na, id:ids}]);
     @endif

     @endforeach
     @endif

                             </script> --}}
                            <div style="height: 10px; display: inline-block;">
                                <a href="{!! route('modals.setting_user_view',['id_select'=>'supporter']) !!}" title="انتخاب کاربران" class="jsPanels">
                                    <span class="icon icon-afzoodane-fard fonts"></span>
                                </a>
                            </div>
                        </td>
                    </tr>
        <tr>
                        <td style=" width: 120px;border: none;">دسترسی ویرایش</td>
                        <td style="border: none;">
                            <select multiple id="supervisor" name="user_edit" style="width: 350px;display: inline-block;"></select>
                            {{--  <script>
                                 $('#supervisor').magicSuggest({
                                     data: "{{App::make('url')->to('/')}}/searchUser",
                                     dataUrlParams: {id: 34},
                                     allowFreeEntries: false,
                                     allowDuplicates: false,
                                     hideTrigger: true
                                 });
                                 var manager = $('#supervisor').magicSuggest({});
     @if (is_array($ACC) && count($ACC)>0)
     @foreach($ACC as $item)
     @if ($item->actype=='3')
     na = "{{$item->Name}} {{$item->Family}}";
     ids = {{$item->id}};
     manager.addToSelection([{name:na, id:ids}]);
     @endif

     @endforeach
     @endif

                             </script> --}}
                            <div style="height: 10px; display: inline-block;">
                                <a href="{!! route('modals.setting_user_view',['id_select'=>'supervisor']) !!}" title="انتخاب کاربران" class="jsPanels">
                                    <span class="icon icon-afzoodane-fard fonts"></span>
                                </a>
                            </div>
                        </td>
                    </tr>
        <tr style="display: none;">
                        <td>نوع فرم : *</td>
                        <td>
                            <select class="inputbox form-control" name="form_type">
                                <option value="1" @if($Form->type=='1') selected @endif >فرم پرسشنامه</option>
                                <option value="2" @if($Form->type=='2') selected @endif>فرم همکاری</option>
                                <option value="3" @if($Form->type=='3') selected @endif>فرم اقدام</option>
                            </select>
                        </td>
                    </tr>
        <tr style="display: none;">
                        <td>
                            نمایش گزینه ها در
                        </td>
                        <td>
                            <select name="column" class="form-control" style=" width: 120px;display: inline;">
                                <option value="1" @if($Form->col=='1') selected @endif>1</option>
                                <option value="2" @if($Form->col=='2') selected @endif>2</option>
                                <option value="3" @if($Form->col=='3') selected @endif>3</option>
                                <option value="4" @if($Form->col=='4') selected @endif>4</option>
                                <option value="5" @if($Form->col=='5') selected @endif>5</option>
                                <option value="6" @if($Form->col=='6') selected @endif>6</option>
                            </select>
                            ستون
                        </td>

                    </tr>
    </tbody>


    </table>
    <?php $i = 1; ?>
    @if (is_array($Fields))
                    @foreach($Fields as $item)
                        <div style="border-top: 1px solid #cccccc;">
                            <table id="sortable2" class="ProcTable table table-default table-bordered table-striped ">
                                <tbody>
                                <tr>
                                    <th width="100%">پرسش - توضیح<span class="counter"> {{$i}}</span>
                                        <div style="position: relative;;height: 10px;" class="FloatLeft Delicn" onclick="removeRow(this)" action="delete" page="FormField" id="{{$item->did}}">
                                            <span style="height: 10px;" class="FloatLeft icon  icon icon-hazv"></span>
                                        </div>
                                    </th>
                                </tr>


                                <tr id="id_1">
                                    <td>
                                        <table class="tblBorderLess">
                                            <tbody>
                                            <tr>
                                                <td align="right" colspan="3">
                                                    <div style="float:right;width: 250px;">
                                                        <input type="radio" name="SelType[{{$i}}]" @if($item->question=="1")checked onload="SelType(this)" @endif  value="1" class="SelType" onclick="SelType(this)"> پرسش
                                                        <input type="radio" name="SelType[{{$i}}]" value="0" @if($item->question=="0")checked onload="SelType(this)" @endif  class="SelType" onclick="SelType(this)"> توضیح (برای مخاطب)
                                                    </div>


                                                    <div style="float:left;width: 150px;margin-bottom: 10px;">
                                            <span style="display: inline;">
                                                مرحله</span>
                                                        <select class="form-control" style="display: inline;width: 80px;" name="level[{{$i}}]">
                                                            <option value="1" @if($item->level=='1') selected @endif>1</option>
                                                            <option value="2" @if($item->level=='2') selected @endif>2</option>
                                                            <option value="3" @if($item->level=='3') selected @endif>3</option>
                                                            <option value="4" @if($item->level=='4') selected @endif>4</option>
                                                            <option value="5" @if($item->level=='5') selected @endif>5</option>
                                                        </select>
                                                    </div>
                                                    <textarea class="form-control" style="width: 97%" rows="2" name="field_name[{{$i}}]" id="comment">{{$item->field_name}}</textarea>
                                                </td>
                                            </tr>
                                            <tr style="@if($item->question=='0')  display: none; @endif" class="Porsesh">
                                                <td style="vertical-align: top">
                                                    نوع پاسخ
                                                    <input type="hidden" value="{{$item->did}}" name="did[{{$i}}]">
                                                    <select class="form-control" style="display: inline;width: 250px;" name="field_type[{{$i}}]">

                                                        @if(is_array($fields))
                                                            @foreach($fields as $items)
                                                                <option value="{{$items->value}}" @if($item->field_type==$items->value) selected @endif>{{$items->name}}</option>
                                                            @endforeach

                                                        @endif
                                                    </select>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr style="@if($item->question=='0')  display: none; @endif" class="Porsesh AlertP">
                                                <td style="vertical-align: top">
                                                    مقادیر
                                                    <input type="text" size="30" style="width:400px;display: inline"
                                                           value="@if(is_array($item->values))@foreach($item->values as $vlaue)@if($vlaue->field_value!=''){{$vlaue->field_value}}|@endif @endforeach @endif
                                                                   " dir="rtl" class="form-control" name="field_value[{{$i}}]">
                                                    <span style="color:red;">
                                            برای جدا کردن مقادیر از "|" استفاده نمایید .
                                        </span>
                                                </td>

                                            </tr>
                                            <td style="vertical-align: top">
                                                <input type="checkbox" @if($item->requires=='1') checked @endif   name="requires[{{$i}}]">
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
                        <?php $i++; ?>
                    @endforeach
                @endif

    <div id="Row1" style="border-top: 1px solid #cccccc;">
                    <table id="sortable2" class="ProcTable table table-default table-bordered table-striped table-hover">
                        <tbody>
                        <tr>

                            <th width="100%">پرسش - توضیح<span class="counter">  {{$i}} </span>
                                <div style="position: relative;;height: 10px;" class="FloatLeft " onclick="removeRow(this)">
                                    <span style="height: 10px;" class="FloatLeft icon  icon icon-hazv"></span>
                                </div>

                            </th>

                        </tr>


                        <tr id="id_1">

                            <td>
                                <table class="tblBorderLess">
                                    <tbody>
                                    <tr>

                                        <td align="right" colspan="4">

                                            <div style="float:right;width: 250px;">
                                                <input type="radio" checked value="1" class="SelType" name="SelType[{{$i}}]" onclick="SelType(this)"> پرسش
                                                <input type="radio" value="0" class="SelType" name="SelType[{{$i}}]" onclick="SelType(this)"> توضیح (برای مخاطب)
                                            </div>

                                            <div style="float:left;width: 150px;margin-bottom: 10px;">
                                        <span style="display: inline;">
                                            مرحله</span>
                                                <select class="form-control" style="display: inline;width: 80px;" name="level[{{$i}}]">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>

                                            <textarea class="form-control" style="width: 97%" rows="2" name="field_name[{{$i}}]" id="comment"></textarea>
                                        </td>
                                    </tr>


                                    <tr class="Porsesh">
                                        <td style="vertical-align: top">
                                            نوع پاسخ
                                            <select class="form-control DD_Sel" style="display: inline;width: 250px;" name="field_type[{{$i}}]">
                                                @if(is_array($fields))
                                                    @foreach($fields as $item)
                                                        <option value="{{$item->value}}">{{$item->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                        </td>
                                    </tr>
                                    <tr class="Porsesh AlertP">
                                        <td style="vertical-align: top">
                                            مقادیر
                                            <input type="text" style="width:400px;display: inline" value="" dir="rtl" class="form-control" name="field_value[{{$i}}]">
                                            <span style="color:red;">
                                        برای جدا کردن مقادیر از "|" استفاده نمایید .
                                    </span>
                                        </td>
                                        <td style="vertical-align: top">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top">

                                            <input type="checkbox" name="requires[{{$i}}]">
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
    @if($Form->isdraft=='1')
                    <input type="submit" name="newform" id="submit" value="تایید" class="btn btn-primary FloatLeft"/>
                    <input type="submit" name="newform" id="submit" value="پیش‌نویس" class="btn btn-primary FloatLeft" style="margin-left: 10px"/></td>
    @else
                    <input type="submit" name="newform" id="submit" value="تایید" class="btn btn-primary FloatLeft"/>

                @endif
    <script>
                    var i = 1;
                    $("#Add").click(function () {
                        counter = $(".counter:last").html();
                        counter = counter * 1 + 1;
                        con = $("#Row1").html();
                        // con = con.replace('[{{$i}}]', '[' + counter + ');
                        con = con.replace(/[[{{$i}}]]/g, '' + counter + ');
                        con = con.replace(/_{{$i}}/g, '_' + counter);
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


