<!-- <div style="  font-size: 12pt;">
                                       
     <a href="41430">   <img src="img/bavar.jpg" /></a>
     
                                        <table style="width: 100%;">
                                            <tbody><tr>

                                                    <td style="text-align:center;width:185px;height:70px;">
                                                        <a style="font-family: naskh;color:#555;" href="21/1/">
                                                            <img src="img/home_aghaz.jpg">  </a>  
                                                    </td>

                                                    <td style="text-align:center;width:185px;height:70px;">

                                                        <a style="font-family: naskh;color:#555;" href="24/1/">
                                                            <img src="img/home_karbord.jpg">      </a>
                                                    </td>
                                                    <td style="text-align:center;width:185px;height:70px;">  
                                                        <a style="font-family: naskh;color:#555;margin-right: 3px !important;color:#555;" original-title="راهنمای اینجا" class="ModalPanel" href="#" link="helpview.php?id=21&amp;tagname=rahnamamozei&amp;hid=57">
                                                            <img src="img/home_rahnam.jpg">  </a>
                                                    </td>
                                                </tr>
                                                <tr>


                                                    <td style="text-align:center;width:185px;height:70px;">

                                                        <a style="font-family: naskh;color:#555;" href="37261">
                                                            <img src="img/home_dore.jpg">  </a>  





                                                    </td>
                                                    <td style="text-align:center;width:185px;height:70px;">      
                                                        <a style="font-family: naskh;color:#555;" href="20">
                                                            <img src="img/home_dargah.jpg">    
                                                        </a>
                                                    </td>

                                                    <td style="text-align:center;width:185px;height:70px;">   
                                                        <a style="font-family: naskh;color:#555;" href="26">
                                                            <img src="img/home_miz.jpg">    
                                                        </a>
                                                    </td>

                                                </tr>

                                            </tbody></table>
                                        <br>
                                    </div>-->
<div class="col-md-12 col-sm-12 col-xs-12 noPadding pull-right">
    <div>

        <div id="slider2_container" class="daneshSlider shadowBox" style="position: relative; top:0; left: 0; width: 790px; height: 340px; overflow: hidden;float:right; ">

            <!-- Loading Screen -->
