<style>
    .HFM_ModalOpenBtn{
        border: none !important;
    }
</style>
<div id="tab" class="row table-bordered" style="border-bottom: none">
    <ul class="nav nav-tabs">
        <li class="active" id="define">
            <a href="#tab_t1" data-toggle="tab">عمومی</a>
        </li>
        <li>
            <a href="#tab_t2" data-toggle="tab">دسترسی</a>
            {{--<a href="#" data-toggle="tab">تنظیم</a>--}}
        </li>
    </ul>
    <form action="{{ route('hamahang.diagram.save_diagram') }}" class="" name="digram_form" id="digram_form" method="post"
          enctype="multipart/form-data">
        <div class="tab-content new-task-form">
            <div class="tab-pane active tab-view" id="tab_t1">
                <div class="row col-lg-12">
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4"><label class="line-height-35">{{ trans('tasks.title') }}</label></div>
                    <div class="col-lg-8">
                        <div class="row">
                            <input type="text" class="form-control" name="title" id="title" placeholder="{{trans('tasks.title')}}" value="{{isset($diagram->title) ? $diagram->title : ''}}"/>
                            <input name="did" id="did" type="hidden" value="{{ enCode($diagram->id) }}">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                        <div class="col-lg-4 col-md-3 col-sm-4 col-xs-4"><label class="line-height-35">شناسه</label></div>
                        <div class="col-lg-8 col-md-3 col-sm-4 col-xs-4"><label class="line-height-35">{{ enCode($diagram->id) }}</label></div>
                    </div>
                </div>
                <div class="row col-lg-12">
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4"><label class="line-height-35">{{ trans('tasks.keyword') }}</label></div>
                    <div class="col-lg-11">
                        <select id="new_task_keywords" class="select2_auto_complete_keywords" name="keywords[]"
                                data-placeholder="{{trans('tasks.select_some_keywords')}}"
                                multiple="multiple">
                            @if(isset($task['task_keywords']))
                                @foreach($task['task_keywords'] as $keyword)
                                    <option value="{{$keyword->id}}" selected>{{$keyword->title}}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class=" Chosen-LeftIcon"></span>
                    </div>
                </div>
            </div>
            <div class="tab-pane tab-view" id="tab_t2">
                <table style="width:80%;" id="FormTable" dir="ltr">
                    <tr style="direction: rtl;">
                        <td colspan="2">
                            <span style=" font-size: 14px;">مجوز استفاده</span>
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
                            <select name="roles_list_subject_edit[]" multiple="multiple" class="form-control roles_list_subject_edit"></select>
                        </td>
                        <td class="col-xs-2"> نقش
                        </td>
                    </tr>
                    {{--<tr style="direction: rtl;">--}}
                        {{--<td colspan="2">--}}
                            {{--<hr/>--}}
                            {{--<span style="font-size: 14px;">مجوز مشاهده و ویرایش</span>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td class="col-xs-10">--}}
                            {{--<select name="users_list_subject_edit[]" multiple="multiple" class="form-control users_list_subject_edit"></select>--}}
                        {{--</td>--}}
                        {{--<td class="col-xs-2"> کاربر--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td class="col-xs-10">--}}
                            {{--<select name="roles_list_subject_edit[]" multiple="multiple" class="form-control roles_list_subject_edit"></select>--}}
                        {{--</td>--}}
                        {{--<td class="col-xs-2"> نقش--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                </table>
            </div>

        </div>
    </form>
</div>

<script>
    $(".users_list_subject_view").select2({
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
                console.log(data);
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });
    $(".roles_list_subject_view").select2({
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
                console.log(data);
                var a = true;
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });
    $(".roles_list_subject_view").html('<option selected="selected" value="3">public عمومی</option>');

    $(".users_list_subject_edit").select2({
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
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });

    $(".roles_list_subject_edit").select2({
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
                console.log(data);
                var a = true;
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });

</script>

<script type="text/javascript" src="{{URL::to('assets/Packages/DataTables/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/bootstrap/js/bootstrap-filestyle.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
<script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>

@include('hamahang.Tasks.helper.CreateNewTask.inline_js')
