<?php

namespace App\Http\Controllers\Hamahang;

use App\HamahangCustomClasses\jDateTime;
use App\Models\Hamahang\OrgChart\onet_job;
use App\Models\Hamahang\OrgChart\org_chart_items_jobs;
use App\Models\Hamahang\OrgChart\org_charts_items_jobs;
use App\Models\Hamahang\OrgChart\org_charts_items_jobs_alternate_users;
use App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts;
use App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts_access;
use App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts_adventage;
use App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts_alternate_users;
use App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts_staff;
use App\Models\Hamahang\OrgChart\org_charts_items_jobs_posts_worktime;
use App\Models\Hamahang\OrgChart\org_charts_items_jobs_wages;
use App\Models\Hamahang\OrgChart\org_charts_items_missions;
use App\Models\Hamahang\OrgChart\org_osi;
use App\Models\Hamahang\OrgChart\org_staff;
use App\Models\Hamahang\OrgChart\org_staff_edu;
use App\Models\Hamahang\OrgChart\org_staff_jobs;
use DB;

use Request;
use Validator;
use App\User;
use App\Http\Controllers\Controller;
use App\Models\Hamahang\OrgChart\org_organs;
use App\Models\Hamahang\OrgChart\org_charts;
use App\Models\Hamahang\OrgChart\org_chart_items;
use App\Models\Hamahang\OrgChart\org_charts_items_posts;

class OrgChartController extends Controller
{
    public function SetScore()
    {
        $job_id = deCode(Request::input('job'));
        $item = Request::input('item');
        $score = Request::input('score');
        $job = org_charts_items_jobs_wages::where('chart_item_job_id', '=', $job_id)->get();
        if ($job->count() == 0) {
            org_charts_items_jobs_wages::create([
                'uid' => auth()->id(),
                'chart_item_job_id' => $job_id,
                "$item" => $score
            ]);
        } else {
            org_charts_items_jobs_wages::where('chart_item_job_id', '=', $job_id)
                ->update([
                    "$item" => $score
                ]);
            $job = org_charts_items_jobs_wages::where('chart_item_job_id', '=', $job_id)->first();
            $update = [];
            $totla_score = 0;
            $map_effect_score = [
                [5, 5, 5, 5, 5],
                [15, 15, 15, 15, 15],
                [25, 25, 25, 25, 25],
                [40, 43, 45, 48, 52],
                [50, 55, 61, 66, 73],
                [70, 78, 86, 96, 105],
                [85, 96, 106, 120, 131],
                [105, 117, 129, 146, 158],
                [120, 135, 149, 169, 184],
                [140, 156, 174, 195, 211],
                [150, 169, 191, 213, 231],
                [170, 191, 218, 242, 264],
                [185, 209, 240, 265, 289],
                [200, 228, 262, 290, 317],
                [215, 248, 282, 313, 342],
                [235, 272, 311, 343, 375],
                [250, 291, 331, 366, 415]
            ];
            if (trim($job->effect_effect) != '' && trim($job->effect_association) != '') {
                $update['effect_first_score'] = ($job->effect_effect - 1) * 3 + $job->effect_association;
                if (trim($job->effect_size) != '') {
                    $update['effect_score'] = $map_effect_score[$update['effect_first_score'] - 1][$job->effect_size - 1];
                    $totla_score += $update['effect_score'];
                }
            }
            $map_connections_score = [
                [10, 25, 30, 45],
                [25, 40, 45, 60],
                [40, 55, 60, 75],
                [55, 75, 80, 100],
                [70, 90, 95, 115]
            ];
            if (trim($job->connections_type) != '' && trim($job->connections_frame) != '') {
                $update['connections_score'] = $map_connections_score[$job->connections_type - 1][$job->connections_frame - 1];
                $totla_score += $update['connections_score'];
            }
            $map_problem_score = [
                [10, 15, 20, 25],
                [25, 30, 35, 40],
                [40, 45, 50, 55],
                [65, 70, 75, 80],
                [90, 95, 100, 105],
                [115, 120, 125, 130]
            ];
            if (trim($job->problem_solving_innovation) != '' && trim($job->problem_solving_complexity) != '') {
                $update['problem_solving_score'] = $map_problem_score[$job->problem_solving_innovation - 1][$job->problem_solving_complexity - 1];
                $totla_score += $update['problem_solving_score'];
            }
            $map_skill_score = [
                [
                    [15, 25, 35],
                    [30, 40, 50],
                    [60, 70, 80],
                    [90, 100, 110],
                    [110, 120, 130],
                    [135, 145, 155],
                    [160, 170, 180],
                    [180, 190, 200]
                ], [
                    [50, 60, 70],
                    [65, 75, 85],
                    [95, 105, 115],
                    [125, 135, 145],
                    [140, 150, 160],
                    [170, 180, 190],
                    [190, 200, 210],
                    [215, 225, 235]
                ], [
                    [75, 85, 95],
                    [90, 100, 110],
                    [120, 130, 140],
                    [150, 160, 170],
                    [170, 180, 190],
                    [195, 205, 215],
                    [220, 230, 240],
                    [240, 250, 260]
                ]
            ];
            if (trim($job->skill_technical_knowledge) != '' && trim($job->skill_communication_skills) != '' && trim($job->skill_spread) != '') {
                $update['skill_score'] = $map_skill_score[$job->skill_communication_skills - 1][$job->skill_technical_knowledge - 1][$job->skill_spread - 1];
                $totla_score += $update['skill_score'];
            }
            $map_risk_score = [
                [0, 0, 0],
                [5, 10, 15],
                [15, 20, 25],
                [25, 30, 35]
            ];
            if (trim($job->risk_possibility) != '' && trim($job->risk_type) != '') {
                $update['risk_score'] = $map_risk_score[$job->risk_type - 1][$job->risk_possibility - 1];
                $totla_score += $update['risk_score'];
            }
            $update['total_score'] = $totla_score;
            $level_job = 0;
            if ($totla_score >= 40 && $totla_score < 50) {
                $level_job = 1;
            } else if ($totla_score >= 40 && $totla_score < 50) {
                $level_job = 2;
            } else if ($totla_score >= 50 && $totla_score < 60) {
                $level_job = 3;
            } else if ($totla_score >= 60 && $totla_score < 75) {
                $level_job = 4;
            } else if ($totla_score >= 75 && $totla_score < 100) {
                $level_job = 5;
            } else if ($totla_score >= 100 && $totla_score < 125) {
                $level_job = 6;
            } else if ($totla_score >= 125 && $totla_score < 175) {
                $level_job = 7;
            } else if ($totla_score >= 175 && $totla_score < 225) {
                $level_job = 8;
            } else if ($totla_score >= 225 && $totla_score < 275) {
                $level_job = 9;
            } else if ($totla_score >= 275 && $totla_score < 325) {
                $level_job = 10;
            } else if ($totla_score >= 325 && $totla_score < 375) {
                $level_job = 11;
            } else if ($totla_score >= 375 && $totla_score < 425) {
                $level_job = 12;
            } else if ($totla_score >= 425 && $totla_score < 475) {
                $level_job = 13;
            } else if ($totla_score >= 475 && $totla_score < 525) {
                $level_job = 14;
            } else if ($totla_score >= 525 && $totla_score < 575) {
                $level_job = 15;
            } else if ($totla_score >= 575 && $totla_score < 625) {
                $level_job = 16;
            } else if ($totla_score >= 625 && $totla_score < 675) {
                $level_job = 17;
            } else if ($totla_score >= 675 && $totla_score < 725) {
                $level_job = 18;
            } else if ($totla_score >= 725 && $totla_score < 775) {
                $level_job = 19;
            } else if ($totla_score >= 775 && $totla_score < 825) {
                $level_job = 20;
            } else if ($totla_score >= 825 && $totla_score < 875) {
                $level_job = 21;
            } else if ($totla_score >= 875 && $totla_score < 950) {
                $level_job = 21;
            }

            $update['level_job'] = $level_job;
            org_charts_items_jobs_wages::where('chart_item_job_id', '=', $job_id)
                ->update($update);
        }
        return json_encode([
            'score' => $score,
            'job_id' => $job_id,
            'success' => true,
            'item' => $item
        ]);
    }

    private function check_posts($array)
    {
        $arr = [];
        $ps = org_posts::where('parent_unit_id', $array['id'])->get();
        //exit(var_dump($ps));
        //echo '\n';
        if (sizeof($ps) > 0) {
            foreach ($ps as $p) {
//				//array_push($arr, ['title' => $p['title'], 'id' => $p['id'], 'node_type' =
                $arr['title'] = $p['title'];
                $arr['node_type'] = 1;
                $arr['id'] = $p['id'];
                //array_push($arr, ['title' => 'sss', 'id' => 'ssssss', 'node_type' => 'cdcdc']);
            }
        }
        var_dump($arr);
        echo "*$%$$$\n";

        if (isset($array['nodes'])) {

            foreach ($array['nodes'] as $n)
                if ($n['node_type'] == 0) {
                    //echo $n['id']."***";
                    $this->check_posts($n);
                }
            $array['nodes'] += $arr;
        } else {
            $array['nodes'] = $arr;
        }
    }

    private function buildTree($flat_array, $pidKey, $parent = 0, $idKey = 'id', $children_key = 'children')
    {
        $grouped = array();
        foreach ($flat_array as $sub) {
            $grouped[$sub[$pidKey]][] = $sub;
        }

        $fnBuilder = function ($siblings) use (&$fnBuilder, $grouped, $idKey, $children_key) {
            foreach ($siblings as $k => $sibling) {
                $id = $sibling[$idKey];
                if (isset($grouped[$id])) {
                    $sibling[$children_key] = $fnBuilder($grouped[$id]);
                }
                $siblings[$k] = $sibling;
            }
            return $siblings;
        };

        $tree = $fnBuilder($grouped[$parent]);
        return $tree;
    }

