<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\hamafza\Relations;
use Datatables;
use Illuminate\Http\Request;
use Validator;

class RelationsController extends Controller
{
    public function index($Uname)
    {
        $vg = variable_generator('user', 'desktop', $Uname);
        return view('hamahang.Relations.index', $vg);
    }

    public function getRelations()
    {
        $relations = Relations::query();
        return Datatables::eloquent($relations)
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->make(true);
    }

    public function addNewRelation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'directname' => 'required',
            'Inversename' => 'required',
            'dariche' => 'required',
            'direction' => 'required',
        ], [], [
            'directname' => 'نام حالت مستقیم',
            'inversename' => 'نام حالت معکوس',
            'dariche' => 'عنوان دریچه ناوبری',
            'direction' => 'حالت نمایش',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $relation = new Relations();
            $relation->name = $request->name;
            $relation->directname = $request->directname;
            $relation->Inversename = $request->Inversename;
            $relation->direction = $request->direction;
            $relation->dariche = $request->dariche;
            $relation->dariche_inver = $request->dariche_inver;
            $relation->save();

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function editRelation(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'directname' => 'required',
            'Inversename' => 'required',
            'dariche' => 'required',
            'direction' => 'required',
        ], [], [
            'directname' => 'نام حالت مستقیم',
            'inversename' => 'نام حالت معکوس',
            'dariche' => 'عنوان دریچه ناوبری',
            'direction' => 'حالت نمایش',
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $relation = Relations::find(deCode($request->relation_id));
            $relation->name = $request->name;
            $relation->directname = $request->directname;
            $relation->Inversename = $request->Inversename;
            $relation->direction = $request->direction;
            $relation->dariche = $request->dariche;
            $relation->dariche_inver = $request->dariche_inver;
            $relation->save();

            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function deleteRelation(Request $request)
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
            Relations::destroy($item_id);
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

}

