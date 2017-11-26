$(document).ready(function()
{

    $(".editUWDiv").hide();

    $(".Province").empty();
    $(".Province").append($("<option></option>").val('0').html('انتخاب کنید'));

    $.each(provdata, function() {
        $(".Province").append($("<option></option>").val(this['id']).html(this['province']));
    });



    $(".Province").change(function() {
        pid = $(this).val();
        $(".City").empty();
        for (var i in provdata)
        {
            var id = provdata[i].id;
            if (pid == id) {
                shahrs = provdata[i].shahr;
                for (var j in shahrs)
                {
                    $(".City").append($("<option></option>").val(shahrs[j].id).html(shahrs[j].city));
                }
            }
        }
    });


    $(".EditUE").click(function() {
        $(".editDiv").hide();
        target = $(this).attr("val");
        $('#' + target).show();
        targetid = $(this).attr("targetid");
        $('#location_UE_' + targetid).focus();

    });

    $(".EditUW").click(function() {
        $(".editDiv").hide();
        target = $(this).attr("val");
        $('#' + target).show();
        targetid = $(this).attr("targetid");
        $('#EditUW_title_' + targetid).focus();

    });

    $(".closeBut").click(function() {
        $(this).closest('.editDiv').hide();
    });

    $(".EditUP").click(function() {
        $(".editDiv").hide();
        target = $(this).attr("val");
        $('#' + target).show();
        targetid = $(this).attr("targetid");
        $('#EditUP_title_' + targetid).focus();

    });
    $(".closeBut").click(function() {
        $(this).closest('.editDiv').hide();
    });


    $(".iconDelW").click(function() {
        id = $(this).attr('val');
        title = 'DelDelHDelDel';
        comment = 'DelDelHDelDel';
        if (title == '')
            alert('عنوان خالی است')
        else {
            $.ajax({
                type: "POST",
                url: Baseurl + "EditUW",
                dataType: 'html',
                data: ({id: id, title: title, comment: comment}),
                success: function(theResponse) {
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                    location.reload();
                }
            });
        }
    });
    
    $(".iconDelE").click(function() {
        id = $(this).attr('val');
        title = 'DelDelHDelDel';
        comment = 'DelDelHDelDel';
        if (title == '')
            alert('عنوان خالی است')
        else {
            $.ajax({
                type: "POST",
                url: Baseurl + "EditUE",
                dataType: 'html',
                data: ({id: id, title: title, comment: comment}),
                success: function(theResponse) {
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                  //  location.reload();
                }
            });
        }
    });

    $(".EditUDetails").click(function() {
        $("#EditUDetail").show();
    });


    $(".EditUDetail").click(function() {
        user_name = $("#user_name").val();
        user_family = $("#user_family").val();
        user_summary = $("#user_summary").val();
        comment = $("#comment").val();
       user_gender= $('input[name=user_gender]:checked').val()
        EditUdetdate = $("#EditUdet").val();
        Province = $("#ProvinceUdet").val();
        City = $("#CityUdet").val();
                user_mobile = $("#user_mobile").val();

        tel_code = $("#tel_code").val();
        tel_number = $("#tel_number").val();
        fax_code = $("#fax_code").val();
        fax_number = $("#fax_number").val();
        user_website = $("#user_website").val();
        user_mail = $("#user_mail").val();

        if (user_name == '')
            alert('عنوان خالی است')
        else {
            $.ajax({
                type: "POST",
                url: Baseurl + "EditUDetail",
                dataType: 'html',
                data: ({user_mobile:user_mobile,user_name: user_name, user_family: user_family, user_summary: user_summary, comment: comment
                    , user_gender: user_gender, EditUdetdate: EditUdetdate, Province: Province, City: City
                    , tel_code: tel_code, tel_number: tel_number, fax_code: fax_code, fax_number: fax_number
                    , user_website: user_website, user_mail: user_mail
                }),
                success: function(theResponse) {
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                  //  location.reload();
                }
            });
            
            $(".closeBut").trigger("click");
        }
    });

    $(".iconEditUP").click(function() {
        id = $(this).attr('val');
        title = 'DelDelHDelDel';
        comment = 'DelDelHDelDel';
        if (title == '')
            alert('عنوان خالی است')
        else {
            $.ajax({
                type: "POST",
                url: Baseurl + "EditUP",
                dataType: 'html',
                data: ({id: id, title: title, comment: comment}),
                success: function(theResponse) {
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                    location.reload();
                }
            });
        }
    });


    $(".EditUEOK").click(function() {
        id = $(this).attr('editid');
        locationTXT = "University_UE_" + id;
        locations = $("#" + locationTXT).val();
        trendTXT = "trend_UE_" + id;
        trend = $("#" + trendTXT).val();
        levelTXT = "level_UE_" + id;
        level = $("#" + levelTXT).val();
        UniversityTXT = "University_UE_" + id;
        University = $("#" + UniversityTXT).val();
        ProvinceTXT = "ProvinceUE_" + id;
        Province = $("#" + ProvinceTXT).val();
        CityTXT = "CityUE_" + id;
        City = $("#" + CityTXT).val();
        commentTXT = "comment_UE_" + id;
        comment = $("#" + commentTXT).val();
        sdateTXT = "EditUE_sdate_" + id;
        sdate = $("#" + sdateTXT).val();
        edateTXT = "EditUE_edate_" + id;
        edate = $("#" + edateTXT).val();
        if (locations == '')
            alert('عنوان خالی است')
        else {
            $.ajax({
                type: "POST",
                url: Baseurl + "EditUE",
                dataType: 'html',
                data: ({id: id, locations: locations, comment: comment, trend: trend, level: level, Province: Province, City: City, sdate: sdate, edate: edate, University: University}),
                success: function(theResponse) {
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                    location.reload();
                }
            });
        }
    });
    $(".EditUWOK").click(function() {
        id = $(this).attr('editid');
        titleTXT = "EditUW_title_" + id;
        title = $("#" + titleTXT).val();
        commentTXT = "EditUW_comment_" + id;
        comment = $("#" + commentTXT).val();
        companyTXT = "EditUW_company_" + id;
        company = $("#" + companyTXT).val();
        vahedTXT = "EditUW_org_vahed_" + id;
        vahed = $("#" + vahedTXT).val();
        ProvinceTXT = "ProvinceUW_" + id;
        Province = $("#" + ProvinceTXT).val();
        CityTXT = "CityUW_" + id;
        City = $("#" + CityTXT).val();
        sdateTXT = "EditUW_sdate_" + id;
        sdate = $("#" + sdateTXT).val();
        edateTXT = "EditUW_edate_" + id;
        edate = $("#" + edateTXT).val();

        if (title == '')
            alert('عنوان خالی است')
        else {
            $.ajax({
                type: "POST",
                url: Baseurl + "EditUW",
                dataType: 'html',
                data: ({id: id, title: title, comment: comment, company: company, vahed: vahed, Province: Province, City: City, sdate: sdate, edate: edate}),
                success: function(theResponse) {
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                    location.reload();
                }
            });
        }
    });
    $(".EditUPOK").click(function() {
        id = $(this).attr('editid');
        titleTXT = "EditUP_title_" + id;
        title = $("#" + titleTXT).val();
        commentTXT = "EditUP_comment_" + id;
        comment = $("#" + commentTXT).val();
         vals =JSON.stringify(user_specials.getSelection());
         var token =$("#_Alltoken").val();
        if (title == '')
            alert('عنوان خالی است')
        else {
            $.ajax({
                type: "POST",
                url: Baseurl + "EditUP",
                dataType: 'html',
                data: ({UPvals:vals,id: id, title: title, comment: comment,token:token}),
                success: function(theResponse) {
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                    location.reload();
                }
            });
        }
    });

});