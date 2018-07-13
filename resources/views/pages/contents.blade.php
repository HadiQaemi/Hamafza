@extends('layouts.master')
@section('specific_plugin_style')
    <link rel="stylesheet" type="text/css" media="all" href="{{url('theme/Content/css/wall.css')}}" title="Aqua"/>
@stop
@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{url('theme/Scripts/snetwork.js')}}"></script>
@stop
@section('inline_scripts')
    @include('pages.helper.toolbar_inline_js')
@stop
@section('content')
    <input id="PageCounter" value="1" type="hidden">
    <div class="panel-body text-decoration ContentSec">
        @if(!empty($Uname))
            <input type="hidden" id="UserConUname" value="{{$Uname}}">
        @endif
        @if(!empty($PageTypes))
            <input type="hidden" id="PageTypes" value="{{$PageTypes}}">
        @endif
        @include('sections.postinuserpage')
        @if(! empty($alert)!='')
            <div class="comment-box">
                <div class="commenTxtHolders">
                    {{$alert}}
                </div>
            </div>
        @endif
        <div class="comment-contain"></div>
        @if (is_array($content))
            @foreach($content as $item)
                <div class="comment-contain" id="{{ $item->id}}" postid="{{ $item->id}}">
                    <div class="comment-box">
                        <?php
                        if (array_key_exists('OrganPic', $item) && $item->OrganPic != '')
                        {
                            $pic = 'pics/group/Groups.png';
                            if (trim($item->OrganPic) != '' && file_exists('pics/group/' . $item->gid . '-' . $item->OrganPic))
                                $pic = 'pics/group/' . $item->gid . '-' . $item->OrganPic;
                            else if (trim($item->OrganPic) != '' && file_exists('pics/group/' . $item->OrganPic))
                                $pic = 'pics/group/' . $item->OrganPic;
                            $name = $item->OrganName;
                            $link = $item->Organlink;
                        }
                        else
                        {
                            if (isset($item->uid))
                            {
                                $pic = enCode(\App\User::find($item->uid)->avatar);//'pics/user/' . $item->Pic;
                            }
                            else
                            {
                                $pic = enCode(-1);
                            }
                            $name = $item->Name . ' ' . $item->Family;
                            $link = $item->Uname;
                        }
                        ?>
                        <img src="{{route('FileManager.DownloadFile',['type'=>'ID','id'=>$pic])}}" class="avatar" title="{{ $name}}" data-placement="top" data-toggle="tooltip">
                        <div class="name"><a href="{{App::make('url')->to('/')}}/{{ $link}}" target="_blank">{{ $name}}</a></div>
                        <div class="text">
                            @if($item->title!='')
                                {{$item->type}}:  {{ $item->title}}
                                <br>
                            @endif

                            @if($item->shid !='0')
                                <span>بازنشر از:</span>
                                <a target="_blank" href="{{App::make('url')->to('/')}}/{{$item->share_userlink}}">{{$item->share_user}}</a>
                                <span>؛</span>
                            @endif
                            @if ( !array_key_exists('OrganPic', $item) &&($item->InsertedGroup!=''  ||$item->InsertedOrgan|| $item->InsertedSubject ) )
                                درج شده در
                                @if($item->InsertedGroup!='')
                                    گروه  <a target="_blank" href="{{App::make('url')->to('/')}}/{{$item->InsertedGrouplink}}">{{$item->InsertedGroup}}</a>،
                                @endif
                                @if($item->InsertedOrgan!='')
                                    کانال   <a target="_blank" href="{{App::make('url')->to('/')}}/{{$item->InsertedOrganlink}}">{{$item->InsertedOrgan}}</a>،
                                @endif
                                @if($item->InsertedSubject!='')
                                    صفحه   <a target="_blank" href="{{App::make('url')->to('/')}}/{{$item->InsertedSubjectlink}}">{{$item->InsertedSubject}}</a>
                                @endif
                                <br>
                            @endif

                            @if($item->pic!='')
                                <img src="{{App::make('url')->to('/')}}/uploads/{{ $item->pic}}" style="max-width: 600px">
                                <br>
                            @endif
                            {!!nl2br($item->desc)!!}
                            @if($item->shid !='0' && $item->share_content!='')
                                <hr>
                                @if($item->share_pic!='')
                                    <img src="{{App::make('url')->to('/')}}/uploads/{{ $item->share_pic}}" style="max-width: 600px">
                                    <br>
                                @endif
                                {{$item->share_content}}
                            @endif
                            <div style="margin:5px; ">
                                @if(array_key_exists("keywords",$item) && is_array($item->keywords))
                                    @foreach($item->keywords as $items)
                                        <div class="FaqTags" id="Key_{{$items->id}}">{{$items->title}}</div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    @if($item->likes!='0')
                        <div class="like-box">
                            @else
                                <div class="like-box40">
                                    @endif
                                    <div class="firstRow">
                                        @if($item->islike)
                                            <span class="PostLike" like='0' postid="{{$item->id}}">حذف پسند </span>
                                        @else
                                            <span class="PostLike" like='1' postid="{{$item->id}}">پسند </span>
                                        @endif
                                        - <span postid="Comment_{{$item->id}}" class="Comment_Foc">اظهار نظر</span> -
                                        <span> <a class="jsPanels" title="بازنشر" href="{{App::make('url')->to('/')}}/modals/postshare?postid={{$item->id}}">بازنشر</a> </span>
                                        <div class="pull-left left-detail PostDate">
                                            @if(session('uid') ==$item->uid)
                                                @php
                                                    $post = App\Models\hamafza\Post::where('parent_id', $item->id)->get();
                                                @endphp
                                                @if (isset($item->accepted) && !$item->accepted)
                                                    @if (!$post->count())
                                                        <span id="{{$item->id}}" action="delete" page="Post" class="FloatLeft fonts icon-hazv  PostDelicn"></span>
                                                    @endif
                                                @endif
                                            @endif
                                            {{$item->reg_date}}
                                        </div>
                                    </div>
                                    @if ($item->likes!='0')
                                        <div class="secondRow">
                                            <span id="LikeCounter_{{$item->id}}">{{$item->likes  }}  </span> نفر این مطلب را
                                            @if ($item->likes!='1')
                                                پسندیده‌اند
                                            @else
                                                پسندید
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                @if (is_array($item->comments))
                                    @foreach($item->comments as $items)
                                        @if (\App\User::find($item->uid))
                                            <div class="addcomment commentShow">
                                                <input class="Postid" value="{{$items->id}}" type="hidden">
                                                <a target='_blank' href='{{$items->Uname}}'>
                                                    <img class="imgContain" title="{{ $items->Name}} {{ $items->Family}}" data-placement="top" data-toggle="tooltip"
                                                         src="{{route('FileManager.DownloadFile',['type'=>'ID','id'=>enCode(\App\User::find($item->uid)->avatar)])}}">
                                                </a>
                                                <div class="txtContain">{{$items->comment}}</div>
                                                <div class="CommentTime">
                                                    <span> {{$items->reg_date}} </span>
                                                    @if(session('uid') ==$items->uid)
                                                        <span style="margin-right: 10px;" class="FloatLeft fonts icon-hazv CommentDelicn" page="comment" action="delete" id="{{$items->id}}"></span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                @if(auth()->check())
                                    <div class="addcomment">
                                        <input class="Postid" value="{{$item->id}}" type="hidden">
                                        <img class="imgContain" src="{{route('FileManager.DownloadFile',['type'=>'ID','id'=>enCode(auth()->user()->avatar)])}}">
                                        <div class="txtContain">
                                            <input Class="CommentSend" postid="{{$item->id}}" id="Comment_{{$item->id}}" type="text" placeholder="نظرتان را بنویسید">
                                        </div>
                                    </div>
                                @endif
                        </div>
                        @endforeach
                    @endif
                </div>
@stop

@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.rightcol')
@stop