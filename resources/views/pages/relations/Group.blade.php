@extends('pages.Desktop.DesktopFunctions')
@section('content')
<link href="{{App::make('url')->to('/')}}/theme/Content/css/social.css" rel="stylesheet" type="text/css"/>
<?php
$pic = 'pics/group/Groups.png';
if (trim($about->pic) != '' && file_exists('pics/group/' . $about->id . '-' . $about->pic))
    $pic = 'pics/group/' . $about->id . '-' . $about->pic;
else if (trim($about->pic) != '' && file_exists('pics/group/' . $about->pic))
    $pic = 'pics/group/' . $about->pic;
?>
<div class="gkCode10" style="margin:15px;">
    <table style="border:none;">
        <tbody>
            <tr style="border:none;">
                <td width="150" style="border: none;vertical-align: top;padding-top: 15px;text-align: right;">
                    <img src="{{App::make('url')->to('/')}}/{{$pic}}" style="max-width:100px; height:auto; margin-left:15px;" class="mCS_img_loaded">
                </td>
                <td style="border:none;text-align:right;">
                    <div style="max-width: 760px;display: inline-block;vertical-align: top;text-align: right;font-size:9pt;">
                        <h1><a href="{{App::make('url')->to('/')}}/{{$about->link}}">{{$about->name}}</a></h1>
                        <hr style="width:100%;margin:0;">
                        {{$about->summary}}
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
    <p>
    <ul class="person-list row">

    @if(is_array($members) && count($members)>0)
    @foreach($members as $item)

    <?php
    $pic = 'pics/user/Users.png';
    if (trim($item->Pic) != '' && file_exists('pics/user/' . $item->id . '-' . $item->Pic))
        $pic = 'pics/user/' . $item->id . '-' . $item->Pic;
    else if (trim($item->Pic) != '' && file_exists('pics/user/' . $item->Pic))
        $pic = 'pics/user/' . $item->Pic;
    ?>
    <li class="">
        <a href="{{App::make('url')->to('/')}}/{{$item->Uname}}" target="_blank"><img src="{{App::make('url')->to('/')}}/{{$pic}}" class="person-avatar"></a>
        <div class="person-detail">
            <div class="close"></div>
            <div class="person-name"><a href="{{App::make('url')->to('/')}}/{{$item->Uname}}" target="_blank">{{$item->Name}} {{$item->Family}}</a></div>
            <div class="person-moredetail">{{$item->Summary}}</div>
            <div class="person-relation"></div>
        </div>
        <!--        <div class="person-circle grey">
                    <span class="flaticon-plus"></span>
                    افزودن به دوستان
                    <span class="flaticon-arrow"></span>
                </div>-->
    </li>
    @endforeach
    @endif

</ul>




@stop