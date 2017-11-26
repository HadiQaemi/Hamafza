@extends('pages.Desktop.DesktopFunctions')
@section('content')
    <link href="{{url('theme/Content/css/social.css')}}" rel="stylesheet" type="text/css"/>
    <ul class="person-list row">
        @if(is_array($Circle) && count($Circle)>0)
            @foreach($Circle as $item)
                <?php
                $pic = 'pics/user/Users.png';
                if (trim($item->Pic) != '' && file_exists('pics/user/' . $item->id . '-' . $item->Pic))
                    $pic = 'pics/user/' . $item->id . '-' . $item->Pic;
                else if (trim($item->Pic) != '' && file_exists('pics/user/' . $item->Pic))
                    $pic = 'pics/user/' . $item->Pic;
                ?>
                <li class="">
                    <a href="{{url($item->Uname)}}" target="_blank">
                        <img src="{{url($pic)}}" class="person-avatar">
                    </a>
                    <div class="person-detail">
                        <div class="close"></div>
                        <div class="person-name">
                            <a href="{{url($item->Uname)}}" target="_blank">{{$item->Name}} {{$item->Family}}</a>
                        </div>
                        <div class="person-moredetail">{{$item->Summary}}</div>
                        <div class="person-relation"></div>
                    </div>
                    <!--
                    <div class="person-circle grey">
                        <span class="flaticon-plus"></span>
                        <span> افزودن به دوستان</span>
                        <span class="flaticon-arrow"></span>
                    </div>
                    -->
                </li>
            @endforeach
        @endif
    </ul>
@stop