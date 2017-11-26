<script>
    $(document).ready(function () {
        $(".Playcontrol").click(function () {
            $(this).hide();
            $('#' + $(this).attr('vid')).get(0).play();
            $('#' + $(this).attr('vid')).show();
        });
        $(".ShowVideos").click(function () {
            $(".VideCotrol").hide();
            $(".VideCotroler").each(
                    function (index) {
                        var input = $(this);
                        input.get(0).pause();
                    }
            );
            $("#Video_" + $(this).attr('vid')).show();
        });

    });
    $(".scrlbig").mCustomScrollbar({theme: "dark-3",
        mouseWheel: {invert: false}
        ,
        callbacks: {
            onTotalScroll: function () {
                var ptid = $('.ptid').last().val();
//                Com = '<span class="sui-loading-back"></span> <div class="contentDiv"><div class="mainDiv"><div class="logoDiv"></div><div class="textDiv"></div></div><div class="loaderDiv"><img src="img/loading.gif"></div></div>'
//                jQuery('#TextSection').css('width', '100%');
//                
                jQuery.ajax({
                    type: "POST",
                    url: Baseurl + "api/GetTreeNodes",
                    data: {ptid: ptid},
                    cache: false,
                    success: function (html) {
                        jQuery('#TextSection').append(html);

                    }
                });
            }

        }
    });
</script>
