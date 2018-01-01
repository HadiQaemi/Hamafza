
    <link href="{{App::make('url')->to('/')}}/theme/Content/css/magicsuggest.css" rel="stylesheet">
    <script src="{{App::make('url')->to('/')}}/theme/Scripts/magicsuggest-min.js"></script>
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
    <span style="text-align: center;">
    مشخصات موضوع
</span>

    <br>
    <div class="panel-body text-decoration">
        <div class='text-content'>
            <form id="form_login" action="{{ route('hamafza.subject_type_save') }}" method="post">
                {{ csrf_field() }}
                <div class="col-md-12">
                    <table class="table">
                        <tr>
                            <td class="table-active">
                                نام
                            </td>
                            <td>
                                <input type="hidden" value="{{$ST->id}}" name="editid">

                                <input type="text" value="{{$ST->name}}" required="" class="form-control col-xs-8" name="name">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;border:none;" class="table-active">
                                پیش عنوان
                            </td>
                            <td style="text-align: right;border:none;">
                                <input type="text" value="{{$ST->pretitle}}" class="form-control col-xs-8" name="pretitle">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;border:none;">
                                توضیح
                            </td>
                            <td style="text-align: right;border:none;">
                                <textarea dir="rtl" value="{{$ST->comment}}" id="comment" rows="2" class="form-control" name="comment"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>درگاه</td>
                            <td>
                                <select class="form-control col-xs-4" id="process" name="department">
                                    <option value="0" selected>فاقد درگاه</option>

                                    @if (is_array($Departments))
                                        @foreach($Departments as $item)
                                            <option value="{{ $item->pid }}" @if($item->pid==$ST->did) selected="true" @endif>{{ $item->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <input type="checkbox" name="department_select" @if($ST->department_select=='1')  checked="" @endif > تعیین هنگام ایجاد
                                <input type="checkbox" name="department_require" @if($ST->department_require=='1')  checked="" @endif > الزامی
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;border:none;" class="table-active">
                                کلیدواژه ها
                            </td>
                            <td style="text-align: right;border:none;">
                                <input type="text" class="form-control col-xs-4" name="keywords" id="Addsubkeywords">
                                <input type="checkbox" name="tag_select" @if($ST->tagselect=='1')  checked="" @endif > تعیین هنگام ایجاد
                                <input type="checkbox" name="tag_require" @if($ST->tagrequire=='1')  checked="" @endif > الزامی
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
                                            <option value="{{ $item->id }}" @if($item->id==$ST->framework) selected="true" @endif>{{ $item->title}}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: right;border:none;">فرآیند</td>
                            <td style="text-align: right;border:none;">
                                <select class="form-control col-xs-4" id="process" name="process">
                                    <option value="0">بدون فرآیند</option>
                                    @if (is_array($Process))
                                        @foreach($Process as $item)
                                            <option value="{{ $item->id }}" @if($item->id==$ST->process) selected="true" @endif>{{ $item->process_name}}</option>
                                        @endforeach
                                    @endif
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;border:none;"></td>
                            <td style="text-align: right;border:none;">

                                <input type="checkbox" name="proc_select" @if($ST->proc_select=='1')  checked="" @endif> تعیین هنگام ایجاد
                                <input type="checkbox" name="proc_require" @if($ST->proc_require=='1')  checked="" @endif> الزامی
                                </p>
                            </td>
                        </tr>
                        <!--                <tr>
                                            <td >راهنما</td>
                                            <td>
                                                <select  class="form-control col-xs-4" id="help" name="help">
                                                    <option value="0">بدون راهنما</option>
                                                </select>
                                            </td>
                                        </tr>-->
                    <!--                <tr>
                    <td style="text-align: right;border:none;">
                        پس از ایجاد ورود به

                    </td> 
                    <td style="text-align: right;border:none;">
                        <input type="radio" name="editalertshow" value="1"   @if($ST->ShowEdit=='1')  checked=""  @endif> حالت ویرایش
                               <input type="radio" name="editalertshow" value="0"   @if($ST->ShowEdit=='0')  checked=""  @endif> حالت نمایش

                    </td>
                </tr>-->
                        <tr>
                            <td style="text-align: right">اطلاعیه در حالت نمایش صفحه</td>
                            <td style="text-align: right;">
                                <select class="form-control col-xs-7" name="ViewAlert">
                                    <option value="0">بدون اطلاعیه</option>
                                    @if (is_array($Alerts))
                                        @foreach($Alerts as $item)
                                            <option value="{{ $item->id }}" @if($item->id==$ST->viewalert) selected="true" @endif>{{ $item->name}}</option>
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
                                            <option value="{{ $item->id }}" @if($item->id==$ST->editalert) selected="true" @endif>{{ $item->name}}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: right;" colspan="2"> فیلدها <br><img style="cursor:pointer" src="{{App::make('url')->to('/')}}/theme/Content/icons/add.png" id="add">&nbsp;<img style="cursor:pointer" id="remove"
                                                                                                                                                                                                   src="{{App::make('url')->to('/')}}/theme/Content/icons/remove.png">
                                <script type="text/javascript">
                                    $(function () {

                                        $('img#add').click(function () {
                                            var i = $('#fieldcount').val();
                                            i++;
                                            var sel = ' <select  class="form-control" name="field_type[]">' +
                                                    @if (is_array($FieldType))
                                                            @foreach($FieldType  as $key => $value)
                                                        '<option value="{{ $key }}">{{ $value}}</option>' +
                                                    @endforeach
                                                            @endif
                                                        '</select>';
                                            $('<tr><td><input type="text" placeholder="عنوان فیلد"  class="form-control" name="field_name[]"></td><td style="text-align: right;">' + sel + '</td> <td><input type="text" placeholder="مقادیر فیلد"  class="form-control" name="field_defval[]"></td><td><input type="text" placeholder="بالون راهنما"  class="form-control" name="field_descr[]">&nbsp;<input type="checkbox" name="requires[]" /> الزامی</td></tr>').appendTo('table#fields');
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
                                    <?php $j = 1; ?>

                                    @if(is_array($ST->fields) &&  count($ST->fields)>0)
                                        @foreach($ST->fields as $f)
                                            <tr>
                                                <td>
                                                    <input type="text" placeholder="عنوان فیلد" value="{{$f->name}}" class="form-control" name="field_name[]">
                                                </td>
                                                <td style="text-align: right;">
                                                    <select class="form-control" name="field_type[]">
                                                        @if (is_array($FieldType))
                                                            @foreach($FieldType  as $key => $value)
                                                                <option value="{{ $key }}" @if($key==$f->type) selected="true" @endif>{{ $value}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="مقادیر فیلد" class="form-control" value="{{$f->defvalue}}" name="field_defval[]">
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="بالون راهنما" class="form-control" name="field_descr[]" value="{{$f->help}}">
                                                    <label><input type="checkbox" name="requires[]"> الزامی </label>
                                                </td>
                                            </tr>
                                            <?php $j++; ?>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                <input type="text" placeholder="عنوان فیلد" value="" class="form-control" name="field_name[]">
                                            </td>
                                            <td style="text-align: right;">
                                                <select class="form-control" name="field_type[]">
                                                    @if (is_array($FieldType))
                                                        @foreach($FieldType  as $key => $value)
                                                            <option value="{{ $key }}">{{ $value}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" placeholder="مقادیر فیلد" class="form-control" value="" name="field_defval[]">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="بالون راهنما" class="form-control" name="field_descr[]" value="">
                                                <label><input type="checkbox" name="requires[]"> الزامی </label>
                                            </td>
                                        </tr>
                                    @endif
                                    <input type="hidden" value="{{$j}}" id="fieldcount">

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
                                        <th class="right">راهنمای اینجا</th>
                                        <th class="center">ورود</th>
                                        <th class="center">نمایش عمومی</th>
                                        <th class="center">حذف</th>
                                    </tr>
                                    </thead>
                                    <tbody class="ui-sortable">

                                    @if(is_array($ST->Tabs) &&  count($ST->Tabs)>0)


                                        @foreach($ST->Tabs as $f)

                                            <tr id="id_1">
                                                <td class="center" style="text-align: right;border:none;">
                                                    {{$i}}                                        </td>
                                                <td style="text-align: right;">
                                                    <input type="text required" class="form-control" value="{{$f->name}}" dir="rtl" name="tab_name[{{$i}}]">
                                                    <input type="hidden" name="tab_id[{{$i}}]" value="{{$f->id}}">
                                                    <input type="hidden" name="tab_tid[{{$i}}]" value="{{$f->tid}}">

                                                </td>
                                                <td style="text-align: right;">
                                                    <select class="form-control col-xs-8" dir="rtl" name="tab_type[{{$i}}]">
                                                        <option value="1" @if($f->type=='1') selected="" @endif>متن</option>
                                                        <option value="4" @if($f->type=='4') selected="" @endif>مفهوم</option>
                                                        <option value="7" @if($f->type=='7') selected="" @endif>درخت</option>
                                                        <option value="20" @if($f->type=='20') selected="" @endif>اصطلاح‌نامه</option>

                                                    </select>
                                                    @if($f->tem!='')
                                                        <a href="{{App::make('url')->to('/')}}/modals/addsubtem?opener=tab_tem_{{$i}}&title=tab_tem_title_{{$i}}" title="قالب" class="jsPanels" id="tab_tem_title_{{$i}}">
                                                            قالب درج شده </a>
                                                        <input type="hidden" value="{{$f->tem}}" name="tab_tem[{{$i}}]" id="tab_tem_{{$i}}">
                                                    @else

                                                        <input type="hidden" value="" name="tab_tem[{{$i}}]" id="tab_tem_{{$i}}">
                                                    @endif
                                                </td>
                                                <td class="center" style="text-align: right;">
                                                    @php ($help = \App\Models\Hamahang\Help::find($f->help_pid))
                                                    <input type="hidden" name="tab_help[]" />
                                                    <select class="form-control help_class" name="tab_help[{{ $i }}]">
                                                        @if ($help)<option value="{!! $help->id !!}">{!! $help->title !!}</option>@endif
                                                    </select>
                                                </td>
                                                <td class="center" style="text-align: right;">
                                                    <input type="radio" value="{{$i}}" name="tab_first" @if($f->first=='1') checked='' @endif>
                                                </td>

                                                <td class="center" style="text-align: right;">
                                                    <input type="checkbox" name="tab_view[{{$i}}]" @if($f->view=='1') checked='' @endif>
                                                </td>

                                                <td class="center" style="text-align: right;">
                                                    <input type="checkbox" name="del_did[{{$i}}]">
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    @endif

                                    @for(;$i<=10;$i++)
                                        <tr id="id_1">
                                            <td class="center" style="text-align: right;border:none;">
                                                {{$i}}                                        </td>
                                            <td style="text-align: right;">
                                                <input type="text required" class="form-control" value="" dir="rtl" name="tab_name[{{$i}}]">
                                                <input type="hidden" name="tab_id[{{$i}}]" value="0">
                                                <input type="hidden" name="tab_tid[{{$i}}]" value="">


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
                                            <td>
                                                <input type="text" class="HelpRel" name="help[{{$i}}]"/>

                                            </td>
                                            <td class="center" style="text-align: right;">
                                                <input type="radio" value="1" name="tab_first">
                                            </td>

                                            <td class="center" style="text-align: right;">
                                                <input type="checkbox" checked="" name="tab_view[{{$i}}]">
                                            </td>

                                            <td class="center" style="text-align: right;">
                                                <input type="hidden" name="del_did[{{$i}}]" value="0">

                                            </td>
                                        </tr>

                                    @endfor


                                    </tbody>
                                </table>
                            </td>
                        </tr>

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
{{--
                        <tr>
                            <td>سطح دسترسی - رسمی</td>
                            <td>
                                @if (is_array($SecGroup))
                                    @foreach($SecGroup as $item)
                                        <input type="checkbox" value="{{ $item->id }}" name="public[]"


                                               @if(is_array($ST->public) &&  count($ST->public)>0)
                                               @foreach($ST->public as $f)
                                               @if($f->secid==$item->id)
                                               checked=''
                                                @endif
                                                @endforeach
                                                @endif

                                        >{{ $item->name}}
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
                                        <input type="checkbox" value="{{ $item->id }}" name="private[]"
                                               @if(is_array($ST->private) &&  count($ST->private)>0)
                                               @foreach($ST->private as $f)
                                               @if($f->secid==$item->id)
                                               checked=''
                                                @endif
                                                @endforeach
                                                @endif
                                        >{{ $item->name}}
                                    @endforeach
                                @endif
                            </td>
                        </tr>--}}
                        <tr>
                            <td>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary FloatLeft" name="addasubject">تایید</button>

                            </td>
                        </tr>
                    </table>
                    <br>
                    <br>

                </div>
            </form>
        </div>
    </div>

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

