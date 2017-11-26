<div class="btn-group pull-right frst-wdt mr">
    <button type="button" id="rSubMenuBtn" class="btn  fa fa-align-justify icon-reorder" data-icon="U+E0CC" data-toggle="tooltip" data-placement="top" title="ابزارها"></button>
</div>
@if(!Auth::check())
    @if($type=='Page')
        <div class="btn-group pull-right mr">
            <button type="button" class="btn fa fa-anchor icon-pasandidan login" data-toggle="modal" data-target="#loginWmessage" data-placement="top" title="{{trans('labels.Like')}}"></button>
        </div>
    @endif
    <div class="btn-group pull-right mr">
        <button type="button" class="btn fa fa-anchor icon-rss login" data-toggle="modal" data-target="#loginWmessage" data-placement="top" title="{{trans('labels.unfollow')}}"></button>
    </div>
    @if(\Request::route()->getName() != 'page.forum')
    <div class="btn-group pull-right mr">
        <button type="button" class="btn fa fa-anchor icon-ezhare-nazar login" data-toggle="modal" data-target="#loginWmessage" data-placement="top" title="{{trans('labels.comment')}}"></button>
    </div>
    @endif
@else
    @if($type=='Page')
        @if ($vals['like'] == '1')
            <div class="btn-group pull-right mr">
                <button id="LikePage" type="subject" val="0"
                @foreach($params as $k=>$v)
                    {{$k}}="{{$v}}"
                @endforeach
                data-href="{{route('hamafza.page_like')}}" type="button" class="btnActive  fa fa-anchor icon-pasandidan" data-toggle="tooltip" data-placement="top" title="{{trans('labels.disLike')}}"></button>
            </div>
        @elseif ($vals['like'] == '0')
            <div class="btn-group pull-right mr">
                <button id="LikePage" type="subject" val="1"
                @foreach($params as $k=>$v)
                    {{$k}}="{{$v}}"
                @endforeach
                data-href="{{route('hamafza.page_like')}}" type="button" class="btn fa fa-anchor icon-pasandidan" data-toggle="tooltip" data-placement="top" title="{{trans('labels.Like')}}"></button>
            </div>
        @endif
        @if ($vals['follow'] == '1')
            <div class="btn-group pull-right mr">
                <button id="FollowPage" type="subject" val="0"
                @foreach($params as $k=>$v)
                    {{$k}}="{{$v}}"
                @endforeach
                data-href="{{route('hamafza.page_follow')}}"  type="button" class="btnActive  fa fa-anchor icon-rss" data-toggle="tooltip" data-placement="top" title="{{trans('labels.unfollow')}}"></button>
            </div>
        @elseif ($vals['follow'] == '0')
            <div class="btn-group pull-right mr">
                <button id="FollowPage" type="subject" val="1"
                @foreach($params as $k=>$v)
                    {{$k}}="{{$v}}"
                @endforeach
                data-href="{{route('hamafza.page_follow')}}"  type="button" class="btn  fa fa-anchor icon-rss" data-toggle="tooltip" data-placement="top" title="{{trans('labels.follow')}}"></button>
            </div>
        @endif
        @if(\Request::route()->getName() != 'page.forum')
        <div class="btn-group pull-right mr">
            <button id="CommentPage" type="subject" val="1"
            @foreach($params as $k=>$v)
                {{$k}}="{{$v}}"
            @endforeach
            type="button" class="btn  fa fa-anchor icon-ezhare-nazar comment" data-toggle="tooltip" data-placement="top" title="{{trans('labels.comment')}}"></button>
        </div>
        @endif
        @if(count($help) > 0 )
            <div class="btn-group" style="float: left">
                <a href="{{url('/modals/helpview?id='.$help['pageid'].'&tagname= '.$help['tagname'].'&hid='.$help['id'].'&pid=25')}}" title="راهنمای اینجا" class="jsPanels icon icon-help HelpIcons"></a>
            </div>
        @endif
    @endif

    @if($type=='Group' || ($type=='User' && $id!= Auth::id()) ){{--TODO:Check Group Owner--}}
    @if ($vals['follow'] == '1')
        <div class="btn-group pull-right mr">
            <button id="FollowPage" type="User" val="0"
            @foreach($params as $k=>$v)
                {{$k}}="{{$v}}"
            @endforeach
            data-href="{{route('hamafza.page_follow')}}" type="button" class="btnActive  fa fa-anchor icon-rss" data-toggle="tooltip" data-placement="top" title="{{trans('labels.unfollow')}}"></button>
        </div>
    @elseif ($vals['follow'] == '0')
        <div class="btn-group pull-right mr">
            <button id="FollowPage" type="User" val="1"
            @foreach($params as $k=>$v)
                {{$k}}="{{$v}}"
            @endforeach
            data-href="{{route('hamafza.page_follow')}}" type="button" class="btn  fa fa-anchor icon-rss" data-toggle="tooltip" data-placement="top" title="{{trans('labels.follow')}}"></button>
        </div>
        @if(\Request::route()->getName() != 'page.forum')
        <div class="btn-group pull-right mr">
            <button id="CommentPage" val="1"
            @foreach($params as $k=>$v)
                {{$k}}="{{$v}}"
            @endforeach
            type="button" class="btn  fa fa-anchor icon-ezhare-nazar comment" data-toggle="tooltip" data-placement="top" title="{{trans('labels.comment')}}"></button>
        </div>
        @endif
        @if(count($help) > 0 )
            <div class="btn-group" style="float: left">
                <a href="{{url('/modals/helpview?id='. $help['pageid'].'&tagname='.$help['tagname'].'&hid='.$help['id'].'&pid=25')}}" title="راهنمای اینجا" class="jsPanels icon icon-help HelpIcons"></a>
            </div>
        @endif
    @endif
    @endif
@endif