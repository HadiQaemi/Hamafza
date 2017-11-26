@extends('layouts.master')
@section('MainTemplate')
<div hmfz-tmplt-thm-clr="theme-lightblue" hmfz-tmplt-cntnt="">
    <link rel="stylesheet" type="text/css" href="theme/Content/css/quran.css"/>
    <div class="toolbarContainer">
        <div id="toolbar">
            <div class="pull-right right-detail">
                <h2>درگاه دانشنامه</h2>
                <small>آخرین بروز رسانی  ۲۰ فروردین ۱۳۹۰</small>
            </div>

            <div class="btn-group pull-left frst-wdt mr">
                <!--  -->
                <button type="button" class="btn trash" data-toggle="tooltip" data-placement="top" title="حذف"></button>
            </div>
            <div class="btn-group pull-left mr">
                <!--  -->
                <button type="button" class="btn activity" data-toggle="tooltip" data-placement="top" title="فعالیت ها"></button>
            </div>
            <div class="btn-group pull-left mr">
                <!--  -->
                <button type="button" class="btn history" data-toggle="tooltip" data-placement="top" title="تاریخچه"></button>
            </div>
            <div class="btn-group pull-left">
                <button type="button" class="btn mark" data-toggle="tooltip" data-placement="top" title="علامت گذاری"></button>
            </div>
            <div class="btn-group pull-left mr">
                <!--  -->
                <button type="button" class="btn ask" data-toggle="tooltip" data-placement="top" title="پرسش"></button>
            </div>
            <div class="btn-group pull-left">
                <button type="button" class="btn cooperation" data-toggle="tooltip" data-placement="top" title="همکاری"></button>
            </div>
            <div class="btn-group pull-left mr">
                <!--  -->
                <button type="button" class="btn tag" data-toggle="tooltip" data-placement="top" title="چوب الف"></button>
            </div>
            <div class="btn-group pull-left">
                <button type="button" class="btn print" data-toggle="tooltip" data-placement="top" title="چاپ"></button>
            </div>
            <div class="btn-group pull-left">
                <button type="button" class="btn note" data-toggle="tooltip" data-placement="top" title="یادداشت"></button>
            </div>
            <div class="btn-group pull-left mr">
                <!--  -->
                <button type="button" class="btn introduction" data-toggle="tooltip" data-placement="top" title="معرفی"></button>
            </div>
            <div class="btn-group pull-left">
                <button type="button" class="btn comment" data-toggle="tooltip" data-placement="top" title="نظر"></button>
            </div>
        </div>
        <div class="activty-box"></div>
    </div>
    <div id="mainContainer">
        <div class="dsply-tbl">
            <div class="dsply-tbl-rw">
                <div class="right-menu dsply-tbl-cl">
                    <ul class="menu">
                        <li class="active"><a href="#/quran.html">اصلی</a></li>
                        <li ><a href="#/hamradeh.html" >هم رده</a></li>
                        <li ><a href="#/wall.html" >دیوار</a></li>
                        <li  class="darkmenu"><a href="#/worktable.html">میز کار</a></li>
                    </ul>
                    <div class="bottom">
