@extends('layouts.master')
@section('inline_scripts')
    @include('pages.helper.toolbar_inline_js')
@stop
@section('content')

@if(is_array($content))

<?php
$group_edit = $content;
?>

<link href="{{App::make('url')->to('/')}}/theme/Content/css/textassist.css" rel="stylesheet" type="text/css"/>
<script src="{{App::make('url')->to('/')}}/theme/Scripts/textassist.js" type="text/javascript"></script>
<script src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.tokeninput.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("#Groupkeywords").tokenInput("{{App::make('url')->to('/')}}/Tagsearch", {
        preventDuplicates: true,
        hintText: "عبارتی را وارد کنید",
        noResultsText: "نتیجه‌ای یافت نشد، با زدن دکمه اینتر کلیدواژه جدیدی ایجاد می‌شود",
        searchingText: "در حال جستجو",
        onAdd: function(item) {
            //add the new label into the database
            if (parseInt(item.id) == 0) {
                name = $("tester").text();
                if (name != null) {
                    $.ajax({
                        type: "POST",
                        url: "tagmergeaction.php",
                        dataType: 'html',
                        data: ({New: 'OK', Name: name}),
                        success: function(theResponse) {
                            if (theResponse != 'NOK')
                                alert('بر چسب جدید با موفقیت تعریف شد');
                            $("#Groupkeywords").tokenInput("remove", {name: name});
                            $("#Groupkeywords").tokenInput("add", {id: theResponse, name: name});
                        }
                    });
                }
            }
        },
        onResult: function(item) {
            if ($.isEmptyObject(item)) {

                return [{id: '0', name: $("tester").text()}]
            } else {
                return item
            }

        },
    });


   var keywords = <?php echo $group_edit['keywords'] ?>;
   for (i=0;i<keywords.length;i++){
        var keyname = keywords[i].title;
        var keyid = keywords[i].id;

        $("#Groupkeywords").tokenInput("add", {id: keyid, name: keyname });
      };


});</script>

