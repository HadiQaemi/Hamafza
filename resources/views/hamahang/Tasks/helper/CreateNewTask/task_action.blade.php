<div class="col-lg-12 " dir="rtl">


    <table class="table table-striped">
        <tr>
            <td><label for="title">وضعیت</label></td>
            <td>
                <div class="form-inline">
                    <input type="radio" class="" name="status" id="r1"/>
                    <label for="r1">{{trans('tasks.status_not_started')}}</label>
                    <input type="radio" class="" name="status" id="r2" />
                    <label for="r2">{{trans('tasks.status_started')}} - درصد پیشرفت</label>
                    <input type="text" style="width: 25px;padding: 1px;text-align: center" class="form-control" name="percent"/>
                    <input type="radio" class="" name="status" id="r1"/>
                    <label for="r1">{{trans('tasks.status_done')}}</label>
                    <input type="radio" class="" name="status" id="r1"/>
                    <label for="r1">{{trans('tasks.status_finished')}}</label>
                    <input type="radio" class="" name="status" id="r1"/>
                    <label for="r1">متوقف</label>
                </div>
            </td>

        </tr>
        <tr>
            <td><label for="desc">پیگیری</label></td>
            <td>
                <div class="form-inline">
                    <input type="checkbox" class="" name="" id="r1"/>
                    <label for="">درخواست پیگیری</label>
                    <input type="text" class="form-control" value="توضیح ..." name="desc" id="desc" id="title"
                           style="width: 50% "/>
                </div>
            </td>
        </tr>
        <tr>
            <td><label for="">کیفیت انجام</label></td>
            <td>
                <div class="form-inline">
                    <input type="radio" class="" name="quality" id="r1" value="1"/>
                    <label for="r1">عالی</label>
                    <input type="radio" class="" name="quality" id="r2" value="2"/>
                    <label for="r2">خوب</label>
                    <input type="radio" class="" name="quality" id="r2" value="3"/>
                    <label for="r2">متوسط</label>
                    <input type="radio" class="" name="quality" id="r2" value="4"/>
                    <label for="r2">ضعیف</label>
                    <input type="radio" class="" name="quality" id="r2" value="5"/>
                    <label for="r2">بسیارضعیف</label>
                    <input type="radio" class="" name="quality" id="r2" value="0"/>
                    <label for="r2">تعیین نشده</label>

                </div>
            </td>
        </tr>
        <tr>
            <td><label for="desc">بازگردانی</label></td>
            <td>
                <div class="form-inline">
                    <input type="checkbox" class="" name="" id="r1"/>
                    <label for="">بازگردانی به واگذارکننده</label>
                    <input type="text" class="form-control" value="توضیح ..." name="desc" id="desc" id="title"
                           style="width: 50% "/>
                    <br/>
                    <label for="">واگذاری به </label>
                    <input type="text" class="form-control" value="توضیح ..." name="desc" id="desc" id="title"
                           style="width: 50% "/>
                    <span class="glyphicon glyphicon-user " aria-hidden="false"></span>
                </div>
            </td>
        </tr>
        <tr>
            <td><label for="">بسته کاری</label></td>
            <td>
                <div class="form-inline">
                    <select class="form-control">
                        <option></option>
                        <option>بسته کاری</option>
                        <option></option>
                    </select>
                    <label for="keywords">کلیدواژه ها</label>
                    <input type="text" class="form-control" name="keywords" id="keywords" style="width: 60%"/>
                </div>
            </td>
        </tr>
        <tr>
            <td><label for="">برآورد مدت</label></td>
            <td>
                <div class="form-inline">
                    <input type="text" style="width: 10px;" class="form-control" name="predicted_time"/>
                    <select class="form-control">
                        <option>ساعت</option>
                        <option>دقیقه</option>
                        <option>روز</option>
                    </select>

                    <label for="">شناور</label>

                    <select class="form-control">
                        <option>این هفته</option>
                        <option></option>
                        <option></option>
                    </select>

                    <label for="">تخصیص وقت</label>
                    <input type="text" style="width: 20px;" class="form-control" name=""/>
                    <label for="">از</label>
                    <input type="text" style="width: 10px;" class="form-control" name=""/>
                    <label for="">تا</label>
                    <input type="text" style="width: 10px;" class="form-control" name=""/>
                </div>
            </td>
        </tr>
        <tr>
            <td><label for="date">توضیح</label></td>
            <td>
                <input type="text" class="form-control " id="datepicker" name="time_desc"/>
            </td>
        </tr>


    </table>
</div>
