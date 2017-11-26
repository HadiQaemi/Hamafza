<link href="{{App::make('url')->to('/')}}/theme/Content/css/magicsuggest.css" rel="stylesheet">
<script src="{{App::make('url')->to('/')}}/theme/Scripts/magicsuggest-min.js"></script>
<script type="text/javascript">
     token = $("#_token").val();
   function RemoveFile(obj)
   {
       $(obj).parent().parent().parent().remove();
   }
   function FileName(obj, tar)
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
       $(obj).closest('span').children('div').html('');
       $(obj).closest('span').children('div').removeClass('btn');
       $(obj).closest('span').children('div').removeClass('btn-default');
       $(obj).closest('span').children('div').removeClass('btn-file');
       $("#add").trigger('click');
   }
   
   $(document).ready(function() {
       $("#naghlclick").click(function() {
       if ($(this).attr("val") == '1') {
           $("#naghl").show();
           $(this).attr("val", '0');
           $(this).removeClass("glyphicon-triangle-left");
           $(this).addClass("glyphicon-triangle-bottom");
           $("#naghallow").val("1");
       }
       else
       {
           $("#naghl").hide();
           $(this).attr("val", '1');
           $(this).removeClass("glyphicon-triangle-bottom");
           $(this).addClass("glyphicon-triangle-left");
           $("#naghallow").val("0");
       }
   });
        $(function() {
       $('img#add').click(function() {
           var i = parseInt($('#fileCount').val());
           i++;
   
           $('<tr><td style="padding-top: 5px;text-align:right;direction:rtl;border:none;"><span class=" btn-file" ><div id="FileTile[' + i + ']" class="btn btn-default btn-file" style="font-size:12pt;cursor: pointer" >افزودن فایل</div><input style="height: 30px;width: 100px" type="file" name="file[' + i + ']" onchange="FileName(this);" ></span><span class="descr" style="display:none;"><div class="DelFile icon-hazv" onclick="RemoveFile(this);" style="color: red;cursor: pointer !important;display: inline-block; height: 15px;width: 15px;"></div>  <input name="ftitle[' + i + ']" class="form-control" style="display: inline;max-width: 200px;" value="" /></span>  </td></tr>').appendTo('table#files');
           $('#fileCount').val(i);
       });
       $('img#remove').click(function() {
           var i = parseInt($('#fileCount').val());
           if (i > 1) {
               $('table#files tr:last').remove();
               i--;
           }
       });
   });
       $("#input-plugin-mesure_tags").tokenInput("{{App::make('url')->to('/')}}/Tagsearch", {
           preventDuplicates: true,
           hintText: "عبارتی را وارد کنید",
           noResultsText: "نتیجه‌ای یافت نشد، با زدن دکمه اینتر کلیدواژه جدیدی ایجاد می‌شود",
           searchingText: "در حال جستجو",
           onAdd: function(item) {
               //add the new label into the database
               if (parseInt(item.id) == 0) {
                   name = $("tester").text();
                   if (name != null) {
                       $.ajax({
                           type: "POST",
                           url: "tagmergeaction.php",
                           dataType: 'html',
                           data: ({New: 'OK', Name: name}),
                           success: function(theResponse) {
                               if (theResponse != 'NOK')
                                   alert('بر چسب جدید با موفقیت تعریف شد');
                               $("#input-plugin-mesure_tags").tokenInput("remove", {name: name});
                               $("#input-plugin-mesure_tags").tokenInput("add", {id: theResponse, name: name});
                           }
                       });
                   }
               }
           },
           onResult: function(item) {
               if ($.isEmptyObject(item)) {
   
                   return [{id: '0', name: $("tester").text()}]
               } else {
                   return item
               }
   
           },
       });
   });
</script>

