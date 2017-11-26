<script src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.tokeninput.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#PS_input-plugin-methods").tokenInput("{{App::make('url')->to('/')}}/Tagsearch", {
            preventDuplicates: true,
            hintText: "عبارتی را وارد کنید",
            noResultsText: "نتیجه‌ای یافت نشد، با زدن دکمه اینتر برچسب جدیدی ایجاد می‌شود",
            searchingText: "در حال جستجو",
            onAdd: function (item) {
                //add the new label into the database
                if (parseInt(item.id) == 0) {
                    name = $("tester").text();
                    if (name != null) {
                        $.ajax({
                            type: "POST",
                            url: "tagmergeaction.php",
                            dataType: 'html',
                            data: ({New: 'OK', Name: name}),
                            success: function (theResponse) {
                                if (theResponse != 'NOK')
                                    alert('بر چسب جدید با موفقیت تعریف شد');
                                $("#PS_input-plugin-methods").tokenInput("remove", {name: name});
                                $("#PS_input-plugin-methods").tokenInput("add", {id: theResponse, name: name});
                            }
                        });
                    }
                }
            },
            onResult: function (item) {
                if ($.isEmptyObject(item)) {

                    return [{id: '0', name: $("tester").text()}]
                } else {
                    return item
                }

            },
        });


                @if(is_array($Setting->keywords))
                @foreach($Setting->keywords as $item)
        var keyname = "{{$item->title}}";
        var keyid = "{{$item->id}}";

        $("#PS_input-plugin-methods").tokenInput("add", {id: keyid, name: keyname});
        @endforeach
        @endif
    });
</script>
<input type="text" id="PS_input-plugin-methods" name="PS_keywords" ttype="12"/>
