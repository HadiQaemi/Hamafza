@php
    $array_weekly_weekdays = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه', ];
    $array_weeks = ['اولین', 'دومین', 'سومین', 'چهارمین', 'آخرین', ];
    $array_monthly_months = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند', ];
@endphp
{!! Form::model(null, ['route' => ['hamahang.scheduler.create'], 'class' => 'form-inline', 'id' => '']) !!}
<div style="float: right; height: 250px;">
    <div class="input-group pull-right" style="margin: 0 0 5px 5px;">
        <span class="input-group-addon" style="padding: 0 5px 0 0; margin: 0 5px 0 0;">
            {!! Form::radio('type', 0, false, ['id' => 'type_0', 'data-target' => '', 'class' => 'form-control']) !!}
        </span>
        <span class="input-group-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
            <label for="type_0">یک مرتبه</label>
        </span>
    </div>
    <div class="clear"></div>
    <div class="input-group pull-right" style="margin: 0 0 5px 5px;">
        <span class="input-group-addon" style="padding: 0 5px 0 0; margin: 0 5px 0 0;">
            {!! Form::radio('type', 1, false, ['id' => 'type_1', 'data-target' => 'type_daily', 'class' => 'form-control']) !!}
        </span>
        <span class="input-group-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
            <label for="type_1">روزانه</label>
        </span>
    </div>
    <div class="clear"></div>
    <div class="input-group pull-right" style="margin: 0 0 5px 5px;">
        <span class="input-group-addon" style="padding: 0 5px 0 0; margin: 0 5px 0 0;">
            {!! Form::radio('type', 2, false, ['id' => 'type_2', 'data-target' => 'type_weekly', 'class' => 'form-control']) !!}
        </span>
        <span class="input-group-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
            <label for="type_2">هفتگی</label>
        </span>
    </div>
    <div class="clear"></div>
    <div class="input-group pull-right" style="margin: 0 0 5px 5px;">
        <span class="input-group-addon" style="padding: 0 5px 0 0; margin: 0 5px 0 0;">
            {!! Form::radio('type', 3, false, ['id' => 'type_3', 'data-target' => 'type_monthly', 'class' => 'form-control']) !!}
        </span>
        <span class="input-group-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
            <label for="type_3">ماهانه</label>
        </span>
    </div>
    <div class="clear"></div>
