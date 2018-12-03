@php ($types = \App\Models\hamafza\SubjectType::all())

@include('layouts.master_tinymce')

<style>
    table#table_pages_list
    {
        display: none;
    }
    table#table_pages_list tr td
    {
        vertical-align: middle;
    }
</style>

<script>
    $(document).ready(function()
    {
        e_count_num = $('#count_num');
        e_all_links = $('#all_links');
        e_layout_1 = $('#layout_1');
        e_layout_2 = $('#layout_2');
        e_layout_3 = $('#layout_3');
        e_layout_4 = $('#layout_4');
        e_content_type_1 = $('#content_type_1');
        e_content_type_2 = $('#content_type_2');

        $(document).on('change', '[name=count]', function()
        {
            var thic = $(this);
            if (1 == thic.val())
            {
                e_count_num.val('');
                e_all_links.removeAttr('checked');
                e_count_num.attr('disabled', 'disabled');
                e_all_links.attr('disabled', 'disabled');
            } else if (2 == thic.val())
            {
                e_count_num.removeAttr('disabled');
                e_all_links.removeAttr('disabled');
            }
        });

        $(document).on('click', '[id^=layout_]', function()
        {
            var e_contents_0 = $('#contents_0');
            var e_content_type = $('[id^=content_type_]');
            switch ($(this).val())
            {
                case '1':
                {
                    e_contents_0.change();
                    e_content_type_1.click();
                    e_content_type.attr('disabled', 'disabled');
                    break;
                }
                case '2':
                case '3':
                case '4':
                {
                    e_content_type.removeAttr('disabled');
                    break;
                }
            }
        });
        $(document).on('change', '#contents_0', function()
        {
            var thic = $(this);
            if (thic.is(':checked'))
            {
                $('#animates_0').removeAttr('disabled');
            } else
            {
                $('#animates_0').removeAttr('checked');
                $('#animates_0').attr('disabled', 'disabled');
            }
        });

        e_layout_1.click();

        $('#types').select2({'width': '100%'});
        $('#keywords').select2
        ({
            minimumInputLength: 3,
            dir: 'rtl',
            width: '100%',
            tags: false,
            ajax:
            {
                dataType: 'json',
                quietMillis: 150,
                type: 'post',
                url: '{{ route('auto_complete.keywords') }}',
                data: function(term)
                {
                    return {term: term};
                }, results: function(data)
                {
                    return { results: $.map(data, function(item) { return {text: item.text, id: item.id} }) };
                }
            }
        });
        $('#admins').select2
        ({
            minimumInputLength: 2,
            dir: 'rtl',
            width: '100%',
            ajax:
            {
                cache: true,
                dataType: 'json',
                quietMillis: 50,
                type: 'post',
                url: '{{ route('auto_complete.users') }}',
                data: function(term)
                {
                    return {term: term};
                }, processResults: function(data)
                {
                    console.log(data);
                    return {results: data.results};
                }
            }
        });
        $('#table_pages_list').fadeIn();
    });
</script>

<table class="table" id="table_pages_list">
    <tr>
        <td class="no-border"><label for="types">نوع موضوع</label></td>
        <td class="no-border">
            <select class="form-control" id="types" multiple="multiple">
                @foreach ($types as $type)
                    <option value="{!! $type->id !!}">{!! $type->name !!}</option>
                @endforeach
            </select>
        </td>
    </tr>
    <tr>
        <td class="no-border"><label for="keywords">کلیدواژه</label><br /><br /></td>
        <td class="no-border">
            <select class="form-control" id="keywords" multiple="multiple"></select><br />
            <div style="margin-top: 10px;">
                <input type="radio" id="keywords_and_or_0" value="0" name="keywords_and_or" checked="checked" /><label for="keywords_and_or_0">حداقل یکی از کلیدواژه ها</label>
                <input type="radio" id="keywords_and_or_1" value="1" name="keywords_and_or" /><label for="keywords_and_or_1">همه کلیدواژه ها</label>
            </div>
        </td>
    </tr>
    <tr>
        <td class="no-border"><label for="admins">مدیر</label></td>
        <td class="no-border"><select class="form-control" id="admins" multiple="multiple"></select></td>
    </tr>
    <tr>
        <td><label for="count">تعداد</label></td>
        <td>
            <input type="radio" name="count" id="count_1" value="1" checked="checked" /><label for="count_1">همه صفحات</label>
            <input type="radio" name="count" id="count_2" value="2" /><label for="count_2"><span>تا <input type="text" class="form-control" id="count_num" name="count_num" style="display: inline; width: 50px;" disabled="disabled" /> صفحه</span></label>
            <input type="checkbox" id="all_links" value="1" disabled="disabled" /><label for="all_links">پیوند همه صفحات</label>
        </td>
    </tr>
    <tr>
        <td><label for="layout_1">چیدمان</label></td>
        <td>
            <input type="radio" name="layout" id="layout_1" value="1" checked="checked" /><label for="layout_1">سطری</label>
            <input type="radio" name="layout" id="layout_2" value="2" /><label for="layout_2">ردیفی</label>
            <input type="radio" name="layout" id="layout_3" value="3" /><label for="layout_3">3 ستونی</label>
            <input type="radio" name="layout" id="layout_4" value="4" /><label for="layout_4">4 ستونی</label>
        </td>
    </tr>
    <tr>
        <td class="no-border"><label for="arrange">ترتیب</label></td>
        <td class="no-border">
            <input type="radio" name="arrange" id="arrange_1" value="1" checked="checked" /><label for="arrange_1">زمان ثبت</label>
            <input type="radio" name="arrange" id="arrange_2" value="2" /><label for="arrange_2">الفبایی</label>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="order" id="order_3" value="1" checked="checked" /><label for="order_3">نزولی</label>
            <input type="radio" name="order" id="order_4" value="2" /><label for="order_4">صعودی</label>
        </td>
    </tr>
    <tr>
        <td class="no-border"><label for="arrange">محتوا</label></td>
        <td class="no-border">
            <input type="radio" name="content_type" id="content_type_1" onclick="$('[id^=contents_]').removeAttr('checked').attr('disabled', 'disabled');" /><label for="content_type_1">فقط عنوان</label>
            <input type="radio" name="content_type" id="content_type_2" onclick="$('[id^=contents_]').removeAttr('disabled');" checked="checked" /><label for="content_type_2">عنوان به همراه</label>
            <input type="checkbox" id="contents_0" /><label for="contents_0">تصویر</label>
            <input type="checkbox" id="contents_1" /><label for="contents_1">مشخصه ها</label>
            <input type="checkbox" id="contents_2" /><label for="contents_2">چکیده</label>
            <input type="checkbox" id="contents_3" /><label for="contents_3">تاریخ</label>
        </td>
    </tr>
    <tr>
        <td class="no-border"><label for="arrange">انیمیشن</label></td>
        <td class="no-border">
            <input type="checkbox" id="animates_0" name="animate" /><label for="animates_0">زوم تصویر</label>
        </td>
    </tr>
</table>
