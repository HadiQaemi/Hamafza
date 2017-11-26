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
                                <a style="float: right;"
                                   @if($tool->url_type==2)
                                   @php($username = auth()->check()?auth()->user()->Uname:'NotLogin')
                                   class=""
                                   href="{{url( str_replace(['[username]','[subject_id]','[page_id]'],[$username,$option['subject_id'],$option['page_id']],$tool->url)).$get_url_str }}"
                                   @elseif($tool->url_type == 1 && $tool->available->modal==0)
                                   class="{{$tool->available->url}}"
                                   href="#"
                                   @elseif ($tool->url_type == 1 && $tool->available->modal==1)
                                   class="jsPanels"
                                   href="/modals/{{$tool->available->url.$get_url_str}}"
                                   @endif
                                   title="{{ $tool->title }}"> {{ $tool->title }}
                                </a>
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
    $.each($('.MenuDiv').find('.MenuTBL').children(), function( index, value ) {
       // console.log($(this).children().length);
        if($(this).children().length < 1){
            $(this).parent().parent().hide();
        }
    });
</script>