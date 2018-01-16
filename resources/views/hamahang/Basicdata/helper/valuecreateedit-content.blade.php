<div style="padding: 10px;">
    <label>عنوان:</label> <input type="text" id="title" name="title" class="form-control" style="width: 400px;" value="{!! @$basicdatavalue['title'] !!}" /><br />
    <label>مقدار:</label> <input type="text" id="value" name="title" class="form-control" style="width: 400px; direction: ltr;" value="{!! @$basicdatavalue['value'] !!}" /><br />
    <label>توضیحات:</label> <textarea id="comment" name="comment" class="form-control" style="width: 400px;">{!! @$basicdatavalue['comment'] !!}</textarea><br />
    <label>وضعیت:</label> <input type="radio" id="0" name="inactive" value="0" checked="checked" /><label for="inactive_0">فعال</label> <input type="radio" id="inactive_1" name="inactive" value="1" /><label for="inactive_1">غیر فعال</label>
    <input type="hidden" id="parentid" name="parentid" value="{!! @$parentid !!}" />
</div>
<script>
    $('#inactive_{!! @$basicdatavalue['inactive'] !!}').attr('checked', 'checked');
</script>