<link type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/reset-browser.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/jquery.ui.datepicker1.8-all.css"/>
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/Packages/bootstrap/css/bootstrap.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/Packages/bootstrap/css/bootstrap-rtl.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets/Packages/FontAwesome/css/font-awesome.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/style.css"/>
<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/homslider/animate.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/homslider/bootslider.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/bootstrap/css/bootstrap-image-gallery.min.css"/>
<!--<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">-->
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/scroll/jquery.mCustomScrollbar.min.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/public.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/daneshnameh.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/jquery-ui.css"/>
<!--<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/jquery.jspanel.css"  />-->
<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/JSPanel/jquery.jspanel.css')}}">

<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/jquery.notice.css"/>
<link rel="stylesheet" type="text/css" href="{{App::make('url')->to('/')}}/theme/Content/css/treemenu.css"/>
<link type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/hamahang_style.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css')}}">
<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/select2/dist/css/select2.min.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/bootstrap/css/select2-bootstrap.css')}}"/>
<?php
if (isset($Title))
{
    $pos = strpos(strip_tags($Title), 'ویرایش');
    if ($pos !== false)
        echo '<link type="image/png" rel="icon" href="' . Request::root() . '/edit.png">';
    else
        echo '<link type="image/png" rel="icon" href="' . Request::root() . '/favicon.png">';
}

?>