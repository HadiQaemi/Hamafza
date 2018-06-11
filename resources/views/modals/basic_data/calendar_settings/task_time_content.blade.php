<div class="row" >
    <form class="form-controller " id="form-multi-tasking">
        <div class="col-md-12" id="take_title" style="padding: 20px 10px;">

        </div>
        <div class="col-md-12" style="overflow-x: auto">
            <div class="row col-xs-12 noLeftPadding noRightPadding margin-top-20">
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
                                       id="startdate" autocomplete="off"
                                       placeholder="{{trans('calendar_events.ce_date_label')}}"
                                       aria-describedby="startdate-session">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6 noLeftPadding noRightPadding no-margin-left no-margin-right">
                            <div class=' input-group date'>
                                <input type="text" class="form-control TimePicker"
                                       placeholder="{{trans('calendar_events.ce_hour_label')}}"
                                       name="starttime"
                                       id="starttime" autocomplete="off"
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
                                       id="enddate" autocomplete="off"
                                       placeholder="{{trans('calendar_events.ce_date_label')}}"
                                       aria-describedby="enddate-session">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6 noLeftPadding noRightPadding no-margin-left no-margin-right">
                            <div class=' input-group date'>

                                <input type="text" class="form-control TimePicker"
                                       placeholder=" {{trans('calendar_events.ce_hour_label')}}"
                                       name="endtime"
                                       id="endtime" autocomplete="off"
                                       aria-describedby="endtime">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

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
    $.ajax({
        url: '{{ URL::route('auto_complete.get_user_calendar')}}',
        type: 'Post', // Send post dat
        dataType:'json',
        success: function (s) {

            var options = '';
            $('select[name="cid"]').empty();
            for (var i = 0; i < s.length; i++) {
                if(s[i].is_default ==1)
                {
                    options += '<option  selected=true value="' + s[i].id + '">' + s[i].title + '</option>';
                }
                else{
                    options += '<option value="' + s[i].id + '">' + s[i].title + '</option>';
                }


            }

            $('select[name="cid"]').append(options);
            $('select[name="cid"]').select2({
                dir: "rtl",
                width: '100%',
            });
        }
    });
</script>