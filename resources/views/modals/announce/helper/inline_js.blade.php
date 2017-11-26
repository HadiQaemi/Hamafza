<script>
    $(document).on('click',"#naghlclick",function () {
        if ($(this).attr("val") == '1') {
            $("#naghl").show();
            $(this).attr("val", '0');
            $(this).removeClass("glyphicon-triangle-left");
            $(this).addClass("glyphicon-triangle-bottom");
            $("#naghallow").val("1");
        }
        else {
            $("#naghl").hide();
            $(this).attr("val", '1');
            $(this).removeClass("glyphicon-triangle-bottom");
            $(this).addClass("glyphicon-triangle-left");
            $("#naghallow").val("0");
        }
    });
    $(document).on('click','#submit_btn_add_announce',function () {
        $("#announce_send").submit();
    })
</script>