<div style="padding: 10px;">
    <label>عنوان:</label> <input type="text" id="title" name="title" class="form-control" style="width: 400px;" value="{!! @$basicdatavalue['title'] !!}" /><br />
    <label>آدرس لینک:</label> <input type="text" id="value" name="value" class="form-control" style="width: 400px; direction: ltr;" value="{!! @$basicdatavalue['url_address'] !!}" /><br />

    <div class="row">
        <div id="new_header_image" class="form-group">
            <div>
                <code style="font-size: 12px;">بهترین ابعاد تصویر: 191*158 پیکسل</code>
            </div>
            <div class="col-lg-9">
                {!! $HFM_media['Buttons']['ad_image'] !!}
                {!! $HFM_media['ShowResultArea']['ad_image'] !!}
                <span class="help-block">{{trans('app.valid_mime_type')}}: gif, png, jpg. | <span>{{trans('app.valid_max_file_size')}}
                        : 2mb</span> </span>
            </div>
        </div>
    </div>
    <div id="old_header_image" class="row">
        <div class="col-sm-3">
            <labal>فایل شما:</labal>
            <div style="height: 191px; width: 158px;">
                <img style="height: 191px; width: 191px;"
                     src="{{route('File.DownloadFile',['ID', front_settings(1)['header_image']['value'] ? front_settings(1)['header_image']['value'] : -1, 'default_img' => 'front_header_image.jpg']) }}"
                     alt="">
            </div>
        </div>
        <labal>نمونه تکرار شونده:</labal>
        <div>
            <div class="col-sm-9"
                 style="height: 191px; background-repeat: repeat-x; background-image: url('{{route('File.DownloadFile',['ID', front_settings(1)['header_image']['value'] ? front_settings(1)['header_image']['value'] : -1, 'default_img' => 'front_header_image.jpg']) }}')">
            </div>
        </div>
    </div>

    <label>توضیحات:</label> <textarea id="comment" name="comment" class="form-control" style="width: 400px;">{!! @$basicdatavalue['comment'] !!}</textarea><br />
    <label>وضعیت:</label> <input type="radio" id="0" name="inactive" value="0" checked="checked" /><label for="inactive_0">فعال</label> <input type="radio" id="inactive_1" name="inactive" value="1" /><label for="inactive_1">غیر فعال</label>
    <input type="hidden" id="parentid" name="parentid" value="{!! @$parentid !!}" />
</div>
<script>
    $('#inactive_{!! @$basicdatavalue['inactive'] !!}').attr('checked', 'checked');
</script>