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
<form action="{{ route('hamafza.keyword_merge') }}" method="post" enctype="multipart/form-data" name="form" >
    <div style="margin:10px;">
        <table class="table">
            <tr>
                <td colspan="3" style="text-align: right;">
                    ادغام شود با
                </td>
                 <td colspan="3" style="text-align: right;">
                    <input type="text"  class="plugin-methods" name="merge" ttype="12"  />

                </td>
            <input name="keyid" type="hidden"  value="{{$keyword}}" >

            </tr>
          
                        <tr>

            <td colspan="4" dir="rtl" style="text-align: right;">
                <input type="submit" class="btn btn-info FloatLeft" value="تایید" name="circle_add" id="submit">
            </td>
            </tr>

        </table>

        <p></p>
    </div>
</form>