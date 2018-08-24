<div hmfz-tmplt-thm-clr="" hmfz-tmplt-cntnt="">
    ﻿    <div class="bootslider minislider" id="bootslider">
        <!-- Bootslider Loader -->
        <div class="bs-loader">
            <img src="homslider/loader.gif" width="31" height="31" alt="Loading.." id="loader"/>
        </div>
        <!-- /Bootslider Loader -->
        <!-- Bootslider Container -->
        @if (App::isDownForMaintenance() || !isset($client_ip) ||  !in_array($client_ip, ['89.165.122.115', '188.34.116.207', '127.0.0.1']))
            <div class="bs-container">
            <!-- Bootslider Slide -->
            @if(is_array($mainSlide) && count($mainSlide)>0)
                @foreach($mainSlide as $item)
                    <div class="bs-slide active">
                        <div class="bs-foreground">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-10 col-sm-10 col-sx-10  bs-vertical-center">
                                        <div data-animate-in="slideLeftReturn" data-animate-out="slideUp"
                                             data-delay="500">
                                            <h2>{{$item->title}}</h2>
                                            <p>{{$item->descr}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bs-background">
                            <img src="Content/icons/slider-log.png" class="bs-layer"
                                 data-animate-in="slideRightReturn" data-animate-out="slideLeft"
                                 data-width="157" data-height="206" data-top="100"
                                 data-right="50" data-delay="500">
                            <img src="Content/slide/{{$item->pic}}" class="bs-layer"
                                 data-animate-in="slideLeftReturn" data-animate-out="slideDown" data-width="320"
                                 data-height="269" data-left="250"
                                 data-top="20" data-delay="500">

                            <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="371">
                        </div>
                    </div>
                @endforeach
            @else
            <!-- /Bootslider Slide -->
                <div class="bs-slide active">
                    <div class="bs-foreground">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-sm-10 col-sx-10  bs-vertical-center">
                                    <div data-animate-in="slideLeftReturn" data-animate-out="slideUp"
                                         data-delay="500">
                                        <h2>اشراف می‌یابید!</h2>

                                        <p>در هم‌افزا «دانش» نظم می‌یابد، تصورها درست‌تر شکل می‌گیرند و «فهم»
                                            عمیق‌تر و دقیق‌تری پدید می‌آید.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bs-background">
                        <img src="Content/icons/slider-log.png" class="bs-layer"
                             data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157"
                             data-height="206" data-top="100"
                             data-right="50" data-delay="500">
                        <img src="Content/slide/1.png" class="bs-layer" data-animate-in="slideLeftReturn"
                             data-animate-out="slideDown" data-width="320" data-height="269" data-left="250"
                             data-top="20" data-delay="500">

                        <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="371">
                    </div>
                </div>
                <!-- Bootslider Slide -->
                <div class="bs-slide">
                    <div class="bs-foreground">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-sm-10 col-sx-10  bs-vertical-center">
                                    <div data-animate-in="slideLeftReturn" data-animate-out="slideUp"
                                         data-delay="500">
                                        <h2>نزدیک می‌شوید!</h2>
                                        <p>هم‌افزا «حصارهای علمی» را کم‌رنگ کرده و هم‌افزایی دانش را افزایش
                                            می‌دهند. هم‌افزا ذهن‌ها را به هم نزدیک می‌کند.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bs-background">
                        <img src="Content/icons/slider-log.png" class="bs-layer"
                             data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157"
                             data-height="206" data-top="100"
                             data-right="50" data-delay="500">
                        <img src="Content/slide/3.png" class="bs-layer" data-animate-in="slideLeftReturn"
                             data-animate-out="slideDown" data-width="320" data-height="269" data-left="250"
                             data-top="20" data-delay="500">

                        <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="371">
                    </div>
                </div>
                <!-- /Bootslider Slide -->
                <!-- Bootslider Slide -->
                <div class="bs-slide">
                    <div class="bs-foreground">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-sm-10 col-sx-10  bs-vertical-center">
                                    <div data-animate-in="slideLeftReturn" data-animate-out="slideUp"
                                         data-delay="500">
                                        <h2> وصل می‌شوید!</h2>
                                        <p>در هم‌افزا جویندگان و صاحبان دانش یکدیگر را «می‌یابند» و در تعامل با
                                            یکدیگر «هم‌زبان» و «هم‌دل» می‌شوند.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bs-background">
                        <img src="Content/icons/slider-log.png" class="bs-layer"
                             data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157"
                             data-height="206" data-top="100"
                             data-right="50" data-delay="500">
                        <img src="Content/slide/2.png" class="bs-layer" data-animate-in="slideLeftReturn"
                             data-animate-out="slideDown" data-width="320" data-height="269" data-left="250"
                             data-top="20" data-delay="500">
                        <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="371">
                    </div>
                </div>
                <!-- /Bootslider Slide -->
                <!-- Bootslider Slide -->
                <div class="bs-slide">
                    <div class="bs-foreground">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-sm-10 col-sx-10  bs-vertical-center">
                                    <div data-animate-in="slideLeftReturn" data-animate-out="slideUp"
                                         data-delay="500">
                                        <h2>شکوفا می‌شوید!</h2>
                                        <p>
                                            می‌توانید خود را معرفی کنید، افراد بیشتری را بهتر بشناسید، از
                                            زیرساخت‌های متعددی (شبکه اجتماعی، ویکی، پرس‌وجو و ...) استفاده کنید؛
                                            تا بیشتر بفهمید و بهتر منتشر کنید.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bs-background">
                        <img src="Content/icons/slider-log.png" class="bs-layer"
                             data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157"
                             data-height="206" data-top="100"
                             data-right="50" data-delay="500">
                        <img src="Content/slide/6.png" class="bs-layer" data-animate-in="slideLeftReturn"
                             data-animate-out="slideDown" data-width="320" data-height="269" data-left="250"
                             data-top="20" data-delay="500">

                        <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="371">
                    </div>
                </div>
                <!-- /Bootslider Slide -->
                <!-- Bootslider Slide -->
                <div class="bs-slide">
                    <div class="bs-foreground">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-sm-10 col-sx-10  bs-vertical-center">
                                    <div data-animate-in="slideLeftReturn" data-animate-out="slideUp"
                                         data-delay="500">
                                        <h2>شروع کنید!</h2>
                                        <p>مخاطبان هم‌افزا «اهالی اندیشه و جویندگان علم» هستند؛ به‌ویژه کسانی که
                                            می‌خواهند «وقتشان» در پیچ‌وتاب فضای شلوغ و به‌هم‌ریخته کنونی تلف
                                            نشود.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bs-background">
                        <img src="Content/icons/slider-log.png" class="bs-layer"
                             data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157"
                             data-height="206" data-top="100"
                             data-right="50" data-delay="500">
                        <img src="Content/slide/4.png" class="bs-layer" data-animate-in="slideLeftReturn"
                             data-animate-out="slideDown" data-width="320" data-height="269" data-left="250"
                             data-top="20" data-delay="500">

                        <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="371">
                    </div>
                </div>
                <!-- /Bootslider Slide -->
                <!-- Bootslider Slide -->
                <div class="bs-slide">
                    <div class="bs-foreground">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-sm-10 col-sx-10  bs-vertical-center">
                                    <div data-animate-in="slideLeftReturn" data-animate-out="slideUp"
                                         data-delay="500">
                                        <h2>به اینجا بیایید!</h2>
                                        <p>
                                            چشم انداز هم افزا اینجا است: «فهم بهتر و بیشتر، اوج گرفتن قله علم و
                                            عمل و تقویت اندیشه و تعقل در راستای رشد فردی و نیل به جامعه مطلوب.»
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bs-background">
                        <img src="Content/icons/slider-log.png" class="bs-layer"
                             data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157"
                             data-height="206" data-top="100"
                             data-right="50" data-delay="500">
                        <img src="Content/slide/5.png" class="bs-layer" data-animate-in="slideLeftReturn"
                             data-animate-out="slideDown" data-width="320" data-height="269" data-left="250"
                             data-top="20" data-delay="500">

                        <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="371">
                    </div>
                </div>
                <!-- /Bootslider Slide -->
                <!-- Bootslider Slide -->
                <div class="bs-slide">
                    <div class="bs-foreground">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-sm-10 col-sx-10 bs-vertical-center">
                                    <div data-animate-in="slideLeftReturn" data-animate-out="slideUp"
                                         data-delay="500">
                                        <h2>
                                            به هم‌افزا نیاز دارید!

                                        </h2>
                                        <p>
                                            دنیای امروز بسیار گسترده، متنوع و پیچیده شده؛ مشغله‌ها و دغدغه‌ها
                                            فزونی یافته؛ فراغت‌ها اندک، حافظه و عقلانیت تضعیف و رؤیاهای
                                            تقویت‌شده؛ غفلت‌ها زیاد و قلب‌ها سست شده‌ و ...
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bs-background">
                        <img src="Content/icons/slider-log.png" class="bs-layer"
                             data-animate-in="slideRightReturn" data-animate-out="slideLeft" data-width="157"
                             data-height="206" data-top="100"
                             data-right="50" data-delay="500">
                        <img src="Content/slide/7.png" class="bs-layer" data-animate-in="slideLeftReturn"
                             data-animate-out="slideDown" data-width="320" data-height="269" data-left="250"
                             data-top="20" data-delay="500">

                        <img src="Content/icons/slider-highlight.png" data-width="1206" data-height="371">
                    </div>
                </div>
                <!-- /Bootslider Slide -->
            @endif
        </div>
        @endif
        <!-- /Bootslider Container -->
    </div>

    <div class="row main-container" style="top:-20px;">
        <div class="col-md-3" style="top:-20px;">
            <div class="panel panel-light" style="height: 332px;">
                <div class="panel-heading panel-heading-darkblue"></div>
                @include('sections.homeright')

            </div>
        </div>
        <div class="col-md-6" style="top:-20px;">
            <div class="panel panel-light" style="height: 332px;">
                <div class="panel-heading panel-heading-green"></div>
                <div class="panel-body">
                    @include('sections.homecenter')

                </div>
            </div>
        </div>
        <div class="col-md-3" style="top:-20px;">
            <div class="panel panel-light quick-access" style="height: 332px;">

                <div class="panel-heading panel-heading-green" style="padding: 0"></div>
                <div class="panel-body">
                    @include('sections.homeleft')
                </div>
            </div>
        </div>
    </div>
    <div class="row main-container">
        <div style="top:-20px;" class="col-md-12">
            <div class="">
                <center>
                    <table align="center">
                        <tr>
                            <td>
                                <a style="margin-left: 10px; font-family: naskh; color:#555;" href="21/1">
                                    <img class="image" src="img/home_aghaz.png">
                                </a>
                            </td>
                            {{--<td>
                                <a style="margin-left: 10px; font-family: naskh; color:#555;" href="24/1">
                                    <img class="image" src="img/home_karbord.png">
                                </a>
                            </td>--}}
                            <td>
                                <a style="margin-left: 10px; font-family: naskh; color:#555;" class="jsPanels" title=" راهنمای اینجا" href="modals/helpview?id=21&amp;tagname=rahnamamozei&amp;hid=57&amp;pid=25">
                                    <img class="image" src="img/home_rahnam.png">
                                </a>
                            </td>

                            <td>
                                <a style="margin-left: 10px; font-family: naskh; color:#555;" href="20">
                                    <img class="image" src="img/home_dargah.png">
                                </a>
                            </td>
                            <td>
                                <a style="margin-left: 10px; font-family: naskh; color:#555;" href="26">
                                    <img class="image" src="img/home_miz.jpg">
                                </a>
                            </td>
                        </tr>
                    </table>
                    <br>
                </center>
                <style>
                    .image {
                        -webkit-transition: all 1s ease; /* Safari and Chrome */
                        -moz-transition: all 1s ease; /* Firefox */
                        -ms-transition: all 1s ease; /* IE 9 */
                        -o-transition: all 1s ease; /* Opera */
                        transition: all 1s ease;
                        width: 70px;
                    }

                    .image:hover {
                        -webkit-transform: scale(1.25); /* Safari and Chrome */
                        -moz-transform: scale(1.25); /* Firefox */
                        -ms-transform: scale(1.25); /* IE 9 */
                        -o-transform: scale(1.25); /* Opera */
                        transform: scale(1.25);
                    }
                </style>
            </div>
        </div>
    </div>
</div>