@extends('layouts.master')
@section('inline_scripts')
    @include('pages.helper.toolbar_inline_js')
@stop
@section('content')
    <link href="{{App::make('url')->to('/')}}/theme/Content/css/textassist.css" rel="stylesheet" type="text/css"/>
    <script src="{{App::make('url')->to('/')}}/theme/Scripts/textassist.js" type="text/javascript"></script>
    @include('scripts.publicpages')
    @include('sections.contextmenu')

    <div class="panel-body text-decoration">
        <div class="row">
            <div class="col-md-4 panel-body new-list">
                <label>اعضاء</label>
                @if (is_array($accept_users) && count($accept_users)>0)
                    @foreach($accept_users as $item)
                        <li>
                            <table>
                                <tbody>
                                <tr>
                                    <td style="width: 30px;">
                                        <a href="{{App::make('url')->to('/')}}/{{$item->Uname}}"> <img src="{{App::make('url')->to('/')}}/pics/user/{{ $item->Pic}}" class="CircleImage mCS_img_loaded" style="width: 55px;height: 55px;"></a>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="{{App::make('url')->to('/')}}/{{$item->Uname}}">{{$item->Name}} {{$item->Family}}  </a>
                                    </td>
                                    <td style="text-align: right;width:15px;">
                                        @if(session('uid') !=$item->id)
                                            <div class="icon icon-minus-square RemoveUser2Group" uid="{{$item->id}}" style="font-size: 150%"></div>
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </li>
                    @endforeach
                @endif
            </div>
            <div class=" col-md-3">
            </div>
            <div class="panel-body new-list col-md-4">
                <label>متقاضیان عضویت</label>
                @if (is_array($request_users) && count($request_users)>0)
                    @foreach($request_users as $item)
                        <li>
                            <table>
                                <tbody>
                                <tr>
                                    <td style="width: 30px;">
                                        <a href="{{App::make('url')->to('/')}}/{{$item->Uname}}"> <img src="{{App::make('url')->to('/')}}/pics/user/{{$item->Pic}}" class="CircleImage mCS_img_loaded" style="width: 55px;height: 55px;"></a>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="{{App::make('url')->to('/')}}/{{$item->Uname}}">{{$item->Name}} {{$item->Family}}  </a>
                                    </td>
                                    <td style="text-align: right;width:15px;">
                                        <div class="icon icon-minus-square RemoveUser2Group" uid="{{$item->id}}" style="font-size: 150%"></div>
                                    </td>
                                    <td style="text-align: right;width:15px;">
                                        <div class="icon icon-plus-square AcceptUser2Group" uid="{{$item->id}}" style="font-size: 150%"></div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </li>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@stop
@include('sections.keywords')
@section('Files')
    @if (is_array($Files) && count($Files)>0)
        <div class="spacer">
            <div class="panel panel-light fix-box1">
                <div class="fix-inr1">
                    <div style="padding: 0;" class="panel-heading panel-heading-darkblue"></div>
                    <div class="panel-body text-decoration">
                        <b>{{ trans('label.Files')  }}</b>
                        @foreach($Files as $item)
                            <li>
                                <div style="display: inline-block;height: 10px; margin: 5px"><span style="font-size: 15pt;height: 10px;" class="icon icon-{{$item['ext']}}"></span></div>
                                <a href="{{App::make('url')->to('/')}}/download?fid={{ $item->id }}&fname={{ $item->Uname }}"><span>{{ $item['title']}}</span><span style="font-size: 7pt;margin-right:10px">{{ $item['size']}}ک.ب</span></a>
                            </li>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    @include('sections.relation')
@stop
@include('sections.tabs')

@section('Tree')
    @include('sections.rightcol')
@stop

