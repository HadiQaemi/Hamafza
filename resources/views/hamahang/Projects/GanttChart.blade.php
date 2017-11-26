@extends('layouts.master')
@section('after_main_style')
    <!--<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/GanttChart/sources/skins/dhtmlxgantt_broadway.css')}}">-->
    <link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/GanttChart/sources/skins/dhtmlxgantt_terrace.css')}}">
@stop

@section('content')
    <div class="row">
        <div class="space-14"></div>
        <fieldset>
            <legend>{{ trans('projects.project') }}</legend>
            <div class="col-xs-12" style="padding: 5px; height: 100%;">
                <div id="GanttArea" style="height: 100%; width: 100%;"></div>
                <div class="clearfixed"></div>
            </div>
        </fieldset>
    </div>
    <div style="width:  100%; height: 500px; overflow: hidden">
        <div id="gantt_here" style='direction:ltr; width:100%; height:100%;'></div>
    </div>

@stop

@section('specific_plugin_scripts')
    <script type="text/javascript" src="{{URL::to('assets/Packages/GanttChart/sources/dhtmlxgantt.js')}}"></script>
@stop

@section('inline_scripts')

    <script type="text/javascript">
        var tasks;
        var demo_tasks = {
            data: [
                {"id": 1, "text": "Office itinerancy", "type": gantt.config.types.project, "order": "10", progress: 0.4, open: false},

                {"id": 2, "text": "Office facing", "type": gantt.config.types.project, "start_date": "02-04-2013", "duration": "8", "order": "10", progress: 0.6, "parent": "1", open: true},
                {"id": 3, "text": "Furniture installation", "type": gantt.config.types.project, "start_date": "11-04-2013", "duration": "8", "order": "20", "parent": "1", progress: 0.6, open: true},
                {"id": 4, "text": "The employee relocation", "type": gantt.config.types.project, "start_date": "13-04-2013", "duration": "6", "order": "30", "parent": "1", progress: 0.5, open: true},

                {"id": 25, "text": "Office facing", "type": gantt.config.types.project, "start_date": "02-04-2013", "duration": "8", "order": "10", progress: 0.6, "parent": "1", open: true},
                {"id": 26, "text": "Furniture installation", "type": gantt.config.types.project, "start_date": "11-04-2013", "duration": "8", "order": "20", "parent": "1", progress: 0.6, open: true},
                {"id": 27, "text": "The employee relocation", "type": gantt.config.types.project, "start_date": "13-04-2013", "duration": "6", "order": "30", "parent": "1", progress: 0.5, open: true},

                {"id": 28, "text": "Offffffffffffffffffacing", "type": gantt.config.types.project, "start_date": "02-04-2013", "duration": "8", "order": "10", progress: 0.6, "parent": "1", open: true},
                {"id": 29, "text": "dddddddddddddddddddddon", "type": gantt.config.types.project, "start_date": "11-04-2013", "duration": "8", "order": "20", "parent": "1", progress: 0.6, open: true},
                {"id": 30, "text": "aaaaaaaaaaaaaaaaaaaaaa", "type": gantt.config.types.project, "start_date": "13-04-2013", "duration": "6", "order": "30", "parent": "1", progress: 0.5, open: true},

                {"id": 5, "text": "Interior office", "start_date": "02-04-2013", "duration": "7", "order": "3", "parent": "2", progress: 0.6, open: true},
                {"id": 6, "text": "Air conditioners check", "start_date": "03-04-2013", "duration": "7", "order": "3", "parent": "2", progress: 0.6, open: true},
                {"id": 7, "text": "Workplaces preparation", "start_date": "11-04-2013", "duration": "8", "order": "3", "parent": "3", progress: 0.6, open: true},
                {"id": 8, "text": "Preparing workplaces", "start_date": "14-04-2013", "duration": "5", "order": "3", "parent": "4", progress: 0.5, open: true},
                {"id": 9, "text": "Workplaces importation", "start_date": "14-04-2013", "duration": "4", "order": "3", "parent": "4", progress: 0.5, open: true},
                {"id": 10, "text": "Workplaces exportation", "start_date": "14-04-2013", "duration": "3", "order": "3", "parent": "4", progress: 0.5, open: true},

                {"id": 11, "text": "Product launch", "type": gantt.config.types.project, "order": "5", progress: 0.6, open: true},

                {"id": 12, "text": "Perform Initial testing", "start_date": "03-04-2013", "duration": "5", "order": "3", "parent": "11", progress: 1, open: true},
                {"id": 13, "text": "Development", "type": gantt.config.types.project, "start_date": "02-04-2013", "duration": "7", "order": "3", "parent": "11", progress: 0.5, open: true},
                {"id": 14, "text": "Analysis", "start_date": "02-04-2013", "duration": "6", "order": "3", "parent": "11", progress: 0.8, open: true},
                {"id": 15, "text": "Design", "type": gantt.config.types.project, "start_date": "02-04-2013", "duration": "5", "order": "3", "parent": "11", progress: 0.2, open: false},
                {"id": 16, "text": "Documentation creation", "start_date": "02-04-2013", "duration": "7", "order": "3", "parent": "11", progress: 0, open: true},

                {"id": 17, "text": "Develop System", "start_date": "03-04-2013", "duration": "2", "order": "3", "parent": "13", progress: 1, open: true},

                {"id": 25, "text": "Beta Release", "start_date": "06-04-2013", "order": "3", "type": gantt.config.types.milestone, "parent": "13", progress: 0, open: true},

                {"id": 18, "text": "Integrate System", "start_date": "08-04-2013", "duration": "2", "order": "3", "parent": "13", progress: 0.8, open: true},
                {"id": 19, "text": "Test", "start_date": "10-04-2013", "duration": "4", "order": "3", "parent": "13", progress: 0.2, open: true},
                {"id": 20, "text": "Marketing", "start_date": "10-04-2013", "duration": "4", "order": "3", "parent": "13", progress: 0, open: true},

                {"id": 21, "text": "Design database", "start_date": "03-04-2013", "duration": "4", "order": "3", "parent": "15", progress: 0.5, open: true},
                {"id": 22, "text": "Software design", "start_date": "03-04-2013", "duration": "4", "order": "3", "parent": "15", progress: 0.1, open: true},
                {"id": 23, "text": "Interface setup", "start_date": "03-04-2013", "duration": "5", "order": "3", "parent": "15", progress: 0, open: true},
                {"id": 24, "text": "Release v1.0", "start_date": "15-04-2013", "order": "3", "type": gantt.config.types.milestone, "parent": "11", progress: 0, open: true}
            ],
            links: [
                {id: "1", source: "1", target: "2", type: "1"},

                {id: "2", source: "2", target: "3", type: "0"},
                {id: "3", source: "3", target: "4", type: "0"},
                {id: "4", source: "2", target: "5", type: "2"},
                {id: "5", source: "2", target: "6", type: "2"},
                {id: "6", source: "3", target: "7", type: "2"},
                {id: "7", source: "4", target: "8", type: "2"},
                {id: "8", source: "4", target: "9", type: "2"},
                {id: "9", source: "4", target: "10", type: "2"},

                {id: "10", source: "11", target: "12", type: "1"},
                {id: "11", source: "11", target: "13", type: "1"},
                {id: "12", source: "11", target: "14", type: "1"},
                {id: "13", source: "11", target: "15", type: "1"},
                {id: "14", source: "11", target: "16", type: "1"},

                {id: "15", source: "13", target: "17", type: "1"},
                {id: "16", source: "17", target: "25", type: "0"},
                {id: "23", source: "25", target: "18", type: "0"},
                {id: "17", source: "18", target: "19", type: "0"},
                {id: "18", source: "19", target: "20", type: "0"},
                {id: "19", source: "15", target: "21", type: "2"},
                {id: "20", source: "15", target: "22", type: "2"},
                {id: "21", source: "15", target: "23", type: "2"},
                {id: "22", source: "13", target: "24", type: "0"}
            ]
        };
        $(document).ready(function () {
            var sendInfo = {
                tid: 1
            };
            $.ajax({
                type: "POST",
                url: '{{ route('hamahang.project.get_gantt_data') }}',
                //dataType: "json",
                data: sendInfo,
                success: function (data) {
                    tasks = data;
                    gantt.init("gantt_here");
                    //modSampleHeight();
                    console.log(demo_tasks);
                    console.log(JSON.parse(data));
                    gantt.parse(JSON.parse(data));
                }
            });
        });
    </script>
@stop

@include('sections.tabs')
@section('position_right_col_3')
    @include('sections.desktop_menu')
@stop