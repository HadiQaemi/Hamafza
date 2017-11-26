<script>
    function AddNode(parentid, parentText)
    {
        $("#parent_id").val(parentid);
        $("#nodeprename").html("اضافه کردن به: " + parentText);
    }
    function EditNode(parentid, parentText)
    {
        $("#nodeprename").html("ویرایش: " + parentText);
        if (parentid != '') {
            $.ajax({
                type: "POST",
                url: '{{ route('hamafza.get_poodman_node') }}',
                dataType: 'html',
                data: ({id: parentid}),
                success: function(theResponse) {
                    var obj = JSON.parse(theResponse);
                    var Node = obj['Node'];
                    $("#Title_Text").val(Node['name']);
                    $("#Selected_subject").tokenInput("clear");
                    if (Node['pid'] !='0') {
                        var title = Node['title'];
                        $("#Selected_subject").tokenInput("add", {id:Node['Subjectid'], name:title});
                        $('.token-input-token').trigger("click");
                    }
                    $(':radio').removeAttr('checked');
                    $("#Addpanel").show();
                    $("#Addtype").val("edit");
                    descr = Node['descr'];
                    showtype = Node['showtype'];
                    if (descr !== '')
                        $("#tozihshow").show();
                    $("#Matn_Text").val(descr);
                    $("#ptree_id").val(parentid);
                    prenumselect = Node['prenumselect'];
                    prenum = Node['prenum'];
                    if (prenumselect == '1') {
                        $('#PishShomare_select').prop('checked', true);
                        $('#PishShomare').val(prenum);
                        $("#PishShomare").removeAttr("disabled");
                    } else {
                        $('#PishShomare_select').prop('checked', false);
                        $("#PishShomare").val("");
                        $("#PishShomare").attr("disabled", "disabled");
                    }


                    switch (showtype) {
                        case "0":
                            $('#matnpart').prop('checked', true);
                            break;
                        case "1":
                            $('#tozih').prop('checked', true);
                            break;
                        case "2":
                            $('#all').prop('checked', true);
                            $('#all').trigger('click');
                            break;
                        case "3":
                            $('#mosh').prop('checked', true);
                            break;
                        case "4":
                            $('#alamat').prop('checked', true);

//        $sql = "select id,title from announces as h where h.pid={$pageid} ";
//        $query = mysql_query($sql);
//        $res = '<select id="announces">';
//        $res1 = '';
//        while ($row = mysql_fetch_assoc($query)) {
//            $sel = 'selected=""';
//            if ($row['id'] == $highid)
//                $sel = 'selected="selected"';
//            $res1.='<option value="' . $row['id'] . '" ' . $sel . '>' . $row['title'] . '</option>';
//        }
//        if ($res1 == '')
//            $res = 'موردی یافت نشد.';
//        else {
//            $res.=$res1;
//            $res.=' </select>';
//        }
//        echo ' $("#alamatres").html(\'' . $res . '\');';
//
//
//
//        //  echo "$('#announces').prop('selectedIndex',".$highid.");";
//        echo " setTimeout(selectDD(" . $highid . "), 3000);";
//        echo '$("#announces").val("' . $highid . '");';
                            break;
                    }


                }
            });
        } else {
            return '';
        }
    }
    function DeleteNode(id, Text) {
        var x;
        if (confirm(Text) == true) {
            $.ajax({
                type: "POST",
                url: '{{ route('hamafza.delete_tree_node') }}',
                dataType: 'html',
                data: ({ptid: id}),
                success: function(theResponse) {
                    jQuery.noticeAdd({
                        text: theResponse,
                        stay: false,
                        type: 'success'
                    });
                }
            });
        } else {
            return '';
        }
    }

    function LoadReports() {
        sid = jQuery("#Selected_Reports").val();
        if (sid != null) {
            $.ajax({
                type: "POST",
                url: "showreports.php",
                dataType: 'html',
                data: ({sid: sid}),
                success: function(theResponse) {
                    $("#Reports").html(theResponse);
                }
            });
        }

    }

    $(document).ready(function()
    {
          $("#SSS").click(function() {
                      $("#Selected_subject").tokenInput("add", {id: '7875487', name: 'sss'});
                  });
        

        $(".SelRad").click(function() {
            $('#tabs').hide();
        });
        $("#tozihclick").click(function() {
            if ($('#tozihshow').css('display') == 'none')
            {
                $('#tozihshow').show();
                $("#tozihclick").attr("src", "{{App::make('url')->to('/')}}/theme/Content/images/down2.png")
            }
            else {
                $('#tozihshow').hide();
                $("#tozihclick").attr("src", "{{App::make('url')->to('/')}}/theme/Content/images/left.png");

            }
        });

        $("#AddTree").click(function() {
            $("#Addpanel").show();
            $("#Addtype").val("add");
        });
        $("#alamat").click(function() {
            sid = jQuery("#Selected_subject").val();
            $("#Matn_Part").hide();
            $("#PageContent").html("");
            $("#tabs").hide();
            if (name != null) {
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamafza.show_highlight') }}',
                    dataType: 'html',
                    data: ({sid: sid}),
                    success: function(theResponse) {
                        $("#alamatres").html(theResponse);
                        //location.reload();
                    }
                });
            }
        });
        $("#sel_saf").click(function() {
            $("#Sel_Page").show();
            $("#Sel_Report").hide();
            $("#Selected_Reports").tokenInput("clear");
            $("#Selected_subject").tokenInput("clear");
            $("#ReportTR").hide();

        });
        $("#sel_rep").click(function() {
            $("#Sel_Page").hide();
            $("#Sel_Report").show();
            $("#SafheTR").hide();
            $("#Selected_Reports").tokenInput("clear");
            $("#Selected_subject").tokenInput("clear");




        });
        $("#all").click(function() {
            $("#Matn_Part").hide();
            $("#PageContent").html("");
            $("#tabs").show();
            sid = jQuery("#Selected_subject").val();
            if (name != null) {
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamafza.show_tabs') }}',
                    dataType: 'html',
                    data: ({sid: sid}),
                    success: function(theResponse) {
                        $("#tabs").html(theResponse);
                        //location.reload();
                    }
                });
            }

        });

        $("#showPages").click(function() {
            sid = jQuery("#Selected_subject").val();
            if (name != null) {
                $.ajax({
                    type: "POST",
                    url: "showtabs2.php",
                    dataType: 'html',
                    data: ({sid: sid}),
                    success: function(theResponse) {
                        $("#tabs2").html(theResponse);
                        //location.reload();
                    }
                });
            }

        });




        $(".TabsTbss").click(function() {
            sid = $(this).val();
            if (name != null) {
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamafza.show_page_body') }}',
                    dataType: 'html',
                    data: ({sid: sid}),
                    success: function(theResponse) {
                        $("#PageContent").html(theResponse);
                    }
                });
            }

        });


        $("#NewTree").click(function() {
            // if ($("#sel_saf").prop("checked") == true) {
            pageid = jQuery("#pageid").val();
            Title = jQuery("#Title_Text").val();
            Matn_Part = jQuery("#Matn_Part").val();

old_id= $("#ptree_id").val();
            Matn = $("#Matn_Text").val();
            sid = jQuery("#Selected_subject").val();
            var tozih = '0';
            var matnpart = '0';

            var all = '0';
            var mosh = '0';
            var alamat = '0';
            Matnpart = $('#matnpart').is(':checked');

            tozih = $('#tozih').is(':checked');
            all = $('#all').is(':checked');
            mosh = $('#mosh').is(':checked');
            alamat = $('#alamat').is(':checked');
            PishShomare_select = $("#PishShomare_select").checked;
            PishShomare = $("#PishShomare").val();
            announces = $("#announces").val();
            type = $("#Addtype").val();
            treeid = $("#ptree_id").val();
            title_high = $("#title_high").val();
            qut_high = $("#qut_high").val();
            parent_id = $("#parent_id").val();

            var val = "";
            i = 0;
            $('.TabsTbs:checked').each(function(i) {
                val = val + "," + $(this).val();
            });

            if (pageid != null) {
                $.ajax({
                    type: "POST",
                    url: '{{ route('hamafza.new_tree_node') }}',
                    dataType: 'html',
                    data: ({old_id:old_id,pageid: pageid, sid: sid, Title: Title, Matn: Matn, all: all, tozih: tozih, matinpart: Matnpart, mosh: mosh, alamat: alamat, PishShomare_select: PishShomare_select, PishShomare: PishShomare, announces: announces, pages: val, title_high: title_high, qut_high: qut_high, type: type, treeid: treeid, parentid: parent_id, Matn_Part: Matn_Part}),
                    success: function(theResponse) {
                        if (type == "add") {
                            jQuery.noticeAdd({
                                text: theResponse,
                                stay: false,
                                type: 'success'
                            });
                            //   location.reload();
                        }
                        else
                            alert("با موفقیت ویرایش گردید");
                    }
                });
            }
            //      }
//        else if ($("#sel_rep").prop("checked") == true) {
//            var checkedVals = $('.ReportCheck:checkbox:checked').map(function() {
//                return this.value;
//            }).get();
//            var selReports = checkedVals.join(",");
//
//            Title = jQuery("#Title_Text").val();
//            Matn = tinyMCE.get('Matn_Text').getContent()
//            sid = jQuery("#Selected_Reports").val();
//            type = $("#Addtype").val();
//            parent_id = $("#parent_id").val();
//            pid = jQuery("#pageid").val();
//
//            if (sid != null) {
//                $.ajax({
//                    type: "POST",
//                    url: "newtree.php",
//                    dataType: 'html',
//                    data: ({tid: pid, sid: sid, Title: Title, Matn: Matn, SelReports: selReports, Report: 'ok', type: type, parentid: parent_id}),
//                    success: function(theResponse) {
//                        if (type == "add") {
//                            alert("شاخه مورد نظر درج گردید.");
//                            //   location.reload();
//                        }
//                        else
//                            alert("با موفقیت ویرایش گردید");
//                    }
//                });
//            }
            //   }
        });


        $('#PishShomare_select').click(function() {
            if (this.checked)
                $("#pishshomareshow").show();
            else {
                $("#PishShomare").val('');
                $("#pishshomareshow").hide();
            }
        });
        $('#tozih').click(function() {
            if (this.checked) {
                $("#Matn_Part").hide();

                $("#PageContent").html("");
            }
            else {
                $("#PishShomare").val('');
                $("#pishshomareshow").hide();
            }
        });
        $('#matnpart').click(function() {
            if (this.checked) {
                $("#Matn_Part").show();
                $("#Matn_Part").val('');


                sid = jQuery("#Selected_subject").val();
                if (sid != null) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('hamafza.show_page_body') }}',
                        dataType: 'html',
                        data: ({sid: sid}),
                        success: function(theResponse) {
                            $("#PageContent").html(theResponse);
                        }
                    });
                }
            }
            else {
                $("#Matn_Part").val('');
                $("#Matn_Part").hide();
                $("#PageContent").html("");

            }
        });

    });




    function AddTagsPodman(Tid, Tname) {
        $("#Selected_subject").tokenInput("add", {id: Tid, name: Tname});

    }
    function selectDD(Tid) {
        $('#announces').prop('selectedIndex', Tid);

    }



</script>