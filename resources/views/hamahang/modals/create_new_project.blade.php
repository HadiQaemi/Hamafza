<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/ChosenAjax/css/chosen.css')}}">
<link type="text/css" rel="stylesheet" href="{{URL::to('assets/Packages/TagsInput/css/jquery.tagsinput.rtl.css')}}">
<link type="text/css" rel="stylesheet"  href="{{URL::to('assets/Packages/PersianDateOrTimePicker/css/persian-datepicker-0.4.5.css')}}">

    <div class="tab-content">
        <div class="space-14"></div>
        <fieldset>
            <legend>{{ trans('modal.project') }} </legend>
            <div class="col-xs-12" style="padding: 5px;">

                <div id="tab" class="container table-bordered" style="width: 95%;margin-bottom: 10px">
                    <ul class="nav nav-tabs">
                        <li>
                            <a href="#t1" data-toggle="tab" class="active">{{ trans('modal.define') }}</a>
                        </li>
                        <li>
                            <a href="#t2" data-toggle="tab">{{ trans('modal.access') }}</a>
                        </li>
                        <li>
                            <a href="#t3" data-toggle="tab">{{ trans('modal.status') }}</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" style="padding-top: 8px" id="t1">
                            <div class="col-xs-12" style="padding: 5px;">
                                <table class="table table-striped">
                                    <tr>
                                        <td>{{ trans('app.title') }}</td>
                                        <td>

                                            <input type="text" class="col-xs-4 form-control" id="p_title"/>
                                            <input type="radio" class="" name="p_type" value="0"/><label>{{ trans('modal.formal') }}</label>
                                            <input type="radio" class="" name="p_type" value="1"/><label>{{ trans('modal.informal') }}</label>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('modal.up_goals') }}</td>
                                        <td><input type="text" class="form-control" id="p_top_goals"/></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('modal.page') }}</td>
                                        <td>
                                            <div class="col-sm-12 row">
                                                    <span id="pages">
                                                        <div class="col-sm-12 row">
                                                <select class="js-data-example-ajax form-control" id="page_id" name="page_id" multiple>

											    </select>
                                                <span style="position: absolute; left: 20px; top: 10px;" class="glyphicon glyphicon-file"></span>
                                            </div>
                                                    </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>توضیح</td>
                                        <td><input type="text" class="form-control" id="p_desc"/></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('modal.process_manager') }}</td>
                                        <td>
                                            <div class="col-xs-5">
                                                <div class="col-sm-7 row">
                                                    <select id="p_responsible"
                                                            name="p_responsible[]"
                                                            class="chosen-rtl form-controls col-xs-12"
                                                            data-placeholder="{{trans('tasks.select_some_options')}}">
                                                        <option value=""></option>
                                                    </select>
                                                    <span style="position: absolute; left: 20px; top: 10px;" class=""></span>
                                                </div>
                                            </div>
                                            <div class="col-xs-1">{{ trans('modal.organization_unit') }}</div>
                                            <div class="col-xs-6">
                                                <div class="col-sm-7 row">
                                                    <select id="p_org_unit"
                                                            name="p_org_unit[]"
                                                            class="chosen-rtl col-xs-12"
                                                            data-placeholder="{{trans('tasks.select_some_options')}}">
                                                        <option value=""></option>
                                                    </select>
                                                    <span style="position: absolute; left: 20px; top: 10px;" class=""></span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('modal.schedule_based_on') }}</td>
                                        <td>
                                            <select id="p_schedule_on" class="form-control col-xs-4">
                                                <optgroup label="{{ trans('modal.select') }}">
                                                    <option value="1">{{ trans('modal.project_start_date') }}</option>
                                                    <option value="2">{{ trans('modal.project_end_date') }}</option>
                                                </optgroup>
                                            </select><span id="schedule_massage" style="color-rendering: gray"></span>
                                        </td>
                                    </tr>

                                </table>
                                <table class="table table-default">
                                    <tr>
                                        <td>{{ trans('modal.start_date') }}</td>
                                        <td>
                                            <div>

                                                <div class="input-group pull-right">
                                <span class="input-group-addon" id="respite_date">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                                    <input type="text" class="form-control DatePicker" id="start_date" name="start_date"
                                                           aria-describedby="respite_date">
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ trans('modal.end_date') }}</td>
                                        <td>
                                            <div class="input-group pull-right">
                                <span class="input-group-addon" id="respite_date">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                                <input type="text" class="form-control DatePicker" name="end_date" id="end_date" aria-describedby="respite_date">
                                            </div>
                                        </td>
                                        <td>{{ trans('modal.current_date') }}</td>
                                        <td>
                                            <div class="input-group pull-right">
                                <span class="input-group-addon" id="respite_date">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                                <input type="text" class="form-control DatePicker" name="current_date" id="current_date" aria-describedby="respite_date">
                                            </div>
                                        </td>
                                        <td>{{ trans('modal.status_date') }}</td>
                                        <td>
                                            <div class="input-group pull-right">
                                <span class="input-group-addon" id="respite_date">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                                <input type="text" class="form-control DatePicker" name="state_date" id="state_date" aria-describedby="respite_date">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><h6>{{ trans('modal.base_calendar') }}</h6></td>
                                        <td>
                                            <select class="form-control" id="base_calendar">
                                                <option value="">{{ trans('modal.select') }}</option>
                                                @foreach($calendars as $calendar)
                                                    <option value="{{ $calendar->id }}">{{ $calendar->title }}</option>
                                                @endforeach

                                            </select>
                                        </td>
                                        <td>{{ trans('modal.priority') }}</td>
                                        <td><input type="text" class="form-control col-xs-4" id="p_priority"/></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="width-120">
                                            <label class="line-height-35">{{ trans('modal.keywords') }}</label>
                                        </td>
                                        <td colspan="7">
                                            <div class="row-fluid">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline line-height-25">
                                                    <div class="form-inline">
                                                        <input type="text" class="col-xs-12" id="p_keyword" name="p_keyword[]" multiple/>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                        <div class="tab-pane" style="padding-top: 8px" id="t2">
                            <table class="table table-default">
                                <tr>
                                    <td class="col-xs-2">
                                        <h6>{{ trans('modal.edit_access') }}</h6>
                                    </td>
                                    <td class="col-xs-3">
                                        <input type="radio" value="all" id="ModifyPermissionType1" name="ModifyPermissionType" onclick="CheckType()"/><label>{{ trans('modal.all_users') }}</label>
                                        <input type="radio" value="some" id="ModifyPermissionType2" name="ModifyPermissionType" onclick="CheckType()"/><label>{{ trans('modal.permitted_users') }} </label>
                                    </td>
                                    <td class="col-xs-7">
                                        <div class="col-sm-7 row">
                                            <select id="ModifyPermissionUsers"
                                                    name="ModifyPermissionUsers[]"
                                                    class="chosen-rtl col-xs-12 "
                                                    data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                                <option value=""></option>
                                            </select>

                                            <span style="position: absolute; left: 20px; top: 10px;" class=""></span>
                                        </div>
                                    </td>

                                </tr>
                            </table>
                            <table class="table table-default">
                                <tr>
                                    <td class="col-xs-2">
                                        <h6>{{ trans('modal.read_access') }}</h6>
                                    </td>
                                    <td class="col-xs-3">
                                        <input type="radio" value="all" id="ObservationPermissionType1" name="ObservationPermissionType" onclick="CheckType()"/><label>{{ trans('modal.all_users') }}</label>
                                        <input type="radio" value="some" id="ObservationPermissionType2" name="ObservationPermissionType" onclick="CheckType()"/><label>{{ trans('modal.permitted_users') }}</label>
                                    </td>
                                    <td class="col-xs-7">
                                        <div class="col-sm-7 row">
                                            <select id="ObservationPermissionUsers"
                                                    name="ObservationPermissionUsers[]"
                                                    class="chosen-rtl col-xs-12 "
                                                    data-placeholder="{{trans('tasks.select_some_options')}}" multiple>
                                                <option value=""></option>
                                            </select>

                                            <span style="position: absolute; left: 20px; top: 10px;" class=""></span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="tab-pane" style="padding-top: 8px" id="t3">
                            <table class="table table-bordered" style="text-align: center;">
                                <thead>
                                <th></th>
                                <th>{{ trans('modal.start') }}</th>
                                <th>{{ trans('modal.end') }}</th>
                                <th>{{ trans('modal.duration') }}</th>
                                <th>{{ trans('modal.work_hour') }}</th>
                                <th>{{ trans('modal.price') }}</th>
                                </thead>
                                <tr>
                                    <td>{{ trans('modal.base_line') }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>

                                    <td>{{ trans('modal.real') }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('modal.development') }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('modal.remain') }}</td>
                                    <td colspan="2"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('modal.status') }}</td>
                                    <td colspan="2"></td>
                                    <td><span style="background-color: red">{{ trans('modal.critical') }}</span></td>
                                    <td></td>
                                    <td><span style="background-color: yellow">{{ trans('modal.alert') }}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>


                    <div class="col-xs-12">
                    <span class="pull-left">

                        <input type="radio" name="save_type" value="11"/>
                        <label>{{ trans('modal.draft') }}</label>
                        <input type="radio" name="save_type" value="22"/>
                        <label>{{ trans('modal.final') }}</label>
                        <a class="btn btn-info">{{ trans('modal.confirm_and_register_new_project') }}</a>
                        <a class="btn btn-info" onclick="CheckForm()">{{ trans('app.confirm') }}</a>
                    </span>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="modal fade" id="confirm_modal" role="dialog">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color:red;" id="confirm_modal_title">خطا</h4>
                </div>
                <div class="modal-body">
                    <span id="confirm_modal_massage">{{ trans('modal.sure_to_delete_working_package') }}</span>
                </div>
                <div class="modal-footer">
                    <span style="text-align: center" id="">
                        <a class="btn btn-default" onclick="close_modal()">{{ trans('app.confirm') }}</a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/ChosenAjax/js/chosen.ajaxaddition.jquery.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/TagsInput/js/jquery.tagsinput.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-date.js')}}"></script>
    <script type="text/javascript" src="{{URL::to('assets/Packages/PersianDateOrTimePicker/js/persian-datepicker-0.4.5.js')}}"></script>
    <script>

        $(".js-data-example-ajax").select2({
            minimumInputLength: 1,
            tags: false,
            dir: "rtl",
            width: '100%',
            ajax: {
                url: "{{ route('autocomplete_pages_list',['username'=>$uname]) }}",
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

        $('#p_schedule_on').on('change', function () {
            var val = $('#p_schedule_on').val();
            if (val == 1) {
                $('#schedule_massage').html('{{ trans('modal.tasks_starts_soon') }}');
                $('#end_date').attr('disabled', 'disabled');
                $('#start_date').attr('disabled', false);
            }
            if (val == 2) {

                $('#schedule_massage').html('{{ trans('modal.tasks_starts_late') }}');
                $('#end_date').attr('disabled', false);
                $('#start_date').attr('disabled', 'disabled');
            }
        })
        function CheckForm() {
            if (($('input[name=save_type]:checked').val() == 11 || $('input[name=save_type]:checked').val() == 22) && $('#base_calendar').val() != '') {
                SaveNewProject();
            }
            else {
                {
                    var TxtAlert = '';
                    if (!($('input[name=save_type]:checked').val() == 11 || $('input[name=save_type]:checked').val() == 22))
                        TxtAlert += '{{ trans('modal.saving_undefined') }}' + '<br/>';
                    if (!$('#base_calendar').val() != '')
                        TxtAlert += '{{ trans('modal.timing_undefined') }}';
                    $('#confirm_modal_massage').html(TxtAlert);
                    $('#confirm_modal').modal({show: true});

                }
            }
            function SaveNewProject() {
                var sendInfo = {

                    p_title: $('#p_title').val(),
                    p_type: $('input[name=p_type]:checked').val(),
                    p_top_goals: $('#p_top_goals').val(),
                    p_page: $('#p_page').val(),
                    p_about: $('#p_about').val(),
                    p_desc: $('#p_desc').val(),
                    p_responsible: $('#p_responsible').val(),
                    p_org_unit: $('#p_org_unit').val(),
                    p_keyword: $('#p_keyword').val(),
                    p_schedule_on: $('#p_schedule_on').val(),
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                    current_date: $('#current_date').val(),
                    state_date: $('#state_date').val(),
                    base_calendar: $('#base_calendar').val(),
                    p_priority: $('#p_priority').val(),
                    p_page: $('#page_id').val(),
                    modify_permission_type: $('input[name=ModifyPermissionType]:checked').val(),
                    ModifyPermissionUsers: $('#ModifyPermissionUsers').val(),
                    observation_permission_type: $('input[name=ObservationPermissionType]:checked').val(),
                    ObservationPermissionUsers: $('#ObservationPermissionUsers').val(),
                    save_type: $('input[name=save_type]:checked').val(),
                };
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamahang.project.save_new_project') }}',
                    dataType: "json",
                    data: sendInfo,
                    success: function (data) {

                        Location.reload();

                    }
                });

            }}

        (function ($) {
            $(".DatePicker").persianDatepicker({
                observer: true,
                autoClose: true,
                //position: 'right',
                format: 'YYYY-MM-DD'
            });
            $('#p_keyword').tagsInput
            ({
                'width': 'auto',
                'height': 'auto',
                'minChars': 0,
                'maxChars': 0, // if not provided there is no limit
                'delimiter': [','],   // Or a string with a single delimiter. Ex: ';'
                'interactive': true,
                'defaultText': '{{trans('tasks.enter_keywords')}}',
                'placeholderColor': '#777777',
                'removeWithBackspace': true,
            });
            $('#p_responsible').ajaxChosen({
                dataType: 'json',
                type: 'POST',
                url: "{{ route('autocomplete',['username'=>$uname]) }}"
            });
            $('#p_org_unit').ajaxChosen({
                dataType: 'json',
                type: 'POST',
                url: "{{ route('hamahang.project.user_orgs') }}"
            });
            $('#ModifyPermissionUsers').ajaxChosen({
                dataType: 'json',
                type: 'POST',
                url: "{{ route('autocomplete',['username'=>$uname]) }}"
            });
            $('#ObservationPermissionUsers').ajaxChosen({
                dataType: 'json',
                type: 'POST',
                url: "{{ route('autocomplete',['username'=>$uname]) }}"
            });
        })(jQuery);

    </script>




