<style>
    .gantt_default_matrix div{
        /*position: initial !important;*/
    }
    .gantt_default_corner{
        visibility: hidden;
    }
</style>
<div style="padding-top: 70px">
    <script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/daypilot-all.min.js"></script>
    <div class="shadow"></div>
    <div class="hideSkipLink">
    </div>
    <div class="main">

        <div class="space"></div>

        <div id="dp"></div>

        <script type="text/javascript">

            var dp = new DayPilot.Gantt("dp");
            dp.startDate = new DayPilot.Date("1397-01-01");
            dp.days = 365;

            dp.linkBottomMargin = 5;

            dp.rowCreateHandling = 'Enabled';

            dp.columns = [
                { title: "Name", property: "text", width: 100},
                { title: "Duration", width: 100}
            ];

            dp.onBeforeRowHeaderRender = function(args) {
                $(".gantt_default_corner").css('visibility', 'hidden');
                args.row.columns[1].html = new DayPilot.Duration(args.task.end().getTime() - args.task.start().getTime()).toString("d") + " days";
                args.row.areas = [
                    {
                        right: 3,
                        top: 3,
                        width: 16,
                        height: 16,
                        style: "cursor: pointer; box-sizing: border-box; background: white; border: 1px solid #ccc; background-repeat: no-repeat; background-position: center center; background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAABASURBVChTYxg4wAjE0kC8AoiFQAJYwFcgjocwGRiMgPgdEP9HwyBFDkCMAtAVY1UEAzDFeBXBAEgxQUWUAgYGAEurD5Y3/iOAAAAAAElFTkSuQmCC);",
                        action: "ContextMenu",
                        menu: taskMenu,
                        v: "Hover"
                    }
                ];
            };

            // dp.contextMenuLink = new DayPilot.Menu([
            //     {
            //         text: "Delete",
            //         onclick: function() {
            //             var link = this.source;
            //             $.post("backend_link_delete.php", {
            //                     id: link.id()
            //                 },
            //                 function(data) {
            //                     loadLinks();
            //                 });
            //         }
            //     }
            // ]);
            //
            // dp.onRowCreate = function(args) {
            //     $.post("backend_create.php", {
            //             name: args.text,
            //             start: dp.startDate.toString(),
            //             end: dp.startDate.addDays(1).toString()
            //         },
            //         function(data) {
            //             loadTasks();
            //         });
            // };

            // dp.onTaskMove = function(args) {
            //     $.post("backend_move.php", {
            //             id: args.task.id(),
            //             start: args.newStart.toString(),
            //             end: args.newEnd.toString()
            //         },
            //         function(data) {
            //             dp.message("Updated");
            //         });
            // };

            // dp.onTaskResize = function(args) {
            //     $.post("backend_move.php", {
            //             id: args.task.id(),
            //             start: args.newStart.toString(),
            //             end: args.newEnd.toString()
            //         },
            //         function(data) {
            //             dp.message("Updated");
            //         });
            // };


            // dp.onRowMove = function(args) {
            //     $.post("backend_row_move.php", {
            //             source: args.source.id,
            //             target: args.target.id,
            //             position: args.position
            //         },
            //         function(data) {
            //             dp.message("Updated");
            //         });
            // };

            // dp.onLinkCreate = function(args) {
            //     $.post("backend_link_create.php", {
            //             from: args.from,
            //             to: args.to,
            //             type: args.type
            //         },
            //         function(data) {
            //             loadLinks();
            //         });
            // };

            // dp.onTaskClick = function(args) {
            //     var modal = new DayPilot.Modal();
            //     modal.closed = function() {
            //         loadTasks();
            //     };
            //     modal.showUrl("edit.php?id=" + args.task.id());
            // };

            dp.init();

            loadTasks();
            // loadLinks();

            function loadTasks() {
                $.post("{{ URL::route('hamahang.project.project_fetch_gantt_tasks') }}",{pid:"{{Request::input('pid')}}"}, function(data) {
                    dp.tasks.list = JSON.parse(data);
                    dp.update();
                    $("div.gantt_default_matrix > div").removeAttr("style");
                    $(".gantt_default_corner").html($(".gantt_default_corner").html().replace('DEMO',''));
                });
            }

            {{--function loadLinks() {--}}
                {{--$.post("http://localhost:8080/gantt/TutorialHtml5GanttChart/backend_links.php", function(data) {--}}
                    {{--dp.links.list = data;--}}
                    {{--dp.update();--}}
                {{--});--}}
            {{--}--}}
            {{--function loadTasks() {--}}
                {{--$.post("{{ URL::route('hamahang.project.project_fetch_gantt_tasks') }}",{pid:"{{Request::input('pid')}}"}, function(data) {--}}
                {{--//     dp.tasks.list = JSON.parse('[{"id":"1","text":"Task 1","start":"1396-01-14","end":"1396-01-04","complete":"0"},{"id":"6","text":"Milestone 1","start":"1396-01-21","end":"1396-01-21","complete":"0","type":"Milestone"},{"id":"9","text":"Sub-Task 2.2","start":"1396-01-05","end":"1396-01-08","complete":"100"},{"id":"7","text":"Task 2","start":"1396-01-14","end":"1396-01-17","complete":"0"},{"id":"8","text":"Sub-Task 2.1","start":"1396-01-19","end":"1396-01-24","complete":"50"},{"id":"5","text":"Sub-Task 3.1","start":"1396-01-18","end":"1396-02-09","complete":"50"},{"id":"10","text":"asdasd","start":"1396-01-10","end":"1396-01-22","complete":"40"},{"id":"3","text":"Task 3 30","start":"1396-07-06","end":"1396-09-24","complete":"0"},{"id":"11","text":"654654","start":"1396-01-01","end":"1396-02-03","complete":"40"},{"id":"12","text":"ss","start":"1396-12-21","end":"1396-12-22","complete":"0","type":"Milestone"}]');--}}
                    {{--dp.tasks.list = JSON.parse('[{"id":219,"text":"asdasdasd","start":"1397-11-02","end":"1397-11-02","complete":null},{"id":220,"text":"\u062a\u0633\u062a \u0648\u0637\u0627\u06cc\u0641","start":"1397-11-03","end":"1397-12-30","complete":0},{"id":222,"text":"\u062a\u0633\u062a \u0648\u0638\u06cc\u0641\u0647 \u0639\u0646\u0648\u0627\u0646","start":"1397-11-03","end":"1397-11-03","complete":null},{"id":223,"text":"\u062a\u0633\u062a \u0632\u0645\u0627\u0646","start":"1397-11-03","end":"1397-12-02","complete":null}]');--}}
                    {{--dp.update();--}}
                {{--// });--}}
            {{--}--}}

            function loadLinks() {
                // $.post("http://localhost:8080/gantt/TutorialHtml5GanttChart/backend_links.php", function(data) {
                dp.links.list = JSON.parse('[{"id":"6","from":"1","to":"3","type":"FinishToStart"},{"id":"7","from":"1","to":"7","type":"FinishToStart"},{"id":"28","from":"10","to":"11","type":"FinishToStart"},{"id":"35","from":"9","to":"7","type":"FinishToStart"},{"id":"36","from":"3","to":"11","type":"FinishToFinish"}]');
                dp.update();
                // });
            }

            var taskMenu = new DayPilot.Menu({
                items: [
                    {
                        text: "Delete",
                        onclick: function() {
                            var task = this.source;
                            $.post("backend_task_delete.php", {
                                    id: task.id()
                                },
                                function(data) {
                                    loadTasks();
                                });
                        }
                    }
                ]
            });

        </script>

    </div>
    <div class="clear">
    </div>
</div>