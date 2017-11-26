
$(document).ready(function () {

    /*For Left Side */

    $(window).resize(function () {

        if (window.innerWidth > 992) {

            $.sidr('close', 'sidr-left');
        }
    })


    $('#leftSideMenu').sidr({

        name: 'sidr-left', side: 'left', source: 'aside#leftSide'

    })

    $("span.closeLefSide").click(function () {

        $.sidr('close', 'sidr-left');
    })
})