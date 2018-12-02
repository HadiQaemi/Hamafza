@php ($c = 0)
@foreach ($subjects as $subject)
    @php ($c++)
    @if (0 == $row_count) <div class="row"> @endif
        <div class="col-sm-{!! value_selector($layout - 3, [4, 3]) !!}">
            @php ($fields = $subject->listfields()->withPivot(['field_value'])->get()->toArray())
            <table class="table" style="">
                @if ($contents['image'])
                    <tr>
                        <td style="box-sizing: border-box; overflow: hidden; text-align: center; padding: 0; margin: 0;">
                            <a href="{!! url($subject->pages[0]->id) !!}" target="_blank">
                                <img class="{!! $animates ? 'zoom' : null !!}" src="{!! $subject->def_image_url !!}" style="background-size: cover; max-height: 150px;" />
                            </a>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td style="text-align: center;">
                        <a style="/*font-size: 44px;*/" href="{!! url($subject->pages[0]->id) !!}" target="_blank">{!! $subject->title !!}</a><br />
                        @if ($contents['abstract'] && $subject->description) {!! substr($subject->description, 0, 150) !!} ...<br />@endif
                        <br />
                        @if ($contents['fields'] && $fields)
                            @foreach($fields as $field)
                                @if($field['pivot']['field_value'])
                                    {!! $field['name'] !!}: <span style="color: #3eb332;">{!! $field['pivot']['field_value'] !!}</span><br />
                                @endif
                            @endforeach
                            <br />
                        @endif
                        @if ($contents['date'])
                            <div class="{!! 1 == $layout || 2 == $layout ? 'pull-left' : null !!}">
                                {!! explode('-', $subject->jalali_reg_date)[1] !!}<br />
                            </div>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    @php
        $row_count++;
        if ($layout == $row_count/* || $c == count($subjects)*/)
        {
            echo ('</div><div class="clearfix"></div>');
            $row_count = 0;
        }
    @endphp
@endforeach