<script type="text/javascript" src="{{App::make('url')->to('/')}}/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: 'textarea',
    directionality: 'rtl',
    language: 'fa',
    menubar: "tools table format view insert edit",
    height: 170,
    menu: {// this is the complete default configuration

    },
    content_css: "{{App::make('url')->to('/')}}/theme/Content/css/content.css",
    plugins: [
        'directionality hamafza advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code responsivefilemanager '
    ],
    toolbar: ' bold italic | alignleft aligncenter alignright alignjustify ltr rtl | bullist numlist outdent indent ',
});
</script>
@endif
@include('scripts.publicpages')
@include('sections.contextmenu')
<div class="panel-body text-decoration">

    <?php
    $alert = '';
    if (Session::get('newgroup') == 'newgroup') {
        $alerts = DB::table('function_alert as f')->join('alerts as a', 'a.id', '=', 'f.alertid')->where("functionname", 'newgroup')->select('a.comment')->first();
        $alert = $alerts->comment;
        Session::put('newgroup','');
    } elseif (Session::get('newgroup') == 'neworgan') {
        $alerts = DB::table('function_alert as f')->join('alerts as a', 'a.id', '=', 'f.alertid')->where("functionname", 'neworgan')->select('a.comment')->first();
        $alert = $alerts->comment;
                Session::put('newgroup','');

    } elseif (Session::get('newgroup') == '')
        $alert = '';
    ?>


    <div class='text-content'>
     @if ($alert!='')
        <div style="margin:15px;" class="gkCode10" id=""> {{$alert}}</div>
    @endif
    @if(is_array($content))

        <form action="{{ route('hamafza.update_group') }}" method="post" id="form_group" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <table class="table" style="background-color:#fff">
                <tr>
                    <td width="160">نام <font color="red">*</font></td>
                    <td>
                        <input name="group_title" type="text" value="<?php echo (isset($group_edit['name']) ? $group_edit['name'] : ''); ?>" class="form-control required" id="group_title" dir="rtl" style="width:388px"/>
                        <input name="gname" type="hidden" value="{{$gname}}" />

                    </td>
                </tr>

                <tr>
                    <td>معرفی اجمالی</td>
                    <td>
                        <input name="group_summary" type="text" placeholder="چند واژه برای بیان رویکردها و نکات مورد توجه گروه" value="<?php echo (isset($group_edit['summary']) ? $group_edit['summary'] : ''); ?>" class="form-control " id="group_summary" dir="rtl" style="width:388px"/>
                    </td>
                </tr>
                <tr>
                    <td>کلیدواژه ها</td>
                    <td>
                        <input type="text" id="Groupkeywords" name="Groupkeywords" ttype="12"   />
                    </td>
                </tr>
        <tr>
            <td>تصویر</td>
            <td>
                <?php
                if ($group_edit['pic'] != "" && file_exists("pics/group/" . $group_edit['id'] . "-" . $group_edit['pic'] . "")) {
                ?>
                <img src="<?php echo "pics/group/" . $group_edit['id'] . "-" . $group_edit['pic']; ?>" alt="" style="width: 100px; height: auto" />
                <input type="hidden" name="vpic" id="vpic" value="<?php echo $group_edit['pic'] ?>"/><br/>
                <?php
                }
                ?>
                <script type="text/javascript">
                    function FileName(obj)
                    {

                        var fileName = $(obj).val();
                        pos = fileName.lastIndexOf('.');
                        fileName = fileName.substring(0, pos);
                        var top = $(obj).closest('span');
                        top.css("color", "red");
                        top.next('span').show();

                        top.next('span').children('input').val(fileName);
                    }
                </script>
                <span class="btn btn-default btn-file">
                            انتخاب فایل <input type="file" name="pic" value="" class="form-control" id="group_pic" dir="rtl" style="width:388px" onchange="FileName(this);">
                        </span></span>
                <span class="descr" style="display: none;"> عنوان فایل <input name="ftitle[1]" class="form-control" style="width:200px" value="" /></span>


                <input name="group_link" type="hidden" value="<?php echo (isset($group_edit['link']) ? $group_edit['link'] : ''); ?>"
            </td>
        </tr>

                <tr>
                    <td>دیدگاه ها و ایده های اصلی</td>
                    <td colspan="1"><textarea placeholder="چشم انداز، دست آوردهای مورد انتظار و فواید تشکیل گروه، توضیحی مختصر از اهداف، مخاطبان و راهبردها و ..." id="group_descrip" name="group_descrip" class="form-control" ><?php echo (trim($group_edit['descrip']) == '' ? '' : trim($group_edit['descrip'])) ?></textarea></td>


                </tr>


                <tr <?php echo $group_edit['isorgan'] == '1' ? 'style="display:none;"' : ''; ?> >
                    <td>نوع</td>
                    <td>
                        <select  class="form-control" data-placeholder="انتخاب کنید" id="group_type" name="group_type">
                            <option value="1" @if($group_edit['type']=='1')selected @endif>کانون تفکر</option>
                            <option value="2" @if($group_edit['type']=='2')selected @endif>اجتماع یادگیری</option>
                            <option value="3" @if($group_edit['type']=='3')selected @endif>اجتماع عمل</option>
                            <option value="4" @if($group_edit['type']=='4')selected @endif>مدیریت پروژه</option>
                            <option value="5" @if($group_edit['type']=='5')selected @endif>هم دوره ای ها</option>
                            <option value="6" @if($group_edit['type']=='6')selected @endif >سایر</option>
                        </select>


                    </td>
                </tr>
                <tr>
                    <td>اهداف</td>
                    <td>
                        <textarea placeholder="نتایج مورد انتظار از تشکیل گروه، دلایلی که ضرورت و اهمیت گروه را مشخص می کند" name="group_target" class="form-control" ><?php echo (isset($group_edit['target']) ? $group_edit['target'] : ''); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>مخاطبان</td>
                    <td>
                        <textarea placeholder="افرادی که می توانند از فعالیت های گروه بهره مند شوند و یا برای دستیابی به اهداف گروه همکاری نمایند" name="group_audience" class="form-control" ><?php echo (isset($group_edit['audience']) ? $group_edit['audience'] : ''); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>راهبردها</td>
                    <td>
                        <textarea placeholder="فعالیت ها و اقداماتی که برای دستیابی به اهداف باید انجام شوند" name="group_strategy" class="form-control" ><?php echo (isset($group_edit['strategy']) ? $group_edit['strategy'] : ''); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>فعالیت ها</td>
                    <td>
                        <textarea placeholder="فعالیت ها و اقداماتی که برای دستیابی به اهداف باید انجام شوند" name="group_activity" class="form-control" ><?php echo (isset($group_edit['activity']) ? $group_edit['activity'] : ''); ?></textarea>
                    </td>
                </tr>

                @if ($group_edit['isorgan'] == '1')
                    <tr>
                        <td>حوزه فعالیت</td>
                        <td>
                            <textarea placeholder="موضوع و حوزه فعالیت کانال..." name="subject" class="form-control" ><?php echo (isset($group_edit['subject']) ? $group_edit['subject'] : ''); ?></textarea>
                        </td>
                    </tr>

                    <td>نشانی</td>
                    <td>
                        <textarea placeholder="نشانی کانال..." name="address" class="form-control" ><?php echo (isset($group_edit['address']) ? $group_edit['address'] : ''); ?></textarea>
                    </td>
                    </tr>

                    <td>شماره‌های تماس</td>
                    <td>
                        <textarea placeholder="" name="tel" class="form-control" ><?php echo (isset($group_edit['tel']) ? $group_edit['tel'] : ''); ?></textarea>
                    </td>
                    </tr>

                    <td>وب گاه</td>
                    <td>
                        <input name="url" type="text" value="<?php echo (isset($group_edit['url']) ? $group_edit['url'] : ''); ?>" class="form-control required" id="url" dir="rtl" style="width:388px"/>

                    </td>
                    </tr>

                    <td>رایانامه</td>
                    <td>
                        <input name="email" type="text" value="<?php echo (isset($group_edit['email']) ? $group_edit['email'] : ''); ?>" class="form-control required" id="email" dir="rtl" style="width:388px"/>
                    </td>
                    </tr>

               @endif

                    <tr>
                        <td>توضیح</td>
                        <td>
                            <textarea placeholder="ویژگی ها، مقررات، دستاوردها و ..." name="description" class="form-control" >
{{$group_edit['description'] }}
                            </textarea>
                        </td>
                    </tr>

                <tr>
                    <td colspan="2">عضویت :
                        <label><input type="radio" name="group_limit" value="0" <?php echo (isset($group_edit['allowreg']) && $group_edit['allowreg'] == 0) ? 'checked' : ''; ?> />عدم نیاز به تایید</label>
                        <label><input type="radio" name="group_limit" value="1" <?php echo (isset($group_edit['allowreg']) && $group_edit['allowreg'] == 1) ? 'checked' : ''; ?> />نیاز به تایید</label>
                        <?php
                        $_SESSION['hash'] = md5(time() . $_SERVER['REMOTE_ADDR']);
                        echo '<input type="hidden" name="hash" value="' . $_SESSION['hash'] . '" />';
                        ?>

                        <input type="hidden" name="gid" value="<?php echo (isset($group_edit['id']) ? $group_edit['id'] : 0); ?>" />

                    </td>
                </tr>
                <tr><td colspan="2">

                        <button type="submit" class="btn btn-primary FloatLeft" name="addasubject" >تایید</button>
        <span class="btn btn-default FloatLeft" style="margin-left: 10px"><a href="{{App::make('url')->to('/')}}/{{$gname}}">لغو</a></span>


                    </td></tr>
            </table>
        </form>
    </div>
    @else
    {{$content}}
    @endif
    @stop
    @section('tabs')
    @if (is_array($tabs))
    @foreach($tabs as $item)
    @if (trim($item['link']) === trim($pid))
    <li class="active"><a href="{{App::make('url')->to('/')}}/{{ $item['href'] }}">{{ $item['title'] }}</a></li>
    @else
    <li><a href="{{App::make('url')->to('/')}}/{{ $item['href'] }}">{{ $item['title']}}</a></li>
    @endif
    @endforeach
    @endif
    @stop
    @section('Tree')
    @include('sections.rightcol')




    @stop

