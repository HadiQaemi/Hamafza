var currentRequest = null;
$(".scrl-2").mCustomScrollbar({
    callbacks: {
    whileScrolling: function() {
     //alert("sss");
    }
  } 
    
    /*callbacks: {
        onTotalScroll: function() {
            var cou = $(".comment-contain:last").attr("postid");
            var username = $("#UserConUname").val();
            var URL='';
            var PageTypes=$("#PageTypes").val();
            if(PageTypes=='contents')
                URL= Baseurl + "GetUserContentPaging";
            else if(PageTypes=='userwall')
                URL= Baseurl + "GetWallByPaging";
            else if(PageTypes=='GroupContent')
                URL= Baseurl + "GroupContentsPaging";

            $(".ContentSec").append('<span id="ConLoading" class="sui-loading-back"></span> <div class="contentDiv"><div class="mainDiv"><div class="logoDiv"></div><div class="textDiv">منتظر بمانید</div></div><div class="loaderDiv"></div></div>');
            if (cou != null) {
                currentRequest = jQuery.ajax({
                    type: "POST",
                    url: URL,
                    dataType: 'text',
                    data: ({postid: cou, Uname: username}),
                    beforeSend: function() {
                        if (currentRequest != null) {
                            currentRequest.abort();
                            $(".contentDiv").hide();
                        }
                    },
                    success: function(data) {
                        $("#ConLoading").remove();
                        $(".contentDiv").hide();
                        $(".ContentSec").append(data);
                    }
                });
            }
        }
    }*/
});
function loadFile(event) {
    $("#picUploadW").css("color", "red");
    $(".icon-ax").css("color", "red");
}
 function CommentSend(e, event) {
    if (event.which == 13) {
        var val = $(e).val();
        if (val == '')
            alert("محتوا خالی است");
        else {
            uid = curUid;
            obj = $(e);
            postid = $(e).attr('postid');
            if (val != null) {
                $.ajax({
                    type: "POST",
                    url: Baseurl + "postcomment",
                    dataType: 'text',
                    data: ({postid: postid, uid: uid, comment: val}),
                    success: function(theResponse) {
                        var json = $.parseJSON(theResponse);
                        str = '<div class="addcomment commentShow"><input class="commentid" type="hidden" value="' + json['id'] + '" ><a target="_blank" href="' + CarUname + '"> <img class="imgContain" src="' + CurPics + '"></a>';
                        str = str + '<div class="txtContain">' + val + '</div><span class="CommentTime">0ثانیه قبل</span></div>';
                        $(obj).closest(".addcomment").before(str);
                        jQuery.noticeAdd({
                            text: json['text'],
                            stay: false,
                            type: 'success'
                        });
                    }
                });
                $(e).val("");
            }
        }
    }
}

