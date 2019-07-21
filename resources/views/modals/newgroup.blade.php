<script type="text/javascript">
$(document).ready(function() {
    $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute; left: 40px; top: -3px;"><a href="{{App::make('url')->to('/')}}/modals/helpview?code={{enCode('353')}}" title="راهنمای اینجا" class="jsPanels icon-help HelpIcon" style="float: left; padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');
    $("#Groupkeywords").tokenInput("{{App::make('url')->to('/')}}/Tagsearch", {
    preventDuplicates: true,
        hintText: "عبارتی را وارد کنید",
        noResultsText: "نتیجه‌ای یافت نشد، با زدن دکمه اینتر کلیدواژه جدیدی ایجاد می‌شود",
        searchingText: "در حال جستجو",
        onAdd: function(item) {
        //add the new label into the database
        if (parseInt(item.id) == 0) {
            var name = $("tester").text();
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

<form enctype="multipart/form-data" id="addUserGroupFrm" method="post" action="{{ route('hamafza.new_org_group') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="col-xs-12 margin-top-10">
        <div class="col-xs-2">{{trans('groups.name')}}<span class="color_red">*</span></div>
        <div class="col-xs-6"><input type="text" id="group_title" class="form-control required" value="" name="group_title" placeholder="{{trans('groups.name')}}"/></div>
    </div>
    <div class="col-xs-12 margin-top-10">
        <div class="col-xs-2">{{trans('groups.url')}}<span class="color_red">*</span></div>
        <div class="col-xs-6 no-margin-left"><input type="text" id="group_link" class="form-control required inline" value="" name="group_link" placeholder="{{trans('groups.url')}}"></div>
        <div class="pull-right dir_ltr line-height-30">{{App::make('url')->to('/')}}/</div>
    </div>
    <div class="col-xs-12 margin-top-10">
        <div class="col-xs-2">{{trans('groups.brief_description')}}</div>
        <div class="col-xs-6"><input type="text" id="group_summary" class="form-control" value="" name="group_summary" placeholder="{{trans('groups.brief_description')}}"></div>
    </div>
    <div class="col-xs-12 margin-top-10">
        <div class="col-xs-2">{{trans('groups.keyword')}}</div>
        <div class="col-xs-6"><input type="text" id="Groupkeywords" name="Groupkeywords" ttype="12" placeholder="{{trans('groups.keyword')}}"/></div>
    </div>
    <div class="col-xs-12 margin-top-10">
        <div class="col-xs-2 noLeftPadding">{{trans('groups.member_permission')}}</div>
        <div class="col-xs-6">
            <input type="radio" checked="" value="0" name="group_limit" id="group_limit_0">
            <label for="group_limit_0">{{trans('groups.no')}}</label>
            <input type="radio" value="1" name="group_limit" id="group_limit_1">
            <input type="hidden" value="0" name="group_type" id="group_type">
            <label for="group_limit_1">{{trans('groups.yes')}}</label>
        </div>
    </div>
    {{--<table style="background-color:#fff" class="table">--}}
        {{--<tbody>--}}
            {{--<tr>--}}
                {{--<td>نوع</td>--}}
                {{--<td>--}}
                    {{--<select  class="form-control" data-placeholder="انتخاب کنید" id="group_type" name="group_type">--}}
                        {{--<option value="0" ></option>--}}
                        {{--<option value="1">کانون تفکر</option>--}}
                        {{--<option value="2">اجتماع یادگیری</option>--}}
                        {{--<option value="3">اجتماع عمل</option>--}}
                        {{--<option value="4">مدیریت پروژه</option>--}}
                        {{--<option value="5">هم دوره ای ها</option>--}}
                        {{--<option value="6">سایر</option>--}}
                    {{--</select>--}}
                    {{--<input type="hidden" value="0" name="isorgan">--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td>تصویر</td>--}}
                {{--<td>--}}
                    {{--<span class="btn btn-default btn-file">--}}
                        {{--انتخاب فایل <input type="file" onchange="FileName(this);" style="width:388px" dir="rtl" id="group_pic" class="form-control" value="" name="pic">--}}
                    {{--</span>--}}
                    {{--<span style="display: none;" class="descr"> عنوان فایل <input value="" style="width:200px" class="form-control" name="ftitle[1]"></span>--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td colspan="2">--}}

                    {{--<input type="submit" value="تایید " class="btn btn-primary FloatLeft" name="addUserGroup" id="submit"></td></tr>--}}
        {{--</tbody></table>--}}
</form>