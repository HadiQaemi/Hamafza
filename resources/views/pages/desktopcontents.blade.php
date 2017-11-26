@extends('layouts.master')
@section('content')
    <link rel="stylesheet" type="text/css" media="all" href="{{App::make('url')->to('/')}}/theme/Content/css/wall.css" title="Aqua"/>
    <div class="panel-body text-decoration ContentSec">
        <div class='text-content'>
            @if(is_array($content) && count($content)>0)
                @foreach($content as $item)
                    <div class="comment-contain">
                        <div class="comment-box">
                            @if(!empty($type) && $type=='announce')
                                <img class="avatar mCS_img_loaded" src="{{App::make('url')->to('/')}}/theme/Content/icons/yddasht.png">
                            @endif
                            @if(!empty($type) && $type=='highlight')
                                <img class="avatar mCS_img_loaded" src="{{App::make('url')->to('/')}}/theme/Content/icons/alamatgozari.png">
                            @endif
                            @if($item->title!='')
                                <div class="name">در صفحه :<a target="_blank" href="{{App::make('url')->to('/')}}/{{$item->pid}}"> {{$item->title}}</a></div>
                            @endif
                            <div class="text">
                                @if(array_key_exists('atitle', $item))
                                    {{$item->atitle}}
                                    <br>
                                @endif
                                @if(trim($item->quote)!='')
                                    درباره<span> « {{$item->quote}} » </span>
                                    <br>
                                @endif
                                @if(array_key_exists('comment',$item))
                                    {{nl2br($item->comment)}}
                                @endif
                                <div style="margin:5px; ">
                                    @if(isset($item->keywords))
                                        @if(array_key_exists("keywords",$item) && is_array($item->keywords))
                                            @foreach($item->keywords as $items)
                                                    @if(isset($items->keyword))
                                                            <a class="FaqTags" onclick="AddTags('{{$items->id}}','{{$items->keyword}}', 1); ">{{$items->keyword}}</a>
                                                    @endif
                                            @endforeach
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="like-box40">
                            <div class="firstRow">
                                <span>{{$item->reg_date}} </span>
                                <div class="pull-left left-detail PostDate">
                                    @if(array_key_exists('comment',$item))
                                        <span class="FloatLeft fonts icon-hazv  PostDelicn" page="Announce" action="delete" id="{{$item->id}}"></span>
                                    @else
                                        <span class="FloatLeft fonts icon-hazv  PostDelicn" page="Highlight" action="delete" id="{{$item->id}}"></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div style="margin:15px;" class="gkCode10">موردی یافت نشد.</div>
            @endif
        </div>
    </div>
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop
