@php
    $help_code = 0;
    $route = Route::current();
    if ($route)
    {
        $route_name = $route->getName();
        if ($route_name)
        {
            switch ($route_name)
            {
                case 'page':
                {
                    $route_parameters = $route->parameters();
                    $page_id = $route_parameters['id'];
                    $page = \App\Models\hamafza\Pages::find($page_id);
                    $page_subject = $page->subject;
                    if ($page_subject)
                    {
                        switch ($page_subject->kind)
                        {
                            case '20':
                            {
                                $help_code = 'hpDnr77D8TQ';
                            }
                            default:
                            {
                                $help = DB::table('hamahang_help_relations')->where('target_type', 'App\Models\hamafza\Pages')->where('target_id', $page_id)->get();
                                if ($help->count())
                                {
                                    if (isset($help[0]))
                                    {
                                        $hpid = $help[0]->help_id;
                                        $help_code = $hpid ? enCode($hpid) : 0;
                                    }
                                } else
                                {
                                    $help_code = $page->tab_help;
                                }
                            }
                        }
                    }
                    //$help_code = '[REMOVE]';
                    break;
                }
                case 'page.edit':
                {
                    $route_parameters = $route->parameters();
                    if (isset($route_parameters['Type']))
                    {
                        $route_parameters_type = $route_parameters['Type'];
                        switch ($route_parameters_type)
                        {
                            case 'text':
                            {
                                $help_code = 'Do5AhfWHTSs';
                                break;
                            }
                            case 'slide':
                            {
                                $help_code = 'bf40ZEo5Z0E';
                                break;
                            }
                            case 'films':
                            {
                                $help_code = 'j13pDDm7edo';
                                break;
                            }
                        }
                    }
                    break;
                }
                case 'page.forum':
                {
                    $help_code = 'XXkr9sQi3iI';
                    break;
                }
                case 'page.desktop.index':
                {
                    $help_code = 'hRDEtAuUjJ8';
                    break;
                }
                case 'ugc.desktop.hamahang.acl.index':
                {
                    $help_code = 'KcmXxvdX0u0';
                    break;
                }
                case 'ugc.desktop.Hamahang.files.follow_ME':
                {
                    $help_code = 'swIkIx9Xc0w';
                    break;
                }
                case 'ugc.desktop.hamahang.user_list.index':
                {
                    $help_code = '1lp9YTh6L2w';
                    break;
                }
                case 'ugc.index':
                {
                    $help_code = 'pHZtB1B2sMk';
                    break;
                }
                case 'contents.UserContents':
                case 'ugc.wall':
                {
                    $help_code = 'GOfFSFzmFG8';
                    break;
                }
                case 'page.desktop.announces':
                {
                    $help_code = '5AuondmumWQ';
                    break;
                }
                case 'ugc.desktop.index':
                {
                    $help_code = 'dH_t4i3vxZE';
                    break;
                }
				case (	strstr($route_name,'ugc.desktop.hamahang.tasks.my_tasks',false) ):
                {
                    $help_code = 'S6FryAHtxyg';
                    break;
                }
				case (	strstr($route_name,'ugc.desktop.hamahang.tasks.my_assigned_tasks',false) ):
                {
                    $help_code = 'O5e86Vdno5c';
                    break;
                }
				case 'ugc.desktop.hamahang.tasks.Packages':
                {
                    $help_code = '1HmFWYC26cI';
                    break;
                }
				case 'ugc.desktop.hamahang.project.list':
                {
                    $help_code = '0breATQ_KYA';
                    break;
                }
				case 'ugc.desktop.hamahang.process.list':
                {
                    $help_code = 'lZ9G783RBgE';
                    break;
                }
				case 'ugc.desktop.hamahang.tasks.my_assigned_tasks.show_drafts':
                {
                    $help_code = 'Zo7ZOE5cN2E';
                    break;
                }
				case 'ugc.desktop.hamahang.calendar.index':
                {
                    $help_code = 'M_OO9Rm0N1Y';
                    break;
                }
				case 'ugc.desktop.hamahang.calendar_events.events':
                {
                    $help_code = 'Z25opedJJQc';
                    break;
                }
				case 'ugc.desktop.hamahang.calendar_events.sessions':
                {
                    $help_code = '5ioTwN_IztQ';
                    break;
                }
				case 'ugc.desktop.hamahang.calendar_events.invitations':
                {
                    $help_code = '9nU71Rvx6RI';
                    break;
                }
				case (	strstr($route_name,'ugc.desktop.hamahang.tickets',false) ):
                {
                    $help_code = 'nzA32CirWps';
                    break;
                }
				case (	strstr($route_name,'ugc.desktop.Hamahang.files',false) ):
                {
                    $help_code = 'wZruyEabWpo';
                    break;
                }
				case (	strstr($route_name,'ugc.desktop.keywords',false) ):
                {
                    $help_code = 'JZMzyR073xs';
                    break;
                }
				case 'ugc.desktop.announces':
                {
                    $help_code = 'dtejVqoWgs0';
                    break;
                }
				case 'ugc.desktop.highlights':
                {
                    $help_code = 'vNdPYVsvRHk';
                    break;
                }
				case (	strstr($route_name,'ugc.desktop.form_list',false) ):
                {
                    $help_code = '3WWSTpG_mfo';
                    break;
                }
				case 'ugc.desktop.notifications':
                {
                    $help_code = 'qnpuF1Bip10';
                    break;
                }
				case 'ugc.desktop.hamahang.summary.index':
                {
                    $help_code = 'V1oBEI0xAQA';
                    break;
                }
				case 'ugc.desktop.hamahang.user_list.index':
                {
                    $help_code = 'oX52rdmIqC0';
                    break;
                }
				case 'ugc.desktop.show_groups':
                {
                    $help_code = 'pbBz5nSGruc';
                    break;
                }
				case 'ugc.desktop.hamahang.org_chart.OrgOrgans.list':
                {
                    $help_code = 'Nw_CWdNK2RA';
                    break;
                }
				case 'chart':
                {
                    $help_code = 'XIz_3yUSMfY';
                    break;
                }
				case 'ugc.desktop.hamahang.acl.index':
                {
                    $help_code = 'w72rAsJvVwo';
                    break;
                }
				case 'ugc.desktop.hamahang.subjects.index':
                {
                    $help_code = 'KBylI3uxKNA';
                    break;
                }
				case 'ugc.desktop.hamahang.relations_index':
                {
                    $help_code = 'FplHsEzcGXI';
                    break;
                }
				case 'ugc.desktop.hamahang.subst_index':
                {
                    $help_code = 'xt8KkJ5z77g';
                    break;
                }
				case 'ugc.desktop.hamahang.alerts_index':
                {
                    $help_code = 'op7dbrZ6s08';
                    break;
                }
				case 'ugc.desktop.hamahang.alerts_index':
                {
                    $help_code = 'VBwD2MrcymM';
                    break;
                }
				case 'ugc.desktop.hamahang.basicdata.index':
                {
                    $help_code = '7cEatcNTIik';
                    break;
                }
				case 'ugc.desktop.hamahang.menus.index':
                {
                    $help_code = 'qNMuBK4h9tA';
                    break;
                }
				case 'ugc.desktop.hamahang.tools.index':
                {
                    $help_code = 'A7R9nk-ZHk8';
                    break;
                }

            }
        }
        //dd($route_name);
    }
