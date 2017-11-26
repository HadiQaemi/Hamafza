@include('modals.modalheader')

<style>
    body
    {
        background-color: white;
    }
</style>

<div style="padding: 20px">
    انتخاب متن قرآن:
    <select class="form-control" dir="rtl" class="select" id="quran" name="quran"><option value="1">متن قرآن</option><option value="11">الهی قمشه&zwnj;ای</option><option value="12">انصاریان</option><option value="13">آیتی</option><option value="14">بهرام پور</option><option value="15">خرمدل</option><option value="16">خرمشاهی</option><option value="17">صادقی تهرانی</option><option value="18">فولادوند</option><option value="19">مجتبوی</option><option value="20">معزی</option><option value="21">مکارم شیرازی</option></select>
    <br>
    انتخاب سوره:

 <select dir="rtl" class="form-control" id="sura" name="sura">
     @foreach ($sura as $value)
        <option value="{{$value->id}}">{{$value->name}} (شامل {{$value->aya}} سوره)</option>
       @endforeach
 </select>

<br>
انتخاب آیه:

<input type="text"  class="form-control" id="aya">
در صورتیکه می خواهید همه آیات نمایش داده شود ، این قسمت خالی بماند.

</div>