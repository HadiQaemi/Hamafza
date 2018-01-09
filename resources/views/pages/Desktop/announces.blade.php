@extends('layouts.master')
@section('specific_plugin_style')
    <link rel="stylesheet" type="text/css" media="all" href="{{url('theme/Content/css/wall.css')}}" title="Aqua"/>
@stop
@section('content')
    <div class="panel-body text-decoration ContentSec">
        <div class='text-content'>
            @php
                if (isset($highlights) && count($highlights) > 0)
                {
                    $announces = $highlights;
                }
            @endphp
            @if (isset($announces) && count($announces) > 0)
                @foreach($announces as $item)
                    <div class="comment-contain">
                        <div class="comment-box">
                            @if(!empty($type) && $type=='announce')
                                <img class="avatar mCS_img_loaded" src="{{url('theme/Content/icons/yddasht.png')}}">
                            @endif
                            @if($item->page->subject->title!='')
                                <div class="name">در صفحه :<a target="_blank" href="{{url($item->pid)}}"> {{$item->page->subject->title}}</a></div>
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
                                @if (array_key_exists('comment', $item->toArray()))
                                    {{ nl2br($item->comment) }}
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
                                <span>{{$item->JalaliRegDate}} </span>
                                <div class="pull-left left-detail PostDate">
                                    <span class="FloatLeft fonts icon-hazv  PostDelicn" page="Announce" action="delete" id="{{$item->id}}"></span>
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
