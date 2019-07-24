@include('layouts.master_tinymce')
{{--@include('modals.modalheader')--}}

<style>
    table#table_pages_list
    {
        display: none;
    }
    table#table_pages_list tr td
    {
        vertical-align: middle;
    }
</style>
<style>
    .table tr td {
        font-size: 9pt !important;
    }

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


<script type="text/javascript">
    $(document).ready(function () {
        $('#keywords').select2
        ({
            minimumInputLength: 3,
            dir: 'rtl',
            width: '100%',
            tags: false,
            ajax:
                {
                    dataType: 'json',
                    quietMillis: 150,
                    type: 'post',
                    url: '{{ route('auto_complete.keywords') }}',
                    data: function(term)
                    {
                        return {term: term};
                    }, results: function(data)
                    {
                        return { results: $.map(data, function(item) { return {text: item.text, id: item.id} }) };
                    }
                }
        });
        $('#types').select2({'width': '100%'});

        $('#RepSels').on('click', function () {
            var Sjadval_col2 = $('select#jadval_col2 option').sort().clone();
            var Sjadval_row2 = $('select#jadval_row2 option').sort().clone();

            $('select#jadval_col2 option').remove();
            $('select#jadval_row2 option').remove();


            $('select#jadval_col2').append(Sjadval_row2);
            $('select#jadval_row2').append(Sjadval_col2);


        });


        $('#choice-value').on('click', function () {
            $("#filtervalue").css('visibility', 'visible');
        });
        $('#choice-first').on('click', function () {
            $('#filtervalue').css('visibility', 'hidden');
        });
        $('#choice-second').on('click', function () {
            $('#filtervalue').css('visibility', 'hidden');
        });
        $('#jadval_col1').on('dblclick', 'option', function () {
            $(this).clone().appendTo("#jadval_col2");
            $(this).remove();
        });
        $('#jadval_col2').on('dblclick', 'option', function () {
            $(this).clone().appendTo("#jadval_col1");
            $(this).remove();
        });

        $('#jadval_row1').on('dblclick', 'option', function () {
            $(this).clone().appendTo("#jadval_row2");
            $(this).remove();
        });
        $('#jadval_row2').on('dblclick', 'option', function () {
            $(this).clone().appendTo("#jadval_row1");
            $(this).remove();
        });


        $("#Forms").change(function () {
            var formid = $(this).val();
            $.ajax({
                beforeSend: function (request) {
                    request.setRequestHeader("X-CSRF-TOKEN", '{{ csrf_token() }}');
                },
                type: "POST",
                url: '{{ route('hamafza.form_field') }}',
                dataType: 'html',
                data: ({
                    id: formid
                }),
                success: function (theResponse) {
                    $('.columns').empty();

                    var j = JSON.parse(theResponse);
                    $('#Fillter option').each(function () {
                        $(this).remove();
                    });
                    var option = $('<option value="0">بدون فیلتر</option>');
                    $('#Fillter').append(option);

                    for (var i = 0; i < j.length; i++) {
                        var option = $('<option value="' + j[i]['id'] + '">' + j[i]['field_name'] + '</option>');
                        $('.columns').append(option);
                    }
                    for (var i = 0; i < j.length; i++) {
                        var option = $('<option value="' + j[i]['id'] + '">' + j[i]['field_name'] + '</option>');
                        $('#Fillter').append(option);
                    }

                    @if($Xs != '')
                        Xs = "{{$Xs}}";
                    Xs = Xs.split(",");
                    $('#Fillter').append(option);
                    $("#jadval_col1 option").each(function () {
                        for (j = 0; j < Xs.length; j++) {
                            if (Xs[j] != '' && $(this).val() == Xs[j]) {
                                var option = $('<option value="' + Xs[j] + '">' + $(this).text() + '</option>');
                                $('#jadval_col2').append(option);
                                $("#jadval_col1 option[value='" + Xs[j] + "']").remove();

                            }
                        }
                    });

                    @endif
                            @if($Ys != '')
                        Ys = "{{$Ys}}";
                    Ys = Ys.split(",");
                    $("#jadval_row1 option").each(function () {
                        for (j = 0; j < Ys.length; j++) {
                            if (Ys[j] != '' && $(this).val() == Ys[j]) {
                                var option = $('<option value="' + Ys[j] + '">' + $(this).text() + '</option>');
                                $('#jadval_row2').append(option);
                                $("#jadval_row1 option[value='" + Ys[j] + "']").remove();

                            }
                        }
                    });

                    @endif
                    @if($filter!="0")
                    $("#Fillter").val("{{$filter}}");
                    @endif


                }
            });

        });


        var FormStuff = {
            init: function () {
                this.applyConditionalRequired();
                this.bindUIActions();
            },
            bindUIActions: function () {
                $("input[type='radio'], input[type='checkbox']").on("change", this.applyConditionalRequired);
            },
            applyConditionalRequired: function () {
                $(".require-if-active").each(function () {
                    var el = $(this);
                    if ($(el.data("require-pair")).is(":checked")) {
                        el.prop("required", true);
                    } else {
                        el.prop("required", false);
                    }
                });
            }
        };
        FormStuff.init();
    });
    $(document).ready(function () {
        $('.add').click(function () {
            $('.second ul').append($(this).removeClass('add').unbind('click'));
        });
        $('.group').hide();
        $('#option1').show();
        @if ($formexcel == 'form')
        $("#choice-form").trigger("click");
        $("#selectMe").val("{{$nemodar}}");
        $("#selectMe").trigger("change");
        $("#Forms").val("{{$formid}}");
        $("#Forms").trigger("change");


        @else
        $("#choice-exell-form").trigger("click");
        @endif

        @if($filtertype=='first')
        $("#choice-first").trigger("click");
        @elseif($filtertype=='second')
        $("#choice-second").trigger("click");
        @else
        $("#choice-value").trigger("click");
        $("#filtervalue").val("{{$filtertype}}");
        @endif


    });
    @if($Xs != '')
    $("#width-diagram").val("{{$width}}");
    $("#name-diagram").val("{{$title}}");
    @endif


    $(document).ready(function () {


        $(function () {
            $("#selectMe").val('option1');
        });

        $('#choice-form').click(function () {
            $('.select-one').trigger("click");
            formid = $("#Forms").val();
            $.ajax({
                type: "POST",
                url: '{{ route('hamafza.form_field') }}',
                dataType: 'html',
                data: ({
                    id: formid
                }),
                success: function (theResponse) {
                    $('.columns').empty();
                    var j = JSON.parse(theResponse);
                    for (var i = 0; i < j.length; i++) {
                        var option = $('<option value="' + j[i]['id'] + '">' + j[i]['field_name'] + '</option>');
                        $('.columns').append(option);
                    }
                }
            });

        });
        $('.select-one').click(function () {
            $('.blockCl').hide();
            this.checked ? $('#block').show(1000) : $('#block').hide(1000);
        });
        $('.select-two').click(function () {
            $('.blockCl').hide();
            this.checked ? $('#block-seconed').show(1000) : $('#block-seconed').hide(1000);
        });
        $('.select-three').click(function () {
            $('.blockCl').hide();
            var formid = $("#Forms").val();
            $.ajax({
                type: "POST",
                url: '{{ route('hamafza.form_reports') }}',
                dataType: 'html',
                data: ({
                    id: formid
                }),
                success: function (theResponse) {
                    var j = JSON.parse(theResponse);
                    for (var i = 0; i < j.length; i++) {
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
        if (texts != '' && vals != '') {
            x.add(option);
            $("#jadval_col1 option[value='" + vals + "']").remove();
            $("#jadval_col1 option:first").attr('selected', 'selected');
        }
    }

    function jadval_rows_add() {
        var texts = $("#jadval_row1 option:selected").text();
        var vals = $("#jadval_row1 option:selected").val();
        var x = document.getElementById("jadval_row2");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        if (texts != '' && vals != '') {
            x.add(option);
            $("#jadval_row1 option[value='" + vals + "']").remove();
            $("#jadval_row1 option:first").attr('selected', 'selected');
        }

    }

    function jadval_rows_remove() {
        var texts = $("#jadval_row2 option:selected").text();
        var vals = $("#jadval_row2 option:selected").val();
        var x = document.getElementById("jadval_row1");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        if (texts != '' && vals != '') {
            x.add(option);
            $("#jadval_row2 option[value='" + vals + "']").remove();
            $("#jadval_row2 option:first").attr('selected', 'selected');
        }
    }


    function myFunction_jadval2() {
        var texts = $("#jadval_col2 option:selected").text();
        var vals = $("#jadval_col2 option:selected").val();
        var x = document.getElementById("jadval_col1");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        if (texts != '' && vals != '') {
            x.add(option);
            $("#jadval_col2 option[value='" + vals + "']").remove();
            $("#jadval_col2 option:first").attr('selected', 'selected');

        }

    }


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

    function myFunction3() {
        var texts = $("#mySelecttwos option:selected").text();
        var vals = $("#mySelecttwos option:selected").val();
        var x = document.getElementById("mySelectthrees");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelecttwos option[value='" + vals + "']").remove();
    }

    function myFunction4() {
        var texts = $("#mySelectthrees option:selected").text();
        var vals = $("#mySelectthrees option:selected").val();
        var x = document.getElementById("mySelecttwos");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelectthrees option[value='" + vals + "']").remove();
    }

    function myFunction5() {
        var texts = $("#mySelectfour option:selected").text();
        var vals = $("#mySelectfour option:selected").val();
        var x = document.getElementById("mySelectfive");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelectfour option[value='" + vals + "']").remove();
    }

    function myFunction6() {
        var texts = $("#mySelectfive option:selected").text();
        var vals = $("#mySelectfive option:selected").val();
        var x = document.getElementById("mySelectfour");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelectfive option[value='" + vals + "']").remove();
    }

    function myFunction7() {
        var texts = $("#mySelectsix option:selected").text();
        var vals = $("#mySelectsix option:selected").val();
        var x = document.getElementById("mySelectseven");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelectsix option[value='" + vals + "']").remove();
    }

    function myFunction8() {
        var texts = $("#mySelectseven option:selected").text();
        var vals = $("#mySelectseven option:selected").val();
        var x = document.getElementById("mySelectsix");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelectseven option[value='" + vals + "']").remove();
    }

    function myFunction9() {
        var texts = $("#mySelecteight option:selected").text();
        var vals = $("#mySelecteight option:selected").val();
        var x = document.getElementById("mySelectnine");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelecteight option[value='" + vals + "']").remove();
    }

    function myFunction10() {
        var texts = $("#mySelectnine option:selected").text();
        var vals = $("#mySelectnine option:selected").val();
        var x = document.getElementById("mySelecteight");
        var option = document.createElement("option");
        option.text = texts;
        option.value = vals;
        x.add(option);
        $("#mySelectnine option[value='" + vals + "']").remove();
    }
</script>

<div id="dashbord-page" class="container" style="overflow: auto;height: 390px;background-color: #FFF;width: 100%;">
    <form class="form-horizontal" role="form">
        {{ csrf_field() }}
        <div class="col-xs-12" style="border-bottom: 1px solid #eee">
            <div class="col-xs-1">
                <label >داده</label>
            </div>
            <div class="col-xs-3">
                <input type="radio" name="choice" id="choice-form" value="out" checked>
                <label for="choice-form">نمودار بیرونی</label>
            </div>
            <div class="col-xs-4">
                <input type="radio" name="choice" id="choice-form-2" value="form" style="margin-top: -8px;">
                <label for="choice-form-2">فرم</label>
                <span class="reveal-if-active ">
                        <select class="select-form form-control" id="Forms"
                                style="max-width: 150px;display: inline-block;" placeholder="عنوان را وارد کنید">
                            @php($Forms = \App\Models\hamafza\Form::all())
                            @foreach($Forms as $item)
                                <option value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach
                        </select>
                    </span>
            </div>
            <div class="col-xs-4">
                <input type="radio" name="choice" id="choice-exell-form">
                <label for="choice-exell-form">فرم اکسل </label>
                <span class="reveal-if-active">
                    <a href="#">مدیریت فایل ها</a>
                </span>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="col-xs-1">
                <label >نمودار</label>
            </div>
            <div class="col-xs-10">
                <span class="">
                    @php($diagram = \App\Models\Hamahang\diagram_users_permission::where('user_id',auth()->user()->id)->get())
                    <select class="form-control" id="types">
                        @foreach ($diagram as $item)
                            <option value="{{$item->diagram->id}}">{{$item->diagram->title}}</option>
                        @endforeach
                    </select>

                </span>
            </div>
        </div>
        <div class="col-xs-12" style="border-bottom: 1px solid #eee;padding-bottom: 5px;margin-bottom: 5px;">
            <div class="col-xs-1">
                <label >کلیدواژه</label>
            </div>
            <div class="col-xs-10">
                <span class="">
                    <select class="form-control" id="keywords" multiple="multiple"></select><br />
                </span>
            </div>
        </div>
        <div class="col-xs-12" style="border-bottom: 1px solid #eee;padding-bottom: 10px;margin-bottom: 5px;">
            <div class="col-xs-1 line-height-35">
                <label >پارامترها</label>
            </div>
            <div class="col-xs-10 line-height-35">
                <div class="col-xs-1">
                    <label >از</label>
                </div>
                <div class="col-xs-5">
                    <input type="text" name="since" placeholder="9804" class="form-control"/>
                </div>
                <div class="col-xs-1">
                    <label >تا</label>
                </div>
                <div class="col-xs-5">
                    <input type="text" name="untim" placeholder="9804" class="form-control"/>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="col-xs-1 line-height-35">
                <label >ابعاد</label>
            </div>
            <div class="col-xs-10 line-height-35">
                <div class="col-xs-1">
                    <label >طول</label>
                </div>
                <div class="col-xs-5">
                    <input type="text" name="tol" placeholder="طول" class="form-control"/>
                </div>
                <div class="col-xs-1">
                    <label >عرض</label>
                </div>
                <div class="col-xs-5">
                    <input type="text" name="arz" placeholder="عرض" class="form-control"/>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="col-xs-1 line-height-35">
                <label >عنوان</label>
            </div>
            <div class="col-xs-10 line-height-35">
                <input type="text" name="title" placeholder="عنوان" class="form-control"/>
            </div>
        </div>
        {{--<table class="table">--}}
            {{--<tr>--}}
                {{--<td style="border: none;">عنوان</td>--}}
                {{--<td style="border: none;"><input class="form-control" id="name-diagram" placeholder="عنوان را وارد کنید" type="text">--}}
                    {{--<input id="defvalue" value="0" type="hidden">--}}
                {{--</td>--}}
            {{--</tr>--}}

            {{--<tr>--}}
                {{--<td>نوع نمایش</td>--}}
                {{--<td><select id="selectMe" class="select-form form-control" style="padding: 0.5rem;width: 150px;display: inline-block;" placeholder="عنوان را وارد کنید">--}}
                        {{--<option value="option1">جدول</option>--}}
                        {{--<option value="Pie">نمودار دایره ای</option>--}}
                        {{--<option value="Histogram">نمودار ستونی</option>--}}
                        {{--<option value="Linear">نمودار خطی</option>--}}
                        {{--<option value="Radar">نمودار راداری</option>--}}
                    {{--</select>--}}

                    {{--<span style="margin-right: 50px;">--}}
                         {{--عرض نمودار(پیکسل)                <input class="form-control" id="width-diagram" placeholder="عرض را وارد کنید" type="text" style="width: 120px;display: inline;">--}}
                    {{--</span>--}}
                {{--</td>--}}

            {{--</tr>--}}

            {{--<tr>--}}
                {{--<td>انتخاب داده</td>--}}
                {{--<td><input type="radio" name="choice" id="choice-form" required>--}}
                    {{--<label for="choice-form">فرم</label>--}}
                    {{--<span class="reveal-if-active ">--}}
                        {{--<select class="select-form form-control" id="Forms" style="max-width: 200px;display: inline-block;" placeholder="عنوان را وارد کنید">--}}
                            {{--@php($Forms = \App\Models\hamafza\Form::all())--}}
                            {{--@foreach($Forms as $item)--}}
                                {{--<option value="{{$item->id}}">{{$item->title}}</option>--}}
                            {{--@endforeach--}}
                        {{--</select>--}}
                    {{--</span>--}}

                    {{--<input type="radio" name="choice" id="choice-exell-form">--}}
                    {{--<label for="choice-exell-form">فرم اکسل </label>--}}
                    {{--<span class="reveal-if-active">--}}
                        {{--<a href="#">مدیریت فایل ها</a>--}}
                    {{--</span></td>--}}

            {{--</tr>--}}

            {{--<tr>--}}

                {{--<td colspan="2">--}}

                    {{--<div id="jadval" class="jadval">--}}
                        {{--<div class="first col-sm-4 list-group first">--}}
                            {{--<label>ستون‌های(فیلدهای) داده</label>--}}

                            {{--<select size="7" multiple="multiple" id="jadval_col1" class="columns select-form form-control" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">--}}
                            {{--</select>--}}
                        {{--</div>--}}

                        {{--<div class="col-sm-4 btn-wrapper" style="text-align: center; ">--}}
                            {{--<span class=" btn btn-4 btn-4b btn-success" style="margin: auto;  width: 90px;" onclick="myFunction_jadval()">افزودن</span>--}}
                            {{--<p></p>--}}
                            {{--<span class="btn btn-4 btn-4b btn-danger " style="margin: auto;  width: 90px;" onclick="myFunction_jadval2()">حذف کردن</span>--}}
                        {{--</div>--}}
                        {{--<div class="second col-sm-4 list-group">--}}
                            {{--<label> سطرها -محورعمودی </label>--}}
                            {{--<select size="7" multiple="multiple" id="jadval_col2" class="select-form form-control" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">--}}
                            {{--</select>--}}
                        {{--</div>--}}
                        {{--<div class="row">--}}
                            {{--<div class="first col-sm-4 list-group">--}}
                                {{--<p></p>--}}

                                {{--<label>ستون‌های(فیلدهای) داده</label>--}}
                                {{--<p></p>--}}

                                {{--<select size="7" multiple="multiple" id="jadval_row1" class="columns select-form form-control" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">--}}
                                {{--</select>--}}
                            {{--</div>--}}

                            {{--<div class="col-sm-4 btn-wrapper" style="text-align: center;">--}}
                                {{--<span class=" btn btn-4 btn-4b btn-success" style="margin: auto;  width: 90px;" onclick="jadval_rows_add()">افزودن</span>--}}
                                {{--<p></p>--}}
                                {{--<span class="btn btn-4 btn-4b btn-danger " style="margin: auto;  width: 90px;" onclick="jadval_rows_remove()">حذف کردن</span>--}}


                            {{--</div>--}}
                            {{--<div class="third col-sm-4 list-group">--}}
                                {{--<img src="{{App::make('url')->to('/')}}/img/refresh.png" id="RepSels">--}}
                                {{--<select size="7" multiple="multiple" id="vaset" style="display: none;">--}}
                                {{--</select>--}}
                                {{--<br>--}}
                                {{--<label>ستون‌ها - محور افقی</label>--}}
                                {{--<select size="7" multiple="multiple" id="jadval_row2" class="select-form form-control" style="padding: 0.5rem" placeholder="عنوان را وارد کنید">--}}
                                {{--</select>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                {{--</td>--}}

            {{--</tr>--}}

            {{--<tr>--}}
                {{--<td>فیلتر--}}
                    {{--<select id="Fillter" class="select-form form-control" style="padding: 0.5rem;width: 150px;display: inline-block;" placeholder="عنوان را وارد کنید">--}}
                        {{--<option value="0">بدون فیلتر</option>--}}

                    {{--</select>--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--<input type="radio" required="" id="choice-first" name="choice2">اولین رکورد--}}
                    {{--<input type="radio" required="" id="choice-second" name="choice2">آخرین رکورد--}}
                    {{--<input type="radio" required="" id="choice-value" name="choice2">مقدار--}}
                    {{--<input type="text" class="form-control" name="values" id="filtervalue" style="width: 150px;display: inline;visibility: hidden">--}}
                {{--</td>--}}

            {{--</tr>--}}
        {{--</table>--}}

    </form>
</div>
