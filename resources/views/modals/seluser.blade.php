{{--@include('modals.modalheader')--}}
{{--<script src="{{App::make('url')->to('/')}}/theme/Scripts/magicsuggest-min.js"></script>--}}
@include('modals.seluserscript')
<style>
    #SelectedDiv #SelectedUsers {
        height: 370px;
        /*overflow: auto;*/
    }
    .person-circle {
        background: #fff !important;
        border: 1px solid #fff !important;
    }
    .person-list li {
        background: #fff none repeat scroll 0 0;
        border: 1px solid #dbdbdb;
        box-shadow: 0 4px 7px rgba(162, 162, 162, 0.54);
        float: right;
        height: 100px !important;
        margin: 5px !important;
        padding: 0;
        position: relative;
        width: 48% !important;
    }
    .person-list li .person-detail {
        padding: 13px 10px 0px 5px !important;
    }

    .person-list .person-avatar {
        float: right;
        margin: 0px !important;
        width: 100px !important;
        height: 100px !important;
        border-radius: 0 !important;
    }
    .col-md-9 .person-list .person-moredetail {
        font-size: 11px;
        line-height: 17px;
        height: 55px;
        overflow: auto;
    }
    #SelectedDiv {
        position: relative;
        height: 400px;
    }
    #InsertBut {
        height: 30px
    }
</style>
<div class="row" style="height: 430px;overflow-y: auto;overflow-x: hidden;">
    <div class="col-md-3" style="border-left: 1px #E5E5E5 solid;height: 400px;">
        <div>
            <div id="Selected" style="border-bottom:  1px #E5E5E5 solid;display: none;cursor: pointer;text-align:center">
                <span style='color:blue;'>
                    انتخاب شده:
                </span>
                <span id="Count" style="color: red;" onchange="/*ValChang(this);*/">
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
        <div id="SearchDiv" class="GroupList">
            سه حرف از نام یا نام خانوادگی را وارد نمایید.
            <input type="text" id="Search_Box" class="form-control" onkeyup="send_user(this,event)">

            <ul class="person-list GroupList row" id="SearchedUsers">

            </ul>
        </div>
        <div id="SelectedDiv" style="display: none;">
            <ul class="person-list GroupList row" id="SelectedUsers_div"></ul>
        </div>
    </div>
</div>
<script>

    function send_user(e, event) {
        var strs = $(e).val();
        var n = strs.length;
        if (n > 2) {
            $('#SearchedUsers').empty();
            var mytimeout;
            clearTimeout(mytimeout);
            mytimeout=setTimeout($.post('{!! route('search_list_user') !!}', {'term': strs}, function (data) {
                $("#SearchedUsers").html(data);
                $("#SearchedUsers").show();
                $('#SelectedUsers_div').empty();
            }), 5000);

        }

    }
    function Select_users(e) {

        var family = $(e).attr("data_family");
        var name = $(e).attr("data_name");
        var user_id = $(e).attr("data_id");
        if ($('#SelUser_' + user_id).length > 0) {
            $('li[data_id="' + user_id + '"]').css("background-color", "#ffffff");
            document.getElementById('SelUser_' + user_id).remove();
        }
        else
        {
            $('li[data_id="' + user_id + '"]').css("background-color", "#cdcdcd");
        str = '';
        $('li[userid="' + user_id + '"]').css("background-color", "whitesmoke");
        str = str + '<li id="SelUser_' + user_id + '" Class="selected" family="'+family+'" name="'+ name +'" family="'+ family +'" userid="' + user_id + '"><div class="person-detail">';
        $("#SelectedUsers_div").append(str);
        }
    }
$(document).ready(function(){

    $("#InsertBtn_user").click(function () {
        var localRels = '';
        var localRelsName = '';
        $('#SelectedUsers_div').find('li').each(function() {
            $('#select_user').append('<option selected="selected" value='+$(this).attr('userid')+'>'+$(this).attr('name')+' '+$(this).attr('family')+'</option>').change();
            //$("#select_user").addSelect2Items([{id: $(this).attr('userid'), text: $(this).attr('name')}]);
           // $("#select_user").append('<option value='+$(this).attr('userid')+'>'+$(this).attr('name')+'<option>');
           // $(".select2-selection__rendered").append('select2-selection__choice');
            //$(this).find('li').each(function(){
                //localRels = localRels + ',' + $(this).attr('user_id');
               // localRelsName = localRelsName + ',' + $(this).attr('name');

               // data =data+"{id:"+ $(this).attr('user_id')+", name:'"+$(this).attr('name')+"'},";
               /* if(auto!=''){
                    Selectuserx($(this).attr('user_id'),$(this).attr('name'),auto);

                }*/
            //});
        });
    });
});

        {{-- function CommentSend(e, event) {


         {{--  $('#SearchedUsers').empty();
        for (var i = 0; i < Allusers.length; i++) {
            name = Allusers[i]['Name'] + ' ' + Allusers[i]['Family'];
            if (Allusers[i]['Family'].indexOf(strs) > -1 || Allusers[i]['Name'].indexOf(strs) > -1 || name.indexOf(strs) > -1) {
                id = Allusers[i]['id'];
                pic = "{{App::make('url')->to('/')}}/" + Allusers[i]['Pic'];
                sum = Allusers[i]['Summary'];
                str = '';
                str = str + '<li onclick="Selectuser(this);" types="{{$Type}}" id="SelUser_' + id + '" Class="selected" name="' + name + '" userid="' + id + '" userpic="' + pic + '" sum="' + sum + '"><img  src="' + pic + '" class="person-avatar mCS_img_loaded"><div class="person-detail">';
                str = str + '<div class="close"></div><div class="person-name">' + name + '</div><div class="person-moredetail">' + sum + '</div>';
                str = str + '<div class="person-relation"></div></div><br><div class="" style="padding-left:10px;"><span  userid="' + id + '" class="icon-bastan UnselectUser" style="color:red;cursor:pointer;" onclick="Deluser(this)"></span></div></li>';
                $("#SearchedUsers").append(str);
                $("#SearchedUsers").show();
            }
        }--}}
    //}

</script>
<div class="col-md-12" style="height: 100px; border-top: 1px solid #e5e5e5;height: 14px;padding-top: 5px;position: static;">
    <button class="btn btn-primary FloatLeft"  id="InsertBtn_user">درج</button>
</div>
