<script type="text/javascript" src="{{asset('assets/js/Jquery/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/Jquery/jquery-migrate-3.0.0.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/Packages/bootstrap/js/bootstrap.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/Packages/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js')}}"></script>

<script type="text/javascript" src="{{url('theme/Scripts/bootstrap-show-password.min.js')}}"></script>
<script type="text/javascript" src="{{url('theme/homslider/jquery.touchSwipe.min.js')}}"></script>
<script type="text/javascript" src="{{url('theme/homslider/jquery.mousewheel.min.js')}}"></script>
<script type="text/javascript" src="{{url('theme/homslider/jquery.fitvids.js')}}"></script>
<script type="text/javascript" src="{{url('theme/homslider/jquery.grozav.bootslider.min.js')}}"></script>
<script type="text/javascript" src="{{url('theme/Scripts/custom.js')}}"></script>
<script type="text/javascript" src="{{url('theme/Scripts/public.js')}}"></script>
<script type="text/javascript" src="{{url('theme/Scripts/jquery.bsvalidate.js')}}"></script>
<script type="text/javascript" src="{{url('theme/Scripts/mobile-detect.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/Packages/jquery-ui/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/Packages/JSPanel/jquery.jspanel.min.js')}}"></script>
<script type="text/javascript" src="{{url('theme/Scripts/jquery.notice.js')}}"></script>
<script type="text/javascript" src="{{url('theme/Scripts/jstree.js')}}"></script>
<script type="text/javascript" src="{{url('theme/Scripts/jstree.search.js')}}"></script>
<script type="text/javascript" src="{{url('theme/Scripts/jquery.highlight.js')}}"></script>
<script type="text/javascript" src="{{url('theme/Scripts/jquery.tokeninput.js')}}"></script>
<script type="text/javascript" src="{{url('theme/Scripts/jquery.ui.datepicker-cc.all.min.js')}}"></script>
<script src="{{ url('assets/Packages/PersianDateOrTimePicker/js/persian-date.js') }}"></script>
<script src="{{ asset('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js') }}"></script>

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
            url: '{{ route('Hamahang.bazaar.cart_add') }}',
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
            url: '{{ route('Hamahang.bazaar.cart_count') }}',
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