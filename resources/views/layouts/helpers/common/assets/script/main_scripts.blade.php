<script type="text/javascript" src="{{URL::asset('assets/js/Jquery/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/Jquery/jquery-migrate-3.0.0.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/Packages/bootstrap/js/bootstrap.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/Packages/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js')}}"></script>

<!--<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/bootstrap/js/bootstrap.min.js"></script>-->
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/bootstrap-show-password.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/homslider/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/homslider/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/homslider/jquery.fitvids.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/homslider/jquery.grozav.bootslider.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.tipsy.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/waitMe.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/custom.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/spectrum.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/public.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.bsvalidate.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/mobile-detect.min.js"></script>
<script type="text/javascript" src="{{URL::asset('assets/Packages/jquery-ui/jquery-ui.min.js')}}"></script>
<!--<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jquery-ui.min.js`"></script>-->
<script type="text/javascript" src="{{URL::asset('assets/Packages/JSPanel/jquery.jspanel.min.js')}}"></script>
<!--<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.jspanel.min.js"></script>-->
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.notice.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jstree.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jstree.search.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.highlight.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.tokeninput.js"></script>
<script type="text/javascript" src="{{ asset('assets/Packages/highcharts/code/highcharts.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/Packages/highcharts/code/modules/data.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/Packages/highcharts/code/modules/drilldown.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/Packages/highcharts/code/modules/exporting.js') }}"></script>
{{--<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/highcharts.js"></script>--}}
{{--<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/exporting.js"></script>--}}
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript" src="{{URL::asset('assets/Packages/select2/dist/js/select2.full.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/Packages/select2/dist/js/i18n/fa.js')}}"></script>
<script src="{{ asset('assets/Packages/PersianDateOrTimePicker/js/persian-date.js') }}"></script>
<script src="{{ asset('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js') }}"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/assets/Packages/calendar/lib/moment/moment.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/assets/Packages/calendar/lib/moment/moment-jalaali.js"></script>
{{--<script src="{!! url('/assets/Packages/gemini-scrollbar/gemini-scrollbar.js') !!}"></script>--}}
<script src="https://js.pusher.com/4.4/pusher.min.js"></script>
@if(Auth::check())
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        var userid = {{Auth::user()->id}}
        var pusher = new Pusher('70bb6aa696b7ba2cc310', {
                cluster: 'mt1',
                forceTLS: true
            });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            if(userid == data.message)
            {
                jQuery.noticeAdd
                ({
                    text: 'وظیفه ی جدیدی برای شما ثبت شد',
                    stay: false,
                    type: 'success'
                });
            }

        });
    </script>
@endif
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    @if (auth()->check())
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
    var Baseurl = "{{App::make('url')->to('/')}}/";
    var LangJson_DataTables = {
        "decimal": "",
        "emptyTable": "{{trans('DataTables.EmptyTable')}}",
        "info": "{{trans('DataTables.Info')}}",
        "infoEmpty": "{{trans('DataTables.InfoEmpty')}}",
        "infoFiltered": "<br/>{{trans('DataTables.InfoFiltered')}}",
        "infoPostFix": "{{trans('DataTables.InfoPostFix')}}",
        "thousands": "{{trans('DataTables.InfoThousands')}}",
        "lengthMenu": "{{trans('DataTables.LengthMenu')}}",
        "loadingRecords": "{{trans('DataTables.LoadingRecords')}}",
        "processing": "{{trans('DataTables.Processing')}}",
        "search": "{{trans('DataTables.Search')}}",
        "searchPlaceholder": "{{trans('DataTables.placeholder')}}",
        "zeroRecords": "{{trans('DataTables.ZeroRecords')}}",
        "paginate": {
            "first": "{{trans('DataTables.First')}}",
            "last": "{{trans('DataTables.Last')}}",
            "next": "{{trans('DataTables.Next')}}",
            "previous": "{{trans('DataTables.Previous')}}"
        },
        "aria": {
            "sortAscending": "{{trans('DataTables.SortAscending')}}",
            "sortDescending": "{{trans('DataTables.SortDescending')}}"
        }
    };
    var CommonDom_DataTables = '<"space-10">' +
            ' <"row form-inline" <"col-xs-4"f> <"col-xs-4">  <"col-xs-4 text-left toolbar"> <"clearfixed">>' +
            ' <"row" <"col-xs-12" rt> <"clearfixed">>' +
            ' <"row" <"col-xs-5"<"col-xs-6"i><"col-xs-6"l>><"col-xs-7 pull-left text-left"p> <"clearfixed">>';
    function isFunction(functionToCheck) {
        var getType = {};
        return functionToCheck && getType.toString.call(functionToCheck) === '[object Function]';
    }

    /**
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     * begin public cart and discountcoupon functions
     *
     * some of scripts may placed in:
     *      \resources\views\hamahang\Bazaar\helper\bazaar-js.blade.php
     *      \resources\views\hamahang\Bazaar\helper\cart-js.blade.php
     *
     */

    // process add to cart
    function add_to_cart(thic)
    {
        $(thic).attr('disabled', 'disabled');
        id = $('#subject_id').val();
        count = $('#subject_count').val();
        if (cart_add(id, count))
        {
            //$('.add_to_cart').effect('transfer', {to : $('.fa-shopping-basket')}, 1000, function(){ cart_update_basket(); });
            $('.add_to_cart').effect('transfer', {to : $('.user-config')}, 1000, function(){ cart_update_basket(); /*$(thic).removeAttr('disabled');*/ });
        } else
        {
            alert('Error!')
        }
    }

    // add an item to cart
    function cart_add(id, count)
    {
        r = false;
        $.ajax
        ({
            async: false,
            url: '{{ route('hamahang.bazaar.cart_add') }}',
            type: 'post',
            dataType: 'json',
            data: {'id' : id, 'count' : count},
            success: function(data) { r = data.success; }
        });
        return r;
    };

    // dynamically update cart`s basket
    function cart_update_basket()
    {
        $.ajax
        ({
            url: '{{ route('hamahang.bazaar.cart_count') }}',
            type: 'post',
            dataType: 'json',
            //success: function(data) { $('#cart_basket_count').html(data.result); }
            success: function(data)
            {
                if (data.result) {
                    $('#basket_area').css('visibility', 'visible');
                    $('#cart_basket_count').html(data.result);
                } else
                {
                    $('#basket_area').css('visibility', 'hidden');
                }
            }
        });
    };

    /**
     *
     * end public cart and discountcoupon functions
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     */

