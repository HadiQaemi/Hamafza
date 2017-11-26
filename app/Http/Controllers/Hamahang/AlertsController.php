<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\Hamahang\Alert;
use Datatables;
use Illuminate\Http\Request;
use Validator;

class AlertsController extends Controller
{
    public function index($Uname)
    {
        $vg = variable_generator('user', 'desktop', $Uname);
        return view('hamahang.Alerts.index', $vg);
    }

    public function getAlerts()
    {
        $alerts = Alert::query();
        return Datatables::of($alerts)
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->editColumn('comment', function ($data)
            {
                return $data->shorten_comment;
            })
            ->make(true);
    }

    public function addNewAlert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'comment' => 'required',
        ], [], [
            'comment' => 'متن',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $alert = new Alert();
            $alert->name = $request->name;
            $alert->comment = $request->comment;
            $alert->save();

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function editAlert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
            'name' => 'required',
            'comment' => 'required',
        ], [], [
            'comment' => 'متن',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $alert = Alert::find(deCode($request->item_id));
            $alert->name = $request->name;
            $alert->comment = $request->comment;
            $alert->save();

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function editAlertView(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $alert = Alert::find(deCode($request->item_id));
            $edit_form = view('hamahang.Alerts.helper.views.edit_form')
                ->with('alert', $alert)
                ->render();

            $result['content'] = $edit_form;
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function deleteAlert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required'
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $item_id = deCode($request->input('item_id'));
            Alert::destroy($item_id);
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

}