$(document).ready(function()
{
    $(".Endorse").click(function() {
        type = $(this).attr('Type');
        spid = $(this).attr('spid');
        $(this).hide();

        if (spid == '')
            alert("محتوا خالی است");
        else {
            $.ajax({
                type: "POST",
                url: Baseurl + "endorse",
                dataType: 'html',
                data: ({type: type, spid: spid}),
                success: function(theResponse) {
                    if (type == 'EndorseUnDo')
                    {
                        $('#USER_' + spid + '_' + curUid).remove();
                        $('#do_' + spid).show();
                    }
                    else {
                        $('#Undo_' + spid).show();
                        $("#viewULEnd_" + spid).append("<li  id='USER_" + spid + "_" + curUid + "'><img src='" + CurPic + "' style='height: 30px;width: 30px;border-radius: 50%;' class='mCS_img_loaded'></li>");
                    }
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                }
            });
        }
    });

    $(".addBookmark").click(function() {
        type = 'user';
        title = 'صفحه شخصی: ' + $('#toolbar .right-detail h2').html();
        if (title == '')
            alert("محتوا خالی است");
        else {
            $.ajax({
                type: "POST",
                url: Baseurl + "bookmark",
                dataType: 'html',
                data: ({type: type, title: title, tid: uids}),
                success: function(theResponse) {
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                }
            });
        }
    });

    $(".CheckedGroup").click(function() {
        if ($(this).is(":checked") == true) {
            news = $(this).attr("value");
            cur = $("#groups").val();
            if (cur == "all")
                $("#Cids").val("0");
            $("#groups").val(cur + "," + news);
        }
        else
        {
            news = $(this).attr("value");
            cur = $("#groups").val();
            cur = cur.replace("," + news, "");
            $("#groups").val(cur)
        }
    });

    $(".btnpost").click(function()
    {
        uid = curUid;
        pid = Sid;
        type = $("#post_type").val();
        desc = $("#NewPost").val();
        title = $("#commentTitleW").val();
        image = '';
        video = '';
        all = '1';
        keys = '';
        cids = $("#Cids").val();
        gids = $("#groups").val();
        var formData = new FormData();
        formData.append('image', $('#pictureUpload')[0].files[0]);
        formData.append('uid', uid);
        formData.append('pid', pid);
        formData.append('type', type);
        formData.append('desc', desc);
        formData.append('title', title);
        formData.append('all', all);
        formData.append('keys', keys);
        formData.append('cids', cids);
        formData.append('gids', gids);
        if (title == '')
            alert("محتوا خالی است");
        else {
            $.ajax({
                type: "POST",
                url: Baseurl + "newpost",
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                data: formData,
                success: function(theResponse) {
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                }
            });
        }
    });
    $("#commentTitleW").keypress(function(e)
    {
        $("#commentEditorW").show();
        $("#commentEditorW").stop().animate({
            height: "100px"
        });
    });

    $('.CommentSend').on('keypress', function(e) {
        if (e.which == 13) {
            var val = $(this).val();
            if (val == '')
                alert("محتوا خالی است");
            else {
                uid = curUid;
                obj = $(this);
                postid = $(this).attr('postid');
                if (val != null) {
                    $.ajax({
                        type: "POST",
                        url: Baseurl + "postcomment",
                        dataType: 'text',
                        data: ({postid: postid, uid: uid, comment: val}),
                        success: function(theResponse) {
                            var json = $.parseJSON(theResponse);
                            str = '<div class="addcomment commentShow"><input class="commentid" type="hidden" value="' + json['id'] + '" ><a target="_blank" href="' + CarUname + '"> <img class="imgContain" src="' + CurPics + '"></a>';
                            str = str + '<div class="txtContain">' + val + '</div><span class="CommentTime">0ثانیه قبل</span></div>';
                            $(obj).closest(".addcomment").before(str);
                            jQuery.noticeAdd({
                                text: json['text'],
                                stay: false,
                                type: 'success'
                            });
                        }
                    });
                    $(this).val("");
                }
            }
        }
    });
//    $(".CommentSend").keypress(function(e)
//    {
//        
//    });
    $(".Comment_Foc").click(function()
    {
        var postid = $(this).attr("postid");
        postid = "#" + postid;
        $(postid).focus();
        $(postid).val(" ");
    });
    $(".PostLike").click(function()
    {
        uid = curUid;
        obj = $(this);
        like = $(this).attr('like');
        postid = $(this).attr('postid');
        likecount = $("#LikeCounter_" + postid).text();
        if (postid != null) {
            $.ajax({
                type: "POST",
                url: Baseurl + "postlike",
                dataType: 'html',
                data: ({postid: postid, uid: uid, like: like}),
                success: function(theResponse) {
                    if (like == 1) {
                        $(obj).html("حذف پسند");
                        $(obj).attr('like', '0');
                        likecount++;
                        $("#LikeCounter_" + postid).html(likecount);
                    }
                    else
                    {
                        $(obj).html("پسند");
                        $(obj).attr('like', '1');
                        likecount--;
                        $("#LikeCounter_" + postid).html(likecount);
                    }
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                }
            });
        }
    });
    $('.dropdown.keep-open').on({
        "shown.bs.dropdown": function() {
            this.closable = false;
        },
        "click": function(e) {
            var target = $(e.target);
            if (target.hasClass("dropdown-toggle"))
                this.closable = true;
            else
                this.closable = false;
        },
        "hide.bs.dropdown": function() {
            return this.closable;
        }
    });
    $(".sel_circle").click(function() {
        if ($(this).attr('checked')) {
            news = $(this).attr('value');
            cur = $("#Cids").val();
            $("#Cids").val(cur + "," + news);
        } else {
            $("#txtAge").hide();
        }
    });
    $("input[name=circle]").click(function() {
        if ($('input[name=circle]:checked').val() == 'only') {
            uid = curUid;
            $("#Cids").val("0");
            $.ajax({
                type: "POST",
                url: Baseurl + "GetMyCircle",
                dataType: 'text',
                data: ({uid: uid}),
                success: function(theResponse) {
                    var json = $.parseJSON(theResponse);
                    var i = 0;
                    var len = json.length;
                    strs = '';
                    for (; i < len; ) {
                        strs += '<li><input type="checkbox"  value="' + json[i]['id'] + '" class="sel_circle receiver" name="circle[]">' + json[i]['name'] + '</li>';
                        i++;
                    }
                    strs += '<script>$(".sel_circle").click(function() {    if ($(this).is(":checked")==true) {         news=$(this).attr("value");  cur= $("#Cids").val(); if(cur=="all")$("#Cids").val("0"); $("#Cids").val(cur+","+news); } else { news=$(this).attr("value"); cur= $("#Cids").val(); cur=cur.replace(","+news, ""); $("#Cids").val(cur)} });</script>';
                    $("#Circles").html(strs);
                    $("#Circles").show();
                    $("#CirclesW").html(strs);
                    $("#CirclesW").show();
                }
            });
        }
        else {
            $("#Cids").val('all');
        }

    });
});