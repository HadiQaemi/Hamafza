<?php

namespace App\Http\Controllers\Hamahang;

use Auth;
use Request;
use Validator;
use Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Hamahang\FileManager\FileManager;
use App\Models\Hamahang\FileManager\FileMimeTypes;

class FileManagerController extends Controller
{

    public $file_type = [
        'page_image' => ['jpg', 'jpeg', 'png'],
        'page_file' => ['zip', 'doc', 'docx', 'pdf', 'mpga', 'amr', 'xls', 'xlsx', 'ppt', 'pptx'],
    ];
    private function PrepareUploadedFilesForJSON($section)
    {
        if (session()->has('Files'))
        {
            $FilesInSessions = session('Files');
            if (array_key_exists($section, $FilesInSessions))
            {
                $FilesInSection = $FilesInSessions[$section];
                foreach ($FilesInSection as $key => $value)
                {
                    $FilesInSection[enCode($key)] = $FilesInSection[$key];
                    $FilesInSection[enCode($key)]['ID'] = enCode($value['ID']);
                    $FilesInSection[enCode($key)]['FileName'] = enCode($value['FileName']);
                    unset($FilesInSection[$key]);
                }
                return $FilesInSection;
            }
        }
        return false;
    }

    public function UploadWithAddToSession($section)
    {
        $field = "Attachments";
        $section = deCode($section);
        $succeeded_for_json = [];
        $succeeded_for_session = [];

        $failed = [];
        $allowed = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'xls', 'xlsx', 'ppt', 'pptx', 'doc', 'docx', 'pdf', 'rar', 'zip', 'tar.gz', 'gz'];
        if (Request::file("$field")[0] !== null)
        {
            /*$MC_Result = HFM_CheckMultiFile($section,Request::file("$field"));
            if(!$MC_Result['result'])
            {
                return json_encode(array('success' => False, 'error' => $MC_Result['error_msg']));
            }*/

            foreach (Request::file("$field") as $attachment)
            {
                $original_name = $attachment->getClientOriginalName();
                $ext = explode('.', $original_name);
                $ext = strtolower(end($ext));
                //$file_name='OwnerID_'.Auth::id().'_'.md5_file($attachment).'_'.time().'.'.$ext;
                $icon = HFM_MimeTypeIcon($attachment->getMimeType());
                if (in_array($ext, $allowed) === true)
                {
                    if (session()->has('TrueTypeUpload'))
                    {
                        $TrueMimeType = Session::get('TrueTypeUpload');
                        if (isset($TrueMimeType["$section"]))
                        {
                            $rules = array('file' => 'mimes:' . implode(",", $TrueMimeType["$section"]) . '|max:50000'/*---png,jpeg,jpg,gif,pdf,zip,rar,ico,,doc.docx,xls,xlsx---*/);
                        }
                        else
                        {
                            return json_encode(array('success' => False, 'error' => '' . trans('filemanager.acceptable_prefix_of_file_not_selected') . ''));
                        }
                    }
                    else
                    {
                        return json_encode(array('success' => False, 'error' => '' . trans('filemanager.acceptable_prefix_of_file_not_selected') . ''));
                    }

                    $messages = ['file.mimes' => '' . trans('filemanager.mime_type_not_allowed') . '', 'file.max' => '' . trans('filemanager.file_size_not_allowed') . ''];

                    $validator = Validator::make(array('file' => $attachment), $rules, $messages);
                    if ($validator->passes())
                    {
                        $result = HFM_Upload($attachment);
                        $succeeded_for_session[$result['ID']] = array('Icon' => $icon, 'MimeType' => $attachment->getMimeType(), 'ID' => $result['ID'], 'Size' => HFM_FileSizeConvert($result['Size']), 'FileName' => $result['FileName'], 'OrginalFileName' => $result['OrginalFileName']);
                        $result['ID'] = enCode($result['ID']);
                        $result['FileName'] = enCode($result['FileName']);
                        $succeeded_for_json[] = array('ID' => $result['ID'], 'Icon' => $icon, 'Size' => HFM_FileSizeConvert($result['Size']), 'MimeType' => $attachment->getMimeType(), 'FileName' => $result['FileName'], 'OrginalFileName' => $result['OrginalFileName']);
                    }
                    else
                    {
                        $errors = $validator->errors();
                        $failed[] = array('Icon' => $icon, 'Size' => HFM_FileSizeConvert($attachment->getSize()), 'MimeType' => $attachment->getMimeType(), 'OrginalFileName' => $original_name, 'error' => $errors);
                    }
                }
                else
                {
                    $failed[] = array('OrginalFileName' => $original_name, 'Size' => HFM_FileSizeConvert($attachment->getSize()), 'Icon' => $icon, 'MimeType' => $attachment->getMimeType(), 'error' => array('file' => '' . trans('filemanager.mime_type_not_allowed') . ''));
                }
            }
        }

