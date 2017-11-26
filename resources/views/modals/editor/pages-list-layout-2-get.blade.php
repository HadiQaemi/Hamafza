@foreach ($subjects as $subject)
    @php ($fields = $subject->listfields()->withPivot(['field_value'])->get()->toArray())
    <table class="table" style="border: none;">
        <tr>
            @if ($contents['image'])
                <td class="col-sm-2" style="box-sizing: border-box; overflow: hidden; border: none;">
                    <a href="{!! url($subject->pages[0]->id) !!}" target="_blank">
                        <img class="{!! $animates ? 'zoom' : null !!}" src="{!! $subject->def_image_url !!}" width="150" />
                    </a>
                </td>
            @endif
            <td class="col-sm-10" style="border: none;">
                <a href="{!! url($subject->pages[0]->id) !!}" target="_blank">{!! $subject->title !!}</a><br />
                @if ($contents['abstract'] && $subject->description) {!! substr($subject->description, 0, 150) !!} ...<br />@endif
                <br />
                @if ($contents['fields'] && $fields)
                    @foreach($fields as $field)
                        @if($field['pivot']['field_value'])
                            {!! $field['name'] !!}: {!! $field['pivot']['field_value'] !!}<br />
                        @endif
                    @endforeach
                    {{--
                    <table class="table">
                        @foreach($fields as $field)
                            <tr>
                                <td>{!! $field['name'] !!}:</td>
                                <td>{!! $field['pivot']['field_value'] !!}</td>
                            </tr>
                        @endforeach
                    </table><br />
                    --}}
                    <br />
                @endif
                @if ($contents['date'])
                    <div class="pull-left">
                        {!! explode('-', $subject->jalali_reg_date)[1] !!}<br />
                    </div>
                @endif
            </td>
        </tr>
    </table>
@endforeach