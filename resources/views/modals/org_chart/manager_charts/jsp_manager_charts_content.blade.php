<div class="row">
    <div class="base_tabs">
        <ul class="nav nav nav-tabs">
            {{--<li id="tab_charts" class="active"><a data-toggle="pill" href="#charst">چارت ها</a></li>--}}
            <li id="tab_insert_charts" class="active"><a data-toggle="pill" href="#add_chart">ایجادچارت</a></li>
        </ul>

        <div class="tab-content">

            <input type="hidden" id="input_Uname" value="{{$username}}">
            {{--<div id="charst" class="tab-pane fade in active">--}}
            {{--<div style="padding: 15px;">--}}
            {{--<table class="table table table-striped table-bordered dt-responsive nowrap display dataTable no-footer" id="Chart_Datatable">--}}
            {{--<thead>--}}
            {{--<th>شناسه</th>--}}
            {{--<th>ایجادکننده</th>--}}
            {{--<th>عنوان</th>--}}
            {{--<th>توضیحات</th>--}}
            {{--<th>عملیات</th>--}}
            {{--</thead>--}}
            {{--</table>--}}
            {{--</div>--}}
            {{--</div>--}}
            <div id="add_chart" class="tab-pane  fade in active">
                <div style="padding: 15px;">
                    <div id="alert_insert"></div>
                    <form id="FormInsertChart">
                        <div>{{ trans('org_chart.chart_name') }}</div>
                        <div class="space-4"></div>
                        <input name="chart_name" type="text" class="form-control" id="New_ChartTitle"/>
                        <div class="space-6"></div>
                        <div>{{ trans('app.description') }}</div>
                        <div class="space-4"></div>
                        <div>
                            <textarea name="chart_description" type="text" class="form-control" rows="5" style="overflow: hidden" id="New_ChartDesc"></textarea>
                        </div>
                        <input id="organ_id" name="organs_id" type="hidden" value="{{$org_id}}"/>
                    </form>
                </div>
            </div>
        </div>


    </div>
</div>

