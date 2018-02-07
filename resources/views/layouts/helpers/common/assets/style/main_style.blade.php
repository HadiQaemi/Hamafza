<link type="text/css" rel="stylesheet" href="{{url('assets/css/reset-browser.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{url('theme/Content/css/jquery.ui.datepicker1.8-all.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{url('assets/Packages/bootstrap/css/bootstrap.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{url('assets/Packages/bootstrap/css/bootstrap-rtl.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{url('assets/Packages/FontAwesome/css/font-awesome.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{url('theme/Content/css/style.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{url('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
<link type="text/css" rel="stylesheet" href="{{url('theme/homslider/animate.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{url('theme/homslider/bootslider.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{url('theme/bootstrap/css/bootstrap-image-gallery.min.css')}}"/>
<!--<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css')}}">-->
<link type="text/css" rel="stylesheet" href="{{url('theme/scroll/jquery.mCustomScrollbar.min.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{url('theme/Content/css/public.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{url('theme/Content/css/daneshnameh.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{url('theme/Content/css/jquery-ui.css')}}"/>
<!--<link rel="stylesheet" type="text/css" href="{{url('theme/Content/css/jquery.jspanel.css')}}"  />-->
<link type="text/css" rel="stylesheet" href="{{url('assets/Packages/JSPanel/jquery.jspanel.css')}}">

<link type="text/css" rel="stylesheet" href="{{url('theme/Content/css/jquery.notice.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{url('theme/Content/css/treemenu.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{url('assets/Packages/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css')}}">
<link type="text/css" rel="stylesheet" href="{{url('assets/Packages/select2/dist/css/select2.min.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{url('assets/Packages/bootstrap/css/select2-bootstrap.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{url('/assets/Packages/gemini-scrollbar/gemini-scrollbar.css')}}">
<link type="text/css" rel="stylesheet" href="{{url('assets/css/hamahang_style.css')}}"/>

<?php
if (isset($Title))
{
    $pos = strpos(strip_tags($Title), 'ویرایش');
    if ($pos !== false)
        echo '<link type="image/png" rel="icon" href="' . Request::root() . '/edit.png">';
    else{
        if(config('constants.IndexView')=='kmkz')
            echo '<link type="image/png" rel="icon" href="' . Request::root() . '/logo-kmkz.png">';
        else
            echo '<link type="image/png" rel="icon" href="' . Request::root() . '/favicon.png">';
    }

}

?>