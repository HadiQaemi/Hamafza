<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\Hamahang\Scheduler\Enquiry;
use Request;
use Auth;
use Validator;
use DB;
use App\Models\Hamahang\tasks\tasks;

class SchedulerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hamahang.Scheduler.scheduler')->with('data', []);
    }

    public function create()
    {
        $validator = Validator::make
        (
            Request::all(),
            [
                'type' => 'required',
                'title' => 'required',
                'start_date' => 'required|jalali_date|jalali_date_after:yesterday',
                'start_time' => ['required', 'regex:^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$^'],
                'count' => 'required_without:end_time|integer|between:1,1440',
                'end_time' => ['required_without:count', 'regex:^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$^'],
                'end_date' => 'required_if:type,1|jalali_date|jalali_date_after:field,start_date',
                'daily_freq' => 'required_if:type,1',
                'weekly_freq' => 'required_if:type,2',
                'weekly_weekdays' => 'required_if:type,2',
                'monthly_months' => 'required_if:type,3',
                'monthly_type' => 'required_if:type,3',
                'monthly_days' => 'required_if:monthly_type,1',
                'monthly_weeknums' => 'required_if:monthly_type,2',
                'monthly_weekdays' => 'required_if:monthly_type,2',
            ],
            [
                'type.*' => 'انتخاب یکی از گزینه های <b>یک مرتبه</b>، <b>روزانه</b>، <b>هفتگی</b> یا <b>ماهانه</b> الزامی است.',
                'title.*' => 'فیلد "عنوان" الزامی است.',
                'start_date.*' => 'فیلد "تاریخ شروع" را معتبر، بزرگتر از دیروز و کوچکتر از "تاریخ پایان" وارد کنید.',
                //'start_date.required' => 'فیلد "تاریخ شروع" الزامی است.',
                //'start_date.jalali_date' => 'فیلد "تاریخ شروع" را درست وارد کنید.',
                //'start_date.jalali_date_after' => 'فیلد "تاریخ شروع" باید بزرگتر از دیروز باشد.',
                'start_time.*' => 'فیلد "ساعت شروع" الزامی است.',
                'count.*' => 'در نحوه تکرار وقتی "تا ساعت" انتخاب نشود "مرتبه" الزامی است.',
                'end_time.*' => 'در نحوه تکرار وقتی "مرتبه" انتخاب نشود "تا ساعت" الزامی است.',
                'end_date.*' => 'فیلد "تاریخ پایان" را معتبر و بزرگتر از "تاریخ پایان" وارد کنید.',
                'daily_freq.*' => 'وقتی "نوع تکرار" <b>روزانه</b> باشد، فیلد "تکرار هر" الزامی است.',
                'weekly_freq.*' => 'وقتی "نوع تکرار" <b>هفتگی</b> باشد، فیلد "تکرار هر" الزامی است.',
                'weekly_weekdays.*' => 'وقتی "نوع تکرار" <b>هفتگی</b> باشد، فیلد "فقط در روزهای" الزامی است.',
                'monthly_months.*' => 'وقتی "نوع تکرار" <b>ماهانه</b> باشد، فیلد "ماه ها" الزامی است.',
                'monthly_type.*' => 'وقتی "نوع تکرار" <b>ماهانه</b> باشد، فیلد "روزها" یا "در" الزامی است.',
                'monthly_days.*' => 'فیلد "روزها" الزامی است.',
                'monthly_weeknums.*' => 'زیر فیلد "در" الزامی است.',
                'monthly_weekdays.*' => 'زیر فیلد "در" الزامی است.',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        Request::merge(['start_date' => implode('-', HDate_JtoG(Request::input('start_date')))]);
        if ('0' !== Request::input('type'))
        {
            Request::merge(['end_date' => implode('-', HDate_JtoG(Request::input('end_date')))]);
        }

        $type = Request::input('type');
        $uid = Auth::user()->id;
        $schedule = new Enquiry;
        $schedule->setTable('schedule');
        $schedule->uid = $uid;
        $schedule->title = Request::input('title');
        $schedule->start_date = Request::input('start_date');
        $schedule->end_date = Request::input('end_date');
        $get_date_diff = get_date_diff($schedule->start_date, $schedule->end_date);
        $weeks = intval($get_date_diff->days / 7);
        $schedule->type = Request::input('type');
        $result_1 = $schedule->save();
        if ($result_1)
        {
            $schedule_id = $schedule->id;
            $schedule_period = new Enquiry;
            $schedule_period->setTable('schedule_period');
            $schedule_period->uid = $uid;
            $schedule_period->schedule_id = $schedule_id;
            $schedule_period->start_time = Request::input('start_time');
            $schedule_period->recur_type = Request::input('recur_type');
            if (1 == $schedule_period->recur_type)
            {
                $schedule_period->count = Request::input('count');
                $schedule_period->end_time = null;
            } else if (2 == $schedule_period->recur_type)
            {
                $schedule_period->count = null;
                $schedule_period->end_time = Request::input('end_time');
            }
            $schedule_period->recur_freq = Request::input('recur_freq');
            $result_2 = $schedule_period->save();
            if ($result_2)
            {
                switch ($type)
                {
                    case 0: //once
                    {
                        $sub_result = $result_2;
                        $schedule_recur = new Enquiry;
                        $schedule_recur->setTable('schedule_recur');
                        $schedule_recur->schedule_id = $schedule_id;
                        $schedule_recur->recur_date = $schedule->start_date;
                        $schedule_recur->save();
                        break;
                    }
                    case 1: //daily
                    {
                        $schedule_id = $schedule->id;
                        $schedule_daily = new Enquiry;
                        $schedule_daily->setTable('schedule_daily');
                        $schedule_daily->schedule_id = $schedule_id;
                        $schedule_daily->daily_freq = Request::input('daily_freq');
                        $sub_result = $schedule_daily->save();
                        for ($i = 0; $i < $get_date_diff->days / Request::input('daily_freq'); $i++)
                        {
                            $datetime = new \DateTime($schedule->start_date);
                            $datetime->add(new \DateInterval('P' . (Request::input('daily_freq') * $i) . 'D'));
                            $schedule_recur = new Enquiry;
                            $schedule_recur->setTable('schedule_recur');
                            $schedule_recur->schedule_id = $schedule_id;
                            $schedule_recur->recur_date = $datetime->format("Y-m-d");
                            $schedule_recur->save();
                        }
                        break;
                    }
                    case 2: //weekly
                    {
                        $schedule_id = $schedule->id;
                        $schedule_weekly = new Enquiry;
                        $schedule_weekly->setTable('schedule_weekly');
                        $schedule_weekly->schedule_id = $schedule_id;
                        $freq = Request::input('weekly_freq');
                        $schedule_weekly->weekly_freq = $freq;
                        $schedule_weekly->weekdays = implode(',', Request::input('weekly_weekdays'));
                        $sub_result = $schedule_weekly->save();
                        $d = 0;
                        $start_date = new \DateTime($schedule->start_date);
                        $purpose_date = new \DateTime($schedule->start_date);
                        $end_date = new \DateTime($schedule->end_date);
                        while ($d < $get_date_diff->days)
                        {
                            for ($wd = 0; $wd < 7; $wd++)
                            {
                                $purpose_date = new \DateTime($schedule->start_date);
                                $purpose_date->add(new \DateInterval("P{$d}D"));
                                if ((in_array(get_persian_weekday($purpose_date->format('w')), Request::input('weekly_weekdays'))) && ($start_date <= $purpose_date) && ($purpose_date <= $end_date))
                                {
                                    $schedule_recur = new Enquiry;
                                    $schedule_recur->setTable('schedule_recur');
                                    $schedule_recur->schedule_id = $schedule_id;
                                    $schedule_recur->recur_date = $purpose_date->format('Y-m-d');
                                    $schedule_recur->save();
                                }
                                $d++;
                            }
                            $d += 7 * ($freq - 1);
                        }
                        break;
                    }
                    case 3: //monthly
                    {
                        $schedule_id = $schedule->id;
                        $schedule_monthly = new Enquiry;
                        $schedule_monthly->setTable('schedule_monthly');
                        $schedule_monthly->schedule_id = $schedule_id;
                        $months = Request::input('monthly_months');
                        $type = Request::input('monthly_type');
                        $schedule_monthly->months = implode(',', $months);
                        $schedule_monthly->type = $type;
                        switch ($type)
                        {
                            case 1:
                            {
                                $days = Request::input('monthly_days');
                                $schedule_monthly->days = implode(',', $days);
                                break;
                            }
                            case 2:
                            {
                                $weeknums = Request::input('monthly_weeknums');
                                $weekdays = Request::input('monthly_weekdays');
                                $schedule_monthly->weeknums = implode(',', $weeknums);
                                $schedule_monthly->weekdays = implode(',', $weekdays);
                                break;
                            }
                        }
                        $sub_result = $schedule_monthly->save();
                        $res = [];
                        switch ($type)
                        {
                            case 1:
                            {
                                $start_date = new \DateTime($schedule->start_date);
                                $end_date = new \DateTime($schedule->end_date);
                                $diff = get_date_diff($start_date->format('Y-m'), $end_date->format('Y-m'));
                                $ms = get_date_diff_mounts($diff);
                                for ($m = 0; $m < $ms; $m++)
                                {
                                    $purpose_date = new \DateTime($schedule->start_date);
                                    $purpose_date->add(new \DateInterval("P{$m}M"));
                                    if (in_array($purpose_date->format('m'), $months))
                                    {
                                        for ($d = 1; $d < 32; $d++)
                                        {
                                            if (in_array($d, $days))
                                            {
                                                $recur_date = $purpose_date->format('Y-m') . "-$d";
                                                $explode = explode('-', $recur_date);
                                                if (checkdate($explode[1], $explode[2], $explode[0]))
                                                {
                                                    $schedule_recur = new Enquiry;
                                                    $schedule_recur->setTable('schedule_recur');
                                                    $schedule_recur->schedule_id = $schedule_id;
                                                    $schedule_recur->recur_date = $recur_date;
                                                    $schedule_recur->save();
                                                }
                                                $res[] = $recur_date;
                                            }
                                        }
                                    }
                                }
                                break;
                            }
                            case 2:
                            {
                                $om = 0;
                                $wn = 1;
                                for ($d = 0; $d <= $get_date_diff->days; $d++)
                                {
                                    $purpose_date = new \DateTime($schedule->start_date);
                                    $purpose_date->add(new \DateInterval("P{$d}D"));
                                    $cm = $purpose_date->format('m');
                                    if ($om !== $cm)
                                    {
                                        $wn = 1;
                                        $om = $cm;
                                    }
                                    $wd = ($purpose_date->format('w'));
                                    if (in_array($cm, $months) && in_array($wn, $weeknums) && in_array($wd, $weekdays))
                                    {
                                        $recur_date = $purpose_date->format('Y-m-d');
                                        $schedule_recur = new Enquiry;
                                        $schedule_recur->setTable('schedule_recur');
                                        $schedule_recur->schedule_id = $schedule_id;
                                        $schedule_recur->recur_date = $recur_date;
                                        $schedule_recur->save();
                                        $res[] = $recur_date;
                                    }
                                    $wn += 6 == $wd ? 1 : 0;
                                }
                                break;
                            }
                        }
                        break;
                    }
                }
                if ($sub_result)
                {
                    DB::statement("CALL SCHEDULE_GET_RECUR()");
                    $select = DB::select("SELECT `schedule_id`, `date` AS `recur_date`, TIME_FORMAT(`time`, '%H:%i') AS `recur_time` FROM `_schedule_get_recur`");
                    $select = json_decode(json_encode($select), true);
                    $final = [];
                    foreach ($select as $s)
                    {
                        $final[] =
                        [
                            'schedule_id' => $s['schedule_id'],
                            'recur_date' => $s['recur_date'],
                            'recur_time' => $s['recur_time'],
                            'created_at' => date('Y-m-d H:i:s'),
                        ];
                    }
                    db::table('schedule_recur_data')->insert($final);
                    $use_as_repeater = Request::input('use_as_repeater');
                    db::table('schedule_relations')->insert(['uid' => $uid, 'schedule_id' => $schedule_id, 'user_id' => 0, 'target_table' => 'hamahang_task', 'target_id' => Request::input('tid'), 'use_as_repeater' => $use_as_repeater, 'created_at' => date('Y-m-d H:i:s')]);
                    if ($use_as_repeater)
                    {
                        $last_insert_id = db::select('SELECT LAST_INSERT_ID() AS `last_insert_id`');
                        tasks::ScheduleTaskCopy($last_insert_id[0]->last_insert_id, $s['recur_date'] . ' ' . $s['recur_time']);
                    }
                    return response()->json(['success' => true, 'result' => ['با موفقیت ذخیره شد.']]);
                } else
                {

                }


            } else
            {

            }
        } else
        {

        }
        Request::session()->flash('alert-success', 'زمانبندی با موفقیت ایجاد شد.');
        return redirect()->route('ugc.desktop.hamahang.scheduler.index', ['username' => auth()->user()->Uname]);
    }
}