<div dir="rtl">
   <form id="measure_add" data-toggle="validator" name="measure_add" enctype="multipart/form-data" method="post" action="{{App::make('url')->to('/')}}/measure_add">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token"/>
       <span class="help-icon-span WindowHelpIcon">
        <a href="{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=abzarvazife&hid=6" title="راهنمای اینجا" href="#" class="jsPanels icon-help HelpIcon" style="float: left;padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip">
        </a>
    </span>
       <br>
       <p></p>

       <table class="table">
         <tbody>
             <tr>
               <td style="width:100px;border:none;">عنوان</td>
               <td style="border:none;" class="form-group">
                   <input type="text" value="" required="" class="form-control required"  id="title" name="title"></td>
            </tr>
            <tr>
               <td colspan="2"> 
                  <input type="checkbox" name="moarefi" checked="">
                  درباره: 
                  <strong>{{$title}}</strong>
                  @if($type=='subject')
                  <input type="hidden" name='sid' value='{{$sid}}'>
                  <input type="hidden" name='pid' value='{{$pid}}'>
                  @endif
                  <input type="hidden" name='type' value='{{$type}}'>
               </td>
            </tr>
             @if($select!='')
            <tr>
               <td  style="width:100px;border:none;"> 
                  نقل قول  
               </td>
               <td style="border:none;">
                  <!--<pres dir="ltr" class="xdebug-var-dump">-->
                     <textarea class="form-control" id="select" name="select">{{$select}}</textarea>
                  <!--</pres>-->
<!--                  <div>
                     نقل قول
                     <input type="radio" name="naghl" value="1" checked> مستقیم
                     <input type="radio" name="naghl" value="0"> غیر مستقیم
                     <span style="margin-right: 20px;">
                     شماره صفحه سند
                     <input type="text" class="form-control" id="bookpage" name="bookpage" style="width:60px; display: inline;"> 
                     </span>
                  </div>-->
               </td>
            </tr>
            @else
            <input type="hidden" name="naghallow" id="naghallow" value="0">
            <tr>
               <td style="width:100px;border:none;"> 
                  <span style="cursor: pointer" id="naghlclick" class="glyphicon glyphicon-triangle-left"  val="1"><span style="font-family: 'IranSharp'">نقل قول  </span>                
                  </span>            
               </td>
               <td  style="border:none;">
                  <div id="naghl" style="display: none;">
                     <!--<pres dir="ltr" class="xdebug-var-dump">-->
                        <textarea class="form-control" id="select" name="select"></textarea>
                     <!--</pres>-->
                     <div>
