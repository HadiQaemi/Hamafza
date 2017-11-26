<script src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.tokeninput.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
$("#input-plugin-methods").tokenInput("{{App::make('url')->to('/')}}/Tagsearch", {
preventDuplicates: true,
        hintText: "عبارتی را وارد کنید",
        noResultsText: "نتیجه‌ای یافت نشد، با زدن دکمه اینتر برچسب جدیدی ایجاد می‌شود",
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
                        $("#input-plugin-methods").tokenInput("remove", {name: name});
                        $("#input-plugin-methods").tokenInput("add", {id: theResponse, name: name});
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

<div style="width: 100%;display: inline-block;">
<input type="text" id="input-plugin-methods" name="Commentkeywords" ttype="12"   />
</div>