    public function selectUser()
    {
        dd('hi hadi');
    }

    public function OrgansList($username)
    {
        $arr = variable_generator('user', 'desktop', $username);
        $arr['Uname'] = $username;
        $arr['UName'] = $username;
        return view('hamahang.OrgChart.OrgansList', $arr);
    }

    public function OrgOrgansList($username)
    {
        $arr = variable_generator('user', 'desktop', $username);
        $arr['Uname'] = $username;
        $arr['UName'] = $username;
        return view('hamahang.OrgChart.OrgOrgansList', $arr);
    }

    public function OrgChartList($UName, $OrgID)
    {
        org_organs::findOrFail($OrgID);
        $arr = user_page_variable_generator($UName);
        $arr['OrgID'] = $OrgID;
        return view('hamahang.OrgChart.OrgChartsList', $arr);
    }

    public function AjaxOrgOrgans()
    {
        $data = org_organs::with('charts', 'charts.items', 'charts.items.jobs', 'charts.items.jobs.posts', 'charts.items.jobs.posts.users')
            ->leftJoin('user', 'user.id', '=', 'hamahang_org_organs.uid')
            ->leftJoin('hamahang_org_organs AS ParentOrg', 'ParentOrg.id', '=', 'hamahang_org_organs.parent_id')
            ->leftJoin('hamahang_org_charts AS ChartsOrg', 'ChartsOrg.org_organs_id', '=', 'hamahang_org_organs.id')
            ->select(
                'user.Uname AS CreatorUserName',
                'user.Name AS CreatorName',
                'ChartsOrg.id AS ChartID',
                'user.Family AS CreatorFamily',
                'ParentOrg.title AS ParentTitle',
                'hamahang_org_organs.*'
            )->whereNull('hamahang_org_organs.deleted_at')->groupBy('id');
        return \Yajra\Datatables\Facades\Datatables::eloquent($data)
            ->addColumn('chartsCount', function ($data) {
                $chartCount = 0;
                $chartItemCount = 0;
                $chartItemJobCount = 0;
                $chartItemJobPostCount = 0;
                $chartItemJobPostUserCount = 0;
                $chart = $data->charts[0];
                $chartCount++;
                foreach ($chart->items as $item) {
                    $chartItemCount++;
                    foreach ($item->jobs as $job) {
                        $chartItemJobCount++;
                        foreach ($job->posts as $post) {
                            $chartItemJobPostCount++;
                            foreach ($post->users as $user) {
                                $chartItemJobPostUserCount++;
                            }
                        }
                    }
                }

                return [
                    'chartCount' => $chartCount,
                    'chartItemCount' => $chartItemCount,
                    'chartItemJobCount' => $chartItemJobCount,
                    'chartItemJobPostCount' => $chartItemJobPostCount,
                    'chartItemJobPostUserCount' => $chartItemJobPostUserCount,
                ];
            })
            ->addColumn('oid', function ($data) {
                return enCode($data->id);
            })
            ->make(true);
        $data = collect($data)->map(function ($x) {
            return (array)$x;
        })->toArray();
        $result['data'] = $data;
        return json_encode($result);
    }