        if (session()->has('Files'))
        {
            $FilesInSession = session('Files');
            if (array_key_exists($section, $FilesInSession))
            {
                $FilesForSession = $FilesInSession["$section"] + $succeeded_for_session;
            }
            else
            {
                $FilesForSession = $succeeded_for_session;
            }
            $FilesInSession[$section] = $FilesForSession;
            session()->put('Files', $FilesInSession);
        }
        else
        {
            $FilesForSession = $succeeded_for_session;
            session()->put('Files', array("$section" => $FilesForSession));
        }
        return response()->json(['success' => true, 'failed' => $failed, 'succeeded' => $succeeded_for_json, 'message' => '' . trans('filemanager.action_complete_successfully') . '', 'attachment_files' => $this->PrepareUploadedFilesForJSON($section),]);
    }

    public function AddSelectedFileToSession($section = "Null")
    {
        $field = "Attachments";
        $section = deCode($section);
        /*$MC_Result = HFM_CheckMultiFile($section,Request::get("$field"));
        if(!$MC_Result['result'])
        {
            return json_encode(array('success' => False, 'error' => ''.$MC_Result['error_msg'].''));
        }*/
        if (Session::has('TrueTypeUpload'))
        {
            $TrueMimeType = Session::get('TrueTypeUpload');
            if (isset($TrueMimeType["$section"]))
            {
                $True_mimeType_array = array();
                foreach ($TrueMimeType["$section"] as $value)
                {
                    $mime_type_record = FileMimeTypes::where('ext', '=', '.' . $value)->first();
                    if ($mime_type_record)
                    {
                        $True_mimeType_array[] = $mime_type_record->mimeType;
                    }
                }
            }
            else
            {
                return json_encode(array('success' => False, 'error' => '' . trans('filemanager.acceptable_prefix_of_file_not_selected') . ''));
            }
        }
        else
        {
            return json_encode(array('success' => False, 'error' => '' . trans('filemanager.acceptable_prefix_of_file_not_selected') . ''));
        }

        $succeeded_for_json = [];
        $succeeded_for_session = [];
        $failed = [];

        if (Request::get("$field") !== null)
        {
            foreach (Request::get("$field") as $attachment)
            {
                $file = FileManager::find(deCode($attachment));
                $icon = HFM_MimeTypeIcon($file->mimeType);
                if (in_array($file->mimeType, $True_mimeType_array))
                {
                    $succeeded_for_session[$file->id] = array('Icon' => $icon, 'MimeType' => $file->mimeType, 'ID' => $file->id, 'Size' => HFM_FileSizeConvert($file->size), 'FileName' => $file->filename, 'OrginalFileName' => $file->originalName);

                    $ID = enCode($file->id);
                    $FileName = enCode($file->filename);

                    $succeeded_for_json[] = array('ID' => $ID, 'Icon' => $icon, 'Size' => HFM_FileSizeConvert($file->size), 'MimeType' => $file->mimeType, 'FileName' => $FileName, 'OrginalFileName' => $file->originalName);
                }
                else
                {
                    $failed[] = array('Icon' => $icon, 'Size' => HFM_FileSizeConvert($file->size), 'MimeType' => $file->mimeType, 'OrginalFileName' => $file->originalName, 'error' => array('file' => '' . trans('filemanager.mime_type_not_allowed') . ''));
                }
            }
        }

        if (session()->has('Files'))
        {
            $FilesInSession = session('Files');
            if (array_key_exists($section, $FilesInSession))
            {
                $FilesForSession = $FilesInSession[$section] + $succeeded_for_session;
            }
            else
            {
                $FilesForSession = $succeeded_for_session;
            }
            $FilesInSession[$section] = $FilesForSession;
            session()->put('Files', $FilesInSession);
        }
        else
        {
            $FilesForSession = $succeeded_for_session;
            session()->put('Files', array("$section" => $FilesForSession));
        }
        return response()->json(['success' => true, 'failed' => $failed, 'succeeded' => $succeeded_for_json, 'message' => '' . trans('filemanager.action_complete_successfully') . '', 'attachment_files' => $this->PrepareUploadedFilesForJSON($section),]);
    }

    public function Download($type = "ID", $id = 0, $default_img = '404.png')
    {
        $r = null;
        if ($id === 0)
        {
            return HFM_DownloadByID(-1);//"Not Valid Request";
        }

        $id = deCode($id);
        switch ($type)
        {
            case "ID":
                $r = HFM_DownloadByID($id, $default_img);
                break;
            case "Name":
                $r = HFM_DownloadByName($id, $default_img);
                break;
            case "flag":
                $r = HFM_download_from_public_storage($id, 'flags');
                break;
            default:
                $r = HFM_DownloadByID(-1, $default_img); //"Not Valid Request";
        }
        return $r;
    }

    public function ShowGridMyFiles()
    {
        return view('FileManager.ShowGridMyFiles');
    }

    public function GridMyFiles()
    {
        return Datatables::of(FileManager::select("id", "originalName", "extension", "mimeType", "size", "created_at")->where('uid', '=', Auth::id()))
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->editColumn('size', function ($data)
            {
                return HFM_FileSizeConvert($data->size);
            })
            ->editColumn('created_at', function ($data)
            {
                return HDate_GtoJ($data->created_at);
            })
            ->make(true);
    }

    public function LoadMyFiles()
    {
        $act = Request::get('act');
        $act = trim($act) == '' ? '' : deCode($act);
        return Datatables::of(
            FileManager::select("id", "originalName", "extension", "mimeType", "size", "created_at")
                ->where('uid', '=', Auth::id())->whereIn('extension', $this->file_type[$act])
        )
            ->editColumn('en_id', function ($data)
            {
                return enCode($data->id);
            })
            ->editColumn('id', function ($data)
            {
                return enCode($data->id);
            })
            ->editColumn('size', function ($data)
            {
                return HFM_FileSizeConvert($data->size);
            })
            ->editColumn('created_at', function ($data)
            {
                return HDate_GtoJ($data->created_at);
            })
            ->orderBy('created_at', 'desc')
            ->make(true);
        dd($res);
    }

    public function ShowUploadedFiles($section)
    {
        return view('hamahang.FileManager.ShowUploadedFiles')->with('section', deCode($section));
    }

    public function RemoveFFS($section = "NULL", $record = 0)
    {
        if ($section == "NULL" || $record === 0)
        {
            $result = False;
            return json_encode($result);
        }

        $section = deCode($section);
        $record = (int)deCode($record);

        if (session()->has('Files'))
        {
            $Files = session('Files');
            if (array_key_exists($section, $Files))
            {
                $AllRemove = Request::get("AllRemove");
                if (isset($AllRemove) && !empty($AllRemove) && $AllRemove)
                {
                    unset($Files[$section]);
                    session()->forget('Files');
                    session()->put('Files', $Files);
                    $result['success'] = true;
                    return json_encode($result);
                }
                else
                {
                    if (array_key_exists($section, $Files) && $Files[$section][$record]["ID"] == $record)
                    {
                        unset($Files[$section][$record]);
                        session()->forget('Files');
                        session()->put('Files', $Files);
                        $result['success'] = true;
                        $result['All_Attachments'] = $this->PrepareUploadedFilesForJSON($section);
                        return json_encode($result);
                    }
                }
            }
        }
        $result['success'] = False;
        return json_encode($result);
    }

    public function RemoveFFDB()
    {

    }

    public function download_from_public_storage()
    {

    }

    public function tinymce_external_filemanager_form()
    {
        return view('hamahang.FileManager.tinymce.external_filemanager_addedit');
    }

    public function tinymce_external_filemanager()
    {
        $validator = Validator::make
        (
            Request::all(),
            [
                'pid' => 'required|integer',
                'image' => 'required|mimes:png,jpg,jpeg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',
            ], [],
            [
                'image' => 'فرمت فایل باید یکی از mimes:png,jpg,jpeg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx باشد.'
            ]
        );
        $folder = 'pages';
        $form = Request::all();
        if(isset($form['form_type'])){
            $folder = 'tasks';
            $form['pid'] = md5($form['pid']).time().rand(1,100).rand(1,100);
        }
        if ($validator->fails())
        {
            return response()->json(['success' => false, 'result' => $validator->errors()]);
        }

        $upload = HFM_Upload(Request::file('image'), $folder.'/' . $form['pid'] . '/');

        $r = route('FileManager.DownloadFile', ['type' => 'ID', 'id' => enCode($upload['ID'])]);

        return response()->json(['success' => true, 'result' => [$r], 'FileName' => $upload['FileName'], 'FileID' => enCode($upload['ID'])]);
    }

}