<!--            <div u="loading" style="position: absolute; top: 0; left: 0;">
                <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;background-color: #000; top: 0; left: 0;width: 100%;height:100%;">
                </div>
                <div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center;top: 0; left: 0;width: 100%;height:100%;">
                </div>
            </div>-->

            <!-- Slides Container -->
            <div u="slides" class="slideHolder" style="cursor: move; position: absolute; left: 0; top:20px; width: 790px; height: 300px; overflow: hidden;">
               
                  @if(is_array($otherSlide) && count($otherSlide)>0)
                            @foreach($otherSlide as $item)
                            <div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <img src="Content/slide/{{$item->pic}}" class="pull-right col-md-3 col-sm-3 col-xs-3" />
                        <div class="pull-right col-md-9 col-sm-9 col-xs-9 Divcalss">
                            <b><a href="{{$item->url}}">{{$item->title}}</a></b>
                            <br>
                         {{$item->descr}}
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                            @endforeach
                 @else

                <div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <img src="img/homeslide0.jpg" class="pull-right col-md-3 col-sm-3 col-xs-3" />
                        <div class="pull-right col-md-9 col-sm-9 col-xs-9 Divcalss">
                            <b>برنامه راهبردی صنعت، معدن و تجارت</b>
                            <br>
                            در پروژه «طراحی برنامه راهبردی صنعت، معدن و تجارت» اقتصاد ایران با تمرکز بر بخش صنعت، معدن و تجارت تحلیل شده و راهبردهای اساسی برای پیشرفت طراحی شده‌اند.
                            <br>
                            <a href="31830">درگاه برنامه راهبردی صنعت، معدن و تجارت</a>
                            ، دربردارنده مستندات این پروژه است

                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <img src="img/homeslide1.jpg" class="pull-right  col-md-3 col-sm-3 col-xs-3" />
                        <div class="pull-right col-md-9 col-sm-9 col-xs-9 Divcalss">
                            <b> پژوهش</b>
                            <br>
                            موضوعات پژوهشی بسیار متنوع بوده و روش‌های متعددی نیز برای پژوهش مطرح هستند. آشنایی با روش‌های پژوهش و انتخاب روش مناسب یکی از دغدغه‌های دانشجویان و محققان است.
                            <br>
                            <a href="41880">درگاه پژوهش</a>، دربردارنده چارچوب‌ها و انواع روش‌های پژوهش است.


                        </div>
                        <div class="clearfix"></div>
                    </div>



                </div>
                <div>
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <img src="img/homeslide2.jpg" class="pull-right  col-md-3 col-sm-3 col-xs-3" />
                         <div class="pull-right col-md-9 col-sm-9 col-xs-9 Divcalss">
                            <b>شبکه اجتماعی</b>
                            
                            <br>
                        شبکه اجتماعی کارکردهای مؤثری برای شناسایی و تعامل بین افراد و گروه‌ها داشته و می‌توان از آن برای افزایش آگاهی و انتقال هوشمندانه اطلاعات استفاده نمود.
                        <br>
                        در درگاه کاربران می‌توانید با کاربران این سامانه آشنا شوید. حضور در شبکه اجتماعی هم‌افزا را با ثبت‌نام و معرفی خود آغاز کنید.

                        </div>
                        <div class="clearfix"></div>
                    </div>



                </div>
                 
                 @endif
            </div>

            <!-- Bullet Navigator Skin Begin -->
            <!-- jssor slider bullet navigator skin 01 -->
            <style>
                .Divcalss{
                    text-align: justify; 
                    font-size: 12pt;
                }

                /*
                .jssorb01 div           (normal)
                .jssorb01 div:hover     (normal mouseover)
                .jssorb01 .av           (active)
                .jssorb01 .av:hover     (active mouseover)
                .jssorb01 .dn           (mousedown)
                */
                .jssorb01 div, .jssorb01 div:hover, .jssorb01 .av {
                    filter: alpha(opacity=70);
                    opacity: .7;
                    overflow: hidden;
                    cursor: pointer;
                    border: #000 1px solid;
                }

                .jssorb01 div {
                    background-color: gray;
                }

                .jssorb01 div:hover, .jssorb01 .av:hover {
                    background-color: #d3d3d3;
                }

                .jssorb01 .av {
                    background-color: #fff;
                }

                .jssorb01 .dn, .jssorb01 .dn:hover {
                    background-color: #555555;
                }
            </style>
            <!-- bullet navigator container -->
            <div u="navigator" class="jssorb03" style="position: absolute; bottom: 4px; right: 0;left:0;margin:0 auto">
                <!-- bullet navigator item prototype -->
                <div u="prototype" style="position: absolute; width: 21px; height: 21px; text-align:center; line-height:21px; color:#a3a3a3; font-size:12px;"><numbertemplate></numbertemplate></div>
            </div>
            <!-- Bullet Navigator Skin End -->
            <!-- Arrow Navigator Skin Begin -->
            <style>
                /* jssor slider arrow navigator skin 02 css */
                /*
                .jssora02l              (normal)
                .jssora02r              (normal)
                .jssora02l:hover        (normal mouseover)
                .jssora02r:hover        (normal mouseover)
                .jssora02ldn            (mousedown)
                .jssora02rdn            (mousedown)
                */

                .jssorb03 {
                    cursor: pointer;
                }

                .jssorb03 .av {
                    background-color: #1b8ed1;
                }

                .jssora02l, .jssora02r, .jssora02ldn, .jssora02rdn {
                    position: absolute;
                    cursor: pointer;
                    display: block;
                    background: url(img/a15.png) no-repeat;
                    overflow: hidden;
                }

                .jssora02l {
                    background-position: -3px -33px;
                }

                .jssora02r {
                    background-position: -63px -33px;
                }

                .jssora02l:hover {
                    background-position: -123px -33px;
                }

                .jssora02r:hover {
                    background-position: -183px -33px;
                }

                .jssora02ldn {
                    background-position: -243px -33px;
                }

                .jssora02rdn {
                    background-position: -303px -33px;
                }
            </style>
            <!-- Arrow Left -->
            <span u="arrowleft" class="jssora02l" style="width: 55px; height: 55px;bottom:0; left: 8px;">
            </span>
            <!-- Arrow Right -->
            <span u="arrowright" class="jssora02r" style="width: 55px; height: 55px; bottom: 0; right: 8px">
            </span>
        </div>
    </div>
</div>
