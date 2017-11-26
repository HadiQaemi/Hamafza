<?php

namespace App\HamafzaServiceClasses;

use Illuminate\Support\Facades\DB;

class ProccesClass {

    public function EditProccess($uid, $session_id, $phase_name, $phase_score, $view, $phase_manager1, $phase_manager, $formid
    , $pformid, $persons, $alert, $process_name, $process_comment, $process_id) {
        $user = UserClass::CheckLogin($uid, $session_id);
        if ($user) {
            $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
            DB::table('process')
                    ->where('id', $process_id)
                    ->update(array('name' => $process_name, 'comment' => $process_comment, 'edit_date' => $reg_date));
            $work = $process_id;
            DB::table('process_phase')->where('pid', $process_id)->delete();

            $phase_score = explode(',', $phase_score);
            $view = explode(',', $view);
            $phase_manager1 = explode(',', $phase_manager1);
            $phase_manager = explode(',', $phase_manager);
            $formid = explode(',', $formid);
            $pformid = explode(',', $pformid);
            $persons = explode(',', $persons);
            $alert = explode(',', $alert);
            $myArray = explode(',', $phase_name);

            foreach ($myArray as $key => $value) {
                if (trim($value) != '') {
                    $phase_managerR = $phase_manager[$key];
                    $phase_manager1R = $phase_manager1[$key];
                    $formR = $formid[$key];
                    $pformidR = $pformid[$key];
                    $phase_scoreR = $phase_score[$key];
                    $viewR = $view[$key];
                    if ($viewR == 'on')
                        $viewR = '1';
                    else
                        $viewR = '0';
                    $formR = $formid[$key];
                    $alertR = $alert[$key];
                    $pp = DB::table('process_phase')->insertGetId(
                            array('pid' => $work, 'name' => $value, 'manager' => $phase_managerR, 'manager1' => $phase_manager1R, 'form' => $formR,
                                'pform' => $pformidR, 'score' => $phase_scoreR, 'orders' => $key, 'alert' => $alertR, 'view' => $viewR, 'reg_date' => $reg_date
                    ));
                }
            }
            $message = trans('labels.PRoCOK');
            $err = false;
        } else {
            $message = trans('labels.FailUser');
            $err = true;
        }
        return Response::json(array(
                    'error' => $err,
                    'data' => $message), 200
                )->setCallback(Input::get('callback'));
    }

    public function ADDProccess($uid, $session_id, $phase_name, $phase_score, $view, $phase_manager1, $phase_manager, $formid
    , $pformid, $persons, $alert, $process_name, $process_comment) {
        $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
        $work = DB::table('process')->insertGetId(
                array('admin' => $uid, 'name' => $process_name, 'comment' => $process_comment, 'reg_date' => $reg_date, 'edit_date' => $reg_date));
       
        foreach ($phase_name as $key => $value) {
            if (trim($value) != '') {
                $phase_managerR = $phase_manager[$key];
                $phase_manager1R = $phase_manager1[$key];
                $formR = $formid[$key];
                $pformidR = $pformid[$key];
                $phase_scoreR = $phase_score[$key];
                $viewR = $view[$key];
                if ($viewR == 'on')
                    $viewR = '1';
                else
                    $viewR = '0';
                $formR = $formid[$key];
                $alertR = $alert[$key];
                $pp = DB::table('process_phase')->insertGetId(
                        array('pid' => $work, 'name' => $value, 'manager' => $phase_managerR, 'manager1' => $phase_manager1R, 'form' => $formR,
                            'pform' => $pformidR, 'score' => $phase_scoreR, 'orders' => $key, 'alert' => $alertR, 'view' => $viewR, 'reg_date' => $reg_date
                ));
            }
        }
        $message = trans('labels.PRoCOK');
        $err = false;
        return $message;
    }

    public function EditProcces($pid) {
        $Forms = DB::table('process as p')->leftJoin('process_phase as pp', 'p.id', '=', 'pp.pid')
                        ->leftJoin('user as u', 'u.id', '=', 'pp.manager')
                        ->select('p.id as pid', 'p.name as process_name', 'p.comment', 'pp.id as did', 'pp.name as phase_name', 'pp.manager', 'pp.manager1', 'pp.form', 'pp.pform', 'pp.alert', 'pp.view', 'pp.score', 'pp.orders', 'u.Name', 'u.Family', 'u.id')
                        ->where('p.id', $pid)->orderBy('pp.orders')->get();
        return $Forms;
    }

    public function NewProccessData() {
        $Forms = DB::table('forms as f')->select('f.id', 'f.title')->get();
        $porseshname = $Forms;
        $Alerts = DB::table('alerts as a')->select('a.id', 'a.name')->get();
        $Res['Forms'] = $Forms;
        $Res['Alerts'] = $Alerts;
        $Res['Porsesh'] = $porseshname;

        return $Res;
    }

    public function GetProcces($uid, $session_id) {
            $message = DB::table('process as p')->leftJoin('process_subject as ps', 'ps.pid', '=', 'p.id')
                            ->leftJoin('user as u', 'p.admin', '=', 'u.id')->select(DB::raw('p.id, p.admin, p.name, p.reg_date, u.Name, u.Family , ps.pid , count(p.id) as nums'))->groupBy('p.id')->orderBy('p.reg_date')->get();
            $i = 1;
            foreach ($message as $value) {
                $value->reg_date = '';
                $value->sortid = $i;
            $value->edit = $i;
            $value->del = $i;
            $value->flowchart = $i;
            $i++;
        }
        $message = json_encode($message);
                $message = json_decode($message);

        return $message;
    }

}
