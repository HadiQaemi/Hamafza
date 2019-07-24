<?php
namespace App\Http\Controllers\Hamahang;


use App\Models\Hamahang\diagrams;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;

class DiagramController extends Controller
{

    public function diagram_list_all($uname)
    {
        $arr = variable_generator('user', 'desktop', $uname);
        return view('hamahang.Diagram.DiagramList', $arr);
    }

    public function fetech_all_diagram()
    {
        $diagrams = diagrams::with('keywords');
        return Datatables::eloquent($diagrams)
            ->addColumn('keywords', function ($data)
            {
                $rr = [];
                if(is_array($data->keywords))
                {
                    foreach($data->keywords as $Ar)
                        $rr[]= ['id'=>$Ar->id,'title'=>$Ar->title];
                }
                return json_encode($rr);
            })
            ->addColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->make(true);


    }

    public function save_diagram()
    {
        $diagrams = diagrams::find(deCode(\Request::get('did')));
        $diagrams->keywords()->delete();
        if(\Request::exists('keywords'))
        {
            foreach (\Request::get('keywords') as $keyword)
            {
                $keyword = str_replace('exist_in','',$keyword);
                $diagrams->keywords()->create([
                    'uid' => auth()->user()->id,
                    'keyword_id' => $keyword
                ]);
            }
        }
        $diagrams->users_permissions()->delete();
        if(\Request::exists('users_list_subject_view'))
        {
            foreach (\Request::get('users_list_subject_view') as $user)
            {
                $diagrams->users_permissions()->create([
                    'uid' => auth()->user()->id,
                    'user_id' => $user
                ]);
            }
        }
        $diagrams->title = \Request::get('title');
        if($diagrams->save())
            return json_encode(['status' => true]);

    }
}