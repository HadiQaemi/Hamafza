<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\hamafza\Subject;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Request;
use Validator;

class FileController extends Controller
{
    public function Created_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'Created_ME']);
        return view('hamahang.Files.Created_ME.Created_ME', $res);
    }

    public function Edited_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'Edited_ME']);
//        return view($res['viewname'], $res);
        return view('hamahang.Files.Edited_ME.Edited_ME', $res);
    }

    public function follow_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'follow_ME']);
//        return view($res['viewname'], $res);
        return view('hamahang.Files.follow_ME.follow_ME', $res);
    }

    public function like_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'like_ME']);
//        return view($res['viewname'], $res);
        return view('hamahang.Files.like_ME.like_ME', $res);
    }

    public function highlight_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'highlight_ME']);
//        return view($res['viewname'], $res);
        return view('hamahang.Files.highlight_ME.highlight_ME', $res);
    }

    public function ano_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'ano_ME']);
//        return view($res['viewname'], $res);
        return view('hamahang.Files.ano_ME.ano_ME', $res);
    }

    public function Sug_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'Sug_ME']);
//        return view($res['viewname'], $res);
        return view('hamahang.Files.Sug_ME.Sug_ME', $res);
    }

    public function visited_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'visited_ME']);
//        return view($res['viewname'], $res);
        return view('hamahang.Files.visited_ME.visited_ME', $res);
    }

    public function Proc_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'Proc_ME']);
//        return view($res['viewname'], $res);
        return view('hamahang.Files.Proc_ME.Proc_ME', $res);
    }

    public function ALL_ME($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'ALL_ME']);
