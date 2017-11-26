<script src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.tokeninput.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#input-plugin-methods_tags").tokenInput("{{App::make('url')->to('/')}}/Tagsearch", {
            preventDuplicates: true,
            hintText: "عبارتی را وارد کنید",
            searchingText: "در حال جستجو",
            onResult: function (item) {
                if ($.isEmptyObject(item)) {

                    return [{id: '0', name: $("tester").text()}]
                } else {
                    return item
                }
            },
        });
    });
</script>

<input type="text" id="input-plugin-methods_tags" name="keywords" ttype="12"/>
