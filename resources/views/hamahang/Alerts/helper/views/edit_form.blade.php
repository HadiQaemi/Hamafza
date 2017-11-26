<tr>
    <td>عنوان</td>
    <td>
        <input type="text" size="100" dir="rtl" id="edit_form_alert_title" class="form-control required" name="name" value="{{ $alert->name }}">
    </td>
</tr>
<tr>
    <td>متن</td>
    <td>
        <textarea class="mceEditor" id="edit_form_comment" name="comment"> {{ $alert->comment }} </textarea>
    </td>
</tr>;