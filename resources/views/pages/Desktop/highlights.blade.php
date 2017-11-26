@extends('layouts.master')
@section('specific_plugin_style')
    <link rel="stylesheet" type="text/css" media="all" href="{{url('theme/Content/css/wall.css')}}" title="Aqua"/>
@stop
@section('content')
    <div class="panel-body text-decoration ContentSec">
        <div class='text-content'>
            @if(isset($highlights) && count($highlights)>0)
                @foreach($highlights as $item)
                    <div class="comment-contain">
                        <div class="comment-box">
                            @if(!empty($type) && $type=='highlight')
                                <img class="avatar mCS_img_loaded" src="{{url('theme/Content/icons/alamatgozari.png')}}">
                            @endif
                            @if(isset($item->page->subject->title)&& $item->page->subject->title!='')
                                <div class="name">در صفحه :<a target="_blank" href="{{url($item->pid)}}"> {{$item->page->subject->title}}</a></div>
                            @endif
                            <div class="text">
                                @if(trim($item->quote)!='')
                                    درباره<span> « {{$item->quote}} » </span>
                                    <br>
                                @endif
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="like-box40">
                            <div class="firstRow">
                                <span>{{$item->JalaliRegDate}} </span>
                                <div class="pull-left left-detail PostDate">
                                    <span class="FloatLeft fonts icon-hazv  PostDelicn" page="Highlight" action="delete" id="{{$item->id}}"></span>
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
