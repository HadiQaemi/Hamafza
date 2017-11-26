<?php

namespace App\Http\Controllers\Hamahang;


use App\Http\Controllers\Controller;
use App\Models\hamafza\Pages;
use App\Models\Hamahang\FileManager\Fileable;
use DB;
use Illuminate\Http\Request;
use Validator;

class PagesController extends Controller
{
    public function getPageFiles(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pid' => 'required',
        ], [
            'pid' => 'شماره صفحه'
        ]);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $page_files = Pages::find($request->pid)->files;
            foreach ($page_files as $page_file)
            {
                $page_file->encoded_file_id = enCode($page_file->id);
            }
            $result['page_files'] = $page_files;
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function savePageFiles(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pid' => 'required',
        ], [
            'pid' => 'شماره صفحه'
        ]);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $page = Pages::find($request->pid);
            $file = HFM_SaveMultiFiles('page_file', '\App\Models\Hamahang\FileManager\Fileable', 'fileable_id', $page->id, ['created_by' => auth()->id(), 'fileable_type' => 'App\Models\hamafza\Pages', 'type' => 2]);
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }

    public function removePageFiles(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_id' => 'required',
        ], [
            'file_id' => 'فایل'
        ]);

        if ($validator->fails())
        {
            $result['error'] = $validator->errors();
            $result['success'] = false;
            return json_encode($result);
        }
        else
        {
            $file = Fileable::where('file_id', $request->file_id)
                ->delete();
            $result['message'][] = trans('app.operation_is_success');
            $result['success'] = true;
            return json_encode($result);
        }
    }
}
