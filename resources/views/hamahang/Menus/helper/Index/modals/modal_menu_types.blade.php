<div class="modal fade" tabindex="-1" id="menu_types_modal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span>انواع منو </span>:
                    <span class="bg-warning" id="modal_header_item_title" style="padding:2px 10px; margin-right: 10px;"></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="container " style="width: 95%">
                    <div id="menTypeMsg"></div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#addmenuType"  data-toggle="tab">اطلاعات منو</a></li>
                        <li><a href="#menutpelist"  data-toggle="tab"> لیست </a></li>

                    </ul>
                    <div class="tab-content">
                    <div id="addmenuType" class="col-xs-12 tab-pane fade in active default-options">
                        <form id="menyTypeForm">


                            <table class="table table-bordered col-xs-12">
                                <tr>
                                    <td class="col-xs-2">عنوان</td>
                                    <td class="col-xs-10"><input type="text" class="form-controll" name="title"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <button type="button" id="add-menu-type" value="save" class="btn btn-info pull-left" type="button">
                                            <i class="glyphicon  glyphicon-save-file bigger-125 pull-left"></i>
                                            <span>ثبت</span>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden" name="edit_id" value="0"/>
                        </form>
                    </div>
                        <div id="menutpelist" class="col-xs-12 tab-pane fade in  default-options">
                            <table id="menuTypesGrid" class="table table-striped table-bordered col-xs-12 dt-responsive nowrap display">
                                <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>عنوان</th>
                                    <th>عملیات</th>
                                </tr>

                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>