@endphp

<div class="btn-group pull-right frst-wdt mr"><button type="button" id="rSubMenuBtn" class="btn  fa fa-align-justify icon-reorder" data-icon="U+E0CC" data-toggle="tooltip" data-placement="top" title="ابزارها"></button></div>
@if (auth()->check())
    @if ('Page' == $type)
        @if ('0' == $vals['like'])
            <div class="btn-group pull-right mr">
                <button id="LikePage" type="subject" val="1" @foreach($params as $k => $v) {{ $k }} = "{{ $v }}" @endforeach data-href="{!! route('hamafza.page_like') !!}" type="button" class="btn fa fa-anchor icon-pasandidan" data-toggle="tooltip" data-placement="top" title="{{ trans('labels.Like') }}"></button>
            </div>
        @elseif ('1' == $vals['like'])
            <div class="btn-group pull-right mr">
                <button id="LikePage" type="subject" val="0" @foreach($params as $k => $v) {{ $k }} = "{{ $v }}" @endforeach data-href="{!! route('hamafza.page_like') !!}" type="button" class="btnActive  fa fa-anchor icon-pasandidan" data-toggle="tooltip" data-placement="top" title="{{ trans('labels.disLike') }}"></button>
            </div>
        @endif
        @if ('0' == $vals['follow'])
            <div class="btn-group pull-right mr">
                <button id="FollowPage" type="subject" val="1" @foreach($params as $k => $v) {{ $k }} = "{{ $v }}" @endforeach data-href="{!! route('hamafza.page_follow') !!}"  type="button" class="btn  fa fa-anchor icon-rss" data-toggle="tooltip" data-placement="top" title="{{ trans('labels.follow') }}"></button>
            </div>
        @elseif ('1' == $vals['follow'])
            <div class="btn-group pull-right mr">
                <button id="FollowPage" type="subject" val="0" @foreach($params as $k => $v) {{ $k }} = "{{ $v }}" @endforeach data-href="{!! route('hamafza.page_follow') !!}"  type="button" class="btnActive  fa fa-anchor icon-rss" data-toggle="tooltip" data-placement="top" title="{{ trans('labels.unfollow') }}"></button>
            </div>
        @endif
        @if ('page.forum' != $route_name)
            <div class="btn-group pull-right mr">
                <button id="CommentPage" type="subject" val="1" @foreach($params as $k => $v) {{ $k }} = "{{ $v }}" @endforeach type="button" class="btn  fa fa-anchor icon-ezhare-nazar comment" data-toggle="tooltip" data-placement="top" title="{{ trans('labels.comment') }}"></button>
            </div>
        @endif
    @elseif ('Group' == $type || ('User' == $type && $id != Auth::id())) {{--TODO:Check Group Owner--}}
    @if ('0' == $vals['follow'])
        <div class="btn-group pull-right mr">
            <button id="FollowPage" type="User" val="1" @foreach($params as $k => $v) {{ $k }} = "{{ $v }}" @endforeach data-href="{{route('hamafza.page_follow')}}" type="button" class="btn  fa fa-anchor icon-rss" data-toggle="tooltip" data-placement="top" title="{{ trans('labels.follow') }}"></button>
        </div>
        @if ('page.forum' != $route_name)
            <div class="btn-group pull-right mr">
                <button id="CommentPage" val="1" @foreach($params as $k => $v) {{ $k }} = "{{ $v }}" @endforeach type="button" class="btn  fa fa-anchor icon-ezhare-nazar comment" data-toggle="tooltip" data-placement="top" title="{{ trans('labels.comment') }}"></button>
            </div>
        @endif
    @elseif ('1' == $vals['follow'])
        <div class="btn-group pull-right mr">
            <button id="FollowPage" type="User" val="0" @foreach($params as $k => $v) {{ $k }} = "{{ $v }}" @endforeach data-href="{{route('hamafza.page_follow')}}" type="button" class="btnActive  fa fa-anchor icon-rss" data-toggle="tooltip" data-placement="top" title="{{ trans('labels.unfollow') }}"></button>
        </div>
    @endif
    @endif
    @if ('[REMOVE]' != $help_code)
        <div class="btn-group" style="float: left;"><a href="{!! url("/modals/helpview?code=$help_code") !!}" title="راهنمای اینجا" class="jsPanels icon icon-help HelpIcons"></a></div>
    @endif
@else
    @if ('Page' == $type)
        <div class="btn-group pull-right mr">
            <button type="button" class="btn fa fa-anchor icon-pasandidan login" data-toggle="modal" data-target="#loginWmessage" data-placement="top" title="{{ trans('labels.Like') }}"></button>
        </div>
    @endif
    <div class="btn-group pull-right mr">
        <button type="button" class="btn fa fa-anchor icon-rss login" data-toggle="modal" data-target="#loginWmessage" data-placement="top" title="{{ trans('labels.unfollow') }}"></button>
    </div>
    @if ('page.forum' != $route_name)
        <div class="btn-group pull-right mr">
            <button type="button" class="btn fa fa-anchor icon-ezhare-nazar login" data-toggle="modal" data-target="#loginWmessage" data-placement="top" title="{{ trans('labels.comment') }}"></button>
        </div>
    @endif
    @if ('[REMOVE]' != $help_code)
        <div class="btn-group" style="float: left;"><a href="{!! url("/modals/helpview?code=$help_code") !!}" title="راهنمای اینجا" class="jsPanels icon icon-help HelpIcons"></a></div>
    @endif
@endif