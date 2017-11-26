@include('modals.modalheader')

<style>
    .list-group {
        text-align: center;
    }
    #dashbord-page label {
        font-weight: normal;
        padding: 0 1rem;
    }
    #dashbord-page .reveal-if-active {
        opacity: 0;
        max-height: 0;
        overflow: hidden;
        -webkit-transform: scale(0.8);
        transform: scale(0.8);
        -webkit-transition: 0.5s;
        transition: 0.5s;
    }
    #dashbord-page .reveal-if-active label {
        display: block;
        margin: 0 0 3px 0;
    }
    #dashbord-page .reveal-if-active input[type=text] {
        width: 100%;
    }
    #dashbord-page .select-form {
        font-size: 1.1rem;
    }
    #dashbord-page input[type="radio"]:checked ~ .reveal-if-active,
    #dashbord-page input[type="checkbox"]:checked ~ .reveal-if-active {
        opacity: 1;
        max-height: 100px;
        -webkit-transform: scale(1);
        transform: scale(1);
        overflow: visible;
    }
    #dashbord-page select[multiple],
    #dashbord-page select[size] {
        width: 100%;
        max-height: 200px;
    }
    #dashbord-page form {
        margin: 20px auto;
    }
    #dashbord-page form > div {
        margin: 0 0 20px 0;
    }
    #dashbord-page form > div label {
        font-weight: bold;
    }
    #dashbord-page form > div > div {
        padding: 5px;
    }
    #dashbord-page form .form-group .tittle-wrapper {
        margin-top: 1.5rem;
    }
    #dashbord-page form .form-group .form-control:focus {
        border-color: #66afe9;
        outline: 0;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(121, 221, 41, 0.8);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(121, 221, 41, 0.8);
    }
    #dashbord-page #option2 input {
        margin: 1.5rem 0;
    }
    #dashbord-page #block,
    #dashbord-page #block-seconed {
        display: none;
        padding: 10px;
        text-align: center;
    }
    #dashbord-page #block-three {
        display: none;
        padding: 10px;
        text-align: center;
        min-height: 515px;
    }
    #dashbord-page #block {
        height: 515px;
    }
    #dashbord-page #block-seconed {
        min-height: 270px;
    }
    #dashbord-page .btn-wrapper {
        margin: 6rem auto;
    }
    #dashbord-page .btn-wrapper .left-btn,
    #dashbord-page .btn-wrapper .right-btn {
        border: 1px solid green;
        background-color: green;
        padding: 1.5rem 3rem;
        position: relative;
        color: white;
        overflow: hidden;
        z-index: 1;
        width: 10.5rem;
        display: block;
        margin: 1rem auto;
        border-radius: 0;
        font-family: 'Glyphicons Halflings';
    }
    #dashbord-page .btn-wrapper .left-btn:before,
    #dashbord-page .btn-wrapper .right-btn:before {
        position: absolute;
        content: "";
        width: 100%;
        height: 100%;
        opacity: 0;
        top: 0;
        left: 0;
        background: black;
        transition: all 0.3s;
        z-index: -1;
        border-radius: 0;
    }
    #dashbord-page .btn-wrapper .left-btn:after,
    #dashbord-page .btn-wrapper .right-btn:after {
        position: absolute;
        font-family: 'Glyphicons Halflings';
        font-style: normal;
        font-weight: 400;
        line-height: 1;
        font-size: 2rem;
        top: 50%;
        transform: translateY(-60%);
    }
    #dashbord-page .btn-wrapper .left-btn:hover,
    #dashbord-page .btn-wrapper .right-btn:hover {
        color: white;
    }
    #dashbord-page .btn-wrapper .left-btn:hover:before,
    #dashbord-page .btn-wrapper .right-btn:hover:before {
        opacity: 0.5;
        transition: all 0.3s;
    }
    #dashbord-page .btn-wrapper .left-btn:hover:after,
    #dashbord-page .btn-wrapper .right-btn:hover:after {
        right: .5rem;
        transition: all 0.3s;
    }
    #dashbord-page .btn-wrapper .left-btn:after {
        content: "\e079";
        right: -50px;
        transition: all 0.3s;
    }
    #dashbord-page .btn-wrapper .right-btn:after {
        content: "\e080";
        right: -50px;
        transition: all 0.3s;
    }
