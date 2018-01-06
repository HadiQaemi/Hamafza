<script>

    var i = 0;

    $(document).ready(function()
    {
        $('[name^=relations]').empty();
        e_form_keyword = $('.form_keyword');
        e_jspanel = e_form_keyword.parent().parent();
        e_jspanel_header = e_jspanel.find('.jsPanel-hdr > .jsPanel-headerbar > .jsPanel-titlebar > .jsPanel-title');
        e_jspanel_content = e_jspanel.find('.jsPanel-content');
        e_jspanel_footer = e_jspanel.find('.jsPanel-ftr');
        e_jspanel_close = e_jspanel_header.find('.jsglyph-close');
        //e_title = $('#title');
        //e_short_code = $('#short_code');
        //e_description = $('#description');
        e_subject_ids = $('#subject_ids');
        e_id = $('#id');
        e_subject_ids.select2();
        @if ($is_edit && $keyword)
            @if ($keyword->relations_by_type)
                @foreach ($keyword->relations_by_type as $relation_k => $relation)
                    relation_clone('{!! $relation_k !!}');
                @endforeach
            @endif
        @else
            relation_clone(0);
        @endif
    });

    function relation_clone(selected)
    {
        i++;
        tr = $($.parseHTML
        (
            '<tr>' +
                '<td>' +
                '<select class="form-control relation_types" name="relations[' + i + '][type]">' +
                    @foreach (config('keyword.relation_types') as $value => $title)
                        '<option value="{!! $value !!}"' + ('{!! $value !!}' == selected ? ' selected="selected"' : '') + '>{!! $title !!}</option>' +
                    @endforeach
                '</select>' +
            '</td>' +
            '<td>' +
                '<select class="form-control relation_values" name="relations[' + i + '][values][]" multiple="multiple">' +
                    @if ($is_edit)
                        relation_clone_get_options(selected) +
                    @endif
                '</select>' +
            '</td>' +
            '<td>' +
                '<i class="fa fa-close relation_types_delete" onclick="relation_delete(this);"></i>' +
            '</td>' +
        ' </tr>'
        ));
        tr.find('.relation_types').select2({width: '100%', dir: 'rtl'});
        make_auto_compelete(tr.find('.relation_values'));
        $('.table_relations').append(tr);
    }

    function relation_clone_get_options(selected)
    {
        r = '';
        switch (selected)
        {
            @if ($is_edit && $keyword)
                @if ($keyword->relations_by_type)
                    @foreach ($keyword->relations_by_type as $relation_k => $relation)
                        case '{!! $relation_k !!}':
                        {
                            @foreach ($relation['values'] as $value)
                                @php ($keyword_from_value = \App\Models\hamafza\Keyword::find($value))
                                @if ($keyword_from_value)
                                    r += '<option value="exist_in{!! $value !!}" selected="selected">{!! $keyword_from_value->title !!}</option>';
                                @endif
                            @endforeach
                            break;
                        }
                    @endforeach
                @endif
            @else
                default:
                {
                    break;
                }
            @endif
        }
        return r;
    }

    function relation_delete(thic)
    {
        var tr = $(thic).closest('tr');
        tr.find('select').empty();
        tr.remove();
    }

    function keyword_addedit(thic, add_new)
    {
        $(thic).attr('disabled', 'disabled');
        data = e_form_keyword.serialize() + '&is_approved=' + $('input[name="is_approved"]:checked').val();
        $.ajax
        ({
            type: 'POST',
            dataType: 'json',
            url: '{!! route('modals.keyword_add_edit') !!}',
            data: data,
            success: function(data)
            {
                if (data.success)
                {
                    jQuery.noticeAdd
                    ({
                        text: 'انجام شد.',
                        stay: false,
                        type: 'success'
                    });
                    if (add_new)
                    {
                        keyword_form_reload(data.result[0]);
                    } else
                    {
                        e_jspanel.fadeOut(function()
                        {
                            e_jspanel_close.click();
                        });
                    }
                    if (typeof DataTables_KeywordsList_reload == 'function')
                    {
                        DataTables_KeywordsList_reload();
                    }
                } else
                {
                    messageModal('fail', 'خطا', data.result);
                    $(thic).removeAttr('disabled');
                }
            },
        });
    }

    function make_auto_compelete(target)
    {
        target.select2
        ({
            minimumInputLength: 3,
            dir: 'rtl',
            width: '100%',
            tags: true,
            ajax:
            {
                url: "{{route('auto_complete.keywords')}}",
                dataType: "json",
                type: "POST",
                quietMillis: 150,
                data: function (term)
                {
                    return { term: term };
                },
                results: function (data)
                {
                    return {
                        results: $.map(data, function (item)
                        {
                            return { text: item.text, id: item.id }
                        })
                    };
                }
            }
        });
    }

    function keyword_form_reload(selected)
    {
        e_jspanel_content.html('<div class="loader"></div>');
        $.ajax
        ({
            type: 'POST',
            dataType: 'json',
            url: '{!! route('modals.keyword_add_edit_form') !!}',
            data: data + '&thesauruses_selected=' + selected,
            success: function(data)
            {
                if (data)
                {
                    e_jspanel_header.html(data.header);
                    e_jspanel_content.html(data.content);
                    e_jspanel_footer.html(data.footer);
                } else
                {

                }
            },
        });
    }

</script>