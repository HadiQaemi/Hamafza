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
<script type="text/javascript" src="{{URL::asset('assets/Packages/jquery-ui/jquery-ui.min.js')}}"></script>
<!--<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jquery-ui.min.js`"></script>-->
<script type="text/javascript" src="{{URL::asset('assets/Packages/JSPanel/jquery.jspanel.min.js')}}"></script>

<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jstree.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jstree.search.js"></script>

<script src="{{URL::asset('theme/hamafza/index_2/js/dropdown.js')}}"></script>
<script src="{{URL::asset('theme/hamafza/index_2/js/collapse.js')}}"></script>
<script src="{{URL::asset('theme/hamafza/index_2/js/transition.js')}}"></script>
<script src="{{URL::asset('theme/hamafza/index_2/js/tooltip.js')}}"></script>
<script src="{{URL::asset('theme/hamafza/index_2/js/modal.js')}}"></script>
<script src="{{URL::asset('theme/hamafza/index_2/js/carousel.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/Packages/select2/dist/js/select2.full.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/Packages/select2/dist/js/i18n/fa.js')}}"></script>


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

</script>

