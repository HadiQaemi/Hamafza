<div class="row">
    <div class="base_tabs">
                <div style="padding: 15px;">
                    <div id="alert_insert"></div>
                    <form id="FormEditChart">
                        <div>{{ trans('org_chart.chart_name') }}</div>
                        <div class="space-4"></div>
                        <input name="chart_title" type="text" class="form-control" id="NewChartTitle" value="{{$chart_title}}"/>
                        <div class="space-6"></div>
                        <div>{{ trans('app.description') }}</div>
                        <div class="space-4"></div>
                        <div>
                            <textarea name="chart_description" type="text" class="form-control" id="NewChartDesc">{{$chart_description}}</textarea>
                        </div>
                        <input name="chart_id" type="hidden" value="{{$chart_id}}"/>
                    </form>
                </div>
    </div>
</div>

