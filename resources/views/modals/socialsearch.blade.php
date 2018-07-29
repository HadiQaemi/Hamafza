<style>
    .person-list li {
        background: #fff none repeat scroll 0 0;
        border: 1px solid #dbdbdb;
        box-shadow: 0 4px 7px rgba(162, 162, 162, 0.54);
        float: right;
        height: 120px;
        margin: 14px;
        padding: 0;
        position: relative;
        width: 250px;
        padding-left: 10px;
    }
    .person-list .person-avatar {
        float: right;
        margin: 8px;
        width: 60px;
        height: 60px;
    }
</style>
<form role="form" class="bs-example bs-example-form">
    <div class="row" style="min-height: 400px;">
        <center>
            <br>
            <center>
                <div style="width: 600px;margin: 0 100px 0 100px;">
                    <div class="input-group">
                        <div class="input-group-btn">
                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" id="but" style="height: 34px;">
                                <span>کاربران</span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li id="type_user" class="ddsel" value="1"><a href="#">کاربران</a></li>
                                <li id="type_group" class="ddsel" value="2"><a href="#"> گروه‌ها</a></li>
                                <li id="type_organ" class="ddsel" value="3"><a href="#">کانال‌ها</a></li>
                            </ul>
                        </div><!-- /btn-group -->

                        <input id="searchtext" type="text" class="form-control" autocomplete="off" style="border-left-style: solid;height: 34px;padding-right: 10px;" placeholder="نام، نام خانوادگی یا عنوان فرد مورد نظر را بنویسید">
                    </div><!-- /input-group -->
                </div>
            </center>
            </br>
            <!-- /.col-lg-6 --><br>
            <div id="response" style="width: 600px;margin-right: 80px"></div>
        </center>
    </div>
</form>
<script>
    $(document).ready(function () {
        var currentRequest = null;
        $(".ddsel").click(function () {
            id = $(this).attr('value');
            if (id == '1') {
                $("#but").html('کاربران' + '<span class="caret"></span>');
                $("#searchtext").attr("placeholder", "نام، نام خانوادگی یا عنوان فرد مورد نظر را بنویسید")
            }
            if (id == '2') {
                $("#searchtext").attr("placeholder", "نام یا معرفی اجمالی گروه مورد نظر را بنویسید")
                $("#but").html('گروه‌ها' + '<span class="caret"></span>');
            }
            if (id == '3') {
                $("#searchtext").attr("placeholder", "نام یا معرفی اجمالی کانال مورد نظر را بنویسید")
                $("#but").html('کانال ها' + '<span class="caret"></span>');
            }
            text = $("#but").html().replace('<span class="caret"></span>', '').trim();
            if (id == 1)
                type = '1';
            else if (id == 3)
                type = '3';
            else
                type = '2';
            keyword = "";
            $("#response").html('<span class="sui-loading-back"></span> <div class="contentDiv"><div class="mainDiv"><div class="logoDiv"></div><div class="textDiv"></div></div><div class="loaderDiv"><img src="img/loading.gif"></div></div>');
            currentRequest = jQuery.ajax({
                type: 'POST',
                data: ({type: type, key: keyword}),
                url: '{{ route('hamafza.search_person') }}',
                beforeSend: function () {
                    if (currentRequest != null) {
                        currentRequest.abort();
                    }
                },
                success: function (data) {
                    $("#response").html(data);
                }
            });
        });

        $("#searchtext").keyup(function () {
            keyword = $(this).val();
            text = $("#but").html().replace('<span class="caret"></span>', '').trim();
            if (text == 'کاربران')
                type = '1';
            else if (text == 'گروه‌ها')
                type = '2';
            else
                type = '3';
            if (keyword.length > 2) {
                $("#response").html('<span class="sui-loading-back"></span> <div class="contentDiv"><div class="mainDiv"><div class="logoDiv"></div><div class="textDiv"></div></div><div class="loaderDiv"><img src="img/loading.gif"></div></div>');
                currentRequest = jQuery.ajax({
                    type: 'POST',
                    data: ({type: type, key: keyword}),
                    url: '{{ route('hamafza.search_person') }}',
                    beforeSend: function () {
                        if (currentRequest != null) {
                            currentRequest.abort();
                        }
                    },
                    success: function (data) {
                        $("#response").html(data);
                    }
                });

            }
        });
        $('#type_{{$type}}').click();
    });
</script>
