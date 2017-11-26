<link href="{{url('theme/Content/css/magicsuggest.css')}}" rel="stylesheet">
<script src="{{url('theme/Scripts/magicsuggest-min.js')}}"></script>
<div class="guran-sooreh-list">
    <div class="navbar navbar-default">
        <span class="help-icon-span" style="position: absolute;top: -10px;">
            <a href="{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=abzartanzimat&hid=6" title="راهنمای اینجا" href="#" class="jsPanels icon-help HelpIcon" style="float: left;padding-left: 20px;padding-top: 15px;"
               title="راهنمای اینجا" data-placement="top" data-toggle="tooltip">
            </a></span>
        <ul class="nav nav-tabs">
            <li class="active"><a aria-controls="sooreh-tab-1" href="#sooreh-tab-1" role="tab" data-toggle="tab"> عمومی</a></li>
            <li><a aria-controls="sooreh-tab-2" href="#sooreh-tab-2" role="tab" data-toggle="tab">روابط</a></li>
            <li><a aria-controls="sooreh-tab-3" href="#sooreh-tab-3" role="tab" data-toggle="tab">دسترسی</a></li>
            <li><a aria-controls="sooreh-tab-4" href="#sooreh-tab-4" role="tab" data-toggle="tab">بازار</a></li>
            <li><a aria-controls="sooreh-tab-4" href="#sooreh-tab-5" role="tab" data-toggle="tab">راهنما</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div id="sooreh-tab-1" role="tabpanel" class="tab-pane active">
            <form id="form_subject" method="post" action="{{ route('hamafza.update_subject') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" value="{{$pid}}" name="subject_pid">
                <table class="table">
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
                            @include('sections.page_setting_tags')
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            {!!$fields!!}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" value="{{$sid}}" name="sid">
                            <input type="submit" class="btn btn-primary" value="تایید " style=" float: left" name="addSubject" id="submit">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <div id="sooreh-tab-2" role="tabpanel" class="tab-pane">
            <script type="text/javascript">
                $(document).ready(function () {
                    $(".token-input-list-pages").tokenInput("{{App::make('url')->to('/')}}/Pagesearch", {
                        preventDuplicates: true,
                        hintText: "عبارتی را وارد کنید",
                        noResultsText: "نتیجه‌ای یافت نشد، با زدن دکمه اینتر کلیدواژه جدیدی ایجاد می‌شود",
                        searchingText: "در حال جستجو",
                    });
                });
            </script>
            <form id="form_subject" method="post" action="{{ route('hamafza.update_relations') }}">
                <span style="padding: 10px;"><b>{{$Title}}</b></span>
                <br>
                {!!$relation!!}
                <input type="hidden" value="{{$sid}}" name="rel_sid">
                <input type="submit" class="btn btn-primary" value="تایید " style=" float: left" id="submit2">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            </form>
        </div>
        <div id="sooreh-tab-3" role="tabpanel" class="tab-pane">
            <form id="manager_form" method="post" action="{{ route('hamafza.update_access') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <table width="100%" style="direction:rtl" class="table" id="contactform">
                    <tbody>
                    <tr>
                        <td style="width:150px;">دسترسی ویرایش</td>
                        <td>
                            <input name="limit_edit" type="radio" id="RadioGroup1_0" value="0" <?php if ($Access->access->edit == '0') echo 'checked'; ?> >همه کاربران
                            <input type="radio" name="limit_edit" id="RadioGroup1_1" value="1" <?php if ($Access->access->edit == '1') echo 'checked'; ?> />کاربران مجاز
                            <div id="limit_edit_panel" style="height: 10px;display: inline-block; <?php if ($Access->access->edit == '0') echo 'display: none;'; ?> ">
                                {{-- <input id="magicsuggest" name="user_edits_limit" style="width: 350px;display: inline-block;">--}}
                                <select id="select_user" multiple="multiple" style="width: 350px;display: inline-block;">

                                </select>
                                <script type="text/javascript">
                                    $("#select_user").select2({
                                        ajax: {
                                            type: "POST",
                                            url: '{!! route('auto_complete.users') !!}',
                                            dataType: 'json',
                                            processResults: function (data) {
                                                return {
                                                    results: $.map(data, function (item, i) {
                                                        return {
                                                            text: item.text,
                                                            id: item.id
                                                        }
                                                    })
                                                };
                                            },

                                        },
                                        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                                    });
                                    $("#select_user_m").select2({
                                        ajax: {
                                            type: "POST",
                                            url: '{!! route('auto_complete.users') !!}',
                                            dataType: 'json',
                                            processResults: function (data) {
                                                return {
                                                    results: $.map(data, function (item, i) {
                                                        return {
                                                            text: item.text,
                                                            id: item.id
                                                        }
                                                    })
                                                };
                                            },

                                        },
                                        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                                    });
                                </script>
                               {{--  <script>
                                   $('#magicsuggest').magicSuggest({
                                        data: "{{App::make('url')->to('/')}}/searchUser",
                                        dataUrlParams: {id: 34},
                                        allowFreeEntries: false,
                                        allowDuplicates: false,
                                        hideTrigger: true
                                    });
                                    var ms = $('#magicsuggest').magicSuggest({});
                                    @if ($Access->access->edit == '1' && array_key_exists("editusers", $Access->access) && is_array($Access->access->editusers))
                                        @foreach($Access->access->editusers as $tab)
                                            na = "{{$tab->name}}";
                                            ids = '{{$tab->id}}';
                                            ms.addToSelection([{name: na, id: ids}]);
                                        @endforeach
                                    @endif
                                </script>--}}
                                <a href="{!! route('modals.setting_user_view',['id_select'=>'select_user']) !!}" title="انتخاب کاربران" class="jsPanels">
                                    <span class="icon icon-afzoodane-fard fonts"></span>
                                </a>
                                <input type="hidden"
                                       value="@if($Access->access->edit == '0' && is_array($Access->access->editusers) && count($Access->access->editusers)>0)@foreach($Access->access->editusers as $tab){{$tab->id}},@endforeach @endif"
                                       name="user_edits" uids="" id="user_edits">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:150px;border:none;">دسترسی مشاهده</td>
                        <td style="border:none;">
                            <input name="limit_view" type="radio" id="RadioGroup0_0" value="1" <?php if ($Access->access->view == '1') echo 'checked'; ?> />همه کاربران
                            <input name="limit_view" type="radio" id="RadioGroup0_1" value="0" <?php if ($Access->access->view == '0') echo 'checked'; ?> />کاربران مجاز
                            <div id="limit_view_panel" style="height: 10px;display: inline-block; <?php if ($Access->access->view == '1') echo 'display: none;'; ?>">
                                <select id="select_user_m"  multiple="multiple" name="user_view_limit" style="width: 350px;display: inline-block;">
                                </select>
                                {{-- <script>
                                    $('#magicsuggest2').magicSuggest({
                                        data: "{{App::make('url')->to('/')}}/searchUser",
                                        dataUrlParams: {id: 34},
                                        allowFreeEntries: false,
                                        allowDuplicates: false,
                                        hideTrigger: true
                                    });
                                    var ms2 = $('#magicsuggest2').magicSuggest({});
                                    @if ($Access->access->view == '0' && array_key_exists("viewusers", $Access->access) && is_array($Access->access->viewusers))
                                        @foreach($Access->access->viewusers as $tab)
                                            na = "{{$tab->name}}";
                                            ids = '{{$tab->id}}';
                                            ms2.addToSelection([{name: na, id: ids}]);
                                        @endforeach
                                    @endif
                                </script>--}}
                                <a href="{!! route('modals.setting_user_view',['id_select'=>'select_user_m']) !!}" title="انتخاب کاربران" class="jsPanels">
                                    <span class="icon icon-afzoodane-fard fonts"></span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:100px;">نمایش</td>
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
                            <input type="submit" class="btn btn-primary" value="تایید " style=" float: left" id="submit2">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
            <script>
                $(document).ready(function () {
                    $(".subject_help").tokenInput("{{App::make('url')->to('/')}}/Helpsearch", {
                        preventDuplicates: true,
                        hintText: "عبارتی را وارد کنید",
                        noResultsText: "نتیجه‌ای یافت نشد، با زدن دکمه اینتر کلیدواژه جدیدی ایجاد می‌شود",
                        searchingText: "در حال جستجو",
                        onAdd: function (item) {
                            //add the new label into the database
                            if (parseInt(item.id) == 0) {
                                name = $("tester").text();
                                if (name != null) {
                                    $.ajax({
                                        type: "POST",
                                        url: "tagmergeaction.php",
                                        dataType: 'html',
                                        data: ({New: 'OK', Name: name}),
                                        success: function (theResponse) {
                                            if (theResponse != 'NOK')
                                                alert('بر چسب جدید با موفقیت تعریف شد');
                                            $("#input-plugin-methods").tokenInput("remove", {name: name});
                                            $("#input-plugin-methods").tokenInput("add", {id: theResponse, name: name});
                                        }
                                    });
                                }
                            }
                        },
                        onResult: function (item) {
                            if ($.isEmptyObject(item)) {

                                return [{id: '0', name: $("tester").text()}]
                            } else {
                                return item
                            }

                        }
                    });
                    $("#RadioGroup0_1").click(function () {
                        $("#limit_view_panel").show();
                        $("#limit_view_panel").css('display', 'inline-block');
                    });
                    $("#RadioGroup0_0").click(function () {
                        $("#limit_view_panel").hide();
                    });
                    $("#RadioGroup1_1").click(function () {
                        $("#limit_edit_panel").show();
                        $("#limit_edit_panel").css('display', 'inline-block');
                    });
                    $("#RadioGroup1_0").click(function () {
                        $("#limit_edit_panel").hide();
                    });
                });
            </script>
        </div>
        <div id="sooreh-tab-4" role="tabpanel" class="tab-pane">
            @include('hamahang.Bazaar.helper.bazaar-form')
        </div>
        <div id="sooreh-tab-5" role="tabpanel" class="tab-pane">
            <form id="manager_form" method="post" action="{{ route('hamafza.update_help') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <label>راهنمای اینجا</label>
                <table width="100%" style="direction:rtl" class="table" id="contactform">
                    <tbody>
                    @if(is_array($Access->tabs))
                        @foreach($Access->tabs as $tab)
                            <tr>
                                <td>{{$tab->tab_name}}</td>
                                <td>
                                    <input type="text" style="width:388px" dir="rtl" class="form-control subject_help" name="subject_help[{{$tab->pid}}]" id="subject_help_{{$tab->pid}}">
                                    <script>
                                        @if (is_array($Helps) && count($Helps) > 0)
                                            @foreach($Helps as $hlp)
                                                @if ($hlp->id == $tab->pid && $hlp->help_tag != '')
                                                    var x = "{{$hlp->help_tag}}";
                                                    var y = "{{$hlp->help_name}}";
                                                    $("#subject_help_{{$tab->pid}}").tokenInput("add", {id: x, name: y});
                                                @endif
                                            @endforeach
                                        @endif
                                    </script>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <label>اطلاعیه</label>
                <table width="100%" style="direction:rtl" class="table" id="contactform">
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
                <input type="submit" id="submit" name="addSubject" style=" float: left" value="تایید " class="btn btn-primary">
            </form>
        </div>
    </div>
</div>