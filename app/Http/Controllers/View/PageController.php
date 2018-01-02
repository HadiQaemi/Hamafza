<?php

namespace App\Http\Controllers\View;

use App\HamafzaServiceClasses\SubjectRelation;
use App\Models\hamafza\Pages;
use App\Models\Hamahang\SubjectRel;
use Auth;
use App\Http\Requests;
use App\HamafzaViewClasses;
use App\Http\Controllers\Controller;
use App\HamafzaViewClasses\PageClass;

//use App\HamafzaViewClasses\KeywordClass;
//use App\HamafzaViewClasses\DesktopClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{

    public function update_relations(Request $request)
    {
        //dd($request->all());
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $sid = $request->input('rel_sid');
            $relations = $request->input('relations');
            $subject_rel = $request->input('subject_rel');
            //DB::table('subjects_rel')->where('sid1', $sid)->orWhere('sid2', $sid)->delete();
            SubjectRel::where('sid1', $sid)->orWhere('sid2', $sid)->delete();
            if(isset($subject_rel)){
                foreach ($subject_rel as $key => $value)
                {
                    if (!empty($value))
                    {
                        if (isset($relations[$key]))
                        {
                            $relate = $relations[$key];
                            if ($relate != '')
                            {
                                if (substr($relate[0], 0, 1) == "D")
                                {
                                    $relate = str_replace("D", '', $relate[0]);
                                    //DB::table('subjects_rel')->insert(array('sid1' => $sid, 'sid2' => $sid2, 'rel' => $relate));
                                    foreach ($value as $val)
                                    {
                                        $sid2 = $val;
                                        $check = SubjectRel::where('sid1', $sid)
                                            ->Where('sid2', $sid2)
                                            ->Where('rel', $relate)
                                            ->first();
                                        if (count($check) == 0)
                                        {
                                            $subjectRel = new SubjectRel();
                                            $subjectRel->sid1 = $sid;
                                            $subjectRel->sid2 = $sid2;
                                            $subjectRel->rel = $relate;
                                            $subjectRel->save();
                                        }
                                    }
                                }
                                elseif (substr($relate[0], 0, 1) == "I")
                                {
                                    $relate = str_replace("I", '', $relate[0]);
                                    //DB::table('subjects_rel')->insert(array('sid1' => $sid2, 'sid2' => $sid, 'rel' => $relate));
                                    foreach ($value as $val)
                                    {
                                        $sid2 = $val;
                                        $check = SubjectRel::where('sid1', $sid2)
                                            ->Where('sid2', $sid)
                                            ->Where('rel', $relate)
                                            ->first();

                                        if (count($check) == 0)
                                        {
                                            $subjectRel = new SubjectRel();
                                            $subjectRel->sid1 = $sid2;
                                            $subjectRel->sid2 = $sid;
                                            $subjectRel->rel = $relate;
                                            $subjectRel->save();
                                        }
                                    }
                                }
                            }
                        }

                    }
                }
            }else{
                $result['success'] = true;
                session()->flash('message', 'روابط با موفقیت ویرایش شد');
                session()->flash('mestype', 'success');
                return json_encode($result);
            }

            $result=[];
            if($subjectRel){
                $result['success'] = true;
                session()->flash('message', 'روابط با موفقیت ویرایش شد');
                session()->flash('mestype', 'success');
                return json_encode($result);
            }else{
                $result['success'] = false;
                $result['message'][] = 'ویرایش اطلاعات با مشکل مواجه شد . دوباره امتحان کنید.';
                return json_encode($result);
            }
            //return Redirect()->back()->with('message', $user)->with('mestype', 'success');
        }
    }

    public function ADDPageFilm(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $pid = $request->input('pid');
            $PreTitle = $request->input('PreTitle');
            $Title = $request->input('Title');
            $Time = $request->input('Time');
            $Picfile = $request->file('Picfile');
            $Filmfile = $request->file('Filmfile');
            $Desce = $request->input('Desce');
            $i = 1;
            foreach ($Picfile as $key => $file)
            {
                $input = array('image' => $file);
                $rules = array(
                    'image' => 'image'
                );
                $path = '';
                $validator = Validator::make($input, $rules);
                if ($validator->fails())
                {
                    return 'لطفا تنها فایل تصویری انتخاب کنید';
                    $pics[$i] = '';
                }
                else
                {
                    if ($file)
                    {
                        if ($file->isValid())
                        {
                            $tmpFilePath = 'videos/';
                            $extension = $file->getClientOriginalExtension();
                            $tmpFileName = $uid . time() . '.' . $extension; // renameing image
                            $img = Image::make($file->getRealPath());
                            $img->resize(450, null, function ($constraint)
                            {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });
                            $img->save('videos/' . $tmpFileName)->destroy();
                            $pics[$i] = $tmpFileName;
                        }
                        else
                        {
                            $pics[$i] = '';
                        }
                    }
                }
                $i++;
            }
            $i = 1;
            $films = array();
            foreach ($Filmfile as $key => $file)
            {
                if ($file)
                {
                    $tmpFilePath = 'videos/';
                    $extension = $file->getClientOriginalExtension();
                    if ($extension == 'mov' || $extension == 'mp4' || $extension == 'mkv')
                    {
                        $tmpFileName = $uid . time() . '.' . $extension; // renameing image
                        $file->move('videos/', $tmpFileName);
                        $films[$i] = $tmpFileName;
                    }
                    else
                    {
                        $films[$i] = '';
                    }
                }

                $i++;
            }
            $SP = new \App\HamafzaServiceClasses\PageClass();
            $menu = $SP->ADDPageFilm($uid, $sesid, $films, $pics, $PreTitle, $Title, $Desce, $pid, $Time);
            return Redirect()->back()->with('message', $menu)->with('mestype', 'success');
        }
    }

    public function ADDPageSlide(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $pid = $request->input('pid');
            $files = $request->file('file');
            $filetitle = $request->input('ftitle');
            $file_count = count($files);
            $uploadcount = 0;
            $Slides = '';
            foreach ($files as $key => $file)
            {
                $input = array('image' => $file);
                $rules = array(
                    'image' => 'image'
                );
                $path = '';
                $validator = Validator::make($input, $rules);
                if ($validator->fails())
                {
                    return 'لطفا تنها فایل تصویری انتخاب کنید';
                }
                else
                {
                    if ($file)
                    {
                        if ($file->isValid())
                        {
                            $tmpFilePath = 'slides/';
                            $extension = $file->getClientOriginalExtension();
                            $tmpFileName = $uid . time() . '.' . $extension; // renameing image
                            $img = Image::make($file->getRealPath());
                            $img->resize(800, null, function ($constraint)
                            {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });
                            $img->save('slides/' . $tmpFileName, 100)->destroy();
                            $Slides[$uploadcount]['name'] = $tmpFileName;
                            $Slides[$uploadcount]['title'] = $filetitle[$key];
                        }
                    }
                }
                $uploadcount++;
            }
            $SP = new \App\HamafzaServiceClasses\PageClass();
            $menu = $SP->AddPageSlide($uid, $sesid, $pid, $Slides);
            return Redirect()->back()->with('message', $menu)->with('mestype', 'success');
        }
    }

