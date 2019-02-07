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
        $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute; left: 40px; top: -3px;"><a href="{!! url('/modals/helpview?code=0') !!}" title="راهنمای اینجا" class="jsPanels icon-help HelpIcon" style="float: left; padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');
    });
</script>

<form enctype="multipart/form-data" id="addUserOrganFrm" method="post" action="{{ route('hamafza.new_org_group') }}">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="col-xs-12 margin-top-10">
        <div class="col-xs-2">{{trans('canals.name')}}<span class="color_red">*</span></div>
        <div class="col-xs-6"><input type="text" id="group_title" class="form-control required" value="" name="group_title" placeholder="{{trans('groups.name')}}"/></div>
    </div>
    <div class="col-xs-12 margin-top-10">
        <div class="col-xs-2">{{trans('canals.url')}}<span class="color_red">*</span></div>
        <div class="col-xs-6 no-margin-left"><input type="text" id="group_link" class="form-control required inline" value="" name="group_link" placeholder="{{trans('groups.url')}}"></div>
        <div class="pull-right dir_ltr line-height-30">{{App::make('url')->to('/')}}/</div>
    </div>
    <div class="col-xs-12 margin-top-10">
        <div class="col-xs-2">{{trans('canals.brief_description')}}</div>
        <div class="col-xs-6"><input type="text" id="group_summary" class="form-control" value="" name="group_summary" placeholder="{{trans('groups.brief_description')}}"></div>
    </div>
    <div class="col-xs-12 margin-top-10">
        <div class="col-xs-2">{{trans('canals.keyword')}}</div>
        <div class="col-xs-6"><input type="text" id="Groupkeywords" name="Groupkeywords" ttype="12" placeholder="{{trans('groups.keyword')}}"/></div>
    </div>
    <div class="col-xs-12 margin-top-10">
        {{--<div class="col-xs-2">{{trans('canals.picture')}}</div>--}}
        {{--<div class="col-xs-6">--}}
            {{--<span class="btn btn-default btn-file">--}}
                 {{--{{trans('canals.choose_file')}}<input type="file" onchange="FileName(this);" style="width:388px" dir="rtl" id="group_pic" class="form-control" value="" name="pic">--}}
            {{--</span>--}}
            {{--<span style="display: none;" class="descr">{{trans('canals.name_file')}}<input value="" style="width:200px" class="form-control" name="ftitle[1]"></span>--}}
        {{--</div>--}}
    </div>
    <div class="col-xs-12 margin-top-10">
        <div class="col-xs-2 noLeftPadding">{{trans('canals.member_permission')}}</div>
        <div class="col-xs-6">
            <input type="radio" checked="" value="0" name="group_limit" id="group_limit_0">
            <label for="group_limit_0">{{trans('groups.no')}}</label>
            <input type="radio" value="1" name="group_limit" id="group_limit_1">
            <input type="hidden" value="0" name="group_type" id="group_type">
            <label for="group_limit_1">{{trans('groups.yes')}}</label>
            <input type="hidden" value="1" name="isorgan">
        </div>
    </div>
</form>