</style>

<div id="dashbord-page" class="container" style="overflow: auto;height: 390px;background-color: #FFF;width: 100%;">
    <form class="form-horizontal" role="form">
        <div class="form-group">
            <h3 class="col-sm-1">عنوان </h3>
            <div class="col-sm-10">
                <input class="form-control" id="name-diagram" placeholder="عنوان را وارد کنید" type="text">
            </div>
        </div>
         <div class="form-group">
            <h3 class="col-sm-1">عنوان ستون عمودی </h3>
            <div class="col-sm-10">
                <input class="form-control" id="name-ycol" placeholder="عنوان ستون عمودی را وارد کنید" type="text">
            </div>
        </div>
        <div  class="form-group" >
            <span class="type-show">  نوع نمایش  </span>
                <select id="selectMe" class="select-form form-control" style="padding: 0.5rem;width: 150px;display: inline-block;" placeholder="عنوان را وارد کنید">
                    <option value="option1">جدول</option>
                    <option value="Pie">نمودار دایره ای</option>
                    <option value="Histogram">نمودار ستونی</option>
                    <option value="Linear">نمودار خطی </option>
                    <option value="Radar">نمودار راداری </option>
                </select> 
        </div>
        <div  class="form-group">
            انتخاب داده                
            <input type="radio" name="choice" id="choice-form" required>
            <label for="choice-form">فرم</label>
            <span class="reveal-if-active " >
                <select  class="select-form form-control" id="Forms" style="max-width: 200px;display: inline-block;" placeholder="عنوان را وارد کنید">
                    @if(is_array($Forms) && count($Forms)>0)
                    @foreach($Forms as $item)
                    <option value="{{$item['id']}}">{{$item['title']}}</option>

                    @endforeach

                    @endif
                </select>
            </span>

            <input type="radio" name="choice" id="choice-exell-form">
            <label for="choice-exell-form">فرم اکسل </label>
            <span class="reveal-if-active">
                <a href="#">مدیریت فایل ها</a>
            </span>
        </div>
        <div class="col-sm-12">
   <div id="option2" class="group">
                <div>
                    <input class="select-one" id="select-one" type="radio" name="diagram" value="1"> 
                    <label>
                        یک ستون به عنوان محور Xها و یک ستون به عنوان محور Yها 
                    </label>

                </div>
                <div>
                    <input class="select-three" id="select-three"  type="radio" name="diagram" value="2">
                    <label>
                        یک ستون به عنوان محور X ها و رکورد ها به عنوان سری ها
                    </label>

                </div>
                <div>
                    <input class="select-two" id="select-two" type="radio" name="diagram" value="3">
                    <label>یک ستون به عنوان محور Y ها</label>

                </div>
            </div>
            <div id="jadval" class="jadval" style="display: none;"> 
                <div class="first col-sm-4 list-group first">
                    <label>ستون‌های اصلی</label>
                    <select size="25" multiple="multiple" id="jadval_col1"  class="columns select-form form-control" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">

                    </select>
                </div>

                <div class="col-sm-4 btn-wrapper">
                    <span class=" btn btn-4 btn-4b left-btn" onclick="myFunction_jadval()">اضافه</span>
                    <span class="btn btn-4 btn-4b right-btn" onclick="myFunction_jadval2()">کم کردن</span>
                </div>
                <div class="second col-sm-4 list-group">
                    <label>ستون‌های نمایش</label>
                    <select size="10" multiple="multiple" id="jadval_col2" class="select-form form-control" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">
                    </select>
                </div>
                <div class="row">
                    <div class="first col-sm-4 list-group">
                        <label>سطرهای اصلی</label>
                        <select size="10" multiple="multiple" id="jadval_row1"  class="Rows select-form form-control" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">
                        </select>
                    </div>

                    <div class="col-sm-4 btn-wrapper">
                        <span class="btn btn-4 btn-4b left-btn" onclick="jadval_rows_add()">اضافه</span>
                        <span class="btn btn-4 btn-4b right-btn" onclick="jadval_rows_remove()">کم کردن</span>
                    </div>
                    <div class="third col-sm-4 list-group">
                        <label>سطرهای نمایش</label>
                        <select size="10" multiple="multiple" id="jadval_row2" class="select-form form-control" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">
                        </select>
                    </div>
                </div>
            </div>
         



         

        </div>
        
           <div id="block" class="blockCl"> 
                <div class="row" style="height: 240px;">
                    <div class="first col-sm-4">
                        <div class="list-group first">
                            <h4>ستون ها</h4>
                            <select size="25" multiple="multiple" id="mySelecttwo"  class="columns select-form form-control" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 btn-wrapper">
                        <span class="btn btn-4 btn-4b left-btn" onclick="myFunction2()">اضافه</span>
                        <span class="btn btn-4 btn-4b right-btn" onclick="myFunction()">کم کردن</span>
                    </div>
                    <div class="second col-sm-4">
                        <ul>
                            <label>ستون‌های نمایش</label>
                            <select size="10" multiple="multiple" id="mySelectone" class="columns select-form form-control" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">
                            </select>
                        </ul>
                    </div>
                </div>
                <br>

                <div class="row col-sm-12">
                    <div class="first col-sm-4">
                        <div class="list-group first">
                            <h4>ستون ها</h4>
                            <select size="25" multiple="multiple" id="mySelecttwos"  class="columns select-form form-control" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 btn-wrapper">
                        <span class="btn btn-4 btn-4b left-btn" onclick="myFunction3()">اضافه</span>
                        <span class="btn btn-4 btn-4b right-btn" onclick="myFunction4()">کم کردن</span>
                    </div>
                    <div class="third col-sm-4">
                        <ul>
                            <h4>ایگرگ ها</h4>
                            <select size="10" multiple="multiple" id="mySelectthrees"  class="select-form  form-control" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">

                            </select>
                        </ul>
                    </div>
                </div>

            </div>
        
        
        <div id="block-three"  class="blockCl"> 
            <div class="col-sm-12">
                <div class="first col-sm-4">
                    <div class="list-group first">
                        <h4>ستون ها</h4>
                        <select size="10" multiple="multiple" id="mySelectfour" class="columns select-form form-control" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">

                        </select>
                    </div>
                </div>
                <div class="col-sm-4 btn-wrapper">
                    <span class="btn btn-4 btn-4b left-btn" onclick="myFunction5()">اضافه</span>
                    <span class="btn btn-4 btn-4b right-btn" onclick="myFunction6()">کم کردن</span>
                </div>
                <div class="second col-sm-4">
                    <ul>
                        <label>ستون‌های نمایش</label>
                        <select size="10" multiple="multiple" id="mySelectfive" class="select-form form-control" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">

                        </select>
                    </ul>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="first col-sm-3">
                    <div class="list-group first">
                        <label>سطرهای اصلی</label>
                        <select size="10" multiple="multiple" id="mySelectsix"  class="Rows select-form" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">

                        </select>
                    </div>
                </div>
                <div class="col-sm-3 btn-wrapper">
                    <span class="btn btn-4 btn-4b left-btn" onclick="myFunction7()">اضافه</span>
                    <span class="btn btn-4 btn-4b right-btn" onclick="myFunction8()">کم کردن</span>
                </div>
                <div class="third col-sm-3">
                    <ul>
                        <h4>سری ها</h4>
                        <select size="10" multiple="multiple" id="mySelectseven" class="select-form" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">


                        </select>
                    </ul>
                </div>
            </div>
        </div>

        <div id="block-seconed"  class="blockCl"> 
            <div class="first col-sm-4">
                <div class="list-group first">
                    <h4>ستون ها</h4>
                    <select size="10" multiple="multiple" id="mySelecteight" class="select-form form-control" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">
                    </select>
                </div>
            </div>
            <div class="col-sm-4 btn-wrapper">
                <span class="btn btn-4 btn-4b left-btn" onclick="myFunction9()">اضافه</span>
                <span class="btn btn-4 btn-4b right-btn" onclick="myFunction10()">کم کردن</span>
            </div>
            <div class="second col-sm-4">
                <ul>
                    <label>ستون‌های نمایش</label>
                    <select size="10" multiple="multiple" id="mySelectnine" class="columns select-form form-control" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">
                    </select>
                </ul>
            </div>

        </div>
        <div id="option1" class="group"></div>




