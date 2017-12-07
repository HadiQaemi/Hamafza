@section('keywords')
    <style>
        .bottom_keywords_client
        {
            margin: 10px 20px 0 0;
            padding: 0 0 20px 10px;
        }
        .bottom_keywords
        {
            background-color: #E8E8E8;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 5px;
            padding: 5px;
        }
    </style>
    <div class="text-content bottom_keywords_client">
        @foreach ($keywords as $item)
            <span class="bottom_keywords" data-id="{!! $item->id !!}" data-title="{!! $item->title !!}" data-relations='{!! $item->keyword_and_relations_json !!}'><i class="fa fa-tag{!! $item->keyword_has_relation ? 's' : null !!}"></i> {!! $item->title !!}</span>
        @endforeach
    </div>
    <script>
        $(document).on('click', '.bottom_keywords', function()
        {
            thic = $(this);
            $.each(JSON.parse(thic.attr('data-relations')), function(id, text)
            {
                $("#Navigatekeywords").select2('trigger', 'select', {data: {id: id, text: text}});
            });
            $('[href="#tab3"]').click();
            $('#TagBut').click();
        });
    </script>
@stop

