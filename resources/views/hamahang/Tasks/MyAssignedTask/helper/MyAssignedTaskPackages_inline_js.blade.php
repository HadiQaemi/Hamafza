<script>
    var current_utpid;
    var current_package = '';
    var selectedrow = [];
    var current_statement = 1;
    t2_default = '';
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
                        package_tasks += '<li>' + data[i]['title'] + '<span class="pull-left"><i class="fa fa-remove cursor-pointer" onclick="RemoveFromPackage(' + data[i]['package_id'] + ',' +
                            data[i]['utpid'] + ')' +
                            '"></i></span></li>';
                    }
                    package_tasks += '</ul>';
                    $('#package' + current_package).html(package_tasks);
                }
            });
        }
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
    function select_task_modal(id) {
        current_package = id;
        $('#select_tasks').modal({show: true});
    }
    function new_package() {
        $('#new_package').modal({show: true});
    }
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

                    if (data.success == true) {

                        setTimeout(function () {
                            location.reload();
                        }, 1000)
                    }
                    else {
                        messageModal('error', '{{trans('app.operation_is_failed')}}', data.error);
                    }

                }
            });
        }

    }
    function ModifyPackage(id, title) {
        current_package = id
        $('#current_package_name').html(title);
        $('#modify_package').modal({show: true});

    }

    $(document).ready(function () {
        refresh_data(current_statement);
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
                    if (data.success == true) {

                        setTimeout(function () {
                            location.reload();
                        }, 1000)
                    }
                    else {
                        messageModal('error', '{{trans('app.operation_is_failed')}}', data.error);
                    }
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
    });
</script>