@include('hamahang.Subjects.new_subject_modals.helper.subject_inline_js')
<div class="navbar navbar-default">
	<span class="help-icon-span">
		{{--<a href="{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=abzarmozoejadid&hid=6" title="راهنمای اینجا" href="#" class="jsPanels icon-help HelpIcon" style="float: left;padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a>--}}
	</span>
    <ul class="nav nav-tabs">
        <li class="active tab"><a aria-controls="tab-1" href="#tab-1" role="tab" data-toggle="tab">مشخصات</a></li>
        <li class="tab"><a aria-controls="tab-2" href="#tab-2" role="tab" data-toggle="tab">دسترسی</a></li>
    </ul>
</div>
<form id="form_new_subject" method="post" enctype="multipart/form-data" name="form">
    <div class="tab-content">
        <div class="form-group">
            <div id="alert_subjects_in_jspanel"></div>
        </div>
        <div id="tab-1" role="tabpanel" class="tab-pane active">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <table width="100%" id="FormTable" dir="ltr">
                <tr id="TitleRow">
                    <td dir="rtl">
                        <input type="text" id="name" required="" class="form-control col-xs-6" name="title">
                    </td>
                    <td width="120" style="text-align: right;">مشخصات</td>
                </tr>
                <tr dir="rtl">
                    <td dir="rtl" style="border:none;">
                        <input type="hidden" id="Framework" name="Framework" value="0">
                        <input type="hidden" id="IsPublic" name="IsPublic" value="1">
                        <input type="hidden" id="SKIND" name="SKIND" value="0">
                        <input type="hidden" id="KindIn" name="kind" value="0">
                        <span style="float: right;margin:0px 5px;">
							@if($subject_type_policies_Official_check == true)
                                <input style="margin-top: 10px;" id="PubRad" checked="checked" name="sectype" value="1" type="radio"> رسمی
                            @else
                                <input style="margin-top: 10px;" class="disabled" disabled name="sectype" value="1" type="radio"> رسمی
                            @endif
                            @if($subject_type_policies_personal_check == true)
                                <input style="margin-top: 10px;" id="PriRad" name="sectype" value="0" type="radio">شخصی
                            @endif
							</span>
                        @if($subject_type_policies_Official_check == true)
                            <select class="form-control col-xs-4" id="PublicSel" name="Skind">
                                @foreach($OfficialSubjects as $item)
                                    <option value="{{ $item->id }}"
                                            tem="true"
                                            public="1"
                                            kind="{{ $item->id}}"
                                            framework="{{ $item->Framework}}"
                                    >{{ $item->name}}</option>
                                @endforeach
                            </select>
                        @endif
                        @if($subject_type_policies_personal_check == true)
                            <select class="form-control col-xs-4" id="PrivatSel" name="Skind" style="display: none;">
                                @foreach($PersonalSubjects as $item)
                                    <option value="{{ $item->id }}" public="0" framework="{{ $item->Framework}}" kind="{{ $item->id}}">{{ $item->name}}</option>
                                @endforeach
                            </select>
                        @endif
                        <br>
                        <div id="Ghaleb" class="col-xs-12" style="float: right;margin:10px 120px 0;display: none;">
                            <input type="checkbox" checked="" name='tem'> قالب کپی شود.
                        </div>
                    </td>
                    <td style="width:120px;border:none;text-align: right">نوع</td>
                </tr>
                <tr>
                    <td dir="rtl">
                        <select name="keywords_list_subject[]" multiple="multiple" class="form-control keywords_list_subject"></select>
                    </td>
                    <td style="width:120px;border:none;text-align: right"> افزودن کلید واژه</td>
                </tr>

            </table>
            <span id="FieldDiv"></span>
            <table>
                <tr>
                    <td colspan="2" style="text-align:left">
                        <input type="hidden" name="fileCount" id="fileCount" value="1"/>
                        <input type="hidden" name="ticket_add" id="ticket_add" value="ticket_add2"/>
                        <input style="display:none" type="submit" name="submit" id="submit_hide" value="ایجاد" class="btn btn-primary submit_btn"/>
                        <input style="display:none" type="submit" name="submit" id="submit_edit_hide" value="ایجاد و ویرایش" class="btn btn-primary submit_btn"/>
                    </td>
                </tr>
            </table>
        </div>
        <div id="tab-2" role="tabpanel" class="tab-pane">
            <table style="width:80%;" id="FormTable" dir="ltr">
                <tr style="direction: rtl;">
                    <td colspan="2">
                        <span style=" font-size: 14px;">مجوز مشاهده</span>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="users_list_subject_view[]" multiple="multiple" class="form-control users_list_subject_view"></select>
                    </td>
                    <td class="col-xs-2"> کاربر
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="roles_list_subject_view[]" multiple="multiple" class="form-control roles_list_subject_view"></select>
                    </td>
                    <td class="col-xs-2"> نقش
                    </td>
                </tr>
                <tr style="direction: rtl;">
                    <td colspan="2">
                        <hr/>
                        <span style="font-size: 14px;">مجوز مشاهده و ویرایش</span>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="users_list_subject_edit[]" multiple="multiple" class="form-control users_list_subject_edit"></select>
                    </td>
                    <td class="col-xs-2"> کاربر
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-10">
                        <select name="roles_list_subject_edit[]" multiple="multiple" class="form-control roles_list_subject_edit"></select>
                    </td>
                    <td class="col-xs-2"> نقش
                    </td>
                </tr>
            </table>
        </div>
    </div>
</form>