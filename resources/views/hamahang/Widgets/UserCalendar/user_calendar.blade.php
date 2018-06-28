@include('hamahang.Widgets.UserCalendar.JS.calendars_grid')
    </div>
</div>
<style>
    .datepicker-plot-area{
        border: none;
        border-bottom: 1px solid #ccc;
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
        box-shadow: none;
    }
</style>
<div id="calendar_datepickar" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hd-tree" data-mcs-theme="minimal-dark2" style="direction: ltr; max-height: 80vh; overflow-y: auto;">
    <div style="direction: rtl">
        <div class="row event_result_holder ">
            <div id="currentMonth" class="row tab-pane fade in  default-options">
                <div id="calendar_widget_current_month" ></div>
                <div class="clearfixed"></div>
            </div>
        </div>

    </div>
</div>
<div id="calendar_myCalendar" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hd-tree" data-mcs-theme="minimal-dark2" style="direction: ltr; max-height: 80vh; overflow-y: auto;">
    <div style="direction: rtl">
        <div class="panel-heading panel-heading-darkblue">
            <div class="row">
                <h6 class="noPadding noMargin">
                    <span>{{trans('calendar.calendar_index_calendar_list_title')}}</span>
                    <a href="#" onclick="addPersonalCalendar();"
                       class="btn btn-default fa fa-plus pull-left"
                       alt="{{ trans('calendar.modal_calendar_ header_title') }} "
                       title="{{ trans('calendar.modal_calendar_ header_title') }}">
                        {{--{{ trans('app.add') }} --}}
                    </a>
                </h6>
                <div class="clearfixed"></div>
            </div>
        </div>
        <div class="panel panel-light panel-list padding-remove">
            <!--<div class="panel-heading panel-heading-darkblue">تازه&zwnj;های دیوار من </div>-->
            <div class="panel-body new-list">
                <div class="row event_result_holder ">
                    <table id="personalCalendarGrid" class="table_td_padding_5px">
                        <thead>
                        <tr>
                            {{--<th data-column-id="rowIndex">{{trans('calendar.calendar_index_calendar_datatable_rowindex')}}</th>--}}
                            <th data-column-id="title">{{trans('calendar.calendar_index_calendar_datatable_title')}}</th>
                            <th>{{trans('calendar.calendar_index_calendar_datatable_action')}}</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="clearfixed"></div>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="pcol_32" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hd-tree" data-mcs-theme="minimal-dark2" style="direction: ltr; max-height: 80vh; overflow-y: auto;">
    <div style="direction: rtl">
