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
    @php
        $relations = '';
    @endphp
    @if (isset($keywords))
        @if ($keywords)
            <div class="text-content bottom_keywords_client">
                @foreach ($keywords as $item)
                    <span class="bottom_keywords one_keyword" data-id="{!! $item->id !!}" data-title="{!! $item->title !!}" data-relations='{!! $item->keyword_and_relations_json !!}'><i class="fa fa-tag"></i> <span style="color: #6391C5;">{!! $item->title !!}</span></span>
                    @php
                        $relations = $item->keyword_and_relations_json ;
                    @endphp
                @endforeach
                @if(count($keywords)>1)
                    <span class="bottom_keywords all_keywords" style="background: transparent" data-relations='{!! $relations !!}'><i class="fa fa-tags"></i> <span style="color: #6391C5;">همه موارد</span></span>
                @endif
            </div>
        @endif
    @endif
    <script>
        $(document).on('click', '.all_keywords', function()
        {
            thic = $(this);
            $.each(JSON.parse(thic.attr('data-relations')), function(id, text)
            {
                $("#Navigatekeywords").select2('trigger', 'select', {data: {id: id, text: text}});
                $('#TagBut').click();
            });
            $('[href="#tab3"]').click();
            $('#TagBut').click();
            $('.gm-scroll-view').css('width','350px');
            $('.ful-scrn').css('left','420px');
            $('#h_sidenav').css('z-index','1000000');
        });
        var btn = 0;
        $(document).on('click', '.one_keyword', function()
        {
            $("#Navigatekeywords").html('');
            thic = $(this);
            $('[href="#tab3"]').click();
            $('#TagBut').click();
            $("#Navigatekeywords").select2('trigger', 'select', {data: {id: thic.attr('data-id'), text: thic.attr('data-title')}});
            $('#TagBut').click();
            $("#Navigatekeywords").select2('trigger', 'select', {data: {id: thic.attr('data-id'), text: thic.attr('data-title')}});
            if((btn++)==1)
                $(this).click();
            $('.gm-scroll-view').css('width','350px');
            $('#h_sidenav').css('z-index','1000000');
        });
    </script>
@stop

