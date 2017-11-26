<div class="modal fade" tabindex="-1" id="modal_calendar_setting" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span>{{trans('calendar.modal_calendar_setting_header_title')}}</span>:
                    <span class="bg-warning" id="modal_header_item_title" style="padding:2px 10px; margin-right: 10px;"></span>
                </h4>
            </div>
            <div class="modal-body">
                <div id="tab" class="container" style="width: 95%">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#dp1" data-toggle="tab">
                                <i class="fa fa-edit"></i>
                                <span>{{trans('calendar.modal_calendar_setting_default_event')}}</span>
                            </a>
                        </li>
                        <li>
                            <a href="#dp2" data-toggle="tab">
                                <i class="fa fa-edit"></i>
                                <span>{{trans('calendar.modal_calendar_setting_sharing_event')}} </span>
                            </a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div class="col-xs-12 tab-pane fade in active default-options" id="dp1">
                            <table class="table table-bordered col-xs-12 text-">
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
                                            <div id="jalali-color" class="input-group colorpicker-component">
                                                <input type="text" value="" name="jalali-color" class="form-control"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                            <script>

                                                    $('#jalali-color').colorpicker({
                                                        container: '#jalali-color ',
                                                        align: 'left'
                                                    });

                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-xs-1"><input type="checkbox" name="gergorian"/></td>
                                        <td class="col-xs-6"><label>{{trans('calendar.modal_setting_gergorian_event')}}</label></td>
                                        <td class="col-xs-5">
                                            <div id="gergorian-color" class="input-group colorpicker-component">
                                                <input type="text" value="" name="gergorian-color" class="form-control"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                            <script>

                                                    $('#gergorian-color').colorpicker({
                                                        container: '#gergorian-color '
                                                    });

                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-xs-1"><input type="checkbox" name="ghamari"/></td>
                                        <td class="col-xs-6"><label>{{trans('calendar.modal_setting_ghamari_event')}}</label></td>
                                        <td class="col-xs-5">
                                            <div id="ghamari-color" class="input-group colorpicker-component">
                                                <input type="text" value="" name="ghamari-color" class="form-control"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                            <script>

                                                    $('#ghamari-color').colorpicker({
                                                        container: '#ghamari-color'
                                                    });

                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-xs-1"><input type="checkbox" name="vacation"/></td>
                                        <td class="col-xs-6"><label>{{trans('calendar.modal_setting_vocation_event')}}</label></td>
                                        <td class="col-xs-5">
                                            <div id="vacation-color" class="input-group colorpicker-component">
                                                <input type="text" value="" name="vacation-color" class="form-control"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                            <script>

                                                    $('#vacation-color').colorpicker({
                                                        container: '#vacation-color'
                                                    });

                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-xs-1"><input type="checkbox" name="event"/></td>
                                        <td class="col-xs-6"><label>{{trans('calendar.modal_setting_event')}}</label></td>
                                        <td class="col-xs-5">
                                            <div id="event-color" class="input-group colorpicker-component">
                                                <input type="text" value="" name="event-color" class="form-control"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                            <script>

                                                    $('#event-color').colorpicker({
                                                        container: '#event-color'
                                                    });

                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-xs-1"><input type="checkbox" name="session"></td>
                                        <td class="col-xs-6"><label>{{trans('calendar.modal_setting_session')}}</label></td>
                                        <td class="col-xs-5">
                                            <div id="session-color" class="input-group colorpicker-component">
                                                <input type="text" value="" name="session-color" class="form-control"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                            <script>
                                                $(function () {
                                                    $('#session-color').colorpicker({
                                                        container: '#session-color'
                                                    });
                                                });
                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-xs-1"><input type="checkbox" name="invitation"/></td>

                                        <td class="col-xs-6"><label>{{trans('calendar.modal_setting_invitation')}}</label></td>
                                        <td class="col-xs-5">
                                            <div id="invitation-color" class="input-group colorpicker-component">
                                                <input type="text" value="" name="invitation-color" class="form-control"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                            <script>
                                                $(function () {
                                                    $('#invitation-color').colorpicker({
                                                        container: '#invitation-color'
                                                    });
                                                });
                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-xs-1"><input type="checkbox" name="reminder"/></td>
                                        <td class="col-xs-6"><label>{{trans('calendar.modal_setting_reminder')}}</label></td>
                                        <td class="col-xs-5">
                                            <div id="reminder-color" class="input-group colorpicker-component">
                                                <input type="text" value="" name="reminder-color" class="form-control"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                            <script>
                                                $(function () {
                                                    $('#reminder-color').colorpicker({
                                                        container: '#reminder-color'
                                                    });
                                                });
                                            </script>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                        <div class="col-xs-12 tab-pane sharing-options" id="dp2">
                            <table class="table table-bordered col-xs-12">
                                <thead>
                                <tr>
                                    <th class="text-center">{{trans('calendar.modal_calendar_setting_show')}} </th>
                                    <th class="text-center">{{trans('calendar.modal_calendar_setting_title')}} </th>
                                    <th class="text-center">{{trans('calendar.modal_calendar_setting_color')}} </th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="save-calendar-setting" value="save" class="btn btn-info" type="button">
                    <i class="glyphicon  glyphicon-save-file bigger-125"></i>
                    <span>{{trans('calendar.save')}}</span>
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
