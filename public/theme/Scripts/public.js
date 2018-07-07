$(document).ready(function () {
    $('.dropdown-menu.keep-open').on({
        "shown.bs.dropdown": function () {
            this.closable = false;
        },
        "click": function () {
            this.closable = false;
        },
        "hide.bs.dropdown": function () {
            return this.closable;
        }
    });

    $("#LoginButt").click(function () {
        var pas = $("input.password").val();
        $("#passwordhid").val(pas);
        $("#LoginForm").submit();
    });

    $("#LoginButtw").click(function () {
        var pas = $("input.passwordw").val();
        $("#passwordhidw").val(pas);
        $("#LoginFormw").submit();
    });

    $(document).on("keypress", "input:password", function (e) {
        var keyCode = (e.keyCode ? e.keyCode : e.which);
        if (keyCode == 13)  // the enter key code
        {
            $('#LoginButt').trigger('click');
            return false;
        }
    });

    $("#LikePage,.LikePage").click(function () {
        valu = $(this).attr('val');
        uid = $(this).attr('uid');
        sid = $(this).attr('sid');
        userid = $(this).attr('userid');
        type = $(this).attr('type');
        token = $("#_Alltoken").val();
        var link = $(this).data('href');
        if (valu != null) {
            $.ajax({
                type: "POST",
                url: link,
                dataType: 'html',
                data: ({tar_val: valu, tar_uid: uid, tar_sid: sid, type: type, userid: userid, token: token}),
                success: function (theResponse) {
                    theResponse = jQuery.parseJSON(theResponse);
                    if (theResponse.val == 0) {
                        $("#LikePage").removeClass('btnActive');
                        $("#LikePage").addClass('btn');
                        $("#LikePage").attr('val', '1');
                    }
                    else {
                        $("#LikePage").removeClass('btn');
                        $("#LikePage").addClass('btnActive');
                        $("#LikePage").attr('val', '0');

                    }
                    jQuery.noticeAdd({
                        text: theResponse.message,
                        stay: false,
                        type: 'success'
                    });
                }
            });
        }
    });
    $("#FollowPage,.FollowPage").click(function () {
        valu = $(this).attr('val');
        uid = $(this).attr('uid');
        sid = $(this).attr('sid');
        userid = $(this).attr('userid');
        type = $(this).attr('type');
        var link = $(this).data('href');
        if (valu != null) {
            $.ajax({
                type: "POST",
                url: link,
                dataType: 'html',
                data: ({tar_val: valu, tar_uid: uid, tar_sid: sid, userid: userid, type: type}),
                success: function (theResponse) {
                    theResponse = jQuery.parseJSON(theResponse);
                    if (theResponse.val == 0) {
                        $("#FollowPage").removeClass('btnActive');
                        $("#FollowPage").addClass('btn');
                        $("#FollowPage").attr('val', '1');
                    }
                    else {
                        $("#FollowPage").removeClass('btn');
                        $("#FollowPage").addClass('btnActive');
                        $("#FollowPage").attr('val', '0');

                    }
                    jQuery.noticeAdd({
                        text: theResponse.message,
                        stay: false,
                        type: 'success'
                    });
                }
            });
        }
    });
});
