<meta charset="UTF-8">
<title>
    @if( ! empty($Title) && !empty($SiteTitle) )
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
<meta name="author" content="M.Mastersoft@gmail.com">
<meta name="generator" content="Mostafa Kalantar">