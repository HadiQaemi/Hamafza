<legend>
    <h3>
        <a href="{!! route('modals.add_new_post') !!}" class="jsPanels btn btn-default pull-left jspa btn-primary btn fa fa-plus"></a>
    </h3>
</legend>
<div class="row-fluid">
    <div class="col-lg-12">
        <table id="ShowPostlistGrid" class="table dt-responsive nowrap display text-center" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>عنوان</th>
                <th>عنوان واحد</th>
                <th>عنوان شغل</th>
                <th>توضیحات</th>
                <th>{{trans('org_chart.share_payment')}}</th>
                <th>{{trans('org_chart.outsourced')}}</th>
                <th>عملیات</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="clearfix"></div>
</div>