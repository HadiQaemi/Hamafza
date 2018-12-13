@extends('layouts.master')
@section('after_main_style')
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
@stop

@section('after_main_scripts')
    @if ($user->id == auth()->id())
        <script t
                ype="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
        <script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>
    @endif
@stop

@section('content')
    <div class="panel-body text-decoration"  style="direction:rtl">
        @if(auth()->check() && auth()->user()->is_new == '1')
            <div class="gkCode10" style="padding-right: 30px;">
                <div id="new_user_alert">
                    {!! $alert? $alert->comment : '' !!}
                    <div style="text-align: left;">
                        <button type="button" class="btn btn-md btn-primary btn_new_user_to_old">دیدم، برداشته شود!</button>
                    </div>
                </div>
            </div>
        @endif
        {{--@if( $alert!='')--}}
        {{--<div class="gkCode10" style="  margin: 10px;">--}}
        {{--{!! $alert !!}--}}
        {{--</div>--}}
        {{--@endif--}}
        <div class="gkCode10" style="  margin: 10px;">
            @if(auth()->check() && $user->id == auth()->id())
                <a href="{!! route('modals.edit_user_detail') !!}?user_id={{ $user->id }}" title="تنظیمات صفحه کاربری" style=" height: 10px;margin-left: -15px;padding: 0;" class=" iconEdit  edit_user_detail_icon FloatLeft jsPanels">
                    <span class="fa fa-edit" style="color: black; font-size: 17px;"></span>
                </a>
            @endif
                <div style="max-width:170px; display:inline-block; vertical-align:top">
                {{--<a class="@if(auth()->check() && $user->id == auth()->id()) jsPanels @endif" href="{{ route('modals.profile_avatar') }}">--}}
                <a class="@if(auth()->check() && $user->id == auth()->id()) @endif">
                    @if(isset($user->Uname) && isset(auth()->user()->Uname))
                        {{--@if($user->Uname == auth()->user()->Uname)--}}
                            {{--<i class="fa fa-edit" style="margin-right: -20px;"></i>--}}
                        {{--@endif--}}
                    @endif
                    <img src="{{$user->AvatarLink}}" style="width:100px; height: 100px; margin:0 10px;float:right;border-radius: 50%; border: 1px solid #CCCCCC;background: #FFF;padding: 2px; "/>
                </a>
            </div>
            <div style="width:80%; display:inline-block; vertical-align:top">
                <div class="col-xs-3">
                    <h1>{{ $user->Name }}  {{ $user->Family }} </h1>
                    @if(isset($user->Summary) && trim($user->Summary))
                        {{ $user->Summary }}<br>
                    @endif
                    @if(isset($user->Comment) && trim($user->Comment))
                        {{ $user->Comment }}<br>
                    @endif
                    @if(isset($user->profile) && trim($user->profile->birth_date))
                        <span>تاریخ تولد:</span> {{ $user->profile->birth_date }} <span style="padding-left: 10px;"></span>
                    @endif
                    @if(isset($user->profile->City) && trim($user->profile->City))
                        <span>محل تولد:</span> {{ $user->profile->city->name }} <br>
                    @endif
                    @if($user->Email)
                        <span>رایانامه:</span> <a href="mailto:{{ $user->Email }}">{{ $user->Email }} </a> <span style="padding-left: 10px;"></span>
                    @endif
                    @if(isset($user->profile) && trim($user->profile->Tel_number))
                        <span>تلفن:</span> {{ $user->profile->Tel_number }}-{{ $user->profile->Tel_code }} <span style="padding-left: 10px;"></span>
                    @endif
                    @if(isset($user->profile) && trim($user->profile->Website))
                        <span>وبگاه:</span> <a target="_blank" href="http://{{ $user->profile->Website }}">{{ $user->profile->Website }} </a> <span style="padding-left: 10px;"></span>
                    @endif
                    @if(isset($user->profile) && trim($user->profile->Mobile))
                        <span>تلفن همراه:</span> {{ $user->profile->Mobile }}<span style="padding-left: 10px;"></span>
                    @endif
                    @if(isset($user->profile) && trim($user->profile->Fax_number))
                        <span>دورنگار:</span> {{ $user->profile->Fax_number }}-{{ $user->profile->Fax_code }}
                    @endif
                </div>
                @if(trim($user_comment)!='')
                    <div class="col-xs-9 user_comment">
                        {{ $user_comment }}
                    </div>
                @endif
            </div>
        </div>
        {{------------------------------------ User Detail----------------------------------------}}
        {{-- @if ($user->id == auth()->id())
             <div id="user_detail_edit" class="hide">
                 <div id="edit_user_detail" style="padding: 10px 10px 10px 32px;">
                     <form id="user_detail_edit_form" method="post">
                         <table class="table-striped col-xs-12">
                             <tbody>
                             <tr>
                                 <td><span style="color:red">*</span>نام</td>
                                 <td>
                                     <input type="text" name="name" class="form-control required" value="{{ $user->Name }} ">
                                 </td>
                             </tr>
                             <tr>
                                 <td><span style="color:red">*</span>نام خانوادگی</td>
                                 <td>
                                     <input type="text" name="family" class="form-control required" value="{{ $user->Family }}">
                                 </td>
                             </tr>
                             <tr>
                                 <td>معرفی اجمالی</td>
                                 <td><input type="text" name="summary" class="text form-control" value="{{ $user->Summary }}" placeholder="چند واژه برای معرفی شما (مانند عناوینی که در کارت ملاقات ذکر می شود)"></td>
                             </tr>

                             <tr>
                                 <td>دیدگاه ها و ایده های اصلی</td>
                                 <td colspan="1">
                                     <textarea class="form-control" rows="5" name="comment" id="comment" placeholder="دیدگاه ها و ایده های اصلی">{{ $user->Comment }}</textarea>
                                 </td>
                             </tr>
                             <tr>
                                 <td>جنسیت</td>
                                 <td>
                                     <label style="display:inline"><input class="gender" type="radio" @if($user->Gender =='0') checked="checked" @endif value="0" name="gender">مرد</label>
                                     <label style="display:inline"><input class="gender" type="radio" @if($user->Gender =='1') checked="checked" @endif value="1" name="gender">زن</label>
                                     <label style="display:inline"><input class="gender" type="radio" @if($user->Gender =='2') checked="checked" @endif value="2" name="gender">نامشخص</label>
                                 </td>
                             </tr>
                             <tr>
                                 <td>تاریخ تولد</td>
                                 <td>
                                     <input id="birthday" name="birthday" class="form-control jalali_date" type="text" value="{{ isset($user->profile->birth_date) ? $user->profile->birth_date : '' }}"/>
                                 </td>
                             </tr>
                             <tr>
                                 <td>محل تولد</td>
                                 --}}{{--                                {{ dd($user->province) }}--}}{{--
                                 <td>
                                     <div class="row">
                                         <div class="col-xs-3">
                                             <select id="province" name="province" class='select2 province form-control'>
                                                 <option value="0">انتخاب کنید</option>
                                             </select>
                                         </div>
                                         <div class="col-xs-9">
                                             <select id="city" name="city" class='select2 city form-control'>
                                                 <option value="0">انتخاب کنید</option>
                                             </select>
                                         </div>
                                     </div>
                                 </td>
                             </tr>
                             <tr>
                                 <td>تلفن همراه</td>
                                 <td><input type="text" name="mobile" class="form-control" value="{{ isset($user->profile->Mobile) ? $user->profile->Mobile : '' }}"></td>
                             </tr>
                             <tr>
                                 <td>تلفن ثابت</td>
                                 <td style="text-align: right;">
                                     <input style="width: 250px" class="form-control col-xs-9" type="text" value="{{ isset($user->profile->Tel_number) ? $user->profile->Tel_number : '' }}" name="tel_number" size="34" maxlength="10"
                                            placeholder="شماره تلفن">
                                     <input style="width: 100px" class="form-control col-xs-3" type="text" value="{{ isset($user->profile->Tel_code) ? $user->profile->Tel_code : '' }}" name="tel_code" size="4" maxlength="4"
                                            placeholder="کد شهر">
                                 </td>
                             </tr>
                             <tr>
                                 <td> فاکس</td>
                                 <td style="text-align: right;">
                                     <input style="width: 250px" class="form-control col-xs-9" type="text" value="{{ isset($user->profile->Fax_number) ? $user->profile->Fax_number : '' }}" name="fax_number" size="34" maxlength="10"
                                            placeholder="شماره فکس">
                                     <input style="width: 100px" class="form-control col-xs-3" type="text" value="{{ isset($user->profile->Fax_code) ? $user->profile->Fax_code : ''  }}" name="fax_code" size="4" maxlength="4"
                                            placeholder="کد شهر">
                                 </td>
                             </tr>
                             <tr>
                                 <td>وب سایت</td>
                                 <td>
                                     <input type="text" name="website" class="form-control" value="{{ isset($user->profile->Website) ? $user->profile->Website : '' }}">
                                 </td>
                             </tr>
                             <tr>
                                 <td><span style="color:red">*</span>رایانامه</td>
                                 <td><input type="text" name="email" class="form-control" value="{{ isset($user->Email) ? $user->Email : '' }}" readonly></td>
                             </tr>
                             <tr>
                                 <td></td>
                                 <td>
                                 <span class="FloatLeft">
                                     <input type="button" value="تایید" class="btn btn-primary btn_edit_user_detail">
                                     <input type="button" value="لغو" class="btn btn-default btn_abort_edit_user_detail">
                                 </span>
                                 </td>
                             </tr>
                             </tbody>
                         </table>
                     </form>
                 </div>
             </div>
         @endif--}}
        {{------------------------------------ User Detail----------------------------------------}}
        <div class="total" style="padding: 10px 10px 10px 32px;">
            <h1 class="heading" id="specials">
                <span class="icon icon-open"></span>
                <span id="specials">تخصص‌ها</span>
            </h1>
            <div class="inner">
                <div id="user_special_edit" class="hide">
                    <table class="col-xs-12">
                        <tr>
                            <td>
                                <form id="update_user_specials_form">
                                    <input id="edit_form_item_id" type="hidden" name="item_id" value="{{ $user->id }}">
                                    <span>اگر تخصص انتخابی شما در لیست ثبت نشده باشد، به عنوان یک تخصص جدید ثبت می‌گردد.</span>
                                    <select id="user_specials" name="user_specials[]" multiple="multiple" class='select2 user_specials form-control' placeholder="انتخاب و ثبت تخصص"></select>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="FloatLeft">
                                    <input type="button" class="btn btn-primary btn_update_user_specials" value="تایید">
                                    <input type="button" class="btn  btn-default btn_abort_update_user_specials" value="لغو">
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <table style="width:100%">
                    <?php $i = 1; ?>
                    @php($user_specials = $user->user_specials()->whereHas('keyword')->get())
                    @if($user_specials && $user_specials->count() > 0)
                        @foreach($user_specials as $special)
                            <li style="padding: 5px;">
                                <div class="endorse_item" style="border: none;">
                                    @if($special->EndorsedByMe)
                                        <div style="float: right;" id="{{ $special->id }}" class="fa fa-2x fa-check-square-o endorse_voted @if($user->id == auth()->id()) cursor-no-drop @else cursor-pointer @endif special" title="حذف صحه گذاری" data-placement="top" data-toggle="tooltip"></div>
                                    @else
                                        <div style="float: right;" id="{{ $special->id }}" class="fa fa-2x fa-check-square-o endorse_vote_icon @if($user->id == auth()->id()) cursor-no-drop @else cursor-pointer @endif special" title="صحه گذاری" data-placement="top" data-toggle="tooltip"></div>
                                    @endif
                                    <div class="endorse_title" style="padding: 5px;background-color: #ececec; margin-left: 10px;">
                                        <span> {{$special ? $special->keyword->title : ''}}</span>
                                    </div>
                                    <div class="endorse_vote_count cursor-pointer" title="صحه گذاران" data-placement="top" data-toggle="tooltip">
                                        {{--                                    {{$special->endorse_users->count()}}--}}
                                        @if($special->CountEndorse != '0')
                                            @if(auth()->id() != null)
                                                <span class="span_count_users" data-toggle="modal" data-target="#user_endorse"><u>{{ $special->CountEndorse  }}</u>&nbsp;نفر صحه گذاری کرده‌اند. </span>
                                            @else
                                                <span class="span_count_users"><u>{{ $special->CountEndorse  }}</u>&nbsp;نفر صحه گذاری کرده‌اند. </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="clearfixed"></div>
                            </li>
                            @php($i++)
                        @endforeach
                    @endif
                </table>
                @if ($user->id == auth()->id())
                    <div class="icon">
                        <br />
                        <a class="icon-pencil-1 user_specials_edit" style="cursor: pointer"></a> <a class="user_specials_edit" style="cursor: pointer;">ویرایش تخصص‌ها</a>
                    </div>
                @endif
            </div>
        </div>

        <div id="user_works" class="total" style="padding: 10px 10px 10px 32px;">
            <h1 class="heading">
                <span id="specials">مسئولیت‌ها، شغل‌ها</span>
            </h1>
            <h1 class="heading" style="margin: 0px;">
                @if ($user->id == auth()->id())
                    <a class="icon-hazv icon-plus add_new_work"></a>
                    <a class="add_new_work" style="padding: 5px; font-size: 11px; cursor: pointer;">مسئولیت جدید</a>
                @endif
            </h1>
            <div class="inner">
                @if ($user->id == auth()->id())
                    <div class="user_work_form_div"></div>
                @endif
                @if($user->works->count() > 0)
                    <?php $i = 1; ?>
                    <table>
                        @foreach($user->works as $work)
                            <tr>
                                <td>
                                    <label style="display:inline-block;padding:0;width:100%;">
                                        {{$i}}- {{ isset($work->post) ? $work->post : '' }}</label>{{ isset($work->company) ? $work->company : ''}}؛ {{ isset($work->section) ? $work->section : '' }}
                                    ؛ {{ isset($work->start_year) ? $work->jalali_start_year : '' }} - {{ isset($work->end_year) ? ($work->be_continue==1 ? 'ادامه دارد' : $work->jalali_end_year ) : '' }}
                                    ؛ {{ isset($work->province->name) ? $work->province->name : '' }} {{ isset($work->city->name) ? $work->city->name : '' }}
                                    @if ($user->id == auth()->id())
                                        <div class="icon IconHeight">
                                            <span class="icon-hazv delete_user_work" data-item_id="{{ $work->id }}"></span>
                                            <span class="icon-pencil-1 edit_user_work" style="cursor: pointer;"
                                                  data-item_id="{{ $work->id }}"
                                                  data-post="{{ $work->post }}"
                                                  data-company="{{ $work->company }}"
                                                  data-section="{{ $work->section }}"
                                                  data-province="{{ $work->province }}"
                                                  data-city="{{ $work->city }}"
                                                  data-start_year="{{ $work->jalali_start_year }}"
                                                  data-end_year="{{ $work->jalali_end_year }}"
                                                  data-comment="{{ $work->comment }}">
                                            </span>
                                        </div>
                                        <br> {{ isset($work->comment) ? $work->comment : ''}}
                                        <div class="user_work_form_div"></div>
                                    @endif
                                </td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>

        <div id="user_educations" class="total" style="padding: 10px 10px 10px 32px;">
            <h1 class="heading">
                <span class="icon icon-open"></span>
                <span>تحصیلات</span>
            </h1>
            <h1 class="heading" style="margin: 0px;">
                @if ($user->id == auth()->id())
                    <a class="icon-hazv icon-plus add_new_education"></a>
                    <a class="add_new_education" style="padding: 5px; font-size: 11px; cursor: pointer;">تحصیلات جدید</a>
                @endif
            </h1>
            <div class="inner">
                @if($user->id == auth()->id())
                    <div class="user_education_form_div"></div>
                @endif
                @if($user->educations->count() > 0)
                    <?php $i = 1; ?>
                    <table>
                        @foreach($user->educations as $education)
                            <?php
                            if (isset($education->grade))
                            {
                                $grade = '';
                                switch ($education->grade)
                                {
                                    case '1':
                                        $grade = "دیپلم";
                                        break;
                                    case '2':
                                        $grade = "فوق دیپلم";
                                        break;
                                    case '3':
                                        $grade = "کارشناسی";
                                        break;
                                    case '4':
                                        $grade = "کارشناسی ارشد";
                                        break;
                                    case '5':
                                        $grade = "دکتری";
                                        break;
                                    case '6':
                                        $grade = "دکترای حرفه‌ای";
                                        break;
                                    case '7':
                                        $grade = "فوق دکتری";
                                        break;
                                }
                            }
                            ?>
                            <tr>
                                <td>
                                    <label style="display:inline-block;padding:0;width:100%;">
                                        <br>
                                        {{ isset($education->major) ? $education->major : '' }}  {{ isset($education->grade) ? $grade : '' }}؛ {{ isset($education->university) ? $education->university : '' }}
                                        ؛ {{ isset($education->start_year) ? $education->jalali_start_year : ''}} - {{ isset($education->end_year) ? $education->jalali_end_year : ''}}
                                        ؛ {{ isset($education->province->name) ? $education->province->name : '' }} - {{ isset($education->city->name) ? $education->city->name : '' }}
                                        @if ($user->id == auth()->id())
                                            <div class="icon IconHeight">
                                                <span class="icon-hazv delete_user_education" data-item_id="{{ $education->id }}"></span>
                                                <span class="icon-pencil-1 edit_user_education" style="cursor: pointer;"
                                                      data-item_id="{{ $education->id }}"
                                                      data-major="{{ $education->major }}"
                                                      data-start_year="{{ $education->jalali_start_year }}"
                                                      data-end_year="{{ $education->jalali_end_year }}"
                                                      data-grade="{{ $education->grade }}"
                                                      data-province="{{ $education->province }}"
                                                      data-city="{{ $education->city }}"
                                                      data-university="{{ $education->university }}"
                                                      data-comment="{{ $education->comment }}">
                                                </span>
                                            </div>
                                        @endif
                                        <br> {{ isset($education->comment) ? $education->comment : ''}}
                                        <div class="user_education_form_div"></div>
                                    </label>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
    </div>
    <!-- Modal -->

    <!-- Modal -->
    <div class="modal fade" id="user_endorse" role="dialog">
        <div class="modal-dialog" style="top: 10%;">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">صحه گذاران<span class="endorse_title_modal"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="loader"></div>
                    <table class="table table-condensed ">
                        <tbody class="tbody_users">
                        <tr style="text-align: center;">
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
@stop
@include('sections.tabs')

@section('inline_scripts')
    @include('pages.helper.about_user_inline_js')
@stop

@section('Tree')
    @include('sections.rightcol')
@stop
