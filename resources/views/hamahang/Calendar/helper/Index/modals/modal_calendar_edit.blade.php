<div>
    <div id="edit_form_error"></div>
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#t1" id="pan_t1" data-toggle="tab">
                <i class="fa fa-edit"></i>
                <span>{{trans("calendar.modal_calendar_edit_tab1_title")}}</span>
            </a>
        </li>
        <li>
            <a href="#t2" id="pan_t2" data-toggle="tab">
                <i class="fa fa-edit"></i>
                <span>{{trans("calendar.modal_calendar_edit_tab2_title")}}</span>
            </a>
        </li>
        <li>
            <a href="#t3" id="pan_t3" data-toggle="tab">
                <i class="fa fa-edit"></i>
                <span>{{trans("calendar.modal_calendar_edit_tab3_title")}}</span>
            </a>
        </li>
        <li>
            <a href="#t4" id="pan_t4" data-toggle="tab">
                <i class="fa fa-edit"></i>
                <span>{{trans("calendar.modal_calendar_edit_tab4_title")}}</span>
            </a>
        </li>
        <li >
            <a href="#t5" data-toggle="tab">
                <i class="fa fa-edit"></i>
                <span>{{trans('calendar.modal_calendar_setting_default_event')}}</span>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="t1"  class="tab-pane fade in active">
            <div class="panel panel-info col-md-12">
                <div class="panel-body" id="item_edit">
                    <form id="calendar_info_form">
                        <input type="hidden" id="form_edit_item_item_id" name="item_id" value=""/>
                        <table class="table table-bordered col-md-12">
                            <tbody>
                            <tr>
                                <td class=" col-md-2">
                                    <label>
                                        <span class="required">*</span>
                                        {{trans("calendar.modal_calendar_title_field_label")}}
                                    </label>
                                </td>
                                <td class="col-md-10">
                                    <input name="title" id="item_title" class="form-control" placeholder="">
                                </td>
                            </tr>
                            <tr>
                                <td class=" col-md-2" >
                                    <label>
                                        <span class="require">*</span>
                                        {{trans("calendar.modal_calendar_type_field_label")}}
                                    </label>
                                </td>
                                <td class="col-md-10">
                                    <input name="type" type="radio" id="item_type" value="1">
                                    {{trans("calendar.modal_calendar_type_field_ch1")}}
                                    <input name="type" type="radio" id="item_type" value="2">
                                    {{trans("calendar.modal_calendar_type_field_ch2")}}
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2" >
                                    <label class="form-check-label"> {{trans("calendar.modal_calendar_default_field_label")}}</label>
                                </td>
                                <td class="col-md-10">
                                    <div class="form-check">
                                        {{trans("calendar.modal_calendar_descriotion_field_label")}}
                                        <input name="is_default" type="checkbox" id="is_default" class="form-check-input" value="1"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class=" col-md-2">
                                    <label> {{trans("calendar.modal_calendar_descriotion_field_label")}}</label>
                                </td>
                                <td class="col-md-10">
                                    <textarea name="descriotion" class="form-control" id="item_descriotion"></textarea>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div id="t2" class="tab-pane fade">
            <div class="panel panel-info col-md-12">
                <div class="panel-body" id="item_setting">
                    <form class="form-inline" id="calendar_setting_form">
                        <table  style="overflow: scroll" class="table table-bordered col-md-12">
                            <tbody>
                            <tr>
                                <td class="col-md-12" colspan="2">
                                    <label>
                                        <span class="require">*</span>
                                        {{trans('calendar.modal_calendar_edit_prayer_times_field_label')}}
                                    </label>
                                    <label c>
                                        <input name="prayer_times" type="radio" id="item_prayer_times" class="form-control" value="1">
                                        {{trans('calendar.modal_calendar_edit_prayer_times_radio1_label')}}
                                    </label>
                                    <label>
                                        <input name="prayer_times" type="radio" id="item_prayer_times" class="form-control" value="2" checked>
                                        {{trans('calendar.modal_calendar_edit_prayer_times_radio2_label')}}
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2">
                                    <label>
                                        <span class="require">*</span>
                                        {{trans('calendar.modal_calendar_edit_prayer_times_city_privince')}}
                                    </label>
                                </td>
                                <td class="col-md-10">
                                    <div class="col-xs-4">
                                        <select name="province" class="chosen-rtl" size="120" data-h id="province" data-placeholder="{{ trans('calendar.calendar_select_province') }}">
                                            <option value="0">{{trans('calendar.calendar_select_province')}}</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-1"></div>
                                    <div class="col-xs-3">
                                        <select name="prayer_time_city" class="chosen-rtl" data-placeholder="{{ trans('calendar.calendar_select_city') }}" id="item_prayer_time_city">
                                            <option value="0">{{trans('calendar.calendar_select_city')}}</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2">
                                    <label>
                                        <span class="require">*</span>
                                        {{trans('calendar.modal_calendar_edit_beginning_day_field_label')}}
                                    </label>
                                </td>
                                <td class="col-md-10">
                                    <label>
                                        <input name="beginning_day" type="radio" id="item_beginning_day" class="form-control" value="1">
                                        {{trans('calendar.modal_calendar_edit_beginning_day_radio1_label')}}
                                    </label>
                                    <label>
                                        <input name="beginning_day" type="radio" id="item_beginning_day" checked class="form-control" value="2">
                                        {{trans('calendar.modal_calendar_edit_beginning_day_radio2_label')}}
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2">
                                    <label>
                                        {{trans('calendar.modal_calendar_edit_hiddentime_field_label')}}
                                    </label>
                                </td>
                                <td class=" col-md-10" id="hidentime" colspan="2">
                                    <div id="hiden_holder">
                                        <label> {{trans('calendar.calendar_from')}}</label>
                                        <div class='col-md-4 form-horizontal input-group date'>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                            <input type="text" class="form-control TimePicker" placeholder="{{trans('calendar.calendar_from')}}" name="hidden_from[]" id="hidden_from" aria-describedby="respite_time">
                                        </div>
                                        <label> {{trans('calendar.calendar_to')}}</label>
                                        <div class='col-md-4  form-horizontal input-group date'>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-time"></span>
                                            </span>
                                            <input type="text" class="form-control TimePicker" placeholder="{{trans('calendar.calendar_to')}}" name="hidden_to[]" id="hidden_to" aria-describedby="respite_time">
                                        </div>
                                        <a class="btn btn-default btn-xs fa fa-clone" href="#" onclick="addNewHideTime();"></a>
                                        <a class="btn btn-default btn-xs fa fa-close" href="#" onclick="removeAllHiddenTime();"></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2">
                                    <label>{{trans('calendar.modal_calendar_edit_monasebat_field_label')}}</label>
                                </td>
                                <td class="col-md-10">
                                    <input name="monasebat" type="checkbox">
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2">
                                    <label> {{trans('calendar.modal_calendar_edit_brith_day_field_label')}}</label>
                                </td>
                                <td class="col-md-10">
                                    <input name="brith_day" type="checkbox">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div id="t3" class="tab-pane fade">
            <div class="panel panel-info col-md-12">
                <div class="panel-body" id="item_permission">
                    <form class="form-inline" id="calendar_permission_form">
                        <table class="table table-bordered col-md-12">
                            <tbody>
                            <tr>
                                <td class="col-md-2">
                                    <label>
                                    {{trans('calendar.modal_calendar_edit_viewPermissions_field_label')}}
                                    <!--<select name="viewPermissions[]" class="form-control chosen-select chosen-rtl" multiple></select>-->
                                    </label>
                                </td>
                                <td class="col-md-10">
                                    <select id="states-multi-select-users" name="viewPermissions[]" class="chosen-rtl col-xs-12" data-placeholder="{{trans('calendar.calendar_select_user')}}" multiple>
                                        <option value=""></option>
                                        <!--<option value="10000" selected>hhhhhhhhhhhhhhhhhhhhhhh</option>-->
                                    </select>
                                    <span style=" position: absolute; left: 20px; top: 10px;" class=""></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2">
                                    <label>
                                    {{trans('calendar.modal_calendar_edit_editPermissions_field_label')}}
                                    <!--<select name="viewPermissions[]" class="form-control chosen-select chosen-rtl" multiple></select>-->
                                    </label>
                                </td>
                                <td class="col-md-10">
                                    <select id="states-multi-select-users_edit" name="editPermissions[]" class="chosen-rtl col-xs-12" data-placeholder="{{trans('calendar.calendar_select_user')}}" multiple>
                                        <option value=""></option>
                                    </select>
                                    <span style=" position: absolute; left: 20px; top: 10px;" class=""></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div id="t4" class="tab-pane fade">
            <div class="panel panel-info col-md-12">
                <div class="panel-body" id="item_permission">
                    <form class="form-inline" id="calendar_sharing_events_form">
                        <table class="table table-bordered col-md-12">
                            <tbody>
                            <tr>
                                <td class="col-md-12 ">
                                    <div id="sharingSelect">
                                        <table class="table  col-md-12">
                                            <tbody>
                                            <tr>
                                                <td class="col-md-4">
                                                    <label>
                                                        {{trans('calendar.modal_calendar_edit_sharing_calendar_field_label')}}
                                                    </label>
                                                </td>
                                                <td class='col-md-3'>
                                                    <select name="sharing_calendar_list[]" id="sharing_calendar_list" class=" col-xs-6 chosen-rtl"></select>
                                                </td>
                                                <td class='col-md-4'>
                                                    <div class="input-group colorpicker-component sharing-color">
                                                        <input type="text" value="" name="sharing-color[]" class="form-control"/>
                                                        <span class="input-group-addon"><i></i></span>
                                                    </div>
                                                    <script>
                                                        $(function () {
                                                            $('.sharing-color').colorpicker({
                                                                container: '.sharing-color'
                                                            });
                                                        });
                                                    </script>
                                                </td>
                                                <td class="col-md-1">
                                                    <a class="btn btn-default btn-xs fa fa fa-floppy-o"
                                                       href="#"
                                                       title="{{trans('calendar.save')}}"
                                                       alt = "{{trans('calendar.save')}}"
                                                       onclick="addNewSharing(this);"></a>
                                                    <!-- <a class="btn btn-default btn-xs fa fa-close" href="#"
                                                        onclick="removeSharing(this);"></a>-->
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-12 ">
                                    <div id="lastShring">
                                        <table id="" class="table table-inverse">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{trans('calendar.modal_calendar_title_field_label')}}</th>
                                                <th>{{trans('calendar.modal_calendar_color_field_label')}}</th>
                                                <th>{{trans('calendar.calendar.action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="sharing_calendars" value=""/>
                    </form>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in" id="t5">
            <table class="table table-bordered col-xs-12 default-options">
                <thead>
                <tr>
                    <th class="text-center">{{trans('calendar.modal_calendar_setting_show')}} </th>
                    <th class="text-center">{{trans('calendar.modal_calendar_setting_title')}} </th>
                    <th class="text-center">{{trans('calendar.modal_calendar_setting_color')}} </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="col-xs-1"><input type="checkbox" name="jalalai"/></td>
                    <td class="col-xs-6"><label> {{trans('calendar.modal_setting_jalali_event')}}</label></td>
                    <td class="col-xs-5">
                        <div class="input-group colorpicker-component jalalai-color">
                            <input type="text" value="" name="jalalai-color" class="form-control"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                        <script>
                            $('.jalalai-color').colorpicker({
                                container: '.jalalai-color',
                                align: 'left'
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-1"><input type="checkbox" name="gergorian"/></td>
                    <td class="col-xs-6"><label>{{trans('calendar.modal_setting_gergorian_event')}}</label></td>
                    <td class="col-xs-5">
                        <div  class="input-group colorpicker-componen gergorian-color">
                            <input type="text" value="" name="gergorian-color" class="form-control"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                        <script>
                            $('.gergorian-color').colorpicker({
                                container: '.gergorian-color '
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-1"><input type="checkbox" name="ghamari"/></td>
                    <td class="col-xs-6"><label>{{trans('calendar.modal_setting_ghamari_event')}}</label></td>
                    <td class="col-xs-5">
                        <div  class="input-group colorpicker-component ghamari-color">
                            <input type="text" value="" name="ghamari-color" class="form-control"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                        <script>
                            $('.ghamari-color').colorpicker({
                                container: '.ghamari-color'
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-1"><input type="checkbox" name="vacation"/></td>
                    <td class="col-xs-6"><label>{{trans('calendar.modal_setting_vocation_event')}}</label></td>
                    <td class="col-xs-5">
                        <div class="input-group colorpicker-component vacation-color">
                            <input type="text" value="" name="vacation-color" class="form-control"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                        <script>
                            $('.vacation-color').colorpicker({
                                container: '.vacation-color'
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-1"><input type="checkbox" name="event"/></td>
                    <td class="col-xs-6"><label>{{trans('calendar.modal_setting_event')}}</label></td>
                    <td class="col-xs-5">
                        <div  class="input-group colorpicker-component event-color">
                            <input type="text" value="" name="event-color" class="form-control"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                        <script>
                            $('.event-color').colorpicker({
                                container: '.event-color'
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-1"><input type="checkbox" name="session"></td>
                    <td class="col-xs-6"><label>{{trans('calendar.modal_setting_session')}}</label></td>
                    <td class="col-xs-5">
                        <div  class="input-group colorpicker-component session-color">
                            <input type="text" value="" name="session-color" class="form-control"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                        <script>
                            $(function () {
                                $('.session-color').colorpicker({
                                    container: '.session-color'
                                });
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-1"><input type="checkbox" name="invitation"/></td>
                    <td class="col-xs-6"><label>{{trans('calendar.modal_setting_invitation')}}</label></td>
                    <td class="col-xs-5">
                        <div id="" class="input-group colorpicker-component invitation-color">
                            <input type="text" value="" name="invitation-color" class="form-control"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                        <script>
                            $(function () {
                                $('.invitation-color').colorpicker({
                                    container: '.invitation-color'
                                });
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td class="col-xs-1"><input type="checkbox" name="reminder"/></td>
                    <td class="col-xs-6"><label>{{trans('calendar.modal_setting_reminder')}}</label></td>
                    <td class="col-xs-5">
                        <div id="" class="input-group colorpicker-component reminder-color">
                            <input type="text" value="" name="reminder-color" class="form-control"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                        <script>
                            $(function () {
                                $('.reminder-color').colorpicker({
                                    container: '.reminder-color'
                                });
                            });
                        </script>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
  </div>
<script>
    $('#pan_t2').on('click', function (data) {
        setTimeout(function (data) {
            $.ajax({
                url: '{{ URL::route('auto_complete.provinces')}}',
                type: 'POST', // Send post dat
                async: false,
                dataType: 'json',
                success: function (data) {
                    $('#province').select2({
                        data: data
                    });
                }
            });
        }, 1000);
    });
    $('#province').change(function () {
        var pid = $('#province').val();
        $.ajax({
            url: '{{ URL::route('auto_complete.cities')}}',
            type: 'Post', // Send post dat
            data: {pId: pid},
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#item_prayer_time_city').select2({
                    placeholder: '{{trans('app.select_a_option')}}',
                    dir: "rtl",
                    width: '100%',
                    data: data,

                }).val(null).trigger('change');
            }
        });
    });
    $("select[name='viewPermissions[]']").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '100%',
        ajax: {
            url: "{{route('auto_complete.users')}}",
            dataType: "json",
            type: "POST",
            quietMillis: 150,
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
    $("select[name='editPermissions[]']").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '100%',
        ajax: {
            url: "{{route('auto_complete.users')}}",
            dataType: "json",
            type: "POST",
            quietMillis: 150,
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
    $('#pan_t4').on('click', function () {
        //console.log( options);
        setTimeout(function () {
            $.ajax({
                url: '{{ URL::route('hamahang.calendar.get_own_calendar' )}}',
                type: 'POST', // Send post dat
                async: false,
                dataType: 'json',
                success: function (data) {
                    var data = $.map(data, function (obj) {
                        return {id: obj.id, text: obj.title};
                    });
                    $('select[name="sharing_calendar_list[]"]').select2({
                        placeholder: '{{trans('app.select_a_option')}}',
                        dir: "rtl",
                        width: '100%',
                        data: data
                    }).val(null).trigger('change');
                }
            });
        }, 1000);
    });
</script>