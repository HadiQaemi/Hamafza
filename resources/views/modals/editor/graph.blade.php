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
    <br>
    درجه گراف:
    <input type="text" id="Graphno" name="Graphno"  class="form-control"   />
    <input type="hidden" id="Retval">


</div>