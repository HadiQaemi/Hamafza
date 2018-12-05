<div class="h-content">
    <div id="tab" style="width: 100%;" class="data-delete{!! $post->id !!}" data-type="post">
        <!-- post -->
        <div>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 15%; text-align: center; padding: 10px 10px 10px 25px; ">
                        {!! $post->user->LargAvatar !!}<br/>
                        <div style="margin-top: 5px;"><a href="{{ url($post->user->Uname) }}">{!! $post->user->Name !!} {!! $post->user->Family !!}</a></div>
                        @if (!$post->isOwner)
                            <div style="text-align: center; vertical-align: top; padding-top: 10px;">
                                <i class="fa fa-sort-asc fa-4x vote-up{!! $post->id !!}" aria-hidden="true" data-target_id="{!! $post->id !!}" data-type="+1" style="cursor: pointer; color: {!! +1 == $post->hasVoted ? 'orange' : 'lightgrey' !!};"></i>
                                <span style="padding: -20px; line-height: 0; font-size: large;"><div class="vote-count{!! $post->id !!}" style="direction: ltr;">{!! strip_tags($post->voteSum) !!}</div></span>
                                <i class="fa fa-sort-desc fa-4x vote-down{!! $post->id !!}" aria-hidden="true" data-target_id="{!! $post->id !!}" data-type="-1" style="cursor: pointer; color: {!! -1 == $post->hasVoted ? 'orange' : 'lightgrey' !!};"></i>
                            </div>
                        @endif
                    </td>
                    <td style="width: 85%; padding: 10px 0 25px 25px; text-align: justify; line-height: 180%;">
                        @if ($post->accepted)<i class="fa fa-check-circle" aria-hidden="true" style="color: #3eb332;"></i> @endif<strong>{!! strip_tags($post->title) !!}</strong><br/>
                        <br/>
                        {!! strip_tags($post->desc) !!}<br/>
                        <br/>
                        <table width="100%">
                            <tr>
                                <td width="85%" style="padding: 0; margin: 0;">
                                    @foreach ($post->keywords as $keyword)
                                        <a href="{!! route('page', ['id' => $sid*10, 'tagid' => $keyword->id]) !!}" class="h-tag"><span class="h-span-keyword"><i class="fa fa-tag" aria-hidden="true"></i> {!! $keyword->title !!}</span></a>
                                    @endforeach
                                </td>
                                <td width="15%" style="padding: 0; margin: 0; text-align: left; padding-top: 10px;">
                                    @if (!$post->accepted && $post->totalReward > 0)
                                        <img src="{!! url('img\enquiry\reward-icon.png') !!}"/> {{ trans('enquiry.reward') }}: <span style="font-size: medium;">{!! $post->totalReward !!}</span> {{ trans('enquiry.emtiaz') }}
                                    @endif
                                </td>
                            </tr>
                        </table>
                        @if (isset($Files) && count($Files) > 0 && !empty($Files))
                            <div class="spacer">
                                <div class="panel panel-light fix-box1">
                                    <div class="fix-inr1" style="height: 100%">
                                        <div style="padding: 0;" class="panel-heading panel-heading-darkblue"></div>
                                        <div class="panel-body text-decoration">
                                            <b>{{ trans('label.Files') }}</b>
                                            @foreach ($Files as $file)
                                                <li>
                                                    <div style="display: inline-block;height: 10px; margin: 5px">
                                                        <span style="font-size: 15pt;height: 10px;" class="icon icon-{{$file->extension}}"></span>
                                                    </div>
                                                    <a href="{{route('FileManager.DownloadFile',['type'=>'ID','id'=>enCode($file->id)])}}/?&fname={{ $file->originalName }}">
                                                        <span>{{  $file->originalName }}</span>
                                                        <span style="font-size: 7pt;margin-right:10px">{{  $file->size }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
                <tr style="background-color: #eeeeee;">
                    <td></td>
                    <td style="border: 1px #9db8d5 solid; border-top: none; border-bottom: none;">
                        <div style="float: right;">
                            <a href="#" class="PostLike" like="{!! $post->IsLiked ? 1 : 0 !!}" postid="{!! $post->id !!}">{!! $post->IsLiked ? trans('enquiry.like') : trans('enquiry.unlike') !!} </a> -
                            <a href="#" postid="Comment_{!! $post->id !!}" class="Comment_Foc">{{ trans('enquiry.ezharnazar') }}</a> -
                            <a class="jsPanels" href="{!! route('modals.post_share', [ 'postid' => $post->id ]) !!}">{{ trans('enquiry.share') }}</a>
                        </div>
                        @php ($is_administrator = \Laratrust::hasRole('administrator'))
                        @if ($post->isOwner || $is_administrator)
                            @if (0 == $post->answerCount || $is_administrator)
                                <div style="margin-right: 10px; float: left;" class="fonts icon-hazv CommentDelicn delete-post" page="Post" action="delete" id="{!! $post->id !!}"></div>
                            @endif
                        @endif
                        <div style="float: left;">{!! $post->jalaliRegDateName !!}</div>
                        <div class="clear"></div>
                    </td>
                </tr>
                <tr style="background-color: #eeeeee;">
                    <td></td>
                    <td style="border: 1px #9db8d5 solid; border-top: none; border-bottom: none;">
                        <div id="{!! $post->id !!}">
                            <div class="h-new-comment">
                                @forelse ($post->comments as $comment)
                                    <div style="width: 100%; margin: 5px 0; background-color: #f4f4f4; padding: 5px;">
                                        <input class="Postid" value="{!! $comment->id !!}" type="hidden">
                                        <div style="float: right; margin-right: 5px;">{!! isset($comment->user->smallAvatar2) ? $comment->user->smallAvatar2 : '' !!}</div>
                                        <div style="float: left; width: 93%; margin: auto; padding: 5px; min-height: 30px; text-align: justify;">
                                            {!! strip_tags($comment->comment) !!}
                                        </div>
                                        <div class="clear"></div>
                                        <div style="float: left; height: 20px;">
                                            @if ($comment->isOwner)
                                                <div style="margin-right: 10px; float: left;" class="fonts icon-hazv CommentDelicn" page="comment" action="delete" id="{!! $comment->id !!}"></div>
                                            @endif
                                            <div style=" float: left;">{!! $comment->jalaliRegDateName !!}</div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                            <span style="margin-right: 10px;">{!! auth()->user()->smallAvatar2 !!}</span>
                            <input class="CommentSend2 form-control" postid="{!! $post->id !!}" id="Comment_{!! $post->id !!}" placeholder="{{ trans('enquiry.writeyourcomment') }}" type="text" style="width: 90%; display: inline-block;">
                            <div class="addcomment">
                                <span style="margin-right: 10px;">{!! auth()->user()->smallAvatar2 !!}</span>
                                <input id="CommentSend{!! $post->id !!}" class="CommentSend form-control" postid="{!! $post->id !!}" id="Comment_{!! $post->id !!}" placeholder="{{ trans('enquiry.writeyourcomment') }}" type="text" style="width: 90%; display: inline-block;">
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <!-- /post -->
        <!-- answers -->
        @foreach ($post->answers as $answer)
            <div style="background-color: #eeeeee; height: 50px;"></div>
            <div class="data-delete{!! $answer->id !!}">
                @if(isset($answer->user->Uname))
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 15%; text-align: center; padding: 10px 10px 10px 25px; ">
                                {!! isset($answer->user->LargAvatar) ? $answer->user->LargAvatar : '' !!}<br/>
                                <div style="min-width: 132px;">
                                    <div style="margin-top: 5px;"><a href="{{ url($answer->user->Uname) }}">{!! $answer->user->Name !!} {!! $answer->user->Family !!}</a></div>
                                @if (!$answer->isOwner)
                                    <div class="pull-left" style="text-align: center; vertical-align: top; padding-top: 20px; margin-left: 30px;">
                                        <i class="fa fa-sort-asc fa-4x vote-up{!! $answer->id !!}" aria-hidden="true" data-target_id="{!! $answer->id !!}" data-type="+1" style="cursor: pointer; color: {!! +1 == $answer->hasVoted ? 'orange' : 'lightgrey' !!};"></i><span style="font-size: large;"><div class="vote-count{!! $answer->id !!}" style="direction: ltr;">{!! strip_tags($answer->voteSum) !!}</div></span>
                                        <i class="fa fa-sort-desc fa-4x vote-down{!! $answer->id !!}" aria-hidden="true" data-target_id="{!! $answer->id !!}" data-type="-1" style="cursor: pointer; color: {!! -1 == $answer->hasVoted ? 'orange' : 'lightgrey' !!};"></i>
                                    </div>
                                    <div class="pull-left" style="text-align: center; vertical-align: top; padding-top: 55px; margin-left: 15px;">
                                    @if ($answer->accepted)
                                        <i class="fa fa-check-circle fa-4x" style="color: #3eb332;"></i>
                                    @elseif (!$post->accepted && $post->isOwner)
                                        <i class="fa fa-check-circle fa-4x clickable-accept" style="cursor: pointer; color: lightgray;" postid="{!! $answer->id !!}"></i>
                                        @endif
                                    </div>
                                @elseif ($post->accepted)
                                    <i class="fa fa-check-circle fa-4x" style="color: #3eb332;"></i>
                                    @endif
                                </div>
                            </td>
                            <td style="width: 85%; padding: 10px 0 25px 25px; text-align: justify; line-height: 180%;">
                                {!! strip_tags($answer->desc) !!}<br/>
                                <br/>
                            </td>
                        </tr>
                        <tr style="background-color: #eeeeee;">
                            <td></td>
                            <td style="border: 1px #9db8d5 solid; border-top: none; border-bottom: none;">
                                <div style="float: right;">
                                    <a href="#" class="PostLike" like="{!! $answer->IsLiked ? 1 : 0 !!}" postid="{!! $answer->id !!}">{!! $answer->IsLiked ? trans('enquiry.like') : trans('enquiry.unlike') !!} </a> -
                                    <a href="#" postid="Comment_{!! $answer->id !!}" class="Comment_Foc">{{ trans('enquiry.ezharnazar') }}</a> -
                                    <a class="jsPanels" href="{!! route('modals.post_share', [ 'postid' => $answer->id ]) !!}">{{ trans('enquiry.share') }}</a>
                                </div>
                            @if ($answer->isOwner)
                            @if (!$answer->accepted)
                                    <div style="margin-right: 10px; float: left;" class="fonts icon-hazv CommentDelicn delete-post" page="Post" action="delete" id="{!! $answer->id !!}"></div>
                                @endif
                                @endif
                                <div style="float: left;">{!! $answer->jalaliRegDateName !!}</div>
                                <div class="clear"></div>
                            </td>
                        </tr>
                        <tr style="background-color: #eeeeee;">
                            <td></td>
                            <td style="border: 1px #9db8d5 solid; border-top: none; border-bottom: none;">
                                <div id="{!! $answer->id !!}">
                                    <div class="h-new-comment">
                                    @forelse ($answer->comments as $comment)
                                            <div style="width: 100%; margin: 5px 0; background-color: #f4f4f4; padding: 5px;">
                                                <input class="Postid" value="{!! $comment->id !!}" type="hidden">
                                                <div style="float: right; margin-right: 5px;">{!! auth()->user()->smallAvatar2 !!}</div>
                                                <div style="float: left; width: 93%; margin: auto; padding: 5px; min-height: 30px; text-align: justify;">
                                                    {!! strip_tags($comment->comment) !!}
                                                </div>
                                                <div class="clear"></div>
                                                <div style="float: left; height: 20px;">
                                                @if ($comment->isOwner)
                                                    <div style="margin-right: 10px; float: left;" class="fonts icon-hazv CommentDelicn" page="comment" action="delete" id="{!! $comment->id !!}"></div>
                                                    @endif
                                                    <div style=" float: left;">{!! $comment->jalaliRegDateName !!}</div>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                    <span style="margin-right: 10px;">{!! auth()->user()->smallAvatar2 !!}</span>
                                    <input class="CommentSend2 form-control" postid="{!! $answer->id !!}" id="Comment_{!! $answer->id !!}" placeholder="{{ trans('enquiry.writeyourcomment') }}" type="text" style="width: 90%; display: inline-block;">
                                    <div class="addcomment">
                                        <span style="margin-right: 10px;">{!! auth()->user()->smallAvatar2 !!}</span>
                                        <input id="CommentSend{!! $answer->id !!}" class="CommentSend form-control" postid="{!! $answer->id !!}" id="Comment_{!! $answer->id !!}" placeholder="{{ trans('enquiry.writeyourcomment') }}" type="text" style="width: 90%; display: inline-block;">
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                @endif
            </div>
        @endforeach
    <!-- /answers -->
    <!-- post new answer -->
    @if (!$post->hasAnswered && !$post->isOwner && !$post->accepted)
        <table style="width: 100%; background-color: #eeeeee;" class="post-new-answer">
            <tr>
                <td colspan="2" style="padding-top: 50px;">
                    <fieldset>
                        <legend>{{ trans('enquiry.sendanswer') }}:</legend>
                        <textarea class="form-control" placeholder="{{ trans('enquiry.writeyouranswer') }}" style="margin-bottom: 10px;" rows="10" id="post_desc"></textarea>
                        <input class="btn btn-primary" type="submit" value="{{ trans('enquiry.submitanswer') }}" style="float: left;" id="post_answer">
                    </fieldset>
                </td>
            </tr>
        </table>
        @endif
        <!-- /post new answer -->
    </div>
</div>