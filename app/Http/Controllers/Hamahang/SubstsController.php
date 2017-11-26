<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\Hamahang\Subst;
use Illuminate\Http\Request;
use Datatables;
use Validator;

class SubstsController extends Controller
{
    public function index($Uname)
    {
        $vg = variable_generator('user', 'desktop', $Uname);
        return view('hamahang.Subst.index', $vg);
    }

    public function getSubsts()
    {
        $alerts = Subst::query();
        return Datatables::of($alerts)
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->make(true);
    }

    public function addNewSubst(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first' => 'required',
            'second' => 'required',
        ], [], [
            'first' => 'عبارت',
            'second' => 'جایگزین',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $subst = new Subst();
            $subst->uid = auth()->id();
            $subst->first = $request->first;
            $subst->second = $request->second;
            $subst->save();

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function editSubstView(Request $request)
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
            $subst = Subst::find(deCode($request->item_id));
            $edit_form = view('hamahang.Subst.helper.views.edit_form')
                ->with('subst', $subst)
                ->render();

            $result['content'] = $edit_form;
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function editSubst(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
            'first' => 'required',
            'second' => 'required',
        ], [], [
            'first' => 'عبارت',
            'second' => 'جایگزین',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $subst = Subst::find(deCode($request->item_id));
            $subst->first = $request->first;
            $subst->second = $request->second;
            $subst->save();

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function deleteSubst(Request $request)
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
            Subst::destroy($item_id);
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }
}

