<div class="row" >
    <div class="col-xs-12" >

    </div>
   <div class="base_add_user">
       <div id="success_msg_area_id"></div>
       <div id="error_msg_add_user"></div>
       <div class="space-4"></div>
       <form id="form_created_new">
       <table class=" col-xs-12">
        <tr>
            <td class="col-xs-2">
                <label class=""><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i> نام : </label>
            </td>
            <td class="col-xs-10">
                <input id="Name" name="Name" type="text" class="form-control"/>
            </td>
        </tr>
        <tr>
            <td class="col-xs-2">
                <label class="control-label"><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i> نام خانوادگی : </label>
            </td>
            <td class="col-xs-10">
                <input id="Family" name="Family" type="text" class="form-control"/>
            </td>
        </tr>
        <tr>
            <td class="col-xs-2">
                <label class="control-label"><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i> نام کاربری : </label>
            </td>
            <td class="col-xs-10">
                <input id="Uname" name="Uname" type="text" class="form-control"/>
            </td>
        </tr>
        <tr>
            <td class="col-xs-2">
                <label class="control-label"><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i> رمز ورود : </label>
            </td>
            <td class="col-xs-10">
                <input id="password" name="password" type="password" class="form-control" autocomplete="off"/>
            </td>
        </tr>
        <tr>
            <td class="col-xs-2">
                <label class="control-label"><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i>تکرار رمز ورود : </label>
            </td>
            <td class="col-xs-10">
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="off" class="form-control"/>
            </td>
        </tr>
        <tr>
            <td class="col-xs-2">
                <label class="control-label"><i style="font-size: 8px;color: #b50707;" class="fa fa-asterisk"></i>ادرس ایمیل : </label>
            </td>
            <td class="col-xs-9">
                <div class="col-xs-8" style="padding-right: 0px;">
                    <input id="Email" name="Email" type="text" class="form-control"/>
                </div>
                <div class="col-xs-4">
                    <input id="Email_confirmed" name="Email_confirmed" type="checkbox"/>
                    <label class="control-label"></i>ایمیل تایید شده است  </label>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="col-xs-12">
                <span style="color: blue; font-size: 14px;">اختصاص نقش به کاربر: </span>
            </td>
        </tr>
        <tr>
            <td class="col-xs-2">
                <label class="control-label">{{trans('menus.add_role')}}</label>
            </td>
            <td class="col-xs-10">
                <select name="roles_list[]" multiple="multiple" class="form-control roles_list"></select>
            </td>
        </tr>
    </table>
       </form>
   </div>
</div>