</div>

</form>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $("#Forms").change(function() {
            var formid = $(this).val();
            if ($("#selectMe").val() == 'option1')
                $('#jadval').show();
            $.ajax({
                type: "POST",
                url: "{{App::make('url')->to('/')}}/FormField",
                dataType: 'html',
                data: ({id: formid}),
                success: function(theResponse) {
                    var j = JSON.parse(theResponse);
                    for (var i = 0; i < j.length; i++)
                    {
                        var option = $('<option value="' + j[i]['id'] + '">' + j[i]['field_name'] + '</option>');
                        $('.columns').append(option);
                    }
//                    for (var i = 0; i < j.length; i++)
//                    {
//                        var option = $('<option value="' + j[i]['id'] + '">' + j[i]['field_name'] + '</option>');
//                        $('#mySelecttwo').append(option);
//                    }
//                    for (var i = 0; i < j.length; i++)
//                    {
//                        var option = $('<option value="' + j[i]['id'] + '">' + j[i]['field_name'] + '</option>');
//                        $('#mySelecteight').append(option);
//                    }
//
//                    for (var i = 0; i < j.length; i++)
//                    {
//                        var option = $('<option value="' + j[i]['id'] + '">' + j[i]['field_name'] + '</option>');
//                        $('#jadval_col1').append(option);
//                    }

                }
            });
            $.ajax({
                type: "POST",
                url: "{{App::make('url')->to('/')}}/FormReports",
                dataType: 'html',
                data: ({id: formid}),
                success: function(theResponse) {
                    var j = JSON.parse(theResponse);
                    for (var i = 0; i < j.length; i++)
                    {
                        var option = $('<option value="' + j[i]['id'] + '"> تکمیل شده توسط ' + j[i]['reporter'] + ' در تاریخ ' + j[i]['reg_date'] + '</option>');
                        $('.Rows').append(option);
                    }
//                    for (var i = 0; i < j.length; i++)
//                    {
//                        var option = $('<option value="' + j[i]['id'] + '"> تکمیل شده توسط ' + j[i]['reporter'] + ' در تاریخ ' + j[i]['reg_date'] + '</option>');
//                        $('#jadval_row1').append(option);
//                    }

                }
            });
        });


        var FormStuff = {init: function() {
                this.applyConditionalRequired();
                this.bindUIActions();
            }, bindUIActions: function() {
                $("input[type='radio'], input[type='checkbox']").on("change", this.applyConditionalRequired);
            }, applyConditionalRequired: function() {
                $(".require-if-active").each(function() {
                    var el = $(this);
                    if ($(el.data("require-pair")).is(":checked")) {
                        el.prop("required", true);
                    } else {
                        el.prop("required", false);
                    }
                });
            }};
        FormStuff.init();
    });
    $(document).ready(function() {
        $('.group').hide();
        $('#option1').show();
        $('#selectMe').change(function() {
            $('#jadval').hide();
            $('.group').hide();
            if ($(this).val() == 'option1' || $(this).val() == 'Pie')
                $('#jadval').show();
            else
            {
                $('#jadval').hide();
                $('#option2').show();
                $('#select-one').trigger("click");
            }

        });
    });
    $(document).ready(function() {
        $('.add').click(function() {
            $('.second ul').append($(this).removeClass('add').unbind('click'));
        });
    });
    $(document).ready(function() {
        
                $('#choice-form').click(function() {
                    $('.select-one').trigger("click");
                });
        $('.select-one').click(function() {
            $('.blockCl').hide();
            this.checked ? $('#block').show(1000) : $('#block').hide(1000);
        });
        $('.select-two').click(function() {
            $('.blockCl').hide();
            this.checked ? $('#block-seconed').show(1000) : $('#block-seconed').hide(1000);
        });
        $('.select-three').click(function() {
            $('.blockCl').hide();
            var formid = $("#Forms").val();
            $.ajax({
                type: "POST",
                url: "{{App::make('url')->to('/')}}/FormReports",
                dataType: 'html',
                data: ({id: formid}),
                success: function(theResponse) {
                    var j = JSON.parse(theResponse);
                    for (var i = 0; i < j.length; i++)
                    {
                        var option = $('<option value="' + j[i]['id'] + '"> تکمیل شده توسط ' + j[i]['reporter'] + ' در تاریخ ' + j[i]['reg_date'] + '</option>');
                        $('#mySelectsix').append(option);
                    }

                }
            });

            this.checked ? $('#block-three').show(1000) : $('#block-three').hide(1000);
        });
    });
    function myFunction() {
        var texts = $("#mySelectone option:selected").text();
        var vals = $("#mySelectone option:selected").val();
        var x = document.getElementById("mySelecttwo");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelectone option[value='" + vals + "']").remove();
    }
    function myFunction_jadval() {
        var texts = $("#jadval_col1 option:selected").text();
        var vals = $("#jadval_col1 option:selected").val();
        var x = document.getElementById("jadval_col2");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#jadval_col1 option[value='" + vals + "']").remove();
    }
    function jadval_rows_add() {
        var texts = $("#jadval_row1 option:selected").text();
        var vals = $("#jadval_row1 option:selected").val();
        var x = document.getElementById("jadval_row2");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#jadval_row1 option[value='" + vals + "']").remove();
    }

    function jadval_rows_remove() {
        var texts = $("#jadval_row2 option:selected").text();
        var vals = $("#jadval_row2 option:selected").val();
        var x = document.getElementById("jadval_row1");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#jadval_row2 option[value='" + vals + "']").remove();
    }


    function myFunction_jadval2() {
        var texts = $("#jadval_col2 option:selected").text();
        var vals = $("#jadval_col2 option:selected").val();
        var x = document.getElementById("jadval_col1");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#jadval_col2 option[value='" + vals + "']").remove();
    }

    $(document).ready(function() {

    });
    function myFunction2() {
        var texts = $("#mySelecttwo option:selected").text();
        var vals = $("#mySelecttwo option:selected").val();
        var x = document.getElementById("mySelectone");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelecttwo option[value='" + vals + "']").remove();
    }

    function  myFunction3() {
        var texts = $("#mySelecttwos option:selected").text();
        var vals = $("#mySelecttwos option:selected").val();
        var x = document.getElementById("mySelectthrees");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelecttwos option[value='" + vals + "']").remove();
    }
    function  myFunction4() {
        var texts = $("#mySelectthrees option:selected").text();
        var vals = $("#mySelectthrees option:selected").val();
        var x = document.getElementById("mySelecttwos");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelectthrees option[value='" + vals + "']").remove();
    }
    function  myFunction5() {
        var texts = $("#mySelectfour option:selected").text();
        var vals = $("#mySelectfour option:selected").val();
        var x = document.getElementById("mySelectfive");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelectfour option[value='" + vals + "']").remove();
    }
    function  myFunction6() {
        var texts = $("#mySelectfive option:selected").text();
        var vals = $("#mySelectfive option:selected").val();
        var x = document.getElementById("mySelectfour");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelectfive option[value='" + vals + "']").remove();
    }
    function  myFunction7() {
        var texts = $("#mySelectsix option:selected").text();
        var vals = $("#mySelectsix option:selected").val();
        var x = document.getElementById("mySelectseven");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelectsix option[value='" + vals + "']").remove();
    }
    function  myFunction8() {
        var texts = $("#mySelectseven option:selected").text();
        var vals = $("#mySelectseven option:selected").val();
        var x = document.getElementById("mySelectsix");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelectseven option[value='" + vals + "']").remove();
    }
    function  myFunction9() {
        var texts = $("#mySelecteight option:selected").text();
        var vals = $("#mySelecteight option:selected").val();
        var x = document.getElementById("mySelectnine");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelecteight option[value='" + vals + "']").remove();
    }
    function  myFunction10() {
        var texts = $("#mySelectnine option:selected").text();
        var vals = $("#mySelectnine option:selected").val();
        var x = document.getElementById("mySelecteight");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelectnine option[value='" + vals + "']").remove();
    }

    $(document).ready(function() {

    });
</script>
