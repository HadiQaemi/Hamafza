<div class="h-content">
    <div id="tab" class="row-fluid" style="width: 100%;">
        <ul class="nav nav-tabs">
            <!--
            <li>
                <a href="#t10" id="th10" data-id="10" data-toggle="tab"><i class="fa fa-sort-amount-desc" data-ord="desc"></i>همه</a>
            </li>
            -->
            <li>
                <a href="#t20" id="th20" data-id="20" data-toggle="tab"><i class="fa fa-sort-amount-asc" data-ord="asc"></i> {{ trans('enquiry.new') }}</a>
            </li>
            <li>
                <a href="#t30" id="th30" data-id="30" data-toggle="tab"><i class="fa fa-sort-amount-desc" data-ord="desc"></i> {{ trans('enquiry.reward') }}</a>
            </li>
            <li>
                <a href="#t40" id="th40" data-id="40" data-toggle="tab"><i class="fa fa-sort-amount-desc" data-ord="desc"></i> {{ trans('enquiry.hot') }}</a>
            </li>
            <li>
                <a href="#t50" id="th50" data-id="50" data-toggle="tab"><i class="fa fa-sort-amount-desc" data-ord="desc"></i> {{ trans('enquiry.vote') }}</a>
            </li>
            <li style="margin: 10px;">
                <button class="btn btn-info" onclick="show_comment_box();">
                    <span>پرسش جدید</span>
                </button>
            </li>
            <li style="float: left; display: none;" id="current-keyword-area">
                <div class="h-span-keyword" style="margin: 11px;">
                    <a class="h-tag" id="current-keyword-area-close" href="#"
                       onclick="$('#current-keyword-area').hide(); return false;" data-tagid="0" style="text-decoration: none; margin-top: 0; padding: 3px;">X</a>
                    <i class="fa fa-tag"></i> <span id="current-keyword-area-title"></span>
                </div>
            </li>
        </ul>
        <div class="tab-content" style="min-height: 550px;">
            <div class="tab-pane" id="t10">
                @include('hamahang.Enquiry.helper.subcontent')
            </div>
            <div class="tab-pane" id="t20">
                @include('hamahang.Enquiry.helper.subcontent')
            </div>
            <div class="tab-pane" id="t30">
                @include('hamahang.Enquiry.helper.subcontent')
            </div>
            <div class="tab-pane" id="t40">
                @include('hamahang.Enquiry.helper.subcontent')
            </div>
            <div class="tab-pane" id="t50">
                @include('hamahang.Enquiry.helper.subcontent')
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
</div>