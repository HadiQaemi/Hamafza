<script type="text/javascript">
    {{--$('#select-user').ajaxChosen({
        dataType: 'json',
        type: 'POST',
        url: "{{ route('autocomplete') }}"
    });--}}


    $('#modify_chart_info').on('click',function () {

        $('#modify_chart_info_modal').modal({show: true});
    });
    $('#add_root_item').on('click',function () {
        $('#add_root_item_modal').modal({show: true});
    });
    function modify_chart_info() {
        var sendInfo = {
            cid: $('#edit_ChartID').val(),
            nTitle: $('#edit_chart_title').val(),
            nDesc: $('#edit_chart_description').val()

        };
        $.ajax({
            type: "POST",
            url: '{{ URL::route('hamahang.org_chart.modify_chart_info') }}',
            dataType: "json",
            data: sendInfo,
            success: function (data)
            {
                console.log(data);
                if(data == 'ok')
                {
                    $('#ChartTitle').html(sendInfo.nTitle);
                }
                $('#modify_chart_info_modal').modal('hide');
            }
        });
    }
    function create_new_root_item() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{URL::route('hamahang.org_chart.add_root_chart_item',['username'=>$UName,'ChartID'=>$Chart->org_organs_id])}}',
            data:$("#form_add_root_item").serialize(),
            dataType: "json",
            success: function (result)
            {
                $('#add_new_root_chart_item_form_error').empty();
                if(result.success == true)
                {
                    $('#form_add_root_item').trigger("reset");
                    $('#add_root_item_modal').modal('hide');
                    setTimeout(function () {
                        $('#chart-container').empty();
                        load_orgchart();
                    }, 750);
                }
                else
                {
                    var ul = document.createElement('ul');
                    var target = result.error;
                    for (var k in target)
                    {
                        if (target.hasOwnProperty(k))
                        {
                            var li = document.createElement('li');
                            li.append(target[k]);
                            ul.appendChild(li);
                            console.log(li);
                        }
                    }
                    $('#add_new_root_chart_item_form_error').append(ul);
                }
            }
        });
    }
    function add_post_user(char) {
        $("#onclick-menu-content").css("display", "none");
        var sendInfo = {
            user_id: $('#select-user').val(),
            post_id: current_post_id
        };
        $.ajax({
            type: "POST",
            url: '{{URL::route('hamahang.org_chart.add_post_user')}}',
            dataType: "json",
            data: sendInfo,
            success: function (result) {
                if (result.length > 0) {
                    //$('#tbl_posts').empty();
                    var post = '<table id="tbl_posts" class="table table-striped col-md-12" style="padding-bottom: 20px">';
                    post += '<thead>\
                                    <tr>\
                                    <th>عنوان پست</th>\
                                    <th style="text-align: center">کارمند</th>\
                                    <th style="text-align: center">عملیات</th>\
                                    </tr>\
                                </thead>\
                            <tbody>';
                    for (i = 0; i < result.length; i++) {
                        post += '<tr><td>' + result[i]['title'] + '</td>';
                        if (result[i]['user_id'] != 'no') {
                            post += '<td style="text-align: center"><span style="min-width: 90px"> ' + result[i]['user_info']['Name'] +' '+result[i]['user_info']['Family'] + '</span>';
                            post += '<img src="/assets/images/employee.jpg" width="20px" height="20px" style="margin-right: 25px"/></td>';
                            post += '<td style="text-align: center"><a style="margin-right: 10px" onclick="assign_employee(' + result[i]['id'] + ')"><i class="">ویرایش</i>|';
                            post += '<a style="margin-right: 10px" onclick="remove_employee(' + result[i]['id'] + ')"><i style="color: red" class="">حذف</i></td></tr>';
                        }
                        else {
                            post += '<td style="text-align: center;color: #e00;font-size: 10px">کارمندی برای این پست تعیین نشده است</td>';
                            post += '<td style="text-align: center"><a onclick="assign_employee(' + result[i]['id'] + ')"><i class= >افزودن</i></td></tr>';
                        }
                    }
                    post += '</tbody></table>';
                }
                $('#item_posts').html(post);
                $('#tbl_posts').DataTable({
                    "dom": window.CommonDom_DataTables,
                    columnDefs: [
                        {orderable: false, targets: -1},
                        {orderable: false, targets: 1}
                    ],
                    bRetrieve: true
                });
            }
        });
    }

    function hide_menu() {
        $("#onclick-menu-content").css("display", "none");
    }

    function new_sub_org_unit() {
        $('#new_sub_org_modal').modal({show: true});
    }

    var xx;
    var yy;
    var current_id;
    var current_post_id;
    $(document).mousemove(function (e) {
        xx = e.pageX;
        yy = e.pageY;
    });
    function create_new_node() {
        $.ajax({
            type: "POST",
            url: '{{URL::route('hamahang.org_chart.add_new_node')}}',
            data:$("#add_new_chart_item_form").serialize(),
            dataType: "json",
            success: function (result)
            {
                $('#add_new_chart_item_form_error').empty();
                if(result.success == true)
                {
                    $('#add_new_chart_item_form').trigger("reset");
                    $('#item_details').modal('hide');
                    setTimeout(function () {
                        get_item_info(result.item_id);
                        $('#item_details').modal({show: true});
                        $('#chart-container').empty();
                        $('.nav-tabs a[href="#t5"]').tab('show');
                        load_orgchart();
                    }, 750);
                }
                else
                {
                    var ul = document.createElement('ul');
                    var target = result.error;
                    for (var k in target)
                    {
                        if (target.hasOwnProperty(k))
                        {
                            var li = document.createElement('li');
                            li.append(target[k]);
                            ul.appendChild(li);
                            console.log(li);
                        }
                    }
                    $('#add_new_chart_item_form_error').append(ul);
                }
            }
        });
    }

    function OpenModal_ItemInfo(id)
    {
        current_id = id;
        get_item_info(id);
        $('#item_details').modal({show: true});
        //$(this).siblings('.second-menu').toggle();
    }

    {{-- function OrgChart()
    {
        var datascource = '{{URL::route('ugc.desktop.hamahang.org_chart.ajax_org_chart_data',['username'=>$UName,'id'=>$chart_id])}}';
        $('#chart-container').orgchart({
            'data': datascource,
            //'depth': 90,
            'nodeContent': 'title',
            'pan': true,
            'zoom': true,
            'draggable': true,
             //'direction': 'r2l',

            'nodeID': 'id',
            'createNode': function ($node, data) {
                console.log(JSON.parse(data));
               // data2=JSON.parse(data);
                //console.log(data2.id);
                var secondMenuIcon = '<div>\n\
                      <i onclick="RemoveChartItem(' + data.id + ')" class="cursor-pointer fa fa-remove text-danger"></i>\n\
                      <i onclick="OpenModal_ItemInfo(' + data.id + ')" class="cursor-pointer fa fa-info-circle text-info"></i>\n\
                      <a href="{!! route('modals.show_edit_data_organ',['username'=>auth()->user()->Uname]) !!}"  class="jsPanels cursor-pointer fa fa-info-circle text-info"></a>\n\
                    </div>';
                var secondMenu = '';
                $node.append(secondMenuIcon).append(secondMenu);
            },
            'dropCriteria': function ($draggedNode, $dragZone, $dropZone) {
                if ($draggedNode.find('.content').text().indexOf('manager') > -1 && $dropZone.find('.content').text().indexOf('engineer') > -1) {
                    return false;
                }
                return true;
            }
        }).children('.orgchart').on('nodedropped.orgchart',
                function (event) {
                    var draggedNode = event.draggedNode.attr("id");
                    var dragZone = event.dragZone.attr("id");
                    var dropZone = event.dropZone.attr("id");
                    SubmitChange(draggedNode, dropZone, dragZone);
                });
    }
    OrgChart();--}}
    function load_orgchart()
    {
        $('#chart-container').html('');
        $.post('{{URL::route('hamahang.org_chart.ajax_org_chart_data_show')}}',{'id':'<?php echo $Chart->id?>'},function(data){
            $('#chart-container').orgchart({
                    'data' :data[0],
                    'depth': 9,
                    'pan': true,
                    'zoom': true,
                    'nodeContent':'title',
                    'nodeTitle': 'name',
                'createNode': function ($node, data) {
                    var secondMenuIcon = '<div>\n\
                            <i onclick="RemoveChartItem(' + data.id + ')" class="cursor-pointer fa fa-remove text-danger"></i>\n\
                            <a href="{!! route('modals.show_edit_data_organ') !!}?item_id='+data.id+'"  class="jsPanels cursor-pointer fa fa-info-circle text-info"></a>\n\
                        </div>';
                    var secondMenu = '';
                    $node.append(secondMenuIcon).append(secondMenu);
                }
            });
        });
    }
    load_orgchart();
    function RemoveChartItem(id,pid) {
        var sendInfo = {
            item_id: id
        };
        var P_ID = pid;
        $.ajax({
            type: "POST",
            url: '{{URL::route('hamahang.org_chart.remove_chart_item')}}',
            dataType: "json",
            data: sendInfo,
            success: function (result) {
                if($("#one").length>0)
                {
                    $('#item_details').modal({show: false});
                    get_item_info(P_ID);
                    $('#item_details').modal({show: true});
                }
                $('#chart-container').empty();
                load_orgchart();
            },
            error: function (result) {
                alert("خطایی روی داده است.");
            }
        });
    }
{{--
    function SubmitChange(draggedNode, dropZone, dragZone)
    {
        $.ajax({
            type: 'post',
            url: '{{URL::route('hamahang.org_chart.submit_change')}}',
            data: {draggedNode: draggedNode, dropZone: dropZone, dragZone: dragZone},
            success: function (result) {
                console.log(result);
            }
        });
    }
    function get_item_info(id)
    {
        var sendInfo = {
            id: id
        };
        $.ajax({
            type: 'post',
            url: '{{URL::route('hamahang.org_chart.item_info')}}',
            data: sendInfo,
            success: function (result) {
                //console.log(result);
                if (result[0].length > 0) {
                    var post = '<table id="tbl_posts" class="table table-striped col-md-12" style="padding-bottom: 20px">';
                    post += '<thead>\
                            <tr>\
                            <th>عنوان پست</th>\
                            <th style="text-align: center">کارمند</th>\
                            <th style="text-align: center">عملیات</th>\
                    </tr>\
                    </thead>\
                    <tbody>';
                    for (i = 0; i < result[0].length; i++) {
                        post += '<tr><td>' + result[0][i]['title'] + '</td>';
                        if (result[0][i]['user_id'] != 'no') {
                            post += '<td style="text-align: center"><span style="min-width: 90px"> ' + result[0][i]['user_info']['Name'] +' '+ result[0][i]['user_info']['Family']+ '</span>';
                            post += '<img src="/assets/images/employee.jpg" width="20px" height="20px" style="margin-right: 25px"/></td>';
                            post += '<td style="text-align: center"><a style="margin-right: 10px" onclick="assign_employee(' + result[0][i]['id'] + ')"><i class="">ویرایش</i>|';
                            post += '<a style="margin-right: 10px" onclick="remove_employee(' + result[0][i]['id'] + ')"><i style="color: red" class="">حذف</i></td></tr>';
                        }
                        else {
                            post += '<td style="text-align: center;color: #e00;font-size: 10px">کارمندی برای این پست تعیین نشده است</td>';
                            post += '<td style="text-align: center"><a onclick="assign_employee(' + result[0][i]['id'] + ')"><i class="" >افزودن</i></td></tr>';
                        }
                    }
                    post += '</tbody></table>';
                }
                else {
                    post = '<h4>هیچ سمتی برای این واحد سازمانی تعریف نشده است</h4>';
                }
                var info = '';
                info += '<span style="float: right;margin-right: 20px;"><h6>نام سازمان : ' + result[1]['org_title'] + '</h6></span>';
                info += '<span style="float: right;margin-right: 20px"><h6>نام چارت : ' + result[1]['chart_title'] + '</h6></span>';
                if (result[1]['parent_id'] != 0)
                    info += '<span style="float: right;margin-right: 20px"><h6>نام واحد سازمانی بالادستی : ' + result[1]['parent_title'] + '</h6></span>';
                else
                    info += '<span style="float: right;margin-right: 20px"><h6 style="color: red">واحد سازمانی ' +
                            '</h6></span>';
                info += '<span style="float: right;margin-right: 20px"><h6>تعداد کل پست ها : ' + result[1]['post_count'] + '</h6></span>';
                info += '<span style="float: right;margin-right: 20px"><h6>تعداد پست های خالی : ' + result[1]['free_post_count'] + '</h6></span>';
                $('#item_posts').html(post);
                $('#current_item_info').html(info);
                var parent_link = '';
                if (result[1]['parent_id'] != 0) {
                    parent_link = '<a class="btn btn-info" onclick="change_item(' + result[1]['parent_id'] + ')">' + result[1]['parent_title'] + '</a>';
                    $('#item_parent').html(parent_link);
                }

                if (result[1]['item_items'].length > 0) {
                    var items = '';
                    for (i = 0; i < result[1]['item_items'].length; i++) {
                        items += '<a class="btn btn-info" onclick="change_item(' + result[1]['item_items'][i]['id'] + ')" style="margin-right: 15px">' + result[1]['item_items'][i]['title'] + '****' + result[1]['item_items'][i]['item_childs_count'] + '</a>';
                    }
                    items += '';
                }
                else {
                    items = '<h4>زیر شاخه ای برای این واحد سازمانی یافت نشد</h4>';
                }
                $('#item_items').html(items);
                $('#tbl_posts').DataTable({
                    "dom": window.CommonDom_DataTables,
                    columnDefs: [
                        {orderable: false, targets: -1},
                        {orderable: false, targets: 1}
                    ]
                });

                var url = "{{URL::route('hamahang.org_chart.get_item_children')}}"
                RefreshChilds(id);
                $('#add_new_chart_item_post_form').trigger("reset");

                $('#chart_item_select_parents').chosen('destroy');

                $("#modal_header_item_title").text(result[1]['item_title']);
                $("#edit_chart_item_form #form_edit_item_item_id").val(result[1]['item_id']);
                $("#add_new_chart_item_post_form #form_add_post_for_item_id").val(result[1]['item_id']);
                $("#add_new_chart_item_form #form_add_chart_id").val(result[1]['chart_id']);
                $("#add_new_chart_item_form #form_add_item_id").val(result[1]['item_id']);
                $("#edit_chart_item_form #item_title").val(result[1]['item_title']);
                $("#edit_chart_item_form #item_description").val(result[1]['item_description']);
                $("#edit_chart_item_form #default_parent_item").val(result[1]['parent_id']);
                $("#edit_chart_item_form #default_parent_item").text(result[1]['parent_title']);
                $('#chart_item_select_parents').ajaxChosen({
                    dataType: 'json',
                    type: 'POST',
                    url: "{{ route('auto_complete.chart_items') }}"
                });
                //                    console.log(result);
                //                    edit_chart_item_form
                //                    default_parent_item
                //                    item_title
                //                    item_description
            },
            error: function () {
                alert('err');
            }
        });
    }
    function RefreshChilds(id) {
        var url = "{{ route('hamahang.org_chart.get_item_children') }}";
        window.ItemChildrenGrid.destroy();
        //window.table_chart_grid2 = $('#draft_files_grid2').DataTable();
        setTimeout(function () {
            window.ItemChildrenGrid = $('#ItemChildrenGrid').DataTable({
                "dom": window.CommonDom_DataTables,
                "ajax": {
                    "url": url,
                    "type": "POST",
                    "data": { 'id': id}
                },
                "autoWidth": false,
                "language": window.LangJson_DataTables,
                "processing": true,
                "serverside": true,
                columns: [
                    {"data": "id"},
                    {"data": "title"},
                    {"data": "description"},
                    {"data": "created_at"},
                    {"data": "updated_at"}
                ]
            });
        }, 100);
    }
    function RemoveChartItem(id,pid) {
        var sendInfo = {
            item_id: id
        };
        var P_ID = pid;
        $.ajax({
            type: "POST",
            url: '{{URL::route('hamahang.org_chart.remove_chart_item')}}',
            dataType: "json",
            data: sendInfo,
            success: function (result) {
                if($("#one").length>0)
                {
                    $('#item_details').modal({show: false});
                    get_item_info(P_ID);
                    $('#item_details').modal({show: true});
                }
                $('#chart-container').empty();
                OrgChart();
            },
            error: function (result) {
                alert("خطایی روی داده است.");
            }
        });
    }

    function change_item(id) {
        $('#item_details').modal('hide');
        setTimeout(function () {
            get_item_info(id);
            $('#item_details').modal({show: true});
        }, 750);
    }

    function remove_employee(id) {
        var sendInfo = {
            post_id: id
        };
        $.ajax({
            type: "POST",
            url: '{{URL::route('hamahang.org_chart.remove_post_user')}}',
            dataType: "json",
            data: sendInfo,
            success: function (result) {
                if (result.length > 0) {
                    // $('#tbl_posts').empty();
                    var post = '<table id="tbl_posts" class="table table-striped col-md-12" style="padding-bottom: 20px">';
                    post += '<thead>\
                            <tr>\
                            <th>عنوان پست</th>\
                            <th style="text-align: center">کارمند</th>\
                            <th style="text-align: center">عملیات</th>\
                    </tr>\
                    </thead>\
                    <tbody>';
                    for (i = 0; i < result.length; i++) {
                        post += '<tr><td>' + result[i]['title'] + '</td>';
                        if (result[i]['user_id'] != 'no') {
                            post += '<td style="text-align: center"><span style="min-width: 90px"> ' + result[i]['user_info']['name'] + '</span>';
                            post += '<img src="/assets/images/employee.jpg" width="20px" height="20px" style="margin-right: 25px"/></td>';
                            post += '<td style="text-align: center"><a style="margin-right: 10px" onclick="assign_employee(' + result[i]['id'] + ')"><i class="">ویراش</i>|';
                            post += '<a style="margin-right: 10px" onclick="remove_employee(' + result[i]['id'] + ')"><i style="color: red" class="">حذف</i></td></tr>';
                        }
                        else {
                            post += '<td style="text-align: center;color: #e00;font-size: 10px">کارمندی برای این پست تعیین نشده است</td>';
                            post += '<td style="text-align: center"><a onclick="assign_employee(' + result[i]['id'] + ')"><i class="" >افزودن</i></td></tr>';
                        }
                    }
                    post += '</tbody></table>';
                }

                $('#item_posts').html(post);
                $('#tbl_posts').DataTable({
                    "dom": window.CommonDom_DataTables,
                    columnDefs: [
                        {orderable: false, targets: -1},
                        {orderable: false, targets: 1}
                    ],
                    bRetrieve: true
                });
            }
        });
    }

    $(document).mousemove(function (e) {
        xx = e.pageX;
        yy = e.pageY;
        //alert(x+"hhhhh"+y);
    });

    function new_post() {
        var sendInfo = {
            item_id: current_id,
            post_title: $('#new_post_title').val()
        };
        $.ajax({
            type: "POST",
            url: '{{URL::route('hamahang.org_chart.add_new_post')}}',
            dataType: "json",
            data: sendInfo,
            success: function (result) {
                //console.log(result);
                if (result.length > 0) {
                    var post = '<table class="table table-striped col-md-12" style="text-align: center"><tr><th style="text-align: center">عنوان پست</th><th style="text-align: center">کارمند</td><th style="text-align: center">عملیات</th><tr>';
                    for (i = 0; i < result.length; i++) {
                        post += '<tr  ><td  style="text-align: center">' + result[i]['title'] + '</td>';
                        //post += '<tr><td>' + result[i]['title'] + '</td>';
                        if (result[i]['user_id'] != 'no') {
                            post += '<td><span style="min-width: 90px"> ' + result[i]['user_info']['name'] + '</span>';
                            post += '<img src="/assets/images/employee.jpg" width="20px" height="20px" style="margin-right: 25px"/></td>';
                            post += '<td><a style="margin-right: 10px" onclick="assign_employee(' + result[i]['id'] + ')"><i class="">ویرایش</i>|';
                            post += '<a style="margin-right: 10px" onclick="remove_employee(' + result[i]['id'] + ')"><i style="color: red" class="">حذف</i></td></tr>';
                        }
                        else {
                            post += '<td style="color: #e00;font-size: 10px">کارمندی برای این پست تعیین نشده است</td>';
                            post += '<td><a onclick="assign_employee(' + result[i]['id'] + ')"><i class="" >افزودن</i></td></tr>';
                        }
                    }
                    post += '</table>';
                }
                $('#add_new_chart_item_post_form').trigger("reset");
                $('.nav-tabs a[href="#t3"]').tab('show');
                $('#item_posts').html(post);
            }
        });
    }

    function assign_employee(id)
    {
        current_post_id = id;
        $('#onclick-menu-content').css('position', 'absolute');
        $('#onclick-menu-content').css('top', yy + 10); //or wherever you want it
        $('#onclick-menu-content').css('left', xx - 100);
        $("#onclick-menu-content").css("display", "block");
    }

    function UpdateChartItem()
    {
        $.ajax({
            type: 'post',
            url: '{{URL::route('hamahang.org_chart.update_chart_item')}}',
            data:$("#edit_chart_item_form").serialize(),
            dataType: "json",
            success: function (result)
            {
                $('#item_details').modal('hide');
                setTimeout(function () {
                    get_item_info(result.item_id);
                    $('#item_details').modal({show: true});
                    $('#chart-container').empty();
                    OrgChart();
                }, 750);
            }
        });
    }
    --}}
</script>