@if($from_menu == '')
    @extends('pages.Desktop.DesktopFunctions')
    @section('content')
@endif

    <link href="{{App::make('url')->to('/')}}/theme/Content/css/magicsuggest.css" rel="stylesheet">
    <script src="{{App::make('url')->to('/')}}/theme/Scripts/magicsuggest-min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#Addsubkeywords").tokenInput("{{App::make('url')->to('/')}}/Tagsearch", {
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
                                    $("#Addsubkeywords").tokenInput("remove", {name: name});
                                    $("#Addsubkeywords").tokenInput("add", {id: theResponse, name: name});
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

                },
            });
        });</script>
    <div class="panel-body text-decoration">
        <div class='text-content'>
            <form action="{{ route('hamafza.subject_type_save') }}" method="post" name="form" id="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                <div class="col-md-12">
                    <table class="table">
                        <tr>
                            <td class="table-active">
                                نام
                            </td>
                            <td>
                                <input type="hidden" value="0" name="editid">

                                <input type="text" required="" class="form-control col-xs-8" name="name">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;border:none;" class="table-active">
                                پیش عنوان
                            </td>
                            <td style="text-align: right;border:none;">
                                <input type="text" class="form-control col-xs-8" name="pretitle">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;border:none;">
                                توضیح
                            </td>
                            <td style="text-align: right;border:none;">
                                <textarea dir="rtl" id="comment" rows="2" class="form-control" name="comment"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>درگاه</td>
                            <td>
                                <select class="form-control col-xs-4" id="process" name="department">
                                    <option value="0" selected>فاقد درگاه</option>
                                    @if (is_array($Departments))
                                        @foreach($Departments as $item)
                                            <option value="{{ $item->pid }}">{{ $item->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <input type="checkbox" name="department_select"> تعیین هنگام ایجاد
                                <label><input type="checkbox" name="department_require"> الزامی</label>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;border:none;" class="table-active">
                                کلیدواژه ها
                            </td>
                            <td style="text-align: right;border:none;">
                                <input type="text" class="form-control col-xs-4" name="keywords" id="Addsubkeywords">
                                <label><input type="checkbox" name="tag_select"> تعیین هنگام ایجاد</label>
                                <label><input type="checkbox" name="tag_require"> الزامی</label>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;border:none;" class="table-active">
                                چارچوب
                            </td>
                            <td style="text-align: right;border:none;">
                                <select class="form-control col-xs-4" name="charchoob">
                                    <option value="0" selected>فاقد چارچوب</option>
                                    @if (is_array($Framework))
                                        @foreach($Framework as $item)
                                            <option value="{{ $item->id }}">{{ $item->title}}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: right;border:none;">فرآیند :</td>
                            <td style="text-align: right;border:none;">
                                <select class="form-control col-xs-4" id="process" name="process">
                                    <option value="0">بدون فرآیند</option>
                                    @if (is_array($Process))
                                        @foreach($Process as $item)
                                            <option value="{{ $item->id }}">{{ $item->process_name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <input type="checkbox" name="proc_select"> تعیین هنگام ایجاد
                                <label><input type="checkbox" name="proc_require"> الزامی</label>
                            </td>
                        </tr>
                        <!--                <tr>
                                            <td style="text-align: right;border:none;">
                                                پس از ایجاد ورود به


                                            </td>
                                            <td style="text-align: right;border:none;">
                                                <input type="radio" name="editalertshow" value="1" checked=""> حالت ویرایش
                                                <input type="radio" name="editalertshow" value="0" checked=""> حالت نمایش

                                            </td>
                                        </tr>-->
                        <tr>
                            <td style="text-align: right;">اطلاعیه در حالت نمایش صفحه</td>
                            <td style="text-align: right;">
                                <select class="form-control col-xs-7" name="ViewAlert">
                                    <option value="0">بدون اطلاعیه</option>
                                    @if (is_array($Alerts))
                                        @foreach($Alerts as $item)
                                            <option value="{{ $item->id }}">{{ $item->name}}</option>
                                        @endforeach
                                    @endif

                                </select>

                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: right;border:none;">اطلاعیه در حالت ویرایش صفحه</td>
                            <td style="text-align: right;border:none;">
                                <select class="form-control col-xs-7" name="EditAlert">
                                    <option value="0">بدون اطلاعیه</option>
                                    @if (is_array($Alerts))
                                        @foreach($Alerts as $item)
                                            <option value="{{ $item->id }}">{{ $item->name}}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: right;" colspan="2"> فیلدها <br><img style="cursor:pointer" src="{{App::make('url')->to('/')}}/theme/Content/icons/add.png" id="add">&nbsp;<img style="cursor:pointer" id="remove"
                                                                                                                                                                                                   src="{{App::make('url')->to('/')}}/theme/Content/icons/remove.png">
                                <input type="hidden" value="1" id="fieldcount">
                                <script type="text/javascript">
                                    $(function () {

                                        $('img#add').click(function () {
                                            var i = $('#fieldcount').val();
                                            i++;
                                            var sel = ' <select  class="form-control" name="field_type[' + i + ']">' +
                                                    @if (is_array($FieldType))
                                                            @foreach($FieldType  as $key => $value)
                                                        '<option value="{{ $key }}">{{ $value}}</option>' +
                                                    @endforeach
                                                            @endif
                                                        '</select>';
                                            $('<tr><td><input type="text" placeholder="عنوان فیلد"  class="form-control" name="field_name[' + i + ']"></td><td style="text-align: right;">' + sel + '</td> <td><input type="text" placeholder="مقادیر فیلد"  class="form-control" name="field_defval[' + i + ']"></td><td><input type="text" placeholder="بالون راهنما"  class="form-control" name="field_descr[' + i + ']">&nbsp;<input type="checkbox" name="requires[' + i + ']" /> الزامی</td></tr>').appendTo('table#fields');

                                            $('#fieldcount').val(i);
                                        });
                                        $('img#remove').click(function () {
                                            var i = $('#fieldcount').val();
                                            if (i > 1) {
                                                $('table#fields tr:last').remove();
                                                i--;
                                                $('#fieldcount').val(i);

                                            }
                                        });
                                    });
                                </script>
                                <table id="fields" class="table ">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" placeholder="عنوان فیلد" class="form-control" name="field_name[1]">
                                        </td>
                                        <td style="text-align: right;">
                                            <select class="form-control" name="field_type[1]">
                                                @if (is_array($FieldType))
                                                    @foreach($FieldType  as $key => $value)
                                                        <option value="{{ $key }}">{{ $value}}</option>
                                                    @endforeach
                                                @endif
                                            </select>&nbsp;

                                        </td>
                                        <td>
                                            <input type="text" placeholder="مقادیر فیلد" class="form-control" name="field_defval[1]">
                                        </td>
                                        <td>
                                            <input type="text" placeholder="بالون راهنما" class="form-control" name="field_descr[1]">
                                            <label><input type="checkbox" name="requires[1]"> الزامی </label>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>


                        <tr>
                            <td style="text-align: right;" colspan="2">
                                <table id="sortable2" class="table table-default table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th class="center">#</th>
                                        <th class="right">نام زبانه</th>
                                        <th class="right">نوع زبانه</th>
                                        <th class="right">راهنما</th>

                                        <th class="center">ورود</th>
                                        <th class="center">نمایش عمومی</th>
                                        <th class="center">حذف</th>
                                    </tr>
                                    </thead>
                                    <tbody class="ui-sortable">
                                    @for($i=1;$i<=10;$i++)
                                        <tr id="id_1">
                                            <td class="center" style="text-align: right;border:none;">
                                                {{$i}}                                        </td>
                                            <td style="text-align: right;">
                                                <input type="text required" class="form-control" value="" dir="rtl" name="tab_name[{{$i}}]">
                                                <input type="hidden" name="tab_id[{{$i}}]" value="0">

                                            </td>
                                            <td style="text-align: right;">
                                                <select class="form-control col-xs-8" dir="rtl" name="tab_type[{{$i}}]">
                                                    <option value="1">متن</option>
                                                    <option value="4">مفهوم</option>
                                                    <option value="7">درخت</option>
                                                    <option value="20">اصطلاح‌نامه</option>

                                                </select>

                                                <input type="hidden" value="" name="tab_tem[{{$i}}]" id="tab_tem_{{$i}}">
                                            </td>
                                            <td class="center" style="text-align: right;">
                                                <!--<input type="text" class="HelpRel" name="help[{{$i}}]"/>-->
                                                <input type="hidden" name="tab_help[]" />
                                                <select class="form-control help_class" name="tab_help[{{ $i }}]"></select>
                                            </td>
                                            <td class="center" style="text-align: right;">
                                                <input type="radio" @if($i==1) checked="" @endif value="1" name="tab_first">
                                            </td>

                                            <td class="center" style="text-align: right;">
                                                <input type="checkbox" checked="" name="tab_view[{{$i}}]">
                                            </td>

                                            <td class="center" style="text-align: right;">

                                            </td>
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <script>
                            $('.help_class').select2
                            ({
                                minimumInputLength: 2,
                                dir: 'rtl',
                                width: '200',
                                ajax:
                                {
                                    type: 'post',
                                    url: '{{ route('auto_complete.help') }}',
                                    dataType: 'json',
                                    quietMillis: 50,
                                    cache: true,
                                    data: function(term) { return { term: term }; },
                                    processResults: function(data)
                                    {
                                        console.log(data);
                                        var a = true;
                                        return { results: data.results };
                                    }
                                }
                            });
                        </script>

                        <tr>
                            <td colspan="2" class="col-xs-12">
                                <span style="color: blue; font-size: 14px;">مدیریت سطح دسترسی رسمی: </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-xs-2">
                                {{trans('menus.add_user')}}
                            </td>
                            <td class="col-xs-10">
                                <select name="users_list_subject_type_public[]" multiple="multiple" class="form-control users_list_subject_type_public">
                                    @if(!empty($subject_type->user_policies_personal))
                                        @foreach($subject_type->user_policies_personal as $subject)
                                            <option selected="selected" value="{{ $subject->id }}">{{ $subject->Name.' '.$subject->Family }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="col-xs-2">
                                {{trans('menus.add_role')}}
                            </td>
                            <td class="col-xs-10">
                                <select name="roles_list_subject_type_public[]" multiple="multiple" class="form-control roles_list_subject_type_public" >
                                    @if(!empty($subject_type->role_policies_personal))
                                        @foreach($subject_type->role_policies_personal as $subject)
                                            <option selected="selected" value="{{ $subject->id }}">{{ $subject->name.' '.$subject->display_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" class="col-xs-12">
                                <span style="color: blue; font-size: 14px;">مدیریت سطح دسترسی شخصی: </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-xs-2">
                                {{trans('menus.add_user')}}
                            </td>
                            <td class="col-xs-10">

                                <select name="users_list_subject_type_private[]" multiple="multiple" class="form-control users_list_subject_type_private">
                                    @if(!empty($subject_type->user_policies_official))
                                        @foreach($subject_type->user_policies_official as $subject)
                                            <option selected="selected" value="{{ $subject->id }}">{{ $subject->Name.' '.$subject->Family }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="col-xs-2">
                                {{trans('menus.add_role')}}
                            </td>
                            <td class="col-xs-10">
                                <select name="roles_list_subject_type_private[]" multiple="multiple" class="form-control roles_list_subject_type_private" >
                                    @if(!empty($subject_type->role_policies_official))
                                        @foreach($subject_type->role_policies_official as $subject)
                                            <option selected="selected" value="{{ $subject->id }}">{{ $subject->name.' '.$subject->display_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                        </tr>

                       {{-- <tr>
                            <td>
                                سطح دسترسی - رسمی
                            </td>
                            <td>
                                @if (is_array($SecGroup))
                                    @foreach($SecGroup as $item)
                                        <input type="checkbox" value="{{ $item->id }}" name="public[]"><label>{{ $item->name}}</label>
                                    @endforeach
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;border:none;">
                                سطح دسترسی - شخصی
                            </td>
                            <td style="text-align: right;border:none;">
                                @if (is_array($SecGroup))
                                    @foreach($SecGroup as $item)
                                        <input type="checkbox" value="{{ $item->id }}" name="private[]">  <label>{{ $item->name}}</label>
                                    @endforeach
                                @endif

                            </td>
                        </tr>--}}
                        <tr>
                            <td>

                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary floatLeft" style="float: left;" name="addasubject">تایید</button>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <br>
                    <br>

                </div>
            </form>

            <script type="text/javascript">
                $(document).ready(function () {
                    $(".HelpRel").tokenInput("{{App::make('url')->to('/')}}/Helpsearch", {
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

                        },
                    });

                });</script>
        </div>
    </div>
    <script>
        $(".users_list_subject_type_public").select2({
            minimumInputLength: 2,
            dir: "rtl",
            width: '95%',
            ajax: {
                url: "{{ route('auto_complete.users') }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                processResults: function (data) {
                    //console.log(data);
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        });
        $(".roles_list_subject_type_public").select2({
            minimumInputLength: 2,
            dir: "rtl",
            width: '95%',
            ajax: {
                url: "{{ route('auto_complete.roles') }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                processResults: function (data) {
                    //console.log(data);
                    var a = true;
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        });

        $(".users_list_subject_type_private").select2({
            minimumInputLength: 2,
            dir: "rtl",
            width: '95%',
            ajax: {
                url: "{{ route('auto_complete.users') }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                processResults: function (data) {
                    //console.log(data);
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        });
        $(".roles_list_subject_type_private").select2({
            minimumInputLength: 2,
            dir: "rtl",
            width: '95%',
            ajax: {
                url: "{{ route('auto_complete.roles') }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                processResults: function (data) {
                    //console.log(data);
                    var a = true;
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        });
    </script>
@if($from_menu == '')
    @stop
@else
    {{die() }}
@endif

