@section('Tree')

    @yield('CustomRightMenu')
    @yield('CustomRightMenu1')


    @if ($Tree!='')

        <div class="panel-body searching-cntnt">

            <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
                <div class="txtsearch">
                    <input type="text" placeholder="غربال..." id="list-search"/>
                </div>
                <div accordion="" class="panel-group accordion" id="accordion">
                    <div id="Fehresrt" class="v"></div>
                </div>
            </div>
            <style type="text/css">
                .jstree li > a > .jstree-icon {
                    display: none !important;
                }
            </style>
            <script>

                $('#Fehresrts').jstree({
                    "plugins": ["themes", "html_data", "ui", "crrm", "contextmenu", "wholerow", "checkbox", "search","sort"],
                    'core': {
                        'dataType': 'json',
                        'data': {
                            "url": '{{ URL::route('hamahang.Menus.get_menu_nodes')}}',
                            type: 'POST',
                            "data": function (node) {
                                return {"id": node.id,"_token":$("#_Alltoken").val()};
                            }
                        },
                        'check_callback': true
                    }
                });
                $('#Fehresrts').on('click', 'li a', function () {
                    window.location = $(this).attr('href');
                });
                $(function () {
                    $("#Fehresrt").jstree({
                        "plugins": ["search"]
                    });
                    var to = false;
                    $('#list-search').keyup(function () {
                        if (to) {
                            clearTimeout(to);
                        }
                        to = setTimeout(function () {
                            var v = $('#list-search').val();
                            $('#Fehresrt').jstree(true).search(v);
                        }, 250);
                    });
                });
                $('#Fehresrt').jstree({
                    "plugins": ["search","sort"],
                    'core': {
                        'data': {
                            "url": '{{ URL::route('hamahang.Menus.get_menu_nodes')}}',
                            type: 'POST',
                            "data": function (node) {
                                return {"id": node.id};
                            }
                        },
                        /*'data': [
                            {"id": "1", "parent": "#", "text": "وظایف"},
//        {"id": "10", "parent": "1", "text": "<i class='fa fa-plus'></i>  ایجاد وظیفه جدید", "a_attr": {'href': '{{route('ugc.desktop.hamahang.Task.Create',['username'=>$uname])}}'}},
                            {"id": "43", "parent": "1", "text": "<i class='fa fa-pencil-square-o'></i>  مشاهده پیش نویس ها", "a_attr": {'href': '{{route('ugc.desktop.hamahang.tasks.my_assigned_tasks.show_drafts',['username'=>$uname])}}'}},
                            {"id": "2", "parent": "1", "text": "ارجاعات من"},
                            {"id": "3", "parent": "1", "text": "وظایف من"},
                            {"id": "4", "parent": "2", "text": "لیست وظایف", "a_attr": {'href': '{{route('ugc.desktop.hamahang.tasks.my_assigned_tasks.list',['username'=>$uname])}}'}},
                            {"id": "5", "parent": "2", "text": "اولویت وظایف", "a_attr": {'href': '{{route('ugc.desktop.hamahang.tasks.my_assigned_tasks.priority',['username'=>$uname])}}'}},
                            {"id": "6", "parent": "2", "text": "وضعیت وظایف", "a_attr": {'href': '{{route('ugc.desktop.hamahang.tasks.my_assigned_tasks.state',['username'=>$uname])}}'}},
                            {"id": "7", "parent": "3", "text": "لیست وظایف", "a_attr": {'href': '{{route('ugc.desktop.hamahang.tasks.my_tasks.list',['username'=>$uname])}}'}},
                            {"id": "8", "parent": "3", "text": "اولویت وظایف", "a_attr": {'href': '{{route('ugc.desktop.hamahang.tasks.my_tasks.priority',['username'=>$uname])}}'}},
                            {"id": "9", "parent": "3", "text": "وضعیت وظایف", "a_attr": {'href': '{{route('ugc.desktop.hamahang.tasks.my_tasks.state',['username'=>$uname])}}'}},
                            {"id": "11", "parent": "#", "text": "بسته های کاری"},
                            {"id": "12", "parent": "11", "text": "ارجاعات من", "a_attr": {'href': '{{route('ugc.desktop.hamahang.tasks.my_assigned_tasks.package',['username'=>$uname])}}'}},
                            {"id": "13", "parent": "11", "text": "وظایف من", "a_attr": {'href': '{{route('ugc.desktop.hamahang.tasks.my_tasks.package',['username'=>$uname])}}'}},
                            {"id": "14", "parent": "11", "text": "تمام وظایف", "a_attr": {'href': '{{route('ugc.desktop.hamahang.tasks.Packages',['username'=>$uname])}}'}},
                            {"id": "20", "parent": "#", "text": "سازمان ها"},
                            {"id": "21", "parent": "20", "text": "مدیریت سازمان ها", "a_attr": {'href': '{{route('ugc.desktop.hamahang.org_chart.OrgOrgans.list',['username'=>$uname])}}'}},
                            {"id": "30", "parent": "#", "text": "تقویم"},
                            {"id": "31", "parent": "30", "text": "مدیریت تقویم ها", "a_attr": {'href': '{{route('ugc.desktop.hamahang.calendar.index',['username'=>$uname])}}'}},
                            {"id": "32", "parent": "30", "text": "رویدادها", "a_attr": {'href': '{{route('ugc.desktop.hamahang.calendar_events.events',['username'=>$uname])}}'}},
                            {"id": "33", "parent": "30", "text": "جلسات", "a_attr": {'href': '{{route('ugc.desktop.hamahang.calendar_events.sessions',['username'=>$uname])}}'}},
                            {"id": "34", "parent": "30", "text": "دعوتنامه ها", "a_attr": {'href': '{{route('ugc.desktop.hamahang.calendar_events.invitations',['username'=>$uname])}}'}},
                            {"id": "40", "parent": "#", "text": "پروژه ها"},
                            {"id": "41", "parent": "40", "text": "ایجاد پروژه ", "a_attr": {'href': '{{route('project',['username'=>$uname])}}'}},
                            {"id": "42", "parent": "40", "text": "لیست پروژه ها", "a_attr": {'href': '{{route('ugc.desktop.hamahang.project.list',['username'=>$uname])}}'}},
                            {!!$Tree!!}
                        ]*/
//                [
//                {!!$Tree!!}
                        //                ],
                        'rtl': true,
                        "themes": {
                            "icons": false
                        }
                    }
                });
                $("#Fehresrt").bind('select_node.jstree',
                        function (e, data) {
                            var id = data.node.id;
                            var n = id.indexOf("#");
//    domain = "{{App::make('url')->to('/')}}//desktop/" + id;
                            if (data.node.a_attr.href != '#') {
                                var n = id.indexOf("#");
                                domain = "{{App::make('url')->to('/')}}/{{$uname}}/desktop/" + id;
                                window.location = domain;
                            }
                            else {

                            }
                        })
                        .on("activate_node.jstree", function (e, data) {
                            if (data.node.a_attr.href != '#') {
                                window.location.href = data.node.a_attr.href;
                                history.pushState("", document.title, window.location.pathname + window.location.search);
                            }
                        });
            </script>

        </div>



    @endif
@stop