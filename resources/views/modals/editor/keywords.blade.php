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
    $(".makhaz").click(function() {
       $("#makhazs").val($(this).attr('val'));
    });
    
$("#Keywordtags").tokenInput("{{App::make('url')->to('/')}}/Tagsearch", {
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
                        $("#Keywordtags").tokenInput("remove", {name: name});
                        $("#Keywordtags").tokenInput("add", {id: theResponse, name: name});
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
});
</script>


<div style="width: 70%;display: inline-block;">
انتخاب کلیدواژه:
    <input type="text" id="Keywordtags" name="Commentkeywords" ttype="12"   />
    
    <br>
        <input type="hidden" id="makhazs" value="0">

    <div style="width: 50%">
            <input  class="makhaz"  name="makhaz"  type="radio" val="1">با زیر مجموعه
            <br>
            <input type="radio" class="makhaz" name="makhaz" checked="" val="0">بدون زیر مجموعه
        </div>
</div>