//    public function AttachFileinPage(Request $request)
//    {
//        if (!Auth::check())
//        {
//            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
//        }
//        else
//        {
//            $uid = (session('uid') != '') ? session('uid') : 0;
//            $sesid = (session('sesid') != '') ? session('sesid') : 0;
//            $pics = array();
//            $pid = $request->input('Fpid');
//            $ftitle = $request->input('ftitle');
//            $attachfile = $request->file('file');
//            $Filmfile = $request->file('Filmfile');
//            $Desce = $request->input('Desce');
//            $delfile = $request->input('delfile');
//            if (is_array($attachfile) && count($attachfile) > 0)
//            {
//                foreach ($attachfile as $key => $file)
//                {
//                    if ($file && $file->isValid())
//                    {
//                        $tmpFilePath = 'files/page/';
//                        $extension = $file->getClientOriginalExtension();
//                        $size = $file->getSize();
//                        $tmpFileName = $pid . time() . '.' . $extension; // renameing image
//                        $file->move($tmpFilePath, $tmpFileName);
//                        $pics[$key]['address'] = $tmpFileName;
//                        $pics[$key]['title'] = $ftitle[$key];
//                        $pics[$key]['size'] = $size;
//                        $pics[$key]['type'] = $extension;
//                    }
//                }
//            }
//            $SP = new \App\HamafzaServiceClasses\PageClass();
//            $menu = $SP->AttachFileinPage($uid, $sesid, $pid, $pics, $delfile);
//            return Redirect()->back()->with('message', $menu)->with('mestype', 'success');
//        }
//    }

    public function EditPageSend(Request $request)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $uid = (session('uid') != '') ? session('uid') : 0;
            $sesid = (session('sesid') != '') ? session('sesid') : 0;
            $pid = $request->input('pid');
            $content = $request->input('content_body');
            $content = str_replace('src="../../tinymce', 'src="' . url('/') . '/tinymce', $content);
            $ver_comment = $request->input('edit_com');
            $ver_date = $request->input('ver_date');
            $edit_num = $request->input('edit_num');
            $description = $request->input('description');
            $PC = new PageClass();
            $content = \App\HamafzaServiceClasses\PageClass::helper_maker($content, $pid);
            $s = $PC->EditPageSend($pid, $uid, $sesid, $content, $ver_comment, $ver_date, $edit_num, $description);
            return $s;
        }
    }

    public function PageEditDetail($id, $PageType)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $res = variable_generator('page', 'edit', $id, ['PageType' => $PageType]);
            if (false)
            {
                view('pages.PageEdit');
            }
            return view($res['viewname'], $res);
        }
    }

    public function PageForum($id, $Type = '')
    {
        $param = ['id' => $id, 'Type' => $Type];
        $res = variable_generator('page', 'forum', $id, $param);
        return view($res['viewname'], $res);
    }

    public function history($id = '', $hid = '')
    {
        $param = ['id' => $id, 'hid' => $hid];
        $res = variable_generator('page', 'history', $id, $param);
        return view($res['viewname'], $res);
    }

    public function PageDetails($PreCode = '', $id = '', $Type = '')
    {
        if ($id == 'OnlyTree')
        {
            $Type = 'OnlyTree';
        }
        $id = ($PreCode != '' && $id != '' && is_numeric($id)) ? $id : $PreCode;
        $param = ['id' => $id, 'Type' => $Type, 'PreCode' => $PreCode];
        $res = variable_generator('page', 'defualt', $id, $param);
        return view($res['viewname'], $res);
    }

    public function PageDesktop($id)
    {
        $res = variable_generator('page', 'desktop', $id);
        if (false) { view('pages.page_desktop_dashboard'); }
        return view($res['viewname'], $res);
    }

    public function PageDesktop_Announces($id)
    {
        $PC = new PageClass();
        return $PC->highlights($id);
    }

    public function PageDesktop_highlights($id)
    {
        $PC = new PageClass();
        return $PC->highlights($id);
    }

    public function savePageImage(Request $request)
    {
        return SIUSaveImage($request, 'jpg,png,jpeg', Pages::find($request->item_id), 'defimage');
    }

    public function renamePageImage(Request $request)
    {
        return SIURenameImage($request);
    }

    public function removePageImage(Request $request)
    {
        return SIURemoveImage(Pages::find($request->item_id), 'defimage');
    }

    public function highlights($id)
    {
        $res = variable_generator('page', 'highlights', $id);
        return view($res['viewname'], $res);
    }

    public function announces($id)
    {
        $res = variable_generator('page', 'announces', $id);
        if (false) { view('pages.Desktop.announces'); }
        return view($res['viewname'], $res);
    }



}
