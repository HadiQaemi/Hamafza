@php
    $file = HFM_GenerateUploadForm([['comment_file', ['gif', 'jpg', 'jpeg', 'png', ], 'Single' ]]);
@endphp
@if (isset($sid))
    @php
        $hide_type = false;
        $subject = App\Models\hamafza\Subject::find($sid);
        if ($subject)
        {
            $hide_type = 20 == $subject->kind;
        }
    @endphp
    <script>
        var Sid = '{{$sid}}';
        var hide_type = '{!! $hide_type !!}';
    </script>
@endif
<div class="sendComment">
    @if(session('uid') !='')
        <div class="col-md-10 col-md-push-1">
            <h1 id="TitleHeads" class="pull-right" style="margin: 10px 2px;font-size: 1.1em;display: none"></h1>
            <span class="pull-left fa fa-close icon-bastan" style=" font-size: 10pt;height: 10px !important;margin-top: 10px;"></span>
        </div>
        <div class="clearfix"></div>
        <div class="commenTxtHolder col-md-10 col-md-push-1">
            <div class="commenTxtHolders">
                <div class="commenTxtHolders">
                    <div class="pull-right col-md-12 col-sm-12 col-xs-12 noPadding " style="margin-right: 15px;">
                        <select name="post_type" id="post_type" class="col-md-1 col-sm-2 col-xs-2 pull-right form-control"{!! $hide_type ? ' disabled="disabled"' : null !!}>
                            <option value="1" selected="">نظر</option>
                            <option value="2">پرسش</option>
                            <option value="3">ایده</option>
                            <option value="4">تجربه</option>
                            {{--<option value="12">خبر</option>--}}
                            {{--<option value="13">مرور</option>--}}
                        </select>
                        <div class="col-md-10 col-sm-8 col-xs-8">
                            <input type="text" id="commentTitleW" class="form-control" placeholder="عنوان">
                        </div>
                        <div class="col-md-1 col-sm-2 col-xs-2 noPadding">
                            <div style="height: 15px">
                                <ul class="titleCommand col-md-12 col-sm-12 col-xs-12 noPadding">
                                    <li>
                                        <a style="height: 10px;" title="تصویر" data-placement="top" data-toggle="tooltip" id="picUploadW" class="fa icon-ax" href="#" style="font-size: 14pt;padding-top: 10px;height: 10px;"></a>
                                        <a style="height: 10px;" title="ویدیو" data-placement="top" data-toggle="tooltip" id="vidUploadWs" class="fa icon-view-slide-active" href="#"
                                           style="font-size: 14pt;padding-top: 10px;height: 10px;"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if ($hide_type)
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            {!! $file['Buttons']['comment_file'] !!}
                            {!! $file['ShowResultArea']['comment_file'] !!}
                        </div>
                    @endif

                    <div class="col-md-12 col-sm-12 col-xs-12" id="commentEditorW">
                        {{--<style>
                            td
                            {
                                border: 0 !important;
                            }
                        </style>--}}
                        <table class="table">
                            <tr>
                                <td colspan="3">
                                    <textarea class="col-md-12 col-sm-12 col-xs-12 form-control" id="NewPost" type="text" placeholder="نظرتان را بنویسید" style="margin-bottom: 5px;"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-1">کلیدواژه</td>
                                <td class="col-xs-8 hideW_on_type_2_1">
                                    <select id="keywordsW" class="no-padding form-control select2_auto_complete_keywords" name="Commentkeywords2[]" ttype="12" data-placeholder="{{trans('tasks.can_select_some_options')}}"
                                            multiple="multiple"></select>
                                    {{--@include('sections.commenttags')--}}
                                </td>
                                <td class="col-xs-3 showW_on_type_2_1">
                                    <div class="no-padding text-left">پاداش <input type="text" class="reward form-control" name="reward" id="reward" style="width: 70px; padding: 0; margin: 0; display: inline-block; height: 30px;"/> (امتیاز
                                        شما:
                                        <div style="direction: ltr; display: inline-block;">{!! get_user_sumscores() !!}</div>
                                        )
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table class="table">
                            <tr>
                                <td class="col-xs-1 showW_on_type_2_2">
                                    <small>درج در درگاه</small>
                                </td>
                                <td class="col-xs-4 showW_on_type_2_2"><select class="portal_id no-padding form-control" name="portal_id" id="portal_id"
                                                                               style="display: inline-block;"{!! $hide_type ? ' disabled="disabled"' : null !!}></select></td>
                                <td class="col-xs-2 hideW_on_type_2_2">
                                    <small>درج در گروه ها و کانال ها</small>
                                </td>
                                <td class="col-xs-4 hideW_on_type_2_2">
                                    <select id="groups" class="darjdar no-padding form-control" multiple>
                                        @foreach(MyOrganGroups() as $item)
                                            <option value="{{$item->id}}" class="CheckedGroup" name="CheckedGroup">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="col-xs-1 text-left">
                                    <div class="dropdown keep-open" style="margin-left: 20px"></div>
                                    <input id="btnpost" type="button" value="ارسال" class="btn btn-info " style="width: 50px;">
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" id='SelectedComment' value="">
                        <script>
                            $(document).ready(function () {
                                portal_id = $('.portal_id');
                                reward = $('.reward');
                                post_type = $('#post_type');
                                $(document).on('change', '#post_type', function () {
                                    hideW_on_type_2_1 = $('.hideW_on_type_2_1');
                                    showW_on_type_2_1 = $('.showW_on_type_2_1');
                                    hideW_on_type_2_2 = $('.hideW_on_type_2_2');
                                    showW_on_type_2_2 = $('.showW_on_type_2_2');
                                    if (2 == post_type.val()) {
                                        // table 1
                                        hideW_on_type_2_1.removeClass('col-xs-11');
                                        hideW_on_type_2_1.addClass('col-xs-8');
                                        showW_on_type_2_1.show();
                                        // table 2
                                        hideW_on_type_2_2.removeClass('col-xs-10');
                                        hideW_on_type_2_2.addClass('col-xs-5');
                                    } else {
                                        // table 1
                                        hideW_on_type_2_1.removeClass('col-xs-8');
                                        hideW_on_type_2_1.addClass('col-xs-11');
                                        showW_on_type_2_1.hide();
                                        // table 2
                                        hideW_on_type_2_2.removeClass('col-xs-5');
                                        hideW_on_type_2_2.addClass('col-xs-10');
                                    }
                                    portal_id.attr('disabled', 'disabled');
                                    $.ajax
                                    ({
                                        type: 'post',
                                        url: '{!! route("hamahang.enquiry.get") !!}',
                                        data: {'what': 'portals', 'sid': hide_type ? Sid : 0, 'sub_kind': post_type.val()},
                                        dataType: 'json',
                                        success: function (data) {
                                            if (data.success) {
                                                portal_id.empty();
                                                json_data = JSON.parse(data.result[0]);
                                                $.each(json_data, function (id, record) {
                                                    portal_id.append('<option value="' + record.id + '">' + record.title + '</option>');
                                                });
                                                if (!hide_type) {
                                                    portal_id.removeAttr('disabled');
                                                }
                                            }
                                        }
                                    });
                                });
                                $(".select2_auto_complete_keywords").select2
                                ({
                                    minimumInputLength: 3,
                                    dir: "rtl",
                                    width: "100%",
                                    tags: true,
                                    ajax: {
                                        url: "{{ route('auto_complete.keywords') }}",
                                        dataType: "json",
                                        type: "POST",
                                        quietMillis: 150,
                                        data: function (term) {
                                            return {
                                                term: term
                                            };
                                        },
                                        results: function (data) {
                                            return {
                                                results: $.map(data, function (item) {
                                                    return {
                                                        text: item.text,
                                                        id: item.id
                                                    }
                                                })
                                            };
                                        }
                                    }
                                });
                                $('.portal_id, .darjdar').select2({'width': '100%', 'dir': 'rtl'});
                                post_type.change();
                            });
                        </script>
                        <img id="output" style="display: none;width: 150px"/>
                    </div>


                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <input type="file" id="pictureUpload" class="hidden" onchange="loadFile(event);"/>
        <input type="file" id="videoUpload" class="hidden"/>
    @else
        <?php
        $alert = '';
        $alerts = DB::table('function_alert as f')->join('alerts as a', 'a.id', '=', 'f.alertid')->where("functionname", 'LoginPop')->select('a.comment')->first();
        if ($alerts)
            $alert = $alerts->comment;
        ?>
        <div style="margin:15px;" class="gkCode10"> {{$alert}}</div>
    @endif
</div>
<script>
    function loadFile(event) {
//            var output = document.getElementById('output');
//            output.src = URL.createObjectURL(event.target.files[0]);
//            $("#output").show();
        $("#picUploadW").css("color", "red");
    }

    $("input[name=circle]").click(function () {
        if ($('input[name=circle]:checked').val() == 'only') {
            uid = curUid;
            $("#Cids").val("0");
            var token = $("#_Alltoken").val();

            $.ajax({
                type: "POST",
                url: '{{ route('hamafza.get_my_circle') }}',
                dataType: 'text',
                data: ({uid: uid, _token: token}),
                success: function (theResponse) {
                    var json = $.parseJSON(theResponse);
                    var i = 0;
                    var len = json.length;
                    strs = '';
                    for (; i < len;) {
                        strs += '<li><input onckick="SCSel(this)" type="checkbox"  value="' + json[i]['id'] + '" class="sel_circle receiver" name="circle[]">' + json[i]['name'] + '</li>';
                        i++;
                    }

                    $("#Circles").html(strs);
                    $("#Circles").show();
                    $("#CirclesW").html(strs);
                    $("#CirclesW").show();

                }
            });
        }
        else {
            $("#Cids").val('all');
        }

    });
    function SCSel(e) {
        if ($(e).is(":checked") == true) {
            news = $(this).attr("value");
            cur = $("#Cids").val();
            if (cur == "all")
                $("#Cids").val("0");
            $("#Cids").val(cur + "," + news);
        } else {
            news = $(this).attr("value");
            cur = $("#Cids").val();
            cur = cur.replace("," + news, "");
            $("#Cids").val(cur);
        }
    }
    $("#post_type").change(function () {
        if ($('#post_type option:selected').text() == 'سایر')
            text = "مطلب خود را بنویسید";
        else
            text = $('#post_type option:selected').text() + '‌' + " تان را بنویسید";
        $("#NewPost").attr("placeholder", text);
    });
    $('#btnpost').click(function ()
    {
        uid = curUid;
        pid = Sid;
        type = $("#post_type").val();
        desc = $("#NewPost").val();

        desc = cleanHTML(desc);
        title = $("#commentTitleW").val();
        selectText = $("#SelectedComment").val();
        if (selectText != '')
        {
            desc = "درباره «" + selectText + "»<hr>" + desc;
        }
        $("#SelectedComment").val("");
        image = '';
        video = '';
        all = '1';
        keys = $("#keywordsW").val();
        cids = $("#Cids").val();
        gids = $("#groups").val();
        portal_id_val = portal_id.val();
        reward_val = reward.val();
        var token = $("#_Alltoken").val();

        var formData = new FormData();
        formData.append('image', $('#pictureUpload')[0].files[0]);
        formData.append('uid', uid);
        formData.append('pid', pid);
        formData.append('type', type);
        formData.append('desc', desc);
        formData.append('title', title);
        formData.append('all', all);
        formData.append('keys', keys);
        formData.append('cids', cids);
        formData.append('gids', gids);
        formData.append('portal_id', portal_id_val);
        formData.append('reward', reward_val);
        //formData.append('_token', token);

        var control = $("#pictureUpload");
        control.val('').clone(true);
        // file=$("#pictureUpload").files[0];

        $.ajax
        ({
            type: "POST",
            url: Baseurl + "newpost",
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            data: formData,
            success: function (theResponse)
            {
                if (theResponse.hasOwnProperty('success'))
                {
                    if (theResponse.success)
                    {

                    } else
                    {
                        messageModal('fail', 'خطا', ['میزان پاداش نمی تواند بیشتر از میزان موجودی امتیاز شما باشد.']);
                    }
                }
                HFM_RemoveAllFFS('{{ $file['ShowResultArea']['comment_file']['section'] }}', true);
                $("#commentTitleWW").val("");
                $("#NewPostW").val("");
                jQuery.noticeAdd({text: 'انجام شد', stay: false, type: 'success'});
                var pic = "{{App::make('url')->to('/')}}" + "/" + "{{session('pic')}}";
                var name = "{{session('Name')}}" + "  " + "{{session('Family')}}";
                var newcom = '<div class="comment-contain"><div class="comment-box"><img class="avatar mCS_img_loaded" src="' + pic + '">';
                newcom = newcom + '<div class="name">' + name + '</div><div class="text">';
                newcom = newcom + title + '<br>' + desc + '<div style="margin:5px; "></div></div><div class="clear"></div></div><div class="like-box40">';
                newcom = newcom + '<div class="firstRow"><span postid="469" like="1" class="PostLike">پسند </span>- <span class="Comment_Foc" postid="Comment_469">اظهار نظر</span> - <span>بازنشر</span><div class="pull-left left-detail">';
                newcom = newcom + ' 0 ثانیه قبل</div></div></div></div>';
                $(newcom).insertBefore(".comment-contain:first");
            }
        });

        $(".icon-bastan").click();

        window.setTimeout(function ()
        {
            $('#th20').click();
            $('#th20').click();
        }, 2000);

    });
    function cleanHTML(input) {
        // 1. remove line breaks / Mso classes
        var stringStripper = /(\n|\r| class=(")?Mso[a-zA-Z]+(")?)/g;
        var output = input.replace(stringStripper, ' ');
        // 2. strip Word generated HTML comments
        var commentSripper = new RegExp('<!--(.*?)-->', 'g');
        var output = output.replace(commentSripper, '');
        var tagStripper = new RegExp('<(/)*(meta|link|span|\\?xml:|st1:|o:|font)(.*?)>', 'gi');
        // 3. remove tags leave content if any
        output = output.replace(tagStripper, '');
        // 4. Remove everything in between and including tags '<style(.)style(.)>'
        var badTags = ['style', 'script', 'applet', 'embed', 'noframes', 'noscript'];

        for (var i = 0; i < badTags.length; i++) {
            tagStripper = new RegExp('<' + badTags[i] + '.*?' + badTags[i] + '(.*?)>', 'gi');
            output = output.replace(tagStripper, '');
        }
        // 5. remove attributes ' style="..."'
        var badAttributes = ['style', 'start'];
        for (var i = 0; i < badAttributes.length; i++) {
            var attributeStripper = new RegExp(' ' + badAttributes[i] + '="(.*?)"', 'gi');
            output = output.replace(attributeStripper, '');
        }
        output = output.replace(/&nbsp;/g, '');
        output = output.replace(/<p  dir="RTL">/g, '<br>');
        output = output.replace(/<\/p>/g, '');


        return output;
    }
    function cleanWordPaste(in_word_text) {
        in_word_text = in_word_text.replace(/<br\/>/gi, "\n");
        in_word_text = in_word_text.replace(/<br \/>/gi, "\n");

        in_word_text = in_word_text.replace(/<br>/gi, "\n");
        in_word_text = in_word_text.replace(/<p>/gi, "\n");

        var tmp = document.createElement("DIV");
        tmp.innerHTML = in_word_text;
        var newString = tmp.textContent || tmp.innerText;
        // this next piece converts line breaks into break tags
        // and removes the seemingly endless crap code
        newString = newString.replace(/\n\n/g, "<br />").replace(/.*<!--.*-->/g, "");
        // this next piece removes any break tags (up to 10) at beginning

        return newString;
    }
</script>


@if ($hide_type)
    @section('HFM_Form_JS')
        {!! $file['UploadForm'] !!}}
        {!! $file['JavaScripts'] !!}}
    @stop
    <script>
        $(document).ready(function()
        {
            window.setInterval(function()
            {
                $('.sendComment').height($('.commenTxtHolders').height() + 73);
            }, 1000);
        });
    </script>
@endif
