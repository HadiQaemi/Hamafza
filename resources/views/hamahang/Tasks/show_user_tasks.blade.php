@extends('layouts.master')


@section('csrf_token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title')
    TODO supply a title
@stop


@section('specific_plugin_style')

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{URL::to('assets/css/dragable.css')}}">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">
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

        #datepicker {
            border: 1px solid #000000;

        }

    </style>
@stop



@section('content')
    <div class="row-fluid" style="background-color: white">
        <div class="space-14"></div>
        <fieldset><legend>اولویت وظایف محول شده به من</legend>
        <div class="container col-xs-12" style="margin-top: 25px;">
            <div class="row-fluid">
                <div class="form-inline col-xs-6">

                    <input type="text" class="form-control" placeholder="عنوان وظیفه ..." name="task_title"
                           id="task_title"
                    />
                    <input type="checkbox" class="form-control" name="official" id="official"/>
                    <label>رسمی</label>
                    <input type="checkbox" class="form-control" name="individual" id="individual"/>
                    <label>غیر رسمی</label>
                    <label style="margin-right: 20px;">مهلت</label>
                    <input type="number" class="form-control " style="width: 80px;" name="respite" id="respite"/>
                </div>
                <div class="form-inline col-xs-6">
                    <input type="checkbox" class="form-control" name="" id="not_started_tasks" checked/>
                    <label>{{trans('tasks.status_not_started')}}</label>
                    <input type="checkbox" class="form-control" name="" id="started_tasks" checked/>
                    <label>{{trans('tasks.status_started')}}</label>
                    <input type="checkbox" class="form-control" name="" id="completed_tasks"/>
                    <label>{{trans('tasks.status_finished')}}</label>
                    <input type="checkbox" class="form-control" name="" id="stoped_tasks"/>
                    <label>متوقف</label>

                </div>
            </div>
            <div class="clearfixed"></div>
            <div class="row-fluid">
                <div class="col-xs-6">
                    <div class="panel panel-default ">
                        <div class="panel-heading text-center">فوری و مهم</div>
                        <div class="panel-body firstContent psize" level="1" id="firstContent">
                            <div class="row-fluid" level="1" id="type1_tasks">
                                @foreach ($tasks as $task)
                                    <?php
                                    $diff = $task->respite_days;
                                    $flasher = '';
                                    if ($task->respite_days < 0)
                                        $flasher = 'flasher';
                                    $ico = 'fa fa-cog';
                                    $spin = '';
                                    if ($task->type == 1)
                                        $spin = "fa fa-cog fa-spin";
                                    if ($task->type == 2)
                                        $spin = "icon-check";
                                    if ($task->type == 3)
                                        $spin = "icon-remove-sign";
                                    if ($task->respite_days > 3)
                                        $class = 'circle-g';
                                    else
                                        $class = 'circle-r';
                                    if ($task->respite_days == 0)
                                        $diff = 'امروز';
                                    elseif ($task->respite_days == 1)
                                        $diff = 'فردا';
                                    ?>
                                    @if ($task->immediate == true & $task->importance == true)
                                        <div id="{{ $task->id }}" class="draggable col-xs-12">
                                            <div class="dragable-inner">
                                                <div style="position: absolute; right: 5px;">
                                                    <div class="{{ $class }} {{ $flasher }}">{{ $diff }}</div>
                                                </div>
                                                <div class="task_title">
                                                    {{ $task->title }} <span style="font-size: 8px">مسئول : {{ $task->Name }}  {{  $task->Family }}</span>
                                                </div>
                                                <div style="position: absolute; left: 7px;" class="state_icon">
                                                    <i class="{{ $ico }} {{ $spin }}"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">مهم و غیرفوری</div>
                        <div class="panel-body secendContent psize" level="2" id="secendContent">
                            <div class="row-fluid" level="2" id="type2_tasks">
                                @foreach ($tasks as $task)
                                    <?php
                                    $diff = $task->respite_days;
                                    $flasher = '';
                                    if ($task->respite_days < 0)
                                        $flasher = 'flasher';
                                    $spin = '';
                                    if ($task->type == 1)
                                        $spin = "fa-spin";

                                    if ($task->respite_days > 3)
                                        $class = 'circle-g';
                                    else
                                        $class = 'circle-r';
                                    if ($task->respite_days == 0)
                                        $diff = 'امروز';
                                    elseif ($task->respite_days == 1)
                                        $diff = 'فردا';
                                    ?>
                                    @if ($task->immediate == false & $task->importance == true)
                                        <div id="{{ $task->id }}" class="draggable col-xs-12">
                                            <div class="dragable-inner">
                                                <div style="position: absolute; right: 5px;">
                                                    <div class="{{ $class }} {{ $flasher }}">{{ $diff }}</div>
                                                </div>
                                                <div style="" class="task_title">
                                                    {{ $task->title }} <span style="font-size: 8px">مسئول : {{ $task->Name }}  {{  $task->Family }}</span>
                                                </div>
                                                <div style="position: absolute; left: 7px;" class="state_icon">
                                                    <i class="fa fa-cog {{ $spin }}"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="col-xs-6">
                    <div class="panel panel-default ">
                        <div class="panel-heading text-center">فوری و غیرمهم</div>
                        <div class="panel-body thirdContent psize" level="3" id="thirdContent">
                            <div class="row-fluid" level="3" id="type3_tasks">
                                @foreach ($tasks as $task)
                                    <?php
                                    $diff = $task->respite_days;
                                    $flasher = '';
                                    if ($task->respite_days < 0)
                                        $flasher = 'flasher';
                                    $spin = '';
                                    if ($task->type == 1)
                                        $spin = "fa-spin";

                                    if ($task->respite_days > 3)
                                        $class = 'circle-g';
                                    else
                                        $class = 'circle-r';
                                    if ($task->respite_days == 0)
                                        $diff = 'امروز';
                                    elseif ($task->respite_days == 1)
                                        $diff = 'فردا';
                                    ?>
                                    @if ($task->immediate == true & $task->importance == false)
                                        <div id="{{ $task->id }}" class="draggable col-xs-12">
                                            <div class="dragable-inner">
                                                <div style="position: absolute; right: 5px;">
                                                    <div class="{{ $class }} {{ $flasher }}">{{ $diff }}</div>
                                                </div>
                                                <div class="task_title">
                                                    {{ $task->title }} <span style="font-size: 8px">مسئول : {{ $task->Name }} {{  $task->Family }}</span>
                                                </div>
                                                <div style="position: absolute; left: 7px; " class="state_icon">
                                                    <i class="fa fa-cog {{ $spin }}" style=""></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">غیرمهم و غیرفوری</div>
                        <div class="panel-body  fourthContent psize " level="4" id="fourthContent">
                            <div class="row-fluid" level="4" id="type4_tasks">
                                @foreach ($tasks as $task)
                                    <?php
                                    $diff = $task->respite_days;
                                    $flasher = '';
                                    if ($task->respite_days < 0)
                                        $flasher = 'flasher';
                                    $spin = '';

                                    if ($task->type == 1)
                                        $spin = "fa-spin";

                                    if ($task->respite_days > 3)
                                        $class = 'circle-g';
                                    else
                                        $class = 'circle-r';
                                    if ($task->respite_days == 0)
                                        $diff = 'امروز';
                                    elseif ($task->respite_days == 1)
                                        $diff = 'فردا';
                                    ?>
                                    @if ($task->immediate == false & $task->importance == false)
                                        <div id="{{ $task->id }}" class="draggable col-xs-12">
                                            <div class="dragable-inner">
                                                <div style="position: absolute; right: 5px;">
                                                    <div class="{{ $class }} {{ $flasher }}">{{ $diff }}</div>
                                                </div>
                                                <div class="task_title">
                                                    {{ $task->title }} <span style="font-size: 8px">مسئول : {{ $task->Name }} {{  $task->Family }}</span>
                                                </div>
                                                <div style="position: absolute; left: 7px; " class="state_icon">
                                                    <i class="fa fa-cog {{ $spin }}"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfixed"></div>
            <div class="row-fluid ">
                <form action="user_tasks" method="POST" id="add_task_form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-xs-2" dir="rtl">
                        <input type="text" class="form-control " placeholder="عنوان وظیفه" name='task_title'
                               id="new_task_title"/>
                    </div>
                    <div class="col-xs-3">
                        <div class="input-group">
                <span class="input-group-addon">
                    <i class=""></i>
                </span>
                            <select id="states-multi-select-users"
                                    name="users[]"
                                    class="col-xs-12"
                                    data-placeholder="{{trans('tasks.select_some_options')}}"
                                    multiple>
                                <option value=""></option>
                            </select>
                        </div>


                    </div>
                    <div class="col-xs-2">
                        <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                            <input type="text" class="DatePicker form-control " placeholder="مهلت..." dir="rtl"
                                   id="DatePicker" name='respite_date'/>
                        </div>
                    </div>

                    <div class="col-xs-4 form-inline" id="t_radio" style="">
            <span style="background-color: #eeeeee;">
                <input type="radio" class="form-control" name="importance" id="importance" value="1"/>
                <label for="">مهم</label>

                <input type="radio" class="form-control" name="importance" id="importance" value="0"/>
                <label for="">غیرمهم</label>
            </span>
                        <span style="">|</span>
            <span style="background-color: #eeeeee">

                <input type="radio" class="form-control" name="immediate" id="immediate" value="1"/>
                <label for="">فوری</label>

                <input type="radio" class="form-control" name="immediate" id="immediate" value="0"/>
                <label for="">غیرفوری</label>
            </span>
                    </div>
                    <div class="col-xs-1" style="text-align: left;">
                        <a class="btn btn-default" id="btn_add_task">تائید</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="clearfixed"></div>
        </fieldset>
    </div>
