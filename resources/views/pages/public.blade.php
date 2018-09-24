@extends('layouts.master')
@section('inline_scripts')
    @include('pages.helper.toolbar_inline_js')
@stop
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
{{--            {!!$Tree!!}--}}

                @if(isset($_GET['s']))
                    @php
                        $content = str_ireplace($_GET['s'],"<span style='background: #9e9b29;padding: 5px;color:#fffefb;border-radius:5px'>".$_GET['s']."</span>",$content);
                    @endphp
                @endif
            {!!$content!!}
{{--            {{$content}}--}}
        </div>
    </div>
@stop
@include('sections.keywords')
@section('Files')
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
    @include('sections.relation')
@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.rightcol')
@stop

