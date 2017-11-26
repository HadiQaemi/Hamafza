@extends('layouts.master')
@section('content')
    <link href="{{App::make('url')->to('/')}}/theme/Content/css/textassist.css" rel="stylesheet" type="text/css"/>
    <script src="{{App::make('url')->to('/')}}/theme/Scripts/textassist.js" type="text/javascript"></script>
    @include('scripts.publicpages')
    @include('sections.contextmenu')

    <div class="panel-body text-decoration">
        <div class='text-content'>
            @if(!empty($Alert) && $Alert!='')
                <div style="margin:15px;" class="gkCode10"> {{$Alert}}</div>
            @endif
            @if( session('NewAlert')!='')
                <div style="margin:15px;" class="gkCode10"> {{session('NewAlert')}}</div>
                <?php  Session::put('NewAlert', '');?>
            @endif
            {!!$content!!}
        </div>
    </div>
@stop
@include('sections.keywords')
@section('Files')
    @if (!empty($Files) && is_array($Files) && count($Files)>0)
        <div class="spacer">
            <div class="panel panel-light fix-box1">
                <div class="fix-inr1" style="height: 100%">
                    <div style="padding: 0;" class="panel-heading panel-heading-darkblue"></div>
                    <div class="panel-body text-decoration">
                        <b>{{ trans('label.Files')  }}</b>
                        @foreach($Files as $item)
                            <li>
                                <div style="display: inline-block;height: 10px; margin: 5px"><span style="font-size: 15pt;height: 10px;" class="icon icon-{{$item['ext']}}"></span></div>
                                <a href="{{App::make('url')->to('/')}}/download?fid={{ $item['id'] }}&fname={{ $item['name'] }}"><span>{{ $item['title']}}</span><span style="font-size: 7pt;margin-right:10px">{{ $item['size']}}ک.ب</span></a>
                            </li>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    @include('sections.relation')
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.rightcol')
@stop