</div>
<div style="float: right; width: 85%; margin-right: 25px;  padding-right: 25px; border-right: gray solid 1px;">
    <!-- messages -->
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }}">{!! Session::get('alert-' . $msg) !!} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
        @endforeach
    </div>
    <!-- messages -->
    <table class="table table-condensed">
        <!-- title -->
        <tr class="success">
            <td class="col-sm-2">
                <label style="line-height: 32px;" class="pull-right">عنوان</label>
            </td>
            <td class="col-sm-9">
                {!! Form::text('title', null, ['class' => 'form-control pull-right rtl', 'style' => 'direction: rtl;']) !!}
            </td>
        </tr>
        <!-- start date -->
        <tr class="info">
            <td class="col-sm-2">
                <label style="line-height: 32px;" class="pull-right">تاریخ شروع</label>
            </td>
            <td class="col-sm-9">
                <div class="input-group pull-right">
                    <span class="input-group-addon">
                        <i class="fa fa-calculator"></i>
                    </span>
                    {!! Form::text('start_date', null, ['class' => 'form-control DatePicker']) !!}
                </div>
            </td>
        </tr>
        <!-- cycle frequency -->
        <tr class="warning">
            <td class="col-sm-2">
                <label style="line-height: 32px;" class="pull-right">&nbsp;ساعت شروع</label>
            </td>
            <td class="col-sm-9">
                <div class="input-group pull-right col-sm-4">
                    <span class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                    </span>
                    {!! Form::text('start_time', null, ['class' => 'form-control TimePicker']) !!}
                </div>
            </td>
        </tr>
        <tr class="warning">
            <td class="col-sm-2">
                <label style="line-height: 32px;" class="pull-right">&nbsp;نحوه تکرار</label>
            </td>
            <td class="col-sm-9">
                <div class="input-group pull-right col-sm-4" style="margin: 0 0 5px 5px;">
                    <span class="input-group-addon">
                        <span style="font-size: 14px;" class="pull-right">مرتبه&nbsp{!! Form::radio('recur_type', 1, true, ['id' => 'recur_type_1', 'style' => 'height: 10px;']) !!}</span>
                    </span>
                    {!! Form::text('count', null, ['class' => 'form-control']) !!}
                </div>
                <div class="input-group pull-right col-sm-6" style="margin: 0 0 5px 5px;">
                    <span class="input-group-addon">
                        <span style="font-size: 14px;" class="pull-right">تا ساعت&nbsp{!! Form::radio('recur_type', 2, false, ['id' => 'recur_type_2', 'style' => 'height: 10px;']) !!}</span>
                    </span>
                    {!! Form::text('end_time', null, ['class' => 'form-control TimePicker', 'disabled' => 'disabled']) !!}
                </div>
            </td>
        </tr>
        <tr class="warning">
            <td class="col-sm-2">
                <label style="line-height: 32px;" class="pull-right">&nbsp;سیکل تکرار</label>
            </td>
            <td class="col-sm-9">
                <div class="input-group pull-right">
                    <span class="input-group-addon">
                        <i class="fa fa-refresh"></i>
                    </span>
                    <select type="text" name="recur_freq" class="form-control">
                        <option value="5">5 دقیقه</option>
                        <option value="10">10 دقیقه</option>
                        <option value="15">15 دقیقه</option>
                        <option value="30">30 دقیقه</option>
                        <option value="60">1 ساعت</option>
                    </select>
                </div>
            </td>
        </tr>
        <!-- end date -->
        <tr id="end_date_node" class="info">
            <td class="col-sm-2">
                <label style="line-height: 32px;" class="pull-right">&nbsp;تاریخ پایان</label>
            </td>
            <td class="col-sm-9">
                <div class="input-group pull-right">
                    <span class="input-group-addon">
                        <i class="fa fa-calculator"></i>
                    </span>
                    {!! Form::text('end_date', null, ['class' => 'form-control DatePicker']) !!}
                </div>
            </td>
        </tr>
        <!-- recur cullection -->
        <tr class="warning">
            <td class="col-sm-2">
                <label style="line-height: 32px;" class="pull-right">&nbsp;نحوه ساخت</label>
            </td>
            <td class="col-sm-9">
                <div class="input-group pull-right">
                    <span class="input-group-addon">
                        <i class="fa fa-refresh"></i>
                    </span>
                    <select type="text" name="use_as_repeater" class="form-control">
                        <option value="0">ایجاد  بر اساس زمانبندی</option>
                        <option value="1">ایجاد در هنگام ذخیره</option>
                    </select>
                </div>
            </td>
        </tr>
        <!-- daily -->
        <tr id="type_daily">
            <td class="col-sm-2">
                <label style="line-height: 32px;" class="pull-right">&nbsp;تکرار هر</label>
            </td>
            <td class="col-sm-9">
                <div class="input-group pull-right" style="width: 150px;">
                    {!! Form::text('daily_freq', null, ['class' => 'form-control pull-right']) !!}
                    <span class="input-group-addon">
                        <label style="width: 50px;">روز&nbsp;</label>
                    </span>
                </div>
            </td>
        </tr>
        <!-- weekly -->
        <tr id="type_weekly">
            <td class="col-sm-2">
                <label style="line-height: 32px;" class="pull-right">&nbsp;تکرار هر</label>
            </td>
            <td class="col-sm-9">
                <div class="input-group pull-right" style="width: 150px;">
                    {!! Form::text('weekly_freq', null, ['class' => 'form-control pull-right']) !!}
                    <span class="input-group-addon">
                        <label style="width: 50px;">هفته&nbsp;</label>
                    </span>
                </div>
            </td>
        </tr>
        <tr id="type_weekly2">
            <td class="col-sm-2">
                <label style="line-height: 45px;" class="pull-right">&nbsp;فقط در روزهای</label>
            </td>
            <td class="col-sm-9">
                @for ($i = 0; $i < 7; $i++)
                    <div class="input-group pull-right" style="margin: 0 0 5px 5px;">
                        <span class="input-group-addon" style="padding: 0 5px 0 0; margin: 0 5px 0 0;">
                            {!! Form::checkbox('weekly_weekdays[]', $i, false, ['id' => "weekly_weekdays_$i", 'class' => 'form-control pull-right']) !!}
                        </span>
                        <span class="input-group-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <label style="line-height: 10px;" for="{{ "weekly_weekdays_$i" }}">{!! $array_weekly_weekdays[$i] !!}</label>
                        </span>
                    </div>
                @endfor
            </td>
        </tr>
        <!-- mountly -->
        <tr id="type_monthly">
            <td class="col-sm-2">
                <label style="line-height: 45px;" class="pull-right">&nbspماه ها</label>
            </td>
            <td class="col-sm-9">
                @for ($i = 1; $i < 13; $i++)
                    <div class="input-group pull-right" style="margin: 0 0 5px 5px;">
                        <span class="input-group-addon" style="padding: 0 5px 0 0; margin: 0 5px 0 0;">
                            {!! Form::checkbox('monthly_months[]', $i, false, ['id' => "monthly_months_$i", 'class' => 'form-control pull-right']) !!}
                        </span>
                        <span class="input-group-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                            <label style="line-height: 10px;" for="{{ "monthly_months_$i" }}">{!! $array_monthly_months[$i - 1] !!}</label>
                        </span>
                    </div>
                @endfor
            </td>
        </tr>
        <tr id="type_monthly2">
            <td class="col-sm-2">
                <label class="pull-right">{!! Form::radio('monthly_type', 1, false, ['id' => 'monthly_type_1']) !!}روزها </label><br />
                <br />
                <label class="pull-right">{!! Form::radio('monthly_type', 2, false, ['id' => 'monthly_type_2']) !!}در </label>
            </td>
            <td class="col-sm-9">
                <div id="type_monthly2_pan1">
                    @for ($i = 1; $i < 32; $i++)
                        <div class="input-group pull-right" style="margin: 0 0 5px 5px;">
                            <span class="input-group-addon" style="padding: 0 5px 0 0; margin: 0 5px 0 0;">
                                {!! Form::checkbox('monthly_days[]', $i, false, ['id' => "monthly_days_$i", 'class' => 'form-control pull-right']) !!}&nbsp;&nbsp;&nbsp;
                            </span>
                            <span class="input-group-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                <label style="line-height: 10px;" for="{{ "monthly_days_$i" }}">{{ $i }}</label>
                            </span>
                        </div>
                    @endfor
                </div>
                <div id="type_monthly2_pan2">
                    @for ($i = 1; $i < 6; $i++)
                        <div class="input-group pull-right" style="margin: 0 0 5px 5px;">
                            <span class="input-group-addon" style="padding: 0 5px 0 0; margin: 0 5px 0 0;">
                                {!! Form::checkbox('monthly_weeknums[]', $i, false, ['id' => "monthly_weeknums_$i", 'class' => 'form-control pull-right']) !!}
                            </span>
                            <span class="input-group-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                <label style="line-height: 10px;" for="{{ "monthly_weeknums_$i" }}">{!! $array_weeks[$i - 1] !!}</label>
                            </span>
                        </div>
                    @endfor<br />
                    <br />
                    <br />
                    <br />
                    <br />
                    @for ($i = 0; $i < 7; $i++)
                        <div class="input-group pull-right" style="margin: 0 0 5px 5px;">
                            <span class="input-group-addon" style="padding: 0 5px 0 0; margin: 0 5px 0 0;">
                                {!! Form::checkbox('monthly_weekdays[]', $i, false, ['id' => "monthly_weekdays_$i", 'class' => 'form-control pull-right']) !!}
                            </span>
                            <span class="input-group-addon" style="padding: 0 5px 0 5px; margin: 0 5px 0 5px;">
                                <label style="line-height: 10px;" for="{{ "monthly_weekdays_$i" }}">{!! $array_weekly_weekdays[$i] !!}</label>
                            </span>
                        </div>
                    @endfor
                </div>
            </td>
        </tr>
        <!-- sumbit -->
        <!--
        <tr>
            <td colspan="2">
                <br />
                {!! Form::submit('ایجاد زمانبندی', ['class' => 'btn btn-primary pull-right']) !!}
            </td>
        </tr>
        -->
    </table>
</div>
{!! Form::close() !!}
<div class="clear"></div>
