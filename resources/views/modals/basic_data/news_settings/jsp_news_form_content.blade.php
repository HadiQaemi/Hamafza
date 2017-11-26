<form id="ad_setting_form">
    <input id="edit_form_ad_id" type="hidden" name="item_id" value="{{ $basic_data_value ? $basic_data_value->id : '' }}">
    <div style="padding: 10px;">
        <div class="row" style="margin-top: 5px;">
            <div class="col-sm-6"><label>عنوان:</label> <input type="text" id="title" name="title" class="form-control" value="{{ $basic_data_value ? $basic_data_value->title : '' }}"/></div>
        </div>
        <div class="row" style="margin-top: 5px;">
            <div class="col-sm-12"><label>لیست کلمات کلیدی:</label><select name="news_tabs_list[]" multiple="multiple" class="form-control tabs_list"></select></div>
        </div>
        <div class="row" style="margin-top: 5px;">
            <div class="col-sm-12"><label>توضیحات:</label> <textarea id="comment" name="comment" class="form-control">{{ $basic_data_value ? $basic_data_value->comment : '' }}</textarea></div>
        </div>
        <div class="row" style="margin-top: 5px;">
            <label>وضعیت:</label>
            <input type="radio" id="inactive_0" name="inactive" value="0"/>
            <label>فعال</label>
            <input type="radio" id="inactive_1" name="inactive" value="1"/>
            <label>غیرفعال</label>
        </div>
    </div>
</form>
<input type="hidden" id="parentid" name="parentid" value="  parentid  "/>

<script>

    $(document).ready(function () {
        @if($basic_data_value)
            if ({{ $basic_data_value->inactive }}) {
                $('#inactive_1').click();
            }
            else {
                $('#inactive_0').click();
            }
            @else
                $('#inactive_0').click();
        @endif
    });
</script>