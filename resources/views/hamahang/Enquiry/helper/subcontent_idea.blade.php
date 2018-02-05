@forelse ($posts as $post)
    @if (isset($post->user))
        <br />
        <table width="100%">
            <tr>
                <td class="h-cells">
                    <div class="h-cells-div" style="color: #6a737c;">
                        <br />
                        <span class="h-cells-div-num">
                            @if ($post->voteSum >= 1000)
                                {!! round($post->voteSum / 1000) . "K" !!}
                            @else
                                {!! $post->voteSum !!}
                            @endif
                        </span><br />
                        <span>{{ trans('enquiry.vote') }}</span>
                    </div>
                </td>
                <td class="h-cells">
                    <div class="h-cells-div{!! $post->answerCount ? ($post->accepted ? '-special-b' : '-special-a') : null !!}">
                        <br />
                        <span class="h-cells-div-num">
                            @if ($post->answerCount >= 1000)
                                {!! round($post->answerCount / 1000) . "K" !!}
                            @else
                                {!! $post->answerCount !!}
                            @endif
                        </span><br />
                        <span>{{ trans('enquiry.answer_idea') }}</span>
                    </div>
                </td>
                <td class="h-cells" style="color: #9b764f;">
                    <div class="h-cells-div">
                        <br />
                        <span class="h-cells-div-num">
                            @if ($post->viewcount >= 1000)
                                {!! round($post->viewcount / 1000) . "K" !!}
                            @else
                                {!! $post->viewcount !!}
                            @endif
                        </span><br />
                        <span>{{ trans('enquiry.view') }}</span>
                    </div>
                </td>
                <td>
                    <div>
                        {!! $post->isOwner ? '<img src="' . url('img/enquiry/enquiry-owner.png') . '" />' : null !!}
                        <a target="_blank" href="{!! route('enquiry.view', ['id' => $sid *10, 'ID' => $post->id]) !!}" data-id="{!! $post->id !!}">{!! $post->title ? strip_tags($post->title) : '[بدون عنوان]' !!}</a>
                    </div>
                    <br />
                    @foreach ($post->keywords as $keyword)
                        <a href="#" class="h-tag" data-tagid="{!! $keyword->id !!}" data-tagtitle="{!! $keyword->title !!}"><span class="h-span-keyword"><i class="fa fa-tag" aria-hidden="true"></i> {!! $keyword->title !!}</span></a>
                    @endforeach
                </td>
            </tr>
            <tr style="border-bottom: lightgray solid 1px;">
                <td colspan="4"></td>
                <td><small>{!! $post->jalaliRegDateName !!}</small></td>
                <td style="text-align: left;">{!! $post->user->SmallAvatar !!}<a href="{{ url($post->user->Uname) }}">{!! $post->user->Name !!} {!! $post->user->Family !!}</a></td>
            </tr>
        </table>
    @endif
@empty
    <div style="padding: 10px;">{{ trans('enquiry.nocontent') }}</div>
@endforelse
