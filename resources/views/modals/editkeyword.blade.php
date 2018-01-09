<script src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.tokeninput.js" type="text/javascript"></script>
<link href="{{App::make('url')->to('/')}}/theme/Content/css/magicsuggest.css" rel="stylesheet">
<script src="{{App::make('url')->to('/')}}/theme/Scripts/magicsuggest-min.js"></script>

<script>

    $("#EditKey").click(function () {
        var form = $("#EditFrom");
        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: form.serialize(),
            success: function (theResponse) {
                jQuery.noticeAdd({
                    text: theResponse,
                    stay: false,
                    type: 'success'
                });
            }
        });
    });
    $("#EditKeyNew").click(function () {
        document.getElementById("EditFrom").reset();
        var form = $("#EditFrom");
        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: form.serialize(),
            success: function (theResponse) {
                jQuery.noticeAdd({
                    text: theResponse,
                    stay: false,
                    type: 'success'
                });
            }
        });

        $("#keyid").val(0);


    });

    $("#Thesar").tokenInput("{{App::make('url')->to('/')}}/Tessearch", {

        < script
    type = "text/javascript" >
        $(document).ready(function () {
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


</script>
<form action="{{ route('hamafza.keyword_update') }}" method="post" enctype="multipart/form-data" name="form" id="EditFrom">
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
    <table class="table">
        <input name="keyid" id='keyid' type="hidden" value="{{$keyword->id}}">

        });</script>
        <
        form
        action = "{{ route('hamafza.keyword_update') }}"
        method = "post"
        enctype = "multipart/form-data"
        name = "form" >
            < table
        class
        = "table" >
            < input
        name = "keyid"
        type = "hidden"
        value = "{{$keyword['id']}}" >


            < tr >
            < td
        style = "width:120px;border: none;" > عنوان < / td >
            < td
        colspan = "3"
        style = "text-align: right;border: none;" >
            < input
        id = "shape"
        name = "shape"
        type = "text"
        value = "{{$keyword['keyword']}}"
        style = "display: inline-block;width: 90%;"
        class
        = "form-control"
        dir = "rtl" / >
            < p > < / p >
            < input
        name = "Tagtype"
        type = "radio"
        value = "0"
        @if($keyword['type']=='0') checked @endif> رسمی
        < input
        name = "Tagtype"
        type = "radio"
        value = "1"
        @if($keyword['type']=='1') checked @endif> شخصی
        < span
        style = "margin-right: 25px;" >
            < input
        name = 'workflow'
        type = 'radio'
        value = '0'
        @if($keyword['workflow']=='0') checked @endif> مصوب
        < input
        name = "workflow"
        type = "radio"
        value = "1"
        @if($keyword['workflow']=='1') checked @endif> موقت
        < / span >
        < span
        class
        = "help-icon-span WindowHelpIcon" >
            < a
        href = "{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=abzarmozoejadidbarchasb&hid=6"
        title = "راهنمای اینجا"
        href = "#"
        class
        = "jsPanels icon-help HelpIcon"
        style = "float: left;padding-left: 20px;"
        title = "راهنمای اینجا"
        data - placement = "top"
        data - toggle = "tooltip" >
            < / a >
            < / span >
            < / td >
            < / tr >
            < tr >
            < td
        style = "width:120px;border: none;" > < / td >
            < td
        colspan = "3"
        style = "text-align: right;border: none;" >
            < input
        name = 'relation'
        type = 'checkbox'
        @if($keyword['morajah']=='1') checked @endif  > معیار
        تقسیم‌بندی(عبارت
        راهنما
        )
        </
        td >
        < / tr >

        < tr >
        < td
        style = "width:120px;border: none;" > کد < / td >
            < td
        colspan = "2"
        style = "text-align: right;direction:rtl;border: none;" >
            < input
        id = "code"
        name = "code"
        type = "text"
        class
        = "form-control"
        value = "{{$keyword['code']}}"
        style = "width:180px"
        dir = "rtl" / >
            < / td >
            < td
        style = "border: none;" >
            تصویر
            < span
        class
        = "btn btn-default btn-file" >
            انتخاب
        تصویر < input
        type = "file"
        name = "PicFile"
        onchange = "FileName(this);" >

            < / span >
            < span
        class
        = "descr"
        style = "display: none;" > عنوان
        فایل < input
        name = "PicFiles"
        class
        = "form-control"
        style = "width:200px"
        value = "" / > < / span >

            < / td >
            < / tr >
            < tr >
            < td
        style = "width:120px" > اصطلاح‌نامه < / td >
            < td
        colspan = "3"
        style = "text-align: right;" >
            < input
        type = "text"
        id = "Thesar"
        name = "thes"
        ttype = "12" / >
            < script >

        </script>
        </TD>

        </tr>


        <tr>
            <td colspan="1" dir="rtl" style="text-align: right;">
                اجزای این کلیدواژه
            </td>
            <td dir="rtl" colspan="3" style="text-align: right;">
                <div style="width:100%;float:right;"><input type="text" id="JozID" class="plugin-methods" name="joz" ttype="12"/>
                </div>
            </td>

        </tr>

        <tr>
            <td colspan="1" dir="rtl" style="text-align: right;border: none;">
                این کلیدواژه یک جزء از
            </td>
            <td dir="rtl" colspan="3" style="text-align: right;border: none;">
                <div style="width:100%;float:right;">
                    <input type="text" id="KOLID" class="plugin-methods" name="kol" ttype="12"/>
                </div>
            </td>

        </tr>
        <tr>
            <td dir="rtl" colspan="1" style="text-align: right;border: none;">
                مصادیق این کلیدواژه
            </td>
            <td dir="rtl" colspan="3" style="text-align: right;border: none;">
                <div style="width:100%;float:right;"><input type="text" id="MesdaghID" class="plugin-methods" name="mesdagh" ttype="12"/>
                </div>
            </td>

        </tr>
        <tr>
            <td dir="rtl" colspan="1" style="text-align: right;border: none;">
                این کلیدواژه یک مصداق از
            </td>
            <td dir="rtl" colspan="3" style="text-align: right;border: none;">
                <div style="width:100%;float:right;"><input type="text" id="aamID" class="plugin-methods" name="aam" ttype="12"/>
                </div>
            </td>

        </tr>
        <tr>
            <td dir="rtl" colspan="1" style="text-align: right;border: none;">
                ‌کلیدواژه‌های پایین دستی
            </td>
            <td dir="rtl" colspan="3" style="text-align: right;border: none;">
                <div style="width:100%;float:right;"><input type="text" id="JOZMESID" class="plugin-methods" name="jozmes" ttype="12"/>
                </div>
            </td>

        </tr>
        <tr>
            <td dir="rtl" colspan="1" style="text-align: right;border: none;">
                ‌کلیدواژه‌های بالادستی
            </td>
            <td dir="rtl" colspan="3" style="text-align: right;border: none;">
                <div style="width:100%;float:right;"><input type="text" id="kolaamID" class="plugin-methods" name="kolaam" ttype="12"/>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1" dir="rtl" style="text-align: right;">
                ‌کلیدواژه‌های هم‌ارز
            </td>
            <td dir="rtl" colspan="3" style="text-align: right;">
                <div style="width:100%;float:right;"><input type="text" id="input-plugin-hamarz" class="plugin-methods" name="hamarz" ttype="12"/>
                </div>
            </td>

        </tr>
        <tr>
            <td dir="rtl" colspan="1" style="text-align: right;border: none;">
                ‌کلیدواژه‌ مرجح ‌
            </td>
            <td dir="rtl" colspan="3" style="text-align: right;border: none;">
                <div style="width:100%;float:right;"><input type="text" id="input-plugin-moraj" class="plugin-methods" name="moraj" ttype="12"/>
                </div>
            </td>

        </tr>
        <tr>
            <td dir="rtl" colspan="1" style="text-align: right;border: none;">
                هم‌ارز در انگلیسی
            </td>
            <td dir="rtl" colspan="3" style="text-align: right;border: none;">
                <div style="width:100%;float:right;"><input type="text" id="englishID" class="plugin-methods" name="english" ttype="12"/>
                </div>
            </td>

        </tr>


        <tr>
            <td dir="rtl" colspan="1" style="text-align: right;border: none;">
                هم‌ارز در عربی
            </td>
            <td dir="rtl" colspan="3" style="text-align: right;border: none;">
                <div style="width:100%;float:right;"><input type="text" id="arabicID" class="plugin-methods" name="arabic" ttype="12"/>
                </div>
            </td>

        </tr>

        <tr>
            <td dir="rtl" colspan="1" style="text-align: right;border: none;">
                ‌کلیدواژه‌های متضاد ‌
            </td>
            <td dir="rtl" colspan="3" style="text-align: right;border: none;">
                <div style="width:100%;float:right;"><input type="text" id="motazadID" class="plugin-methods" name="motazad" ttype="12"/>
                </div>
            </td>

        </tr>

        <tr>
            <td dir="rtl" colspan="1" style="text-align: right;border: none;">
                اشتباه نشود با
            </td>
            <td dir="rtl" colspan="3" style="text-align: right;border: none;">
                <div style="width:100%;float:right;"><input type="text" id="eshtebahID" class="plugin-methods" name="eshtebah" ttype="12"/>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1" dir="rtl" style="text-align: right;">
                ‌کلیدواژه‌های وابسته‌
            </td>
            <td dir="rtl" colspan="3" style="text-align: right;">
                <div style="width:100%;float:right;">
                    <input type="text" id="hambasteID" class="plugin-methods" name="hambaste" ttype="12"/>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="1" dir="rtl" style="text-align: right;">
                هم‌نویسه (اشتراک لفظی)
            </td>
            <td dir="rtl" colspan="3" style="text-align: right;">
                <div style="width:100%;float:right;"><input type="text" id="eshterakID" class="plugin-methods" name="eshterak" ttype="12"/>
                </div>
            </td>

        </tr>

        <tr>
            <td colspan="1" dir="rtl" style="text-align: right;">
                کوته‌نوشت
            </td>
            <td dir="rtl" colspan="3" style="text-align: right;">
                <div style="width:100%;float:right;"><input type="text" id="kootahID" class="plugin-methods" name="kootah" ttype="12"/>
                </div>
            </td>

        </tr>

        <tr>
            <td style="border: none;" colspan="1">
                توضیح (یادداشت دامنه)

            </td>
            <td colspan="3" dir="rtl" style="text-align: right;border: none;">
                <textarea name="Descr" id="Descr" cols="30" rows="3" class="form-control" style="width:100%;">{{$keyword['descr']}}</textarea>
            </td>

        </tr>
        <tr>
            <td colspan="4" dir="rtl" style="text-align: right;">

                <input class="btn btn-primary ThesBut" value="تایید" style="float:left;width: 60px;" id="EditKey"/>
                <input class="btn btn-primary ThesBut" value="تایید و ثبت کلید واژه جدید" style="float:left;margin-left: 5px; width: 160px;" type="reset" id="EditKeyNew"/>


                <input class="btn btn-primary ThesBut" value="تایید" type="submit" id="submit" style="float:left"/>


            </td>

            <input type="hidden" name="Loc" value="Window">

        </tr>

    </table>
</form>
<script>
    @if (is_array($keyword['Rel1']) && count($keyword['Rel1']) > 0)
            @foreach($keyword['Rel1'] as $item)
            @if ($item['rel'] == '1')
        id = "{{$item['id']}}";
    Tname = "{{$item['keyword']}}";

    $("#JozID").tokenInput("add", {id: id, name: Tname});

    @endif

            @endforeach
            @endif


            @if (is_array($keyword['Rel1']) && count($keyword['Rel1']) > 0)
            @foreach($keyword['Rel1'] as $item)
            @if ($item['rel'] == '8')
        id = "{{$item['id']}}";
    Tname = "{{$item['keyword']}}";

    $("#input-plugin-moraj").tokenInput("add", {id: id, name: Tname});
    @endif
            @endforeach
            @endif

            @if (is_array($keyword['Rel1']) && count($keyword['Rel1']) > 0)
            @foreach($keyword['Rel1'] as $item)
            @if ($item['rel'] == '11')
        id = "{{$item['id']}}";
    Tname = "{{$item['keyword']}}";

    $("#kootahID").tokenInput("add", {id: id, name: Tname});
    @endif
            @endforeach
            @endif
            @if (is_array($keyword['Rel1']) && count($keyword['Rel1']) > 0)
            @foreach($keyword['Rel1'] as $item)
            @if ($item['rel'] == '10')
        id = "{{$item['id']}}";
    Tname = "{{$item['keyword']}}";

    $("#eshterakID").tokenInput("add", {id: id, name: Tname});
    @endif
            @endforeach
            @endif

            @if (is_array($keyword['Rel1']) && count($keyword['Rel1']) > 0)
            @foreach($keyword['Rel1'] as $item)
            @if ($item['rel'] == '9')
        id = "{{$item['id']}}";
    Tname = "{{$item['keyword']}}";

    $("#hambasteID").tokenInput("add", {id: id, name: Tname});
    @endif
            @endforeach
            @endif
            @if (is_array($keyword['Rel1']) && count($keyword['Rel1']) > 0)
            @foreach($keyword['Rel1'] as $item)
            @if ($item['rel'] == '13')
        id = "{{$item['id']}}";
    Tname = "{{$item['keyword']}}";

    $("#arabicID").tokenInput("add", {id: id, name: Tname});
    @endif
            @endforeach
            @endif

            @if (is_array($keyword['Rel1']) && count($keyword['Rel1']) > 0)
            @foreach($keyword['Rel1'] as $item)
            @if ($item['rel'] == '12')
        id = "{{$item['id']}}";
    Tname = "{{$item['keyword']}}";

    $("#englishID").tokenInput("add", {id: id, name: Tname});
    @endif
            @endforeach
            @endif
            @if (is_array($keyword['Rel1']) && count($keyword['Rel1']) > 0)
            @foreach($keyword['Rel1'] as $item)
            @if ($item['rel'] == '7')
        id = "{{$item['id']}}";
    Tname = "{{$item['keyword']}}";

    $("#hamarz").tokenInput("add", {id: id, name: Tname});
    @endif
            @endforeach
            @endif
            @if (is_array($keyword['Rel2']) && count($keyword['Rel2']) > 0)
            @foreach($keyword['Rel2'] as $item)
            @if ($item['rel'] == '1')
        id = "{{$item['id']}}";
    Tname = "{{$item['keyword']}}";

    $("#KOLID").tokenInput("add", {id: id, name: Tname});
    @endif
            @endforeach
            @endif

            @if (is_array($keyword['Rel1']) && count($keyword['Rel1']) > 0)
            @foreach($keyword['Rel1'] as $item)
            @if ($item['rel'] == '3')
        id = "{{$item['id']}}";
    Tname = "{{$item['keyword']}}";

    $("#MesdaghID").tokenInput("add", {id: id, name: Tname});
    @endif
            @endforeach
            @endif

            @if (is_array($keyword['Rel2']) && count($keyword['Rel2']) > 0)
            @foreach($keyword['Rel2'] as $item)
            @if ($item['rel'] == '3')
        id = "{{$item['id']}}";
    Tname = "{{$item['keyword']}}";

    $("#aamID").tokenInput("add", {id: id, name: Tname});
    @endif
            @endforeach
            @endif


            @if (is_array($keyword['Rel1']) && count($keyword['Rel1']) > 0)
            @foreach($keyword['Rel1'] as $item)
            @if ($item['rel'] == '5')
        id = "{{$item['id']}}";
    Tname = "{{$item['keyword']}}";

    $("#JOZMESID").tokenInput("add", {id: id, name: Tname});
    @endif
            @endforeach
            @endif


            @if (is_array($keyword['Rel2']) && count($keyword['Rel2']) > 0)
            @foreach($keyword['Rel2'] as $item)
            @if ($item['rel'] == '5')
        id = "{{$item['id']}}";
    Tname = "{{$item['keyword']}}";

    $("#kolaamID").tokenInput("add", {id: id, name: Tname});
    @endif
            @endforeach
            @endif

            @if (is_array($keyword['Thesarus']) && count($keyword['Thesarus']) > 0)
            @foreach($keyword['Thesarus'] as $item)
        id = "{{$item['id']}}";
    Tname = "{{$item['title']}}";

    $("#Thesar").tokenInput("add", {id: id, name: Tname});

    @endforeach
    @endif


</script>