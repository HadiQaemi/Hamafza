<script>
    $(document).ready(function () {
        if ($(".add2Group").first().data('member') == "1")
        {
            $(".add2Group").first().text('لغو عضویت');
            $(".add2Group").first().attr('title11', 'لغو عضویت');

        }
        $(".add2Group").unbind("click");
        $(".add2Group").click(function (e) {
            e.preventDefault();

            if (Gid == '')
                alert("ایراد  در کارکرد");
            else {
                $.ajax({

                    type: "POST",
                    url: "{{route('hamafza.add_group')}}",
                    dataType: 'html',
                    data: ({gid: Gid}),
                    success: function (theResponse) {
                        jQuery.noticeAdd({
                            text: theResponse,
                            stay: false,
                            type: 'success'
                        });
                        if ($(".add2Group").first().data('member') == "0")
                        {
                            $(".add2Group").first().data('member', "1");
                            $(".add2Group").first().text('لغو عضویت');
                            $(".add2Group").first().attr('title11', 'لغو عضویت');

                        } else
                        {
                            $(".add2Group").first().data('member', "0");
                            $(".add2Group").first().text('عضویت');
                            $(".add2Group").first().attr('title11', 'عضویت');
                        }
                    }
                });
            }
        });
    });
    $(".AcceptUser2Group").click(function () {
        var uid = $(this).attr('uid');
        if (Gid == '')
            alert("ایراد  در کارکرد");
        else {
            $.ajax({
                type: "POST",
                url: "{{route('hamafza.accept_user_to_group')}}",
                dataType: 'html',
                data: ({gid: Gid, uid: uid, e: '1'}),
                success: function (theResponse) {
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                }
            });
            $(this).parent().parent().parent().parent().parent().remove();
        }
    });
    $(".RemoveUser2Group").click(function () {
        var uid = $(this).attr('uid');
        if (Gid == '')
            alert("ایراد در کارکرد");
        else {
            $.ajax({
                type: "POST",
                url: "{{route('hamafza.accept_user_to_group')}}",
                dataType: 'html',
                data: ({gid: Gid, uid: uid, e: '0'}),
                success: function (theResponse) {
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                }
            });
            $(this).parent().parent().parent().parent().parent().remove();
        }
    });
</script>
