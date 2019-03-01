<div class="modal fade fade_1s" id="item_details" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span>نمایش اطلاعات واحد سازمانی </span>:
                    <span class="bg-warning" id="modal_header_item_title" style="padding:2px 10px; margin-right: 10px;"></span>
                </h4>
            </div>
            <div class="modal-body">
                <!---------------->
                <div id="tab" class="container table-bordered" style="width: 95%">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#t1" data-toggle="tab">
                                <i class="fa fa-edit"></i>
                                <span>ویرایش</span>
                            </a>
                        </li>
                        <li>
                            <a href="#t3" data-toggle="tab">سمت ها</a>
                        </li>
                        <li>
                            <a href="#t4" data-toggle="tab">
                                <i ></i>
                                <span>افزودن سمت</span>
                            </a>
                        </li>
                        <li>
                            <a href="#t5" data-toggle="tab">واحدها</a>
                        </li>
                        <li>
                            <a href="#t6" data-toggle="tab">
                                <i ></i>
                                <span>افزودن واحد</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content active">
                        <div class="tab-pane active" id="t1" style="padding: 20px">
                            <div class="panel panel-info col-md-12">
                                <div class="panel-body" id="item_edit">
                                    <form id="edit_chart_item_form">
                                        <input type="hidden" id="form_edit_item_item_id" name="item_id" value=""/>
                                        <div class="form-group col-md-12">
                                            <label>
                                                <span class="required">*</span>
                                                <span>عنوان</span>
                                            </label>
                                            <input name="item_title" id="item_title" class="form-control"
                                                   placeholder="">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>
                                                <span>توضیحات</span>
                                            </label>
                                            <textarea name="item_description" id="item_description"
                                                      class="form-control" placeholder="">
                                                </textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>
                                                <span class="required">*</span>
                                                <span>بالادستی :</span>
                                            </label>
                                            <select id="chart_item_select_parents"
                                                    name="item_parent_id"
                                                    class="chosen-rtl col-xs-11"
                                                    data-placeholder="{{trans('tasks.select_some_options')}}"
                                            >
                                                <option id="default_parent_item" value=""></option>
                                            </select>
                                        </div>
                                        <div class="clearfix"></div>

                                        <hr class="hr">
                                        <button class="btn btn-warning pull-left" type="button" onclick="UpdateChartItem()">
                                            <i ></i>
                                            <span>ذخیره تغییرات</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane " id="t3" style="padding: 20px">
                            <div class="panel panel-info col-md-12">
                                <div class="panel-body" id="item_posts">

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="t4" style="padding: 20px">
                            <div class="panel panel-info well-sm row-fluid">
                                <div class="col-xs-12">
                                    <form id="add_new_chart_item_post_form">
                                        <input type="hidden" id="form_add_post_for_item_id" name="item_id" value=""/>
                                        <div class="form-group col-md-12">
                                            <label>
                                                <span class="required">*</span>
                                                <span>عنوان سمت :</span>
                                            </label>
                                            <input name="new_post_title" id="new_post_title" class="form-control" type="text"  />
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>
                                                <span>توضیحات سمت :</span>
                                            </label>
                                            <textarea name="new_post_description" id="new_post_description" class="form-control"  ></textarea>
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr class="hr">
                                        <button class="btn btn-info pull-left" type="button" onclick="new_post()">
                                            <i ></i>
                                            <span> ثبت</span>
                                        </button>
                                    </form>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="tab-pane" id="t5" style="padding: 20px">
                            <div class="panel panel-info col-md-12">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="ItemChildrenGrid"  class="table table-striped table-bordered dt-responsive nowrap display" style="text-align: center" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th data-align="right" data-header-align="right"
                                                        data-column-id="id" data-type="numeric"
                                                        data-identifier="true">#
                                                    </th>
                                                    <th data-align="right" data-header-align="right"
                                                        data-column-id="title">عنوان
                                                    </th>
                                                    <th data-align="right" data-header-align="right"
                                                        data-column-id="description">توضیحات
                                                    </th>
                                                    <th data-align="center" data-header-align="center"
                                                        data-column-id="created_at">ایجاد
                                                    </th>
                                                    <th data-align="center" data-header-align="center"
                                                        data-column-id="updated_at"> تغییر
                                                    </th>
                                                    {{--<th data-align="left" data-header-align="left"--}}
                                                        {{--data-column-id="link" data-formatter="link"--}}
                                                        {{--data-sortable="false">عملیات--}}
                                                    {{--</th>--}}
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="t6" style="padding: 20px">
                            <div class="panel panel-info well-sm row-fluid">
                                <div class="col-xs-12">
                                    <div id="add_new_chart_item_form_error"></div>
                                    <form id="add_new_chart_item_form">
                                        <input type="hidden" id="form_add_chart_id" name="chart_id" value=""/>
                                        <input type="hidden" id="form_add_item_id" name="item_id" value=""/>
                                        <div class="form-group col-md-12">
                                            <label>
                                                <span class="required">*</span>
                                                <span>عنوان واحد سازمانی :</span>
                                            </label>
                                            <input name="new_item_title" id="new_item_title" class="form-control" type="text"  />
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>
                                                <span>توضیحات واحد سازمانی :</span>
                                            </label>
                                            <textarea name="new_item_description" id="new_item_description" class="form-control"  ></textarea>
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr class="hr">
                                        <button class="btn btn-info pull-left" type="button" onclick="create_new_node()">
                                            <i ></i>
                                            <span> ثبت</span>
                                        </button>
                                    </form>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!---------------->
            </div>
            <div class="modal-footer" style="background-color: #0d3349;border-color: white;border-width: 10px;">
                <div id="current_item_info"
                     style="background-color: #0d3349;text-align: right;color: honeydew"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade fade_1s" id="modify_chart_info_modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span> ویرایش اطلاعات چارت :{{$Chart->title}} </span>
                </h4>
            </div>
            <div class="modal-body">
                <!---------------->
                <div id="add_new_root_chart_item_form_error"></div>
                <div class="form-group col-md-12">
                    <label>
                        <span class="required">*</span>
                        <span>عنوان</span>
                    </label>
                    <input name="edit_chart_title" id="edit_chart_title" class="form-control" required placeholder="" value="{{$Chart->title}}" />
                </div>
                <div class="form-group col-md-12">
                    <label> <span>توضیحات</span></label>
                    <textarea name="edit_chart_description" id="edit_chart_description" class="form-control" placeholder="">{{$Chart->description}}</textarea>
                </div>
                <input type="hidden" name="edit_ChartID" id="edit_ChartID" value="{{$Chart->id}}">
                <div class="clearfix"></div>
                <!---------------->
            </div>
            <div class="modal-footer">
                <div id="current_item_info">
                    <button class="btn btn-info" type="button" onclick="modify_chart_info()">
                        <i ></i>
                        <span>ثبت و ذخیره سازی</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade fade_1s" id="add_root_item_modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="#" id="form_add_root_item" class="form_add_root_item">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <span> افزودن واحد ریشه : </span>
                    </h4>
                </div>
                <div class="modal-body">
                    <!---------------->
                    <div id="add_new_root_chart_item_form_error"></div>
                    <div class="form-group col-md-12">
                        <label>
                            <span class="required">*</span>
                            <span>عنوان</span>
                        </label>
                        <input name="root_item_title" id="root_item_title" class="form-control" required placeholder="">
                    </div>
                    <div class="form-group col-md-12">
                        <label> <span>توضیحات</span></label>
                        <textarea name="root_item_description" id="root_item_description" class="form-control" placeholder=""></textarea>
                    </div>
                    <div class="clearfix"></div>
                    <input type="hidden" name="Organs_ID" value="{{$Chart->org_organs_id}}">
                    <input type="hidden" name="Charts_ID" value="{{$Chart->id}}">
                    <!---------------->
                </div>
                <div class="modal-footer">
                    <div id="current_item_info">
                        <button class="btn btn-primary" type="button" onclick="create_new_root_item()">{{trans('app.confirm')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>