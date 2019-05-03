<style>
    table.dataTable {
        width: 100% !important;
    }

    .item_parent_id .select2.select2-container {
        width: 100% !important;
    }
</style>
<div class="row">
    <div class="base_tabs" style="padding: 15px;">
        <ul class="nav nav nav-tabs">
            <li id="tab_post" class="active"><a data-toggle="pill" href="#jobs">{{trans('org_chart.jobs')}}</a></li>
            <li id="tab_post"><a data-toggle="pill" href="#position">سمت ها</a></li>
            {{--<li id="tab_insert_post"><a data-toggle="pill" href="#add_position">افزودن سمت</a></li>--}}
            {{--<li id="tab_item"><a data-toggle="pill" href="#organs">واحدها</a></li>--}}
            {{--<li id="tab_insert_items"><a data-toggle="pill" href="#add_organ">افزودن واحد</a></li>--}}
        </ul>
        {{--<pre style="overflow: scroll; height: 500px">--}}
        {{--{{print_r($job->posts)}}--}}
        {{--</pre>--}}
        <div class="tab-content">
            <div id="jobs" class="tab-pane fade in active">
                <form id="add_job_post_frm" method="post" action="#" id="">
                    <div class="col-xs-12 form-group margin-top-20 noRightPadding noLeftPadding">
                        <div class="col-xs-1 line-height-30 noRightPadding noLeftPadding line-height-35">
                            <label for="item_title">شغل</label>
                        </div>
                        <div class="col-xs-11 noRightPadding noLeftPadding">
                            <div class="pull-right col-xs-10 noPadding line-height-35">
                                {{$job->job->title}}
                            </div>
                            <div class="pull-right margin-right-10 line-height-35 height-35 ">
                                <label for="item_title" class="pull-right">سمت</label>
                            </div>
                            <div class="pull-right">
                                <input type="text" name="amount" id="amount" class="form-control line-height-30 height-30 width-50" placeholder="{{trans('app.amount')}}" value="{{$job->amount}}"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 form-group noRightPadding noLeftPadding">
                        <div class="col-xs-1 line-height-30 noRightPadding noLeftPadding"><label
                                    for="item_title">{{trans('app.description')}}</label></div>
                        <div class="col-xs-11 line-height-30 noRightPadding noLeftPadding">
                            <textarea class="form-control" rows="2" name="comment" id="comment" placeholder="{{trans('app.description')}}">{{$job->description}}</textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div id="position" class="tab-pane fade">
                {{--<div class="col-xs-12 margin-top-10">--}}
                {{--<a href="{!! route('modals.add_new_post') !!}" class="jsPanelsPositions btn btn-default pull-left jspa btn-primary btn fa fa-plus" item="{{$item_id}}"></a>--}}
                {{--</div>--}}
                <table class="table margin-top-20" style="width: 100%;">
                    <thead>
                    <th class="col-xs-4 text-right">{{trans('org_chart.job_title')}}</th>
                    <th class="col-xs-3 text-right">{{trans('org_chart.clerk')}}</th>
                    <th class="col-xs-2 text-right">{{trans('org_chart.extra_title')}}</th>
                    <th class="col-xs-2 text-right">{{trans('org_chart.work_place')}}</th>
                    <th class="col-xs-1 text-right">{{trans('app.operations')}}</th>
                    </thead>
                    <tbody id="list_positions">
                    @foreach($job->posts as $post)
                        <tr>
                            <td class="col-xs-4">{{isset($job->job->title) ? $job->job->title : ''}}</td>
                            <td class="col-xs-3">{{isset($post->users[0]) ? $post->users[0]->user->Name.' '.$post->users[0]->user->Family : ''}}</td>
                            <td class="col-xs-2">{{$post->extra_title}}</td>
                            <td class="col-xs-2">{{$post->location}}</td>
                            <td class="col-xs-1">
                                <i class="fa fa-remove margin-left-10 pointer remove_job_post" ref="{{$post->id}}"
                                   add="{{ route('hamahang.org_chart.delete_item_job_post') }}"></i>
                                <i class="fa fa-edit pointer edit_job jsPanelsEditPositions"
                                   post="{{enCode($post->id)}}"></i>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div id="add_position" class="tab-pane fade">
                <div class="bas_inside_tabs container-fluid">
                    <div id="alert_insert_post" class="mt-5"></div>
                    <form id="form_add_new_chart_item_post" method="post" action="#">
                        <div class="form-group col-md-12 mt-5">
                            <label>
                                <span class="required">*</span>
                                <span>عنوان سمت :</span>
                            </label>
                            <input name="new_post_title" id="insert_new_post_title" class="form-control" type="text"/>
                        </div>
                        <div class="form-group col-md-12">
                            <label>
                                <span>توضیحات سمت :</span>
                            </label>
                            <textarea name="new_post_description" id="insert_new_post_description"
                                      class="form-control"></textarea>
                        </div>


                    </form>
                </div>
            </div>
            <div id="organs" class="tab-pane fade">
                <div class="bas_inside_tabs container-fluid">
                    <table id="datatable_ItemChildrenGrid" class="table">
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
                        <div class="form-group col-md-12">
                            <label>
                                <span class="required">*</span>
                                <span>عنوان واحد سازمانی :</span>
                            </label>
                            <input name="new_item_title" id="new_item_title_org" class="form-control" type="text"/>
                        </div>
                        <div class="form-group col-md-12">
                            <label>
                                <span>توضیحات واحد سازمانی :</span>
                            </label>
                            <textarea name="new_item_description" id="new_item_description_org"
                                      class="form-control"></textarea>
                        </div>
                        <div class="clearfix"></div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>