<style>
    .h-header
    {
        background-image: url('{{ URL('img/bazaar/h-sample-1.jpg') }}');
        color: white;
        height: 325px;

        width: 1075px;
    }
    .h-header .h-tabs
    {
        height: 40px;
    }
    .h-header .h-tabs .h-tab,
    .h-header .h-tabs .h-tab-selected
    {
        cursor: pointer;
        display: inline-block;
        height: 40px;
        width: 210px;
    }
    .h-header .h-tabs .h-tab img
    {
        display: block;
        margin: auto;
        visibility: hidden;
    }
    .h-header .h-tabs .h-tab .h-tab-in
    {
        background-color: rgba(0, 0, 0, 0.5);
        display: block;
        height: 30px;
        padding-top: 6px;
    }
    .h-header .h-tabs .h-tab-selected
    {

    }
    .h-header .h-tabs .h-tab-selected img
    {
        display: block;
        margin: auto;
        visibility: visible;
    }
    .h-header .h-tabs .h-tab-selected .h-tab-in
    {
        background-color: white;
        color: black;
        display: block;
        height: 30px;
        padding-top: 6px;
    }
</style>
<div class="h-content">
    <div id="tab" class="row-fluid" style="width: 95%;">
        <div>
            <img class="h-img" src="" />
            <div style="width: 200px; height: 40px; background-image: url('{{ URL('img/bazaar/button-bascket.png') }}'); float: right; margin: -1px 5px 0 15px;">
                <div style="background-color: red; width: 22px; height: 22px; text-align: center; padding-top: 3px; border-radius: 50%; color: white; margin: 8px 0  0 8px; float: left;">6</div>
            </div>
            <input type="text" id="search_term" class="form-control" style="width: 70%; display: inline-block; height: 36px;" placeholder="جستجو در بازار ..." />
            <input type="button" id="search_btn" class="btn btn-primary" style="display: inline-block; height: 36px;" value=" بیاب " />
        </div>
        <br />
        <div class="h-header">
            <div style="background-color: rgba(0, 0, 0, 0.1); text-align: center; ">
                <div style="height: 285px; font-weight: bold; text-shadow: 2px 2px 2px black;">
                    <div style="padding-top: 35px; font-size: 25px; ">مجموعه کتب مدیریت بازرگانی در سطح کلان در 7 نسخه</div>
                    <div style="margin-top: 10px; ">برگرفته از مجموعه علی بهادری</div>
                    <div style="margin-top: 10px; ">استاد دانشگاه اقتصاد</div>
                </div>
                <div class="h-tabs">
                    <div class="h-tab">
                        <img src="{{ URL('img/bazaar/caret.png') }}" />
                        <div class="h-tab-in">دفتر</div>
                    </div>
                    <div class="h-tab">
                        <img src="{{ URL('img/bazaar/caret.png') }}" />
                        <div class="h-tab-in">کتاب</div>
                    </div>
                    <div class="h-tab">
                        <img src="{{ URL('img/bazaar/caret.png') }}" />
                        <div class="h-tab-in">دفتر</div>
                    </div>
                    <div class="h-tab">
                        <img src="{{ URL('img/bazaar/caret.png') }}" />
                        <div class="h-tab-in">دفتر</div>
                    </div>
                    <div class="h-tab">
                        <img src="{{ URL('img/bazaar/caret.png') }}" />
                        <div class="h-tab-in">دفتر</div>
                    </div>
                </div>
                <script>
                </script>
            </div>
        </div>
    </div>
    <br />
    {{--
    <div id="tab" class="row-fluid" style="width: 95%; padding-right: 10px;">
        <small>
            <div style="width: 100px; float: right;">جدیدترین ها</div>
            <div style="width: 100px; float: right;">محبوب ها</div>
            <div style="width: 100px; float: right;">جذابترین ها</div>
        </small>
        <div class="clear"></div>
        <br />
        @foreach ($subjects1 as $subject1)
            <div class="col-sm-4" style="height: 100px; width: 250px; float: right;">
                <img style="float: right; margin-left: 10px;" src="{{ url('img/bazaar/sample-1.png') }}" />
                <strong>{!! $subject1->title !!}</strong><br />
                <small>{!! $subject1->product_info->CreatedAtName !!}</small><br />
                <small><a href="#" class="add-to-cart">افزودن به سبد خرید</a></small>
                <div class="clear"></div>
            </div>
        @endforeach
        <div class="clear"></div>
    </div>
    --}}
    <div id="tab" class="row-fluid table-bordered" style="width: 95%;">
        <ul class="nav nav-tabs">
            <li>
                <a href="#t1" id="th1" data-id="1" data-toggle="tab">جدیدترین ها</a>
            </li>
            <li>
                <a href="#t2" id="th2" data-id="2" data-toggle="tab">محبوب ها</a>
            </li>
            {{--
            <li style="float: left;">
                <a><span>جستجو:</span> <input type="text" class="form-control" style="display: inline-block; width: 80%;" /></a>
            </li>
            <li>
                <a href="#t30" id="th30" data-id="30" data-toggle="tab">جذابترین ها</a>
            </li>
            --}}
        </ul>
        <div class="tab-content">
            <div class="tab-pane" id="t1" style="padding-top: 10px;">
                <div style="margin: 10px;">در حال بارگذاری...</div>
            </div>
            <div class="tab-pane" id="t2" style="padding-top: 10px;">
                <div style="margin: 10px;">در حال بارگذاری...</div>
            </div>
        </div>
        <br />
        <div style="clear: both;"></div>
    </div>
</div>
<script>
    $('#th10').click();
</script>
