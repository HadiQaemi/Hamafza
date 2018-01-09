@php
    $thesauruses_selected = [];
    if ($is_edit)
    {
        if (isset($keyword))
        {
            if (isset($keyword->thesauruses))
            {
                $thesauruses_selected = array_column($keyword->thesauruses->toArray(), 'subject_id');
            }
        }
    } else
    {
        $thesauruses_selected = $recursive_thesauruses_selected;
    }
@endphp
<form class="form-horizontal form_keyword" style="padding: 10px;">
    <table class="table" style="border: 0;">
        <colgroup>
            <col style="width: 15%;" />
            <col style="width: 53%;" />
            <col style="width: 30%;" />
        </colgroup>
        <tr>
            <td><label for="title">عنوان</label></td>
            <td><input type="text" class="form-control" id="title" name="title" value="{!! $is_edit && $keyword ? $keyword->title : null !!}" /></td>
            <td rowspan="2"></td>
        </tr>
        <tr>
            <td><label for="subject_ids">اصطلاح‌نامه</label></td>
            <td colspan="2">
                <select id="subject_ids" name="subject_ids[]" class="form-control" multiple>
                    @foreach ($thesauruses as $thesaurus)
                        <option value="{!! $thesaurus->id !!}"{!! in_array($thesaurus->id, $thesauruses_selected) ? ' selected="selected"' : null !!}>{!! $thesaurus->title !!}</option>
                    @endforeach
                </select>
            </td>
        </tr>
    </table>
    <table class="table table_relations" style="border: 0;">
        <colgroup>
            <col style="width: 25%;" />
            <col style="width: 70%;" />
            <col style="width: 3%;" />
        </colgroup>
        <tr>
            <th colspan="3">روابط</th>
        </tr>
    </table>
    <button class="btn btn-success pull-right" type="button" onclick="relation_clone();">
        <i class="fa fa-plus relation_types_clone"></i> افزودن
    </button>
    <div class="clearfix"></div>
    <br />
    <table class="table" style="border: 0;">
        <tr>
            <th>
                <input type="checkbox" id="is_morajah" name="is_morajah"{!! $is_edit && $keyword ? ($keyword->is_morajah ? ' checked="checked"' : null) : null !!}/>
                <label for="is_morajah">انتخاب به عنوان مرجح</label>
            </th>
        </tr>
    </table>
    <table class="table" style="border: 0;">
        <colgroup>
            <col style="width: 15%;" />
            <col style="width: 83%;" />
        </colgroup>
        <tr>
            <td><label for="short_code">کد</label></td>
            <td><input type="text" class="form-control" id="short_code" name="short_code" value="{!! $is_edit && $keyword ? $keyword->short_code : null !!}" /></td>
        </tr>
        <tr>
            <td><label for="description">توضیح (یادداشت دامنه)</label></td>
            <td colspan="2"><textarea class="form-control" id="description" name="description">{!! $is_edit && $keyword ? $keyword->description : null !!}</textarea></td>
        </tr>
    </table>
    <input type="hidden" class="form-control" id="title_old" name="title_old" value="{!! $is_edit && $keyword ? $keyword->title : null !!}" />
    <input type="hidden" class="form-control" id="id" name="id" value="{!! $is_edit && $keyword ? $keyword->id : 0 !!}" />
</form>