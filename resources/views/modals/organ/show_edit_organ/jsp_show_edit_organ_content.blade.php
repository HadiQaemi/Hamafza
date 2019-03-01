<style>
    table.dataTable{
        width:100% !important;
    }
</style>
<div class="row">
    <div class="base_tabs" style="padding: 15px;">
        <ul class="nav nav nav-tabs">
            <li id="tab_charts" class="active"><a data-toggle="pill" href="#edit">{{trans('org_chart.organizational_unit')}}</a></li>
            <li id="tab_post"><a data-toggle="pill" href="#jobs">{{trans('org_chart.jobs')}}</a></li>
            <li id="tab_post"><a data-toggle="pill" href="#position">سمت ها</a></li>
            {{--<li id="tab_insert_post"><a data-toggle="pill" href="#add_position">افزودن سمت</a></li>--}}
            {{--<li id="tab_item"><a data-toggle="pill" href="#organs">واحدها</a></li>--}}
            {{--<li id="tab_insert_items"><a data-toggle="pill" href="#add_organ">افزودن واحد</a></li>--}}
        </ul>
        <div class="tab-content">
            <div id="edit" class="tab-pane fade in active">
                <div id="alert_edit" class="mt-5"></div>
                <form id="Form_Update_Item" method="post" action="#" id="">
                    <div class="margin-top-20">
                        <div class="form-group col-xs-12">
                            <input type="hidden" value="{{$item_id}}" name="item_id" />
                            <div class="col-xs-1 line-height-30">{{trans('app.title')}}</div>
                            <div class="col-xs-11"><input type="text" name="item_title" id="item_title" class="form-control" value="{{$title}}"/></div>
                        </div>
                        <div class="form-group col-xs-12">
                            <div class="col-xs-1 line-height-30">{{trans('org_chart.up')}}</div>
                            <div class="col-xs-11">
                                <select id="item_parent_id" name="item_parent_id" class="col-xs-12 js-states form-control">
                                    <option value="{{$parent[0]}}">{{$parent[1]}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-xs-12">
                            <div class="col-xs-1 line-height-30">{{trans('org_chart.missions')}}</div>
                            <div class="col-xs-11">
                                <select id="item_parent_id" name="item_parent_id" class="col-xs-12 js-states form-control">
                                    <option value="{{$parent[0]}}">{{$parent[1]}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-xs-12">
                            <div class="col-xs-1 line-height-30">
                                {{trans('app.description')}}
                            </div>
                            <div class="col-xs-11 line-height-30">
                                <textarea type="text" name="item_description" id="item_description" class="form-control">{{$description}}</textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="jobs" class="tab-pane fade">
                <div class="col-xs-12">
                    <form id="Form_Update_Item" method="post" action="#" id="">
                        <div class="margin-top-20">
                            <div class="col-xs-12 form-group noLeftPadding noRightPadding">
                                <div class="col-xs-11 noLeftPadding noRightPadding">
                                    <div class="col-xs-6 noLeftPadding noRightPadding"><input type="text" name="item_title" id="item_title" class="form-control" placeholder="{{trans('app.title')}}"/></div>
                                    <div class="col-xs-6 noLeftPadding noRightPadding"><input type="text" name="item_title" id="item_title" class="form-control" placeholder="{{trans('app.amount')}}"/></div>
                                </div>
                                <div class="col-xs-1 line-height-35"><a class="btn btn-primary fa fa-plus"></a></div>
                            </div>
                            <div class="col-xs-12 form-group noLeftPadding noRightPadding">
                                <textarea class="form-control" rows="2" name="" id="" placeholder="{{trans('app.description')}}"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <table id="list_post" class="table table-striped 2 dataTable no-footer" style="width: 100%;">
                    <thead>
                        <th class="col-xs-4">{{trans('app.title')}}</th>
                        <th class="col-xs-7">{{trans('org_chart.num_post')}}</th>
                        <th class="col-xs-1">{{trans('app.operations')}}</th>
                    </thead>
                </table>
            </div>
            <div id="position" class="tab-pane fade">
                <div class="col-xs-12 margin-top-10">
                    <a href="{!! route('modals.add_new_post') !!}" class="jsPanels btn btn-default pull-left jspa btn-primary btn fa fa-plus"></a>
                </div>
                <table id="list_post" class="table table-striped 2 dataTable no-footer" style="width: 100%;">
                    <thead>
                    <th class="col-xs-3">{{trans('org_chart.extra_title')}}</th>
                    <th class="col-xs-3">{{trans('org_chart.work_place')}}</th>
                    <th class="col-xs-3">{{trans('org_chart.share_payment')}}</th>
                    <th class="col-xs-2">{{trans('org_chart.working_hours')}}</th>
                    <th class="col-xs-1">{{trans('app.operations')}}</th>
                    </thead>
                </table>
            </div>
            <div id="add_position" class="tab-pane fade">
                <div class="bas_inside_tabs container-fluid">
                    <div id="alert_insert_post" class="mt-5"></div>
                    <form id="form_add_new_chart_item_post" method="post" action="#">
                        <input type="hidden" id="form_add_post_for_item_id" name="item_id" value="{{$item_id}}"/>
                        <div class="form-group col-md-12 mt-5">
                            <label>
                                <span class="required">*</span>
                                <span>عنوان سمت :</span>
                            </label>
                            <input name="new_post_title" id="insert_new_post_title" class="form-control" type="text"  />
                        </div>
                        <div class="form-group col-md-12">
                            <label>
                                <span>توضیحات سمت :</span>
                            </label>
                            <textarea name="new_post_description" id="insert_new_post_description" class="form-control"  ></textarea>
                        </div>


                    </form>
                </div>
            </div>
            <div id="organs" class="tab-pane fade">
                <div class="bas_inside_tabs container-fluid">
                <table id="datatable_ItemChildrenGrid" class="table table-striped col-xs-12 dataTable no-footer">
                    <thead>
                    <th>ردیف</th>
                    <th>عنوان</th>
                    <th>توضیحات</th>

                    </thead>

                </table>
                </div>

            </div>
            <div id="add_organ" class="tab-pane fade">
                <div class="bas_inside_tabs container-fluid">
                    <div id="alert_insert_organ" class="mt-5"></div>
                    <form id="form_add_chart_item_child">
                        <input type="hidden" id="input_add_chart_id" name="chart_id" value="{{$chart_id}}"/>
                        <input type="hidden" id="input_add_item_id" name="item_id" value="{{$item_id}}"/>
                        <div class="form-group col-md-12">
                            <label>
                                <span class="required">*</span>
                                <span>عنوان واحد سازمانی :</span>
                            </label>
                            <input name="new_item_title" id="new_item_title_org" class="form-control" type="text"  />
                        </div>
                        <div class="form-group col-md-12">
                            <label>
                                <span>توضیحات واحد سازمانی :</span>
                            </label>
                            <textarea name="new_item_description" id="new_item_description_org" class="form-control"  ></textarea>
                        </div>
                        <div class="clearfix"></div>

                    </form>
                </div>

            </div>


        </div>
    </div>
</div>

