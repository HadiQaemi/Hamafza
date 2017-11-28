<div style="margin: 10px;">
    <div style="margin-bottom: 5px;">افزودن پیوند جدید:</div>
    <select class="form-control help_add" name="help_add" multiple="multiple"></select>
    <input type="button" class="btn btn-primary" value="ثبت" onclick="seealso_add('{!! enCode($help_id) !!}');" />
</div>
@if ($items->count())
    <table class="table">
        <tr>
            <td>{!! trans('help.row') !!}</td>
            <td>{!! trans('help.title') !!}</td>
            <td style="text-align: center;">{!! trans('help.operations') !!}</td>
        </tr>
        @foreach ($items as $item)
            @php (@$row++)
            <tr id="seealso_{!! enCode($help_id) . '_' . enCode($item->id) !!}">
                <td>
                    {!! $row !!}
                </td>
                <td>
                    <a class="jsPanels" href="{!! route('modals.help.view') . '?id=' . enCode($item->id) !!}">{!! $item->title !!} ({!! $item->usage_count !!} {!! trans('help.title_blocks') !!})</a>
                </td>
                <td style="text-align: center;">
                    <i class="fa fa-close fa-2x" style="color: red; cursor: pointer;" onclick="seealso_delete('{!! enCode($help_id) !!}', '{!! enCode($item->id) !!}');"></i>
                </td>
            </tr>
        @endforeach
    </table>
@else
    <hr />
    <div style="margin: 10px;">موردی برای نمایش وجود ندارد.</div>
@endif
<script>
    $('.help_add').select2
    ({
        minimumInputLength: 2,
        dir: 'rtl',
        width: '95%',
        ajax:
            {
                type: 'post',
                url: '{{ route('auto_complete.help') }}',
                dataType: 'json',
                quietMillis: 50,
                cache: true,
                data: function(term) { return { term: term }; },
                processResults: function(data)
                {
                    console.log(data);
                    var a = true;
                    return { results: data.results };
                }
            }
    });
</script>
