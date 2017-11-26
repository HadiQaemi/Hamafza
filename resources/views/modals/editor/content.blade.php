@include('modals.modalheader')
<style>
    body
    {
        background-color: white;
    }
</style>
<script src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.tokeninput.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function() {
    $("#input-plugin-methods").change(function() {
        $("#Retval").val($("#input-plugin-methods").val());
        $("#Retval2").val($("#input-plugin-methods").text());

    });
$(".makhaz").click(function() {
       $("#makhazs").val($(this).attr('val'));
    });
$(".giume").click(function() {
       $("#giumes").val($(this).attr('val'));
    });

    $("#input-plugin-methods").tokenInput("{{App::make('url')->to('/')}}/Pagesearch", {
        preventDuplicates: true,
        hintText: "عبارتی را وارد کنید",
        noResultsText: "نتیجه‌ای یافت نشد، با زدن دکمه اینتر کلیدواژه جدیدی ایجاد می‌شود",
        searchingText: "در حال جستجو",
        onResult: function(item) {
            if ($.isEmptyObject(item)) {
                return [{id: '0', name: $("tester").text()}]
            } else {
                return item
            }


        },
    });
});
</script>

<div style="padding: 20px">
    انتخاب صفحه:
    <input type="text" id="input-plugin-methods" name="Commentkeywords" ttype="12"   />
    <input type="hidden" id="Retval">
    <input type="hidden" id="makhazs" value="0">
    <input type="hidden" id="giumes" value="0">
    <br>
    <div style="display: flex;">
        <div style="width: 50%">
            <input  class="makhaz"  name="makhaz"  type="radio" val="1">باماخذ
            <br>
            <input type="radio" class="makhaz" name="makhaz" checked="" val="0">بدون ماخذ
        </div>
        <div style="width: 50%">
            <input type="radio" class="giume"  name="giume" val="1">داخل گیومه
            <br>
            <input type="radio"  class="giume" checked="" name="giume"  val="0">بدون گیومه
        </div>
    </div>
</div>