</script>

@if(isset($pid,$sid,$content) && $pid=='1' && $sid=='1' && $content=='1' && Config::get('constants')['IndexView']!='general')
    <script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jssor.core.js"></script>
    <script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jssor.slider.min.js"></script>
    <script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jssor.utils.js"></script>
    <script>
        jQuery(document).ready(function ($) {
            var options =
                {
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
                    $BulletNavigatorOptions: {//[Optional] Options to specify and enable navigator or not
                        $Class: $JssorBulletNavigator$, //[Required] Class to create navigator instance
                        $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
                        $AutoCenter: 0, //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                        $Steps: 1, //[Optional] Steps to go for each navigation request, default value is 1
                        $Lanes: 1, //[Optional] Specify lanes to arrange items, default value is 1
                        $SpacingX: 0, //[Optional] Horizontal space between each item in pixel, default value is 0
                        $SpacingY: 0, //[Optional] Vertical space between each item in pixel, default value is 0
                        $Orientation: 1  //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                    },
                    $ArrowNavigatorOptions: {
                        $Class: $JssorArrowNavigator$, //[Requried] Class to create arrow navigator instance
                        $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
                        $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                    }
                };
            // var jssor_slider1 = new $JssorSlider$("slider2_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                // var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                // if (parentWidth)
                //     jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 792));
                // else
                //     window.setTimeout(ScaleSlider, 30);
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
