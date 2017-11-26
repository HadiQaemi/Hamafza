<div style="padding: 10px;">
    <label>عنوان گروه:</label> <input type="text" id="title" name="title" class="form-control" style="width: 400px;" value="{!! @$basicdata['title'] !!}" /><br />
    <label>توضیحات:</label> <textarea id="comment" name="comment" class="form-control" style="width: 400px;">{!! @$basicdata['comment'] !!}</textarea><br />
    <label>وضعیت:</label> <input type="radio" id="0" name="inactive" value="0" checked="checked" /><label for="inactive_0">فعال</label> <input type="radio" id="inactive_1" name="inactive" value="1" /><label for="inactive_1">غیر فعال</label><br />
@if (empty($basicdata) && false)
    <br />
    <br />
    <br />
    <fieldset id="clone_client">
        <legend>ویژگی ها</legend>
        <style>
            .custom-row
            {
                margin-bottom: 5px;
            }
            .custom-row .minus
            {
                cursor: pointer;
            }
            .custom-row .fa-minus
            {
                margin-top: 13px;
            }
            .custom-row .col-sm-3
            {
                padding-right: 0;
            }
        </style>
        <script>
            function _clone()
            {
                e_clone = $('#clone').clone();
                e_clone.removeAttr('id');
                $('#clone_client').append(e_clone);
            }
            function _delete(thic)
            {
                $(thic).parent().remove();
            }
        </script>

        <div class="row custom-row">
            <div class="col-sm-3">
                <span>عنوان:</span>
                <a href="#" onclick="_clone();" style="float: left;"><i class=""></i> افزودن</a>
            </div>
        </div>
        <div style="display: none;">
            <div class="row custom-row" id="clone">
                <div class="col-sm-3"><input type="text" name="attr_title[]" class="form-control attr_title" /></div>
                <div class="col-sm-3 minus" onclick="_delete(this)"><i class="fa fa-minus"></i> حذف</div>
            </div>
        </div>
    </fieldset>
@endif
</div>
<script>
    $('#inactive_{!! @$basicdata['inactive'] !!}').attr('checked', 'checked');
    _clone();
</script>