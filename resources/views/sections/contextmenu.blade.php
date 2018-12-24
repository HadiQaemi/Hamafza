<script>
    var seltext = "";
    $(document).ready(function () {
        var Page_pid = "{{$pid}}";

        function highlight(text, pid) {
            if (text == '')
                alert("محتوا خالی است");
            else {

                $.ajax({
                    type: "POST",
                    url: Baseurl + "highlight",
                    dataType: 'html',
                    data: ({pid: pid, text: text}),
                    success: function (theResponse) {
                        $(".text-content").highlight(text);
                        jQuery.noticeAdd({
                            text: theResponse,
                            stay: false,
                            type: 'success'
                        });
                    }
                });
            }
        }

        function isValidURL(url) {
            var RegExp = /^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/;
            return RegExp.test(url);
        }

        function isValidEmail(email) {
            var RegExp = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            return RegExp.test(email);
        }

        $('.text-content').textAssist({
            items: [
                {
                    title: '<span style="height:30px" class="btn comment fa fa-anchor icon-ezhare-nazar"></span>نظر',
                    onClick: function (text, offset) {
                        $("#CommentPage").trigger("click");
                        $("#NewPost").val();
                        $(".SelectedComment").val(text);
                        $(".SelectedCommentDiv").html(text);
                        //$(".text-content").highlight(text);
                        $('.ful-scrn').css('display','none');
                        $(".sendComment").css('height','270px');
                        $("#post_type").val('1').change();
                        $(".textassist").hide();
                        return false;

                    }

                },
                {
                    title: '<span style="height:30px" class=" btn  fa fa-anchor icon-porsesh1"></span>پرسش',
                    onClick: function (text, offset) {
                        $(".question").trigger("click");
                        console.log(text);
                        $("#NewPost").val(text);
                        $(".textassist").hide();
                        return false;
                    }
                }
                ,
                {
                    title: '<span style="height:30px" class=" btn  fa fa-anchor icon-baznashr"></span>بازنشر',
                    onClick: function (text, offset) {
                        $(".textassist").hide();
                        return false;
                    },
                    classN: "jsPanels",
                    href: "{{App::make('url')->to('/')}}/modals/share?sid={{$sid }}&pid={{$pid }}&type={{$PageType}}&title={{$Title}}&seltext={%s}",
                },
                {
                    divider: true,
                },
                {
                    title: '<span style="height:30px" class=" btn  fa fa-anchor icon-yaddasht"></span>یادداشت',
                    onClick: function (text, offset) {
                        $(".textassist").hide();
                        return false;
                    },
                    classN: "jsPanels",
                    TitleN: "یادداشت",
                    href: Baseurl + "modals/announce?sid={{$sid }}&pid={{$pid }}&type={{$PageType}}&title={{$Title}}&sel={%s}",
                },
                {
                    title: '<span style="height:30px" class=" btn  fa fa-anchor icon-alamatgozari-2"></span> علامت گذاری',
                    onClick: function (text, offset) {
                        $(".textassist").hide();
                        $(".textassist").hide();
                        highlight(text, {{$pid }});
                    },
                },
                {
                    divider: true,
                },
                {
                    title: '<span style="height:30px" class=" btn  fa fa-anchor icon-moredi-2"></span>وظیفه',
                    onClick: function (text, offset) {
                        $(".textassist").hide();
                        return false;
                    },
                    classN: "jsPanels",
                    TitleN: "وظیفه",
                    href:"{{url('/modals/CreateNewTask?uid='.auth()->id().'&type='.$PageType.'&title='.$Title)}}&sel={%s}",
                    {{--href:"{{url('/modals/CreateNewTask?uid='.auth()->id().'&sid='.$sid.'&type='.$PageType.'&pid='.$pid.'&title='.$Title)}}&sel={%s}",--}}
                {{--"{{App::make('url')->to('/')}}/modals/measure?sid={{$sid }}&pid={{$pid }}&type={{$PageType}}&title={{$Title}}&sel={%s}",--}}
                },
                {
                    divider: true,
                },
                {
                    title: '<span style="height:30px" class=" btn  fa fa-anchor icon-chap"></span>چاپ',
                    onClick: function (text, offset) {
                        $(".textassist").hide();
                        return false;
                    },
                    classN: "jsPanels",
                    href: "{{App::make('url')->to('/')}}/modals/print?sid={{$sid }}&pid={{$pid }}&type={{$PageType}}&title={{$Title}}",
                }
            ]
        });
    });
</script>
