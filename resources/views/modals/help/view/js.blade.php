<script>
    $(document).ready(function()
    {
        var scrolled = 0;
        var sels = false;

        $(".Clicks").click(function()
        {
            var pas = $(this).val();
            if (pas == '0') {
                sels = true;
                scrolled = scrolled + 500;
                $("#helpcomment").show();
                $(".jsPanel-content").animate({
                    scrollTop: scrolled
                });
                $("#helpviewDiv").css('height', '210px');

            }
            else {
                if (sels) {
                    $("#helpcomment").hide();
                    $("#helpviewDiv").css('height', '310');
                }


            }
        });
    });
    function HelpFire(pid, tagname) {
        $.ajax({
            type: "POST",
            url: '{{ route('hamafza.pop_help') }}',
            dataType: 'html',
            data: ({tagname: tagname, pid: pid}),
            success: function(theResponse) {
                jQuery('#helpviewDiv').html("<p></p>");
                jQuery('#helpviewDiv').append(theResponse);
                $(".fancybox-inner").scrollTop(0);
                jQuery('#helpviewDiv').scrollTop(0);
            }
        });
    }

</script>
