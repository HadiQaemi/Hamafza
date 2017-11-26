@include('modals.modalheader')
<script src="{{App::make('url')->to('/')}}/theme/Scripts/magicsuggest-min.js"></script>

<style>
    .person-list li {
        background: #fff none repeat scroll 0 0;
        border: 1px solid #dbdbdb;
        box-shadow: 0 4px 7px rgba(162, 162, 162, 0.54);
        float: right;
        height: 80px;
        margin: 14px;
        padding: 0;
        position: relative;
        width: 240px;
    }
    .person-list .person-avatar {
        float: right;
        margin: 8px;
        width: 60px;
        height: 60px;
    }
</style>
<div class="row" style="height: 400px;" >
    <div class="col-md-3" style="border-left: 1px #E5E5E5 solid;height: 400px;">
        <div>
            <div id="Selected"  style="border-bottom:  1px #E5E5E5 solid;display: none;cursor: pointer" >
                <span >
                    انتخاب شده:
                </span> 
                <span id="Count" style="color: red;" >
                    0
                </span> 
            </div>
            <div id="FehresrtUC" class="v"></div>
        </div>  
    </div>
    <div class="col-md-9" style="">
        <div id="GroupsDiv"> 
        </div>
        <div id="OrgansDiv"> 
        </div>
        <div id="CiclesDiv"> 
        </div>
        <div id="SelectedDiv" style="display: none;"> 
            <ul class="person-list GroupList row" id="SelectedUsers" >

            </ul>

            <div class="col-md-4"><button class="btn btn-primary" id="InsertBut">درج</button></div>

        </div>
        <div id="SearchDiv" class="GroupList"> 
            برای جستجوی کاربر کافی است حداقل سه حرف از نام یا نام خانوادگی مورد نظررا وارد نمایید.
            <input type="text" id="SearchBoxs" class="form-control" onkeyup="SearchBoxA(this)">

            <ul class="person-list GroupList row" id="SearchedUsers" >

            </ul>
        </div>
    </div>
    <script>
           function SearchBoxA(e) {
       var strs = $(e).val();
       var n = strs.length;
       if (n > 2) {
                      $('#SearchedUsers').show();

           $('#SearchedUsers').empty();
           for (var i = 0; i < Allusers.length; i++) {
               name = Allusers[i]['Name'] + ' ' + Allusers[i]['Family'];
               if (Allusers[i]['Family'].indexOf(strs) > -1 || Allusers[i]['Name'].indexOf(strs) > -1 || name.indexOf(strs) > -1) {

                   id = Allusers[i]['id'];
                   pic = "{{App::make('url')->to('/')}}/" + Allusers[i]['Pic'];
                   sum = Allusers[i]['Summary'];
                   str = '';
                   str = str + '<li onclick="Selectuser(this)" types="{{$Type}}" id="SelUser_' + id + '" Class="selected" name="' + name + '" userid="' + id + '" userpic="' + pic + '" sum="' + sum + '"><img  src="' + pic + '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
                   str = str + '<div class="close"></div><div class="person-name">' + name + '</div><div class="person-moredetail">' + sum + '</div>';
                   str = str + '<div class="person-relation"></div></div><br><div class="person-circle grey FloatLeft" style="padding-left:10px;"></div></li>';
                   $("#SearchedUsers").append(str);
               }
           }
       }
   }
        function Selectuserx(Tid,Tname,AuCaom){
            if(AuCaom=='ms')
               ms.addToSelection({id:Tid,name:Tname},false);
            if(AuCaom=='ms2')
               ms2.addToSelection({id:Tid,name:Tname},false);
if(AuCaom=='manager')
               manager.addToSelection({id:Tid,name:Tname},false);
           if(AuCaom=='supervisor')
               supervisor.addToSelection({id:Tid,name:Tname},false);
            if(AuCaom=='supporter')
               supporter.addToSelection({id:Tid,name:Tname},false);
              
        }
        function Selectuser(e) {
        $("#Selected").show();
                type = $(e).attr("types");
                name = $(e).attr("name");
                id = $(e).attr("userid");
                pic = $(e).attr("userpic");
                sum = $(e).attr("sum");
                if (type == 'single') {
        $("#Count").html('1');
                str = '';
                $('li[userid="' + id + '"]').css("background-color", "whitesmoke");
                $('#SelectedUsers').empty();
                str = str + '<li id="SelUser_' + id + '" Class="selected" name="' + name + '" userid="' + id + '"><img  src="' + pic + '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
                str = str + '<div class="close"></div><div class="person-name">' + name + '</div><div class="person-moredetail">' + sum + '</div>';
                str = str + '<div class="person-relation"></div></div><br><div class="person-circle grey FloatLeft" style="padding-left:10px;"><span  userid="' + id + '" class="icon-bastan UnselectUser" style="color:red;cursor:pointer;" onclick="Deluser(this)"></span></div></li>';
                $("#SelectedUsers").append(str);
        }
        else {
        select = $("#Count").html();
                select = select * 1 + 1;
                $("#Count").html(select);
                $("#Selected").show();
                str = '';
                if ($('#SearchedUsers #SelUser_' + id).length) {
        $('li[userid="' + id + '"]').css("background-color", "whitesmoke");
                str = str + '<li id="SelUser_' + id + '" Class="selected" name="' + name + '" userid="' + id + '"><img  src="' + pic + '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
                str = str + '<div class="close"></div><div class="person-name">' + name + '</div><div class="person-moredetail">' + sum + '</div>';
                str = str + '<div class="person-relation"></div></div><br><div class="person-circle grey FloatLeft" style="padding-left:10px;"><span  userid="' + id + '" class="icon-bastan UnselectUser" style="color:red;cursor:pointer;" onclick="DeluserM(this)"></span></div></li>';
                $("#SelectedUsers").append(str);
        }
        }
        }

        function Deluser(e){
        id = $(e).attr("userid");
                $("#SelUser_" + id).remove();
                $("#Selected").hide();
                count = $("#Count").html();
                $("#Count").html(count - 1);
                $('li[userid="' + id + '"]').css("background-color", "white");
        }
        function DeluserM(e){
        id = $(e).attr("userid");
                $("#SelUser_" + id).remove();
                count = $("#Count").html();
                $("#Count").html(count - 1);
                $('li[userid="' + id + '"]').css("background-color", "white");
        }

        $(document).ready(function() {
                    $("#Amir").click(function(){
                         var ms = $("#magicsuggest").magicSuggest({});
               ms.addToSelection({id:1111,name:'aaaaa'});
                        
                    });
        $("#InsertBut").click(function(){
        var localRels = '';
                var localRelsName = '';
                @if(isset($_GET['auto']))
                var auto="{{$_GET['auto']}}";
            @else
                                var auto="";

               @endif
                      var data='';                          


                $('#SelectedUsers').each(function() {
        $(this).find('li').each(function(){
        localRels = localRels + ',' + $(this).attr('userid');
                localRelsName = localRelsName + ',' + $(this).attr('name');
                        data =data+"  {id:"+ $(this).attr('userid')+", name:'"+$(this).attr('name')+"'},";
                                     if(auto!=''){
Selectuserx($(this).attr('userid'),$(this).attr('name'),auto);

                                     }
        });
        });
           
//                        if(auto!='')
//                ms.setSelection('['+data+']');
                $("#{{$_GET['opener']}}").val(localRels);
                $("#{{$_GET['opener']}}").val(localRels);
                $("#{{$_GET['opener']}}_names").html(localRelsName);
                parid = $(this).parent().parent().parent().parent().parent().parent().attr('id');
                $("#" + parid + " .jsPanel-hdr .jsPanel-hdr-r .jsPanel-btn-close").trigger("click");
                console.log($("#" + parid + " .jsPanel-hdr .jsPanel-hdr-r .jsPanel-btn-close").attr('class'));
        });
        
     
        
                $("#SearchBox").keyup(function()
        {
        var strs = $(this).val();
                var n = strs.length;
                if (n > 2){
        $('#SearchedUsers').empty();
                for (var i = 0; i < Allusers.length; i++) {
        name = Allusers[i]['Name'] + ' ' + Allusers[i]['Family'];
                if (Allusers[i]['Family'].indexOf(strs) > - 1 || Allusers[i]['Name'].indexOf(strs) > - 1 || name.indexOf(strs) > - 1){

        id = Allusers[i]['id'];
                pic = "{{App::make('url')->to('/')}}/" + Allusers[i]['Pic'];
                sum = Allusers[i]['Summary'];
                str = '';
                str = str + '<li onclick="Selectuser(this)" types="{{$Type}}" id="SelUser_' + id + '" Class="selected" name="' + name + '" userid="' + id + '" userpic="' + pic + '" sum="' + sum + '"><img  src="' + pic + '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
                str = str + '<div class="close"></div><div class="person-name">' + name + '</div><div class="person-moredetail">' + sum + '</div>';
                str = str + '<div class="person-relation"></div></div><br><div class="person-circle grey FloatLeft" style="padding-left:10px;"><span  userid="' + id + '" class="icon-bastan UnselectUser" style="color:red;cursor:pointer;" onclick="Deluser(this)"></span></div></li>';
                $("#SearchedUsers").append(str);
        }
        }
        }
        });
                $("#Selected").click(function()
        {
        $(".GroupList").hide();
                $("#SelectedDiv").show();
                $("#SelectedUsers").show();
        });
                $(".single").click(function()
        {
        $("#Selected").show();
                $("#Count").html('1');
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
                str = str + '<div class="person-relation"></div></div><br><div class="person-circle grey FloatLeft" style="padding-left:10px;"><span  userid="' + id + '" class="icon-bastan UnselectUser" style="color:red;cursor:pointer;" onclick="Deluser(this)"></span></div></li>';
                $("#SelectedUsers").append(str);
        });
                $(".multi").click(function()
        {
        id = $(this).attr("userid");
                if ($('#SelectedUsers #SelUser_' + id).length == 0) {
        select = $("#Count").html();
                select = select * 1 + 1;
                $("#Count").html(select);
                $("#Selected").show();
                name = $(this).attr("name");
                pic = $(this).attr("userpic");
                sum = $(this).attr("sum");
                str = '';
                $(this).css("background-color", "whitesmoke");
                $('li[userid="' + id + '"]').css("background-color", "whitesmoke");
                str = str + '<li id="SelUser_' + id + '" Class="selected" name="' + name + '" userid="' + id + '"><img  src="' + pic + '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
                str = str + '<div class="close"></div><div class="person-name">' + name + '</div><div class="person-moredetail">' + sum + '</div>';
                str = str + '<div class="person-relation"></div></div><br><div class="person-circle grey FloatLeft" style="padding-left:10px;"><span  userid="' + id + '" class="icon-bastan UnselectUser" style="color:red;cursor:pointer;" onclick="DeluserM(this)"></span></div></li>';
                $("#SelectedUsers").append(str);
        }
        });
        });
                var Groups = {{$Groups}};
                var Organs = {{$Organs}};
                var Cicles = {{$Circles}};
                var Allusers = {{$Allusers}};
                for (var i = 0; i < Groups.length; i++) {
        str = "<ul class='person-list GroupList row' id='GroupDivs_" + Groups[i]['id'] + "' style='display:none;'>";
                members = Groups[i]['members'];
                for (var j = 0; j < members.length; j++) {

        str = str + '<li class="{{$Type}}" sum="' + members[j]['Summary'] + '" name="' + members[j]['Name'] + ' ' + members[j]['Family'] + '" userid="' + members[j]['id'] + '"  userpic="' + "{{App::make('url')->to('/')}}" + '/' + members[j]['Pic'] + '"><img id="GM_' + members[j]['id'] + '" src="' + "{{App::make('url')->to('/')}}" + '/' + members[j]['Pic'] + '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
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

        str = str + '<li class="{{$Type}}" sum="' + members[j]['Summary'] + '" name="' + members[j]['Name'] + ' ' + members[j]['Family'] + '" userid="' + members[j]['id'] + '"  userpic="' + "{{App::make('url')->to('/')}}" + ' / ' + members[j]['Pic'] + '"><img id="OM_' + members[j]['id'] + '" src="' + "{{App::make('url')->to('/')}}" + '/' + members[j]['Pic'] + '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
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

        str = str + '<li class="{{$Type}}"  sum="' + members[j]['Summary'] + '" name="' + members[j]['Name'] + ' ' + members[j]['Family'] + '" userid="' + members[j]['id'] + '" userpic="' + "{{App::make('url')->to(' / ')}}" + ' / ' + members[j]['Pic'] + '"><img id="OM_' + members[j]['id'] + '" src="' + "{{App::make('url')->to('/')}}" + '/' + members[j]['Pic'] + '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
                str = str + '<div class="close"></div><div class="person-name">' + members[j]['Name'] + ' ' + members[j]['Family'] + '</div><div class="person-moredetail">' + members[j]['Summary'] + '</div>';
                str = str + '<div class="person-relation"></div></div></li>';
        }

        str = str + '</ul>'
                old = $("#CiclesDiv").html();
                $("#CiclesDiv").html(old + str);
        }


        function showgroup(id){
        $("#SelectedDiv").hide();
                $(".GroupList").hide();
                $(id).show();
        }
        $(function () {
        $("#FehresrtUC").jstree({
        "plugins" : [ "search" ]
        });
                var to = false;
                $('#list-search').keyup(function () {
        if (to) { clearTimeout(to); }
        to = setTimeout(function () {
        var v = $('#list-search').val();
                $('#FehresrtUC').jstree(true).search(v);
        }, 250);
        });
        });
                $('#FehresrtUC').jstree({
        "plugins" : [ "search" ],
                'core': {
                'data': [
                {{$Tree}}
                ],
                        'rtl': true,
                        "themes": {
                        "icons": false
                        }
                }
        });
                $("#FehresrtUC").bind('select_node.jstree',
                function (e, data)
                {
                var Strings = data.node.id;
                        if (Strings == '0'){
                $(".GroupList").hide();
                        $("#SearchDiv").show();
                }
                g = Strings.lastIndexOf('Group');
                        if (g > - 1){
                id = Strings.replace("Group_", "");
                        for (var i = 0; i < Groups.length; i++) {
                if (Groups[i]['id'] == id){
                members = Groups[i]['members'];
                        showgroup("#GroupDivs_" + id);
                }

                }
                }
                g = Strings.lastIndexOf('Organs');
                        if (g > - 1){
                id = Strings.replace("Organs_", "");
                        for (var i = 0; i < Organs.length; i++) {
                if (Organs[i]['id'] == id){
                members = Organs[i]['members'];
                        showgroup("#OrganDivs_" + id);
                }
                }
                }

                g = Strings.lastIndexOf('Circle');
                        if (g > - 1){
                id = Strings.replace("Circle_", "");
                        for (var i = 0; i < Cicles.length; i++) {
                if (Cicles[i]['id'] == id){
                members = Cicles[i]['members'];
                        showgroup("#CircleDivs_" + id);
                }
                }
                }
                });



    </script>
    
  
</div>