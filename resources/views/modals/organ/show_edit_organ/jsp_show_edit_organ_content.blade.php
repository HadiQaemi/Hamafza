<style>
    table.dataTable{
        width:100% !important;
    }
    .item_parent_id .select2.select2-container{
        width: 100% !important;
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
                        <div class="form-group col-xs-12 noRightPadding noLeftPadding">
                            <input type="hidden" value="{{$item_id}}" name="item_id" />
                            <div class="col-xs-1 line-height-30 noRightPadding noLeftPadding"><label for="item_title">{{trans('app.title')}}</label></div>
                            <div class="col-xs-11 noRightPadding noLeftPadding"><input type="text" name="item_title" id="item_title" class="form-control" value="{{$title}}"/></div>
                        </div>
                        <div class="form-group col-xs-12 noRightPadding noLeftPadding">
                            <div class="col-xs-1 line-height-30 noRightPadding noLeftPadding"><label for="item_description">{{trans('app.description')}}</label></div>
                            <div class="col-xs-11 line-height-30 noRightPadding noLeftPadding">
                                <textarea type="text" name="item_description" id="item_description" class="form-control">{{$description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 margin-top-20 noRightPadding noLeftPadding">
                            <div class="col-xs-1 line-height-30 noRightPadding noLeftPadding"><label for="item_parent_id">{{trans('org_chart.up')}}</label></div>
                            <div class="col-xs-11 noRightPadding noLeftPadding item_parent_id">
                                <select id="" name="item_parent_id" class="form-control select2_auto_complete_chart line-height-35 height-35">
                                    <option value="{{$parent[0]}}">{{$parent[1]}}</option>
                                </select>
                                {{--<select id="item_parent_id" name="item_parent_id" class="col-xs-12 js-states form-control">--}}
                                    {{--<option value="{{$parent[0]}}">{{$parent[1]}}</option>--}}
                                {{--</select>--}}
                            </div>
                        </div>
                        <div class="form-group col-xs-12 noRightPadding noLeftPadding">
                            <div class="col-xs-1 line-height-30 noRightPadding noLeftPadding"><label for="unit_missions">{{trans('org_chart.missions')}}</label></div>
                            <div class="col-xs-11 noRightPadding noLeftPadding">
                                <select id="unit_missions" name="unit_missions[]" class="form-control select2_auto_complete_missions line-height-35 height-35" multiple="multiple"></select>
                            </div>
                            {{--<div class="col-xs-1"><a class="btn btn-primary fa fa-plus" id="add_mission"></a></div>--}}
                        </div>
                        <div class="form-group col-xs-12" id="mission_list"></div>
                    </div>
                </form>
            </div>
            <div id="jobs" class="tab-pane fade">
                <form id="add_job_post_frm" method="post" action="#" id="">
                    <div class="col-xs-12 form-group margin-top-20 noRightPadding noLeftPadding">
                        <div class="col-xs-1 line-height-30 noRightPadding noLeftPadding"><label for="item_title">شغل</label></div>
                        <div class="col-xs-11 noRightPadding noLeftPadding">
                            <div class="pull-right col-xs-10 noPadding">
                                <input type="hidden" value="{{$item_id}}" name="unit_id" />
                                <select name="job" id="job" class="form-control select2_auto_complete_onet_jobs line-height-35 height-35"></select>
                            </div>
                            <div class="pull-right margin-right-10 line-height-35 height-35 ">
                                <label for="item_title" class="pull-right">تعداد</label>
                            </div>
                            <div class="pull-right">
                                <input type="text" name="amount" id="amount" class="form-control line-height-30 height-30 width-50" placeholder="سمت"/>
                            </div>
                            <div class="pull-left line-height-35">
                                <a class="fa fa-plus pointer add_job_post"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 form-group noRightPadding noLeftPadding">
                        <div class="col-xs-1 line-height-30 noRightPadding noLeftPadding"><label for="item_title">{{trans('app.description')}}</label></div>
                        <div class="col-xs-11 line-height-30 noRightPadding noLeftPadding"><textarea class="form-control" rows="2" name="comment" id="comment" placeholder="{{trans('app.description')}}"></textarea></div>
                    </div>
                </form>
                <div class="col-xs-12 form-group margin-top-20 noRightPadding noLeftPadding">
                    <table id="list_job_post" class="table noRightPadding noLeftPadding">
                        <thead>
                            <tr>
                                <td class="col-xs-7 border-bottom">{{trans('app.title')}}</td>
                                <td class="col-xs-4 border-bottom">{{trans('org_chart.num_post')}}</td>
                                <td class="col-xs-1 border-bottom">{{trans('app.operations')}}</td>
                            </tr>
                        </thead>
                        @foreach($jobs as $job)
                            <tr>
                                <td class="col-xs-7 border-bottom">{{isset($job->job->title) ? $job->job->title : ''}}</td>
                                <td class="col-xs-4 border-bottom">{{$job->amount}}</td>
                                <td class="col-xs-1 border-bottom">
                                    <i class="fa fa-remove margin-left-10 pointer remove_job" ref="{{$job->id}}" add="{{ route('hamahang.org_chart.delete_item_job') }}"></i>
                                    <i class="fa fa-edit pointer jsPanelsEditJob" ref="{{$job->id}}"  href="{!! route('modals.add_new_post') !!}"></i>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div id="position" class="tab-pane fade">
                {{--<div class="col-xs-12 margin-top-10">--}}
                    {{--<a href="{!! route('modals.add_new_post') !!}" class="jsPanelsPositions btn btn-default pull-left jspa btn-primary btn fa fa-plus" item="{{$item_id}}"></a>--}}
                {{--</div>--}}
                <table class="table margin-top-10" style="width: 100%;">
                    <thead>
                        <td class="col-xs-4">{{trans('org_chart.job_title')}}</td>
                        <td class="col-xs-3">{{trans('org_chart.clerk')}}</td>
                        <td class="col-xs-2">{{trans('org_chart.extra_title')}}</td>
                        <td class="col-xs-2">{{trans('org_chart.work_place')}}</td>
                        <td class="col-xs-1">{{trans('app.operations')}}</td>
                    </thead>
                    <tbody id="list_positions">
                    @foreach($jobs as $job)
                        @foreach($job->posts as $post)
                            <tr>
                                <td class="col-xs-4">{{isset($job->job->title) ? $job->job->title : ''}}</td>
                                <td class="col-xs-3">{{isset($post->users[0]) ? (isset($post->users[0]->staff->first_name) ? $post->users[0]->staff->first_name : '').' '.(isset($post->users[0]->staff->last_name) ? $post->users[0]->staff->last_name : '') : ''}}</td>
                                <td class="col-xs-2">{{$post->extra_title}}</td>
                                <td class="col-xs-2">{{$post->location}}</td>
                                <td class="col-xs-1">
                                    <i class="fa fa-remove margin-left-10 pointer remove_job_post" ref="{{$post->id}}" add="{{ route('hamahang.org_chart.delete_item_job_post') }}"></i>
                                    <i class="fa fa-edit pointer edit_job jsPanelsEditPositions" post="{{enCode($post->id)}}" ></i>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
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
<script>
    $(".select2_auto_complete_chart").select2({
        minimumInputLength: 3,
        dir: "rtl",
        width: "100%",
        tags: false,
        ajax: {
            url: '{{URL::route('auto_complete.sibling_chart_items')}}',
            dataType: "json",
            type: "POST",
            quietMillis: 150,
            data: function (term) {
                return {
                    term: term,
                    organ: {{$item_id}}
                };
            },
            results: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.text,
                            id: item.id
                        }
                    })
                };
            }
        }
    });
</script>