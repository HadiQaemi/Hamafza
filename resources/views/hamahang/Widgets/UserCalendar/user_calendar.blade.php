@include('hamahang.Widgets.UserCalendar.JS.calendars_grid')
<div class="panel-body searching-cntnt">
    <div class="panel-body searching-cntnt" style="margin-bottom: 10px">
        <div class="row">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#calendars" data-toggle="tab">تقویم ها</a></li>
                <li><a href="#currentMonth" data-toggle="tab">روزها</a></li>
            </ul>
            <div class="tab-content">
                <div id="calendars" class="row tab-pane fade in active default-options">
                    {{--
                    <div class="row">
                        <h6>
                            <span>{{trans('calendar.calendar_index_calendar_list_title')}}</span>
                            <a href="#" onclick="addPersonalCalendar();"
                               class="btn btn-default fa fa-plus pull-left"
                               alt="{{ trans('calendar.modal_calendar_ header_title') }} "
                               title="{{ trans('calendar.modal_calendar_ header_title') }}">{{ trans('app.add') }} </a>
                        </h6>
                        <div class="clearfixed"></div>
                    </div>
                    <hr class=" hr hr2">
                    --}}
                    <div class="row event_result_holder ">
                        <table id="personalCalendarGrid" class="table_td_padding_5px">
                            {{--<thead>
                            <tr>
                                <th data-column-id="rowIndex">{{trans('calendar.calendar_index_calendar_datatable_rowindex')}}</th>
                                <th data-column-id="title">{{trans('calendar.calendar_index_calendar_datatable_title')}}</th>
                                <th>{{trans('calendar.calendar_index_calendar_datatable_action')}}</th>
                            </tr>
                            </thead>--}}
                        </table>
                        <div class="clearfixed"></div>
                    </div>
                    <div class="clearfixed"></div>
                </div>
                <div id="currentMonth" class="row tab-pane fade in  default-options">
                    <div id="calendar_widget_current_month"></div>
                    <div class="clearfixed"></div>
                </div>
            </div>
            <div class="clearfixed"></div>
        </div>
    </div>
</div>