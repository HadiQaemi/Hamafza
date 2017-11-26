<link href="{{url('theme/Content/css/magicsuggest.css')}}" rel="stylesheet">
<style>
    .tab-pane{
        padding: 10px !important;
    }
</style>
<script src="{{url('theme/Scripts/magicsuggest-min.js')}}"></script>
<div class="guran-sooreh-list">
    <div class="navbar">
       {{-- <span class="help-icon-span" style="position: absolute;top: -10px;">
            <a href="{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=abzartanzimat&hid=6" title="راهنمای اینجا" href="#" class="jsPanels icon-help HelpIcon" style="float: left;padding-left: 20px;padding-top: 15px;"
               title="راهنمای اینجا" data-placement="top" data-toggle="tooltip">
            </a></span>--}}
        <ul class="nav nav-tabs">
            <li class="active tab" id="omomi"><a aria-controls="sooreh-tab-1" href="#sooreh-tab-1" role="tab" data-toggle="tab"> مشخصات</a></li>
            <li class="tab" id="ravabet"><a aria-controls="sooreh-tab-2" href="#sooreh-tab-2" role="tab" data-toggle="tab">روابط</a></li>
            <li class="tab" id="dasrasi"><a aria-controls="sooreh-tab-3" href="#sooreh-tab-3" role="tab" data-toggle="tab">دسترسی</a></li>
            <li class="tab" id="bazar"><a aria-controls="sooreh-tab-4" href="#sooreh-tab-4" role="tab" data-toggle="tab">فروش</a></li>
            <li class="tab" id="rahnama"><a aria-controls="sooreh-tab-5" href="#sooreh-tab-5" role="tab" data-toggle="tab">راهنما</a></li>
        </ul>
    </div>
    <div class="tab-content" style="overflow-y:auto;height: 280px;">
        <div id="sooreh-tab-1" role="tabpanel" class="tab-pane active" >
            <form id="form_subject_omomi" method="post" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" value="{{$pid}}" name="subject_pid">
                <div id="alert_setting_omomi"></div>
                <table width="100%">
                    <tbody>
                    <tr>
                        <td>عنوان <font color="red">*</font></td>
                        <td>
                            <input type="text" style="width:388px" dir="rtl" id="subject_title" class="form-control" value="{{$Setting->title}}" name="subject_title">
                        </td>
                    </tr>
                    <tr>
                        <td>نوع <font color="red">*</font></td>
                        <td>
                            <select disabled="" class="form-control">
                                <option>
                                    {{$Setting->asubject}}
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>

                        <td>کلیدواژه ها</td>
                        <td>
                            {{--@include('sections.page_setting_tags')--}}
                            <select name="PS_keywords[]" multiple="multiple" class="form-control keywords_list_subject">
                                @if($subjects->keywords)
                                    @foreach($subjects->keywords as $res)
                                        <option selected="selected" value="exist_in{{ $res->id }}">{{ $res->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            @include('hamahang.pages.helper.meta_fields')
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" value="{{$sid}}" name="sid">
                           {{-- <input type="submit" class="btn btn-primary" value="تایید " style=" float: left" name="addSubject" id="submit">--}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <div id="sooreh-tab-2" role="tabpanel" class="tab-pane">
            <form id="form_subject_ravabet" method="post" >
                <div id="alert_setting_ravabet_btn"></div>
                {{--{{ dd($relation) }}--}}
                <div class="form_relations">
                   {{-- <div class="col-xs-6">
                        <select name="relations[]" id="relations"  class="form-control relations"></select>
                    </div>
                    <div class="col-xs-6">
                        <select name="subject_rel[]" id="subject_rel"  class="form-control subject_rel" multiple="multiple"></select>
                    </div>--}}
                </div>

                <input type="hidden" value="{{$sid}}" name="rel_sid">
               {{-- <input type="submit" class="btn btn-primary" value="تایید " style=" float: left" id="submit2">--}}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            </form>
        </div>
        <div id="sooreh-tab-3" role="tabpanel" class="tab-pane">
            <div class="alert alert-success" role="alert"></div>
            <form id="manager_form" method="post" action="{{App::make('url')->to('/')}}/update_Access">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <table width="100%" style="direction:rtl"  id="contactform">
                    <tbody>

                    <tr>
                        <td colspan="2" class="col-xs-12">
                            <span style=" font-size: 14px;">مجوز مشاهده و ویرایش</span>
                            {{--<a href="{!! route('modals.add_user_view') !!}" class="btn btn_primary jsPanels">test</a>--}}
                        </td>
                    </tr>
                    <tr>
                        <td class="col-xs-2">کاربر</td>
                        <td class="col-xs-10">
                            <select name="users_list_setting_edit[]" id="users_list_setting_edit" multiple="multiple" class="form-control users_list_setting_edit">
                                @if(!empty($subjects->user_policies_edit))
                                    @foreach($subjects->user_policies_edit as $subject)
                                        <option selected="selected" value="{{ $subject->id }}">{{ $subject->Name.' '.$subject->Family }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <a href="{!! route('modals.setting_user_view',['id_select'=>'users_list_setting_edit']) !!}" title="انتخاب کاربران" class="jsPanels">
                                <span class="icon icon-afzoodane-fard fonts"></span>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="col-xs-2">نقش</td>
                        <td class="col-xs-10">
                            <select name="roles_list_setting_edit[]" id="roles_list_setting_edit" multiple="multiple" class="form-control roles_list_setting_edit" >
                                @if(!empty($subjects->role_policies_edit))
                                    @foreach($subjects->role_policies_edit as $subject)
                                        <option selected="selected" value="{{ $subject->id }}">{{ $subject->name.' '.$subject->display_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <a href="{!! route('modals.setting_user_view',['id_select'=>'roles_list_setting_edit']) !!}" title="انتخاب کاربران" class="jsPanels">
                                <span class="icon icon-afzoodane-fard fonts"></span>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="col-xs-12">
                            <hr/>
                            <span style=" font-size: 14px;">مجوز مشاهده </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-xs-2">کاربر</td>
                        <td class="col-xs-10">
                            <select name="users_list_setting_view[]" id="access_list_setting_edit" multiple="multiple" class="form-control users_list_setting_view">
                                @if(!empty($subjects->user_policies_view))
                                    @foreach($subjects->user_policies_view as $subject)
                                        <option selected="selected" value="{{ $subject->id }}">{{ $subject->Name.' '.$subject->Family }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <a href="{!! route('modals.setting_user_view',['id_select'=>'access_list_setting_edit']) !!}" title="انتخاب کاربران" class="jsPanels">
                                <span class="icon icon-afzoodane-fard fonts"></span>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td class="col-xs-2">نقش</td>
                        <td class="col-xs-10">
                            <select name="roles_list_setting_view[]" id="add_roles_list_setting_view" multiple="multiple" class="form-control roles_list_setting_view" >
                                @if(!empty($subjects->role_policies_view))
                                    @foreach($subjects->role_policies_view as $subject)
                                        <option selected="selected" value="{{ $subject->id }}">{{ $subject->name.' '.$subject->display_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <a href="{!! route('modals.setting_user_view',['id_select'=>'add_roles_list_setting_view']) !!}" title="انتخاب کاربران" class="jsPanels">
                                <span class="icon icon-afzoodane-fard fonts"></span>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="width:100px;">نمایش زبانه‌ها</td>
                        <td>
                            زبانه&zwnj;ها:
                            @if(is_array($Access->tabs))
                                @foreach($Access->tabs as $tab)
                                    <input type="checkbox" {{$tab->check}} value="{{$tab->sttid}}" name="show[{{$tab->sttid}}]">{{$tab->tab_name}}
                                @endforeach
                            @endif
                            <br>
                            <?php if ($Access->access->ispublic == '1') { ?>
                            <br>
                            <input type="checkbox" name="subject_view" value="1" <?php if ($Access->access->list == '1') echo "checked"; ?> /> نمایش در فهرست‌های خودکار
                            <input type="checkbox" name="subject_search" value="1" <?php if ($Access->access->search == '1') echo "checked"; ?> /> نمایش در جستجو
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border:none;">
                            <span class="d1">
                                <?php if ($Access->access->ispublic == '1') { ?>
                                <?php } else { ?>
                                <input type="checkbox" name="ispublic">پیشنهاد می‌کنم این صفحه، عمومی شود.
                                <?php
                                if ($Access->access->ispublic == '2')
                                    echo '   (این صفحه قبلا پیشنهاد شده است)';
                                }
                                ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none;" colspan="2">
                            <span class="d1">
                                <!--<input type="checkbox" name="subject_graph" value="1"  /> نمایش در شبکه -->
                                <!-- <input type="checkbox" name="subject_top" value="1"  />&nbsp;نمایش در بالا-->
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" value="{{$pid}}" name="access_pid">
                            <input type="hidden" value="{{$sid}}" name="access_sid">
                            {{--<input type="submit" class="btn btn-primary" value="تایید " style=" float: left" id="submit2">--}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <div id="sooreh-tab-4" role="tabpanel" class="tab-pane">
            @include('hamahang.Bazaar.helper.bazaar-form')
        </div>
        <div id="sooreh-tab-5" role="tabpanel" class="tab-pane">
            <form id="manager_form_rahnama" method="post" action="{{App::make('url')->to('/')}}/update_Help">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <label>راهنمای اینجا</label>
                <table width="100%" style="direction:rtl"  id="contactform">
                    <tbody>
                    @if(is_array($Access->tabs))
                        @foreach($Access->tabs as $tab)
                            <tr>
                                <td>{{$tab->tab_name}}</td>
                                <td>
                                    <input type="text" style="width:388px" dir="rtl" class="form-control subject_help" name="subject_help[{{$tab->pid}}]" id="subject_help_{{$tab->pid}}">
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <label>اطلاعیه</label>
                <table width="100%" style="direction:rtl"  id="contactform">
                    <tbody>
                    @if(is_array($Access->tabs))
                        @foreach($Access->tabs as $tab)
                            <tr>
                                <td>{{$tab->tab_name}}</td>
                                <td>
                                    <input type="text" style="width:388px" dir="rtl" class="form-control subject_help" name="subject_Alert[{{$tab->pid}}]" id="subject_Alert{{$tab->pid}}">
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <input type="hidden" value="{{$sid}}" name="Help_sid">
                <input type="hidden" value="{{$pid}}" name="Help_pid">
                {{--<input type="submit" id="submit" name="addSubject" style=" float: left" value="تایید " class="btn btn-primary">--}}
            </form>
        </div>
    </div>
</div>

@include('hamahang.pages.helper.page_setting_inline_js')