    public function CreateOrgan()
    {
        $validator = Validator::make(Request::all(), [
            'organ_title' => 'required',
            'organ_parent_id' => 'required'
        ]);

        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $org = new org_organs;
            $org->uid = Auth::id();
            $org->parent_id = Request::input('organ_parent_id');
            $org->title = Request::input('organ_title');
            $org->description = Request::input('organ_description');
            $org->save();

            $result['org_id'] = $org->id;
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function UpdateOrgan()
    {
        $validator = Validator::make(Request::all(), [
            'organ_id' => 'required',
            'organ_title' => 'required'
        ]);

        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {

            $org = org_organs::find(Request::input('organ_id'));
            $org->uid = Auth::id();
            $org->parent_id = Request::input('organ_parent_id');
            $org->title = Request::input('organ_title');
            $org->description = Request::input('organ_description');
            $org->save();

            $result['org_id'] = $org->id;
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function RemoveOrgan()
    {
        Request::merge([
            'org_id' => deCode(Request::get('id'))
        ]);
        $validator = Validator::make(Request::all(),
            [
                'org_id' => 'required|exists:hamahang_org_organs,id'
            ],
            [],
            [
                'org_id' => 'سازمان'
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            DB::table('hamahang_org_organs')
                ->where('id', Request::input('org_id'))
                ->update(['deleted_at' => 1]);
            return json_encode('1');

        }
    }

    public function AjaxOrgCharts($OrgID)
    {
        $data = DB::table('hamahang_org_charts AS Charts')
            ->leftJoin('user', 'user.id', '=', 'Charts.uid')
            ->leftJoin('hamahang_org_organs AS Organs', 'Organs.id', '=', 'Charts.org_organs_id')
            ->where('Charts.org_organs_id', '=', $OrgID)
            ->select
            (
                'user.Uname AS CreatorUserName',
                'user.Name AS CreatorName',
                'user.Family AS CreatorFamily',
                'Charts.*'
            )
            ->get();
        $data = collect($data)->map(function ($x) {
            return (array)$x;
        })->toArray();
        $result['data'] = $data;
        //dd(json_encode($result));
        return $result;
        //return $result;
    }

    public function AjaxOrgChartDataShow()
    {

        $validator = Validator::make(Request::all(),
            [
                'id' => 'required|exists:hamahang_org_charts_items,chart_id|exists:hamahang_org_charts,id',
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            //org_charts::findOrFail(Request::input('id'));
            $Items = DB::table('hamahang_org_charts_items')
                ->where('chart_id', '=', Request::input('id'))
                ->whereNull('deleted_at')
                ->select('parent_id', 'title AS name', 'description AS title', 'id')
                ->get();

            $Items = collect($Items)->map(function ($x) {
                return (array)$x;
            })->toArray();
            $tree = buildTree($Items, 'parent_id');

            return $tree;
        }

    }

    public function OrgChartShow($username, $chart_id)
    {
        $validator = Validator::make([ 'username'=>$username, 'chart_id'=>$chart_id],
              [
                'chart_id'=>'required|exists:hamahang_org_charts,id'
              ],
              [],
              [
                  'chart_id' => 'سازمان',
              ]
          );
          if ($validator->fails())
          {

              $result['error'] = $validator->errors();
              $result['success'] = false;
              return json_encode($result);
          }
          else {
              $Chart = org_charts::findOrFail($chart_id);
              $arr = variable_generator('user', 'desktop', $username);
              $arr['chart_id'] = $chart_id;
              $arr['chart_title'] = $Chart->title;
              $arr['Chart'] = $Chart;
              $arr['UName'] = $username;
              return view('hamahang.OrgChart.OrgChartShow', $arr);
          }
    }

    public function OrgListShow($username, $organ_id)
    {
        /* $validator = Validator::make([$username,$chart_id],
              [
                'chart_id'=>'required'
              ],
              [],
              [
                  'new_item_title' => 'عنوان ',
                  'new_item_title' => 'عنوان ',
              ]
          );
          if ($validator->fails())
          {

              $result['error'] = $validator->errors();
              $result['success'] = false;
              return json_encode($result);
          }
          else
          {*/
        $Chart = org_charts::findOrFail($organ_id);
        $arr = variable_generator('user', 'desktop', $username);
        $arr['organ_id'] = $organ_id;
        $arr['Chart'] = $Chart;
        $arr['UName'] = $username;
        return view('hamahang.OrgChart.OrgListShow', $arr);
    }

    public function FetchOrgList()
    {
        $validator = Validator::make(Request::all(),
            [
//                'organ_id'=>'required|exists:hamahang_org_organs,id'
                'organ_id' => 'required|numeric'
            ], [],
            [
                'new_item_title' => 'عنوان ',
                'new_item_title' => 'عنوان ',
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $organ_id = Request::get('organ_id');
            $data = org_chart_items::where('chart_id', '=', $organ_id)->whereNull('deleted_at');
            return \Yajra\Datatables\Facades\Datatables::eloquent($data)
                ->addColumn('oid', function ($data) {
                    return enCode($data->id);
                })
                ->make(true);
        }
    }

    public function FetchJobList()
    {
        $validator = Validator::make(Request::all(),
            [
//                'organ_id'=>'required|exists:hamahang_org_organs,id'
                'organ_id' => 'required|numeric'
            ], [],
            [
                'new_item_title' => 'عنوان ',
                'new_item_title' => 'عنوان ',
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $organ_id = Request::get('organ_id');
            $data = org_chart_items::with('jobs')->where('chart_id', '=', $organ_id)->whereNull('deleted_at')->get();
            $job_lists = [];
            foreach ($data as $item) {
                foreach ($item->jobs as $job) {
                    $job_lists [] = [
                        'title_item' => $item->title,
                        'title' => isset($job->job->title) ? $job->job->title : '',
                        'describ' => $job->description,
                        'amount' => $job->amount
                    ];
                }
            }
            $result['data'] = $job_lists;
            return json_encode($result);
        }
    }

    public function wagesAllJob()
    {
        $data = org_charts_items_jobs::with('job', 'item', 'wage');
        return \Yajra\Datatables\Facades\Datatables::eloquent($data)
            ->addColumn('effect_effect', function ($data) {
                return isset($data->wage->effect_effect) ? $data->wage->effect_effect : '';
            })
            ->addColumn('effect_association', function ($data) {
                return isset($data->wage->effect_association) ? $data->wage->effect_association : '';
            })
            ->addColumn('effect_score', function ($data) {
                return isset($data->wage->effect_score) ? $data->wage->effect_score : '';
            })
            ->addColumn('effect_size', function ($data) {
                return isset($data->wage->effect_size) ? $data->wage->effect_size : '';
            })
            ->addColumn('effect_first_score', function ($data) {
                return isset($data->wage->effect_first_score) ? $data->wage->effect_first_score : '';
            })
            ->addColumn('connections_type', function ($data) {
                return isset($data->wage->connections_type) ? $data->wage->connections_type : '';
            })
            ->addColumn('connections_frame', function ($data) {
                return isset($data->wage->connections_frame) ? $data->wage->connections_frame : '';
            })
            ->addColumn('connections_score', function ($data) {
                return isset($data->wage->connections_score) ? $data->wage->connections_score : '';
            })
            ->addColumn('problem_solving_innovation', function ($data) {
                return isset($data->wage->problem_solving_innovation) ? $data->wage->problem_solving_innovation : '';
            })
            ->addColumn('problem_solving_complexity', function ($data) {
                return isset($data->wage->problem_solving_complexity) ? $data->wage->problem_solving_complexity : '';
            })
            ->addColumn('problem_solving_score', function ($data) {
                return isset($data->wage->problem_solving_score) ? $data->wage->problem_solving_score : '';
            })
            ->addColumn('skill_technical_knowledge', function ($data) {
                return isset($data->wage->skill_technical_knowledge) ? $data->wage->skill_technical_knowledge : '';
            })
            ->addColumn('skill_communication_skills', function ($data) {
                return isset($data->wage->skill_communication_skills) ? $data->wage->skill_communication_skills : '';
            })
            ->addColumn('skill_spread', function ($data) {
                return isset($data->wage->skill_spread) ? $data->wage->skill_spread : '';
            })
            ->addColumn('skill_score', function ($data) {
                return isset($data->wage->skill_score) ? $data->wage->skill_score : '';
            })
            ->addColumn('risk_type', function ($data) {
                return isset($data->wage->risk_type) ? $data->wage->risk_type : '';
            })
            ->addColumn('risk_possibility', function ($data) {
                return isset($data->wage->risk_possibility) ? $data->wage->risk_possibility : '';
            })
            ->addColumn('risk_score', function ($data) {
                return isset($data->wage->risk_score) ? $data->wage->risk_score : '';
            })
            ->addColumn('total_score', function ($data) {
                return isset($data->wage->total_score) ? $data->wage->total_score : '';
            })
            ->addColumn('level_job', function ($data) {
                return isset($data->wage->level_job) ? $data->wage->level_job : '';
            })
            ->addColumn('job', function ($data) {
                return isset($data->job->title) ? $data->job->title : '';
            })
            ->addColumn('item', function ($data) {
                return isset($data->item->title) ? $data->item->title : '';
            })
            ->addColumn('organ', function ($data) {
                return isset($data->item->chart->organ->title) ? $data->item->chart->organ->title : '';
            })
            ->make(true);
    }

    public function fetchAllJob()
    {
        $data = org_charts_items_jobs::with('job', 'item');
        return \Yajra\Datatables\Facades\Datatables::eloquent($data)
            ->addColumn('job', function ($data) {
                return isset($data->job->title) ? $data->job->title : '';
            })
            ->addColumn('item', function ($data) {
                return isset($data->item->title) ? $data->item->title : '';
            })
            ->addColumn('organ', function ($data) {
                return isset($data->item->chart->organ->title) ? $data->item->chart->organ->title : '';
            })
            ->make(true);
    }

    public function fetchPortalJob()
    {

        $data = onet_job::with('skill', 'ability', 'knowledge')->limit(10)->get();
        return json_encode(
            ['data' => $data]
        );
    }

    public function staff($username)
    {
        $arr = variable_generator('user', 'desktop', $username);
        $arr['Uname'] = $username;
        $arr['UName'] = $username;
        return view('hamahang.OrgChart.StaffList', $arr);
    }

    public function jobs($username)
    {
        $arr = variable_generator('user', 'desktop', $username);
        $arr['Uname'] = $username;
        $arr['UName'] = $username;
        return view('hamahang.OrgChart.jobList', $arr);
    }

    public function wagesJobs($username)
    {
        $arr = variable_generator('user', 'desktop', $username);
        $arr['Uname'] = $username;
        $arr['UName'] = $username;
        return view('hamahang.OrgChart.wagesJobs', $arr);
    }

    public function fetchStaff()
    {
        $data = org_staff::whereNull('deleted_at')->with('posts', 'posts.job');
        $staff = \Yajra\Datatables\Facades\Datatables::eloquent($data)
            ->addColumn('enId', function ($data) {
                return enCode($data->id);
            })
            ->addColumn('staff', function ($data) {
                return $data->first_name . ' ' . $data->last_name;
            })
            ->addColumn('staffId', function ($data) {
                return enCode($data->id);
            })
            ->addColumn('post', function ($data) {
                $ret = '';
                foreach ($data->posts as $post)
                {
                    $ret .= (trim($ret) == '' ? '' : ', ') . $post->extra_title;
                    if(count($data->posts)>1)
                        $ret .= ',...';
                    break;
                }
                return $ret;
            })
            ->addColumn('charts', function ($data) {
                $ret = '';
                foreach ($data->posts as $post)
                {
                    $ret .= (trim($ret) == '' ? '' : ', ') . $post->job;
                    if(count($data->posts)>1)
                        $ret .= ',...';
                    break;
                }
                return $ret;
            })
            ->addColumn('job', function ($data) {
                $ret = '';
                foreach ($data->posts as $post)
                {
                    $ret .= (trim($ret) == '' ? '' : ', ') . $post->job->job->title;
                    if(count($data->posts)>1)
                        $ret .= ',...';
                    break;
                }
                return $ret;
            })
            ->addColumn('item', function ($data) {
                $ret = '';
                foreach ($data->posts as $post)
                {
                    $ret .= (trim($ret) == '' ? '' : ', ') . $post->job->item->title;
                    if(count($data->posts)>1)
                        $ret .= ',...';
                    break;
                }
                return $ret;
            })
            ->addColumn('org', function ($data) {
                $ret = '';
                foreach ($data->posts as $post)
                {
                    $ret .= (trim($ret) == '' ? '' : ', ') . $post->job->item->chart->title;
                    if(count($data->posts)>1)
                        $ret .= ',...';
                    break;
                }
                return $ret;
            })
            ->make(true);

        return $staff;
    }

    public function FetchPostList()
    {
        $validator = Validator::make(Request::all(),
            [
//                'organ_id'=>'required|exists:hamahang_org_organs,id'
                'organ_id' => 'required|numeric'
            ], [],
            [
                'new_item_title' => 'عنوان ',
                'new_item_title' => 'عنوان ',
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $organ_id = Request::get('organ_id');
            $data = org_chart_items::with('jobs')->where('chart_id', '=', $organ_id)->whereNull('deleted_at')->get();
            $post_lists = [];
            foreach ($data as $item) {
                foreach ($item->jobs as $job) {
                    foreach ($job->posts as $post) {
                        $post_lists [] = [
                            'title_item' => $item->title,
                            'title_job' => isset($job->job->title) ? $job->job->title : '',
                            'extra_title' => $post->extra_title,
                            'location' => $post->location,
                            'share_performance' => $post->share_performance,
                            'outsourcing' => $post->outsourcing
                        ];
                    }
                }
            }
            $result['data'] = $post_lists;
            return json_encode($result);
        }
    }

    public function ShowJobList($username, $chart_id)
    {
        /* $validator = Validator::make([$username,$chart_id],
              [
                'chart_id'=>'required'
              ],
              [],
              [
                  'new_item_title' => 'عنوان ',
                  'new_item_title' => 'عنوان ',
              ]
          );
          if ($validator->fails())
          {

              $result['error'] = $validator->errors();
              $result['success'] = false;
              return json_encode($result);
          }
          else
          {*/
        $Chart = org_charts::findOrFail($chart_id);
        $arr = variable_generator('user', 'desktop', $username);
        $arr['chart_id'] = $chart_id;
        $arr['Chart'] = $Chart;
        $arr['UName'] = $username;
        return view('hamahang.OrgChart.ShowJobList', $arr);
    }

    public function ShowPostList($username, $chart_id)
    {
        /* $validator = Validator::make([$username,$chart_id],
              [
                'chart_id'=>'required'
              ],
              [],
              [
                  'new_item_title' => 'عنوان ',
                  'new_item_title' => 'عنوان ',
              ]
          );
          if ($validator->fails())
          {

              $result['error'] = $validator->errors();
              $result['success'] = false;
              return json_encode($result);
          }
          else
          {*/
        $Chart = org_charts::findOrFail($chart_id);
        $arr = variable_generator('user', 'desktop', $username);
        $arr['chart_id'] = $chart_id;
        $arr['Chart'] = $Chart;
        $arr['UName'] = $username;
        return view('hamahang.OrgChart.ShowPostList', $arr);
    }

    public function ModifyChartInfo()
    {
        $chart = org_charts::findOrFail(Request::input('cid'));
        $chart->title = Request::input('nTitle');
        $chart->description = Request::input('nDesc');
        $chart->save();
        return json_encode('ok');
    }

    public function AddNewChart()
    {
        $chart = new org_charts;
        $chart->org_organs_id = Request::input('oid');
        $chart->title = Request::input('title');
        $chart->description = Request::input('desc');
        $chart->uid = auth()->id();
        $chart->save();
        return json_encode('1');
    }

    public function item_info()
    {
        $arr = [];
        $posts = DB::table('hamahang_org_charts_items_posts')
            ->whereNull('deleted_at')
            ->where('hamahang_org_charts_items_posts.chart_item_id', '=', Request::input('id'))
            ->get();
        foreach ($posts as $post) {
            if ($post->user_id == '') {
                $post->user_id = 'no';
            } else {
                $user = User::where('id', $post->user_id)->first();
                $post->user_info = $user;
            }
        }
        //die(var_dump($post));
        $arr[0] = $posts;
        $org_name = DB::table('hamahang_org_charts_items')
            ->join('hamahang_org_charts', 'hamahang_org_charts_items.chart_id', '=', 'hamahang_org_charts.id')
            ->join('hamahang_org_organs', 'hamahang_org_organs.id', '=', 'hamahang_org_charts.org_organs_id')
            ->where('hamahang_org_charts_items.id', Request::input('id'))
            ->whereNull('hamahang_org_charts_items.deleted_at')
            ->select('hamahang_org_charts_items.id AS item_id', 'hamahang_org_charts_items.title', 'hamahang_org_charts_items.description', 'hamahang_org_organs.title as org_title', 'hamahang_org_charts.id as chart_id', 'hamahang_org_charts.title as ch_title', 'hamahang_org_charts_items.parent_id as parent')
            ->first();
        //die(var_dump($org_name));
        $arr[1]['chart_id'] = $org_name->chart_id;
        $arr[1]['item_id'] = $org_name->item_id;
        $arr[1]['item_title'] = $org_name->title;
        $arr[1]['item_description'] = $org_name->description;

        $arr[1]['org_title'] = $org_name->org_title;
        $arr[1]['chart_title'] = $org_name->ch_title;
        if ($org_name->parent != 0) {
            $item_parent_name = org_chart_items::where('id', $org_name->parent)->get();
            //die(var_dump($item_parent_name));
            $arr[1]['parent_id'] = $item_parent_name[0]->id;
            $arr[1]['parent_title'] = $item_parent_name[0]->title;
        } else {
            $arr[1]['parent_id'] = 0;
        }
        $item_posts_count = org_charts_items_posts::where('chart_item_id', '=', Request::input('id'))->count();
        $arr[1]['post_count'] = $item_posts_count;
        $item_free_posts_count = org_charts_items_posts::where('chart_item_id', '=', Request::input('id'))
            ->where('user_id', '>', 0)->count();
        $arr[1]['free_post_count'] = $item_posts_count - $item_free_posts_count;
        $item_items = org_chart_items::where('parent_id', Request::input('id'))->get();

        foreach ($item_items as $q) {
            $c = org_chart_items::where('parent_id', $q->id)->count();
            $q->item_childs_count = $c;
        }

        $arr[1]['item_items'] = $item_items;

        $Chart_Items = DB::table('hamahang_org_charts_items')
            //->join('user', 'user.id', '=', 'org_charts_items.id')
            ->where('chart_id', '=', 1)
            ->whereNull('deleted_at')
            ->select('hamahang_org_charts_items.parent_id', 'hamahang_org_charts_items.title AS name', 'hamahang_org_charts_items.description AS title', 'hamahang_org_charts_items.id')
            ->get();

        $Chart_Items = collect($Chart_Items)->map(function ($x) {
            return (array)$x;
        })->toArray();

        $Chart_Items_tree = buildTree($Chart_Items, 'parent_id');
        $arr[1]['item_items_ch'] = json_encode($Chart_Items_tree);
        return $arr;
    }

    public function SubmitChange()
    {
        (int)$id = Request::get('draggedNode');
        (int)$patent_id = Request::get('dropZone');

        $target_item = org_chart_items::findOrFail($patent_id);
        $parent = $target_item->parent_id;

        $parents = array();
        while ($parent !== 0) {
            $parents[] = $parent;
            $target_item = org_chart_items::findOrFail($parent);
            $parent = $target_item->parent_id;
        };

        if (!in_array($id, $parents)) {
            $item = org_chart_items::findOrFail($id)->update(['parent_id' => $patent_id]);
            $result[] = $item;
        } else {
            $result[] = False;
        }

        return json_encode($result);
    }

    public function add_new_node()
    {
        $validator = Validator::make(Request::all(), [
            'chart_id' => 'required',
            'item_id' => 'required',
            'new_item_title' => 'required',
            'new_item_description' => 'required',
        ]);

        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $node = new org_chart_items;
            $node->uid = Auth::id();
            $node->chart_id = Request::input('chart_id');
            $node->parent_id = Request::input('item_id');
            $node->title = Request::input('new_item_title');
            $node->description = Request::input('new_item_description');
            $node->save();

            $result['item_id'] = Request::input('item_id');
            $result['success'] = true;
            return json_encode($result);
        }

    }

    public function create_new_chart_item()
    {
        $request = new Request;
        $item = new org_chart_items;
        $item->uid = Auth::id();
        $item->chart_id = $request->get('chart_id');
        $item->parent_id = $request->get('parent_id');
        $item->title = $request->get('title');
        $item->description = $request->get('description');
        $item->save();
    }

    public function AddRootChartItem()
    {
        $validator = Validator::make(Request::all(), [
            'root_item_title' => 'required',
            'Organs_ID' => 'required',
            'Charts_ID' => 'required'
        ]);

        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $Charts_ID = Request::input('Charts_ID');
            $current_root = org_chart_items::where('chart_id', '=', $Charts_ID)->where('parent_id', '=', 0)->first();

            $node = new org_chart_items;
            $node->uid = auth()->id();
            $node->chart_id = $Charts_ID;
            $node->parent_id = Request::input('Parent_ID');
            $node->title = Request::input('root_item_title');
            $node->description = Request::input('root_item_description');
            $node->save();

//            if ($current_root) {
//                $current_root->parent_id = $node->id;
//                $current_root->save();
//            }

            $result['item_id'] = Request::input('item_id');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function UpdateChartItem()
    {
        $result = array();
        $item_id = Request::input('item_id');
        $item_title = Request::input('item_title');
        $item_parent_id = Request::input('item_parent_id');
        $item_description = Request::input('item_description');

        $item = org_chart_items::find($item_id);
        $item->title = $item_title;
        $item->parent_id = $item_parent_id;
        $item->description = $item_description;
        $item->save();
        $result['item_id'] = $item_id;
        return json_encode($result);
    }

    public function RemoveChartItem()
    {

        $ID = Request::input('item_id');
        org_chart_items::destroy($ID);
        return json_encode($ID);
    }

    public function add_new_post()
    {
        $post = new org_charts_items_posts();
        $post->title = Request::input('post_title');
        $post->chart_item_id = Request::input('item_id');
        $post->uid = 125;
        $post->save();

        $post = DB::table('hamahang_org_charts_items_posts')
            ->where('chart_item_id', '=', $post->chart_item_id)
            ->whereNull('deleted_at')
            ->get();

        foreach ($post as $p) {
            if ($p->user_id == '') {
                $p->user_id = 'no';
            } else {
                $user = User::find($p->user_id)->get();
                $p->user_info = $user[0];
            }
        }
        return $post;
    }

    public function add_post_user()
    {
        $p = org_charts_items_posts::find(Request::input('post_id'));
        $p->user_id = Request::input('user_id');
        $p->save();

        $post = DB::table('hamahang_org_charts_items_posts')
            ->whereNull('deleted_at')
            ->where('chart_item_id', '=', $p->chart_item_id)
            ->get();

        foreach ($post as $p) {
            if ($p->user_id == '') {
                $p->user_id = 'no';
            } else {
                $user = User::where('id', $p->user_id)->first();
                $p->user_info = $user->toArray();
            }
        }
//		/die(var_dump($post));
        return $post;
    }

    public function remove_post_user()
    {
        $p = org_charts_items_posts::find(Request::input('post_id'));
        $p->user_id = '';
        $p->save();
        $post = DB::table('hamahang_org_charts_items_posts')
            ->whereNull('deleted_at')
            ->where('chart_item_id', '=', $p->chart_item_id)
            ->get();
        foreach ($post as $p) {
            if ($p->user_id == '') {
                $p->user_id = 'no';
            } else {
                $user = User::find($p->user_id);
                $p->user_info = $user;
            }
        }
        return $post;
    }

    public function GetItemChildren()
    {
        $ID = Request::input('id');
        $sort = Request::input('sort');
        $current = Request::input('current');
        $rowCount = Request::input('rowCount');
        $searchPhrase = Request::input('searchPhrase');
        $OrgChartItem = new org_chart_items;
        $total = DB::table('hamahang_org_charts_items')->where('parent_id', '=', $ID)->select('title', 'description', 'created_at', 'updated_at', 'id')->get();
        //die(var_dump($total));
        $data = collect($total)->map(function ($x) {
            return (array)$x;
        })->toArray();
        $result['data'] = $data;
        return json_encode($result);

//        $total = $OrgChartItem
//            ->where('title', 'LIKE', '%' . $searchPhrase . '%')
//            ->where('parent_id', '=', $ID)
//            ->count();
//        //Auth::id()
//        if ($sort) {
//            $sort_field = array_keys($sort)[0];
//            $sort_order = $sort[array_keys($sort)[0]];
//        } else {
//            $sort_field = 'id';
//            $sort_order = 'DESC';
//        }
//
//        if ($rowCount == -1) {
//            $data = $OrgChartItem
//                ->select("id", "title", "description", "parent_id", "updated_at", "created_at")
//                ->where('title', 'LIKE', '%' . $searchPhrase . '%')
//                ->where('parent_id', '=', $ID)
//                ->orderBy($sort_field, $sort_order)
//                ->get();
//            //Auth::id()
//        } else {
//            if ($current == 1) {
//                $cur = 0;
//            } else {
//                $cur = ($current - 1) * $rowCount;
//            }
//
//
//            $data = $OrgChartItem
//                ->select("id", "title", "description", "parent_id", "updated_at", "created_at")
//                ->where('title', 'LIKE', '%' . $searchPhrase . '%')
//                ->where('parent_id', '=', $ID)
//                ->orderBy($sort_field, $sort_order)
//                ->offset($cur)
//                ->limit($rowCount)
//                ->get();
//            //Auth::id()
//        }
//
//        $result = array(
//            'rows' => $data,
//            'total' => $total,
//            'rowCount' => $rowCount,
//            'current' => $current,
//            'id' => $ID
//        );
        //return json_encode($total);

    }

    public function select_list_organs()
    {
        return org_organs::where('title', 'Like', '%' . Request::get('term') . '%')->select('id', 'title as text')->get();
    }

    public function insert_posts()
    {
        $validator = Validator::make(Request::all(),
            [
                'mens_num' => 'required|integer',
                'share_payment' => 'required|integer',
                'female_num' => 'required|integer',
                'outsourced_num' => 'required|integer',
                'job_items' => 'exists:hamahang_org_charts_items_jobs,id',
                'need_successor_users' => 'exists:user,id',
                'working_hours.*' => 'in:full_time,working_part_time,working_shift,private_room',
                'access.*' => 'in:financial_auth,financial_server,accounting',
                'advantages.*' => 'in:private_room,shared_room,driver,car,labtop,launch,dinner,insurance,swim',
                'work_place' => ['regex:/^(([0-9]|[\x{600}-\x{6FF}\x{200c}])*\s*)*$/u'],
                'extra_title' => ['regex:/^(([0-9]|[\x{600}-\x{6FF}\x{200c}])*\s*)*$/u']
            ],
            [],
            [
                'extra_title' => 'عنوان تکمیلی',
                'mens_num' => 'تعداد مورد نیاز مرد',
                'female_num' => 'تعداد مورد نیاز زن',
                'outsourced_num' => 'تعداد قابل برون‌سپاری',
                'share_payment' => 'سهم عملکرد در پرداخت'
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {

            $org_charts_items_jobs_posts = org_charts_items_jobs_posts::create([
                'uid' => auth()->id(),
                'chart_item_job_id' => Request::get('job_items'),
                'extra_title' => Request::get('extra_title'),
                'men' => Request::get('mens_num'),
                'women' => Request::get('female_num'),
                'outsourcing' => Request::get('outsourced_num'),
                'location' => Request::get('work_place'),
                'share_performance' => Request::get('share_payment'),
                'share_performance' => Request::get('share_payment'),
            ]);
            if ($org_charts_items_jobs_posts->save()) {
                if (Request::exists('access')) {
                    foreach (Request::get('access') as $access)
                        org_charts_items_jobs_posts_access::create([
                            'uid' => auth()->id(),
                            'chart_item_post_job_id' => $org_charts_items_jobs_posts->id,
                            'type' => $access,
                        ]);
                }
                if (Request::exists('advantages')) {
                    foreach (Request::get('advantages') as $advantage)
                        org_charts_items_jobs_posts_adventage::create([
                            'uid' => auth()->id(),
                            'chart_item_post_job_id' => $org_charts_items_jobs_posts->id,
                            'type' => $advantage,
                        ]);
                }
                if (Request::exists('working_hours')) {
                    foreach (Request::get('working_hours') as $working_hours)
                        org_charts_items_jobs_posts_worktime::create([
                            'uid' => auth()->id(),
                            'chart_item_post_job_id' => $org_charts_items_jobs_posts->id,
                            'type' => $working_hours,
                        ]);
                }
                if (Request::exists('need_successor_users')) {
                    foreach (Request::get('need_successor_users') as $need_successor_users)
                        org_charts_items_jobs_posts_alternate_users::create([
                            'uid' => auth()->id(),
                            'chart_item_post_job_id' => $org_charts_items_jobs_posts->id,
                            'user_id' => $need_successor_users,
                        ]);
                }
                if (Request::exists('add_users')) {
                    foreach (Request::get('add_users') as $users)
                        org_charts_items_jobs_posts_staff::create([
                            'uid' => auth()->id(),
                            'chart_item_post_job_id' => $org_charts_items_jobs_posts->id,
                            'user_id' => $users,
                        ]);
                }
            }
            $result['success'] = true;
            $org_charts_items_jobs_posts->id = enCode($org_charts_items_jobs_posts->id);
            $result['post'] = $org_charts_items_jobs_posts;
        }
        return json_encode($result);
    }

    public function insert_staff()
    {
        $validator = Validator::make(Request::all(),
            [
                'staff_name' => 'required|regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'staff_last_name' => 'required|regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'staff_national_id' => 'numeric',
                'staff_mobile' => 'numeric',
                'staff_birth_day' => 'regex:^([1-1][2-4][0-9][0-9]-[0-1][0-9]-[0-3][0-9])$^',
                'is_married' => 'integer',
                'gender' => 'in:man,woman',
                'staff_job_corp.*' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'staff_job_pos.*' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'staff_job_begin.*' => 'regex:^([1-1][2-4][0-9][0-9]-[0-1][0-9]-[0-3][0-9])$^',
                'staff_job_end.*' => 'regex:^([1-1][2-4][0-9][0-9]-[0-1][0-9]-[0-3][0-9])$^',
                'staff_edu_uni.*' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'staff_edu_grade.*' => 'in:diploma,after_diploma,bsc,msc,phd',
                'staff_edu_major.*' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'staff_edu_date_grade.*' => 'regex:^([1-1][2-4][0-9][0-9]-[0-1][0-9]-[0-3][0-9])$^',
                'staff_organ' => 'integer',
                'chart_item' => 'integer',
                'chart_item_job' => 'integer',
                'chart_item_job_position_new' => 'integer',
                'chart_item_job_position.*' => 'integer'
            ],
            [],
            [
                'staff_name' => 'نام',
                'staff_last_name' => 'نام خانوادگی',
                'staff_national_id' => 'کد ملی',
                'staff_mobile' => 'موبایل',
                'staff_birth_day' => 'تاریخ تولد' . Request::input('staff_birth_day'),
                'is_married' => 'تاهل',
                'gender' => 'جنسیت',
                'staff_job_corp.*' => 'نام شرکت',
                'staff_job_pos.*' => 'سمت',
                'staff_job_begin.*' => 'تاریخ شروع',
                'staff_job_end.*' => 'تاریخ پایان',
                'staff_edu_uni.*' => 'نام دانشگاه',
                'staff_edu_grade.*' => 'مقطع تحصیلی',
                'staff_edu_major.*' => 'رشته تحصیلی',
                'staff_edu_date_grade.*' => 'فارغ التحصیلی',
                'staff_organ' => 'سازمان',
                'chart_item' => 'واحد',
                'chart_item_job' => 'شغل',
                'chart_item_job_position_new' => 'سمت',
                'chart_item_job_position.*' => 'سمت'
            ]
        );

        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $d = new jDateTime;
            if(trim(Request::get('staff_birth_day')) == '')
            {
                $date = Request::get('staff_birth_day');
            }else{
                $date = explode('-', Request::get('staff_birth_day'));
                $date = $d->Jalali_to_Gregorian($date[0], $date[1], $date[2], '-');
            }

            $staff = org_staff::create([
                'uid' => auth()->id(),
                'first_name' => Request::get('staff_name'),
                'last_name' => Request::get('staff_last_name'),
                'national_id' => Request::get('staff_national_id'),
                'mobile' => Request::get('staff_mobile'),
                'birth_date' => $date,
                'is_married' => Request::get('is_married'),
                'is_man' => Request::get('gender'),
                'home_type' => Request::get('home_type'),
                'contract_type' => Request::get('contract_type'),
                'insurance_num' => Request::get('insurance_num'),
                'veteran_precent' => Request::get('veteran_precent'),
                'captivity_duration' => Request::get('captivity_duration'),
                'address' => Request::get('address'),
                'phone' => Request::get('phone'),
                'time_war' => Request::get('time_war')
            ]);
            if ($staff->save()) {

                if (Request::exists('rel_name')) {
                    foreach (Request::get('rel_name') as $k => $marry_date) {
                        $staff->relations()->create([
                            'name' => Request::get('rel_name')[$k],
                            'edu_grade' => Request::get('rel_edu_grade')[$k],
                            'last_name' => Request::get('rel_lastname')[$k],
                            'birth_date' => Request::get('rel_date')[$k],
                            'job' => Request::get('rel_job')[$k],
                            'mobile' => Request::get('rel_mobile')[$k],
                            'rel_type' => Request::get('staff_rel_type')[$k],
                            'married_date' => Request::get('marry_date')[$k],
                        ]);
                    }
                }

                if (Request::exists('child_name')) {
                    foreach (Request::get('child_name') as $k => $child_name) {
                        $staff->childs()->create([
                            'name' => Request::get('child_name')[$k],
                            'birth_date' => Request::get('child_birth_date')[$k],
                            'grade' => Request::get('child_edu_grade')[$k],
                            'national_id' => Request::get('child_national_code')[$k],
                            'job' => Request::get('child_job')[$k],
                            'mobile' => Request::get('child_mobile')[$k],
                        ]);
                    }
                }

                if (Request::exists('related_name')) {
                    foreach (Request::get('related_name') as $k => $related_name) {
                        $staff->families()->create([
                            'name' => Request::get('related_name')[$k],
                            'last_name' => Request::get('related_lastname')[$k],
                            'national_id' => Request::get('related_code_melli')[$k],
                            'org' => Request::get('related_org')[$k],
                            'post' => Request::get('related_post')[$k]
                        ]);
                    }
                }
                if (Request::exists('staff_edu_uni')) {
                    foreach (Request::get('staff_edu_uni') as $k => $staff_edu_uni) {
                        org_staff_edu::create([
                            'uid' => auth()->id(),
                            'staff_id' => $staff->id,
                            'staff_edu_uni' => $staff_edu_uni,
                            'staff_edu_grade' => Request::get('staff_edu_grade')[$k],
                            'staff_edu_major' => Request::get('staff_edu_major')[$k],
                            'staff_edu_date_grade' => Request::get('staff_edu_date_grade')[$k]
                        ]);
                    }
                }
                if (Request::exists('staff_job_corp')) {
                    foreach (Request::get('staff_job_corp') as $k => $staff_job_corp) {
                        org_staff_jobs::create([
                            'uid' => auth()->id(),
                            'staff_id' => $staff->id,
                            'staff_job_corp' => $staff_job_corp,
                            'staff_job_pos' => Request::get('staff_job_pos')[$k],
                            'staff_job_begin' => Request::get('staff_job_begin')[$k],
                            'staff_job_end' => Request::get('staff_job_end')[$k]
                        ]);
                    }
                }
                if (Request::exists('chart_item_job_position')) {
                    foreach (Request::get('chart_item_job_position') as $k => $chart_item_job_position) {
                        org_charts_items_jobs_posts_staff::create([
                            'uid' => auth()->id(),
                            'staff_id' => $staff->id,
                            'chart_item_post_job_id' => $chart_item_job_position
                        ]);
                    }
                }
                if (Request::exists('chart_item_job_position_new')) {
                    org_charts_items_jobs_posts_staff::create([
                        'uid' => auth()->id(),
                        'staff_id' => $staff->id,
                        'chart_item_post_job_id' => Request::get('chart_item_job_position_new')
                    ]);
                }
            }
            $result['success'] = true;
        }
        return json_encode($result);
    }

    public function update_staff()
    {
        $validator = Validator::make(Request::all(),
            [
                'staff_name' => 'required|regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'staff_last_name' => 'required|regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'staff_national_id' => 'numeric',
                'staff_mobile' => 'numeric',
                'staff_birth_day' => 'regex:^([1-1][2-4][0-9][0-9]-[0-1][0-9]-[0-3][0-9])$^',
                'is_married' => 'integer',
                'gender' => 'in:man,woman',
                'staff_job_corp.*' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'staff_job_pos.*' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'staff_job_begin.*' => 'regex:^([1-1][2-4][0-9][0-9]-[0-1][0-9]-[0-3][0-9])$^',
                'staff_job_end.*' => 'regex:^([1-1][2-4][0-9][0-9]-[0-1][0-9]-[0-3][0-9])$^',
                'staff_edu_uni.*' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'staff_edu_grade.*' => 'in:diploma,after_diploma,bsc,msc,phd',
                'staff_edu_major.*' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'staff_edu_date_grade.*' => 'regex:^([1-1][2-4][0-9][0-9]-[0-1][0-9]-[0-3][0-9])$^',
                'staff_organ' => 'integer',
                'chart_item' => 'integer',
                'chart_item_job' => 'integer',
                'chart_item_job_position_new' => 'integer',
                'chart_item_job_position.*' => 'integer'
            ],
            [],
            [
                'staff_name' => 'نام',
                'staff_last_name' => 'نام خانوادگی',
                'staff_national_id' => 'کد ملی',
                'staff_mobile' => 'موبایل',
                'staff_birth_day' => 'تاریخ تولد' . Request::input('staff_birth_day'),
                'is_married' => 'تاهل',
                'gender' => 'جنسیت',
                'staff_job_corp.*' => 'نام شرکت',
                'staff_job_pos.*' => 'سمت',
                'staff_job_begin.*' => 'تاریخ شروع',
                'staff_job_end.*' => 'تاریخ پایان',
                'staff_edu_uni.*' => 'نام دانشگاه',
                'staff_edu_grade.*' => 'مقطع تحصیلی',
                'staff_edu_major.*' => 'رشته تحصیلی',
                'staff_edu_date_grade.*' => 'فارغ التحصیلی',
                'staff_organ' => 'سازمان',
                'chart_item' => 'واحد',
                'chart_item_job' => 'شغل',
                'chart_item_job_position_new' => 'سمت',
                'chart_item_job_position.*' => 'سمت'
            ]
        );

        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {

//            $d = new jDateTime;
//            $date = explode('-', Request::get('staff_birth_day'));
//            $date = $d->Jalali_to_Gregorian($date[0], $date[1], $date[2],'-');
            $sid = deCode(Request::get('sid'));
            $staff_info = org_staff::where('id', '=', $sid)->with('posts', 'edus', 'jobs', 'childs', 'spouses', 'families', 'posts.job')->first();
            $staff_info->update([
                'is_man' => Request::get('gender'),
                'first_name' => Request::get('staff_name'),
                'last_name' => Request::get('staff_last_name'),
                'national_id' => Request::get('staff_national_id'),
                'mobile' => Request::get('staff_mobile'),
                'birth_date' => Request::get('staff_birth_day'),
                'is_married' => Request::get('is_married'),
                'home_type' => Request::get('home_type'),
                'contract_type' => Request::get('contract_type'),
                'insurance_num' => Request::get('insurance_num'),
                'veteran_precent' => Request::get('veteran_precent'),
                'captivity_duration' => Request::get('captivity_duration'),
                'address' => Request::get('address'),
                'phone' => Request::get('phone'),
                'time_war' => Request::get('time_war')
            ]);
            $staff = $staff_info->id;
            $staff_info->edus()->delete();
            $staff_info->jobs()->delete();
            org_charts_items_jobs_posts_staff::where('staff_id', '=', $sid)
                ->whereIn('chart_item_post_job_id', array_column($staff_info->posts->toArray(), 'id'))->delete();

            if (Request::exists('staff_edu_uni')) {
                foreach (Request::get('staff_edu_uni') as $k => $staff_edu_uni) {
                    org_staff_edu::create([
                        'uid' => auth()->id(),
                        'staff_id' => $staff,
                        'staff_edu_uni' => $staff_edu_uni,
                        'staff_edu_grade' => Request::get('staff_edu_grade')[$k],
                        'staff_edu_major' => Request::get('staff_edu_major')[$k],
                        'staff_edu_date_grade' => Request::get('staff_edu_date_grade')[$k]
                    ]);
                }
            }
            if (Request::exists('staff_job_corp')) {
                foreach (Request::get('staff_job_corp') as $k => $staff_job_corp) {
                    org_staff_jobs::create([
                        'uid' => auth()->id(),
                        'staff_id' => $staff,
                        'staff_job_corp' => $staff_job_corp,
                        'staff_job_pos' => Request::get('staff_job_pos')[$k],
                        'staff_job_begin' => Request::get('staff_job_begin')[$k],
                        'staff_job_end' => Request::get('staff_job_end')[$k]
                    ]);
                }
            }
            if (Request::exists('chart_item_job_position')) {
                foreach (Request::get('chart_item_job_position') as $k => $chart_item_job_position) {
                    org_charts_items_jobs_posts_staff::create([
                        'uid' => auth()->id(),
                        'staff_id' => $staff,
                        'chart_item_post_job_id' => $chart_item_job_position
                    ]);
                }
            }

            if (Request::exists('chart_item_job_position_new')) {
                org_charts_items_jobs_posts_staff::create([
                    'uid' => auth()->id(),
                    'staff_id' => $staff,
                    'chart_item_post_job_id' => Request::get('chart_item_job_position_new')
                ]);
            }

            $result['success'] = true;
        }
        return json_encode($result);
    }

    public function update_doc_staff()
    {
        Request::merge([
            'staff_id' => deCode(Request::get('sid'))
        ]);
        $validator = Validator::make(Request::all(),
            [
                'staff_id' => 'required|exists:hamahang_org_staff,id',
                'home_type' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'contract_type' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'insurance_num' => 'numeric',
                'veteran_precent' => 'numeric',
                'captivity_duration' => 'numeric',
                'time_war' => 'numeric',
                'spouse_mobile.*' => 'numeric',
                'marry_date.*' => 'regex:^([1-1][2-4][0-9][0-9]-[0-1][0-9]-[0-3][0-9])$^',
                'birth_date.*' => 'regex:^([1-1][2-4][0-9][0-9]-[0-1][0-9]-[0-3][0-9])$^',
                'spouse_job.*' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'spouse_lastname.*' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'spouse_name.*' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'child_job.*' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'child_name.*' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'child_mobile.*' => 'numeric',
                'child_national_code.*' => 'numeric',
//                'child_edu_grade.*' => 'numeric',
                'child_birth_date.*' => 'regex:^([1-1][2-4][0-9][0-9]-[0-1][0-9]-[0-3][0-9])$^',
                'related_name.*' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'related_lastname.*' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'related_post.*' => 'regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                'related_code_melli.*' => 'numeric',
            ],
            [],
            [
                'staff_id' => 'کارمند ',
                'home_type' => 'نوع مسکن',
                'contract_type' => 'نوع قرارداد',
                'insurance_num' => 'شماره بیمه',
                'veteran_precent' => 'درصد جانبازی',
                'captivity_duration' => 'مدت اسارت',
                'time_war' => 'مدت حضور در جبهه',
                'spouse_mobile.*' => 'موبایل همسر',
                'marry_date.*' => 'تاریخ ازدواج',
                'birth_date.*' => 'تاریخ تولد همسر',
                'spouse_job.*' => 'شغل همسر',
                'spouse_lastname.*' => 'نام خانوادگی همسر',
                'spouse_name.*' => 'نام همسر',
                'child_job.*' => 'شغل فرزند',
                'child_name.*' => 'نام فرزند',
                'child_mobile.*' => 'موبایل فرزند',
                'child_national_code.*' => 'کد ملی فرزند',
                'child_edu_grade.*' => 'تحصیلات فرزند',
                'child_birth_date.*' => 'تاریخ تولد فرزند',
                'related_name.*' => 'نام آشنا',
                'related_lastname.*' => 'نام خانوادگی آشنا',
                'related_post.*' => 'سمت آشنا',
                'related_code_melli.*' => 'کد ملی آشنا'
            ]
        );

        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $staff = org_staff::find(Request::get('staff_id'));
            $staff->home_type = Request::get('home_type');
            $staff->contract_type = Request::get('contract_type');
            $staff->insurance_num = Request::get('insurance_num');
            $staff->veteran_precent = Request::get('veteran_precent');
            $staff->captivity_duration = Request::get('captivity_duration');
            $staff->time_war = Request::get('time_war');
            if ($staff->save()) {
                $staff->spouses()->delete();
                $staff->childs()->delete();
                $staff->families()->delete();

                if (Request::exists('marry_date')) {
                    foreach (Request::get('marry_date') as $k => $marry_date) {
                        $staff->spouses()->create([
                            'name' => Request::get('spouse_name')[$k],
                            'last_name' => Request::get('spouse_lastname')[$k],
                            'birth_date' => Request::get('birth_date')[$k],
                            'job' => Request::get('spouse_job')[$k],
                            'mobile' => Request::get('spouse_mobile')[$k],
                            'married_date' => Request::get('marry_date')[$k],
                        ]);
                    }
                }

                if (Request::exists('child_name')) {
                    foreach (Request::get('child_name') as $k => $child_name) {
                        $staff->childs()->create([
                            'name' => Request::get('child_name')[$k],
                            'birth_date' => Request::get('child_birth_date')[$k],
                            'grade' => Request::get('child_edu_grade')[$k],
                            'national_id' => Request::get('child_national_code')[$k],
                            'job' => Request::get('child_job')[$k],
                            'mobile' => Request::get('child_mobile')[$k],
                        ]);
                    }
                }

                if (Request::exists('related_name')) {
                    foreach (Request::get('related_name') as $k => $related_name) {
                        $staff->families()->create([
                            'name' => Request::get('related_name')[$k],
                            'last_name' => Request::get('related_lastname')[$k],
                            'national_id' => Request::get('related_code_melli')[$k],
                            'post' => Request::get('related_post')[$k]
                        ]);
                    }
                }

            }

            $result['success'] = true;
        }
        return json_encode($result);
    }

    public function edit_post()
    {
        $validator = Validator::make(Request::all(),
            [
                'share_payment' => 'required|integer',
                'need_successor_users' => 'exists:user,id',
                'working_hours.*' => 'in:full_time,working_part_time,working_shift,private_room',
                'access.*' => 'in:financial_auth,financial_server,accounting',
                'advantages.*' => 'in:private_room,shared_room,driver,car,labtop,launch,dinner,insurance,swim',
                'work_place' => ['regex:/^(([0-9]|[\x{600}-\x{6FF}\x{200c}])*\s*)*$/u'],
                'extra_title' => ['regex:/^(([0-9]|[\x{600}-\x{6FF}\x{200c}])*\s*)*$/u']
            ],
            [],
            [
                'extra_title' => 'عنوان تکمیلی',
                'mens_num' => 'تعداد مورد نیاز مرد',
                'female_num' => 'تعداد مورد نیاز زن',
                'outsourced_num' => 'تعداد قابل برون‌سپاری',
                'share_payment' => 'سهم عملکرد در پرداخت'
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {

            $post = org_charts_items_jobs_posts::find(deCode(Request::input('post_id')));

            $post->extra_title = Request::input('extra_title');
            $post->location = Request::input('work_place');
            $post->share_performance = Request::input('share_payment');

            if ($post->save()) {
                org_charts_items_jobs_posts_access::where('chart_item_post_job_id', '=', $post->id)->delete();
                org_charts_items_jobs_posts_adventage::where('chart_item_post_job_id', '=', $post->id)->delete();
                org_charts_items_jobs_posts_worktime::where('chart_item_post_job_id', '=', $post->id)->delete();
                org_charts_items_jobs_posts_staff::where('chart_item_post_job_id', '=', $post->id)->delete();
                if (Request::exists('access')) {
                    foreach (Request::get('access') as $access)
                        org_charts_items_jobs_posts_access::create([
                            'uid' => auth()->id(),
                            'chart_item_post_job_id' => $post->id,
                            'type' => $access,
                        ]);
                }
                if (Request::exists('advantages')) {
                    foreach (Request::get('advantages') as $advantage)
                        org_charts_items_jobs_posts_adventage::create([
                            'uid' => auth()->id(),
                            'chart_item_post_job_id' => $post->id,
                            'type' => $advantage,
                        ]);
                }
                if (Request::exists('working_hours')) {
                    foreach (Request::get('working_hours') as $working_hours)
                        org_charts_items_jobs_posts_worktime::create([
                            'uid' => auth()->id(),
                            'chart_item_post_job_id' => $post->id,
                            'type' => $working_hours,
                        ]);
                }
                if (Request::exists('add_users')) {
                    foreach (Request::get('add_users') as $users)
                        org_charts_items_jobs_posts_staff::create([
                            'uid' => auth()->id(),
                            'chart_item_post_job_id' => $post->id,
                            'staff_id' => $users,
                        ]);
                }
            }
            $updated_post = org_charts_items_jobs_posts::with('users')->find(deCode(Request::input('post_id')));

            $result['user'] = '';
            if(isset($updated_post->user->staff))
                $result['user'] = $updated_post->user->staff->first_name. ' '. $updated_post->user->staff->last_name;

            $result['success'] = true;
            $post->id = enCode($post->id);
            $result['post'] = $post;
        }
        return json_encode($result);
    }

    public function edit_job_unit()
    {
        $validator = Validator::make(Request::all(),
            [
                'mens_num' => 'required|integer',
                'female_num' => 'required|integer',
                'outsourced_num' => 'required|integer',
                'need_successor_users' => 'exists:user,id'
            ],
            [],
            [
                'mens_num' => 'تعداد مورد نیاز مرد',
                'female_num' => 'تعداد مورد نیاز زن',
                'outsourced_num' => 'تعداد قابل برون‌سپاری'
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $job_id = deCode(Request::input('job_id'));
            $org_charts_items_jobs = org_charts_items_jobs::find($job_id);
            $org_charts_items_jobs->amount = Request::input('amount');
            $org_charts_items_jobs->description = Request::input('comment');
            $org_charts_items_jobs->women = Request::input('female_num');
            $org_charts_items_jobs->men = Request::input('mens_num');
            $org_charts_items_jobs->outsourcing = Request::input('outsourced_num');
            $org_charts_items_jobs->save();
            org_charts_items_jobs_alternate_users::where('chart_item_job_id', '=', $job_id)->delete();
            if (Request::exists('need_successor_users')) {
                foreach (Request::get('need_successor_users') as $need_successor_users)
                    org_charts_items_jobs_alternate_users::create([
                        'uid' => auth()->id(),
                        'chart_item_job_id' => $job_id,
                        'user_id' => $need_successor_users,
                    ]);
            }
            $result['success'] = true;
            $org_charts_items_jobs->id = enCode($org_charts_items_jobs->id);
            $result['post'] = $org_charts_items_jobs;
        }
        return json_encode($result);
    }

    public function insert_organs()
    {
        $validator = Validator::make(Request::all(),
            [
                'organ_title' => 'required',
                'organ_level' => 'numeric|min:0|max:5',
                'parent_organ' => 'exists:hamahang_org_organs,id'
            ],
            [],
            [
                'organ_title' => 'عنوان ',
                'parent_organ' => 'سازمان ',
                'organ_level' => 'سطح سازمان ',
                'organ_description' => 'توضیحات'
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
//            insert_organs
            $organ_title = Request::get('organ_title');
            $organ_level = Request::get('organ_level');
            $organ_description = Request::get('organ_description');
            $organ_parent = (Request::get('parent_organ') ? Request::get('parent_organ') : 0);
            $organs = org_organs::create([
                'uid' => auth()->id(),
                'parent_id' => $organ_parent,
                'level' => $organ_level,
                'title' => $organ_title,
                'description' => $organ_description,
            ]);

            $organs_id = $organs->id;
            $chart = org_charts::create([
                'uid' => auth()->id(),
                'org_organs_id' => $organs_id,
                'title' => $organ_title,
                'description' => $organ_parent,

            ]);


            $Charts_ID = $chart->id;
            $current_root = org_chart_items::where('chart_id', '=', $Charts_ID)->where('parent_id', '=', 0)->first();

            $node = new org_chart_items;
            $node->uid = auth()->id();
            $node->chart_id = $Charts_ID;
            $node->parent_id = 0;
            $node->title = trans('org_chart.organizational_unit');
            $node->description = trans('org_chart.organizational_unit');
            $node->save();

            if ($current_root) {
                $current_root->parent_id = $node->id;
                $current_root->save();
            }

            $result['success'] = true;
        }
        return json_encode($result);
    }

    public function edit_organs()
    {

        $validator = Validator::make(Request::all(),
            [
                'organ_title' => 'required',
                'organ_level' => 'numeric|min:0|max:5',
                'parent_organ' => 'exists:hamahang_org_organs,id'
                /*'id_organ'=>'required|exists:hamahang_org_organs,id'*/
            ],
            [],
            [
                'organ_title' => 'عنوان ',
                'parent_organ' => 'سازمان ',
                'organ_description' => 'توضیحات'

            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $organ_title = Request::get('organ_title');
            $organ_description = Request::get('organ_description');
            $organ_id = deCode(Request::get('org_id'));
            $organ_level = Request::get('organ_level');
            $organ_parent = (Request::get('parent_organ') ? Request::get('parent_organ') : 0);
            $organ = org_organs::find($organ_id);
            $organ->title = $organ_title;
            $organ->description = $organ_description;
            $organ->level = $organ_level;
            $organ->parent_id = $organ_parent;
            $organ->save();
            $result['success'] = true;
        }
        return $result;
    }

    public function edit_chart()
    {

        $validator = Validator::make(Request::all(),
            [
                'chart_title' => 'required',
                'chart_id' => 'required|exists:hamahang_org_charts,id'
            ],
            [],
            [
                'organ_title' => 'عنوان ',
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $organ_title = Request::get('chart_title');
            $organ_description = Request::get('chart_description');
            $chart_id = Request::get('chart_id');
            $chart = org_charts::find($chart_id);
            $chart->title = $organ_title;
            $chart->description = $organ_description;
            $chart->save();
            $result['success'] = true;
        }
        return $result;
    }

    private function get_child($id)
    {
        $list_child = org_organs::select('id')->where('parent_id', 4)->get();
    }

    public function select_list_edit_organs()
    {
        $validator = Validator::make(Request::all(),
            [
                'organ_id' => 'required|exists:hamahang_org_organs,id',
            ],
            [],
            [
                'organ_id' => 'سازمان ',
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        $list_child = org_organs::select('id')->where('parent_id', 4)->get();
        // dd($list_child->toArray());
        return org_organs::where('title', 'Like', '%' . Request::get('term') . '%')->whereNotIn('id', [$list_child->toArray()])->select('id', 'title as text')->get();
    }

    public function add_chart_item_child()
    {
        $validator = Validator::make(Request::all(),
            [
                'new_item_title' => 'required',
                'item_id' => 'required',
                'chart_id' => 'required|exists:hamahang_org_charts,id'
            ],
            [],
            [
                'new_item_title' => 'عنوان ',
                'new_item_title' => 'عنوان ',
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $chart_item = new org_chart_items();
            $chart_item->title = Request::get('new_item_title');
            $chart_item->description = Request::get('new_item_description');
            $chart_item->parent_id = Request::get('item_id');
            $chart_item->chart_id = Request::get('chart_id');
            if ($chart_item->save())
                $result['success'] = true;
            else $result['success'] = false;
        }
        return $result;
    }

    public function add_job_post()
    {
        $validator = Validator::make(Request::all(),
            [
                'unit_id' => 'required|numeric',
                'job' => 'required',
                'amount' => 'required|numeric|min:0|max:100',
                'comment' => ['regex:/^(([0-9]|[\x{600}-\x{6FF}\x{200c}])*\s*)*$/u']
            ],
            [
                'job_post' => trans('org_chart.job'),
                'job_comment' => trans('org_chart.comment'),
                'job_amount' => trans('org_chart.amount')
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $job_id = Request::get('job');
            if (substr($job_id, 0, 8) == 'exist_in') {
                $job_id = (int)substr($job_id, 8);
            } else {
                $new_job = onet_job::create([
                    'title' => $job_id
                ]);
                $job_id = (int)$new_job->id;
            }

            $job = onet_job::find($job_id);
            $org_chart_items_jobs = new org_chart_items_jobs();
            $org_chart_items_jobs->chart_item_id = Request::get('unit_id');
            $org_chart_items_jobs->job_id = $job_id;
            $org_chart_items_jobs->amount = Request::get('amount');
            $org_chart_items_jobs->description = Request::get('comment');
            if ($org_chart_items_jobs->save()) {
                $semats = [];
                for ($i = 0; $i < Request::get('amount'); $i++) {
                    $org_charts_items_jobs_posts = new org_charts_items_jobs_posts();
                    $org_charts_items_jobs_posts->uid = auth()->id();
                    $org_charts_items_jobs_posts->extra_title = $job->title;
                    $org_charts_items_jobs_posts->chart_item_job_id = $org_chart_items_jobs->id;
                    $org_charts_items_jobs_posts->save();
                    $semats[] = [
                        'title' => $job->title,
                        'jobId' => enCode($org_charts_items_jobs_posts->id)
                    ];
                }
                $result['success'] = true;
                $result['job_item'] = $org_chart_items_jobs->id;
                $result['semats'] = $semats;

            } else $result['success'] = false;
        }
        return $result;
    }

    public function add_chart_item_post()
    {

        $validator = Validator::make(Request::all(),
            [
                'new_post_title' => 'required',
                'item_id' => 'required',

            ],
            [],
            [
                'new_post_title' => 'عنوان ',

            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $chart_item_post = new org_charts_items_posts();
            $chart_item_post->title = Request::get('new_post_title');
            $chart_item_post->description = Request::get('new_post_description');
            $chart_item_post->chart_item_id = Request::get('item_id');
            $chart_item_post->user_id = 0;
            if ($chart_item_post->save())
                $result['success'] = true;
            else $result['success'] = false;
        }
        return $result;
    }

    public function delete_employ_post()
    {

        $validator = Validator::make(Request::all(),
            [
                'post_id' => 'required|exists:hamahang_org_charts_items_posts,id',

            ],
            [],
            [
                'post_id' => 'آیدی',
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $chart_item_post = org_charts_items_posts::find(Request::get('post_id'));
            $chart_item_post->user_id = 0;
            if ($chart_item_post->save())
                $result['success'] = true;
            else $result['success'] = false;
        }
        return json_encode($result);
    }

    public function select_list_employ()
    {
        if (!empty(Request::get('term')))
            return User::where('Uname', 'Like', '%' . Request::get('term') . '%')->orwhere('Name', 'Like', '%' . Request::get('term') . '%')->orwhere('Family', 'Like', '%' . Request::get('term') . '%')->select('id', 'Family as text')->get();
    }

    public function add_employ_for_post()
    {

        $validator = Validator::make(Request::all(),
            [

                'post_id' => 'required|exists:hamahang_org_charts_items_posts,id'
            ],
            [],
            [
                'employ_id' => 'کارمند ',
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $chart_item_post = org_charts_items_posts::find(Request::get('post_id'));
            $chart_item_post->user_id = (Request::get('employ_id')) ? Request::get('employ_id') : 0;
            if ($chart_item_post->save())
                $result['success'] = true;
            else $result['success'] = false;
        }
        return $result;
    }

    public function delete_item_job()
    {

        $validator = Validator::make(Request::all(),
            [
                'ref_id' => 'required|exists:hamahang_org_charts_items_jobs,id'
            ],
            [],
            [
                'ref_id' => 'شغل ',
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $job = org_charts_items_jobs::find(Request::get('ref_id'));
            $job->posts()->delete();
            if ($job->delete())
                $result['success'] = true;
            else $result['success'] = false;
        }
        return $result;
    }

    public function delete_item_job_post()
    {

        $validator = Validator::make(Request::all(),
            [
                'ref_id' => 'required|exists:hamahang_org_charts_items_jobs_posts,id'
            ],
            [],
            [
                'ref_id' => 'سمت ',
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $post = org_charts_items_jobs_posts::find(Request::get('ref_id'));
            $post->adventages()->delete();
            $post->accesses()->delete();
            $post->alternate_users()->delete();
            $post->users()->delete();
            $post->worktime()->delete();
            if ($post->delete())
                $result['success'] = true;
            else $result['success'] = false;
        }
        return $result;
    }

    public function delete_staff_position()
    {
        $validator = Validator::make(Request::all(),
            [
                'ref_id' => 'required|exists:hamahang_org_charts_items_jobs_posts_staff,id'
            ],
            [],
            [
                'ref_id' => 'شغل ',
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $staff_post = org_charts_items_jobs_posts_staff::find(Request::get('ref_id'));
            if ($staff_post->delete())
                $result['success'] = true;
            else $result['success'] = false;
        }
        return $result;
    }

    public function get_user_info()
    {
        $validator = Validator::make(Request::all(),
            [
                'user_id' => 'required|exists:user,id'
            ],
            [],
            [
                'user_id' => 'کاربر ',
            ]
        );

        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $user = User::find(Request::get('user_id'));
            $result['success'] = true;
            $result['user'] = $user;
        }
        return $result;
    }

    public function delete_staff()
    {
        Request::merge([
            'staff_id' => deCode(Request::get('ref_id'))
        ]);
        $validator = Validator::make(Request::all(),
            [
                'staff_id' => 'required|exists:hamahang_org_staff,id'
            ],
            [],
            [
                'staff_id' => 'کارمند ',
            ]
        );
        if ($validator->fails()) {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        } else {
            $staff_info = org_staff::where('id', '=', Request::get('staff_id'))->with('posts', 'edus', 'jobs', 'childs', 'spouses', 'families', 'posts.job')->first();
            $staff_info->edus()->delete();
            $staff_info->jobs()->delete();
            org_charts_items_jobs_posts_staff::where('staff_id', '=', Request::get('staff_id'))->delete();

            if ($staff_info->delete())
                $result['success'] = true;
            else $result['success'] = false;
        }
        return $result;
    }

    public function update_one_chart_item()
    {
        {
            $validator = Validator::make(Request::all(),
                [
                    'item_title' => 'required|regex:/^(([\x{600}-\x{6FF}\x{200c}])*\s*)*$/u',
                    'item_id' => 'exists:hamahang_org_charts_items,id',
                    'item_parent_id' => 'exists:hamahang_org_charts_items,id'
                ],
                [],
                [
                    'item_title' => 'عنوان',
                    'item_description' => 'توضیحات',
                    'item_parent_id'=>'والد',
                ]
            );
            if ($validator->fails()) {
                $result['error'] = $validator->errors();
                $result['success'] = false;
                return json_encode($result);
            } else {

                $chart_item = org_chart_items::find(Request::get('item_id'));

                $chart_item->title = (Request::get('item_title'));
                $chart_item->description = (Request::get('item_description'));
                if(Request::exists('item_parent_id'))
                {
                    $chart_item->parent_id = (Request::get('item_parent_id'));
                }
                if ($chart_item->save()) {
                    $result['success'] = true;
                    org_charts_items_missions::where('chart_item_id', '=', $chart_item->id)->delete();
                    if (Request::exists('unit_missions')) {
                        foreach (Request::get('unit_missions') as $missions) {
                            if (substr($missions, 0, 8) == 'exist_in') {
                                $missions = (int)substr($missions, 8);
                            } else {
                                $new_missions = org_osi::create([
                                    'title' => $missions
                                ]);
                                $missions = (int)$new_missions->id;
                            }
                            org_charts_items_missions::create([
                                'uid' => auth()->id(),
                                'chart_item_id' => $chart_item->id,
                                'mission_id' => $missions
                            ]);
                        }
                    }
                } else $result['success'] = false;
            }
            return json_encode($result);
        }
    }


}