//        return view($res['viewname'], $res);
        return view('hamahang.Files.ALL_ME.ALL_ME', $res);
    }

    public function ALL_Other($name)
    {
        $roles = Role::all(['id', 'name', 'display_name']);
        foreach ($roles as $role)
        {
            $role->text = $role->name . ' (' . $role->display_name . ')';
        }
        $with_arr = [
            'roles' => $roles
        ];
        $res = variable_generator('user', 'Files', $name, ['type' => 'ALL_Other']);
//        return view($res['viewname'], $res);
        return view('hamahang.Files.ALL_Other.ALL_Other', $res, $with_arr);
    }

    public function Deleted_pages($name)
    {
        $res = variable_generator('user', 'Files', $name, ['type' => 'Deleted_pages']);
//        return view($res['viewname'], $res);
        return view('hamahang.Files.Deleted_pages.Deleted_pages', $res);
    }

    public function get_file_created()
    {
        $subjects = Subject::with('pages')
            ->with('subject_type')
            ->where('archive', 0)
            ->where('admin', Auth::id());

        return \Datatables::eloquent($subjects)
            ->addColumn('JalaliRegDate', function ($data)
            {
                return $data->JalaliRegDate;
            })
            ->addColumn('EditDate', function ($data)
            {
                return $data->LastEdition;
            })
            ->make(true);
    }

    public function get_file_edited()
    {
        $uid = Auth::id();
        $subjects = Subject::with('subject_type')
            ->with('pages')
            ->whereHas('pages', function ($query) use ($uid)
            {
                $query->where('editor', '=', $uid);
            })
            ->where('archive', 0);

        return \Datatables::eloquent($subjects)
            ->addColumn('JalaliRegDate', function ($data)
            {
                return $data->JalaliRegDate;
            })
            ->addColumn('EditDate', function ($data)
            {
                return $data->LastEdition;
            })
            ->make(true);
    }

    public function get_file_follow()
    {
        // $uid = Auth::id();
        $subjects = Auth::user()
            ->subject_members_follow()
            ->where('archive', 0)
            ->with('subject_type')
            ->with('pages');

        return \Datatables::eloquent($subjects)
            ->addColumn('JalaliRegDate', function ($data)
            {
                return $data->JalaliRegDate;
            })
            ->addColumn('EditDate', function ($data)
            {
                return $data->LastEdition;
            })
            ->make(true);
    }

    public function get_file_like()
    {
        $subjects = Auth::user()
            ->subject_members_like()
            ->where('archive', 0)
            ->with('subject_type')
            ->with('pages');

        return \Datatables::eloquent($subjects)
            ->addColumn('JalaliRegDate', function ($data)
            {
                return $data->JalaliRegDate;
            })
            ->addColumn('EditDate', function ($data)
            {
                return $data->LastEdition;
            })
            ->make(true);
    }

    public function get_file_highlight()
    {
        $uid = Auth::id();
        $subjects = Subject::with('subject_type')
            ->with('pages.highlights')
            ->whereHas('pages.highlights', function ($query) use ($uid)
            {
                $query->where('uid', '=', $uid);
            })
            ->where('archive', 0);

        return \Datatables::eloquent($subjects)
            ->addColumn('JalaliRegDate', function ($data)
            {
                return $data->JalaliRegDate;
            })
            ->addColumn('EditDate', function ($data)
            {
                return $data->LastEdition;
            })
            ->make(true);
    }

    public function get_file_ano()
    {
        $uid = Auth::id();
        $subjects = Subject::with('subject_type')
            ->with('pages.announces')
            ->whereHas('pages.announces', function ($query) use ($uid)
            {
                $query->where('uid', '=', $uid);
            })
            ->where('archive', 0);

        return \Datatables::eloquent($subjects)
            ->addColumn('JalaliRegDate', function ($data)
            {
                return $data->JalaliRegDate;
            })
            ->addColumn('EditDate', function ($data)
            {
                return $data->LastEdition;
            })
            ->make(true);
    }

    public function get_file_sug()
    {
        $uid = Auth::id();
        $subjects = Subject::with('subject_type')
            ->with('pages.user_suggests')
            ->whereHas('pages.user_suggests', function ($query) use ($uid)
            {
                $query->where('uid', '=', $uid);
            })
            ->where('archive', 0);

        return \Datatables::eloquent($subjects)
            ->addColumn('JalaliRegDate', function ($data)
            {
                return $data->JalaliRegDate;
            })
            ->addColumn('EditDate', function ($data)
            {
                return $data->LastEdition;
            })
            ->make(true);
    }

    public function get_file_visited()
    {
        $uid = Auth::id();
        $subjects = Subject::with('subject_type')
            ->with('pages.page_visit')
            ->whereHas('pages.page_visit', function ($query) use ($uid)
            {
                $query->where('uid', '=', $uid);
            })
            ->where('archive', 0);

        return \Datatables::eloquent($subjects)
            ->addColumn('JalaliRegDate', function ($data)
            {
                return $data->JalaliRegDate;
            })
            ->addColumn('EditDate', function ($data)
            {
                return $data->LastEdition;
            })
            ->make(true);
    }

    public function get_file_proc()
    {
        $uid = Auth::id();
        $subjects = Subject::with('subject_type')
            ->with('pages')
            ->Where('manager', $uid)
            ->orWhere('supervisor', $uid)
            ->orWhere('supporter', $uid)
            ->orWhere('admin', $uid)
            ->where('archive', 0)
            ->groupBy('id');

        return \Datatables::eloquent($subjects)
            ->addColumn('JalaliRegDate', function ($data)
            {
                return $data->JalaliRegDate;
            })
            ->addColumn('EditDate', function ($data)
            {
                return $data->LastEdition;
            })
            ->make(true);
    }

    public function get_file_all()
    {
        $uid = Auth::id();
        $subjects = Subject::with('subject_type')
            ->with('pages.user_suggests')
            ->with('pages.page_visit')
            ->with('pages.highlights')
            ->with('pages.announces')
            ->Where('admin', $uid)
            ->orWhere('supervisor', $uid)
            ->orWhere('supporter', $uid)
            ->orWhere('admin', $uid)
            ->whereHas('pages.user_suggests', function ($query) use ($uid)
            {
                $query->orWhere('uid', '=', $uid);
            })
            ->whereHas('pages.page_visit', function ($query) use ($uid)
            {
                $query->orWhere('uid', '=', $uid);
            })
            ->whereHas('pages.highlights', function ($query) use ($uid)
            {
                $query->orWhere('uid', '=', $uid);
            })
            ->whereHas('pages.announces', function ($query) use ($uid)
            {
                $query->orWhere('uid', '=', $uid);
            })
            ->where('archive', 0);

        return \Datatables::eloquent($subjects)
            ->addColumn('JalaliRegDate', function ($data)
            {
                return $data->JalaliRegDate;
            })
            ->addColumn('EditDate', function ($data)
            {
                return $data->LastEdition;
            })
            ->make(true);
    }

    public function get_file_all_other()
    {
        $subjects = Subject::with('subject_type')
            ->with('owner')
            ->with('pages')
            ->where('archive', 0);

        return \Datatables::eloquent($subjects)
            ->addColumn('JalaliRegDate', function ($data)
            {
                return $data->JalaliRegDate;
            })
            ->addColumn('EditDate', function ($data)
            {
                return $data->LastEdition;
            })
            ->make(true);
    }

    public function get_file_deleted_pages()
    {
        $subjects = Subject::with('subject_type')
            ->with('pages')
            ->where('archive', '1');

        return \Datatables::eloquent($subjects)
            ->addColumn('JalaliRegDate', function ($data)
            {
                return $data->JalaliRegDate;
            })
            ->addColumn('EditDate', function ($data)
            {
                return $data->LastEdition;
            })
            ->make(true);
    }

    public function addSubjectsRoleShow()
    {
        $validator = Validator::make(Request::all(), [
            'role_id' => 'required|not_in:0',

        ], [], [
            'role_id' => 'نقش'
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $subjects = Subject::all();
            foreach ($subjects as $subject)
            {
                $subject->role_policies_edit()->attach([Request::input('role_id') => ['type' => '1']]);
            }
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function deleteSubjectsRoleShow()
    {
        $validator = Validator::make(Request::all(), [
            'role_id' => 'required|not_in:0',

        ], [], [
            'role_id' => 'نقش'
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $subjects = Subject::all();
            foreach ($subjects as $subject)
            {
                $subject->role_policies_view()->where('type', 1)->detach(Request::input('role_id'));
            }
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function addSubjectsRoleEdit()
    {
        $validator = Validator::make(Request::all(), [
            'role_id' => 'required|not_in:0',

        ], [], [
            'role_id' => 'نقش'
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $subjects = Subject::all();
            foreach ($subjects as $subject)
            {
                $subject->role_policies_edit()->attach([Request::input('role_id') => ['type' => '2']]);
            }
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function deleteSubjectsRoleEdit()
    {
        $validator = Validator::make(Request::all(), [
            'role_id' => 'required|not_in:0',

        ], [], [
            'role_id' => 'نقش'
        ]);
        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $subjects = Subject::all();
            foreach ($subjects as $subject)
            {
                $subject->role_policies_edit()->where('type', 2)->detach([Request::input('role_id')]);
            }
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }
}