<!--                        <input type="radio" name="naghl" value="1" checked> مستقیم
                        <input type="radio" name="naghl" value="0"> غیر مستقیم
                        <span style="margin-right: 20px;">
                        شماره صفحه سند
                        <input type="text" class="form-control" id="bookpage" name="bookpage" style="width:60px; display: inline;"> 
                        </span>-->
                     </div>
                  </div>
               </td>
            </tr>
            @endif
            <tr>
               <td>توضیح</td>
               <td>  
                  <textarea id="Descr" type="text" class="form-control" name="Descr" ></textarea>
               </td>
            </tr>
           
            <tr>
               <td style="width:100px;">مسئول انجام</td>
               <td align="right">
                   <select   id="manager" name="user_edits" multiple style="width: 350px;display: inline-block;"></select>
                   {{-- <script type="text/javascript">
                               $('#manager').magicSuggest({
                       data: "{{App::make('url')->to('/')}}/searchUser",
                               dataUrlParams: { id: 34,_token: token },
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
               </td>
            </tr>
            <tr>
               <td style="width:100px;border:none;">رونوشت</td>
               <td align="right" style="border:none;">
                   <select  id="supervisor" multiple name="user_roonevesht" style="width: 350px;display: inline-block;"></select>
                               {{-- <script>
                                            $('#supervisor').magicSuggest({
                                    data: "{{App::make('url')->to('/')}}/searchUser",
                                            dataUrlParams: { id: 34 ,_token: token},
                                            allowFreeEntries: false,
                                            allowDuplicates: false,
                                            hideTrigger: true
                                    });
                                            var supervisor = $('#supervisor').magicSuggest({});
                                         
                                </script> --}}

                                <div style="height: 10px; display: inline-block;">
                                    <a href="{!! route('modals.setting_user_view',['id_select'=>'supervisor']) !!}" title="انتخاب کاربران" class="jsPanels">
                                        <span class="icon icon-afzoodane-fard fonts"></span>
                                    </a>
                                </div>
                   
               </td>
            </tr>
            <tr style="display:none;">
               <td style="width:100px;">اجازه واگذاری</td>
               <td>
                  <input type="radio" value="1" name="vagozari">بلی
                  <input type="radio" checked="" value="0" name="vagozari">خیر
               </td>
            </tr>
            <tr>
               <td style="width:100px;">مهلت  </td>
               <td class="form-group">
                  <link rel="stylesheet" href="{{App::make('url')->to('/')}}/theme/jsclender/skins/aqua/theme.css">
                  <script src="{{App::make('url')->to('/')}}/theme/jsclender/jalali.js"></script>
                  <script src="{{App::make('url')->to('/')}}/theme/jsclender/calendar.js"></script>
                  <script src="{{App::make('url')->to('/')}}/theme/jsclender/calendar-setup.js"></script>
                  <script src="{{App::make('url')->to('/')}}/theme/jsclender/lang/calendar-fa.js"></script>
                  <input required="" id="date_input" name='mohlat' class="form-control required" style="width: 150px;display: inline;" type="text">
                  <img  id="date_btn" src='{{App::make('url')->to('/')}}/theme/jsclender/cal.png'/>
                  <script>
                     Calendar.setup({
                         inputField: 'date_input',
                         button: 'date_btn',
                         ifFormat: '%Y/%m/%d',
                         dateType: 'jalali'
                     });
                                         
                  </script>
               </td>
            </tr>
            <tr>
               <td style="width:100px;border:none;">اولویت</td>
               <td style="border:none;">
                   <input type="radio" value="0" name="foriat" checked="">غیرمهم
                  <input type="radio" value="1" name="foriat">مهم
                     <input type="radio" style="margin-right:50px;" value="0" name="ahamiat" checked>غیرفوری
                     <input type="radio" value="1" name="ahamiat">فوری
               </td>
            </tr>
            <tr style="display: none;">
               <td style="width:100px;border:none;">اطلاع رسانی</td>
               <td style="border:none;">
                  <input type="checkbox" value="1" name="Sendmail">
                  هم اکنون از طریق رایانامه اطلاع داده شود
                  <div style="display: inline-block;  margin-right: 50px;">
                     <input type="checkbox" disabled="" name="sendsms">
                     هم اکنون از طریق پیامک اطلاع داده شود
                  </div>
               </td>
            </tr>
            <tr>
               <td style="width:100px;">کلیدواژه</td>
               <td>
                  <input type="text" id="input-plugin-mesure_tags" name="mesure_tags"/>
               </td>
            </tr>
            <tr>
               <td style="width:100px;border:none;">فایل های پیوست</td>
               <td dir="rtl" style="text-align:right;direction:rtl;border:none;">
                  <input type="hidden" value="1" id="fileCount">
                  <table  class="atable" style="border:none;" width="100%" border="0" cellspacing="0" cellpadding="0" id="files">
                     <tr>
                        <td style="text-align:right;direction:rtl;border:none;">
                           <span  class="btn-file">
                              <div id="FileTile[1]" class="btn btn-default btn-file" style="font-size: 12pt;cursor: pointer" >افزودن فایل</div>
                              <input style="height: 30px;width: 100px" type="file" name="file[1]" onchange="FileName(this, '#FileTile[1]');">
                           </span>
                           <span class="descr" style="display: none;">
                              <div class="DelFile icon-hazv" onclick="RemoveFile(this);" style="color: red;cursor: pointer !important;display: inline-block; height: 15px;width: 15px;"></div>
                              <input name="ftitle[1]" class="form-control" style="display: inline;max-width: 200px;" value="" />
                           </span>
                        </td>
                     </tr>
                  </table>
                  <span style="display: none;"><img style="cursor:pointer" src="{{App::make('url')->to('/')}}/theme/Content/icons/add.png" id="add">&nbsp;<img style="cursor:pointer" id="remove" src="theme/images/remove.png"></span>
               </td>
            </tr>
            <tr>
               <td colspan="2" dir="rtl">
                  <span>
                  <input type="radio" value="1" name="isdraft"> پیش نویس
                  <input type="radio" checked="" value="0" name="isdraft">نهایی
                  </span>
                  <input type="hidden" value="{{$pid}}" id="pid" name="pid">
                  <input type="hidden" value="{{$sid}}" name="sid">
                  <input type="submit" class="btn btn-info FloatLeft" onsubmit="$('#measure_add').bsValidate();" value="تایید" name="measure_add">
               </td>
            </tr>
         </tbody>
      </table>
   </form>
</div>
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
</script>