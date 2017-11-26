@extends('pages.Desktop.DesktopFunctions')
@section('content')
<script type="text/javascript">
    
    $(document).ready(function() {
        $(".plugin-methods").tokenInput("{{App::make('url')->to('/')}}/Tagsearch", {
            preventDuplicates: true,
            hintText: "عبارتی را وارد کنید",
            noResultsText: "نتیجه‌ای یافت نشد، با زدن دکمه اینتر کلیدواژه جدیدی ایجاد می‌شود",
            searchingText: "در حال جستجو",
        });
        $("#Thesar").tokenInput("{{App::make('url')->to('/')}}/Tessearch", {
            preventDuplicates: true,
            hintText: "عبارتی را وارد کنید",
            searchingText: "در حال جستجو",
        });
        
    });</script>
<form action="{{App::make('url')->to('/')}}/keyword_save" method="post" enctype="multipart/form-data" name="form" >
    <div style="margin:10px;">
          <table class="table">
        <tr>
            <td style="width:120px">عنوان</td>


            <td colspan="3" style="text-align: right;">


                <input id="shape"  name="shape" type="text" value="" style="width: 250px;display: inline-block;" class="form-control"  dir="rtl"/>

                رسمی<input name="Tagtype" type="radio" value="0" checked="">
                شخصی<input name="Tagtype" type="radio" value="1">
            </td>
        </tr>
        <tr>
            <td style="width:120px">نوع</td>
            <td colspan="3" style="text-align: right;">

                مصوب<input name='workflow' type='radio' value='0' checked>

                موقت<input name="workflow" type="radio" value="1">


            </td>
        </tr>

        <tr>
            <td style="width:120px"></td>
            <td colspan="3" style="text-align: right;">
                معیار تقسیم‌بندی (عبارت راهنما)<input name='relation' type='checkbox'  >
            </td>
        </tr>

        <tr>
            <td style="width:120px">کد</td>
            <td colspan="3" style="text-align: right;direction:rtl;">
                <input id="code"  name="code" type="text"  class="form-control" style="width:180px" dir="rtl"/>
            </td>
        </tr>
        <tr>
            <td style="width:120px">تصویر</td>
            <td colspan="3" style="text-align: right;direction:rtl;">
                <span class="btn btn-default btn-file">
                    انتخاب فایل <input type="file" name="PicFile" onchange="FileName(this);">

                </span>
                <span class="descr" style="display: none;"> عنوان فایل <input name="PicFiles" class="form-control" style="width:200px" value="" /></span>

            </td>
        </tr>


        <tr>
            <td style="width:120px">اصطلاح‌نامه</td>
            <td colspan="3" style="text-align: right;">
                <input type="text" id="Thesar" name="thes" ttype="12"  />
            </TD>

        </tr>
        <tr style="display: none;">
            <td></td>
            <td colspan="3" dir="rtl" style="text-align: right;"><input disabled="disabled"  type="checkbox" name="is_keyword" value="1" checked="checked" onclick="showHideText(this, 'diskeyword')"

                <script >
                    showHideText(this, 'diskeyword');
                </script>
            </td>
        </tr>


        <tr>
            <td>
                توضیحات

            </td>
            <td colspan="3" dir="rtl" style="text-align: right;">
                <textarea name="Descr" id="Descr" cols="30" rows="3" class="form-control" style="width:100%"></textarea>
            </td>

        </tr>


        <tr>
            <td  colspan="2" dir="rtl" style="text-align: right;"> 
                اجزای این مفهوم
            </td>
            <td  dir="rtl" colspan="2"style="text-align: right;">
                <div style="width:450px;float:right;">   <input type="text" id="JozID" class="plugin-methods" name="joz" ttype="12"  />
                </div>
            </td>  

        </tr>

        <tr>
            <td  colspan="2" dir="rtl" style="text-align: right;border: none;"> 
                این مفهوم یک جزء از
            </td>
            <td  dir="rtl" colspan="2" style="text-align: right;border: none;">
                <div style="width:450px;float:right;"> 
                    <input type="text" id="KOLID" class="plugin-methods" name="kol" ttype="12"  />
                </div>
            </td>  

        </tr>
        <tr>
            <td  dir="rtl" colspan="2" style="text-align: right;border: none;">
                مصادیق این مفهوم
            </td>
            <td  dir="rtl" colspan="2" style="text-align: right;border: none;">
                <div style="width:450px;float:right;">   <input type="text" id="MesdaghID" class="plugin-methods" name="mesdagh" ttype="12"  />
                </div>
            </td>  

        </tr>
        <tr>
            <td  dir="rtl" colspan="2" style="text-align: right;border: none;"> 
                این مفهوم یک مصداق از
            </td>
            <td  dir="rtl" colspan="2" style="text-align: right;border: none;">
                <div style="width:450px;float:right;">   <input type="text" id="aamID" class="plugin-methods" name="aam" ttype="12"  />
                </div>
            </td>  

        </tr>
        <tr>
            <td  dir="rtl" colspan="2" style="text-align: right;border: none;">
                اجزاء و مصادیق این مفهوم
            </td>
            <td  dir="rtl" colspan="2" style="text-align: right;border: none;">
                <div style="width:450px;float:right;">   <input type="text" id="JOZMESID" class="plugin-methods" name="jozmes" ttype="12"  />
                </div>
            </td>  

        </tr>
        <tr>
            <td  dir="rtl" colspan="2" style="text-align: right;border: none;">
                این مفهوم یک جزء و مصداق از                     </td>
            <td  dir="rtl" colspan="2" style="text-align: right;border: none;">
                <div style="width:450px;float:right;">   <input type="text" id="kolaamID" class="plugin-methods" name="kolaam" ttype="12"  />
                </div>
            </td>  

        </tr>
        <tr>
            <td  colspan="2" dir="rtl" style="text-align: right;"> 
                هم ارزها
            </td>
            <td  dir="rtl" colspan="2"style="text-align: right;">
                <div style="width:450px;float:right;">   <input type="text" id="input-plugin-hamarz" class="plugin-methods" name="hamarz" ttype="12"  />
                </div>
            </td>  

        </tr>
        <tr>
            <td  dir="rtl" colspan="2" style="text-align: right;border: none;">
                اصطلاح مرجح
            </td>
            <td  dir="rtl" colspan="2" style="text-align: right;border: none;">
                <div style="width:450px;float:right;">   <input type="text" id="input-plugin-moraj" class="plugin-methods" name="moraj" ttype="12"  />
                </div>
            </td>  

        </tr>
        <tr>
            <td  dir="rtl" colspan="2" style="text-align: right;border: none;">
                هم‌ارز در انگلیسی
            </td>
            <td  dir="rtl" colspan="2" style="text-align: right;border: none;">
                <div style="width:450px;float:right;">   <input type="text" id="englishID" class="plugin-methods" name="english" ttype="12"  />
                </div>
            </td>  

        </tr>



        <tr>
            <td  dir="rtl" colspan="2" style="text-align: right;border: none;">
                هم‌ارز در عربی
            </td>
            <td  dir="rtl" colspan="2" style="text-align: right;border: none;">
                <div style="width:450px;float:right;">   <input type="text" id="arabicID" class="plugin-methods" name="arabic" ttype="12"  />
                </div>
            </td>  

        </tr>

        <tr>
            <td  colspan="2" dir="rtl" style="text-align: right;"> 
                وابسته‌ها
            </td>
            <td  dir="rtl" colspan="2"style="text-align: right;">
                <div style="width:450px;float:right;">  
                    <input type="text" id="hambasteID" class="plugin-methods" name="hambaste" ttype="12"  />
                </div>
            </td>  

        </tr>
        <tr>
            <td  colspan="2" dir="rtl" style="text-align: right;"> 
                هم‌نویسه (اشتراک لفظی)
            </td> <td  dir="rtl" colspan="2"style="text-align: right;">
                <div style="width:450px;float:right;">   <input type="text" id="eshterakID" class="plugin-methods" name="eshterak" ttype="12"  />
                </div>
            </td>  

        </tr>

        <tr>
            <td  colspan="2" dir="rtl" style="text-align: right;"> 
                کوته‌نوشت
            </td>
            <td  dir="rtl" colspan="2"style="text-align: right;">
                <div style="width:450px;float:right;">   <input type="text" id="kootahID" class="plugin-methods" name="kootah" ttype="12"  />
                </div>
            </td>  

        </tr>
        <tr>
            <td colspan="4" dir="rtl" style="text-align: right;">

                <input type="hidden" name="pid" id="pid" />
                <input type="hidden" name="keyid" id="keyid" />
                <input type="hidden" name="ctxid" id="ctxid" />
                <input name="news_date" type="hidden" id="news_date" />
                <input type="hidden" name="author" id="author"  />
               <input type="submit" class="btn btn-primary FloatLeft" value="تایید" name="circle_add" id="submit">
            </td>
        </tr>

    </table>
        
    <p></p>
        <p></p>
    <p></p>
    <p></p>
    <br>
        <br>
    <br>
    <br>
    </div>
</form>

@stop