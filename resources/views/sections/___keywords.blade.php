@section('keywords')
    <div class='text-content'>
        @if (isset($keywords) && is_array($keywords) && count($keywords)>1)
            <?php
            $last = count($keywords);
            $i = 0;
            $t = '';
            ?>
            <hr>
            <b>کلیدواژه‌ها:</b>
            @foreach($keywords as $item)
                @if(is_object($item))
                    <?php
                    $i++;
                    if ($i < $last)
                        $t .= "AddTags('" . $item->id . "','" . $item->title . "', 0); ";
                    else
                        $t .= "AddTags('" . $item->id . "','" . $item->title . "', 2); ";
                    ?>
                    <li style="display: inline;">
                        <a onclick="AddTags('{{ $item->id }}','{{ $item->title}}', 1); " class="FaqTags">{{ $item->title}}</a>
                    </li>
                @else
                    <?php
                    $i++;
                    if ($i < $last)
                        $t .= "AddTags('" . $item['id'] . "','" . $item['title'] . "', 0); ";
                    else
                        $t .= "AddTags('" . $item['id'] . "','" . $item['title'] . "', 2); ";
                    ?>
                    <li style="display: inline;">
                        <a onclick="AddTags('{{ $item['id'] }}','{{ $item['title']}}', 1); " class="FaqTags">{{ $item['title']}}</a>
                    </li>
                @endif
            @endforeach
            @if ($PageType!='user' &&  $i >1)
                <li style="display: inline;">
                    <a onclick="{{$t}}" class="FaqTags">هم‌رده‌ها (صفحات دارای همه کلیدواژه‌ها) </a>
                </li>
            @endif
        @endif
    </div>
    <script>
        function AddTags(Tid, Tname, val) {
            if (val == 1 || val == 3)
                $("#Navigatekeywords").tokenInput("clear");
            $("#Navigatekeywords").tokenInput("add", {id: Tid, name: Tname});
            $(".leftOver").animate({
                scrollTop: 0
            }, 'slow');
            if (val == 1) {
                $("#TagBut").trigger("click");
                $(".icon-tag").trigger("click");
            }
            if (val == 2) {
                $(".icon-tag").trigger("click");
                $("#TagBut").trigger("click");
            }
        }
    </script>
@stop

