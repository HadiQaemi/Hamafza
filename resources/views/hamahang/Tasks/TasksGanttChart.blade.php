@extends('layouts.master')
@section('specific_plugin_style')
    <link rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dhtmlxgantt.css')}}" type="text/css" media="screen" title="no title" charset="utf-8">
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/helpers/demo.css?v=2522')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/helpers/media/layout.css?v=2522')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themeshelpers/media/elements.css?v=2522')}}"/>

    <!-- daypilot themes -->
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/areas.css?v=2522')}}"/>

    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/month_white.css?v=2522')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/month_green.css?v=2522')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/month_transparent.css?v=2522')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/month_traditional.css?v=2522')}}"/>

    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/navigator_8.css?v=2522')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/navigator_white.css?v=2522')}}"/>

    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/calendar_transparent.css?v=2522')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/calendar_white.css?v=2522')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/calendar_green.css?v=2522')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/calendar_traditional.css?v=2522')}}"/>

    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/scheduler_8.css?v=2522')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/scheduler_white.css?v=2522')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/scheduler_green.css?v=2522')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/scheduler_blue.css?v=2522')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/scheduler_traditional.css?v=2522')}}"/>
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/gantt/dayPilot/themes/scheduler_transparent.css?v=2522')}}"/>
@stop
@section('content')
    <div id="content">
        <div>
            <div class="note"><b>Note:</b> Read more about the <a href="http://javascript.daypilot.org/gantt/">JavaScript Gantt</a>.</div>
            <div id="dp"></div>
        </div>
    </div>
@stop
@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/Packages/gantt/dhtmlxgantt.js')}}"></script>
    <!-- helper libraries -->
    <script src="{{URL::to('assets/Packages/gantt/dayPilot/helpers/jquery-1.12.2.min.js')}}" type="text/javascript"></script>
    <!-- daypilot libraries -->
    <script src="{{URL::to('assets/Packages/gantt/dayPilot/js/daypilot-all.min.js?v=2522')}}" type="text/javascript"></script>
@stop
@section('inline_scripts')
    <script>
        var dp = new DayPilot.Gantt("dp");

        dp.days = 30;

        // generate and load sample tasks

        var start = new DayPilot.Date().getDatePart();
        var last = null;
        for (var i = 0; i < 5; i++) {
            var duration = Math.floor(Math.random() * 3) + 1; // 1 to 3
            var end = start.addDays(duration);
            console.log(start);
            console.log(end);
            var e = new DayPilot.Task({
                start: start,
                end: end,
                id: DayPilot.guid(),
                text: "Task " + i,
                tags: {
                    info: "info text"
                },
                children: [
                    {
                        start: start,
                        end: end,
                        id: DayPilot.guid(),
                        text: "Subtask 1",
                        complete: Math.floor(Math.random() * 101) // 0 to 100
                    },
                    {
                        start: start,
                        end: end,
                        id: DayPilot.guid(),
                        text: "Subtask 2",
                        complete: Math.floor(Math.random() * 101) // 0 to 100
                    },
                    {
                        start: end,
                        id: DayPilot.guid(),
                        text: "Milestone 1",
                        type: "Milestone"
                    }

                ]
            });
            console.log('salam');
            console.log(e);
            dp.tasks.add(e);

            if (last) {
                dp.links.add(new DayPilot.Link({
                    id: DayPilot.guid(),  // optional
                    from: last,
                    to: e.id(),
                    type: "FinishToStart"
                }));
            }
            last = e.id();
            start = end;

        }

        dp.columns = [
            {
                title: "Name",
                width: 50,
                property: "text"
            },
            {
                title: "Info",
                width: 50,
                property: "info"
            },
            {
                title: "Duration",
                width: 50
            }
        ];

        dp.onBeforeRowHeaderRender = function (args) {
            var duration = args.task.duration();
            var html = duration.toString("d") + "d " + duration.toString("h") + "h";
            args.row.columns[2].html = html;
        };

        dp.onBeforeTaskRender = function (args) {
            //args.data.complete = 30;
            //args.data.html = args.task.text + "*";
            //args.data.htmlRight = "right";
            //args.data.htmlLeft = "very long left";
        };

        dp.onRowMoving = function (args) {
            //args.position = "forbidden";
        };

        dp.onColumnResized = function (args) {
            window.console && console.log(args);
            window.console && console.log(dp.columns);
        };

        dp.contextMenuLink = new DayPilot.Menu({
            items: [
                {
                    text: "Show link ID", onclick: function () {
                    alert("Link ID: " + this.source.data.id);
                }
                },
                {
                    text: "Delete link", onclick: function () {
                    dp.links.remove(this.source);
                }
                }
            ]
        });

        dp.contextMenuTask = new DayPilot.Menu({
            items: [
                {
                    text: "Show task ID", onclick: function () {
                    alert("Task ID: " + this.source.id());
                }
                },
                {
                    text: "Delete task", onclick: function () {
                    dp.tasks.remove(this.source);
                }
                }
            ]
        });

        dp.contextMenuRow = new DayPilot.Menu({
            items: [
                {
                    text: "Show task ID", onclick: function () {
                    alert("Task ID: " + this.source.id());
                }
                },
                {
                    text: "Delete task", onclick: function () {
                    dp.tasks.remove(this.source);
                }
                }
            ]
        });

        dp.onTaskClicked = function (args) {
            window.console && console.log(args);
            args.task.row.toggle();
        };

        dp.onTaskDoubleClicked = function (args) {
            alert("Double-clicked: " + args.task.id());
            window.console && console.log(args);
        };

        dp.onRowMove = function (args) {
            window.console && console.log(args);
        };

        dp.onRowMoved = function (args) {
            window.console && console.log(args);
        };

        dp.onLinkCreate = function (args) {
            window.console && console.log(args);
        };

        dp.onRowDoubleClick = function (args) {
            window.console && console.log(args);
        };

        dp.onRowSelect = function (args) {
            window.console && console.log(args);
        };

        dp.onTaskRightClick = function (args) {
            window.console && console.log(args);
        };

        dp.onTaskMove = function (args) {
            window.console && console.log(args);
        };

        dp.onTaskMoving = function (args) {
            window.console && console.log(args);
        };

        dp.linkBottomMargin = 5;
        dp.taskHeight = 24;

        dp.separators = [
            {
                color: "red",
                width: 2,
                location: DayPilot.Date.today().addDays(1),
                layer: "BelowEvents"
            }
        ];

        dp.init();


        $(document).ready(function () {

        });
        function get_data() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var sendInfo = {
                id: 1

            };
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.tasks.my_assigned_tasks.GetData') }}',
                dataType: "json",
                data: sendInfo,
                success: function (data) {
                    console.log(data);
                    alert('ok');
                }
            });
        }


    </script>

@stop
@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop