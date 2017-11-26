<?php

namespace App\Http\Controllers\Hamahang;


use Datatables;
use Illuminate\Http\Request;
use App\Models\hamafza\Keyword;
use App\Models\Hamahang\KeywordRelation;
use App\Http\Controllers\Controller;

class KeywordsController extends Controller
{
    public function index($name)
    {
        $res = variable_generator('user', 'desktop', $name);
        return view('hamahang.Keywords.index', $res);
    }

    public function getKeywordsList(Request $request)
    {
        $res = \App\Models\hamafza\Keyword::withCount('subjects')->with('thesa');
        return Datatables::eloquent($res)
            ->editColumn('thesa', function ($data)
            {
                $string = [];
                foreach ($data->thesa as $th)
                {
                    if (isset($th->pages[0]))
                    {
                        $string[$th->pages[0]->id] = '<a href="' . url($th->pages[0]->id) . '" target="_blank">' . $th->title . '</a>';
                    }
                }
                return implode(', ', $string);
            })
            ->rawColumns(['thesa', 'subjects'])->make(true);
    }

    public function getKeywordsForTree(Request $request)
    {
        $input = $request->all();
        //dd($input['id']);
        $relation_types = config('keyword.relation_types');
        $array = [];
        $keyword_relations1 = KeywordRelation::where('keyword_1_id', $input['id'])->with('keywords_2')->get();
        $keyword_relations2 = KeywordRelation::where('keyword_2_id', $input['id'])->with('keywords_1')->get();
        if ($keyword_relations1)
        {
            foreach ($keyword_relations1 as $keyword_relation1)
            {
                $relation_types1 = config('keyword.relation_types')[$keyword_relation1->relation_type];
                // dd($relation_types);
                $array[$relation_types1][] = $keyword_relation1->keywords_2->title;
            }
            foreach ($keyword_relations2 as $keyword_relation2)
            {
                switch ($keyword_relation2->relation_type)
                {
                    case 1:
                        $relation_types2 = 110;
                        break;
                    case 110:
                        $relation_types2 = 1;
                        break;
                    case 3:
                        $relation_types2 = 310;
                        break;
                    case 310:
                        $relation_types2 = 3;
                        break;
                    case 5:
                        $relation_types2 = 510;
                        break;
                    case 510:
                        $relation_types2 = 5;
                        break;
                        defult:
                        $relation_types2 = $keyword_relation2->relation_type;
                }
                $relation_types2 = config('keyword.relation_types')[$relation_types2];
                // dd($relation_types);
                $array[$relation_types2][] = $keyword_relation2->keywords_1->title;
            }
            return json_encode($array);
        }
    }

    public function get_keyword_subject_list(Request $request)
    {
        $keyword = Keyword::find($request->get('keyword_id'));
        $subjects = $keyword->subjects()->whereHas('pages')->with('pages')->select('subjects.id','subjects.title')->get();
        return Datatables::of($subjects)->make(true);
    }

    public function save_new_keyword(Request $request)
    {
        //dd('No ' . __FUNCTION__);
        $uid = (session('uid') != '') ? session('uid') : 0;
        $sesid = (session('sesid') != '') ? session('sesid') : 0;
        $tmpFileName = '';
        $file = $request->file('PicFiles');
        $UpFiles = array();
        if ($file)
        {
            if ($file->isValid())
            {
                $tmpFilePath = 'files/keywords/';
                $extension = $file->getClientOriginalExtension();
                $tmpFileName = $uid . $key . time() . '.' . $extension; // renameing image
                $img = IImage::make($file->getRealPath());
                $img->resize(550, null, function ($constraint)
                {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $img->save('files/keywords/' . $tmpFileName)->destroy();
            }
        }
        $shape = $request->input('shape');
        $Tagtype = $request->input('Tagtype');
        $workflow = $request->input('workflow');
        $code = $request->input('code');
        $relation = $request->input('relation');
        $thes = $request->input('thes');
        $Descr = $request->input('Descr');
        $joz = $request->input('joz');
        $keys = $request->input('keys');
        $mesdagh = $request->input('mesdagh');
        $jozmes = $request->input('jozmes');
        $kol = $request->input('kol');
        $aam = $request->input('aam');
        $kolaam = $request->input('kolaam');
        $hamarz = $request->input('hamarz');
        $moraj = $request->input('moraj');
        $hambaste = $request->input('hambaste');
        $eshterak = $request->input('eshterak');
        $kootah = $request->input('kootah');
        $english = $request->input('english');
        $arabic = $request->input('arabic');
        $motazad = $request->input('motazad');
        $eshtebah = $request->input('eshtebah');
        $file = $tmpFileName;
        $reg_date = gmdate("Y-m-d H:i:s", time() + 12600);
        $relation = ($relation == '') ? '0' : $relation;
        $keyid1 = DB::table('keywords')
            ->insertGetId(array(
                'keyword' => $shape,
                'reg_date' => $reg_date,
                'descr' => $Descr,
                'type' => $Tagtype,
                'uid' => $uid,
                'ttype' => '15',
                'workflow' => $workflow,
                'code' => $code,
                'morajah' => $relation,
                'pic' => $file
            ));
        $thes = explode(',', $thes);
        if (is_array($thes) && count($thes) > 0)
        {
            foreach ($thes as &$value)
            {
                if ($value != '')
                {
                    DB::table('thesaurus_keywords')->insert(array('keyword_id' => $keyid1, 'subject_id' => $value));
                }
            }
        }
        else
        {
            DB::table('thesaurus_keywords')->insert(array('keyword_id' => $keyid1, 'subject_id' => config('constans.defthesarus')));
        }
        $joz = explode(',', $joz);
        if (is_array($joz) && count($joz) > 0)
        {
            foreach ($joz as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '1'));
                }
            }
        }
        $mesdagh = explode(',', $mesdagh);

