@extends('layouts.master')

@section('csrf_token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop


@section('page_title')
    TODO supply a title
@stop

@section('specific_plugin_style')

    <link rel="stylesheet" href="{{URL::to('assets/css/dragable.css')}}">
    <link type="text/css" rel="stylesheet"
          href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/Grid/dist/jquery.bootgrid.css')}}"/>

    <style type="text/css">
        .state_container {

        }

        hr {
            margin-top: 5px;
            margin-bottom: 5px;
            margin-left: 10px;
            margin-right: 10px;
        }

        .gray_background {
            background-color: #eeeeee;
            margin-right: 3px;
            padding: 3px;
            padding-right: 5px;

        }

        #t_radio label {
            margin-left: 15px;
        }

        label {

        }

        #datepicker {
            border: 1px solid #000000;

        }

        p.ui-state-hover {
            font-weight: normal;
        }

        p.ui-widget-header {
            text-align: center;
            font-weight: normal;
        }

        strong.ui-state-error {
            display: block;
            padding: 3px;
            text-align: center;
        }
    </style>

@stop


@section('content')

    <div id="packages" class="col-xs-12">
        <div class="space-14"></div>
        <fieldset>
            <legend>بسته های کاری من</legend>
            @php ($x=1)
            @foreach($packages as $package)

                @if($x%4==1)
                    <div class="row">
                        @endif
                        <div class="col-xs-3">
                            <div class="panel panel-default">
                                <div class="panel-heading well-sm">
                                    <span>{{ $package->title }}</span>
                                    <span class="pull-left" style="font-size: 14px"><i class="fa fa-remove" onclick="RemovePackage({{ $package->id.',"'.$package->title.'"' }})"></i><i
                                                class="fa fa-edit"
                                                onclick="ModifyPackage({{ $package->id }},'{{ $package->title }}')"></i>
                                    </span>
                                </div>
                                <div id="package{{ $package->id }}" class="panel-body">
                                    <ul>
                                        @foreach($package->tasks as $task)
                                            <li>{{ $task->title }}
                                                @if($task->do_type == 1)
                                                    <span style="color: lightpink;">اقدامی</span>
                                                @endif
                                                @if($task->do_type == 2)
                                                    <span style="color: lightblue;">ارجاعی</span>
                                                @endif
                                                <span class="pull-left"><i class="fa fa-remove" onclick="RemoveFromPackage({{ $task->package_id.",".$task->utpid.",'".$task->title."'"
                                             }})"></i>
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="panel-footer">
                                    <div>
                                        <a onclick="show_select_tasks_window_modal(0 , {{ $package->id }},0)" class="cursor-pointer"><i class=" cursor-pointer"></i> پنجره انتخاب وظایف </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                        @if($x%4==0)
                    </div>
                @endif
                @php ($x++)
            @endforeach
            <div class="col-xs-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a class="btn btn-default btn-block" onclick="new_package()">ایجاد بسته کاری جدید</a>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="modal fade" id="new_package" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">تعریف بسته کاری جدید</h4>
                </div>
                <div class="modal-body">


                    <label for="name">عنوان :</label>
                    <input type="text" name="packagetitle" id="packagetitle"
                           class="text ui-widget-content ui-corner-all">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">{{trans('filemanager.cancel')}}</button>
                    <button id="NewTaskPackageSubmitBtn" name="upload_files" value="save" class="btn btn-info"
                            type="button">
                        <i class="glyphicon  glyphicon-save-file bigger-125"></i>
                        <span>ثبت</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="remove_confirm_modal" role="dialog">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color:red;">هشدار</h4>
                </div>
                <div class="modal-body">
                    <span id="modal_massage">آیا از حذف این بسته کاری اطمینان دارید ؟</span>
                </div>
                <div class="modal-footer">
                    <span id="confirm_results"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modify_package" role="dialog">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color:red;">تغییر نام بسته کاری</h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td>نام فعلی :</td>
                            <td><h6 style="color: green;"><span id="current_package_name"></span></h6></td>
                        </tr>
                        <tr>
                            <td>نام جدید :</td>
                            <td><input class="form-control col-xs-6" id="nTitle"/></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-info pull-left" onclick="ChangePackageTitle(1)">تغییر</a>
                    <a class="btn btn-default pull-left" style="margin-left: 3px" onclick="ChangePackageTitle(0)">انصراف</a>
                </div>
            </div>
        </div>
    </div>
