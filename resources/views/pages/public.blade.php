@extends('layouts.master')
@section('inline_scripts')
    @include('pages.helper.toolbar_inline_js')
@stop
@section('content')
    <link href="{{App::make('url')->to('/')}}/theme/Content/css/textassist.css" rel="stylesheet" type="text/css"/>
    <script src="{{App::make('url')->to('/')}}/theme/Scripts/textassist.js" type="text/javascript"></script>
    @include('scripts.publicpages')
    @include('sections.contextmenu')
    <script>
        $('#highlight_search').focus();
    </script>
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
                        $content = preg_replace("/".$_GET['s']."/","<span id='h'>".$_GET['s']."</span>",$content,1);
                        $content = preg_replace("/".$_GET['s']."/","<span class='highlight_search'>".$_GET['s']."</span>",$content);
                    @endphp
                @endif
            {!!$content!!}
{{--            {{$content}}--}}
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $("#highlight_search").focus();
        });
    </script>

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
                            {{--<pre>{{print_r($file)}}</pre>--}}
                            <li>
                                <div style="display: inline-block;height: 10px; margin: 5px">
                                    @if(trans('label.'.$file->extension)=='label.'.$file->extension)
                                        <span style="font-size: 15pt;height: 10px;" class="fa fa-file-o"></span>
                                    @else
                                        <span style="font-size: 15pt;height: 10px;" class="fa fa-file-{{ trans('label.'.$file->extension) }}-o"></span>
                                    @endif
                                </div>
                                <a href="{{route('FileManager.DownloadFile',['type'=>'ID','id'=>enCode($file->id)])}}/?&fname={{ $file->originalName }}">
                                    <span style="display: inline-block">{{  $file->originalName }}</span>
                                    <span style="display: inline-block">- {{  ceil($file->size/1024) }}KB</span>
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

