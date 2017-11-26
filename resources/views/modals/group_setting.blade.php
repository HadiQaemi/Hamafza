<link href="{{App::make('url')->to('/')}}/theme/Content/css/magicsuggest.css" rel="stylesheet">
<script src="{{App::make('url')->to('/')}}/theme/Scripts/magicsuggest-min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$("#Groupkeywords").tokenInput("{{App::make('url')->to('/')}}/Tagsearch", {
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
                        $("#input-plugin-methods").tokenInput("remove", {name: name});
                        $("#input-plugin-methods").tokenInput("add", {id: theResponse, name: name});
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

<form action="{{ route('hamafza.group_setting_update') }}" method="post" id="form_group" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <table class="table" style="background-color:#fff">
        <tr>
            <td width="160">نام گروه <font color="red">*</font></td>
            <td>
                <input name="group_title" type="text" value="{{$group_edit['name']}}" class="form-control required" id="group_title" dir="rtl" />
            </td>
        </tr>
        <tr>
            <td style="border-top:none;">نشانی در وب <font color="red">*</font></td>
            <td style="direction:ltr;border-top:none;">
                <div style="padding-top:5px;display: inline-block;">{{App::make('url')->to('/')}}/</div><input name="group_link" type="text" value="{{$group_edit['link']}}" class="form-control required" id="group_link" dir="ltr" style="width:388px; text-align:left;display:inline-block"/>
            </td>
        </tr>
        <tr>
            <td >معرفی اجمالی</td>
            <td>
                <input name="group_summary" type="text" value="<?php echo (isset($group_edit['summary']) ? $group_edit['summary'] : ''); ?>" class="form-control" id="group_summary" dir="rtl" style="width:388px"/>
            </td>
        </tr>
        <tr>
            <td style="border-top:none;">نوع</td>
            <td style="border-top:none;">
                <select  class="form-control" data-placeholder="انتخاب کنید" id="group_type" name="group_type">
                        <option value="0" @if($group_edit['type']=='0') selected="" @endif  ></option>
                        <option value="1"  @if($group_edit['type']=='1') selected="" @endif>کانون تفکر</option>
                        <option value="7" @if($group_edit['type']=='7') selected="" @endif>کانال</option>
                        <option value="2" @if($group_edit['type']=='2') selected="" @endif>اجتماع یادگیری</option>
                        <option value="3" @if($group_edit['type']=='3') selected="" @endif>اجتماع عمل</option>
                        <option value="4" @if($group_edit['type']=='4') selected="" @endif>مدیریت پروژه</option>
                        <option value="5" @if($group_edit['type']=='5') selected="" @endif>هم دوره ای ها</option>
                        <option value="6" @if($group_edit['type']=='6') selected="" @endif>سایر</option>
                    </select>
            </td>
        </tr>
        <tr>
            <td style="border-top:none;">تصویر</td>
            <td style="border-top:none;">
                <?php
                if ($group_edit['pic'] != "" && file_exists("pics/group/" . $group_edit['id'] . "-" . $group_edit['pic'] . "")) {
                    ?>
                    <img src="<?php echo "pics/group/" . $group_edit['id'] . "-" . $group_edit['pic']; ?>" alt="" style="width: 100px; height: auto" />
                    <input type="hidden" name="vpic" id="vpic" value="<?php echo $group_edit['pic'] ?>"/><br/>
                    <?php
                }
                ?>
                <span class="btn btn-default btn-file">
                    انتخاب فایل <input type="file" name="pic" value="" class="form-control" id="group_pic" dir="rtl" style="width:388px" onchange="FileName(this);">
                </span></span>
                <span class="descr" style="display: none;"> عنوان فایل <input name="ftitle[1]" class="form-control" style="width:200px" value="" /></span>

            </td>
        </tr> <tr>
            <td style="border-top:none;"> تغییر مدیر
            </td>
            <td style="border-top:none;">

                <select  id="user_edits" name="user_edits" multiple="multiple"style="width: 350px;display: inline-block;"></select>
                               {{--  <script>
                                            $('#user_edits').magicSuggest({
                                    data: "{{App::make('url')->to('/')}}/searchUser",
                                            dataUrlParams: { id: 34, _token: token },
                                            allowFreeEntries: false,
                                            allowDuplicates: false,
                                            hideTrigger: true
                                    });
                                            var manager = $('#user_edits').magicSuggest({});
                                            @if ($group_edit['adminid'] != '')

                                            na = "{{$group_edit['AdminName']}} {{$group_edit['AdminFamily']}}";
                                            ids = {{$group_edit['adminid']}};
                                            manager.addToSelection([{name:na, id:ids}])
                                            @endif
                                </script>
                                 --}}

                                <div style="height: 10px; display: inline-block;">
                                    <a href="{!! route('modals.setting_user_view',['id_select'=>'user_edits']) !!}" title="انتخاب کاربران" class="jsPanels">
                                        <span class="icon icon-afzoodane-fard fonts"></span>
                                    </a>
                                </div>



            </td>
        </tr>
        <tr>
            <td colspan="2">عضویت سایر افراد نیاز به تایید مدیر گروه
                <label><input type="radio" name="group_limit" value="0" @if($group_edit['allowreg']=='0') checked="" @endif  />ندارد</label>
                <label><input type="radio" name="group_limit" value="1" @if($group_edit['allowreg']=='1') checked="" @endif/>دارد</label>
                    <input type="hidden"  name="gid" value="{{$group_edit['id']}}">
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <input type="submit" class="btn btn-info" id="submit" name="addUserGroup" style=" float: left" value="تایید " />
            </td>
        </tr>
    </table>
</form>
<script>
    $("#user_edits").select2({
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