        if (is_array($mesdagh) && count($mesdagh) > 0)
        {

            foreach ($mesdagh as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '3'));
                }
            }
        }
        $jozmes = explode(',', $jozmes);
        if (is_array($jozmes) && count($jozmes) > 0)
        {

            foreach ($jozmes as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '5'));
                }
            }
        }
        $kol = explode(',', $kol);
        if (is_array($kol) && count($kol) > 0)
        {
            foreach ($kol as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')->insert(array('keyword_1_id' => $value, 'keyword_2_id' => $keyid1, 'relation_type' => '1'));
                }
            }
        }

        $aam = explode(',', $aam);

        if (is_array($aam) && count($aam) > 0)
        {

            foreach ($aam as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')->insert(array('keyword_1_id' => $value, 'keyword_2_id' => $keyid1, 'relation_type' => '3'));
                }
            }
        }
        $kolaam = explode(',', $kolaam);
        if (is_array($kolaam) && count($kolaam) > 0)
        {
            foreach ($kolaam as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')->insert(array('keyword_1_id' => $value, 'keyword_2_id' => $keyid1, 'relation_type' => '5'));
                }
            }
        }
        $hamarz = explode(',', $hamarz);
        if (is_array($hamarz) && count($hamarz) > 0)
        {
            foreach ($hamarz as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '7'));
                }
            }
        }

        $moraj = explode(',', $moraj);

        if (is_array($moraj) && count($moraj) > 0)
        {
            foreach ($moraj as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '8'));
                }
            }
        }
        $hambaste = explode(',', $hambaste);

        if (is_array($hambaste) && count($hambaste) > 0)
        {
            foreach ($hambaste as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '9'));
                }
            }
        }
        $eshterak = explode(',', $eshterak);

        if (is_array($eshterak) && count($eshterak) > 0)
        {

            foreach ($eshterak as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '10'));
                }
            }
        }
        //$kootah = explode(',', $kootah);

        if (is_array($kootah) && count($kootah) > 0)
        {

            foreach ($kootah as &$value)
            {
                if ($value != '')
                {
                    mysql_query("INSERT INTO keyword_relations ( keyword_1_id , keyword_2_id , rel ) VALUES ( '$keyid1' , '$value' , '11' )") or die("no connect");
                }
            }
        }
        $english = explode(',', $english);

        if (is_array($english) && count($english) > 0)
        {
            foreach ($english as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '12'));
                }
            }
        }
        $arabic = explode(',', $arabic);
        if (is_array($arabic) && count($arabic) > 0)
        {

            foreach ($arabic as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '13'));
                }
            }
        }
        $eshtebah = explode(',', $eshtebah);
        if (is_array($eshtebah) && count($eshtebah) > 0)
        {
            foreach ($eshtebah as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '20'));
                }
            }
        }
        $motazad = explode(',', $motazad);
        if (is_array($motazad) && count($motazad) > 0)
        {
            foreach ($motazad as &$value)
            {
                if ($value != '')
                {
                    DB::table('keyword_relations')->insert(array('keyword_1_id' => $keyid1, 'keyword_2_id' => $value, 'relation_type' => '21'));
                }
            }
        }
        return Redirect()->back()->with('message', 'انجام شد.')->with('mestype', 'success');
    }

}