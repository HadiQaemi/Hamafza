<style>
    table.dataTable {
        width: 100% !important;
    }

    .item_parent_id .select2.select2-container {
        width: 100% !important;
    }
</style>
<div id="tab" class="row table-bordered" style="border-bottom: none">
    <ul class="nav nav-tabs">
        <li class="active" id="define">
            <a href="#tab_t1" data-toggle="tab">شغل</a>
        </li>
        <li>
            <a href="#tab_t2" data-toggle="tab">مهارت</a>
            {{--<a href="#" data-toggle="tab">تنظیم</a>--}}
        </li>
        <li>
            <a href="#tab_t3" data-toggle="tab">توانایی</a>
        </li>
        <li>
            <a href="#tab_t4" data-toggle="tab">روابط</a>
        </li>
        {{--<li>--}}
        {{--<a href="#tab_t5" data-toggle="tab">اقدام</a>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a href="#tab_t6" data-toggle="tab">بحث و پیگیری</a>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a href="#tab_t7" data-toggle="tab">سابقه</a>--}}
        {{--</li>--}}
        <li style="float: left">
            <h5 id="task_type" style="color: blue"></h5>
        </li>
    </ul>
    <div class="tab-content new-task-form">
        <div class="tab-pane active tab-view" id="tab_t1">
            <div class="col-xs-12 form-group margin-top-20">
                <div class="col-xs-1 line-height-30 noRightPadding noLeftPadding line-height-35">
                    <label for="item_title">شغل</label>
                </div>
                <div class="col-xs-11 noRightPadding noLeftPadding">
                    {{$job->title}}
                </div>
            </div>
            <div class="col-xs-12 form-group margin-top-20 ">
                <div class="col-xs-1 line-height-30 noRightPadding noLeftPadding line-height-35">
                    <label for="item_title">توضیحات</label>
                </div>
                <div class="col-xs-11 noRightPadding noLeftPadding">
                    {{$job->lblDescription}}
                </div>
            </div>
        </div>
        <div class="tab-pane tab-view" id="tab_t2">
            <table class="table margin-top-20" style="width: 100%;">
                <thead>
                <th class="col-xs-4 text-right">مهارت</th>
                <th class="col-xs-3 text-right">توضیحات</th>
                </thead>
                <tbody id="list_positions">
                @foreach($job->skill as $skill)
                    <tr>
                        <td class="col-xs-4">{{isset($skill->skill->label) ? $skill->skill->label : ''}}</td>
                        <td class="col-xs-8">{{isset($skill->skill->description) ? $skill->skill->description : ''}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane tab-view" id="tab_t3">
            <table class="table margin-top-20" style="width: 100%;">
                <thead>
                <th class="col-xs-4 text-right">توانایی</th>
                <th class="col-xs-3 text-right">توضیحات</th>
                </thead>
                <tbody id="list_positions">
                @foreach($job->ability as $ability)
                    <tr>
                        <td class="col-xs-4">{{isset($ability->ability->label) ? $ability->ability->label : ''}}</td>
                        <td class="col-xs-8">{{isset($ability->ability->description) ? $ability->ability->description : ''}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane tab-view" id="tab_t4">
            <table class="table margin-top-20" style="width: 100%;">
                <thead>
                <th class="col-xs-4 text-right">توانایی</th>
                <th class="col-xs-3 text-right">توضیحات</th>
                </thead>
                <tbody id="list_positions">
                @foreach($job->knowledge as $knowledge)
                    <tr>
                        <td class="col-xs-4">{{isset($knowledge->knowledge->label) ? $knowledge->knowledge->label : ''}}</td>
                        <td class="col-xs-8">{{isset($knowledge->knowledge->description) ? $knowledge->knowledge->description : ''}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>