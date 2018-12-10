<meta charset="UTF-8">
<title>
    @if( ! empty($Title) && !empty($SiteTitle) )
        {{ preg_replace("/<span[^>]+\>.*>/i", "", $Title) }} - {{ $SiteTitle }}
    @endif
</title>
<meta http-equiv="content-language" content="fa">
<meta name="keywords" content="{{Config::get('constants.SiteKeyword')}}"/>
@if( ! empty($Descr))
    <meta name="description" content="هم افزا، نوآوری در مدیریت است؛ هم افزا نسل جدید مدیریت راهبردی، مدیریت دانش، مدیریت زمان، مدیریت عملکرد، مدیریت کیفیت، مدیریت نوآوری و مدیریت فناوری است"/>
@else
    <meta name="description" content="هم افزا، نوآوری در مدیریت است؛ هم افزا نسل جدید مدیریت راهبردی، مدیریت دانش، مدیریت زمان، مدیریت عملکرد، مدیریت کیفیت، مدیریت نوآوری و مدیریت فناوری است"/>
@endif
<meta name="googlebot" content="INDEX"/>
<meta property="og:locale" content="fa_IR"/>
<meta property="og:type" content="website"/>
@if( ! empty($Title) && !empty($SiteTitle) )
    <meta property="og:title" content="{{ strip_tags($Title) }} - {{ $SiteTitle }}"/>
@endif
<meta property="og:url" content="{{App::make('url')->to('/')}}"/>
<META NAME="ROBOTS" CONTENT="INDEX">
@if( ! empty($Descr))
    <meta property="og:description" content="{{$Descr}}"/>
@else
    <meta property="og:description" content="{{Config::get('constants.Sitedescription')}}"/>
@endif
<meta name="author" content="amir.fatemi.amin@gmail.com">
<meta name="generator" content="hamafza">
