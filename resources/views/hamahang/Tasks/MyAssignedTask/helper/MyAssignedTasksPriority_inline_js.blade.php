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
        search_ajax();
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
        var respite_day_no = $('#filter_respite').val();
        var started_tasks = '';
        if ($('#started_tasks').is(':checked'))
            $started_tasks = 1;
        var not_started_tasks = '';
        if ($('#not_started_tasks').is(':checked'))
            not_started_tasks = 1;
        var done_tasks = '';
        if ($('#done_tasks').is(':checked'))
            done_tasks = 1;
        var completed_tasks = '';
        if ($('#completed_tasks').is(':checked'))
            completed_tasks = 1;
        var stoped_tasks = '';
        if ($('#stoped_tasks').is(':checked'))
            stoped_tasks = 1;
        var search_str = '';
        if ($('#task_title').val() != '')
            search_str = $('#filter_task_title').val();
        if ($('#individual').is(':checked'))
            var individual = 1;
        else
            var individual = 0;
        if ($('#official').is(':checked'))
            var official = 1;
        else
            var official = 0;

        var sendInfo = {
            @if(isset($filter_subject_id))
            subject_id: '{{ $filter_subject_id }}',
            @endif
            str: search_str,
            completed_tasks: completed_tasks,
            done_tasks: done_tasks,
            started_tasks: started_tasks,
            stoped_tasks: stoped_tasks,
            not_started_tasks: not_started_tasks,
            respite_day_no: respite_day_no,
            individual: individual,
            official: official
        };


        var task;
        $.ajax({
            type: "POST",
            url: '{{ URL::route('hamahang.tasks.my_assigned_tasks.CustomTasksPriority') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data) {
                put_data(data['data']);
                draganddrop();
            },
            error: function (data) {
                document.getElementById('type1_tasks').innerHTML = '';
                document.getElementById('type2_tasks').innerHTML = '';
                document.getElementById('type3_tasks').innerHTML = '';
                document.getElementById('type4_tasks').innerHTML = '';
            }

        });
        function put_data(tasks) {
            $('#type1_tasks').empty();
            $('#type2_tasks').empty();
            $('#type3_tasks').empty();
            $('#type4_tasks').empty();
            for (task in tasks) {
                var responser = '<sapn style="color:lightpink;font-size: 11px;margin-right: 8px"><span>مسئول : </span>'+ tasks[task]['full_name'] +'</span>';
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
                    var txt = '<div id="' + tasks[task]['id'] + '" class="draggable col-xs-12 ui-draggable ui-draggable-handle all-scroll2"  >';
                    txt += '<div class="dragable-inner"><div style="position: absolute; right: 5px;"><div class="' + task_class + ' ' + flasher + '">' + tasks[task]['respite_days'] + '</div>';
                    txt += '</div><div><a class="task_title task_info cursor-pointer" data-t_id = "'+tasks[task]['id']+'">' + tasks[task]['title'] +'</a>'+ responser +'</div><div style="position: absolute; left: 7px;" class="state_icon">';
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
                    var txt = '<div id="' + tasks[task]['id'] + '" class="draggable col-xs-12 ui-draggable ui-draggable-handle all-scroll"  >';
                    txt += '<div class="dragable-inner"><div style="position: absolute; right: 5px;"><div class="' + task_class + ' ' + flasher + '">' + tasks[task]['respite_days'] + '</div>';
                    txt += '</div><div><a class="task_title task_info cursor-pointer" data-t_id = "'+tasks[task]['id']+'">' + tasks[task]['title'] +'</a>'+ responser + '</div><div style="position: absolute; left: 7px;" class="state_icon">';
                    txt += '<i class="' + ico + '"></i></div></div></div>';
                    document.getElementById('type2_tasks').innerHTML += txt;
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
                    var txt = '<div id="' + tasks[task]['id'] + '" class="draggable col-xs-12 ui-draggable ui-draggable-handle all-scroll"  >';
                    txt += '<div class="dragable-inner"><div style="position: absolute; right: 5px;"><div class="' + task_class + ' ' + flasher + '">' + tasks[task]['respite_days'] + '</div>';
                    txt += '</div><div><a class="task_title task_info cursor-pointer" data-t_id = "'+tasks[task]['id']+'">' + tasks[task]['title'] +'</a>'+ responser +'</div><div style="position: absolute; left: 7px;" class="state_icon">';
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
                    var txt = '<div id="' + tasks[task]['id'] + '" class="draggable col-xs-12 ui-draggable ui-draggable-handle all-scroll"  >';
                    txt += '<div class="dragable-inner"><div style="position: absolute; right: 5px;"><div class="' + task_class + ' ' + flasher + '">' + tasks[task]['respite_days'] + '</div>';
                    txt += '</div><div><a class="task_title task_info cursor-pointer" data-t_id = "'+tasks[task]['id']+'">' + tasks[task]['title'] +'</a>'+ responser +'</div><div style="position: absolute; left: 7px;" class="state_icon">';
                    txt += '<i class="' + ico + '"></i></div></div></div>';

                    document.getElementById('type4_tasks').innerHTML += txt;


                };
                draganddrop();

            }
        }

    }
</script>
<script>
    $('#filter_respite').keyup(function () {

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
    $('#done_tasks').click(function () {
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
    $("#filter_task_title").keyup(
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
            $(this).css({position: 'absolute'});


        });
        $(".draggable").mouseup(function () {
            $(this).css({position: 'relative'});
        });
        $(".draggable").draggable({cursor: "all-scroll", revert: "invalid"});
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
                    data: sendInfo ,
                    success: function () {
                        search_ajax();
                    }
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
    };
</script>
<script>
    var from = '';
    var to = '';
    var tid = '';
    $(".draggable").mousedown(function () {
        $(this).css({position: 'absolute'});
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