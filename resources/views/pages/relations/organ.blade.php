@extends('pages.Desktop.DesktopFunctions')
@section('content')
    <link href="{{url('theme/Content/css/social.css')}}" rel="stylesheet" type="text/css"/>
    <ul class="person-list row">
        @if(is_array($Organs) && count($Organs)>0)
            @foreach($Organs as $item)
                <?php
                $pic = 'pics/group/Groups.png';
                if (trim($item->pic) != '' && file_exists('pics/group/' . $item->id . '-' . $item->pic))
                    $pic = 'pics/group/' . $item->id . '-' . $item->pic;
                else if (trim($item->pic) != '' && file_exists('pics/group/' . $item->pic))
                    $pic = 'pics/group/' . $item->pic;
                ?>
                <li class="">
                    <a href="{{url($item->link)}}" target="_blank"><img src="{{url($pic)}}" class="person-avatar"></a>
                    <div class="person-detail">
                        <div class="close"></div>
                        <div class="person-name">
                            <a href="{{url($item->link)}}" target="_blank">{{$item->name}} </a>
                        </div>
                        <div class="person-moredetail">{{$item->summary}}</div>
                        <div class="person-relation"></div>
                    </div>
                </li>
            @endforeach
        @else
            موردی یافت نشد
        @endif
    </ul>
@stop