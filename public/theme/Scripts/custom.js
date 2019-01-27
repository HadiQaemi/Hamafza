$(document).ready(function () {
    $('.addBookmark').click(function () {
        var $this = $(this);
        var target_id = $this.data('target_id');
        var target_table = $this.data('target_type');
        if (target_table == '' || target_id == '') {
            alert('محتوا خالی است.');
        } else {
            $.ajax
            ({
                url: Baseurl + 'bookmarks/add',
                type: 'post',
                dataType: 'json',
                data: {target_table: target_table, target_id: target_id},
                success: function (response) {
                    jQuery.noticeAdd
                    ({
                        type: response[0],
                        text: response[1],
                        stay: false
                    });
                }
            });
        }
    });
});

$(document).click(function (event) {
    var isloc = $(event.target).closest('.token-input-list').length;
    if (isloc == 0) {
        if ($('.token-input-dropdown:visible').is(":visible")) {
            $('.token-input-dropdown:visible').hide();
        }
    }
});
function runWaitMe(el, type = 1, effect = 'pulse') {
    message = 'لطفا شکیبا باشید ...';
    fontSize = '';
    /* More types such as vertical presentation can be added */
    switch (type) {
        case 1:
            maxSize = '';
            textPos = 'vertical';
    }
    el.waitMe({
        effect: effect,
        text: message,
        bg: 'rgba(255,255,255,0.7)',
        color: '#000',
        maxSize: maxSize,
        waitTime: -1,
        source: 'img.svg',
        textPos: textPos,
        fontSize: fontSize,
        onClose: function (el) {
        }
    });
}
function parseArabic(str) {
    return str.replace(/۰/g, '0').replace(/۱/g, '1').replace(/۲/g, '2').replace(/۳/g, '3').replace(/۴/g, '4').replace(/٤/g, '4').replace(/۵/g, '5').replace(/۶/g, '6').replace(/۷/g, '7').replace(/٧/g, '7').replace(/۸/g, '8').replace(/٩/g, '9').replace(/۹/g, '9');
}



$(document).on('mouseover', '[data-toggle="tooltip"]', function () {
    $('[data-toggle="tooltip"]').tooltip();
    // alert('asdasdasd');
});

///
$(document).ready(function () {
    // for task manages +++++++++++++++++++++
    $(document).on("change", "#create_new_task #new_task_users_responsible", function (e) {
        var none = $(this).find('option:selected').length;
        // alert(none);
        if(none > 1)
            $('.person_option').show();
        else
            $('.person_option').hide();
        if(none >= 1)
            $('.send_message').show();
        else
            $('.send_message').hide();

        var title = $('#create_new_task #title').val();
        if(title.trim().length>0 && none>0)
            $('#new_task_save_type_final').click();
        else
            $('#new_task_save_type_draft').click();
    });

    $(document).on("keyup", "#create_new_task #title", function (e) {
        var title = $(this).val();
        // alert(title);
        var new_task_users_responsible = $('#new_task_users_responsible').find('option:selected').length;
        if(title.trim().length>0 && new_task_users_responsible>0)
            $('.new_task_save_type_final').click();
        else
            $('.new_task_save_type_draft').click();
    });
    // +++++++++++++++++++


    var slider;

    $("#scrollReset").stop(true, true).fadeOut();

    $(window).resize(function () {
        manageScroll();
    });

    function manageScroll() {
        if (window.innerWidth < 992) {
            $("#vrScroll").mCustomScrollbar({
                theme: "dark-3", advanced: {
                    updateOnContentResize: true,
                    updateOnImageLoad: true
                }
            });
        } else {
            $("#vrScroll").mCustomScrollbar("destroy")
        }
    }


    function AddTagsByname(e, Tname, Tid) {
        $(e).tokenInput("add", {id: Tid, name: Tname});

    }

    function wichLink(el, w) {
        var htmlUrl = el.attr("href");
        htmlUrl = htmlUrl.replace('#/', '');
        loadCntnt(htmlUrl, w);

    }

    function uniqueId() {
        return new Date().getTime()
    }

    $(".content").mCustomScrollbar({
        callbacks: {
            onTotalScroll: function () {
                console.log("scrolled to bottom");
            }
        }
    });

    function loadCntnt(url, w) {
        $('body').append('<div class="rplc-cntnt"></div>');
        $(".rplc-cntnt").load(url + "?t=" + uniqueId(), function (response, status, xhr) {
            /*New JS*/
            //footer ++++++++++++++++++++++++
            if (url.toLowerCase().indexOf("index") < 0) {
                $("div.footerPage").hide()
            } else {
                $("div.footerPage").show()
            }

            //-------------------------------------
            if (status == "error") {
                var msg = "Sorry but there was an error";


            } else {
                var wrpr = $(".rplc-cntnt");
                $(".rplc-cntnt").remove();
                var cntnt;
                if (w === 'main-menu') {
                    cntnt = $('div[hmfz-tmplt-cntnt]', wrpr);
                    $('div[hmfz-ui-view] *').remove();
                    $('div[hmfz-ui-view]').empty().html(cntnt);
                    homeSlider();
                    $('[data-toggle="tooltip"]').tooltip();
                    $('body').removeClass('theme-lightblue theme-pink theme-darkblue theme-gold theme-green');
                    $('body').addClass(cntnt.attr('hmfz-tmplt-thm-clr'));
                } else if (w === 'page-tab') {
                    cntnt = $('div[hmfz-pg-tb-cntnt]', wrpr);
                    $('div[hmfz-pg-tb]').empty().html(cntnt);
                }
//                    $(".scrl-2").mCustomScrollbar({theme: "dark-3"});
//                    $(".scrl-3").mCustomScrollbar({theme: "dark-3"});
            }
            /*New JS*/
            //footer ++++++++++++++++++++++++
            if ($("body").find("div.footerPage").length > 1) {

                $("body").find("div.footerPage").last().hide()
            }
            //-------------------------------------

        });

    }

    //------------------------------------------
    // toolbar SubMenu +++++++++++++++++++++

    $(document).on("click", ".MustLogin", function (e) {

        if ($("body").find("div#modalTransparent").length <= 0) {

            $("body").append("<div id='modalTransparent' />")
        }
        if ($(this).attr("class") == "register" || $(this).attr('class') == "login") {
            closeFlag = false
        } else {
            close = true
        }
    });
    $(document).on("keypress", "#searchword", function (e) {
        var keyCode = (e.keyCode ? e.keyCode : e.which);
        if (keyCode == 13)  // the enter key code
        {
            $('#SearchBut').trigger('click');
            return false;
        }
    });
    $(document).on("click", ".activity", function (e) {
        e.preventDefault();
        //newjs
        $('.activty-box').stop().slideToggle(400);
        $(document).stop().mouseup(function (e) {
            var container = $("div.activty-box");
            if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
            {
                container.stop().slideUp();
            }
        });
    });
    //-------------------------------------
    // full screen ++++++++++++++++++++++++
    $(document).on("click", "#fa-angle-double-left", function (e) {
        $(".fa-angle-double-left").addClass("hidden");
        $(".fa-angle-double-left").addClass("deactive");
        $(".fa-angle-double-right").removeClass("hidden");
        $(".fa-angle-double-right").removeClass("deactive");
        $("#new-fehrest").removeClass("hidden");
        $("#new-fehrest li").css("margin-right","8px !important");
        $("#new-fehrest .jstree-default.jstree-rtl .jstree-leaf > .jstree-ocl").css("display","none !important");
        $(".jstree-default.jstree-rtl .jstree-leaf > .jstree-ocl").css("display","none !important");
        $("#mySidenav00").removeClass("hidden");
        // $("#buttoninfullscreen").addClass("col-xs-3");
        $(".right-new").addClass("col-xs-2");
        $(".buttoninfullscreen").css("width","25%");
        $(".buttoninfullscreen").css("right","0px");
        $(".buttoninfullscreen").css("top","-15px");
        $(".buttoninfullscreen").css("height","100v");
        $(".buttoninfullscreen").css("position","relative");
        $("#new-content").addClass("col-xs-9");
        $("#new-content").removeClass("col-xs-12");
        $('#calendar').removeClass('col-xs-12');
        $('#calendar').addClass('col-xs-10');
        $('#calendar_sidebar').addClass('col-xs-2');
        $('.panel-heading panel-heading-darkblue').addClass('hidden');
    });
    $(document).on("click", "#fa-angle-double-right", function (e) {
        $("#new-fehrest li").css("margin-right","8px !important");
        $("#new-fehrest .jstree-default.jstree-rtl .jstree-leaf > .jstree-ocl").css("display","none");
        $(".jstree-default.jstree-rtl .jstree-leaf > .jstree-ocl").css("display","none !important");
        $(".fa-angle-double-right").addClass("hidden");
        $(".fa-angle-double-right").addClass("deactive");
        $(".fa-angle-double-left").removeClass("hidden");
        $(".fa-angle-double-left").removeClass("deactive");
        $("#new-fehrest").addClass("hidden");
//                            $("#new-fehrest").removeClass("col-xs-3");
        $(".right-new").removeClass("col-xs-2");
        $(".buttoninfullscreen").css("width","1.5%");
        $(".buttoninfullscreen").css("position","fixed");
        $(".buttoninfullscreen").css("right","15px");
        $(".buttoninfullscreen").css("height","100%");
        $(".buttoninfullscreen").css("top","2px");
        $("#buttoninfullscreen").removeClass("col-xs-3");
        $("#new-content").removeClass("col-xs-9");
        $("#new-content").addClass("col-xs-12");
        $('#calendar').addClass('col-xs-12');
        $('#calendar').removeClass('col-xs-10');
        $('#calendar_sidebar').removeClass('col-xs-2');
        $('.panel-heading panel-heading-darkblue').removeClass('hidden');
    });
    $(document).on("click", ".ful-scrn", function (e) {
        e.preventDefault();
        $(".ful-scrn").css("position","absolute");
        $(".ful-scrn").css("top","5px");
        $(".ful-scrn").css("left","5px");
        var rel = $(this).attr('rel');
        if(rel ==3)
        {
            $('.first-fix-box').toggleClass('ful-fix');
            //$(".ful-fix.fix-box").mCustomScrollbar({theme: "dark-3"});
            if ($(".first-fix-box .ful-scrn span").hasClass("icon-nim-safhe"))
                $(".first-fix-box .ful-scrn span").removeClass("icon-nim-safhe");
            else
                $(".first-fix-box .ful-scrn span").addClass("icon-nim-safhe");
            //alert($('#pcol_32').html());
            if ($("#new-fehrest").hasClass("hidden")){
                $('#new-fehrest').removeClass("hidden");
            }else{
                $('#new-fehrest').addClass("hidden");
            }
            if ($("#calendar_sidebar").hasClass("hidden")){
                html = '<div id="TextSection" style="display: inline-block;">' +
                    '<div class="col-xs-12">'+
                        '<div id="buttoninfullscreen" class="buttoninfullscreen deactive" style="margin-right: -2.4%">'+
                            '<div class="right-new">'+
                                '<i class="fa fa-angle-double-left" aria-hidden="true" id="fa-angle-double-left"></i>'+
                                '<i class="fa fa-angle-double-right deactive hidden" id="fa-angle-double-right" aria-hidden="true"></i>'+
                                    '<div id="new-fehrest" class="hidden">'+$('#calendar_datepickar').html() + $('#calendar_myCalendar').html() +
                                    '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
                $('#calendar_sidebar').html(html);
                $('#calendar_sidebar').removeClass('hidden');
                $('#calendar').addClass('padding-right-50');
            }else{
                $('#buttoninfullscreen').addClass("hidden");

                $('#calendar').addClass('col-xs-12');
                $('#calendar').removeClass('col-xs-10');
                $('#calendar_sidebar').removeClass('col-xs-2');
                $('#calendar_sidebar').addClass('hidden');
                $('#calendar').removeClass('padding-right-50');
            }
            var str = $('#pcol_32').html();
            $('#mySidenav00').html(str.replace("Fehresrt","Fehresrt-new").replace("list-search","list-search-new"));

        }else if(rel ==2)
        {
            $('.second-fix-box').toggleClass('ful-fix');
            //$(".ful-fix.fix-box").mCustomScrollbar({theme: "dark-3"});
            if ($(".second-fix-box .ful-scrn span").hasClass("icon-nim-safhe"))
                $(".second-fix-box .ful-scrn span").removeClass("icon-nim-safhe");
            else
                $(".second-fix-box .ful-scrn span").addClass("icon-nim-safhe");
            //alert($('#pcol_32').html());
            if ($("#new-fehrest").hasClass("hidden")){
                $('#new-fehrest').removeClass("hidden");
            }else{
                $('#new-fehrest').addClass("hidden");
            }
            if ($("#buttoninfullscreen").hasClass("hidden")){
                $('#buttoninfullscreen').removeClass("hidden");
            }else{
                $('#buttoninfullscreen').addClass("hidden");
            }
            var str = $('#pcol_32').html();
            $('#mySidenav00').html(str.replace("Fehresrt","Fehresrt-new").replace("list-search","list-search-new"));
        }else{
            
            $('.first-fix-box').toggleClass('ful-fix');
            if ($(".first-fix-box .ful-scrn span").hasClass("icon-nim-safhe"))
            {
                //$(".ful-fix.fix-box").mCustomScrollbar({theme: "dark-3"});
                $(".first-fix-box .ful-scrn span").removeClass("icon-nim-safhe");
                $('.mixed-scroll').css('right','29%');
            }
            else{
                $(".first-fix-box .ful-scrn span").addClass("icon-nim-safhe");
                if($(".first-fix-box .ful-scrn span").hasClass("icon-openNav00"))
                {
                    $('.mixed-scroll').css('right','20%');

                }else{
                    $('.mixed-scroll').css('right','1%');
                }
            }
            //alert($('#pcol_32').html());
            if ($("#new-fehrest").hasClass("hidden")){
                $('#new-fehrest').removeClass("hidden");
            }else{
                $('#new-fehrest').addClass("hidden");
            }
            if ($("#buttoninfullscreen").hasClass("hidden")){
                $('#buttoninfullscreen').removeClass("hidden");
            }else{
                $('#buttoninfullscreen').addClass("hidden");
            }
            var str = $('#pcol_32').html();
            $('#mySidenav00').html(str.replace("Fehresrt","Fehresrt-new").replace("list-search","list-search-new"));

        }

    });

    //-------------------------------------
    // full screen2 ++++++++++++++++++++++++
    $(document).on("click", ".ful-scrn2", function (e) {
        e.preventDefault();
        $('.fix-box2').toggleClass('ful-fix2');
        //$(".ful-fix.fix-box").mCustomScrollbar({theme: "dark-3"});
        if ($(".ful-scrn2 span").hasClass("icon-nim-safhe"))
            $(".ful-scrn2 span").removeClass("icon-nim-safhe");
        else
            $(".ful-scrn2 span").addClass("icon-nim-safhe");
        //alert($('#pcol_32').html());
        if ($("#new-fehrest").hasClass("hidden")){
            $('#new-fehrest').removeClass("hidden");
        }else{
            $('#new-fehrest').addClass("hidden");
        }
        if ($("#buttoninfullscreen").hasClass("hidden")){
            $('#buttoninfullscreen').removeClass("hidden");
        }else{
            $('#buttoninfullscreen').addClass("hidden");
        }
        var str = $('#pcol_32').html();
        $('#mySidenav00').html(str.replace("Fehresrt","Fehresrt-new").replace("list-search","list-search-new"));

    });
    //-------------------------------------

    // Side search ++++++++++++++++++++++++

    // Side search ++++++++++++++++++++++++
    $('.sidesearch-disable').add('.side-search .close').click(function (event) {
        closeSearch();
    });

    $(".side-search").css("top", $("#header").height());

    $(window).resize(function () {
        $(".side-search").css("top", $("#header").height())
    });


    $("#avatar").click(function () {

        $('div.dropdown-menu').click(function (event) {
            event.stopPropagation();
        })
    });


    function openSearch(state) {
        $('.side-search a').closest('li').eq(state).children('a').tab('show');
        $('.side-search ul.nav-tabs li').removeClass("active").not(':eq(' + state + ')').stop(true, true).hide()
        $('.side-search ul.nav-tabs li').eq(state).stop(true, true).show().addClass("active")
        $("#main").stop(true).animate({
            marginRight: "0",
            marginLeft: "450px"
        });
        $(".side-search").stop(true).animate({
            left: 0,
            top: $("#header").height()
        })
    }

    $(document).on('keyup', '#portallist-search', function () {
        clearTimeout(keyword_search_time);
        keyword_search_time = setTimeout(function () {
            $('ul.navbar-nav .icon-dargah').click()
        }, 1000);
    });

    function closeSearch() {
        $("#main").stop(true).animate({
            marginRight: "0px",
            marginLeft: "0px"
        });
        $(".side-search").stop(true).animate({
            left: -450
        }, function () {
            $('.side-search ul.nav-tabs li').stop(true, true).show()
        })
    }

    //----------------------------------------
    //----------------------------------------

    // Home Slider +++++++++++++++++++++++++++

    homeSlider();

    function homeSlider() {
        $('#bootslider').add('#bootslider *').off().removeData();
        for (var member in slider)
            delete slider[member];
        slider = new bootslider('.bootslider', {
            canvas: {
                width: 1206,
                height: 330
            }
        });
        slider.init();
    }

    //----------------------------------------

    // tooltip +++++++++++++++++++++++++++++++
    $('[data-toggle="tooltip"]').tooltip();
    //----------------------------------------

    // list Search +++++++++++++++++++++++++++
    $(document).on("keyup", "#list-search", function (e) {
        var txt = $(this).val();
        if (txt === '') {
            $('.searching-cntnt *').removeClass('src-hdn src-hlt');
        } else {
            var txt2 = ':contains("' + txt + '")';
            var found = $('.searching-cntnt .panel-title span' + txt2).add('.searching-cntnt li' + txt2);
            $('.searching-cntnt .panel-title span').add('.searching-cntnt li').removeClass('src-hlt').addClass('src-hdn');
            found.addClass('src-hlt').removeClass('src-hdn');
        }
    });

});


/*New JS*/
/*For Right Sub Menu*/

//++++++++++++++++++++++++++++++++++++++++

var rightSubMenu = "-1600px";

$(document).on("click", "#rSubMenuBtn", function (e) {
    rightSubMenu = rightSubMenu == "0" ? "-2600px" : "0";
    Showmenu = rightSubMenu == "0" ? "true" : "false";
    if (rightSubMenu == "0") {
        $("div.rightSubMenu").stop().css("display", "none");
        $("#toolbar .btn-group").hide();
        $("#toolbar .frst-wdt").show();
        $(this).removeClass('icon-reorder');
        $(this).addClass('icon-bastan');

        $(document).stop().mouseup(function (e) {
            var container = $("div.rightSubMenu >div.menu");
            if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
                $("#toolbar .btn-group").show();
            $("#toolbar .frst-wdt").show();
            $("#rSubMenuBtn").removeClass('icon-bastan');
            $("#rSubMenuBtn").addClass('icon-reorder');
            {
                $("div.rightSubMenu").stop().css("display", "block").animate({
                    right: "-2600px"
                }, function () {
                    if (rightSubMenu == "-2600px") {
                        $("div.rightSubMenu").stop().css("display", "none");
                        $("#rSubMenuBtn").removeClass('icon-bastan');
                        $("#rSubMenuBtn").addClass('icon-reorder');
                    }
                })
            }
        });
    }

    $("div.rightSubMenu").stop().css("display", "block").animate({
        right: rightSubMenu
    }, function () {
        if (rightSubMenu == "-160px") {
            $("div.rightSubMenu").stop().css("display", "none")
        }
    })
});

$(document).on("click", "div.rightSubMenu div.pull-right ul li a", function () {
    $(this).parent().addClass("active").siblings().removeClass("active");
    $("div.rSubMenuData >div").stop().hide();
    $("div.rSubMenuData >div#" + $(this).attr("href").split("#")[1]).stop().fadeIn();
    return false
});

//----------------------------------------

/*For Login/Register Modal Transparent Div Problem*/

//++++++++++++++++++++++++++++++++++++++++

var closeFlag = true;

/*when click on body*/

$(document).mouseup(function (e) {
    var container = $("div.modal-dialog");
    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        closeFlag = true
    }
});

/*when click on register/login button*/
$(document).on("click", "div#login div.registers,div#register div.login,#header div.registers,#header div.login", function () {
    if ($("body").find("div#modalTransparent").length <= 0) {
        $("body").append("<div id='modalTransparent' />")
    }
    if ($(this).attr("class") == "register" || $(this).attr("class") == "login") {
        closeFlag = false;
    } else {
        close = true
    }
});

/*when press Esc button*/
$(document).on("keyup", function (e) {

    if (e.keyCode == 27) {
        closeFlag = true
    }
});

/*when click close button*/

$(document).on("click", "div.modal-dialog .close", function () {
    closeFlag = true
});

/*on close modal*/

$(document).on('hidden.bs.modal', '#register,#login', function (event) {
    if (closeFlag) {

        $("body").find("div#modalTransparent").remove()
    }
});

//----------------------------------------

/*For Send Comment*/

//++++++++++++++++++++++++++++++++++++++++
var mainContainerPosition = "absolute";

$(document).on("click", ".MenuDiv .comment", function () {
    $("#toolbar .comment").trigger("click");
    $("#TitleHead").html('نظر');

});

$(document).on("click", ".MenuDiv .question", function () {
    $("#toolbar .comment").trigger("click");
    $("#post_type").val('2').change();
    $("#NewPost").attr('placeholder', 'پرسش تان را واردکنید');
});

$(document).on("click", "#toolbar .comment", function () {
    mainContainerPosition = mainContainerPosition == "absolute" ? "static" : "absolute";
    $("#commentEditorW").show();
    $("#commentEditorW").stop().animate({
        height: editorHeight
    });

    $(".sendComment").stop().animate({
        height: 350
    });

    if (mainContainerPosition == "static") {
        $("#mainContainer").css("position", mainContainerPosition);
        $("#mainContainer").css("height", '800');

    }

    $(this).parent().parent().parent().find(".sendComment").slideToggle('', function () {

        if (mainContainerPosition == "absolute") {
            $("#mainContainer").css("position", mainContainerPosition);
            $("#mainContainer").css("height", 'auto');
        }
    });
});

var editorHeight = "200px";
$(document).on("keyup", "input#commentTitleWW", function (e) {
    $("#commentEditorWW").show();
    $("#commentEditorWW").stop().animate({
        height: 325
    });
    $(".sendComment").stop().animate({
        height: 325
    })
    $('#Commentkeywords2').select2();
});

$(document).on("click", "div.sendComment .fa-close", function () {
    $("#toolbar .comment").click();
    $('.ful-scrn').css('display','inline');
});

$(document).on("click", "div.commenTxtHolder ul li a#picUpload", function () {

    $("#pictureUpload").click()

});

$(document).on("click", "#picUploadW", function () {
    $("#pictureUpload").click()
});

$(document).on("click", "div.commenTxtHolder ul li a#vidUpload", function () {
    $("#pictureUpload").click()
});

$(document).on("click", "#vidUploadW", function () {
    $("#pictureUpload").click()
});
//----------------------------------------

$("div.footerPage:first").remove();

/*For Js Panel*/

$(document).on("click", ".Delicn", function () {
    page = $(this).attr('page');
    id = $(this).attr('id');
    if (id != null) {
        $.ajax({
            type: "POST",
            url: Baseurl + "DeleteRow",
            dataType: 'html',
            data: ({id: id, page: page}),
            success: function (theResponse) {
                jQuery.noticeAdd({
                    text: theResponse,
                    stay: false,
                    type: 'success'
                });
            }
        });
    }
    $(this).parent().parent().parent().remove();

});

$(document).on("click", ".PostDelicn", function () {
    page = $(this).attr('page');
    id = $(this).attr('id');
    if (id != null) {
        $.ajax({
            type: "POST",
            url: Baseurl + "DeleteRow",
            dataType: 'html',
            data: ({id: id, page: page}),
            success: function (theResponse) {
                jQuery.noticeAdd({
                    text: theResponse,
                    stay: false,
                    type: 'success'
                });
            }
        });
    }
    $(this).parent().parent().parent().parent().remove();

});

$(document).on("click", ".CommentDelicn", function () {
    page = $(this).attr('page');
    id = $(this).attr('id');
    if (id != null) {
        $.ajax({
            type: "POST",
            url: Baseurl + "DeleteRow",
            dataType: 'html',
            data: ({id: id, page: page}),
            success: function (theResponse) {
                jQuery.noticeAdd({
                    text: theResponse,
                    stay: false,
                    type: 'success'
                });
            }
        });
    }
    $(this).parent().parent().remove();
});

$(document).on("click", ".DelicnS", function () {
    page = $(this).attr('page');
    id = $(this).attr('id');
    if (id != null) {
        $.ajax({
            type: "POST",
            url: Baseurl + "DeleteRow",
            dataType: 'html',
            data: ({id: id, page: page}),
            success: function (theResponse) {
                jQuery.noticeAdd({
                    text: theResponse,
                    stay: false,
                    type: 'success'
                });
            }
        });
    }
    $(this).parent().parent().remove();
});


function AddTags(Tid, Tname, val) {
    if (val == 1 || val == 3)
        $("#Navigatekeywords").tokenInput("clear");
    $("#Navigatekeywords").tokenInput("add", {id: Tid, name: Tname});
    $(".leftOver").animate({
        scrollTop: 0
    }, 'slow');
    if (val == 1) {
        $("#TagBut").trigger("click");
        $(".icon-tag").trigger("click");
    }
    if (val == 2) {
        $(".icon-tag").trigger("click");
        $("#TagBut").trigger("click");
    }
}

//++++++++++++++++++++++++++++++++++++++++
$(document).on("click", ".jsPanels", function () {
    link = $(this).attr('href');
    title = $(this).attr('title');
    modal = 'modal' == $(this).attr('modal') ? 'modal' : '';
    //get_height = $(this).attr('height');
    if (link.indexOf('share?sid') > 0)
        title = 'بازنشر';
    if (link.indexOf('print?sid') > 0)
        title = 'چاپ';
    var h = $(window).height();
    var w = $(window).width();

    var JS_Panel = $.jsPanel({
        contentAjax: {
            url: link,
            method: 'POST',
            dataType: 'json',
            done: function (data, textStatus, jqXHR, panel) {
                //  this.content.append(jqXHR.responseText);
                //console.log(data.content);
                panel.headerTitle(data.header);
                panel.content.html(data.content);
                panel.toolbarAdd('footer', [{item: data.footer}]);
                //panel.content.css({"width": "800px", "max-height": "550px", "height": hei, 'overflow-y': 'auto'});  ;
            }
        },
        headerControls: {
            minimize: 'disable',
            smallify: 'disable'
        },
        headerTitle: title,
        contentOverflow: {horizontal: 'hidden', vertical: 'auto'},
        panelSize: {width: w * 0.7, height: h * 0.7},
        // contentSize: {width: "800px", height: hei},
        // position: {top: h, left: w},
        // position: 'center',
        theme: 'default',
        paneltype: modal,
    });
    //JS_Panel.resize('1000px','500px');
    JS_Panel.content.html('<div class="loader"></div>');
    return false
});
//----------------------------------------


$(document).on("click", ".DeletePage", function () {
    pid = $(this).attr('pid');
    if (pid != null) {
        $.ajax({
            type: "POST",
            url: Baseurl + "DeleteRow",
            dataType: 'html',
            data: ({id: pid, page: 'delpage'}),
            success: function (theResponse) {
                jQuery.noticeAdd({
                    text: theResponse,
                    stay: false,
                    type: 'success'
                });
            }
        });
    }
});

$(document).on("click", "#TagRefBut", function () {
    jQuery('#Tagloding').hide();
    jQuery('#TagBut').show();
    jQuery('#TagRefBut').hide();
    jQuery('#KeywordFehresrt').show();
    jQuery('#KeywordSearch').hide();
});

$(document).on('click', '#TagBut', function () {
    keyword = jQuery('#Navigatekeywords').val();
    keywords_and_or = jQuery('.keywords_and_or:checked').val();
    jQuery('#Results').show();
    jQuery('#ShowResKey').show();
    $("#ShowResKey").trigger("click");
    $("#KeywordSearch").html('<div class="loader_slider"><div>');

    jQuery.ajax({
        type: "POST",
        url: Baseurl + "api/SearchTags",
        dataType: 'html',
        data: {'keywords': keyword, 'keywords_and_or': keywords_and_or},
        cache: false,
        success: function (html) {
            jQuery('#TagDet').hide();
            jQuery('#TagBut').show();
            jQuery('#TagRefBut').hide();
            jQuery('#KeywordSearch').show();
            jQuery('#KeywordSearch').html("<p></p>");
            jQuery('#KeywordSearch').html(html);
//                jQuery('#Tagloding').hide();
//             GeminiScrollbar_Results.update();


        }
    });
});

$(document).on("keypress", "#usernameTXT", function (event) {
    var englishAlphabetAndWhiteSpace = /[A-Za-z]/g;
    var key = String.fromCharCode(event.which);
    if (event.keyCode == 8 || event.keyCode == 46 || event.keyCode == 37 || event.keyCode == 39 || englishAlphabetAndWhiteSpace.test(key)) {
        return true;
    }
    return false;
});

$(document).on("paste", "#usernameTXT", function () {
    e.preventDefault();
});

$(document).on("keypress", "#usenamew", function (event) {
    var englishAlphabetAndWhiteSpace = /[A-Za-z]/g;
    var key = String.fromCharCode(event.which);
    if (event.keyCode == 8 || event.keyCode == 46 || event.keyCode == 37 || event.keyCode == 39 || englishAlphabetAndWhiteSpace.test(key)) {
        return true;
    }
    return false;
});

$(document).on("paste", "#usenamew", function () {
    e.preventDefault();
});

$(document).on("click", ".CirclePas", function () {
    var uid = $(this).attr("uid");
    var v = $(this).val();
    var incircle = $(this).attr("incircle");
    if (uid != null) {
        $.ajax({
            type: "POST",
            url: Baseurl + "AddCircle",
            dataType: 'html',
            data: ({uid: uid, circle: v, In: incircle}),
            success: function (theResponse) {
                jQuery.noticeAdd({
                    text: theResponse,
                    stay: false,
                    type: 'success'
                });
            }
        });
    }


});

$(document).on('click', 'ul.navbar-navtabs li a', function()
{
    //var all = $('.HelpIcons');
    var all = $('.HelpBookmarks, .HelpPortals, .HelpKeywords, .HelpSearch');
    all.hide();
    switch ($(this).attr('id'))
    {
        case 'tab1':
        {
            $('.HelpBookmarks').show();
            setTimeout(function()
            {
                // GeminiScrollbar_BookmarkFehresrt.update();
            }, 1500);

            $('.list-search').removeAttr('autofocus');
            $('#bookmarklist-search').attr('autofocus', 'true');
            break;
        }
        case 'tab2':
        {
            $('.list-search').removeAttr('autofocus');
            $('#portallist-search').attr('autofocus', 'true');
            $('.HelpPortals').show();
            setTimeout(function()
            {
                // GeminiScrollbar_portallistDiv.update();
            }, 1500);
            break;
        }
        case 'tab3':
        case 'tab3_1':
        case 'ShowResKey':
        {
            $('.HelpKeywords').show();
            setTimeout(function()
            {
                // GeminiScrollbar_keyWords.update();
                $("#keyWords .gm-scroll-view").animate({opacity: 1}, 1000);
            }, 1500);
            break;
        }
        case 'tab4':
        case 'page4_tab1':
        case 'page4_tab2':
        {
            $('.HelpSearch').show();
            setTimeout(function()
            {
                //$('.navbar-navtabs #tab4').click();
            }, 1000);
            break;
        }
        default:
        {
            all.hide();
        }
    }
});

$(document).on('click', 'ul.navbar-nav [href="#tab1"], ul.navbar-navtabs [href="#page1"]', function () {
    $('#BookmarkFehresrt').html
    (
        '<span class="sui-loading-back"></span>' +
        '<div class="contentDiv">' +
        '   <div class="mainDiv">' +
        '       <div class="logoDiv"></div>' +
        '       <div class="textDiv"></div>' +
        '   </div>' +
        '   <div class="loader">' +
        // '       <img src="' + Baseurl + 'img/loading.gif" />' +
        '   </div>' +
        '</div>'
    );
    $('.list-search').removeAttr('autofocus');
    $('#bookmarklist-search').attr('autofocus', 'true');
    token = $('#_Alltoken').val();
    $.ajax
    ({
        type: 'post',
        url: Baseurl + 'bookmarks',
        data: ({token: token}),
        dataType: 'html',
        success: function (response) {
            $('#BookmarkFehresrt').html(response);
        }
    });
});

$(document).on('click', '.HazfBookmark', function () {
    var id = $(this).attr('data-bookmark-id');

    confirmModal({
        title: 'حذف',
        message: 'آیا از حذف مطمئن هستید؟',
        onConfirm: function () {
            if (id != null) {
                var bookmark_id = $('#bookmark_' + id);
                var bookmark_id_parent = bookmark_id.parent();
                $.ajax
                ({
                    type: 'post',
                    url: Baseurl + 'bookmarks/delete',
                    dataType: 'html',
                    data: ({id: id}),
                    success: function (response) {
                        bookmark_id.remove();
                        if (0 == bookmark_id_parent.find('li').length) {
                            bookmark_id_parent.remove();
                            $('#' + bookmark_id_parent.attr('class')).remove()
                        }
                        jQuery.noticeAdd
                        ({
                            text: 'حذف با موفقیت انجام شد.',
                            stay: false,
                            type: 'success'
                        });
                        //$('[href=#page1]').trigger('click');
                    }
                });
            }
        },
        afterConfirm: 'close'
    });
});

$(document).on('click', 'ul.navbar-nav [href="#tab2"], ul.navbar-navtabs [href="#page2"]', function () {
    $('#PrtalFehresrt').html
    (
        '<span class="sui-loading-back"></span>' +
        '<div class="contentDiv">' +
        '   <div class="mainDiv">' +
        '       <div class="logoDiv"></div>' +
        '      <div class="textDiv"></div>' +
        '   </div>' +
        '   <div class="loader">' +
        // '       <img src="' + Baseurl + 'img/loading.gif">' +
        '   </div>' +
        '</div>'
    );
    token = $("#_Alltoken").val();
    $.ajax
    ({
        type: 'post',
        url: Baseurl + 'portals',
        data: {token: token, 'term': $('#portallist-search').val()},
        dataType: 'html',
        success: function (response) {
            $('#PrtalFehresrt').html(response);
            $('.list-search').removeAttr('autofocus');
            $('#portallist-search').attr('autofocus', 'true');
            // GeminiScrollbar_portallistDiv.update();
        }
    });
});

$(document).on('click', '.jsPanelsLive', function () {
    eval_header = $(this).attr('data-header-function')
    header = eval_header ? eval(eval_header) : $(this).attr('data-header')
    eval_content = $(this).attr('data-content-function')
    content = eval_content ? eval(eval_content) : $(this).attr('data-content')
    eval_footer = $(this).attr('data-footer-function')
    footer = eval_footer ? eval(eval_footer) : $(this).attr('data-footer')
    after = $(this).attr('data-after-function');
    var jsPanelsLive = $.jsPanel
    ({
        paneltype: 'modal',
        headerTitle: 'modal jsPanel',
        theme: 'default',
        show: 'animated fadeInDownBig',
        panelSize: {width: 800, height: 600},
        callback: function (panel) {
            $('input:first', this).focus();
            $('button', this.content).click(function () {
                panel.close()
            });
            panel.headerTitle(header);
            panel.content.html(content);
            panel.toolbarAdd('footer', footer);
        }
    });
    jsPanelsLive.fadeOut().fadeIn(1, function () {
        eval(after);
    });
    return false;
});

function _confirm_delete() {
    var c = confirm('آیا مطمئن هستید؟');
    return c;
}

$(document).ready(function () {
    $(function() {
        $('.tipsy').tipsy({fade: true, gravity: 'n'});
    });
    $('.quick-links li, .quick-links a').click(function (e) {
        e.preventDefault();
        $($(this).attr('href')).trigger('click');
        h_sidenav_open(this);
    });
});

function h_sidenav_open(thic) {
    var w = 400;
    $('.mixed-scroll').css('right','25%');
    $(".ful-scrn").css("position","absolute");
    $(".ful-scrn").css("top","5px");
    $(".ful-scrn").css("left","5px");
    if ($('.h_sidenav').width() == 0) {
        $('.h_sidenav_client').hide();
    }
    $('.h_sidenav').width(w);
    if(document.body.clientWidth > 1000){
        // $('.logo-configs').animate({'margin-left': w},800);
        $('.h_sidenav_main').css({'margin-left': w});
    }
    var t = window.setInterval(function () {
        if ($('.h_sidenav').width() >= w) {
            clearInterval(t);
            $('.h_sidenav_client').fadeIn();
        }
    }, 50);
    $('#myNavbar .quick-links-res').addClass('hidden');
    $('.subData').addClass('hidden');
    $($(thic).attr('href')).trigger('click');
}

function h_sidenav_close() {
    $('.mixed-scroll').animate({'right':'32%'},1500);
    var pos = $(".ful-scrn").offset();
    var master_inner_rtl_div = $("#toolbar").offset();
    $('.ful-scrn').css('position','absolute');
    $('.ful-scrn').css('left','5px');
    $('.ful-scrn').css('top','5px');
   $('.h_sidenav_client').fadeOut('fast', function () {
        $('.h_sidenav').width(0);
        $('.h_sidenav_main').css({'margin-left': 0});
        // $('.logo-configs').animate({'margin-left': 0},700);
   });
    var t = window.setInterval(function () {
        if ($('.h_sidenav').width() == 0) {
            clearInterval(t);
            $('#myNavbar .quick-links-res').removeClass('hidden');
            $('.subData').removeClass('hidden');
        }
    }, 50);
}

function GeminiScrollbar_make(e) {
    obj_e = $(e);
    obj_e.css({'height': $(document).height() - 240, 'overflow-x': 'hide', 'overflow-y': 'scroll'});
    // return new GeminiScrollbar({element: document.querySelector(e), autoshow: false}).create();
}

$(document).ready(function(){
    var pos = $(".ful-scrn").offset();
    var master_inner_rtl_div = $("#toolbar").offset();
    $(".ful-scrn").css("position","fixed");
    $(".ful-scrn").css("top",parseInt(master_inner_rtl_div.top)+parseInt(110));
    $(".ful-scrn").css("left",parseInt(pos.left)-5);
    $(".hd-body").scroll(function() {
        var window_height = $(window).height();
         // if (parseInt(window_height)>parseInt(2*$('#new-content').height())) {
        if ($(".hd-body").scrollTop() > 120 && parseInt(2*window_height)<parseInt($('#new-content').height())) {
            $(".navbar-custom").addClass("hidden");
            $(".dsply-tbl").css("margin-top","-40px");
            $(".hd-body").css("max-height","95vh");
            $(".row-hd").css("max-height","95vh");
            $(".row-hd").css("overflow","visible");
            $("#header").addClass("hidden");
            $(".right-detail").css("margin-right","20px");
            $("#rSubMenuBtn").css("top","-45px");
            $(".HelpIcons").css("top","-30px");
            $(".h_sidenav_help").css("top","10px");
            $(".HelpSearch").css("top","10px");
            $(".HelpBookmarks").css("top","10px");
            $(".HelpPortals").css("top","10px");
            $(".HelpKeywords").css("top","10px");
            $(".rightSubMenu").css("top","-40px");
            $("#toolbar .btn-group.mr").css("height","4px");
            $("#toolbar .btn-group").css("height","4px");
            $("#toolbar").css("height","47px");
            $(".ful-scrn").css("position","fixed");
            $(".ful-scrn").css("top","70px");
            $(".ful-scrn").css("left","40px");
            $(".scrl ").css("height","95vh");
            $("#pcol_32").css("max-height","95vh");
            if($('.h_sidenav').width()>350)
                $(".ful-scrn").css("left","410px");
            // $("#toolbar .btn-group.mr").addClass("hidden");
            // $("#toolbar .btn-group").addClass("hidden");
        } else if($(".hd-body").scrollTop() < 40){

            $(".ful-scrn").css("position","absolute");
            $(".ful-scrn").css("top","5px");
            $(".ful-scrn").css("left","5px");
            $(".icon-nim-safhe").css("top","10px");
            $(".icon-nim-safhe").css("left","20px");
            $(".navbar-custom").removeClass("hidden");
            $(".dsply-tbl").css("margin-top","0px");
            $(".hd-body").css("max-height","80vh");
            $(".row-hd").css("max-height","85vh");
            $(".right-detail").css("margin-right","0px");
            $("#rSubMenuBtn").css("top","0px");
            $(".HelpIcons").css("top","0px");
            $(".h_sidenav_help").css("top","10px");
            $(".HelpKeywords").css("top","10px");
            $(".HelpSearch").css("top","10px");
            $(".HelpBookmarks").css("top","10px");
            $(".HelpPortals").css("top","10px");
            $(".rightSubMenu").css("top","0px");
            $("#toolbar .btn-group.mr").css("height","39px");
            $("#toolbar .btn-group").css("height","39px");
            $("#toolbar").css("height","87px");
            $(".scrl").css("height","85vh");
            $("#pcol_32").css("max-height","82vh");
            $("#header").removeClass("hidden");
            var pos = $(".ful-scrn").offset();
            var master_inner_rtl_div = $("#toolbar").offset();
            // $(".ful-scrn").css("position","fixed");
            // $(".ful-scrn").css("top",parseInt(master_inner_rtl_div.top)+parseInt(110));
            // $(".ful-scrn").css("left",parseInt(pos.left)+10);
            $("#toolbar .btn-group.mr").removeClass("hidden");
            $("#toolbar .btn-group").removeClass("hidden");

        }

        if(parseInt($('#new-content').height())>200)
            $(".mixed-scroll").removeClass('hidden');
        if($(".hd-body").scrollTop() > 40)
            $('.btn-scroll.fa-chevron-up').css('visibility','inherit');
        else
            $('.btn-scroll.fa-chevron-up').css('visibility','hidden');

        if($(".hd-body").scrollTop() > (parseInt($('#new-content').height())-1000))
            $('.btn-scroll.fa-chevron-down').css('visibility','hidden');
        else
            $('.btn-scroll.fa-chevron-down').css('visibility','inherit');

        // if ($(".hd-body").scrollTop() > 80 && parseInt(2*window_height)<parseInt($('#new-content').height())) {
        //     $(".mixed-scroll").removeClass('hidden');
        // }
        // if ($(".hd-body").scrollTop() < 80 || $(".hd-body").scrollTop()>(parseInt($('#new-content').height())-1000)) {
        //     $(".mixed-scroll").addClass('hidden');
        // }
    });

});