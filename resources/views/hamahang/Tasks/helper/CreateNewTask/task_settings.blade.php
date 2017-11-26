<table class="table table-striped">
    <tr>
        <td><label for="title">اطلاع رسانی</label></td>
        <td>
            <div class="form-inline">
                <input type="checkbox" class="form-control" name="importance"/>
                <label for="r1">ارسال پیامک</label>
                <input type="checkbox" class="form-control" name="importance"/>
                <label for="r1">ارسال ایمیل</label>
            </div>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>

            <div class="form-inline">
                <input type="radio" class="" name="type" id="r1" onclick="do_disable()"/>
                <label for="r1">اکنون</label>
                <input type="radio" class="" name="type" id="r2" onclick="do_enable()"/>
                <label for="r1">در تاریخ</label>
                <input type="text" class="form-control" name="manager" id="date1" disabled="disabled"/>
                <span class="glyphicon glyphicon-calendar " aria-hidden="false"></span>
                <label for="r1">در ساعت</label>
                <input type="text" class="form-control" name="manager" id="time1" disabled="disabled"/>
                <span class="glyphicon glyphicon-time" aria-hidden="false"></span>
            </div>

        </td>
    </tr>
    <tr>
        <td><label for="desc">تکرار(آزمایشی)</label></td>
        <td>
            <div id="disable_area">
                <div class="form-inline">
                    <select class="form-control">
                        <option>هفتگی</option>
                        <option>روزانه</option>
                        <option>ساعتی</option>
                    </select>
                    <label for="use_type1">هر</label>
                    <select class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                    <label for="use_type1">در</label>
                    <input type="checkbox" class="form-control" name="manager" id="manager"/>
                    <label for="use_type1">شنبه</label>
                    <input type="checkbox" class="form-control" name="manager" id="manager"/>
                    <label for="use_type1">یکشنبه</label>
                    <input type="checkbox" class="form-control" name="manager" id="manager"/>
                    <label for="use_type1">دوشنبه</label>
                    <input type="checkbox" class="form-control" name="manager" id="manager"/>
                    <label for="use_type1">سه شنبه</label>
                    <input type="checkbox" class="form-control" name="manager" id="manager"/>
                    <label for="use_type1">چهارشنبه</label>
                    <input type="checkbox" class="form-control" name="manager" id="manager"/>
                    <label for="use_type1">پنجشنبه</label>
                    <input type="checkbox" class="form-control" name="manager" id="manager"/>
                    <label for="use_type1">جمعه</label>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <div class="form-inline">

                <label for="use_type1">زمان شروع</label>
                <input type="text" class="form-control" name="manager" id="form-field-tags" width="50px"/>
            </div>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <div class="form-inline">

                <label for="use_type1">زمان پایان</label>
                <input type="radio" class="" name="timeout" id=""/>
                <label for="use_type1">هیچوقت</label>
                <input type="radio" class="" name="timeout" id=""/>
                <label for="use_type1">در تاریخ</label>
                <input type="text" class="form-control " name="manager" id="manager" width="50px"/>
            </div>
        </td>
    </tr>
    <tr>
        <td><label for="keywords">فرم(آزمایشی)</label></td>
        <td>
            <div class="form-inline">
                <select class="form-control">
                    <option>انتخاب کنید</option>
                    <option></option>
                    <option></option>
                </select>
            </div>
        </td>
    </tr>

</table>
