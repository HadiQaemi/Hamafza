<!DOCTYPE html>
<html ng-app="hamafza">
<head lang="en">
    <link rel="stylesheet" href="{{App::make('url')->to('/')}}/theme/Content/css/banader.css"/>
    <link href="{{App::make('url')->to('/')}}/theme/amid/css/index.css" rel="stylesheet"/>
    <link href="{{App::make('url')->to('/')}}/theme/amid/css/jquery.flipster.min.css" rel="stylesheet"/>
    <!--[if lt IE 9]>
    <script src="{{App::make('url')->to('/')}}/theme/amid/js/respond.js"></script>
    <![endif]-->
    <script src="{{App::make('url')->to('/')}}/theme/amid/js/jssor.core.js"></script>
    <script src="{{App::make('url')->to('/')}}/theme/amid/js/jssor.utils.js"></script>
    <script src="{{App::make('url')->to('/')}}/theme/amid/js/jssor.slider.min.js"></script>
    <script src="{{App::make('url')->to('/')}}/theme/amid/js/jquery.flipster.min.js"></script>


    <link href="{{App::make('url')->to('/')}}/theme/banader/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="{{App::make('url')->to('/')}}/theme/banader/css/index.css" rel="stylesheet"/>
    <link href="{{App::make('url')->to('/')}}/theme/banader/css/flaticon.css" rel="stylesheet"/>
    <link href="{{App::make('url')->to('/')}}/theme/banader/css/jquery.flipster.min.css" rel="stylesheet"/>
    <!--[if lt IE 9]>
    <script src="{{App::make('url')->to('/')}}/theme/banader/js/respond.js"></script>
    <![endif]-->
    <script src="{{App::make('url')->to('/')}}/theme/banader/js/jquery-1.11.3.min.js"></script>
    <script src="{{App::make('url')->to('/')}}/theme/banader/js/jssor.core.js"></script>
    <script src="{{App::make('url')->to('/')}}/theme/banader/js/jssor.utils.js"></script>
    <script src="{{App::make('url')->to('/')}}/theme/banader/js/jssor.slider.min.js"></script>
    <script src="{{App::make('url')->to('/')}}/theme/banader/js/jquery.flipster.min.js"></script>


    <script>
        jQuery(document).ready(function ($) {

            var _CaptionTransitions = [
                //CLIP|LR
                {$Duration: 900, $Clip: 3, $Easing: $JssorEasing$.$EaseInOutCubic},
                //CLIP|TB
                {$Duration: 900, $Clip: 12, $Easing: $JssorEasing$.$EaseInOutCubic},

                //ZMF|10
                {$Duration: 600, $Zoom: 11, $Easing: {$Zoom: $JssorEasing$.$EaseInExpo, $Opacity: $JssorEasing$.$EaseLinear}, $Opacity: 2},

                //ZML|R
                {$Duration: 600, x: -0.6, $Zoom: 11, $Easing: {$Left: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic}, $Opacity: 2},
                //ZML|B
                {$Duration: 600, y: -0.6, $Zoom: 11, $Easing: {$Top: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic}, $Opacity: 2},

                //ZMS|B
                {$Duration: 700, y: -0.6, $Zoom: 1, $Easing: {$Top: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic}, $Opacity: 2},

                //RTT|10
                {$Duration: 700, $Zoom: 11, $Rotate: 1, $Easing: {$Zoom: $JssorEasing$.$EaseInExpo, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInExpo}, $Opacity: 2, $Round: {$Rotate: 0.8}},

                //RTTL|R
                {
                    $Duration: 700,
                    x: -0.6,
                    $Zoom: 11,
                    $Rotate: 1,
                    $Easing: {$Left: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInCubic},
                    $Opacity: 2,
                    $Round: {$Rotate: 0.8}
                },
                //RTTL|B
                {
                    $Duration: 700,
                    y: -0.6,
                    $Zoom: 11,
                    $Rotate: 1,
                    $Easing: {$Top: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInCubic},
                    $Opacity: 2,
                    $Round: {$Rotate: 0.8}
                },

                //RTTS|R
                {
                    $Duration: 700,
                    x: -0.6,
                    $Zoom: 1,
                    $Rotate: 1,
                    $Easing: {$Left: $JssorEasing$.$EaseInQuad, $Zoom: $JssorEasing$.$EaseInQuad, $Rotate: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseOutQuad},
                    $Opacity: 2,
                    $Round: {$Rotate: 1.2}
                },
                //RTTS|B
                {
                    $Duration: 700,
                    y: -0.6,
                    $Zoom: 1,
                    $Rotate: 1,
                    $Easing: {$Top: $JssorEasing$.$EaseInQuad, $Zoom: $JssorEasing$.$EaseInQuad, $Rotate: $JssorEasing$.$EaseInQuad, $Opacity: $JssorEasing$.$EaseOutQuad},
                    $Opacity: 2,
                    $Round: {$Rotate: 1.2}
                },

                //R|IB
                {$Duration: 900, x: -0.6, $Easing: {$Left: $JssorEasing$.$EaseInOutBack}, $Opacity: 2},
                //B|IB
                {$Duration: 900, y: -0.6, $Easing: {$Top: $JssorEasing$.$EaseInOutBack}, $Opacity: 2},

            ];

            var options = {
                $FillMode: 2,                                       //[Optional] The way to fill image in slide, 0 stretch, 1 contain (keep aspect ratio and put all inside slide), 2 cover (keep aspect ratio and cover whole slide), 4 actual size, 5 contain for large image, actual size for small image, default value is 0
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                                   //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideEasing: $JssorEasing$.$EaseOutQuint,          //[Optional] Specifies easing for right to left animation, default value is $JssorEasing$.$EaseOutQuad
                $SlideDuration: 800,                               //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                $SlideHeight: 400,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $CaptionSliderOptions: {                            //[Optional] Options which specifies how to animate caption
                    $Class: $JssorCaptionSlider$,                   //[Required] Class to create instance to animate caption
                    $CaptionTransitions: _CaptionTransitions,       //[Required] An array of caption transitions to play caption, see caption transition section at jssor slideshow transition builder
                    $PlayInMode: 1,                                 //[Optional] 0 None (no play), 1 Chain (goes after main slide), 3 Chain Flatten (goes after main slide and flatten all caption animations), default value is 1
                    $PlayOutMode: 3                                 //[Optional] 0 None (no play), 1 Chain (goes before main slide), 3 Chain Flatten (goes before main slide and flatten all caption animations), default value is 1
                },

                $BulletNavigatorOptions: {                          //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                 //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 8,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 8,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },

                $ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 1,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };

            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var bodyWidth = document.body.clientWidth;
                if (bodyWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(bodyWidth, 1920));
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

    <script>

        jQuery(document).ready(function ($) {

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },


                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
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

    <script>
        jQuery(document).ready(function ($) {
            var options = {
                $AutoPlay: false,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 5, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 2,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $ThumbnailNavigatorOptions: {
                    $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always

                    $ActionMode: 1,                                 //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
                    $AutoCenter: 3,                             //[Optional] Auto center thumbnail items in the thumbnail navigator container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 3
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange thumbnails, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each thumbnail in pixel, default value is 0
                    $DisplayPieces: 5,                              //[Optional] Number of pieces to display, default value is 1
                    $ParkingPosition: 0,                            //[Optional] The offset position to park thumbnail
                    $Orientation: 2,                                //[Optional] Orientation to arrange thumbnails, 1 horizental, 2 vertical, default value is 1
                    $DisableDrag: true                              //[Optional] Disable drag or not, default value is false
                }
            };

            var jssor_slider3 = new $JssorSlider$("slider3_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider3.$Elmt.parentNode.clientWidth;
                if (parentWidth) {
                    var sliderWidth = parentWidth;

                    //keep the slider width no more than 701
                    sliderWidth = Math.min(sliderWidth, 792);

                    jssor_slider3.$SetScaleWidth(sliderWidth);
                }
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

    <script>

        jQuery(document).ready(function ($) {

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },


                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };
            var jssor_slider1 = new $JssorSlider$("slider4_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 600));
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

    <script>

        jQuery(document).ready(function ($) {

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },


                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };
            var jssor_slider1 = new $JssorSlider$("slider5_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 600));
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

    <script>

        jQuery(document).ready(function ($) {

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },


                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };
            var jssor_slider1 = new $JssorSlider$("slider6_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 600));
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

    <script>

        jQuery(document).ready(function ($) {

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $ThumbnailNavigatorOptions: {

                    $HWA: false,

                },

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },


                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };
            var jssor_slider1 = new $JssorSlider$("slider7_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 600));
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

    <!-- Library Slider -->

    <script>
        jQuery(document).ready(function ($) {
            var options = {
                $AutoPlay: false,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $StartIndex: 3,
                $AutoPlaySteps: -1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 5, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $ThumbnailNavigatorOptions: {
                    $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always

                    $ActionMode: 1,                                 //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
                    $AutoCenter: 3,                             //[Optional] Auto center thumbnail items in the thumbnail navigator container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 3
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange thumbnails, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each thumbnail in pixel, default value is 0
                    $DisplayPieces: 5,                              //[Optional] Number of pieces to display, default value is 1
                    $ParkingPosition: 0,                            //[Optional] The offset position to park thumbnail
                    $Orientation: 1,                                //[Optional] Orientation to arrange thumbnails, 1 horizental, 2 vertical, default value is 1
                    $DisableDrag: true                              //[Optional] Disable drag or not, default value is false
                }
            };

            var jssor_slider2 = new $JssorSlider$("slider8_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider2.$Elmt.parentNode.clientWidth;
                if (parentWidth) {
                    var sliderWidth = parentWidth;

                    //keep the slider width no more than 970
                    sliderWidth = Math.min(sliderWidth, 792);

                    jssor_slider2.$SetScaleWidth(sliderWidth);
                }
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

    <script>

        jQuery(document).ready(function ($) {

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },


                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };
            var jssor_slider1 = new $JssorSlider$("slider9_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 790));
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

    <script>

        jQuery(document).ready(function ($) {

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },


                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };
            var jssor_slider1 = new $JssorSlider$("slider10_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 790));
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

    <script>

        jQuery(document).ready(function ($) {

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },


                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };
            var jssor_slider1 = new $JssorSlider$("slider11_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 790));
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

    <script>

        jQuery(document).ready(function ($) {

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },


                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };
            var jssor_slider1 = new $JssorSlider$("slider12_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 790));
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


    <!-- News Slider -->

    <script>
        jQuery(document).ready(function ($) {
            var options = {
                $AutoPlay: false,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $StartIndex: 4,
                $AutoPlaySteps: -1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 5, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $ThumbnailNavigatorOptions: {
                    $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always

                    $ActionMode: 1,                                 //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
                    $AutoCenter: 3,                             //[Optional] Auto center thumbnail items in the thumbnail navigator container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 3
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange thumbnails, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each thumbnail in pixel, default value is 0
                    $DisplayPieces: 5,                              //[Optional] Number of pieces to display, default value is 1
                    $ParkingPosition: 0,                            //[Optional] The offset position to park thumbnail
                    $Orientation: 1,                                //[Optional] Orientation to arrange thumbnails, 1 horizental, 2 vertical, default value is 1
                    $DisableDrag: true                              //[Optional] Disable drag or not, default value is false
                }
            };

            var jssor_slider2 = new $JssorSlider$("slider13_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider2.$Elmt.parentNode.clientWidth;
                if (parentWidth) {
                    var sliderWidth = parentWidth;

                    //keep the slider width no more than 970
                    sliderWidth = Math.min(sliderWidth, 792);

                    jssor_slider2.$SetScaleWidth(sliderWidth);
                }
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

    <script>

        jQuery(document).ready(function ($) {

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 2,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },


                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };
            var jssor_slider1 = new $JssorSlider$("slider14_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 790));
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


    <script>

        jQuery(document).ready(function ($) {

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 2,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },


                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };
            var jssor_slider1 = new $JssorSlider$("slider15_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 790));
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

    <script>

        jQuery(document).ready(function ($) {

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 2,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },


                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };
            var jssor_slider1 = new $JssorSlider$("slider16_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 790));
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

    <script>

        jQuery(document).ready(function ($) {

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 2,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },


                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };
            var jssor_slider1 = new $JssorSlider$("slider17_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 790));
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

    <script>

        jQuery(document).ready(function ($) {

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 2,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },


                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };
            var jssor_slider1 = new $JssorSlider$("slider18_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 790));
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


    <!-- Store -->

    <script>

        jQuery(document).ready(function ($) {


            $("#coverflow").flipster({

                spacing: -0.5,

                buttons: true,
                onItemSwitch: function (e) {

                    var item = $(e)

                    $(".bookDet span.name").empty().text(item.find("span.name").text())
                    $(".bookDet span.number").empty().text(item.find("span.number").text())

                }
            });

            var item = $("div#coverflow ul li.flipster__item--current")

            $(".bookDet span.name").empty().text(item.find("span.name").text())
            $(".bookDet span.number").empty().text(item.find("span.number").text())

        });
    </script>


    @include('sections.header')

</head>
<body dir="rtl" class="mstr-clr" hmfz-ui-thm="" style="overflow: auto;">
<div hmfz-main-header="">
    {{--<nav id="header" class="navbar navbar-default" style="position: fixed;z-index: 10000;width: 100%;">--}}
    <nav id="header" class="navbar navbar-default">
        <div class="container-fluid">
            @include('sections.menu')
            @include('sections.loginregister')
        </div>

    </nav>
</div>
<div id="main">
    <!-- New HTMl -->
    <div id="scrollReset">
        <a href="#" class="up glyphicon glyphicon-chevron-up"></a>
        <a href="#" class="down glyphicon glyphicon-chevron-down"></a>
    </div>
    <!--End New HTMl -->

    <div hmfz-ui-view="">
        <!-- start of Main Template -->

        <div hmfz-tmplt-thm-clr="" hmfz-tmplt-cntnt="">
            ﻿

            <div class="siteBody">
                <!-- Jssor Slider Begin -->
                <!-- You can move inline styles to css file or css block. -->
                <div id="slider1_container" class="slider" style="position: relative; margin: 0 auto; top: 0; left: 0; width: 1300px; height: 400px; overflow: hidden;">
                    <!-- Loading Screen -->
                    <div u="loading" style="position: absolute; top: 0; left: 0;">
                        <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block;top: 0; left: 0; width: 100%; height: 100%;">
                        </div>
                        <div style="position: absolute; display: block; background: url({{App::make('url')->to('/')}}/theme/banader/img/loading.gif) no-repeat center center;top: 0; left: 0; width: 100%; height: 100%;">
                        </div>
                    </div>
                    <!-- Slides Container -->
                    <div u="slides" style="cursor: move; position: absolute; left: 0; top: 0; width: 1300px;height: 500px; overflow: hidden;">
                        <div>
                            <img u="image" src="{{App::make('url')->to('/')}}/theme/banader/css/images/slider-01.jpg"/>
                            <div u="caption" t="*" style="position: absolute; width: 545px; height: 300px; top: 30px; left: 730px;background: rgba(0,0,0,0.24);">
                                <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/sliderImg-01.jpg" style="float:right"/>
                                <div class="clearfix"></div>
                                <h1>
                                    تخلیه و بارگیری 4,7 میلیون تن کالا در بنادر قشم
                                </h1>
                                <p>“ مدیر اداره بنادر و دریانوردی قشم از ترابری 9,3 میلیون نفر- سفر و تخلیه و بارگیری 4.7 میلیون انواع کالای نفتی و غیرنفتی در بنادر این جزیره از ابتدای سال جاری تاکنون، خبر داد.مدیر اداره بنادر و دریانوردی
                                    قشم از ترابری 9,3 میلیون نفر- سفر و تخلیه و بارگیری 4.7 میلیون انواع کالای نفتی و غیرنفتی در بنادر این جزیره از ابتدای سال جاری تاکنون، خبر داد.”</p>
                            </div>
                        </div>
                        <div>
                            <img u="image" src="{{App::make('url')->to('/')}}/theme/banader/css/images/slider-01.jpg"/>
                            <div u="caption" t="*" style="position: absolute; width: 545px; height: 300px; top: 30px; left: 730px;background: rgba(0,0,0,0.24);">
                                <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/sliderImg-01.jpg" style="float:right"/>
                                <div class="clearfix"></div>
                                <h1>
                                    تخلیه و بارگیری 4,7 میلیون تن کالا در بنادر قشم
                                </h1>
                                <p>“ مدیر اداره بنادر و دریانوردی قشم از ترابری 9,3 میلیون نفر- سفر و تخلیه و بارگیری 4.7 میلیون انواع کالای نفتی و غیرنفتی در بنادر این جزیره از ابتدای سال جاری تاکنون، خبر داد.مدیر اداره بنادر و دریانوردی
                                    قشم از ترابری 9,3 میلیون نفر- سفر و تخلیه و بارگیری 4.7 میلیون انواع کالای نفتی و غیرنفتی در بنادر این جزیره از ابتدای سال جاری تاکنون، خبر داد.”</p>
                            </div>
                        </div>
                        <div>
                            <img u="image" src="{{App::make('url')->to('/')}}/theme/banader/css/images/slider-01.jpg"/>
                            <div u="caption" t="*" style="position: absolute; width: 545px; height: 300px; top: 30px; left: 730px;background: rgba(0,0,0,0.24);">
                                <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/sliderImg-01.jpg" style="float:right"/>
                                <div class="clearfix"></div>
                                <h1>
                                    تخلیه و بارگیری 4,7 میلیون تن کالا در بنادر قشم
                                </h1>
                                <p>“ مدیر اداره بنادر و دریانوردی قشم از ترابری 9,3 میلیون نفر- سفر و تخلیه و بارگیری 4.7 میلیون انواع کالای نفتی و غیرنفتی در بنادر این جزیره از ابتدای سال جاری تاکنون، خبر داد.مدیر اداره بنادر و دریانوردی
                                    قشم از ترابری 9,3 میلیون نفر- سفر و تخلیه و بارگیری 4.7 میلیون انواع کالای نفتی و غیرنفتی در بنادر این جزیره از ابتدای سال جاری تاکنون، خبر داد.”</p>
                            </div>
                        </div>
                        <!-- Example to add fixed static share buttons in slider BEGIN -->
                        <!-- Remove it if no need -->
                        <!-- Share Button Styles -->
                        <style>
                            .share-icon {
                                display: inline-block;
                                float: left;
                                margin: 4px;
                                width: 32px;
                                height: 32px;
                                cursor: pointer;
                                vertical-align: middle;
                                background-image: url({{App::make('url')->to('/')}}/theme/banader/img/share/share-icons.png);
                            }

                            .share-facebook {
                                background-position: 0px 0px;
                            }

                            .share-facebook:hover {
                                background-position: 0px -40px;
                            }

                            .share-twitter {
                                background-position: -40px 0px;
                            }

                            .share-twitter:hover {
                                background-position: -40px -40px;
                            }

                            .share-pinterest {
                                background-position: -80px 0px;
                            }

                            .share-pinterest:hover {
                                background-position: -80px -40px;
                            }

                            .share-linkedin {
                                background-position: -240px 0px;
                            }

                            .share-linkedin:hover {
                                background-position: -240px -40px;
                            }

                            .share-googleplus {
                                background-position: -120px 0px;
                            }

                            .share-googleplus:hover {
                                background-position: -120px -40px;
                            }

                            .share-stumbleupon {
                                background-position: -360px 0px;
                            }

                            .share-stumbleupon:hover {
                                background-position: -360px -40px;
                            }

                            .share-email {
                                background-position: -320px 0px;
                            }

                            .share-email:hover {
                                background-position: -320px -40px;
                            }
                        </style>

                        <!-- Example to add fixed static share buttons in slider BEGIN -->
                        <!-- Remove it if no need -->
                        <div u="any" style="position: absolute; display: block; top: 6px; right: 170px; width: 280px; height: 40px;">


                            <a class="share-icon share-facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=http://jssor.com" title="Share on Facebook"></a>
                            <a class="share-icon share-twitter" target="_blank"
                               href="http://twitter.com/share?url=http://jssor.com&text=jQuery%20Image%20Slider/Slideshow/Carousel/Gallery/Banner%20javascript+html%20TOUCH%20SWIPE%20Responsive" title="Share on Twitter"></a>
                            <a class="share-icon share-googleplus" target="_blank" href="https://plus.google.com/share?url=http://jssor.com" title="Share on Google Plus"></a>
                            <a class="share-icon share-linkedin" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=http://jssor.com" title="Share on LinkedIn"></a>
                            <a class="share-icon share-stumbleupon" target="_blank"
                               href="http://www.stumbleupon.com/submit?url=http://jssor.com&title=jQuery%20Image%20Slider/Slideshow/Carousel/Gallery/Banner%20javascript+html%20TOUCH%20SWIPE%20Responsive" title="Share on StumbleUpon"></a>
                            <a class="share-icon share-pinterest" target="_blank"
                               href="http://pinterest.com/pin/create/button/?url=http://jssor.com&media=http://jssor.com/img/site/jssor.slider.jpg&description=jQuery%20Image%20Slider/Slideshow/Carousel/Gallery/Banner%20javascript+html%20TOUCH%20SWIPE%20Responsive"
                               title="Share on Pinterst"></a>
                            <a class="share-icon share-email" target="_blank"
                               href="mailto:?Subject=Jssor%20Slider&Body=Highly%20recommended%20jQuery%20Image%20Slider/Slideshow/Carousel/Gallery/Banner%20javascript+html%20TOUCH%20SWIPE%20Responsive%20http://jssor.com"
                               title="Share by Email"></a>
                        </div>
                        <!-- Example to add fixed static share buttons in slider END -->
                    </div>

                    <!-- Bullet Navigator Skin Begin -->
                    <style>
                        /* jssor slider bullet navigator skin 21 css */
                        /*
                        .jssorb21 div           (normal)
                        .jssorb21 div:hover     (normal mouseover)
                        .jssorb21 .av           (active)
                        .jssorb21 .av:hover     (active mouseover)
                        .jssorb21 .dn           (mousedown)
                        */
                        .jssorb21 div, .jssorb21 div:hover, .jssorb21 .av {
                            background: url({{App::make('url')->to('/')}}/theme/banader/css/images/b21.png) no-repeat;
                            overflow: hidden;
                            cursor: pointer;
                        }

                        .jssorb21 div {
                            background-position: -5px -5px;
                        }

                        .jssorb21 div:hover, .jssorb21 .av:hover {
                            background-position: -35px -5px;
                        }

                        .jssorb21 .av {
                            background-position: -65px -5px;
                        }

                        .jssorb21 .dn, .jssorb21 .dn:hover {
                            background-position: -95px -5px;
                        }
                    </style>
                    <!-- bullet navigator container -->
                    <div u="navigator" class="jssorb21" style="position: absolute; bottom: 26px; left: 6px;">
                        <!-- bullet navigator item prototype -->
                        <div u="prototype" style="POSITION: absolute; WIDTH: 19px; HEIGHT: 19px; text-align:center; line-height:19px; color:White; font-size:12px;"></div>
                    </div>
                    <!-- Bullet Navigator Skin End -->
                    <!-- Arrow Navigator Skin Begin -->
                    <style>
                        /* jssor slider arrow navigator skin 21 css */
                        /*
                        .jssora21l              (normal)
                        .jssora21r              (normal)
                        .jssora21l:hover        (normal mouseover)
                        .jssora21r:hover        (normal mouseover)
                        .jssora21ldn            (mousedown)
                        .jssora21rdn            (mousedown)
                        */
                        .jssora21l, .jssora21r, .jssora21ldn, .jssora21rdn {
                            position: absolute;
                            cursor: pointer;
                            display: block;
                            background: url({{App::make('url')->to('/')}}/theme/banader/css/images/a21.png) center center no-repeat;
                            overflow: hidden;
                        }

                        .jssora21l {
                            background-position: -3px -33px;
                        }

                        .jssora21r {
                            background-position: -63px -33px;
                        }

                        .jssora21l:hover {
                            background-position: -123px -33px;
                        }

                        .jssora21r:hover {
                            background-position: -183px -33px;
                        }

                        .jssora21ldn {
                            background-position: -243px -33px;
                        }

                        .jssora21rdn {
                            background-position: -303px -33px;
                        }
                    </style>
                    <!-- Arrow Left -->
                    <span u="arrowleft" class="jssora21l" style="width: 55px; height: 55px; top: 123px; left: 8px;">
            </span>
                    <!-- Arrow Right -->
                    <span u="arrowright" class="jssora21r" style="width: 55px; height: 55px; top: 123px; right: 8px">
            </span>
                    <!-- Arrow Navigator Skin End -->
                    <a style="display: none" href="http://www.jssor.com">responsive slider jquery</a>
                </div>
                <!-- Jssor Slider End -->

                <div class="container-fluid">

                    <div class="row">

                        <div class="col-xs-12 col-md-12">

                            <div class="col-md-6 col-sm-6 col-xs-12 noPadding pull-right">
                                <h1 class="blueHeader">دائره المعارف جامع دریایی و بندری</h1>
                                <div>

                                    <div id="slider2_container" class="daneshSlider shadowBox" style="position: relative; top:0; left: 0; width: 790px; height: 340px; overflow: hidden;float:right; ">

                                        <!-- Loading Screen -->
                                        <div u="loading" style="position: absolute; top: 0; left: 0;">
                                            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;background-color: #000; top: 0; left: 0;width: 100%;height:100%;">
                                            </div>
                                            <div style="position: absolute; display: block; background: url({{App::make('url')->to('/')}}/theme/banader/img/loading.gif) no-repeat center center;top: 0; left: 0;width: 100%;height:100%;">
                                            </div>
                                        </div>

                                        <!-- Slides Container -->
                                        <div u="slides" class="slideHolder" style="cursor: move; position: absolute; left: 0; top:20px; width: 790px; height: 300px; overflow: hidden;">
                                            <div>

                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/danesh-04.jpg" class="pull-right"/>
                                                    <p class="pull-right">
                                                        محیط زیست دریایی
                                                        به قلم حسین سیدی
                                                        3 روز پیش
                                                    </p>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/danesh-01.jpg" class="pull-right"/>
                                                    <p class="pull-right">
                                                        محیط زیست دریایی
                                                        به قلم حسین سیدی
                                                        3 روز پیش
                                                    </p>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/danesh-02.jpg" class="pull-right"/>
                                                    <p class="pull-right">
                                                        محیط زیست دریایی
                                                        به قلم حسین سیدی
                                                        3 روز پیش
                                                    </p>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/danesh-03.jpg" class="pull-right"/>
                                                    <p class="pull-right">
                                                        محیط زیست دریایی
                                                        به قلم حسین سیدی
                                                        3 روز پیش
                                                    </p>
                                                    <div class="clearfix"></div>
                                                </div>

                                            </div>
                                            <div>
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/danesh-04.jpg" class="pull-right"/>
                                                    <p class="pull-right">
                                                        محیط زیست دریایی
                                                        به قلم حسین سیدی
                                                        3 روز پیش
                                                    </p>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/danesh-01.jpg" class="pull-right"/>
                                                    <p class="pull-right">
                                                        محیط زیست دریایی
                                                        به قلم حسین سیدی
                                                        3 روز پیش
                                                    </p>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/danesh-02.jpg" class="pull-right"/>
                                                    <p class="pull-right">
                                                        محیط زیست دریایی
                                                        به قلم حسین سیدی
                                                        3 روز پیش
                                                    </p>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/danesh-03.jpg" class="pull-right"/>
                                                    <p class="pull-right">
                                                        محیط زیست دریایی
                                                        به قلم حسین سیدی
                                                        3 روز پیش
                                                    </p>
                                                    <div class="clearfix"></div>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Bullet Navigator Skin Begin -->
                                        <!-- jssor slider bullet navigator skin 01 -->
                                        <style>
                                            /*
                                            .jssorb01 div           (normal)
                                            .jssorb01 div:hover     (normal mouseover)
                                            .jssorb01 .av           (active)
                                            .jssorb01 .av:hover     (active mouseover)
                                            .jssorb01 .dn           (mousedown)
                                            */
                                            .jssorb01 div, .jssorb01 div:hover, .jssorb01 .av {
                                                filter: alpha(opacity=70);
                                                opacity: .7;
                                                overflow: hidden;
                                                cursor: pointer;
                                                border: #000 1px solid;
                                            }

                                            .jssorb01 div {
                                                background-color: gray;
                                            }

                                            .jssorb01 div:hover, .jssorb01 .av:hover {
                                                background-color: #d3d3d3;
                                            }

                                            .jssorb01 .av {
                                                background-color: #fff;
                                            }

                                            .jssorb01 .dn, .jssorb01 .dn:hover {
                                                background-color: #555555;
                                            }
                                        </style>
                                        <!-- bullet navigator container -->
                                        <div u="navigator" class="jssorb03" style="position: absolute; bottom: 4px; right: 0;left:0;margin:0 auto">
                                            <!-- bullet navigator item prototype -->
                                            <div u="prototype" style="position: absolute; width: 21px; height: 21px; text-align:center; line-height:21px; color:#a3a3a3; font-size:12px;">
                                                <numbertemplate></numbertemplate>
                                            </div>
                                        </div>
                                        <!-- Bullet Navigator Skin End -->
                                        <!-- Arrow Navigator Skin Begin -->
                                        <style>
                                            /* jssor slider arrow navigator skin 02 css */
                                            /*
                                            .jssora02l              (normal)
                                            .jssora02r              (normal)
                                            .jssora02l:hover        (normal mouseover)
                                            .jssora02r:hover        (normal mouseover)
                                            .jssora02ldn            (mousedown)
                                            .jssora02rdn            (mousedown)
                                            */

                                            .jssorb03 {
                                                cursor: pointer;
                                            }

                                            .jssorb03 .av {
                                                background-color: #1b8ed1;
                                            }

                                            .jssora02l, .jssora02r, .jssora02ldn, .jssora02rdn {
                                                position: absolute;
                                                cursor: pointer;
                                                display: block;
                                                background: url({{App::make('url')->to('/')}}/theme/banader/css/images/a15.png) no-repeat;
                                                overflow: hidden;
                                            }

                                            .jssora02l {
                                                background-position: -3px -33px;
                                            }

                                            .jssora02r {
                                                background-position: -63px -33px;
                                            }

                                            .jssora02l:hover {
                                                background-position: -123px -33px;
                                            }

                                            .jssora02r:hover {
                                                background-position: -183px -33px;
                                            }

                                            .jssora02ldn {
                                                background-position: -243px -33px;
                                            }

                                            .jssora02rdn {
                                                background-position: -303px -33px;
                                            }
                                        </style>
                                        <!-- Arrow Left -->
                                        <span u="arrowleft" class="jssora02l" style="width: 55px; height: 55px;bottom:0; left: 8px;">
                                </span>
                                        <!-- Arrow Right -->
                                        <span u="arrowright" class="jssora02r" style="width: 55px; height: 55px; bottom: 0; right: 8px">
                                </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 noLeftPadding">
                                <h1 class="blueHeader">شبکه اجتماعی</h1>
                                <div>

                                    <!-- Jssor Slider Begin -->
                                    <!-- You can move inline styles to css file or css block. -->
                                    <div id="slider3_container" class="shadowBox" style="position: relative; top: 0; right: 0; width: 701px; height: 309px; background: #fff; overflow: hidden; ">

                                        <!-- Slides Container -->
                                        <div u="slides" style="cursor: move; position: absolute; right: 99px; top: 0; width: 600px; height: 300px; background-color: #fff; overflow: hidden;">
                                            <div>
                                                <div style="margin: 10px; overflow: hidden; color: #000;">

                                                    <div id="slider4_container" class="socialSlider" style="position: relative; top: 0; left: 0; width: 600px; height: 300px; overflow: hidden;float:right; ">

                                                        <!-- Loading Screen -->
                                                        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                                                            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
                                                            </div>
                                                            <div style="position: absolute; display: block; background: url({{App::make('url')->to('/')}}/theme/banader/img/loading.gif) no-repeat center center;top: 0px; left: 0px;width: 100%;height:100%;">
                                                            </div>
                                                        </div>

                                                        <!-- Slides Container -->
                                                        <div u="slides" class="slideHolder" style="cursor: move; position: absolute; left: 0; top: 0; width: 600px; height: 300px; overflow: hidden;">
                                                            <div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-01.png" class="img-responsive"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-02.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-03.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="clearfix"></div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-04.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-05.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-06.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>

                                                            <div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-01.png" class="img-responsive"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-02.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-03.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="clearfix"></div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-04.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-05.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-06.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <!-- Bullet Navigator Skin Begin -->
                                                        <!-- jssor slider bullet navigator skin 01 -->
                                                        <style>
                                                            /*
                                                            .jssorb01 div           (normal)
                                                            .jssorb01 div:hover     (normal mouseover)
                                                            .jssorb01 .av           (active)
                                                            .jssorb01 .av:hover     (active mouseover)
                                                            .jssorb01 .dn           (mousedown)
                                                            */
                                                            .jssorb01 div, .jssorb01 div:hover, .jssorb01 .av {
                                                                filter: alpha(opacity=70);
                                                                opacity: .7;
                                                                overflow: hidden;
                                                                cursor: pointer;
                                                                border: #000 1px solid;
                                                            }

                                                            .jssorb01 div {
                                                                background-color: gray;
                                                            }

                                                            .jssorb01 div:hover, .jssorb01 .av:hover {
                                                                background-color: #d3d3d3;
                                                            }

                                                            .jssorb01 .av {
                                                                background-color: #fff;
                                                            }

                                                            .jssorb01 .dn, .jssorb01 .dn:hover {
                                                                background-color: #555555;
                                                            }
                                                        </style>
                                                        <!-- bullet navigator container -->
                                                        <div u="navigator" class="jssorb03" style="position: absolute; bottom: 4px; right: 0;left:0;margin:0 auto">
                                                            <!-- bullet navigator item prototype -->
                                                            <div u="prototype" style="position: absolute; width: 21px; height: 21px; text-align:center; line-height:21px; color:#a3a3a3; font-size:12px;">
                                                                <numbertemplate></numbertemplate>
                                                            </div>
                                                        </div>
                                                        <!-- Bullet Navigator Skin End -->
                                                        <!-- Arrow Navigator Skin Begin -->
                                                        <style>
                                                            /* jssor slider arrow navigator skin 02 css */
                                                            /*
                                                            .jssora02l              (normal)
                                                            .jssora02r              (normal)
                                                            .jssora02l:hover        (normal mouseover)
                                                            .jssora02r:hover        (normal mouseover)
                                                            .jssora02ldn            (mousedown)
                                                            .jssora02rdn            (mousedown)
                                                            */

                                                            .jssorb03 {
                                                                cursor: pointer;
                                                            }

                                                            .jssorb03 .av {
                                                                background-color: #1b8ed1;
                                                            }

                                                            .jssora02l, .jssora02r, .jssora02ldn, .jssora02rdn {
                                                                position: absolute;
                                                                cursor: pointer;
                                                                display: block;
                                                                background: url({{App::make('url')->to('/')}}/theme/banader/css/images/a15.png) no-repeat;
                                                                overflow: hidden;
                                                            }

                                                            .jssora02l {
                                                                background-position: -3px -33px;
                                                            }

                                                            .jssora02r {
                                                                background-position: -63px -33px;
                                                            }

                                                            .jssora02l:hover {
                                                                background-position: -123px -33px;
                                                            }

                                                            .jssora02r:hover {
                                                                background-position: -183px -33px;
                                                            }

                                                            .jssora02ldn {
                                                                background-position: -243px -33px;
                                                            }

                                                            .jssora02rdn {
                                                                background-position: -303px -33px;
                                                            }
                                                        </style>
                                                        <!-- Arrow Left -->
                                                        <span u="arrowleft" class="jssora02l" style="width: 55px; height: 55px;bottom:0; left: 8px;">
                                                </span>
                                                        <!-- Arrow Right -->
                                                        <span u="arrowright" class="jssora02r" style="width: 55px; height: 55px; bottom: 0; right: 8px">
                                                </span>
                                                        <!-- Arrow Navigator Skin End -->
                                                        <a style="display: none" href="http://www.jssor.com">responsive slider jquery</a>
                                                    </div>

                                                </div>
                                                <div u="thumb">
                                                    <span>افراد</span>
                                                </div>
                                            </div>
                                            <div>
                                                <div style="margin: 10px; overflow: hidden; color: #000;">
                                                    <div id="slider5_container" class="socialSlider" style="position: relative; top: 0; left: 0; width: 600px; height: 300px; overflow: hidden;float:right; ">

                                                        <!-- Loading Screen -->
                                                        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                                                            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
                                                            </div>
                                                            <div style="position: absolute; display: block; background: url({{App::make('url')->to('/')}}/theme/banader/img/loading.gif) no-repeat center center;top: 0px; left: 0px;width: 100%;height:100%;">
                                                            </div>
                                                        </div>

                                                        <!-- Slides Container -->
                                                        <div u="slides" class="slideHolder" style="cursor: move; position: absolute; left: 0; top: 0; width: 600px; height: 300px; overflow: hidden;">
                                                            <div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-01.png" class="img-responsive"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-02.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-03.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="clearfix"></div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-04.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-05.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-06.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>

                                                            <div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-01.png" class="img-responsive"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-02.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-03.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="clearfix"></div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-04.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-05.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-06.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <!-- Bullet Navigator Skin Begin -->
                                                        <!-- jssor slider bullet navigator skin 01 -->
                                                        <style>
                                                            /*
                                                            .jssorb01 div           (normal)
                                                            .jssorb01 div:hover     (normal mouseover)
                                                            .jssorb01 .av           (active)
                                                            .jssorb01 .av:hover     (active mouseover)
                                                            .jssorb01 .dn           (mousedown)
                                                            */
                                                            .jssorb01 div, .jssorb01 div:hover, .jssorb01 .av {
                                                                filter: alpha(opacity=70);
                                                                opacity: .7;
                                                                overflow: hidden;
                                                                cursor: pointer;
                                                                border: #000 1px solid;
                                                            }

                                                            .jssorb01 div {
                                                                background-color: gray;
                                                            }

                                                            .jssorb01 div:hover, .jssorb01 .av:hover {
                                                                background-color: #d3d3d3;
                                                            }

                                                            .jssorb01 .av {
                                                                background-color: #fff;
                                                            }

                                                            .jssorb01 .dn, .jssorb01 .dn:hover {
                                                                background-color: #555555;
                                                            }
                                                        </style>
                                                        <!-- bullet navigator container -->
                                                        <div u="navigator" class="jssorb03" style="position: absolute; bottom: 4px; right: 0;left:0;margin:0 auto">
                                                            <!-- bullet navigator item prototype -->
                                                            <div u="prototype" style="position: absolute; width: 21px; height: 21px; text-align:center; line-height:21px; color:#a3a3a3; font-size:12px;">
                                                                <numbertemplate></numbertemplate>
                                                            </div>
                                                        </div>
                                                        <!-- Bullet Navigator Skin End -->
                                                        <!-- Arrow Navigator Skin Begin -->
                                                        <style>
                                                            /* jssor slider arrow navigator skin 02 css */
                                                            /*
                                                            .jssora02l              (normal)
                                                            .jssora02r              (normal)
                                                            .jssora02l:hover        (normal mouseover)
                                                            .jssora02r:hover        (normal mouseover)
                                                            .jssora02ldn            (mousedown)
                                                            .jssora02rdn            (mousedown)
                                                            */

                                                            .jssorb03 {
                                                                cursor: pointer;
                                                            }

                                                            .jssorb03 .av {
                                                                background-color: #1b8ed1;
                                                            }

                                                            .jssora02l, .jssora02r, .jssora02ldn, .jssora02rdn {
                                                                position: absolute;
                                                                cursor: pointer;
                                                                display: block;
                                                                background: url({{App::make('url')->to('/')}}/theme/banader/css/images/a15.png) no-repeat;
                                                                overflow: hidden;
                                                            }

                                                            .jssora02l {
                                                                background-position: -3px -33px;
                                                            }

                                                            .jssora02r {
                                                                background-position: -63px -33px;
                                                            }

                                                            .jssora02l:hover {
                                                                background-position: -123px -33px;
                                                            }

                                                            .jssora02r:hover {
                                                                background-position: -183px -33px;
                                                            }

                                                            .jssora02ldn {
                                                                background-position: -243px -33px;
                                                            }

                                                            .jssora02rdn {
                                                                background-position: -303px -33px;
                                                            }
                                                        </style>
                                                        <!-- Arrow Left -->
                                                        <span u="arrowleft" class="jssora02l" style="width: 55px; height: 55px;bottom:0; left: 8px;">
                                                </span>
                                                        <!-- Arrow Right -->
                                                        <span u="arrowright" class="jssora02r" style="width: 55px; height: 55px; bottom: 0; right: 8px">
                                                </span>
                                                        <!-- Arrow Navigator Skin End -->
                                                        <a style="display: none" href="http://www.jssor.com">responsive slider jquery</a>
                                                    </div>
                                                </div>
                                                <div u="thumb">
                                                    <span>گروه‌ها</span>
                                                </div>
                                            </div>
                                            <div>
                                                <div style="margin: 10px; overflow: hidden; color: #000;">
                                                    <div id="slider6_container" class="socialSlider" style="position: relative; top: 0; left: 0; width: 600px; height: 300px; overflow: hidden;float:right; ">

                                                        <!-- Loading Screen -->
                                                        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                                                            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
                                                            </div>
                                                            <div style="position: absolute; display: block; background: url({{App::make('url')->to('/')}}/theme/banader/img/loading.gif) no-repeat center center;top: 0px; left: 0px;width: 100%;height:100%;">
                                                            </div>
                                                        </div>

                                                        <!-- Slides Container -->
                                                        <div u="slides" class="slideHolder" style="cursor: move; position: absolute; left: 0; top: 0; width: 600px; height: 300px; overflow: hidden;">
                                                            <div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-01.png" class="img-responsive"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-02.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-03.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="clearfix"></div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-04.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-05.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-06.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>

                                                            <div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-01.png" class="img-responsive"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-02.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-03.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="clearfix"></div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-04.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-05.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-06.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <!-- Bullet Navigator Skin Begin -->
                                                        <!-- jssor slider bullet navigator skin 01 -->
                                                        <style>
                                                            /*
                                                            .jssorb01 div           (normal)
                                                            .jssorb01 div:hover     (normal mouseover)
                                                            .jssorb01 .av           (active)
                                                            .jssorb01 .av:hover     (active mouseover)
                                                            .jssorb01 .dn           (mousedown)
                                                            */
                                                            .jssorb01 div, .jssorb01 div:hover, .jssorb01 .av {
                                                                filter: alpha(opacity=70);
                                                                opacity: .7;
                                                                overflow: hidden;
                                                                cursor: pointer;
                                                                border: #000 1px solid;
                                                            }

                                                            .jssorb01 div {
                                                                background-color: gray;
                                                            }

                                                            .jssorb01 div:hover, .jssorb01 .av:hover {
                                                                background-color: #d3d3d3;
                                                            }

                                                            .jssorb01 .av {
                                                                background-color: #fff;
                                                            }

                                                            .jssorb01 .dn, .jssorb01 .dn:hover {
                                                                background-color: #555555;
                                                            }
                                                        </style>
                                                        <!-- bullet navigator container -->
                                                        <div u="navigator" class="jssorb03" style="position: absolute; bottom: 4px; right: 0;left:0;margin:0 auto">
                                                            <!-- bullet navigator item prototype -->
                                                            <div u="prototype" style="position: absolute; width: 21px; height: 21px; text-align:center; line-height:21px; color:#a3a3a3; font-size:12px;">
                                                                <numbertemplate></numbertemplate>
                                                            </div>
                                                        </div>
                                                        <!-- Bullet Navigator Skin End -->
                                                        <!-- Arrow Navigator Skin Begin -->
                                                        <style>
                                                            /* jssor slider arrow navigator skin 02 css */
                                                            /*
                                                            .jssora02l              (normal)
                                                            .jssora02r              (normal)
                                                            .jssora02l:hover        (normal mouseover)
                                                            .jssora02r:hover        (normal mouseover)
                                                            .jssora02ldn            (mousedown)
                                                            .jssora02rdn            (mousedown)
                                                            */

                                                            .jssorb03 {
                                                                cursor: pointer;
                                                            }

                                                            .jssorb03 .av {
                                                                background-color: #1b8ed1;
                                                            }

                                                            .jssora02l, .jssora02r, .jssora02ldn, .jssora02rdn {
                                                                position: absolute;
                                                                cursor: pointer;
                                                                display: block;
                                                                background: url({{App::make('url')->to('/')}}/theme/banader/css/images/a15.png) no-repeat;
                                                                overflow: hidden;
                                                            }

                                                            .jssora02l {
                                                                background-position: -3px -33px;
                                                            }

                                                            .jssora02r {
                                                                background-position: -63px -33px;
                                                            }

                                                            .jssora02l:hover {
                                                                background-position: -123px -33px;
                                                            }

                                                            .jssora02r:hover {
                                                                background-position: -183px -33px;
                                                            }

                                                            .jssora02ldn {
                                                                background-position: -243px -33px;
                                                            }

                                                            .jssora02rdn {
                                                                background-position: -303px -33px;
                                                            }
                                                        </style>
                                                        <!-- Arrow Left -->
                                                        <span u="arrowleft" class="jssora02l" style="width: 55px; height: 55px;bottom:0; left: 8px;">
                                                </span>
                                                        <!-- Arrow Right -->
                                                        <span u="arrowright" class="jssora02r" style="width: 55px; height: 55px; bottom: 0; right: 8px">
                                                </span>
                                                        <!-- Arrow Navigator Skin End -->
                                                        <a style="display: none" href="http://www.jssor.com">responsive slider jquery</a>
                                                    </div>
                                                </div>
                                                <div u="thumb">
                                                    <span>سازمان ها</span>
                                                </div>
                                            </div>
                                            <div>
                                                <div style="margin: 10px; overflow: hidden; color: #000;">
                                                    <div id="slider7_container" class="socialSlider" style="position: relative; top: 0; left: 0; width: 600px; height: 300px; overflow: hidden;float:right; ">

                                                        <!-- Loading Screen -->
                                                        <div u="loading" style="position: absolute; top: 0; left: 0;">
                                                            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;background-color: #000; top: 0; left: 0;width: 100%;height:100%;">
                                                            </div>
                                                            <div style="position: absolute; display: block; background: url({{App::make('url')->to('/')}}/theme/banader/img/loading.gif) no-repeat center center;top: 0; left: 0;width: 100%;height:100%;">
                                                            </div>
                                                        </div>

                                                        <!-- Slides Container -->
                                                        <div u="slides" class="slideHolder" style="cursor: move; position: absolute; left: 0; top: 0; width: 600px; height: 300px; overflow: hidden;">
                                                            <div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-01.png" class="img-responsive"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-02.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-03.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="clearfix"></div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-04.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-05.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-06.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>

                                                            <div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-01.png" class="img-responsive"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-02.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-03.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="clearfix"></div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-04.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-05.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/social-06.png"/>
                                                                    <span>ارتش جمهوری اسلامی</span>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <!-- Bullet Navigator Skin Begin -->
                                                        <!-- jssor slider bullet navigator skin 01 -->
                                                        <style>
                                                            /*
                                                            .jssorb01 div           (normal)
                                                            .jssorb01 div:hover     (normal mouseover)
                                                            .jssorb01 .av           (active)
                                                            .jssorb01 .av:hover     (active mouseover)
                                                            .jssorb01 .dn           (mousedown)
                                                            */
                                                            .jssorb01 div, .jssorb01 div:hover, .jssorb01 .av {
                                                                filter: alpha(opacity=70);
                                                                opacity: .7;
                                                                overflow: hidden;
                                                                cursor: pointer;
                                                                border: #000 1px solid;
                                                            }

                                                            .jssorb01 div {
                                                                background-color: gray;
                                                            }

                                                            .jssorb01 div:hover, .jssorb01 .av:hover {
                                                                background-color: #d3d3d3;
                                                            }

                                                            .jssorb01 .av {
                                                                background-color: #fff;
                                                            }

                                                            .jssorb01 .dn, .jssorb01 .dn:hover {
                                                                background-color: #555555;
                                                            }
                                                        </style>
                                                        <!-- bullet navigator container -->
                                                        <div u="navigator" class="jssorb03" style="position: absolute; bottom: 4px; right: 0;left:0;margin:0 auto">
                                                            <!-- bullet navigator item prototype -->
                                                            <div u="prototype" style="position: absolute; width: 21px; height: 21px; text-align:center; line-height:21px; color:#a3a3a3; font-size:12px;">
                                                                <numbertemplate></numbertemplate>
                                                            </div>
                                                        </div>
                                                        <!-- Bullet Navigator Skin End -->
                                                        <!-- Arrow Navigator Skin Begin -->
                                                        <style>
                                                            /* jssor slider arrow navigator skin 02 css */
                                                            /*
                                                            .jssora02l              (normal)
                                                            .jssora02r              (normal)
                                                            .jssora02l:hover        (normal mouseover)
                                                            .jssora02r:hover        (normal mouseover)
                                                            .jssora02ldn            (mousedown)
                                                            .jssora02rdn            (mousedown)
                                                            */

                                                            .jssorb03 {
                                                                cursor: pointer;
                                                            }

                                                            .jssorb03 .av {
                                                                background-color: #1b8ed1;
                                                            }

                                                            .jssora02l, .jssora02r, .jssora02ldn, .jssora02rdn {
                                                                position: absolute;
                                                                cursor: pointer;
                                                                display: block;
                                                                background: url({{App::make('url')->to('/')}}/theme/banader/css/images/a15.png) no-repeat;
                                                                overflow: hidden;
                                                            }

                                                            .jssora02l {
                                                                background-position: -3px -33px;
                                                            }

                                                            .jssora02r {
                                                                background-position: -63px -33px;
                                                            }

                                                            .jssora02l:hover {
                                                                background-position: -123px -33px;
                                                            }

                                                            .jssora02r:hover {
                                                                background-position: -183px -33px;
                                                            }

                                                            .jssora02ldn {
                                                                background-position: -243px -33px;
                                                            }

                                                            .jssora02rdn {
                                                                background-position: -303px -33px;
                                                            }
                                                        </style>
                                                        <!-- Arrow Left -->
                                                        <span u="arrowleft" class="jssora02l" style="width: 55px; height: 55px;bottom:0; left: 8px;">
                                                </span>
                                                        <!-- Arrow Right -->
                                                        <span u="arrowright" class="jssora02r" style="width: 55px; height: 55px; bottom: 0; right: 8px">
                                                </span>
                                                        <!-- Arrow Navigator Skin End -->
                                                        <a style="display: none" href="http://www.jssor.com">responsive slider jquery</a>
                                                    </div>
                                                </div>
                                                <div u="thumb">
                                                    <span>شرکت ها</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ThumbnailNavigator Skin Begin -->
                                        <div u="thumbnavigator" class="jssort13" style="position: absolute; width: 100px; height: 250px; right: -1px; top: 0;border-left: 1px solid #d1d1d1">
                                            <!-- Thumbnail Item Skin Begin -->
                                            <style>
                                                /* jssor slider thumbnail navigator skin 13 css */
                                                /*
                                                .jssort13 .p            (normal)
                                                .jssort13 .p:hover      (normal mouseover)
                                                .jssort13 .pav          (active)
                                                .jssort13 .pav:hover    (active mouseover)
                                                .jssort13 .pdn          (mousedown)
                                                */
                                                .jssort13 .w, .jssort13 .phv .w {
                                                    cursor: pointer;
                                                    position: absolute;
                                                    WIDTH: 98px;
                                                    HEIGHT: 60px;
                                                    top: -1px;
                                                    left: 0;
                                                }

                                                .jssort13 .pav .w, .jssort13 .pdn .w {
                                                    border-right: 1px solid #fff;
                                                }

                                                .jssort13 .c {
                                                    color: #000;
                                                    font-size: 13px;
                                                }

                                                .jssort13 .p .c, .c {
                                                    background-color: #fff;
                                                    font: normal 20px Mitra;
                                                }

                                                .jssort13 span {
                                                    margin: 15px 0 0 0;
                                                    display: block;
                                                }

                                                .jssort13 .pav .c, .jssort13 .p:hover .c, .jssort13 .phv .c {
                                                    background-color: #d1d1d1;
                                                    color: #000;
                                                    font: normal 20px Mitra;
                                                }
                                            </style>
                                            <div u="slides" style="cursor: move; top:0; left:0;">
                                                <div u="prototype" class="p" style="POSITION: absolute; WIDTH: 100px; HEIGHT: 61px; TOP: 0; LEFT: 0; padding:0px;">
                                                    <div class=w>
                                                        <thumbnailtemplate class="c" style=" WIDTH: 100%; HEIGHT: 100%; position:absolute; TOP: 0; LEFT: 0; line-height:28px; text-align:center;"></thumbnailtemplate>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Thumbnail Item Skin End -->
                                        </div>
                                        <!-- ThumbnailNavigator Skin End -->
                                    </div>
                                    <!-- Jssor Slider End -->
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-xs-12 col-md-12">
                            <div class="col-md-6 col-xs-12 col-sm-6 pull-right noPadding">

                                <h1 class="blueHeader">کتابخانه</h1>
                                <div>
                                    <!-- Jssor Slider Begin -->
                                    <!-- You can move inline styles to css file or css block. -->
                                    <div id="slider8_container" class="shadowBox" style="position: relative; top: 0; left: 0; width: 790px; height:391px; background: #fff; overflow: hidden; ">

                                        <!-- Slides Container -->
                                        <div u="slides" style="cursor: move; position: absolute; right: 0; top: 29px; width:790px; height: 390px;background-color: #fff; overflow: hidden;">

                                            <div>
                                                <div style="margin: 10px; overflow: hidden; color: #000;">
                                                    <div style="margin: 10px; overflow: hidden; color: #000;">
                                                        <div id="slider12_container" class="librarySlider" style="position: relative; top: 0; left: 0; width: 790px; height: 390px; overflow: hidden;float:right; ">

                                                            <!-- Loading Screen -->
                                                            <div u="loading" style="position: absolute; top: 0; left: 0;">
                                                                <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;background-color: #000; top: 0; left: 0;width: 100%;height:100%;">
                                                                </div>
                                                                <div style="position: absolute; display: block; background: url({{App::make('url')->to('/')}}/theme/banader/img/loading.gif) no-repeat center center;top: 0; left: 0;width: 100%;height:100%;">
                                                                </div>
                                                            </div>

                                                            <!-- Slides Container -->
                                                            <div u="slides" class="slideHolder" style="cursor: move; position: absolute; left: 0; top: 0; width: 790px; height: 390px; overflow: hidden;">
                                                                <div>
                                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                                        <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                        <span class="arrow-up"></span>
                                                                        <p>
                                                                            نقش حاکمیتی شهرداری
                                                                            چاپ دوم
                                                                            محمد حوضی
                                                                        </p>
                                                                        <div class="clearfix"></div>
                                                                    </div>

                                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                                        <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                        <span class="arrow-up"></span>
                                                                        <p>
                                                                            نقش حاکمیتی شهرداری
                                                                            چاپ دوم
                                                                            محمد حوضی
                                                                        </p>
                                                                        <div class="clearfix"></div>
                                                                    </div>

                                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                                        <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                        <span class="arrow-up"></span>
                                                                        <p>
                                                                            نقش حاکمیتی شهرداری
                                                                            چاپ دوم
                                                                            محمد حوضی
                                                                        </p>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                </div>
                                                                <div>

                                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                                        <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                        <span class="arrow-up"></span>
                                                                        <p>
                                                                            نقش حاکمیتی شهرداری
                                                                            چاپ دوم
                                                                            محمد حوضی
                                                                        </p>
                                                                        <div class="clearfix"></div>
                                                                    </div>

                                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                                        <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                        <span class="arrow-up"></span>
                                                                        <p>
                                                                            نقش حاکمیتی شهرداری
                                                                            چاپ دوم
                                                                            محمد حوضی
                                                                        </p>
                                                                        <div class="clearfix"></div>
                                                                    </div>

                                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                                        <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                        <span class="arrow-up"></span>
                                                                        <p>
                                                                            نقش حاکمیتی شهرداری
                                                                            چاپ دوم
                                                                            محمد حوضی
                                                                        </p>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Arrow Navigator Skin Begin -->
                                                            <style>
                                                                /* jssor slider arrow navigator skin 02 css */
                                                                /*
                                                                .jssora02l              (normal)
                                                                .jssora02r              (normal)
                                                                .jssora02l:hover        (normal mouseover)
                                                                .jssora02r:hover        (normal mouseover)
                                                                .jssora02ldn            (mousedown)
                                                                .jssora02rdn            (mousedown)
                                                                */

                                                                .jssorb03 {
                                                                    cursor: pointer;
                                                                }

                                                                .jssorb03 .av {
                                                                    background-color: #1b8ed1;
                                                                }

                                                                .jssora02l, .jssora02r, .jssora02ldn, .jssora02rdn {
                                                                    position: absolute;
                                                                    cursor: pointer;
                                                                    display: block;
                                                                    background: url({{App::make('url')->to('/')}}/theme/banader/css/images/a15.png) no-repeat;
                                                                    overflow: hidden;
                                                                }

                                                                .jssora02l {
                                                                    background-position: -3px -33px;
                                                                }

                                                                .jssora02r {
                                                                    background-position: -63px -33px;
                                                                }

                                                                .jssora02l:hover {
                                                                    background-position: -123px -33px;
                                                                }

                                                                .jssora02r:hover {
                                                                    background-position: -183px -33px;
                                                                }

                                                                .jssora02ldn {
                                                                    background-position: -243px -33px;
                                                                }

                                                                .jssora02rdn {
                                                                    background-position: -303px -33px;
                                                                }
                                                            </style>
                                                            <!-- Arrow Left -->
                                                            <span u="arrowleft" class="jssora02l" style="width: 55px; height: 55px;top:40%; left:-5px;">
                                                    </span>
                                                            <!-- Arrow Right -->
                                                            <span u="arrowright" class="jssora02r" style="width: 55px; height: 55px;top:40%; right:-5px">
                                                    </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div u="thumb">نشریات</div>
                                            </div>
                                            <div>
                                                <div style="margin: 10px; overflow: hidden; color: #000;">
                                                    <div style="margin: 10px; overflow: hidden; color: #000;">
                                                        <div id="slider11_container" class="librarySlider" style="position: relative; top: 0; left: 0; width: 790px; height: 390px; overflow: hidden;float:right; ">

                                                            <!-- Loading Screen -->
                                                            <div u="loading" style="position: absolute; top: 0; left: 0;">
                                                                <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;background-color: #000; top: 0; left: 0;width: 100%;height:100%;">
                                                                </div>
                                                                <div style="position: absolute; display: block; background: url({{App::make('url')->to('/')}}/theme/banader/img/loading.gif) no-repeat center center;top: 0; left: 0;width: 100%;height:100%;">
                                                                </div>
                                                            </div>

                                                            <!-- Slides Container -->
                                                            <div u="slides" class="slideHolder" style="cursor: move; position: absolute; left: 0; top: 0; width: 790px; height: 390px; overflow: hidden;">
                                                                <div>
                                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                                        <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                        <span class="arrow-up"></span>
                                                                        <p>
                                                                            نقش حاکمیتی شهرداری
                                                                            چاپ دوم
                                                                            محمد حوضی
                                                                        </p>
                                                                        <div class="clearfix"></div>
                                                                    </div>

                                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                                        <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                        <span class="arrow-up"></span>
                                                                        <p>
                                                                            نقش حاکمیتی شهرداری
                                                                            چاپ دوم
                                                                            محمد حوضی
                                                                        </p>
                                                                        <div class="clearfix"></div>
                                                                    </div>

                                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                                        <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                        <span class="arrow-up"></span>
                                                                        <p>
                                                                            نقش حاکمیتی شهرداری
                                                                            چاپ دوم
                                                                            محمد حوضی
                                                                        </p>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                </div>
                                                                <div>

                                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                                        <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                        <span class="arrow-up"></span>
                                                                        <p>
                                                                            نقش حاکمیتی شهرداری
                                                                            چاپ دوم
                                                                            محمد حوضی
                                                                        </p>
                                                                        <div class="clearfix"></div>
                                                                    </div>

                                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                                        <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                        <span class="arrow-up"></span>
                                                                        <p>
                                                                            نقش حاکمیتی شهرداری
                                                                            چاپ دوم
                                                                            محمد حوضی
                                                                        </p>
                                                                        <div class="clearfix"></div>
                                                                    </div>

                                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                                        <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                        <span class="arrow-up"></span>
                                                                        <p>
                                                                            نقش حاکمیتی شهرداری
                                                                            چاپ دوم
                                                                            محمد حوضی
                                                                        </p>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Arrow Navigator Skin Begin -->
                                                            <style>
                                                                /* jssor slider arrow navigator skin 02 css */
                                                                /*
                                                                .jssora02l              (normal)
                                                                .jssora02r              (normal)
                                                                .jssora02l:hover        (normal mouseover)
                                                                .jssora02r:hover        (normal mouseover)
                                                                .jssora02ldn            (mousedown)
                                                                .jssora02rdn            (mousedown)
                                                                */

                                                                .jssorb03 {
                                                                    cursor: pointer;
                                                                }

                                                                .jssorb03 .av {
                                                                    background-color: #1b8ed1;
                                                                }

                                                                .jssora02l, .jssora02r, .jssora02ldn, .jssora02rdn {
                                                                    position: absolute;
                                                                    cursor: pointer;
                                                                    display: block;
                                                                    background: url({{App::make('url')->to('/')}}/theme/banader/css/images/a15.png) no-repeat;
                                                                    overflow: hidden;
                                                                }

                                                                .jssora02l {
                                                                    background-position: -3px -33px;
                                                                }

                                                                .jssora02r {
                                                                    background-position: -63px -33px;
                                                                }

                                                                .jssora02l:hover {
                                                                    background-position: -123px -33px;
                                                                }

                                                                .jssora02r:hover {
                                                                    background-position: -183px -33px;
                                                                }

                                                                .jssora02ldn {
                                                                    background-position: -243px -33px;
                                                                }

                                                                .jssora02rdn {
                                                                    background-position: -303px -33px;
                                                                }
                                                            </style>
                                                            <!-- Arrow Left -->
                                                            <span u="arrowleft" class="jssora02l" style="width: 55px; height: 55px;top:40%; left:-5px;">
                                                    </span>
                                                            <!-- Arrow Right -->
                                                            <span u="arrowright" class="jssora02r" style="width: 55px; height: 55px;top:40%; right:-5px">
                                                    </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div u="thumb">پژوهش‌ها</div>
                                            </div>
                                            <div>
                                                <div style="margin: 10px; overflow: hidden; color: #000;">
                                                    <div id="slider10_container" class="librarySlider" style="position: relative; top: 0; left: 0; width: 790px; height: 390px; overflow: hidden;float:right; ">

                                                        <!-- Loading Screen -->
                                                        <div u="loading" style="position: absolute; top: 0; left: 0;">
                                                            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;background-color: #000; top: 0; left: 0;width: 100%;height:100%;">
                                                            </div>
                                                            <div style="position: absolute; display: block; background: url({{App::make('url')->to('/')}}/theme/banader/img/loading.gif) no-repeat center center;top: 0; left: 0;width: 100%;height:100%;">
                                                            </div>
                                                        </div>

                                                        <!-- Slides Container -->
                                                        <div u="slides" class="slideHolder" style="cursor: move; position: absolute; left: 0; top: 0; width: 790px; height: 390px; overflow: hidden;">
                                                            <div>
                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                    <span class="arrow-up"></span>
                                                                    <p>
                                                                        نقش حاکمیتی شهرداری
                                                                        چاپ دوم
                                                                        محمد حوضی
                                                                    </p>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                    <span class="arrow-up"></span>
                                                                    <p>
                                                                        نقش حاکمیتی شهرداری
                                                                        چاپ دوم
                                                                        محمد حوضی
                                                                    </p>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                    <span class="arrow-up"></span>
                                                                    <p>
                                                                        نقش حاکمیتی شهرداری
                                                                        چاپ دوم
                                                                        محمد حوضی
                                                                    </p>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>
                                                            <div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                    <span class="arrow-up"></span>
                                                                    <p>
                                                                        نقش حاکمیتی شهرداری
                                                                        چاپ دوم
                                                                        محمد حوضی
                                                                    </p>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                    <span class="arrow-up"></span>
                                                                    <p>
                                                                        نقش حاکمیتی شهرداری
                                                                        چاپ دوم
                                                                        محمد حوضی
                                                                    </p>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                    <span class="arrow-up"></span>
                                                                    <p>
                                                                        نقش حاکمیتی شهرداری
                                                                        چاپ دوم
                                                                        محمد حوضی
                                                                    </p>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Arrow Navigator Skin Begin -->
                                                        <style>
                                                            /* jssor slider arrow navigator skin 02 css */
                                                            /*
                                                            .jssora02l              (normal)
                                                            .jssora02r              (normal)
                                                            .jssora02l:hover        (normal mouseover)
                                                            .jssora02r:hover        (normal mouseover)
                                                            .jssora02ldn            (mousedown)
                                                            .jssora02rdn            (mousedown)
                                                            */

                                                            .jssorb03 {
                                                                cursor: pointer;
                                                            }

                                                            .jssorb03 .av {
                                                                background-color: #1b8ed1;
                                                            }

                                                            .jssora02l, .jssora02r, .jssora02ldn, .jssora02rdn {
                                                                position: absolute;
                                                                cursor: pointer;
                                                                display: block;
                                                                background: url({{App::make('url')->to('/')}}/theme/banader/css/images/a15.png) no-repeat;
                                                                overflow: hidden;
                                                            }

                                                            .jssora02l {
                                                                background-position: -3px -33px;
                                                            }

                                                            .jssora02r {
                                                                background-position: -63px -33px;
                                                            }

                                                            .jssora02l:hover {
                                                                background-position: -123px -33px;
                                                            }

                                                            .jssora02r:hover {
                                                                background-position: -183px -33px;
                                                            }

                                                            .jssora02ldn {
                                                                background-position: -243px -33px;
                                                            }

                                                            .jssora02rdn {
                                                                background-position: -303px -33px;
                                                            }
                                                        </style>
                                                        <!-- Arrow Left -->
                                                        <span u="arrowleft" class="jssora02l" style="width: 55px; height: 55px;top:40%; left:-5px;">
                                                </span>
                                                        <!-- Arrow Right -->
                                                        <span u="arrowright" class="jssora02r" style="width: 55px; height: 55px;top:40%; right:-5px">
                                                </span>
                                                    </div>
                                                </div>
                                                <div u="thumb">ماهنامه مسیر</div>
                                            </div>
                                            <div>
                                                <div style="margin: 10px; overflow: hidden; color: #000;">
                                                    <div id="slider9_container" class="librarySlider" style="position: relative; top: 0; left: 0; width: 790px; height: 390px; overflow: hidden;float:right; ">

                                                        <!-- Loading Screen -->
                                                        <div u="loading" style="position: absolute; top: 0; left: 0;">
                                                            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;background-color: #000; top: 0; left: 0;width: 100%;height:100%;">
                                                            </div>
                                                            <div style="position: absolute; display: block; background: url({{App::make('url')->to('/')}}/theme/banader/img/loading.gif) no-repeat center center;top: 0; left: 0;width: 100%;height:100%;">
                                                            </div>
                                                        </div>

                                                        <!-- Slides Container -->
                                                        <div u="slides" class="slideHolder" style="cursor: move; position: absolute; left: 0; top: 0; width: 790px; height: 390px; overflow: hidden;">
                                                            <div>
                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                    <span class="arrow-up"></span>
                                                                    <p>
                                                                        نقش حاکمیتی شهرداری
                                                                        چاپ دوم
                                                                        محمد حوضی
                                                                    </p>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                    <span class="arrow-up"></span>
                                                                    <p>
                                                                        نقش حاکمیتی شهرداری
                                                                        چاپ دوم
                                                                        محمد حوضی
                                                                    </p>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                    <span class="arrow-up"></span>
                                                                    <p>
                                                                        نقش حاکمیتی شهرداری
                                                                        چاپ دوم
                                                                        محمد حوضی
                                                                    </p>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>
                                                            <div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                    <span class="arrow-up"></span>
                                                                    <p>
                                                                        نقش حاکمیتی شهرداری
                                                                        چاپ دوم
                                                                        محمد حوضی
                                                                    </p>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                    <span class="arrow-up"></span>
                                                                    <p>
                                                                        نقش حاکمیتی شهرداری
                                                                        چاپ دوم
                                                                        محمد حوضی
                                                                    </p>
                                                                    <div class="clearfix"></div>
                                                                </div>

                                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                                    <img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg" class="img-responsive"/>
                                                                    <span class="arrow-up"></span>
                                                                    <p>
                                                                        نقش حاکمیتی شهرداری
                                                                        چاپ دوم
                                                                        محمد حوضی
                                                                    </p>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Arrow Navigator Skin Begin -->
                                                        <style>
                                                            /* jssor slider arrow navigator skin 02 css */
                                                            /*
                                                            .jssora02l              (normal)
                                                            .jssora02r              (normal)
                                                            .jssora02l:hover        (normal mouseover)
                                                            .jssora02r:hover        (normal mouseover)
                                                            .jssora02ldn            (mousedown)
                                                            .jssora02rdn            (mousedown)
                                                            */

                                                            .jssorb03 {
                                                                cursor: pointer;
                                                            }

                                                            .jssorb03 .av {
                                                                background-color: #1b8ed1;
                                                            }

                                                            .jssora02l, .jssora02r, .jssora02ldn, .jssora02rdn {
                                                                position: absolute;
                                                                cursor: pointer;
                                                                display: block;
                                                                background: url({{App::make('url')->to('/')}}/theme/banader/css/images/a15.png) no-repeat;
                                                                overflow: hidden;
                                                            }

                                                            .jssora02l {
                                                                background-position: -3px -33px;
                                                            }

                                                            .jssora02r {
                                                                background-position: -63px -33px;
                                                            }

                                                            .jssora02l:hover {
                                                                background-position: -123px -33px;
                                                            }

                                                            .jssora02r:hover {
                                                                background-position: -183px -33px;
                                                            }

                                                            .jssora02ldn {
                                                                background-position: -243px -33px;
                                                            }

                                                            .jssora02rdn {
                                                                background-position: -303px -33px;
                                                            }
                                                        </style>
                                                        <!-- Arrow Left -->
                                                        <span u="arrowleft" class="jssora02l" style="width: 55px; height: 55px;top:40%; left:-5px;">
                                                </span>
                                                        <!-- Arrow Right -->
                                                        <span u="arrowright" class="jssora02r" style="width: 55px; height: 55px;top:40%; right:-5px">
                                                </span>
                                                    </div>
                                                </div>
                                                <div u="thumb">کتابخانه</div>
                                            </div>

                                        </div>

                                        <!-- ThumbnailNavigator Skin Begin -->
                                        <div u="thumbnavigator" class="jssort12" style="position: absolute; width: 500px; height: 30px; right:-60px; top: 0;">
                                            <!-- Thumbnail Item Skin Begin -->
                                            <style>
                                                /* jssor slider thumbnail navigator skin 12 css */
                                                /*
                                                .jssort12 .p            (normal)
                                                .jssort12 .p:hover      (normal mouseover)
                                                .jssort12 .pav          (active)
                                                .jssort12 .pav:hover    (active mouseover)
                                                .jssort12 .pdn          (mousedown)
                                                */
                                                .jssort12 .w, .jssort12 .phv .w {
                                                    cursor: pointer;
                                                    position: absolute;
                                                    WIDTH: 99px;
                                                    HEIGHT: 28px;
                                                    top: 0;
                                                    left: -1px;
                                                }

                                                .jssort12 .pav .w, .jssort12 .pdn .w {
                                                    border-bottom: 1px solid #fff;
                                                }

                                                .jssort12 .c {
                                                    color: #000;
                                                    font-size: 18px;
                                                }

                                                .jssort12 .pav .c, .jssort12 .p:hover .c, .jssort12 .phv .c {
                                                    background-color: #1b8ed1;
                                                    color: #fff;
                                                }
                                            </style>
                                            <div u="slides" style="cursor: move; top:0; right:0;">
                                                <div u="prototype" class="p" style="POSITION: absolute; WIDTH: 100px; HEIGHT: 30px; TOP: 0; right: 0; padding:0;">
                                                    <div class=w>
                                                        <thumbnailtemplate class="c" style=" WIDTH: 100%; HEIGHT: 100%; position:absolute; TOP: 0; right: 0; line-height:28px; text-align:center;"></thumbnailtemplate>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Thumbnail Item Skin End -->
                                        </div>
                                    </div>
                                    <!-- Jssor Slider End -->
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12 col-sm-6 noLeftPadding">

                                <h1 class="blueHeader">اخبار</h1>

                                <div>
                                    <!-- Jssor Slider Begin -->
                                    <!-- You can move inline styles to css file or css block. -->
                                    <div id="slider13_container" class="shadowBox" style="position: relative; top: 0; left: 0; width: 790px; height:400px; background: #fff; overflow: hidden; ">

                                        <!-- Slides Container -->
                                        <div u="slides" style="cursor: move; position: absolute; right: 0; top: 29px; width:790px; height: 390px;background-color: #fff; overflow: hidden;">
                                            <div>
                                                <div style="margin: 10px; overflow: hidden; color: #000;">
                                                    <div id="slider14_container" class="newsSlider" style="position: relative; top: 0; left: 0; width: 790px; height: 400px; overflow: hidden;float:right; ">

                                                        <!-- Loading Screen -->
                                                        <div u="loading" style="position: absolute; top: 0; left: 0;">
                                                            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;background-color: #000; top: 0; left: 0;width: 100%;height:100%;">
                                                            </div>
                                                            <div style="position: absolute; display: block; background: url({{App::make('url')->to('/')}}/theme/banader/img/loading.gif) no-repeat center center;top: 0; left: 0;width: 100%;height:100%;">
                                                            </div>
                                                        </div>

                                                        <!-- Slides Container -->
                                                        <div u="slides" class="slideHolder" style="cursor: move; position: absolute; left: 0; top: 0; width: 790px; height: 300px; overflow: hidden;">
                                                            <div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>نشست انتقال تجربیات سیستم های مخابراتی VHF با حضور شرکت آلمانی</h1>
                                                                        <p>بنا به گفته مدیر کل تأمین و نگهداری تجهیزات، جلسه کارشناسی انتقال تجربیات سیستم های مخابراتی VHF با دعوت از شرکت آلمانی SCHNOOR و با حضور مدیران و کارشناسان معاونت
                                                                            های توسعه و تجهیز بنادر و امور دریایی سازمان بنادر و دریانوردی برگزار شد . . .</p>
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر</h1>
                                                                        <p>معاون امور دریایی اداره کل بنادر و دریانوردی هرمزگان ضمن اشاره به روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر گفت: کنترل خروجی لنج های صیادی و باری از بنادر
                                                                            کوچک در شرایط نامساعد جوی تا میزان 60 درصد در در کاهش سوانح اثرگذار است.</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>نشست انتقال تجربیات سیستم های مخابراتی VHF با حضور شرکت آلمانی</h1>
                                                                        <p>بنا به گفته مدیر کل تأمین و نگهداری تجهیزات، جلسه کارشناسی انتقال تجربیات سیستم های مخابراتی VHF با دعوت از شرکت آلمانی SCHNOOR و با حضور مدیران و کارشناسان معاونت
                                                                            های توسعه و تجهیز بنادر و امور دریایی سازمان بنادر و دریانوردی برگزار شد . . .</p>
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر</h1>
                                                                        <p>معاون امور دریایی اداره کل بنادر و دریانوردی هرمزگان ضمن اشاره به روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر گفت: کنترل خروجی لنج های صیادی و باری از بنادر
                                                                            کوچک در شرایط نامساعد جوی تا میزان 60 درصد در در کاهش سوانح اثرگذار است.</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Arrow Navigator Skin Begin -->
                                                        <style>
                                                            /* jssor slider arrow navigator skin 02 css */
                                                            /*
                                                        .jssora02l              (normal)
                                                        .jssora02r              (normal)
                                                        .jssora02l:hover        (normal mouseover)
                                                        .jssora02r:hover        (normal mouseover)
                                                        .jssora02ldn            (mousedown)
                                                        .jssora02rdn            (mousedown)
                                                        */

                                                            .jssorb03 {
                                                                cursor: pointer;
                                                            }

                                                            .jssorb03 .av {
                                                                background-color: #1b8ed1;
                                                            }

                                                            .jssora02l.v, .jssora02r.v, .jssora02ldn.v, .jssora02rdn.v {
                                                                position: absolute;
                                                                cursor: pointer;
                                                                display: block;
                                                                background: url({{App::make('url')->to('/')}}/theme/banader/css/images/a15v.png) no-repeat;
                                                                overflow: hidden;
                                                            }

                                                            .jssora02l.v {
                                                                background-position: -12px -140px;
                                                            }

                                                            .jssora02r.v {
                                                                background-position: -12px -201px;
                                                            }

                                                            .jssora02l.v:hover {
                                                                background-position: -12px -20px;
                                                            }

                                                            .jssora02r.v:hover {
                                                                background-position: -12px -81px;
                                                            }

                                                            .jssora02ldn.v {
                                                                background-position: -12px -260px;
                                                            }

                                                            .jssora02rdn.v {
                                                                background-position: -303px -33px;
                                                            }
                                                        </style>
                                                        <!-- Arrow Left -->
                                                        <span u="arrowleft" class="jssora02l v " style="width: 55px; height: 55px;bottom:0; top: 8px;">
                                                </span>
                                                        <!-- Arrow Right -->
                                                        <span u="arrowright" class="jssora02r v " style="width: 55px; height: 55px; bottom: 20px; left: 8px">
                                                </span>
                                                    </div>
                                                </div>
                                                <div u="thumb">محیط زیست</div>
                                            </div>
                                            <div>
                                                <div style="margin: 10px; overflow: hidden; color: #000;">
                                                    <div id="slider15_container" class="newsSlider" style="position: relative; top: 0; left: 0; width: 790px; height: 390px; overflow: hidden;float:right; ">

                                                        <!-- Loading Screen -->
                                                        <div u="loading" style="position: absolute; top: 0; left: 0;">
                                                            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;background-color: #000; top: 0; left: 0;width: 100%;height:100%;">
                                                            </div>
                                                            <div style="position: absolute; display: block; background: url({{App::make('url')->to('/')}}/theme/banader/img/loading.gif) no-repeat center center;top: 0; left: 0;width: 100%;height:100%;">
                                                            </div>
                                                        </div>

                                                        <!-- Slides Container -->
                                                        <div u="slides" class="slideHolder" style="cursor: move; position: absolute; left: 0; top: 0; width: 790px; height: 300px; overflow: hidden;">
                                                            <div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>نشست انتقال تجربیات سیستم های مخابراتی VHF با حضور شرکت آلمانی</h1>
                                                                        <p>بنا به گفته مدیر کل تأمین و نگهداری تجهیزات، جلسه کارشناسی انتقال تجربیات سیستم های مخابراتی VHF با دعوت از شرکت آلمانی SCHNOOR و با حضور مدیران و کارشناسان معاونت
                                                                            های توسعه و تجهیز بنادر و امور دریایی سازمان بنادر و دریانوردی برگزار شد . . .</p>
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر</h1>
                                                                        <p>معاون امور دریایی اداره کل بنادر و دریانوردی هرمزگان ضمن اشاره به روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر گفت: کنترل خروجی لنج های صیادی و باری از بنادر
                                                                            کوچک در شرایط نامساعد جوی تا میزان 60 درصد در در کاهش سوانح اثرگذار است.</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>نشست انتقال تجربیات سیستم های مخابراتی VHF با حضور شرکت آلمانی</h1>
                                                                        <p>بنا به گفته مدیر کل تأمین و نگهداری تجهیزات، جلسه کارشناسی انتقال تجربیات سیستم های مخابراتی VHF با دعوت از شرکت آلمانی SCHNOOR و با حضور مدیران و کارشناسان معاونت
                                                                            های توسعه و تجهیز بنادر و امور دریایی سازمان بنادر و دریانوردی برگزار شد . . .</p>
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر</h1>
                                                                        <p>معاون امور دریایی اداره کل بنادر و دریانوردی هرمزگان ضمن اشاره به روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر گفت: کنترل خروجی لنج های صیادی و باری از بنادر
                                                                            کوچک در شرایط نامساعد جوی تا میزان 60 درصد در در کاهش سوانح اثرگذار است.</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Arrow Navigator Skin Begin -->
                                                        <style>
                                                            /* jssor slider arrow navigator skin 02 css */
                                                            /*
                                                        .jssora02l              (normal)
                                                        .jssora02r              (normal)
                                                        .jssora02l:hover        (normal mouseover)
                                                        .jssora02r:hover        (normal mouseover)
                                                        .jssora02ldn            (mousedown)
                                                        .jssora02rdn            (mousedown)
                                                        */

                                                            .jssorb03 {
                                                                cursor: pointer;
                                                            }

                                                            .jssorb03 .av {
                                                                background-color: #1b8ed1;
                                                            }

                                                            .jssora02l.v, .jssora02r.v, .jssora02ldn.v, .jssora02rdn.v {
                                                                position: absolute;
                                                                cursor: pointer;
                                                                display: block;
                                                                background: url({{App::make('url')->to('/')}}/theme/banader/css/images/a15v.png) no-repeat;
                                                                overflow: hidden;
                                                            }

                                                            .jssora02l.v {
                                                                background-position: -12px -140px;
                                                            }

                                                            .jssora02r.v {
                                                                background-position: -12px -201px;
                                                            }

                                                            .jssora02l.v:hover {
                                                                background-position: -12px -20px;
                                                            }

                                                            .jssora02r.v:hover {
                                                                background-position: -12px -81px;
                                                            }

                                                            .jssora02ldn.v {
                                                                background-position: -12px -260px;
                                                            }

                                                            .jssora02rdn.v {
                                                                background-position: -303px -33px;
                                                            }
                                                        </style>
                                                        <!-- Arrow Left -->
                                                        <span u="arrowleft" class="jssora02l v " style="width: 55px; height: 55px;bottom:0; top: 8px;">
                                                </span>
                                                        <!-- Arrow Right -->
                                                        <span u="arrowright" class="jssora02r v " style="width: 55px; height: 55px; bottom: 20px; left: 8px">
                                                </span>
                                                    </div>
                                                </div>
                                                <div u="thumb">اقتصاد</div>
                                            </div>
                                            <div>
                                                <div style="margin: 10px; overflow: hidden; color: #000;">
                                                    <div id="slider16_container" class="newsSlider" style="position: relative; top: 0; left: 0; width: 790px; height: 390px; overflow: hidden;float:right; ">

                                                        <!-- Loading Screen -->
                                                        <div u="loading" style="position: absolute; top: 0; left: 0;">
                                                            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;background-color: #000; top: 0; left: 0;width: 100%;height:100%;">
                                                            </div>
                                                            <div style="position: absolute; display: block; background: url({{App::make('url')->to('/')}}/theme/banader/img/loading.gif) no-repeat center center;top: 0; left: 0;width: 100%;height:100%;">
                                                            </div>
                                                        </div>

                                                        <!-- Slides Container -->
                                                        <div u="slides" class="slideHolder" style="cursor: move; position: absolute; left: 0; top: 0; width: 790px; height: 300px; overflow: hidden;">
                                                            <div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>نشست انتقال تجربیات سیستم های مخابراتی VHF با حضور شرکت آلمانی</h1>
                                                                        <p>بنا به گفته مدیر کل تأمین و نگهداری تجهیزات، جلسه کارشناسی انتقال تجربیات سیستم های مخابراتی VHF با دعوت از شرکت آلمانی SCHNOOR و با حضور مدیران و کارشناسان معاونت
                                                                            های توسعه و تجهیز بنادر و امور دریایی سازمان بنادر و دریانوردی برگزار شد . . .</p>
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر</h1>
                                                                        <p>معاون امور دریایی اداره کل بنادر و دریانوردی هرمزگان ضمن اشاره به روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر گفت: کنترل خروجی لنج های صیادی و باری از بنادر
                                                                            کوچک در شرایط نامساعد جوی تا میزان 60 درصد در در کاهش سوانح اثرگذار است.</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>نشست انتقال تجربیات سیستم های مخابراتی VHF با حضور شرکت آلمانی</h1>
                                                                        <p>بنا به گفته مدیر کل تأمین و نگهداری تجهیزات، جلسه کارشناسی انتقال تجربیات سیستم های مخابراتی VHF با دعوت از شرکت آلمانی SCHNOOR و با حضور مدیران و کارشناسان معاونت
                                                                            های توسعه و تجهیز بنادر و امور دریایی سازمان بنادر و دریانوردی برگزار شد . . .</p>
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر</h1>
                                                                        <p>معاون امور دریایی اداره کل بنادر و دریانوردی هرمزگان ضمن اشاره به روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر گفت: کنترل خروجی لنج های صیادی و باری از بنادر
                                                                            کوچک در شرایط نامساعد جوی تا میزان 60 درصد در در کاهش سوانح اثرگذار است.</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Arrow Navigator Skin Begin -->
                                                        <style>
                                                            /* jssor slider arrow navigator skin 02 css */
                                                            /*
                                                        .jssora02l              (normal)
                                                        .jssora02r              (normal)
                                                        .jssora02l:hover        (normal mouseover)
                                                        .jssora02r:hover        (normal mouseover)
                                                        .jssora02ldn            (mousedown)
                                                        .jssora02rdn            (mousedown)
                                                        */

                                                            .jssorb03 {
                                                                cursor: pointer;
                                                            }

                                                            .jssorb03 .av {
                                                                background-color: #1b8ed1;
                                                            }

                                                            .jssora02l.v, .jssora02r.v, .jssora02ldn.v, .jssora02rdn.v {
                                                                position: absolute;
                                                                cursor: pointer;
                                                                display: block;
                                                                background: url({{App::make('url')->to('/')}}/theme/banader/css/images/a15v.png) no-repeat;
                                                                overflow: hidden;
                                                            }

                                                            .jssora02l.v {
                                                                background-position: -12px -140px;
                                                            }

                                                            .jssora02r.v {
                                                                background-position: -12px -201px;
                                                            }

                                                            .jssora02l.v:hover {
                                                                background-position: -12px -20px;
                                                            }

                                                            .jssora02r.v:hover {
                                                                background-position: -12px -81px;
                                                            }

                                                            .jssora02ldn.v {
                                                                background-position: -12px -260px;
                                                            }

                                                            .jssora02rdn.v {
                                                                background-position: -303px -33px;
                                                            }
                                                        </style>
                                                        <!-- Arrow Left -->
                                                        <span u="arrowleft" class="jssora02l v " style="width: 55px; height: 55px;bottom:0; top: 8px;">
                                                </span>
                                                        <!-- Arrow Right -->
                                                        <span u="arrowright" class="jssora02r v " style="width: 55px; height: 55px; bottom: 20px; left: 8px">
                                                </span>
                                                    </div>
                                                </div>
                                                <div u="thumb">قوانین و مقررات</div>
                                            </div>
                                            <div>
                                                <div style="margin: 10px; overflow: hidden; color: #000;">

                                                    <div id="slider17_container" class="newsSlider" style="position: relative; top: 0; left: 0; width: 790px; height: 390px; overflow: hidden;float:right; ">

                                                        <!-- Loading Screen -->
                                                        <div u="loading" style="position: absolute; top: 0; left: 0;">
                                                            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;background-color: #000; top: 0; left: 0;width: 100%;height:100%;">
                                                            </div>
                                                            <div style="position: absolute; display: block; background: url({{App::make('url')->to('/')}}/theme/banader/img/loading.gif) no-repeat center center;top: 0; left: 0;width: 100%;height:100%;">
                                                            </div>
                                                        </div>

                                                        <!-- Slides Container -->
                                                        <div u="slides" class="slideHolder" style="cursor: move; position: absolute; left: 0; top: 0; width: 790px; height: 300px; overflow: hidden;">
                                                            <div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>نشست انتقال تجربیات سیستم های مخابراتی VHF با حضور شرکت آلمانی</h1>
                                                                        <p>بنا به گفته مدیر کل تأمین و نگهداری تجهیزات، جلسه کارشناسی انتقال تجربیات سیستم های مخابراتی VHF با دعوت از شرکت آلمانی SCHNOOR و با حضور مدیران و کارشناسان معاونت
                                                                            های توسعه و تجهیز بنادر و امور دریایی سازمان بنادر و دریانوردی برگزار شد . . .</p>
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر</h1>
                                                                        <p>معاون امور دریایی اداره کل بنادر و دریانوردی هرمزگان ضمن اشاره به روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر گفت: کنترل خروجی لنج های صیادی و باری از بنادر
                                                                            کوچک در شرایط نامساعد جوی تا میزان 60 درصد در در کاهش سوانح اثرگذار است.</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>نشست انتقال تجربیات سیستم های مخابراتی VHF با حضور شرکت آلمانی</h1>
                                                                        <p>بنا به گفته مدیر کل تأمین و نگهداری تجهیزات، جلسه کارشناسی انتقال تجربیات سیستم های مخابراتی VHF با دعوت از شرکت آلمانی SCHNOOR و با حضور مدیران و کارشناسان معاونت
                                                                            های توسعه و تجهیز بنادر و امور دریایی سازمان بنادر و دریانوردی برگزار شد . . .</p>
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر</h1>
                                                                        <p>معاون امور دریایی اداره کل بنادر و دریانوردی هرمزگان ضمن اشاره به روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر گفت: کنترل خروجی لنج های صیادی و باری از بنادر
                                                                            کوچک در شرایط نامساعد جوی تا میزان 60 درصد در در کاهش سوانح اثرگذار است.</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Arrow Navigator Skin Begin -->
                                                        <style>
                                                            /* jssor slider arrow navigator skin 02 css */
                                                            /*
                                                        .jssora02l              (normal)
                                                        .jssora02r              (normal)
                                                        .jssora02l:hover        (normal mouseover)
                                                        .jssora02r:hover        (normal mouseover)
                                                        .jssora02ldn            (mousedown)
                                                        .jssora02rdn            (mousedown)
                                                        */

                                                            .jssorb03 {
                                                                cursor: pointer;
                                                            }

                                                            .jssorb03 .av {
                                                                background-color: #1b8ed1;
                                                            }

                                                            .jssora02l.v, .jssora02r.v, .jssora02ldn.v, .jssora02rdn.v {
                                                                position: absolute;
                                                                cursor: pointer;
                                                                display: block;
                                                                background: url({{App::make('url')->to('/')}}/theme/banader/css/images/a15v.png) no-repeat;
                                                                overflow: hidden;
                                                            }

                                                            .jssora02l.v {
                                                                background-position: -12px -140px;
                                                            }

                                                            .jssora02r.v {
                                                                background-position: -12px -201px;
                                                            }

                                                            .jssora02l.v:hover {
                                                                background-position: -12px -20px;
                                                            }

                                                            .jssora02r.v:hover {
                                                                background-position: -12px -81px;
                                                            }

                                                            .jssora02ldn.v {
                                                                background-position: -12px -260px;
                                                            }

                                                            .jssora02rdn.v {
                                                                background-position: -303px -33px;
                                                            }
                                                        </style>
                                                        <!-- Arrow Left -->
                                                        <span u="arrowleft" class="jssora02l v " style="width: 55px; height: 55px;bottom:0; top: 8px;">
                                                </span>
                                                        <!-- Arrow Right -->
                                                        <span u="arrowright" class="jssora02r v " style="width: 55px; height: 55px; bottom: 20px; left: 8px">
                                                </span>
                                                    </div>


                                                </div>
                                                <div u="thumb">فناوری</div>
                                            </div>
                                            <div>
                                                <div style="margin: 10px; overflow: hidden; color: #000;">
                                                    <div id="slider18_container" class="newsSlider" style="position: relative; top: 0; left: 0; width: 790px; height: 390px; overflow: hidden;float:right; ">

                                                        <!-- Loading Screen -->
                                                        <div u="loading" style="position: absolute; top: 0; left: 0;">
                                                            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;background-color: #000; top: 0; left: 0;width: 100%;height:100%;">
                                                            </div>
                                                            <div style="position: absolute; display: block; background: url({{App::make('url')->to('/')}}/theme/banader/img/loading.gif) no-repeat center center;top: 0; left: 0;width: 100%;height:100%;">
                                                            </div>
                                                        </div>

                                                        <!-- Slides Container -->
                                                        <div u="slides" class="slideHolder" style="cursor: move; position: absolute; left: 0; top: 0; width: 790px; height: 300px; overflow: hidden;">
                                                            <div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>نشست انتقال تجربیات سیستم های مخابراتی VHF با حضور شرکت آلمانی</h1>
                                                                        <p>بنا به گفته مدیر کل تأمین و نگهداری تجهیزات، جلسه کارشناسی انتقال تجربیات سیستم های مخابراتی VHF با دعوت از شرکت آلمانی SCHNOOR و با حضور مدیران و کارشناسان معاونت
                                                                            های توسعه و تجهیز بنادر و امور دریایی سازمان بنادر و دریانوردی برگزار شد . . .</p>
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر</h1>
                                                                        <p>معاون امور دریایی اداره کل بنادر و دریانوردی هرمزگان ضمن اشاره به روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر گفت: کنترل خروجی لنج های صیادی و باری از بنادر
                                                                            کوچک در شرایط نامساعد جوی تا میزان 60 درصد در در کاهش سوانح اثرگذار است.</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>نشست انتقال تجربیات سیستم های مخابراتی VHF با حضور شرکت آلمانی</h1>
                                                                        <p>بنا به گفته مدیر کل تأمین و نگهداری تجهیزات، جلسه کارشناسی انتقال تجربیات سیستم های مخابراتی VHF با دعوت از شرکت آلمانی SCHNOOR و با حضور مدیران و کارشناسان معاونت
                                                                            های توسعه و تجهیز بنادر و امور دریایی سازمان بنادر و دریانوردی برگزار شد . . .</p>
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-12">

                                                                    <a href="#">

                                                                        <h1>روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر</h1>
                                                                        <p>معاون امور دریایی اداره کل بنادر و دریانوردی هرمزگان ضمن اشاره به روند کاهشی سوانح دریایی در هرمزگان طی پنج سال اخیر گفت: کنترل خروجی لنج های صیادی و باری از بنادر
                                                                            کوچک در شرایط نامساعد جوی تا میزان 60 درصد در در کاهش سوانح اثرگذار است.</p>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Arrow Navigator Skin Begin -->
                                                        <style>
                                                            /* jssor slider arrow navigator skin 02 css */
                                                            /*
                                                        .jssora02l              (normal)
                                                        .jssora02r              (normal)
                                                        .jssora02l:hover        (normal mouseover)
                                                        .jssora02r:hover        (normal mouseover)
                                                        .jssora02ldn            (mousedown)
                                                        .jssora02rdn            (mousedown)
                                                        */

                                                            .jssorb03 {
                                                                cursor: pointer;
                                                            }

                                                            .jssorb03 .av {
                                                                background-color: #1b8ed1;
                                                            }

                                                            .jssora02l.v, .jssora02r.v, .jssora02ldn.v, .jssora02rdn.v {
                                                                position: absolute;
                                                                cursor: pointer;
                                                                display: block;
                                                                background: url({{App::make('url')->to('/')}}/theme/banader/css/images/a15v.png) no-repeat;
                                                                overflow: hidden;
                                                            }

                                                            .jssora02l.v {
                                                                background-position: -12px -140px;
                                                            }

                                                            .jssora02r.v {
                                                                background-position: -12px -201px;
                                                            }

                                                            .jssora02l.v:hover {
                                                                background-position: -12px -20px;
                                                            }

                                                            .jssora02r.v:hover {
                                                                background-position: -12px -81px;
                                                            }

                                                            .jssora02ldn.v {
                                                                background-position: -12px -260px;
                                                            }

                                                            .jssora02rdn.v {
                                                                background-position: -303px -33px;
                                                            }
                                                        </style>
                                                        <!-- Arrow Left -->
                                                        <span u="arrowleft" class="jssora02l v " style="width: 55px; height: 55px;bottom:0; top: 8px;">
                                                </span>
                                                        <!-- Arrow Right -->
                                                        <span u="arrowright" class="jssora02r v " style="width: 55px; height: 55px; bottom: 20px; left: 8px">
                                                </span>
                                                    </div>
                                                </div>
                                                <div u="thumb">تازه‌های نرم افزار</div>
                                            </div>
                                        </div>
                                        <!-- ThumbnailNavigator Skin Begin -->
                                        <div u="thumbnavigator" class="jssort12" style="position: absolute; width: 500px; height: 30px; right:-2px; top: 0;">
                                            <!-- Thumbnail Item Skin Begin -->
                                            <style>
                                                /* jssor slider thumbnail navigator skin 12 css */
                                                /*
                                            .jssort12 .p            (normal)
                                            .jssort12 .p:hover      (normal mouseover)
                                            .jssort12 .pav          (active)
                                            .jssort12 .pav:hover    (active mouseover)
                                            .jssort12 .pdn          (mousedown)
                                            */
                                                .jssort12 .w, .jssort12 .phv .w {
                                                    cursor: pointer;
                                                    position: absolute;
                                                    WIDTH: 99px;
                                                    HEIGHT: 28px;
                                                    top: 0;
                                                    left: -1px;
                                                }

                                                .jssort12 .pav .w, .jssort12 .pdn .w {
                                                    border-bottom: 1px solid #fff;
                                                }

                                                .jssort12 .c {
                                                    color: #000;
                                                    font-size: 18px;
                                                }

                                                .jssort12 .pav .c, .jssort12 .p:hover .c, .jssort12 .phv .c {
                                                    background-color: #1b8ed1;
                                                    color: #fff;
                                                }
                                            </style>
                                            <div u="slides" style="cursor: move; top:0; right:0;">
                                                <div u="prototype" class="p" style="POSITION: absolute; WIDTH: 100px; HEIGHT: 30px; TOP: 0; right: 0; padding:0;">
                                                    <div class=w>
                                                        <thumbnailtemplate class="c" style=" WIDTH: 100%; HEIGHT: 100%; position:absolute; TOP: 0; right: 0; line-height:28px; text-align:center;"></thumbnailtemplate>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Thumbnail Item Skin End -->
                                        </div>
                                    </div>
                                    <!-- Jssor Slider End -->
                                </div>


                            </div>
                        </div>


                        <div class="col-md-12 col-xs-12 noPadding coverflowHolder">
                            <h1>فروشگاه</h1>
                            <div class="coverflow" id="coverflow">
                                <ul>
                                    <li>
                                        <div><img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg"><span class="name">فقه و اصول</span><span class="number">تابستان 1394 - شماره 101</span></div>
                                    </li>
                                    <li>
                                        <div><img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-02.jpg"><span class="name">حقوق عمومی</span><span class="number">زمستان 1394 - شماره 102</span></div>
                                    </li>
                                    <li>
                                        <div><img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-03.jpg"><span class="name">فقه و اصول</span><span class="number">تابستان 1394 - شماره 103</span></div>
                                    </li>
                                    <li>
                                        <div><img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-02.jpg"><span class="name">حقوق عمومی</span><span class="number">زمستان 1394 - شماره 104</span></div>
                                    </li>
                                    <li>
                                        <div><img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg"><span class="name">فقه و اصول</span><span class="number">تابستان 1394 - شماره 105</span></div>
                                    </li>
                                    <li>
                                        <div><img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-03.jpg"><span class="name">حقوق عمومی</span><span class="number">زمستان 1394 - شماره 106</span></div>
                                    </li>
                                    <li>
                                        <div><img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg"><span class="name">حقوق عمومی</span><span class="number">تابستان 1394 - شماره 107</span></div>
                                    </li>
                                    <li>
                                        <div><img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-02.jpg"><span class="name">حقوق عمومی</span><span class="number">زمستان 1394 - شماره 108</span></div>
                                    </li>
                                    <li>
                                        <div><img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-03.jpg"><span class="name">فحقوق عمومی</span><span class="number">تابستان 1394 - شماره 109</span></div>
                                    </li>
                                    <li>
                                        <div><img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-01.jpg"><span class="name">حقوق عمومی</span><span class="number">تابستان 1394 - شماره 107</span></div>
                                    </li>
                                    <li>
                                        <div><img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-02.jpg"><span class="name">حقوق عمومی</span><span class="number">زمستان 1394 - شماره 108</span></div>
                                    </li>
                                    <li>
                                        <div><img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-02.jpg"><span class="name">حقوق عمومی</span><span class="number">زمستان 1394 - شماره 108</span></div>
                                    </li>
                                    <li>
                                        <div><img src="{{App::make('url')->to('/')}}/theme/banader/css/images/book-03.jpg"><span class="name">فحقوق عمومی</span><span class="number">تابستان 1394 - شماره 109</span></div>
                                    </li>
                                </ul>
                                <div class="bookDet">
                                    <span class="name"></span>
                                    <span class="number"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- end of Main Template -->
            <div class="col-md-12 footerPage">
                <p>
                <ul class="center-block" style="width: 800px;">
                    <li><a href="{{App::make('url')->to('/')}}/ms">درباره {{ Config::get('constants.SiteFullTitle')}}</a></li>
                    <li>
                        <div class="Footicon icon-2-3"></div>
                        مبتنی بر <a href="{{App::make('url')->to('/')}}/100">هم&zwnj;افزا</a></li>
                    <li>
                        <div class="Footicon icon-2-3"></div>
                        پشتیبانی:
                        <a href="http://www.hamafza.co" target="_blank">فناوران مدیریت علم هم&zwnj;افزا</a></li>

                    @if ($uid  != '0' && UsersClass::permission('homepage', $uid) == '1')
                        <li>
                            <div class="Footicon icon-2-3"></div>
                            <a href="{{App::make('url')->to('/')}}/{{$Uname}}/desktop/homepage" target="_blank">ویرایش صفحه اول</a></li>
                    @endif

                </ul>
                </p>

            </div>
        </div>
    </div>


    @if(Session::get('message')!='')
        <script>
            jQuery.noticeAdd({
                text: '{{ Session::get('message') }}',
                stay: false,
                type: '{{ Session::get("mestype") }}'
            });
            //                    if (Session::get('message') == 'کاربر ناشناس'){
            //            window.location = "{{App::make('url')->to('/')}}/Logout";
            //            }
        </script>

    @endif
    <script>
        jQuery(document).ready(function ($) {
            var options = {
                $AutoPlay: false, //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1, //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000, //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1, //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
                $HWA: false,
                $ArrowKeyNavigation: true, //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500, //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20, //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 5, //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1, //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0, //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1, //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 2, //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3, //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $ThumbnailNavigatorOptions: {
                    $Class: $JssorThumbnailNavigator$, //[Required] Class to create thumbnail navigator instance
                    $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always

                    $ActionMode: 1, //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
                    $AutoCenter: 3, //[Optional] Auto center thumbnail items in the thumbnail navigator container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 3
                    $Lanes: 1, //[Optional] Specify lanes to arrange thumbnails, default value is 1
                    $SpacingX: 0, //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                    $SpacingY: 0, //[Optional] Vertical space between each thumbnail in pixel, default value is 0
                    $DisplayPieces: 5, //[Optional] Number of pieces to display, default value is 1
                    $ParkingPosition: 0, //[Optional] The offset position to park thumbnail
                    $Orientation: 2, //[Optional] Orientation to arrange thumbnails, 1 horizental, 2 vertical, default value is 1
                    $DisableDrag: true                              //[Optional] Disable drag or not, default value is false
                }
            };
            var jssor_slider3 = new $JssorSlider$("slider3_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider3.$Elmt.parentNode.clientWidth;
                if (parentWidth) {
                    var sliderWidth = parentWidth;
                    //keep the slider width no more than 701
                    sliderWidth = Math.min(sliderWidth, 792);
                    jssor_slider3.$SetScaleWidth(sliderWidth);
                }
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
        });            </script>

    <script>
        var h1 = $("#slider2_container").height();
        var h2 = $("#SecDiv").height();
        if (h1 > h2) {
            $("#SecDiv").height($("#slider2_container").height());

        }
        else {
            $("#slider2_container").height($("#SecDiv").height());

        }
        $("#SecDiv").css('max-height', '300px');
        $("#slider2_container").css('max-height', '300px');

        $(document).ready(function () {
            $("#TagRes").mCustomScrollbar();
        });
        $(function () {
            $("#KeywordFehresrt").jstree({
                "plugins": ["search"]
            });
            var to = false;
        });
        $('#KeywordFehresrt').jstree({
            "plugins": ["search"],
            'core': {
                'data': [
                    {!! $keywordTab !!}
                ],
                'rtl': true,
                "themes": {
                    "icons": false
                }
            }
        });
        $("#KeywordFehresrt").bind('select_node.jstree',
            function (e, data) {
                var texts = data.node.text;
                var ids = data.node.id;
                $("#Navigatekeywords").tokenInput("add", {id: ids, name: texts});
                $("#TagRes").animate({
                    scrollTop: 0
                }, 600);
            })

            .on("activate_node.jstree", function (e, data) {
                window.location.href = data.node.a_attr.href;
                history.pushState("", document.title, window.location.pathname + window.location.search);
            });</script>
<!--    <link rel="stylesheet" type="text/css" media="screen" href="{{App::make('url')->to('/')}}/theme/Content/css/sequencejs-theme.sliding-horizontal-parallax.css" />

                    <script src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.sequence.js"></script>
                    <script src="{{App::make('url')->to('/')}}/theme/Scripts/sequencejs-options.sliding-horizontal-parallax.js"></script>-->
</body>
</html>
