<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/bootstrap-rtl.min.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/style.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/homslider/animate.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/homslider/bootslider.css"/>
<link rel="stylesheet" href="{{App::make('url')->to('/')}}/theme/bootstrap/css/bootstrap-image-gallery.min.css"/>
<!--<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">-->
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/scroll/jquery.mCustomScrollbar.min.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/public.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/daneshnameh.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/jquery-ui.css"/>
<link rel="stylesheet" href="{{App::make('url')->to('/')}}/theme/Content/css/jquery.jspanel.css"  />
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/jquery.notice.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/treemenu.css"/>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/bootstrap-show-password.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/homslider/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/homslider/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/homslider/jquery.fitvids.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/homslider/jquery.grozav.bootslider.min.js"></script>
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
<script src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.ui.datepicker-cc.all.min.js" type="text/javascript"></script>
<link href="{{App::make('url')->to('/')}}/theme/Content/css/jquery.ui.datepicker1.8-all.css" rel="stylesheet" type="text/css"/>


<style>
    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th{
        font-size: 9pt;
    }
</style>

<script>
     $(document).on("click", ".jsPanels", function() {
        link = $(this).attr('href');
        title = $(this).attr('title');
        get_height = $(this).attr('height');
        if (link.indexOf('share?sid') > 0)
            title = 'بازنشر';
        if (link.indexOf('print?sid') > 0)
            title = 'چاپ';
        var w = $(window).width();
        w = w - 800;
        w = w / 2;
        var h = $(window).height();
        h = h - 530;
        h = h / 2;

        if (get_height != '')
            hei = '500';
        else
            hei = 'auto';
        $.jsPanel({
            ajax: {
                url: link,
                done: function(data, textStatus, jqXHR, panel) {
                    panel.content.css({"width": "800px", "max-height": "550px", "height": hei, 'overflow-y': 'auto'});
                    panel.resize("auto", "auto");
                }

            },
            controls: {
                minimize: 'disable',
                smallify: 'disable'
            },
            title: title,
            contentOverflow: {horizontal: 'hidden', vertical: 'scroll'},
            size: {width: 800, height: hei},
            position: {top: 0, left: w},
            // position: 'center',
            theme: 'info'
        });

        return false

    })
    </script>
    <body style="background-color: #FFF;">
        
<div class="panel panel-light fix-box">
    <div class="text-content">
        {{$C}}
    </div>


</div>
    </body>