<!--                        <strong>28</strong>
                        <div>فرد برخط</div>-->
                    </div>
                </div>
                <div  hmfz-pg-tb="" class="next-container dsply-tbl-cl">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-light about-panel">
                                <div class="panel-heading panel-heading-lightblue">
                                    درباره درگاه
                                </div>
                                <div class="panel-body">
                                    اگر مفاهیم «قرآن کریم» به خوبی درک شوند، ساختار ذهنی مطلوبی برای درک جهان فراهم می‌شود؛ اگر احکام «فرقان» به درستی قهمیده شود، مبناهای ارزشی لازم برای شناخت حق و عمل صالح فراهم می‌شود؛ «تنزیل» دربردارنده ایده‌های زیادی برای شناخت و تصمیم‌گیری است.
                                    <br />
                                    خواندن (متن و یا ترجمه)، شنیدن (متن و یا ترجمه) و تدبر در «ذکر» به‌ طور مکرر و هر روزه برای «بهداشت ذهن و طهارت روح» ضروری است؛ به‌ ویژه در دنیای کنونی که اطلاعات طغیان کرده‌اند؛ فراغت‌ها اندک شده‌اند؛ وسوسه‌ها متنوع، گسترده و پیچیده شده‌اند؛ طاغوت‌های فکری ریشه دوانده‌اند و ...
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="panel panel-light padding-remove panel-tab">
                                    <div class="panel-heading panel-heading-lightblue"></div>
                                    <div class="panel-body">
                                        <div class="quran-article-list">
                                            <div class="navbar navbar-default">
                                                <ul class="nav nav-tabs">
                                                    <li class="active" ><a aria-controls="art-tab-1" href="#art-tab-1" role="tab" data-toggle="tab">مقالات</a></li>
                                                    <li><a  aria-controls="art-tab-2" href="#art-tab-2" role="tab" data-toggle="tab">دیوارها </a></li>
                                                    <li><a  aria-controls="art-tab-3" href="#art-tab-3" role="tab" data-toggle="tab">سوالات</a></li>
                                                </ul>
                                            </div>
                                            <div class="tab-content">
                                                <div id="art-tab-1" role="tabpanel" class="tab-pane active">
                                                    <ul class="article-list">
                                                        <li>
                                                            <h3>عنوان مقاله جدید مندرج شده
                                                                <span class="date">12 خرداد 1393</span>
                                                            </h3>
                                                            بازبابی اسناد بر اساس موضوع می‌توان از کلیدواژه‌ها یا صفحه هم رده‌ها در سایر بخش‌ها (مانند اسناد هم رده با برنامه راهبردی صنعت ....
                                                        </li>
                                                        <li>
                                                            <h3>عنوان مقاله جدید مندرج شده
                                                                <span class="date">12 خرداد 1393</span>
                                                            </h3>
                                                            بازبابی اسناد بر اساس موضوع می‌توان از کلیدواژه‌ها یا صفحه هم رده‌ها در سایر بخش‌ها (مانند اسناد هم رده با برنامه راهبردی صنعت ....
                                                        </li>
                                                        <li>
                                                            <h3>عنوان مقاله جدید مندرج شده
                                                                <span class="date">12 خرداد 1393</span>
                                                            </h3>
                                                            بازبابی اسناد بر اساس موضوع می‌توان از کلیدواژه‌ها یا صفحه هم رده‌ها در سایر بخش‌ها (مانند اسناد هم رده با برنامه راهبردی صنعت ....
                                                        </li>
                                                        <li>
                                                            <h3>عنوان مقاله جدید مندرج شده
                                                                <span class="date">12 خرداد 1393</span>
                                                            </h3>
                                                            بازبابی اسناد بر اساس موضوع می‌توان از کلیدواژه‌ها یا صفحه هم رده‌ها در سایر بخش‌ها (مانند اسناد هم رده با برنامه راهبردی صنعت ....
                                                        </li>
                                                        <li>
                                                            <h3>عنوان مقاله جدید مندرج شده
                                                                <span class="date">12 خرداد 1393</span>
                                                            </h3>
                                                            بازبابی اسناد بر اساس موضوع می‌توان از کلیدواژه‌ها یا صفحه هم رده‌ها در سایر بخش‌ها (مانند اسناد هم رده با برنامه راهبردی صنعت ....
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div id="art-tab-2" role="tabpanel" class="tab-pane">دیوارها</div>
                                                <div id="art-tab-3" role="tabpanel" class="tab-pane">سوالات</div>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="panel panel-light padding-remove panel-tab">
                                    <div class="panel-heading panel-heading-lightblue"></div>
                                    <div class="panel-body" ng-controller="soorehController">
                                        <div class="guran-sooreh-list">
                                            <div class="navbar navbar-default">
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a aria-controls="sooreh-tab-1" href="#sooreh-tab-1" role="tab" data-toggle="tab">فهرست سوره ها</a></li>
                                                    <li><a aria-controls="sooreh-tab-2" href="#sooreh-tab-2" role="tab" data-toggle="tab">تفاسیر </a></li>
                                                    <li><a aria-controls="sooreh-tab-3" href="#sooreh-tab-3" role="tab" data-toggle="tab">کلیدواژه ها</a></li>
                                                    <li><a aria-controls="sooreh-tab-4" href="#sooreh-tab-4" role="tab" data-toggle="tab">دروه های آموزشی</a></li>
                                                </ul>
                                            </div>
                                            <div class="tab-content">
                                                <div id="sooreh-tab-1" role="tabpanel" class="tab-pane active">
                                                    <div class="table-responsive">
                                                        <table class="table table-default">
                                                            <tr>
                                                                <th>ردیف</th>
                                                                <th>نام سوره</th>
                                                                <th>قالات</th>
                                                                <th>هم رده</th>
                                                                <th>تعداد آیات</th>
                                                                <th>نزول</th>
                                                            </tr>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>سوره حمد</td>
                                                                <td>۲۵</td>
                                                                <td>۱۷۲</td>
                                                                <td>۷ آیه</td>
                                                                <td>مکه</td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>سوره حمد</td>
                                                                <td>۲۵</td>
                                                                <td>۱۷۲</td>
                                                                <td>۷ آیه</td>
                                                                <td>مکه</td>
                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td>سوره حمد</td>
                                                                <td>۲۵</td>
                                                                <td>۱۷۲</td>
                                                                <td>۷ آیه</td>
                                                                <td>مکه</td>
                                                            </tr>
                                                            <tr>
                                                                <td>4</td>
                                                                <td>سوره حمد</td>
                                                                <td>۲۵</td>
                                                                <td>۱۷۲</td>
                                                                <td>۷ آیه</td>
                                                                <td>مکه</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div id="sooreh-tab-2" role="tabpanel" class="tab-pane">تفاسیر</div>
                                                <div id="sooreh-tab-3" role="tabpanel" class="tab-pane">کلیدواژه ها</div>
                                                <div id="sooreh-tab-4" role="tabpanel" class="tab-pane">دروه های آموزشی</div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.dsply-tbl-rw -->    
        </div><!-- /.display-table -->    
    </div>
</div>
@stop()
