<div class="row" >
    <div class="col-md-3" style="border-left: 1px #E5E5E5 solid;height: 400px;">
        <div>
            <div id="div_count_selected" class="container-fluid">
                <div class="col-md-10">
                    <span id="span_selected_select" style="color: blue; font-size: 11px; cursor: pointer;"> انتخاب شده</span>
                    <span id="span_count_selected" style="color: blue;">0</span>
                </div>
                <div class="col-md-2" id="span_close_selected"><span class="fa fa-remove"></span></div>
            </div>
            <div id="FehresrtUC" class="v"></div>
            <div id="html1">
                <ul>

                </ul>
            </div>
        </div>

    </div>
    <div class="col-md-9" style="">
        <div id="GroupsDiv">
        </div>
        <div id="OrgansDiv">
        </div>
        <div id="CiclesDiv">
        </div>
        <div class="space-6"></div>
        <div id="div_loader" class="loader"></div>
        <div id="SearchDiv" class="">
         <div>   سه حرف از نام یا نام خانوادگی را وارد نمایید.</div>
            <div class="space-6"></div>
            <input type="text" id="Search_Box" class="form-control" onkeyup="send_user(this,event)">
            <hr>
            <div class="div_scroll_serchad_user">
            <ul class="person_list  row" id="SearchedUsers">

            </ul>
            </div>
            <div id="div_loader_searched" class="loader" style="margin-top: 50px;"></div>
        </div>
        <div id="SelectedDiv" style="display: none;">

            <div class="div_scroll_serchad_user">
            <ul class="person_list  row" id="SelectedUsers_div"></ul>
            </div>

        </div>
    </div>
</div>

<script>
var select='{{$id_select}}';
</script>