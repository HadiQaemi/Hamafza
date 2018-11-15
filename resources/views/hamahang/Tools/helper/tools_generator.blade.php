<div class="rightSubMenu">
    <div class="pull-right">
        @foreach ($groups as $group)
            <div class="MenuDiv">
                <a class="MenuHead" href="#{{ $group->name }}">{{ $group->name }}</a>
                <table class="MenuTBL">
                    <tbody>
                    @foreach ($group->tools as $tool)
                        @if(policy_CanView($tool->id,'\App\Models\Hamahang\Tools\Tools','\App\Policies\ToolPolicy'))
                            <tr>
                                <td>
                                    <div style="height: 20px;width: 20px;padding-top: 5px;color:#fff;font-size: 11pt!important">
                                        <span class="{{$tool->icon}}"></span>
                                    </div>
                                </td>
                                <td>
                                    @php($username = auth()->check()?auth()->user()->Uname:'NotLogin')
                                    @if(isset($tool->available->description))
                                        @if(trim($tool->available->description)!=='' && $tool->url_type==2)
                                            <a
                                                type="subject"
                                                val="1"
                                                uid="{{$username}}"
                                                sessid="0"
                                                sid="{{$option['subject_id']}}"
                                                data-href="{{url( $tool->url)}}"
                                                class="{{$tool->available->description}}"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title=""
                                                aria-describedby="ui-id-9">
                                                {{ $tool->title }}
                                            </a>
                                        @else
                                            <a style="float: right;"
                                               @if($tool->url_type==2)
                                               class=""
{{--                                               href="{{url( str_replace(['[username]','[subject_id]','[page_id]'],[$username,$option['subject_id'],$option['page_id']],$tool->url)) . (5 == $tool->id ? null : $get_url_str) }}"--}}
                                               href="{{url( str_replace(['[username]','[subject_id]','[page_id]'],[$username,$option['subject_id'],$option['page_id']],$tool->url)) . (5 == $tool->id ? null : '/'.$option['subject_id']) }}"
                                               @elseif($tool->url_type == 1 && $tool->available->modal==0)
                                               class="{{$tool->available->url}}"
                                               @foreach($option as $key=>$opt)
                                               data-{{$key}}="{{$opt}}"
                                               @endforeach
                                               href="#"
                                               @elseif ($tool->url_type == 1 && $tool->available->modal==1)
                                               class="jsPanels"
                                               href="/modals/{{$tool->available->url.$get_url_str}}"
                                               @endif
                                               title="{{ $tool->title }}">
                                                {{ $tool->title }}
                                            </a>
                                        @endif
                                    @else
                                        <a style="float: right;"
                                           @if($tool->url_type==2)
                                           @php($username = auth()->check()?auth()->user()->Uname:'NotLogin')
                                           class=""
                                           href="{{url( str_replace(['[username]','[subject_id]','[page_id]'],[$username,$option['subject_id'],$option['page_id']],$tool->url)) . (5 == $tool->id ? null : $get_url_str) }}"
                                           @elseif($tool->url_type == 1 && $tool->available->modal==0)
                                           class="{{$tool->available->url}}"
                                           @foreach($option as $key=>$opt)
                                           data-{{$key}}="{{$opt}}"
                                           @endforeach
                                           href="#"
                                           @elseif ($tool->url_type == 1 && $tool->available->modal==1)
                                           class="jsPanels"
                                           href="/modals/{{$tool->available->url.$get_url_str}}"
                                           @endif
                                           title="{{ $tool->title }}">
                                            {{ $tool->title }}
                                        </a>
                                    @endif


                                    {{--<button--}}
                                            {{--id="FollowPage"--}}
                                            {{--type="subject" val="0" uid="5083" sessid="0" sid="44449"--}}
                                            {{--data-href="http://localhost:8080/follow"--}}
                                            {{--class="btnActive  fa fa-anchor icon-rss"--}}
                                            {{--data-toggle="tooltip"--}}
                                            {{--data-placement="top"--}}
                                            {{--title=""--}}
                                            {{--aria-describedby="ui-id-18">--}}
                                    {{--</button>--}}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</div>
<script>
    $.each($('.MenuDiv').find('.MenuTBL').children(), function (index, value) {
        // console.log($(this).children().length);
        if ($(this).children().length < 1) {
            $(this).parent().parent().hide();
        }
    });
</script>