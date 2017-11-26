@if(isset($tools))
{!!$tools!!}
@endif
@if(isset($view)&& is_array($view))
    <?php
    $viewslide = $view['slide'];
    $viewfilm = $view['film'];
    $viewtext = $view['text'];
    ?>
    <script>
        $(document).ready(function () {
            $("#FilmSection").hide();
            $("#SlideSection").hide();
            $("#TextSection").show();
        });
    </script>
    @if ($viewslide == '1' || $viewfilm == '1')
        <?php $Butoons = '<div class="btn-group pull-right mr" style="border-color: #fff;border-style: none solid none none;border-width: 1px;height: 15px;margin-top: 15px;"></div>'; ?>
        @if ($viewslide == '1')
            <?php $Butoons .= '<div class="btn-group pull-right mr"><button title="نمای اسلاید" data-placement="top" data-toggle="tooltip" class="btn  fa fa-anchor icon-slide-act" type="button" id="SlideSwitch" ></button></div> '; ?>
            @if ($viewfilm == '0' && $viewtext == '0') {
            <script>
                $(document).ready(function () {
                    $("#FilmSection").hide();
                    $("#SlideSection").show();
                    $("#SlideSwitch").hide();
                    $("#FilmSwitch").hide();
                    $("#TextSwitch").hide();
                    $("#TextSection").hide();
                });
            </script>
            @endif
            @if ($viewtext == '0') {
            <script>
                $(document).ready(function () {
                    $("#FilmSection").hide();
                    $("#SlideSection").show();
                    $("#TextSection").hide();
                    $("#SlideSwitch").addClass("btnActive");
                });
            </script>
            @endif
        @endif
        @if ($viewfilm == '1')
            <?php $Butoons .= '<div class="btn-group pull-right mr"><button title="نمای فیلم" data-placement="top" data-toggle="tooltip" class="btn  fa fa-anchor icon-file-film" type="button" id="FilmSwitch" ></button></div>'; ?>
            @if ($viewslide == '0' && $viewtext == '0')
                <script>
                    $(document).ready(function () {
                        $("#FilmSection").show();
                        $("#SlideSection").hide();
                        $("#SlideSwitch").hide();
                        $("#FilmSwitch").hide();
                        $("#TextSwitch").hide();
                        $("#TextSection").hide();
                    });
                </script>
            @endif
        @endif
        @if ($viewtext == '1')
            <?php $Butoons .= '<div class="btn-group pull-right mr"><button title="نمای نوشتار" data-placement="top" data-toggle="tooltip" class="btn  fa fa-anchor icon-layout2" type="button" id="TextSwitch" ></button></div>'; ?>
            @if ($viewfilm == '0' && $viewslide == '0')
                <script>
                    $(document).ready(function () {
                        $("#FilmSection").hide();
                        $("#TextSection").show();
                        $("#SlideSwitch").hide();
                        $("#FilmSwitch").hide();
                        $("#TextSwitch").hide();
                        $("#SlideSection").hide();
                    });
                </script>
            @endif
        @endif
        {!! $Butoons !!}
    @endif
    <script>
        $(document).ready(function () {
            $("#SlideSwitch").click(function () {
                $("#SlideSection").show();
                $("#TextSection").hide();
                $("#FilmSection").hide();
                //  $(".PageSlides").wmuSlider();
                $("#SlideSwitch").addClass("btnActive");
                $("#SlideSwitch").removeClass("UnSelectTagBut");
                $("#TextSwitch").removeClass("btnActive");
                $("#FilmSwitch").removeClass("btnActive");
            });
            $("#TextSwitch").click(function () {
                $("#SlideSection").hide();
                $("#FilmSection").hide();
                $("#FilmSwitch").removeClass("btnActive");
                $("#TextSection").show();
                $("#TextSwitch").addClass("btnActive");
                $("#TextSwitch").removeClass("UnSelectTagBut");
                $("#SlideSwitch").removeClass("btnActive");
            });
            $("#FilmSwitch").click(function () {
                $("#SlideSection").hide();
                $("#TextSection").hide();
                $("#TextSwitch").removeClass("btnActive");
                $("#FilmSection").show();
                $("#FilmSwitch").addClass("btnActive");
                $("#FilmSwitch").removeClass("UnSelectTagBut");
                $("#SlideSwitch").removeClass("btnActive");
            });
            $("#SlideSwitch").trigger("click");
            $(".PageSlides").stop();
        });
    </script>
@endif