@stop


@section('specific_plugin_scripts')
    <script src="{{URL::asset('assets/Packages/Grid/js/moderniz.2.8.1.js')}}" type="text/javascript"></script>
    <script>
        function ChangePackageTitle(res) {

            if (res == 0) {
                $('#modify_package').modal('hide');
            }
            else if (res == 1) {
                $('#modify_package').modal('hide');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var sendInfo = {
                    pid: current_package,
                    nTitle: $('#nTitle').val()
                };
                $.ajax({
                    type: "POST",
                    url: '{{ URL::route('hamahang.tasks.change_package_title') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function (data) {
                        setTimeout(function () {
                            location.reload();
                        }, 400)

                    }
                });
            }

        }

        function ModifyPackage(id, title) {
            current_package = id
            $('#current_package_name').html(title);
            $('#modify_package').modal({show: true});

        }

        var current_utpid;

        function RemoveFromPackage(id, utpid, title) {
            current_utpid = utpid;
            current_package = id;
            var ttl = '<span style="color:red" >' + title + '</span>';
            $('#modal_massage').html('آیا برای حذف وظیفه ' + ttl + ' از بسته کاری مطمئن هستید ؟ ');
            var txt = '<a class="btn btn-danger pull-left" onclick="RemoveFromPackageStep2(1)">حذف شود</a>\
                    <a class="btn btn-default pull-left" style="margin-left: 3px" onclick="RemoveFromPackageStep2(\'no\')">انصراف</a>';
            $('#confirm_results').html(txt);
            $('#remove_confirm_modal').modal({show: true});
        }

        function RemovePackage(id, title) {

            current_package = id;
            var ttl = '<span style="color:red" >' + title + '</span>'
            $('#modal_massage').html('آیا برای حذف بسته کاری ' + ttl + ' مطمئن هستید ؟ ');
            var txt = '<a class="btn btn-danger pull-left" onclick="RemovePackageStep2(1)">حذف شود</a>\
                    <a class="btn btn-default pull-left" style="margin-left: 3px" onclick="RemovePackageStep2(\'no\')">انصراف</a>';
            $('#confirm_results').html(txt);
            $('#remove_confirm_modal').modal({show: true});

        }

        function RemovePackageStep2(id) {
            if (id == 'no') {
                $('#remove_confirm_modal').modal('hide');
            }
            else if (id == 1) {
                $('#remove_confirm_modal').modal('hide');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var sendInfo = {
                    pid: current_package
                };
                $.ajax({
                    type: "POST",
                    url: '{{ URL::route('hamahang.tasks.remove_package') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function (data) {

                        setTimeout(function () {
                            location.reload();
                        }, 400)

                    }
                });
            }
        }
        function RemoveFromPackageStep2(id) {
            if (id == 'no') {
                $('#remove_confirm_modal').modal('hide');
            }
            else if (id == 1) {
                $('#remove_confirm_modal').modal('hide');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var sendInfo = {
                    pid: current_package,
                    utpid: current_utpid
                };
                $.ajax({
                    type: "POST",
                    url: '{{ URL::route('hamahang.tasks.my_assigned_tasks.remove_from_package') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function (data) {

                        //console.log(data);
                        var package_tasks = '<ul>';
                        for (var i = 0; i < data.length; i++) {
                            package_tasks += '<li>' + data[i]['title'] + '<span class="pull-left"><i class="fa fa-remove" onclick="RemoveFromPackage(' + data[i]['package_id'] + ',' + data[i]['utpid'] + ')' +
                                    '"></i></span></li>';
                        }
                        package_tasks += '</ul>';
                        $('#package' + current_package).html(package_tasks);
                    }
                });
            }
        }
        var current_package = '';
        function select_task_modal(id) {
            current_package = id;
            $('#select_tasks').modal({show: true});
        }
        function new_package() {
            $('#new_package').modal({show: true});
        }
        ;
        $('#NewTaskPackageSubmitBtn').click(function () {
            //alert($('#packagetitle').val());
            $('#new_package').modal('hide');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var sendInfo = {
                title: $('#packagetitle').val(),
            };
            $.ajax({
                type: "POST",
                url: '{{ URL::route('hamahang.tasks.new_package') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {
                    setTimeout(function () {
                        location.reload();
                    }, 1000)
                }
            });
        });

        $("#keywords").select2({
            minimumInputLength: 1,
            tags: false,
            dir: "rtl",
            width: '100%',
            ajax: {
                url: "{{ route('hamahang.tasks.search_keywords') }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
        $('#keywords').change(function () {
            refresh_data(current_statement);
        });
        var selectedrow = [];
        var current_statement = 1;
        $(document).ready(function () {
            refresh_data(current_statement);
        });

        function refresh_data(id) {
            console.log('before:' + selectedrow);
            var kw = $('#keywords').val();
            {{--var url = "{{ route('hamahang.tasks.FetchMyAssignedTasks')}}";--}}
            $("#MyTasksGrid").bootgrid("destroy");
            $("#MyTasksGrid").bootgrid({
                ajax: true,
                url: url,
                selection: true,
                multiSelect: true,
                post: {type: id, kw: kw},
                formatters: {
                    "link": function (column, row) {
                        return "<a class='cls3' style='margin: 2px' onclick='change_item(" + row.id + ")' href=\"#\"><i class='fa fa-edit'></i></a><a style='margin:2px;' class='cls3'  onclick='RemoveChartItem(" + row.id + ")' href=\"#\"><i >حذف</i></a>";
                    }
                }
            }).on("selected.rs.jquery.bootgrid", function (e, rows) {


                for (var i = 0; i < rows.length; i++) {
                    var x = parseInt(rows[i].id);
                    selectedrow.push(x);
                    $('#selected_tasks_count').html(selectedrow.length);
                    console.log('push=>' + selectedrow);
                }
            }).on("deselected.rs.jquery.bootgrid", function (e, rows) {
                for (var i = 0; i < rows.length; i++) {
                    var x = parseInt(rows[i].id);
                    for (var j in selectedrow) {
                        if (selectedrow[i] == x) {
                            selectedrow.splice(j, 1);
                            break;
                        }
                    }
                }
                $('#selected_tasks_count').html((selectedrow.length) - 1);
            }).on('loaded.rs.jquery.bootgrid', function () {
                $("#MyTasksGrid").bootgrid('select', selectedrow);
            });

        }

        function add_task_to_package() {
            if (selectedrow.length > 0) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var sendInfo = {
                    s_arr: selectedrow,
                    pid: current_package
                };

                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.tasks.my_assigned_tasks.add_to_package') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function (data) {
                        var package_tasks = '<ul>';
                        for (var i = 0; i < data.length; i++) {
                            package_tasks += '<li>' + data[i]['title'] + '<span class="pull-left"><i class="fa fa-remove" onclick="RemoveFromPackage(' + data[i]['package_id'] + ',' + data[i]['utpid'] + ')' +
                                    '"></i></span></li>';
                        }
                        package_tasks += '</ul>';
                        $('#package' + current_package).html(package_tasks);
                    }
                });
            }

            $('#select_tasks').modal('hide');
//            setTimeout(function () {
//                location.reload();
//            }, 1000)


        }

    </script>
@stop



@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop


