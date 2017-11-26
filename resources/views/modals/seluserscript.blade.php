<script type="application/javascript">
function InsertBu(e) {
    var localRels = '';
    var localRelsName = '';
    @if(isset($_GET['auto']))
    var auto = "{!!$_GET['auto']!!}"
    @endif
    var data = '';
    $('#SelectedUsers').each(function() {
        $(this).find('li').each(function() {
            localRels = localRels + ',' + $(this).attr('userid');
            localRelsName = localRelsName + ',' + $(this).attr('name');
            data = data + "  {id:" + $(this).attr('userid') + ", name:'" + $(this).attr('name') + "'},";
            if (auto != '') {
                Selectuserx($(this).attr('userid'), $(this).attr('name'), auto);
            }
        });
    });
    //                        if(auto!='')
    //                ms.setSelection('['+data+']');
    $("#{!!$_GET['opener']!!}").val(localRels);
    $("#{!!$_GET['opener']!!}").val(localRels);
    $("#{!!$_GET['opener']!!}_names").html(localRelsName);
    parid = $(this).parent().parent().parent().parent().parent().parent().attr('id');
    $("#" + parid + " .jsPanel-hdr .jsPanel-hdr-r .jsPanel-btn-close").trigger("click");
    console.log($("#" + parid + " .jsPanel-hdr .jsPanel-hdr-r .jsPanel-btn-close").attr('class'));

}

function ValChang(e) {
//    alert('sss');
    if ($(e).val() > 0)
        $("#InsertBut").hide();
}

function Selectuserx(Tid, Tname, AuCaom) {
    if (AuCaom == 'ms')
        ms.addToSelection({
            id: Tid,
            name: Tname
        }, false);
    if (AuCaom == 'ms2')
        ms2.addToSelection({
            id: Tid,
            name: Tname
        }, false);
    if (AuCaom == 'manager')
        manager.addToSelection({
            id: Tid,
            name: Tname
        }, false);
    if (AuCaom == 'supervisor')
        supervisor.addToSelection({
            id: Tid,
            name: Tname
        }, false);
    if (AuCaom == 'supporter')
        supporter.addToSelection({
            id: Tid,
            name: Tname
        }, false);
}

function Selectuser(e) {
    id = $(e).attr("userid");
    if ($('#SelectedUsers #SelUser_' + id).length == 0) {
        $("#Selected").show();
        type = $(e).attr("types");
        name = $(e).attr("name");
        id = $(e).attr("userid");
        pic = $(e).attr("userpic");
        sum = $(e).attr("sum");
        if (type == 'single') {
            $("#Count").html('1');
            $("#InsertBut").prop("disabled", false);
            str = '';
            $('li[userid="' + id + '"]').css("background-color", "#e5e5e5");
            $('#SelectedUsers').empty();
            str = str + '<li id="SelUser_' + id + '" Class="selected" name="' + name + '" userid="' + id + '"><img  src="' + pic + '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
            str = str + '<div class="close"></div><div class="person-name">' + name + '</div><div class="person-moredetail">' + sum + '</div>';
            str = str + '<div class="person-relation"></div></div><br><div class="person-circle grey FloatLeft" style="padding-left:10px;"><span  userid="' + id + '" class="icon-bastan UnselectUser" style="color: red;cursor: pointer;top: -50px;margin-bottom: -60px;display: inline-flex;" onclick="Deluser(this)"></span></div></li>';
            $("#SelectedUsers").append(str);
        } else {
            select = $("#Count").html();
            select = select * 1 + 1;
            $("#Count").html(select);
            $("#InsertBut").prop("disabled", false);
            $("#Selected").show();
            str = '';
            if ($('#SelUser_' + id).length) {
                $('li[userid="' + id + '"]').css("background-color", "whitesmoke");
                str = str + '<li id="SelUser_' + id + '" Class="selected" name="' + name + '" userid="' + id + '"><img  src="' + pic + '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
                str = str + '<div class="close"></div><div class="person-name">' + name + '</div><div class="person-moredetail">' + sum + '</div>';
                str = str + '<div class="person-relation"></div></div><br><div class="person-circle grey FloatLeft" style="padding-left:10px;" onclick="DeluserM(this)"  userid="' + id + '"><span  userid="' + id + '" class="icon-bastan UnselectUser" style="color: red;cursor: pointer;top: -50px;margin-bottom: -60px;display: inline-flex;"></span></div></li>';
                $("#SelectedUsers").append(str);
            }

        }
    }
}

function Deluser(e) {
    id = $(e).attr("userid");
    $("#SelUser_" + id).remove();
    $("#Selected").hide();
    count = $("#Count").html();
    $("#Count").html(count - 1);
    count--;
    if (count == 0)
        $("#InsertBut").prop("disabled", true);
    $('li[userid="' + id + '"]').css("color", "#000");

    $('li[userid="' + id + '"]').css("background-color", "white");
}

function DeluserM(e) {
    id = $(e).attr("userid");
    $("#SelUser_" + id).remove();
    count = $("#Count").html();
    if (count >= 2)
        $("#Count").html(count - 1);
    else
        $("#Count").html('0');
    $('li[userid="' + id + '"]').css("background-color", "white");
    $('li[userid="' + id + '"]').css("color", "#000");


}

$(document).ready(function() {
    $("#Amir").click(function() {
        var ms = $("#magicsuggest").magicSuggest({});
        ms.addToSelection({
            id: 1111,
            name: 'aaaaa'
        });
    });
    $("#InsertBut").click(function() {
        var localRels = '';
        var localRelsName = '';
        @if(isset($_GET['auto']))
        var auto = "{!!$_GET['auto']!!}"
        @endif
        var data = '';
        $('#SelectedUsers').each(function() {
            $(this).find('li').each(function() {
                localRels = localRels + ',' + $(this).attr('userid');
                localRelsName = localRelsName + ',' + $(this).attr('name');
                data = data + "  {id:" + $(this).attr('userid') + ", name:'" + $(this).attr('name') + "'},";
                if (auto != '') {
                    Selectuserx($(this).attr('userid'), $(this).attr('name'), auto);
                }
            });
        });
        //                        if(auto!='')
        //                ms.setSelection('['+data+']');
        $("#{!!$_GET['opener']!!}").val(localRels);
        $("#{!!$_GET['opener']!!}").val(localRels);
        $("#{!!$_GET['opener']!!}_names").html(localRelsName);
        parid = $(this).parent().parent().parent().attr('id');
        $("#" + parid + " .jsPanel-btn-close").trigger("click");
        console.log(parid);
        //console.log($("#" + parid + " .jsPanel-hdr .jsPanel-hdr-r .jsPanel-btn-close").attr('class'));
    });
    $("#SearchBox").keyup(function() {
        var strs = $(this).val();
        var n = strs.length;
        if (n > 2) {
            $('#SearchedUsers').empty();
            for (var i = 0; i < Allusers.length; i++) {
                name = Allusers[i]['Name'] + ' ' + Allusers[i]['Family'];
                if (Allusers[i]['Family'].indexOf(strs) > -1 || Allusers[i]['Name'].indexOf(strs) > -1 || name.indexOf(strs) > -1) {
                    id = Allusers[i]['id'];
                    pic = "{!!App::make('url')->to('/')!!}/" + Allusers[i]['Pic'];
                    sum = Allusers[i]['Summary'];
                    str = '';
                    str = str + '<li onclick="Selectuser(this)" types="{!!$Type!!}" id="SelUser_' + id + '" Class="selected" name="' + name + '" userid="' + id + '" userpic="' + pic + '" sum="' + sum + '"><img  src="' + pic + '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
                    str = str + '<div class="close"></div><div class="person-name">' + name + '</div><div class="person-moredetail">' + sum + '</div>';
                    str = str + '<div class="person-relation"></div></div><br><div class="" style="padding-left:10px;"></div></li>';
                    $("#SearchedUsers").append(str);
                }
            }
        }
    });
    $("#Selected").click(function() {
        $(".GroupList").hide();
        $("#SelectedDiv").show();
        $("#SelectedUsers").show();
    });
    $(".single").click(function() {
        $("#Selected").show();
        $("#Count").html('1');
        $("#InsertBut").prop("disabled", false);
        $(this).css("background-color", "whitesmoke");
        name = $(this).attr("name");
        id = $(this).attr("userid");
        pic = $(this).attr("userpic");
        sum = $(this).attr("sum");
        str = '';
        $('li[userid="' + id + '"]').css("background-color", "whitesmoke");
        $('#SelectedUsers').empty();
        str = str + '<li id="SelUser_' + id + '" Class="selected" name="' + name + '" userid="' + id + '"><img  src="' + pic + '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
        str = str + '<div class="close"></div><div class="person-name">' + name + '</div><div class="person-moredetail">' + sum + '</div>';
        str = str + '<div class="person-relation"></div></div><br><div class="" style="padding-left:10px;"><span  userid="' + id + '" class="icon-bastan UnselectUser" style="color:red;cursor:pointer;" onclick="Deluser(this)"></span></div></li>';
        $("#SelectedUsers").append(str);
    });
    $(".multi").click(function() {
        id = $(this).attr("userid");
        if ($('#SelectedUsers #SelUser_' + id).length == 0) {
            select = $("#Count").html();
            select = select * 1 + 1;
            $("#InsertBut").prop("disabled", false);
            $("#Count").html(select);
            $("#Selected").show();
            name = $(this).attr("name");
            pic = $(this).attr("userpic");
            sum = $(this).attr("sum");
            str = '';
            $(this).css("background-color", "#e5e5e5");
            $(this).css("color", "white");

            $('li[userid="' + id + '"]').css("background-color", "#e5e5e5");
            str = str + '<li id="SelUser_' + id + '" Class="selected" name="' + name + '" userid="' + id + '"><img  src="' + pic + '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
            str = str + '<div class="close"></div><div class="person-name">' + name + '</div><div class="person-moredetail">' + sum + '</div>';
            str = str + '<div class="person-relation"></div></div><br><div class="person-circle grey FloatLeft" style="padding-left:10px;" onclick="DeluserM(this)"  userid="' + id + '"><span  userid="' + id + '" class="icon-bastan UnselectUser" style="color: red;cursor: pointer;top: -50px;margin-bottom: -60px;display: inline-flex;"></span></div></li>';
            $("#SelectedUsers").append(str);
        }
    });
});
var Groups = {!!$Groups!!};
var Organs = {!!$Organs!!};
var Cicles = {!!$Circles!!};
var Allusers = {!!$Allusers!!};
for (var i = 0; i < Groups.length; i++) {
    str = "<ul class='person-list GroupList row' id='GroupDivs_" + Groups[i]['id'] + "' style='display:none;'>";
    members = Groups[i]['members'];
    for (var j = 0; j < members.length; j++) {

        str = str + '<li class="{!!$Type!!}" sum="' + members[j]['Summary'] + '" name="' + members[j]['Name'] + ' ' + members[j]['Family'] + '" userid="' + members[j]['id'] + '"  userpic="' + "{!!App::make('url')->to('/')!!}" + '/' + members[j]['Pic'] + '"><img id="GM_' + members[j]['id'] + '" src="' + "{!!App::make('url')->to('/')!!}" + '/' + members[j]['Pic'] + '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
        str = str + '<div class="close"></div><div class="person-name">' + members[j]['Name'] + ' ' + members[j]['Family'] + '</div><div class="person-moredetail">' + members[j]['Summary'] + '</div>';
        str = str + '<div class="person-relation"></div></div></li>';
    }


    str = str + '</ul>'
    old = $("#GroupsDiv").html();
    $("#GroupsDiv").html(old + str);
}

for (var i = 0; i < Organs.length; i++) {
    str = "<ul class='person-list GroupList row' id='OrganDivs_" + Organs[i]['id'] + "' style='display:none;'>";
    members = Organs[i]['members'];
    for (var j = 0; j < members.length; j++) {

        str = str + '<li class="{!!$Type!!}" sum="' + members[j]['Summary'] + '" name="' + members[j]['Name'] + ' ' + members[j]['Family'] + '" userid="' + members[j]['id'] + '"  userpic="' + "{!!App::make('url')->to('/')!!}" + ' / ' + members[j]['Pic'] + '"><img id="OM_' + members[j]['id'] + '" src="' + "{!!App::make('url')->to('/')!!}" + '/' + members[j]['Pic'] + '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
        str = str + '<div class="close"></div><div class="person-name">' + members[j]['Name'] + ' ' + members[j]['Family'] + '</div><div class="person-moredetail">' + members[j]['Summary'] + '</div>';
        str = str + '<div class="person-relation"></div></div></li>';
    }

    str = str + '</ul>'
    old = $("#OrgansDiv").html();
    $("#OrgansDiv").html(old + str);
}


for (var i = 0; i < Cicles.length; i++) {
    str = "<ul class='person-list GroupList row' id='CircleDivs_" + Cicles[i]['id'] + "' style='display:none;'>";
    members = Cicles[i]['members'];
    for (var j = 0; j < members.length; j++) {

        str = str + '<li class="{!!$Type!!}"  sum="' + members[j]['Summary'] + '" name="' + members[j]['Name'] + ' ' + members[j]['Family'] + '" userid="' + members[j]['id'] + '" userpic="' + "{!!App::make('url')->to(' / ')!!}" + ' / ' + members[j]['Pic'] + '"><img id="OM_' + members[j]['id'] + '" src="' + "{!!App::make('url')->to('/')!!}" + '/' + members[j]['Pic'] + '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
        str = str + '<div class="close"></div><div class="person-name">' + members[j]['Name'] + ' ' + members[j]['Family'] + '</div><div class="person-moredetail">' + members[j]['Summary'] + '</div>';
        str = str + '<div class="person-relation"></div></div></li>';
    }

    str = str + '</ul>'
    old = $("#CiclesDiv").html();
    $("#CiclesDiv").html(old + str);
}


function showgroup(id) {
    $("#SelectedDiv").hide();
    $(".GroupList").hide();
    $(id).show();
}
$(function() {
    $("#FehresrtUC").jstree({
        "plugins": ["search"]
    });
    var to = false;
    $('#list-search').keyup(function() {
        if (to) {
            clearTimeout(to);
        }
        to = setTimeout(function() {
            var v = $('#list-search').val();
            $('#FehresrtUC').jstree(true).search(v);
        }, 250);
    });
});
$('#FehresrtUC').jstree({
    "plugins": ["search"],
    'core': {
        'data': [{!!$Tree!!}],
        'rtl': true,
        "themes": {
            "icons": false
        }
    }
});
$("#FehresrtUC").bind('select_node.jstree',
    function(e, data) {
        var Strings = data.node.id;
        if (Strings == '0') {
            $(".GroupList").hide();
            $("#SearchDiv").show();
        }
        g = Strings.lastIndexOf('Group');
        if (g > -1) {
            id = Strings.replace("Group_", "");
            for (var i = 0; i < Groups.length; i++) {
                if (Groups[i]['id'] == id) {
                    members = Groups[i]['members'];
                    showgroup("#GroupDivs_" + id);
                }
            }
        }
        g = Strings.lastIndexOf('Organs');
        if (g > -1) {
            id = Strings.replace("Organs_", "");
            for (var i = 0; i < Organs.length; i++) {
                if (Organs[i]['id'] == id) {
                    members = Organs[i]['members'];
                    showgroup("#OrganDivs_" + id);
                }
            }
        }
        g = Strings.lastIndexOf('Circle');
        if (g > -1) {
            id = Strings.replace("Circle_", "");
            for (var i = 0; i < Cicles.length; i++) {
                if (Cicles[i]['id'] == id) {
                    members = Cicles[i]['members'];
                    showgroup("#CircleDivs_" + id);
                }
            }
        }
    });
</script>