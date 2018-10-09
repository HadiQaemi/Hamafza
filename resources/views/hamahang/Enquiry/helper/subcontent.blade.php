<style>
    .h-cells-div-num {
        font-size: 12px;
    }
    .h-cells-div-num{
        height: 120px;
        line-height: 120px;
    }
    .h-cells-div-num div{
        height: 25px;
        line-height: 25px;
    }
    .h-tag{
        margin-top: 0px;
    }
    .h-span-keyword {
        background-color: #e4e2e2;
        border-color: transparent;
        color: #5f6265;
        padding: 2px 7px
    }
</style>
@forelse ($posts as $post)
    @if (isset($post->user))

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin: 1px 0px;padding: 2px 0px;border-top: solid 1px #eee;border-bottom: solid 1px #eee;background: #fff;">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 10px 0px;">
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="height: 60px;line-height: 60px;">
                    <div class="h-cells-div">
                        <small>
                            <div class="h-cells-div-num">
                                <div>
                                    {!! $post->totalReward !!}
                                </div>
                                <div>
                                    {{ trans('enquiry.reward') }}
                                </div>
                            </div>
                        </small>
                    </div>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="height: 60px;line-height: 60px;">
                    <div class="h-cells-div" style="color: #6a737c;">
                        <small>
                            <div class="h-cells-div-num">
                                <div>
                                    @if ($post->voteSum >= 1000)
                                        {!! round($post->voteSum / 1000) . "K" !!}
                                    @else
                                        {!! $post->voteSum !!}
                                    @endif
                                </div>
                                <div>
                                    {{ trans('enquiry.vote') }}
                                </div>
                            </div>
                        </small>
                    </div>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="height: 60px;line-height: 60px;">
                    <div class="h-cells-div{!! $post->answerCount ? ($post->accepted ? '-special-b' : '-special-a') : null !!}">
                        <small>
                            <div class="h-cells-div-num">
                                <div>
                                    @if ($post->answerCount >= 1000)
                                        {!! round($post->answerCount / 1000) . "K" !!}
                                    @else
                                        {!! $post->answerCount !!}
                                    @endif
                                </div>
                                <div>
                                    {{ trans('enquiry.answer') }}
                                </div>
                            </div>
                        </small>
                    </div>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="height: 60px;line-height: 60px;">
                    <div class="h-cells-div">
                        <small>
                            <div class="h-cells-div-num">
                                <div>
                                    @if ($post->viewcount >= 1000)
                                        {!! round($post->viewcount / 1000) . "K" !!}
                                    @else
                                        {!! $post->viewcount !!}
                                    @endif
                                </div>
                                <div>
                                    {{ trans('enquiry.view') }}
                                </div>
                            </div>
                        </small>
                    </div>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style="height: 60px;line-height: 60px;">
                    <div>
                        {!! $post->isOwner ? '<img src="' . url('img/enquiry/enquiry-owner.png') . '" />' : null !!}
                        <a target="_blank" href="{!! route('enquiry.view', ['id' => $sid *10, 'ID' => $post->id]) !!}" data-id="{!! $post->id !!}">{!! $post->title ? strip_tags($post->title) : '[بدون عنوان]' !!}</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-2"></div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    @foreach ($post->keywords as $keyword)
                        <a href="#" class="h-tag" data-tagid="{!! $keyword->id !!}" data-tagtitle="{!! $keyword->title !!}"><span class="h-span-keyword"><i class="fa fa-tag" aria-hidden="true"></i> {!! $keyword->title !!}</span></a>
                    @endforeach
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-3">
                    {!! $post->jalaliRegDateName !!}
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-3">
                    {!! $post->user->SmallAvatar !!}<a href="{{ url($post->user->Uname) }}">{!! $post->user->Name !!} {!! $post->user->Family !!}</a>
                </div>
            </div>
        </div>
    @endif
@empty
    <div style="padding: 10px;">{!! Session::get('enquiry_body'); !!}</div>
@endforelse
<script>
    $(document).ready(function(){
        //$(".tab-content").css("background","#e9e9e9");
        $(".tab-content").css("overflow","hidden");
    });
</script>
