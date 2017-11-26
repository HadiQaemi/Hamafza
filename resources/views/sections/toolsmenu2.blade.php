<?php
$i = 1;
$active = '';
$menutools2 = $menutools;

?>
@if(!empty($menutools) && $menutools!='')
    <div class="rightSubMenu">
        <div class="pull-right">
            @foreach($menutools as $item)
                @if($i==1)
                    <?php $active = 'class="active"'; ?>
                @else
                    <?php $active = ''; ?>
                @endif
                <div class="MenuDiv"><a class="MenuHead" href="#{{$item->name}}">{{$item->name}}</a>
                    <br>
                    <table class="MenuTBL">
                        @foreach($item->tools as $items)
                            @if($items->login ==2 &&  ( session('uid')  ==0))
                                <tr>
                                    <td>
                                        <div style="height: 20px;width: 20px;padding-top: 5px;color:#fff;font-size: 11pt!important"><span class="{{$items->icon}}"></span></div>
                                    </td>
                                    <td>
                                        <div data-target="#loginWmessage" data-toggle="modal" class="login" style="color: #fff; cursor: pointer">{{$items->title}}</div>
                                    </td>
                                </tr>

                            @elseif($items->login !=0 || ( session('uid')  >0))
                                @if($items->modal=='1')
                                    <tr>
                                        <td>
                                            <div style="height: 20px;width: 20px;padding-top: 5px;color:#fff;font-size: 11pt!important"><span class="{{$items->icon}}"></span></div>
                                        </td>
                                        @if( $items->url=='delete' && session('SubjectArchive')=='0' )
                                            <td><a style="float: right;" class=" fa fa-anchor DeletePage" title="{{$items->farsi}}" pid='{{$sid}}'>{{$items->title}}</a></td>
                                            <?php session('SubjectArchive', '0'); ?>
                                        @elseif( !empty($PageType) )
                                            <td><a style="float: right;" class="jsPanels" title="{{$items->title}}"
                                                   href="{{App::make('url')->to('/')}}/modals/{{$items->url}}?sid={{$sid }}&pid={{$pid }}&type={{$PageType}}&title={{$Title}}">{{$items->title}}</a></td>
                                        @else
                                            <td><a style="float: right;" class="jsPanels" title="{{$items->title}}"
                                                   href="{{App::make('url')->to('/')}}/modals/{{$items->url}}?sid={{$sid }}&pid={{$pid }}&type=desktop&title={{$Title}}">{{$items->title}}</a></td>
                                        @endif
                                    </tr>
                                @elseif($items->modal=='100')
                                    <tr>
                                        <td>
                                            <div style="height: 20px;width: 20px;padding-top: 5px;color:#fff;font-size: 11pt!important"><span class="{{$items->icon}}"></span></div>
                                        </td>
                                        @if( !empty($PageType) )
                                            <td><a style="float: right;" href="#">{{$items->title}}</a></td>
                                        @else
                                            <td><a style="float: right;" href="#">{{$items->title}}</a></td>
                                        @endif
                                    </tr>
                                @elseif($items->modal=='3')
                                    <tr>
                                        <td>
                                            <div style="height: 20px;width: 20px;padding-top: 5px;color:#fff;font-size: 11pt!important"><span class="{{$items->icon}}"></span></div>
                                        </td>
                                        <td><a style="float: right;" class=" fa fa-anchor {{$items->url}}" title="{{$items->title}}">{{$items->title}}</a></td>
                                    </tr>
                                @elseif($items->modal=='4')
                                    <tr>
                                        <td>
                                            <div style="height: 20px;width: 20px;padding-top: 5px;color:#fff;font-size: 11pt!important"><span class="{{$items->icon}}"></span></div>
                                        </td>
                                        <td><a style="float: right;" title="{{$items->title}}" href="{{App::make('url')->to('/')}}/{{session('Uname')}}/desktop/{{$items->url}}">{{$items->title}}</a></td>
                                    </tr>
                                @elseif($items->modal=='200')

                                @elseif($items->modal=='4')
                                @else
                                    <tr>
                                        <td>
                                            <div style="height: 20px;width: 20px;padding-top: 5px;color:#fff;font-size: 11pt!important"><span class="{{$items->icon}}"></span></div>
                                        </td>
                                        @if($items->url=='groupedit')
                                            <td><a style="float: right;" title="{{$items->title}}" href="{{App::make('url')->to('/')}}/{{$items->url}}/{{$sid }}/{{session('Gname')}}">{{$items->title}}</a></td>
                                        @else
                                            <td><a style="float: right;" title="{{$items->title}}" href="{{App::make('url')->to('/')}}/{{$items->url}}/{{$pid }}/text">{{$items->title}}</a></td>
                                        @endif
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </table>
                </div>
                <?php $i++; ?>
            @endforeach
        </div>
        <a href="{{App::make('url')->to('/')}}/modals/helpview?id=17&amp;tagname=abzarha&amp;hid=6" title="راهنمای اینجا" href="#" class="jsPanels" style="float: left;padding-left: 20px;" title="راهنمای اینجا" data-placement="top"
           data-toggle="tooltip">
            <img style="width: 20px;height: 25px; vertical-align: inherit;padding: 5px 0 0 0;" src="{{App::make('url')->to('/')}}/img/help-animate.gif">
        </a>
    </div>
@endif