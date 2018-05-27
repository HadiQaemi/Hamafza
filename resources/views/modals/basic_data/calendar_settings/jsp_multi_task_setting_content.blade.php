<div class="row" >
    <form class="form-controller " id="form-multi-tasking">
        <div class="col-md-3" style="border-left: 1px #E5E5E5 solid;height: 400px;">
            <div>
                <div id="div_count_selected" class="container-fluid">
                    <div class="col-md-10">
                        <span id="span_selected_select" style="color: blue; font-size: 11px; cursor: pointer;"> انتخاب شده</span>
                        <span id="span_count_selected" style="color: blue;">0</span>
                    </div>
                    <div class="col-md-2" id="span_close_selected"><span class="fa fa-remove"></span></div>
                </div>
                <div id="FehresrtUC" class="v"></div>
                <div id="html1">
                    <ul>

                    </ul>
                </div>
            </div>

        </div>
        <div class="col-md-9" style="">
            <div id="GroupsDiv">
            </div>
            <div id="OrgansDiv">
            </div>
            <div id="CiclesDiv">
            </div>
            <div class="space-6"></div>
            <div id="div_loader" class="loader"></div>
            <div id="SearchDiv" class="">
                <div class="noLeftPadding noRightPadding no-margin-left no-margin-right">
                    <div class="col-xs-6 noLeftPadding noRightPadding no-margin-left no-margin-right">
                        <div class="col-xs-1 noLeftPadding noRightPadding no-margin-left no-margin-right">
                            <label class="line-height-30 pull-right"> {{trans('calendar_events.ce_startdate_label')}}</label>
                        </div>
                        <div class="col-xs-11 noLeftPadding noRightPadding no-margin-left no-margin-right">
                            <div class="col-sm-6 col-xs-6 noRightPadding no-margin-left no-margin-right">
                                <div class="input-group pull-right">
                                    <input type="text"
                                           class="form-control DatePicker clsDatePicker col-xs-4"
                                           name="startdate"
                                           placeholder="{{trans('calendar_events.ce_date_label')}}"
                                           aria-describedby="startdate-session">
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6 noLeftPadding noRightPadding no-margin-left no-margin-right">
                                <div class=' input-group date'>
                                    <input type="text" class="form-control TimePicker"
                                           placeholder="{{trans('calendar_events.ce_hour_label')}}"
                                           name="starttime"
                                           aria-describedby="starttime">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 noLeftPadding noRightPadding no-margin-left no-margin-right">
                        <div class="col-xs-1 noLeftPadding noRightPadding no-margin-left no-margin-right">
                            <label class="line-height-30 pull-right">{{trans('calendar_events.ce_enddate_label')}}</label>
                        </div>
                        <div class="col-xs-11 noLeftPadding noRightPadding no-margin-left no-margin-right">
                            <div class="col-sm-6 col-xs-6 noRightPadding no-margin-left no-margin-right">
                                <div class="input-group pull-right">
                                    <input type="text"
                                           class="form-control DatePicker  clsDatePicker col-xs-4"
                                           name="enddate"
                                           placeholder="{{trans('calendar_events.ce_date_label')}}"
                                           aria-describedby="enddate-session">
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-6 noLeftPadding noRightPadding no-margin-left no-margin-right">
                                <div class=' input-group date'>

                                    <input type="text" class="form-control TimePicker"
                                           placeholder=" {{trans('calendar_events.ce_hour_label')}}"
                                           name="endtime"
                                           aria-describedby="endtime">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>   سه حرف از عنوان وظیفه یا وظیفه ها را وارد نمایید.</div>
                <div class="space-6"></div>
                <input type="text" id="Search_Box" class="form-control" onkeyup="send_tasks(this,event)">
                <hr>
                <div class="div_scroll_serchad_user">
                <ul class="person_list  row" id="SearchedUsers">

                </ul>
                </div>
                <div id="div_loader_searched" class="loader" style="margin-top: 50px;"></div>
            </div>
            <div id="SelectedDiv" style="display: none;">
                <div class="div_scroll_serchad_user">
                    <ul class="person_list  row" id="SelectedTasks_div"></ul>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
var select='{{$id_select}}';
</script>
<script>
    $(".DatePicker").persianDatepicker({

        autoClose: true,
        format: 'YYYY-MM-DD',

    });
    $(".DatePicker").val('');
    $(".TimePicker").persianDatepicker({
        format: "HH:mm",
        timePicker: {
            //showSeconds: false,
        },
        onlyTimePicker: true
    });
    $(".TimePicker").val('');
</script>