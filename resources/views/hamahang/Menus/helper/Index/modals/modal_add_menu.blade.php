<div class="modal fade"  id="menu_add" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span>منوی جدید </span>:
                    <span class="bg-warning" id="modal_header_item_title" style="padding:2px 10px; margin-right: 10px;"></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="container " style="width: 95%">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#menuInfo"  data-toggle="tab">اطلاعات منو</a></li>
                        <li><a href="#menuAtter"  data-toggle="tab">ویژگی ها</a></li>
                        <li><a href="#menuAccess"  data-toggle="tab">دسترسی ها</a></li>
                        <li><a href="#onjsTree"  data-toggle="tab"> jsTree</a></li>
                        <!--<li><a href="#dynamicMenu"  data-toggle="tab">فرزندهای منو به صورت داینامیک</a></li>-->
                    </ul>
                <form  id="add_new_menu_form" class="form">
                    <div id="menuErrorMsg"></div>
                    <div class="tab-content">
                        <div class="col-xs-12 tab-pane fade in active default-options" id="menuInfo">
                            <table class="table  col-xs-12">
                                <tr>
                                    <td class="col-xs-3"><label>عنوان</label></td>
                                    <td class="col-xs-9"><input type="text" name="title" class="form-control"> </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-3"><label>از نوع</label></td>
                                    <td class="col-xs-9">
                                        <select id="menu-types"  name="menu_type_id"  data-placeholder="انتخاب نمایید...">
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-3"><label>گزینه بالادستی</label></td>
                                    <td class="col-xs-9">
                                        <select id="parentId"  name="parent_id" class="form-control" data-placeholder="انتخاب نمایید...">
                                        </select>
                                    </td>
                                </tr>
                                <tr>

                                    <td class="col-xs-3"><label>لینک منو</label></td>
                                    <td class="col-xs-9">
                                        <label><input type="radio" name="menu_link_type" checked="checked" value="1">داخلی</label>
                                        <label><input type="radio" name="menu_link_type" value="2">خارجی</label>
                                      </td>
                                </tr>
                                <tr  id="hrefRow">

                                    <td class="col-xs-3"><label>href</label></td>
                                    <td class="col-xs-9">

                                        <input type="text" name="href"   class="form-control">
                                        <label>
                                            <input type="radio" value="1" checked name="href_type">
                                            مستقیم
                                        </label>
                                        <label>
                                            <input type="radio" value="2"  name="href_type">
                                            نسبی
                                        </label>
                                    </td>

                                </tr>
                                <tr id="routeRow">

                                    <td class="col-xs-3"><label>انتخاب  Route</label></td>
                                    <td class="col-xs-9">
                                          <select name="route_title"  id="route_title">


                                              </select>

                                </tr>
                              <!--  <td class="col-xs-3"><label>دسترسی </label></td>
                                <td class="col-xs-9">

                                    <input type="text" name="permission" class="form-control"> </td>
                                </tr>-->
                                <!--<tr>
                                    <td class="col-xs-3"><label>استفاده از sql برای ساختار داینامیک</label></td>
                                    <td class="col-xs-3">
                                        <input type="checkbox" name="is_relation" class="checkbox">
                                    </td>
                                </tr>-->
                                </table>
                        </div>
                        <div class="col-xs-12 tab-pane fade in  default-options" id="menuAtter">
                            <table class="table  col-xs-12">
                                <tr>
                                    <td class="col-xs-3"><label> نحوه باز شدن منو</label></td>
                                    <td class="col-xs-9">
                                        <input name="a_target" type="radio" id="a_target1"
                                               value="0">
                                        در همین صفحه


                                        <input name="a_target" type="radio" id="a_target2"
                                               value="2">
                                        در صفحه جدید
                                    </td>
                                </tr>

                                <tr>
                                    <td class="col-xs-3"><label>class( در css)</label></td>
                                    <td class="col-xs-9">

                                        <input type="text" name="id_name" class="form-control"> </td>
                                </tr>
                                <tr>
                                    <td class="col-xs-3"><label>id( درhtml)</label></td>
                                    <td class="col-xs-9">

                                        <input type="text" name="class_name" class="form-control"> </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-xs-12 tab-pane fade in  default-options" id="menuAccess">
                            <table class="col-md-12">
                                <tr>
                                    <td class="col-md-2"><label>نقش</label></td>
                                    <td class="col-md-10">
                                        <select name="menu_role" multiple>

                                        </select>
                                    </td>

                                </tr>
                                <tr>
                                    <td class="col-md-2"><label>کاربران</label></td>
                                    <td class="col-md-10">
                                        <select name="menu_users" multiple>

                                        </select>
                                    </td>

                                </tr>
                                </table>


                            </div>
                        <div class="col-xs-12 tab-pane fade in  default-options" id="onjsTree">
                            <table class="table  col-xs-12">
                                <tr>
                                    <td class="col-xs-3"><label>پارا متر های li</label></td>
                                    <td class="col-xs-9">
                                        <p id="id_nameHelpBlock" class="form-text text-muted">
                                            jsTree
                                        </p>
                                        <textarea name="li_atrr" class="form-control"> </textarea></td>
                                </tr>
                                <tr>
                                    <td class="col-xs-3"><label>پارا متر های  تگ a</label></td>
                                    <td class="col-xs-9">
                                        <p id="id_nameHelpBlock" class="form-text text-muted">
                                         sTree
                                        </p>
                                        <textarea name="a_attr" class="form-control"> </textarea></td>
                                </tr>
                                <tr>
                                    <td class="col-xs-3"><label>پارامترهای(state)</label></td>
                                    <td class="col-xs-9">
                                        <p id="id_nameHelpBlock" class="form-text text-muted">
                                       مربوط به باز یا ببسته بودن این منو در هنگام نمایش
                                        </p>
                                        <textarea name="state" class="form-control"> </textarea></td>
                                </tr>
                                </table>
                        </div>
                        <div class="col-xs-12 tab-pane fade in  default-options" id="dynamicMenu">
                            <table class="table  col-xs-12">

                                <tr>
                                    <td class="col-xs-3"><label>sql</label></td>
                                    <td class="col-xs-9">
                                        <p id="id_nameHelpBlock" class="form-text text-muted">
                                            <b>
                                                توجه داشته باشید که لینک هایی که با استفاده ازsql وارد شده در این فیلد ساخته می شوند به عنوان فرزندان منویی که هم اکنون ساخته می شود در نظر گرفته خواهد شد
                                            </b>
                                           توجه  داشته باشید که اگر از این کویری برای jstree استفاده می کنید باید سه فیلد id( یک رشته) و فیلد text برای عنوان منو  در خروجی ن داشته باشید
                                        </p>
                                        <textarea name="custom_sql" class="form-control"> </textarea></td>
                                </tr>

                                </table>
                        </div>
                    </div>

                        <input type="hidden" name="edit_id" value="0"/>
                </form>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" name="saveMenu" id="savedMenu" value="save"
                        class="btn btn-info"
                        type="button">
                    <i class="glyphicon  glyphicon-save-file bigger-125"></i>
                    <span>ذخیره</span>
                </button>
            </div>
        </div>
    </div>
</div>