@stop


@section('specific_plugin_scripts')
    <script type="text/javascript"
            src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
    <script type="text/javascript"
            src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>
    <script src="{{URL::asset('assets/Packages/jquery-ui/jquery-ui.js')}}" type="text/javascript"></script>
    <script>
        $("#states-multi-select-users").select2({
            minimumInputLength: 1,
            tags: false,
            dir: "rtl",
            width: '100%',
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
    </script>
    <script>
        $(document).ready(function () {

            $(".DatePicker").persianDatepicker({
                observer: true,
                autoClose: true,
                format: 'YYYY-MM-DD'
            });
            var colors = ['white', 'red']; // Define Your colors here, can be html name of color, hex, rgb or anything what You can use in CSS
            var active = 0;
            setInterval(function () {
                $('.flasher').fadeOut(1000);
                active++;
                if (active == colors.length) {
                    $('.flasher').fadeIn(2000);
                    active = 0;
                }
            }, 1000);
            $("body").mouseup(function () {

                $('.psize2').css({overflow: 'auto'});
            });
            function search_value() {
                alert($('#respite').val());
            }
            ;
        });</script>
    <script>
        $(document).ready(function () {
            var colors = ['white', 'red']; // Define Your colors here, can be html name of color, hex, rgb or anything what You can use in CSS
            var active = 0;
            setInterval(function () {
                $('.flasher').fadeOut(1000);
                active++;
                if (active == colors.length) {
                    $('.flasher').fadeIn(2000);
                    active = 0;
                }
            }, 1000);
            $("body").mouseup(function () {

                $('.psize').css({overflow: 'auto'});
            });
            function search_value() {
                alert($('#respite').val());

            }

        });

    </script>
    <script>
        function search_ajax() {
            $respite_day_no = $('#respite').val();
            $started_tasks = '';
            if ($('#started_tasks').is(':checked'))
                $started_tasks = 1;
            $not_started_tasks = '';
            if ($('#not_started_tasks').is(':checked'))
                $not_started_tasks = 1;
            $completed_tasks = '';
            if ($('#completed_tasks').is(':checked'))
                $completed_tasks = 1;
            $stoped_tasks = '';
            if ($('#stoped_tasks').is(':checked'))
                $stoped_tasks = 1;
            $search_str = '';
            if ($('#task_title').val() != '')
                $search_str = $('#task_title').val();
            if ($('#individual').is(':checked'))
                $individual = 1;
            else
                $individual = 0;
            if ($('#official').is(':checked'))
                $official = 1;
            else
                $official = 0;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var sendInfo = {
                str: $search_str,
                completed_tasks: $completed_tasks,
                started_tasks: $started_tasks,
                stoped_tasks: $stoped_tasks,
                not_started_tasks: $not_started_tasks,
                respite_day_no: $respite_day_no,
                individual: $individual,
                official: $official
            };


            var task;
            $.ajax({
                type: "POST",
                url: '{{ URL::route('Task.filter_priority',['username'=>$uname]) }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {

                    put_data(data['data']);
                    draganddrop();
                }

            });
            function put_data(tasks) {
                document.getElementById('type1_tasks').innerHTML = '';
                document.getElementById('type2_tasks').innerHTML = '';
                document.getElementById('type3_tasks').innerHTML = '';
                document.getElementById('type4_tasks').innerHTML = '';
                for (task in tasks) {
                    if (tasks[task]['immediate'] == 1 && tasks[task]['importance'] == 1) {
                        var flasher = '';
                        if (tasks[task]['respite_days'] < 0)
                            flasher = 'flasher';
                        var task_class = 'circle-g';
                        if (tasks[task]['respite_days'] < 4)
                            task_class = 'circle-r';

                        var ico = 'fa fa-cog';
                        var spin = '';
                        if (tasks[task]['type'] == 1)
                            ico = 'fa fa-cog fa-spin';
                        if (tasks[task]['type'] == 2)
                            ico = 'fa fa-calendar-check-o';
                        if (tasks[task]['type'] == 3)
                            ico = 'fa fa-calendar-times-o';


                        var txt = '<div id="' + tasks[task]['id'] + '" class="draggable col-xs-12 ui-draggable ui-draggable-handle">';
                        txt += '<div class="dragable-inner"><div style="position: absolute; right: 5px;"><div class="' + task_class + ' ' + flasher + '">' + tasks[task]['respite_days'] + '</div>';
                        txt += '</div><div class="task_title">' + tasks[task]['title'] + '</div><div style="position: absolute; left: 7px;" class="state_icon">';
                        txt += '<i class="' + ico + '"></i></div></div></div>';

                        document.getElementById('type1_tasks').innerHTML += txt;


                    }
                    if (tasks[task]['immediate'] == 0 && tasks[task]['importance'] == 1) {
                        var flasher = '';
                        if (tasks[task]['respite_days'] < 0)
                            flasher = 'flasher';
                        var task_class = 'circle-g';
                        if (tasks[task]['respite_days'] < 4)
                            task_class = 'circle-r';

                        var ico = 'fa fa-cog';
                        var spin = '';
                        if (tasks[task]['type'] == 1)
                            ico = 'fa fa-cog fa-spin';
                        if (tasks[task]['type'] == 2)
                            ico = 'fa fa-calendar-check-o';
                        if (tasks[task]['type'] == 3)
                            ico = 'fa fa-calendar-times-o';
                        var txt = '<div id="' + tasks[task]['id'] + '" class="draggable col-xs-12 ui-draggable ui-draggable-handle">';
                        txt += '<div class="dragable-inner"><div style="position: absolute; right: 5px;"><div class="' + task_class + ' ' + flasher + '">' + tasks[task]['respite_days'] + '</div>';
                        txt += '</div><div class="task_title">' + tasks[task]['title'] + '</div><div style="position: absolute; left: 7px;" class="state_icon">';
                        txt += '<i class="' + ico + '"></i></div></div></div>';
                        document.getElementById('type2_tasks').innerHTML = txt;


                    }
                    if (tasks[task]['immediate'] == 1 && tasks[task]['importance'] == 0) {
                        var flasher = '';
                        if (tasks[task]['respite_days'] < 0)
                            flasher = 'flasher';
                        var task_class = 'circle-g';
                        if (tasks[task]['respite_days'] < 4)
                            task_class = 'circle-r';

                        var ico = 'fa fa-cog';
                        var spin = '';
                        if (tasks[task]['type'] == 1)
                            ico = 'fa fa-cog fa-spin';
                        if (tasks[task]['type'] == 2)
                            ico = 'fa fa-calendar-check-o';
                        if (tasks[task]['type'] == 3)
                            ico = 'fa fa-calendar-times-o';
                        var txt = '<div id="' + tasks[task]['id'] + '" class="draggable col-xs-12 ui-draggable ui-draggable-handle">';
                        txt += '<div class="dragable-inner"><div style="position: absolute; right: 5px;"><div class="' + task_class + ' ' + flasher + '">' + tasks[task]['respite_days'] + '</div>';
                        txt += '</div><div class="task_title">' + tasks[task]['title'] + '</div><div style="position: absolute; left: 7px;" class="state_icon">';
                        txt += '<i class="' + ico + '"></i></div></div></div>';
                        document.getElementById('type3_tasks').innerHTML += txt;
                    }
                    if (tasks[task]['immediate'] == 0 && tasks[task]['importance'] == 0) {
                        var flasher = '';
                        if (tasks[task]['respite_days'] < 0)
                            flasher = 'flasher';
                        var task_class = 'circle-g';
                        if (tasks[task]['respite_days'] < 4)
                            task_class = 'circle-r';
                        var ico = 'fa fa-cog';
                        var spin = '';
                        if (tasks[task]['type'] == 1)
                            ico = 'fa fa-cog fa-spin';
                        if (tasks[task]['type'] == 2)
                            ico = 'fa fa-calendar-check-o';
                        if (tasks[task]['type'] == 3)
                            ico = 'fa fa-calendar-times-o';
                        var txt = '<div id="' + tasks[task]['id'] + '" class="draggable col-xs-12 ui-draggable ui-draggable-handle">';
                        txt += '<div class="dragable-inner"><div style="position: absolute; right: 5px;"><div class="' + task_class + ' ' + flasher + '">' + tasks[task]['respite_days'] + '</div>';
                        txt += '</div><div class="task_title">' + tasks[task]['title'] + '</div><div style="position: absolute; left: 7px;" class="state_icon">';
                        txt += '<i class="' + ico + '"></i></div></div></div>';

                        document.getElementById('type4_tasks').innerHTML += txt;


                    }
                    ;
                    draganddrop();

                }
            }

        }
    </script>
    <script>
        $('#btn_add_task').click(function () {
            $('#add_task_form').submit();
        });
        $('#respite').keyup(function () {

            setTimeout(search_ajax, 1000);

        });
    </script>
    <script>
        $('#completed_tasks').click(function () {
            search_ajax();
        });
        $('#started_tasks').click(function () {
            search_ajax();
        });
        $('#not_started_tasks').click(function () {
            search_ajax();
        });
        $('#stoped_tasks').click(function () {
            search_ajax();
        });
        $('#official').click(function () {
            search_ajax();
        });
        $('#individual').click(function () {
            search_ajax();
        });
        $("#task_title").keyup(
                function () {
                    setTimeout(search_ajax, 1000);
                }
        );

    </script>
    <script>
        function draganddrop() {
            var from = '';
            var to = '';
            var tid = '';
            $(".draggable").mousedown(function () {
                tid = ($(this).attr('id'));
                from = ($(this).parent().attr('level'));
                $('.psize2').css({overflow: 'hidden'});
            });
            $(".draggable").draggable({cursor: "crosshair", revert: "invalid"});
            $("#secendContent").droppable({
                accept: ".draggable",
                drop: function (event, ui) {

                    $(this).removeClass("border").removeClass("over");
                    var dropped = ui.draggable;
                    var droppedOn = $(this);
                    to = droppedOn.attr('level');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var sendInfo = {
                        tid: tid,
                        from: from,
                        to: to
                    };
                    $.ajax({
                        type: "POST",
                        url: '{{ route('hamahang.tasks.my_tasks.change_priority') }}',
                        dataType: "json",
                        data: sendInfo
                    });
                    $(dropped).detach().css({top: 0, left: 0}).appendTo(droppedOn);
                },
                over: function (event, elem) {
                    $(this).addClass("over");
                }
                ,
                out: function (event, elem) {
                    $(this).removeClass("over");
                }
            });
            $("#thirdContent").droppable({
                accept: ".draggable",
                drop: function (event, ui) {

                    $(this).removeClass("border").removeClass("over");
                    var dropped = ui.draggable;
                    var droppedOn = $(this);
                    to = droppedOn.attr('level');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var fruits = [tid, from, to];
                    var sendInfo = {
                        tid: tid,
                        from: from,
                        to: to
                    };
                    $.ajax({
                        type: "POST",
                        url: '{{ route('hamahang.tasks.my_tasks.change_priority') }}',
                        dataType: "json",
                        data: sendInfo
                    });
                    //alert(from + '----' + tid + '------->' + to);
                    $(dropped).detach().css({top: 0, left: 0}).appendTo(droppedOn);
                },
                over: function (event, elem) {
                    $(this).addClass("over");
                }
                ,
                out: function (event, elem) {
                    $(this).removeClass("over");
                }
            });
            $("#firstContent").droppable({
                accept: ".draggable", drop: function (event, ui) {

                    $(this).removeClass("border").removeClass("over");
                    var dropped = ui.draggable;
                    var droppedOn = $(this);
                    to = droppedOn.attr('level');
                    /////////////////////////////
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var sendInfo = {
                        tid: tid,
                        from: from,
                        to: to
                    };
                    $.ajax({
                        type: "POST",
                        url: '{{ route('hamahang.tasks.my_tasks.change_priority') }}',
                        dataType: "json",
                        data: sendInfo
                    });
                    $(dropped).detach().css({top: 0, left: 0}).appendTo(droppedOn);
                },
                over: function (event, elem) {
                    $(this).addClass("over");
                }
                ,
                out: function (event, elem) {
                    $(this).removeClass("over");
                }
            });
            $("#fourthContent").droppable({
                accept: ".draggable", drop: function (event, ui) {

                    $(this).removeClass("border").removeClass("over");
                    var dropped = ui.draggable;
                    var droppedOn = $(this);
                    to = droppedOn.attr('level');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var fruits = [tid, from, to];
                    var sendInfo = {
                        tid: tid,
                        from: from,
                        to: to
                    };
                    $.ajax({
                        type: "POST",
                        url: '{{ route('hamahang.tasks.my_tasks.change_priority') }}',
                        dataType: "json",
                        data: sendInfo
                    });
                    $(dropped).detach().css({top: 0, left: 0}).appendTo(droppedOn);
                },
                over: function (event, elem) {
                    $(this).addClass("over");
                }
                ,
                out: function (event, elem) {
                    $(this).removeClass("over");
                }
            })
        }
        ;
    </script>
    <script>
        var from = '';
        var to = '';
        var tid = '';
        $(".draggable").mousedown(function () {
            tid = ($(this).attr('id'));
            from = ($(this).parent().attr('level'));
            // alert('from : '+from);
            $('.psize').css({overflow: 'hidden'});
        });

        $(".draggable").draggable({cursor: "crosshair", revert: "invalid"});
        $("#secendContent").droppable({
            accept: ".draggable",
            drop: function (event, ui) {

                $(this).removeClass("border").removeClass("over");
                var dropped = ui.draggable;
                var droppedOn = $(this);
                to = droppedOn.attr('level');


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var fruits = [tid, from, to];
                var sendInfo = {
                    tid: tid,
                    from: from,
                    to: to
                };


                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.tasks.my_tasks.change_priority') }}',
                    dataType: "json",
                    data: sendInfo
                });

                //alert(from + '-seccond-' + tid + '----->' + to);
                $(dropped).detach().css({top: 0, left: 0}).appendTo(droppedOn);


            },
            over: function (event, elem) {
                $(this).addClass("over");
            }
            ,
            out: function (event, elem) {
                $(this).removeClass("over");
            }
        });
        $("#secendContent").sortable();
        $("#thirdContent").droppable({
            accept: ".draggable",
            drop: function (event, ui) {

                $(this).removeClass("border").removeClass("over");
                var dropped = ui.draggable;
                var droppedOn = $(this);
                to = droppedOn.attr('level');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var fruits = [tid, from, to];
                var sendInfo = {
                    tid: tid,
                    from: from,
                    to: to
                };


                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.tasks.my_tasks.change_priority') }}',
                    dataType: "json",
                    data: sendInfo
                });

                //alert(from + '----' + tid + '------->' + to);
                $(dropped).detach().css({top: 0, left: 0}).appendTo(droppedOn);


            },
            over: function (event, elem) {
                $(this).addClass("over");

            }
            ,
            out: function (event, elem) {
                $(this).removeClass("over");
            }
        });
        $("#thirdContent").sortable();

        $("#firstContent").droppable({
            accept: ".draggable", drop: function (event, ui) {

                $(this).removeClass("border").removeClass("over");
                var dropped = ui.draggable;
                var droppedOn = $(this);
                to = droppedOn.attr('level');

                /////////////////////////////
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var fruits = [tid, from, to];
                var sendInfo = {
                    tid: tid,
                    from: from,
                    to: to
                };


                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.tasks.my_tasks.change_priority') }}',
                    dataType: "json",
                    data: sendInfo
                });
                /////////////////////////////

                //                var xhttp;
                //
                //                xhttp = new XMLHttpRequest();
                //                xhttp.onreadystatechange = function () {
                //                    if (this.readyState == 4 && this.status == 200) {
                //                        document.getElementById("til").innerHTML = this.responseText;
                //                    }
                //                };
                //                var fruits = [tid, from, to];
                //                xhttp.open("GET", "/Tasks/test/" + fruits, true);
                //                xhttp.send();

                //alert(from + '-----' + tid + '----->' + to);
                $(dropped).detach().css({top: 0, left: 0}).appendTo(droppedOn);


            },
            over: function (event, elem) {
                $(this).addClass("over");

            }
            ,
            out: function (event, elem) {
                $(this).removeClass("over");
            }
        });
        $("#fourthContent").sortable();
        $("#fourthContent").droppable({
            accept: ".draggable", drop: function (event, ui) {

                $(this).removeClass("border").removeClass("over");
                var dropped = ui.draggable;
                var droppedOn = $(this);
                to = droppedOn.attr('level');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var fruits = [tid, from, to];
                var sendInfo = {
                    tid: tid,
                    from: from,
                    to: to
                };


                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.tasks.my_tasks.change_priority') }}',
                    dataType: "json",
                    data: sendInfo
                });


                //alert(from + '------' + tid + '---->' + to);
                $(dropped).detach().css({top: 0, left: 0}).appendTo(droppedOn);


            },
            over: function (event, elem) {
                $(this).addClass("over");

            }
            ,
            out: function (event, elem) {
                $(this).removeClass("over");
            }
        });


    </script>

@stop


@include('sections.tabs')

@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop