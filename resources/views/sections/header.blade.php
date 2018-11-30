<meta charset="UTF-8">
<title>
    @if(isset($Title )&& isset($SiteTitle ))
        {{ preg_replace("/<span[^>]+\>.*>/i", "", $Title) }} - {{ $SiteTitle }}
    @endif
</title>
<meta http-equiv="content-language" content="fa">
<meta name="keywords" content="{{Config::get('constants.SiteKeyword')}}"/>
@if( ! empty($Descr))
    <meta name="description" content="{{$Descr}}"/>
@else
    <meta name="description" content="{{Config::get('constants.Sitedescription')}}"/>
@endif
<meta name="googlebot" content="INDEX"/>
<meta property="og:locale" content="fa_IR"/>
<meta property="og:type" content="website"/>
@if(isset($Title )&& isset($SiteTitle ))
<meta property="og:title" content="{{ strip_tags($Title) }} - {{ $SiteTitle }}"/>
<meta property="og:site_name" content="{{ $SiteTitle }}"/>
@endif
<meta property="og:url" content="{{url('/')}}"/>

<META NAME="ROBOTS" CONTENT="INDEX">
@if( isset($Descr) &&! empty($Descr))
    <meta property="og:description" content="{{$Descr}}"/>
@else
    <meta property="og:description" content="{{Config::get('constants.Sitedescription')}}"/>
@endif
<meta name="author" content="amghha@gmail.com">
<meta name="generator" content="Amir Ghiasvand">
<link href="{{App::make('url')->to('/')}}/theme/Content/css/jquery.ui.datepicker1.8-all.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/bootstrap-rtl.min.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/style.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/tipsy.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/homslider/animate.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/homslider/bootslider.css"/>
<link rel="stylesheet" href="{{App::make('url')->to('/')}}/theme/bootstrap/css/bootstrap-image-gallery.min.css"/>
<!--<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">-->
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/scroll/jquery.mCustomScrollbar.min.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/public.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/daneshnameh.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/jquery-ui.css"/>
<link rel="stylesheet" href="{{App::make('url')->to('/')}}/theme/Content/css/jquery.jspanel.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/jquery.notice.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/treemenu.css"/>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/bootstrap-show-password.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/homslider/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/homslider/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/homslider/jquery.fitvids.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/homslider/jquery.grozav.bootslider.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.tipsy.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/custom.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/public.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.bsvalidate.js"></script>
<script src="{{App::make('url')->to('/')}}/theme/Scripts/mobile-detect.min.js"></script>
<script src="{{App::make('url')->to('/')}}/theme/Scripts/jquery-ui.min.js"></script>
<script src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.jspanel.min.js"></script>
<script src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.notice.js"></script>
<script src="{{App::make('url')->to('/')}}/theme/Scripts/jstree.js"></script>
<script src="{{App::make('url')->to('/')}}/theme/Scripts/jstree.search.js"></script>
<script src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.highlight.js" type="text/javascript"></script>
<script src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.tokeninput.js" type="text/javascript"></script>
{{--<script src="{{App::make('url')->to('/')}}/theme/Scripts/highcharts.js"></script>--}}
<script src="{{App::make('url')->to('/')}}/theme/Scripts/exporting.js"></script>
<script src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.ui.datepicker-cc.all.min.js" type="text/javascript"></script>
<script>
    @if (Session::has('Login') && session('Login') == 'TRUE')
        var CurPic = "{{auth()->user()->avatar}}";
        var CurPics = "{{route('FileManager.DownloadFile',['type'=>'ID','id'=>enCode((int)auth()->user()->avatar)])}}";
        var CarUname = "{{auth()->user()->Uname}}";
        var curUid = "{{auth()->id()}}";
        var curFamily = "{{auth()->user()->Family}}";
        var curName = "{{auth()->user()->Name}}";
        var curemail = "{{auth()->user()->email}}";
        @if (! empty($PageType) && $PageType == 'group')
            var Gid = "{{$sid}}";
        @endif
    @endif
    var Baseurl = "{{App::make('url')->to('/')}}/";</script>
<?php
$pos = strpos(strip_tags($Title), 'ویرایش');
if ($pos !== false)
    echo '<link type="image/png" rel="icon" href="' . Request::root() . '/edit.png">';
else
    echo '<link type="image/png" rel="icon" href="' . Request::root() . '/favicon.png">';
?>

@if($pid=='1' && $sid=='1' && $content=='1')
    <script src="{{App::make('url')->to('/')}}/theme/Scripts/jssor.core.js" type="text/javascript"></script>
    <script src="{{App::make('url')->to('/')}}/theme/Scripts/jssor.slider.min.js" type="text/javascript"></script>
    <script src="{{App::make('url')->to('/')}}/theme/Scripts/jssor.utils.js" type="text/javascript"></script>
    <script>


        jQuery(document).ready(function ($) {

            var options = {
                $AutoPlay: true, //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1, //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000, //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1, //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true, //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500, //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20, //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1, //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0, //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1, //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1, //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3, //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$, //[Required] Class to create navigator instance
                    $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0, //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1, //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1, //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0, //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0, //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },
                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$, //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };
            var jssor_slider1 = new $JssorSlider$("slider2_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 792));
                else
                    window.setTimeout(ScaleSlider, 30);
            }

            ScaleSlider();
            if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
                $(window).bind('resize', ScaleSlider);
            }


            //if (navigator.userAgent.match(/(iPhone|iPod|iPad)/)) {
            //    $(window).bind("orientationchange", ScaleSlider);
            //}
            //responsive code end
        });
    </script>

@endif