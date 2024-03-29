@if($Small == Auth::id() || (!is_array($Tree) && ($Tree=='groupadmin' || $Tree=='ismember') ))
    <script type="text/javascript">
        $(document).ready(function () {
            $("#input-plugin-methods2").tokenInput("{{App::make('url')->to('/')}}/Tagsearch", {
                preventDuplicates: true,
                hintText: "عبارتی را وارد کنید",
                noResultsText: "نتیجه‌ای یافت نشد، با زدن دکمه اینتر کلیدواژه جدیدی ایجاد می‌شود",
                searchingText: "در حال جستجو",
                onAdd: function (item) {
                    //add the new label into the database
                    if (parseInt(item.id) == 0) {
                        var name = $("tester").text();
                        if (name != null) {
                            $.ajax({
                                type: "POST",
                                url: "tagmergeaction.php",
                                dataType: 'html',
                                data: ({New: 'OK', Name: name}),
                                success: function (theResponse) {
                                    if (theResponse != 'NOK')
                                        alert('بر چسب جدید با موفقیت تعریف شد');
                                    $("#input-plugin-methods2").tokenInput("remove", {name: name});
                                    $("#input-plugin-methods2").tokenInput("add", {id: theResponse, name: name});
                                }
                            });
                        }
                    }
                },
                onResult: function (item) {
                    if ($.isEmptyObject(item)) {

                        return [{id: '0', name: $("tester").text()}]
                    } else {
                        return item
                    }

                },
            });
        });
    </script>
    <div class="comment-box" style="display: block;">
        <form method="post" action="" enctype="multipart/form-data">
            @if(Session::get('uid') !='')
                @if (isset($sid))
                    <script>
                        var Sid = '{{$sid}}';
                        var Tree = '{{$Tree}}'
                    </script>
                @endif
                <div class="commenTxtHolders">

                    <div class="pull-right col-md-12 col-sm-12 col-xs-12 noPadding margin-bottom-30" style="margin-right: 15px;">
                        <div class="col-xs-12 col-sm-2 col-lg-2 noLeftPadding noRightPadding">
                            <select name="post_typeW" id="post_typeW" class="form-control">
                                <option value="0" selected="">انتخاب کنید</option>
                                <option value="1">نظر</option>
                                <option value="2">پرسش</option>
                                <option value="3">ایده</option>
                                <option value="4">تجربه</option>
                                {{--<option value="12">خبر</option>--}}
                                {{--<option value="13">مرور</option>--}}
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-lg-8">
                            <input type="text" id="commentTitleWW" class="form-control" placeholder="عنوان">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                        </div>
                        <div class="col-xs-12 col-sm-2 col-sm-2 col-lg-2 noLeftPadding noRightPadding">
                            <div class="pull-right noPadding" style="height: 15px !important;">
                                <ul class="pull-right titleCommand col-md-12 col-sm-12 col-xs-12 noPadding">
                                    <li style=" display: inline-block">
                                        <a id="picUploadW" title="تصویر" data-placement="top" data-toggle="tooltip" href="#" style="font-size: 14pt;">
                                            <div class="iconX fa icon-ax"></div>
                                        </a>
                                    </li>
                                    <li style=" display: inline">
                                        <a id="vidUploadW" title="ویدیو" data-placement="top" data-toggle="tooltip" href="#" style="font-size: 14pt;"><span class="iconX fa icon-view-slide-active"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>



                    <div class="row" id="commentEditorWW" style="height: 0px; display: none; margin-top: 10px;">
                        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-30">
                            <div id="NewPostW" contenteditable='true' data-placeholder="نظرتان را وارد کنید" class="form-control padding-10"></div>
                        </div>
                        <div class="col-xs-11 margin-bottom-30">
                            <select id="keywords" class="no-padding form-control select2_auto_complete_keywords" name="Commentkeywords2[]" ttype="12" data-placeholder="{{trans('tasks.keyword')}}" multiple="multiple"></select>
                        </div>
                        <div class="col-xs-1">
                            <div class="rewardC">
                                <input type="text" placeholder="پاداش" class="rewardW form-control" name="rewardW" id="rewardW" style="width: 100%;"/>
                                {{--(امتیاز شما: <div style="direction: ltr; display: inline-block;">{!! get_user_sumscores() !!}</div>)--}}
                            </div>
                        </div>
                        <div class="col-xs-11">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 noLeftPadding noRightPadding">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 noLeftPadding">
                                    <select class="portal_idW no-padding form-control" name="portal_idW" id="portal_idW" style="display: inline-block;" multiple data-placeholder="درج در درگاه"></select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 noLeftPadding noRightPadding">
                                <select id="groupsW" class="darjdar no-padding form-control" multiple data-placeholder="درج در گروه ها و کانال ها">
                                    @foreach(MyOrganGroups() as $item)
                                        @if(($Tree=='groupadmin' || $Tree=='ismember') && $item->id==$sid)
                                        @else
                                            <option value="{{$item->id}}" class="CheckedGroup" name="CheckedGroup">{{$item->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <div class="dropdown keep-open" style="margin-left: 20px"></div>
                            <input id="pip_post" type="button" value="ارسال" class="btn btn-primary pull-left">
                        </div>

                        <script>
                            $(document).ready(function ()
                            {
                                portal_idW = $('.portal_idW');
                                rewardW = $('.rewardW');
                                $(".rewardC").css("display","none");
                                $.ajax
                                ({
                                    type: 'post',
                                    url: '{!! route("hamahang.enquiry.get") !!}',
                                    data: {'what': 'portals'},
                                    dataType: 'json',
                                    success: function (data)
                                    {
                                        // alert(data.success);
                                        if (data.success)
                                        {
                                            portal_idW.empty();
                                            json_data = JSON.parse(data.result[0]);
                                            $.each(json_data, function (id, record)
                                            {
                                                portal_idW.append('<option value="' + record.id + '">' + record.title + '</option>');
                                            });
                                        }
                                    }
                                });
                                post_typeW = $('#post_typeW');
                                $(document).on('change', post_typeW, function ()
                                {
                                    hide_on_type_2_1 = $('.hide_on_type_2_1');
                                    show_on_type_2_1 = $('.show_on_type_2_1');
                                    hide_on_type_2_2 = $('.hide_on_type_2_2');
                                    show_on_type_2_2 = $('.show_on_type_2_2');
                                    if (2 == post_typeW.val())
                                    {
                                        // table 1
                                        hide_on_type_2_1.removeClass('col-xs-11');
                                        hide_on_type_2_1.addClass('col-xs-8');
                                        show_on_type_2_1.show();
                                        // table 2
                                        show_on_type_2_2.show();
                                        hide_on_type_2_2.removeClass('col-xs-10');
                                        hide_on_type_2_2.addClass('col-xs-5');
                                        $('.portal_idW').select2({data: {id: 6, text: 'پرس و جو'}});
                                    } else
                                    {
                                        // table 1
                                        hide_on_type_2_1.removeClass('col-xs-8');
                                        hide_on_type_2_1.addClass('col-xs-11');
                                        show_on_type_2_1.hide();
                                        // table 2
                                        show_on_type_2_2.hide();
                                        hide_on_type_2_2.removeClass('col-xs-5');
                                        hide_on_type_2_2.addClass('col-xs-10');
                                    }
                                });
                                post_typeW.change();
                                $(".select2_auto_complete_keywords").select2
                                ({
                                    minimumInputLength: 3,
                                    dir: "rtl",
                                    width: "100%",
                                    tags: true,
                                    ajax:
                                        {
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
                                $('.portal_idW, .darjdar').select2({'width': '100%', 'dir': 'rtl'});
                            });
                        </script>
                    </div>



                </div>
                <input type="file" class="hidden" id="pictureUpload" onchange="loadFile(event);">
                <input type="file" class="hidden" id="videoUpload">
            @endif
            <input type="hidden" id="UserConUname" value="jafarpur">
            <input type="hidden" id="PageTypes" value="userwall">
        </form>
    </div>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#NewPostW').append('<img id="theImg" src="x" />');
                    $('#theImg').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#pictureUpload").change(function () {
            readURL(this);
        });
        $(".CheckedGroup").click(function () {
            type = $("#post_typeW").val();
        });
        $("#post_typeW").change(function () {
            var val = $('#post_typeW option:selected').val();
            if (val == 2)
            {
                $(".rewardC").css("display","");
            } else
            {
                $(".rewardC").css("display","none");
            }
            if ($('#post_typeW option:selected').text() == 'سایر')
                text = "مطلب خود را بنویسید";
            else
                text = $('#post_typeW option:selected').text() + '‌' + " تان را بنویسید";
            $("#NewPostW").attr("data-placeholder", text);
        });
        $("#pip_post").click(function () {
            var token = $("#_Alltoken").val();
            uid = curUid;
            pid = Sid;
            type = $("#post_typeW").val();
            desc = $("#NewPostW").html();
            desc = cleanHTML(desc);
            title = $("#commentTitleWW").val();
            image = '';
            video = '';
            all = '1';
            keys = $("#keywords").val();
            cids = $("#CidsW").val();
            gids = $("#groupsW").val();
            if(Tree=='groupadmin' || Tree=='ismember')
            {
               gids+=","+ Sid; 
            }
            // portal_idW_val = portal_idW.val();
            portal_idW_val = $('#post_typeW').val();
            rewardW_val = rewardW.val();
            var allVals = [];
            $('.Checke dGroup :checked').each(function () {
                allVals.push($(this).val());
            });
            /*gids = gids + ',' + $(".CheckedGroup:checked").map(
                    function () {
                        return this.value;
                    }).get().join(",");*/
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
            formData.append('portal_id', portal_idW_val);
            formData.append('reward', rewardW_val);
            //formData.append('_token', token);
            var control = $("#pictureUpload");
            control.val('').clone(true);
            control.replaceWith(control = control.clone(true));
            $.ajax({
                type: "POST",
                url: Baseurl + "newpost",
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                data: formData,
                success: function (theResponse) {
                    if (theResponse.hasOwnProperty('success')) {
                        if (theResponse.success) {

                        } else {
                            messageModal('fail', 'خطا', ['میزان پاداش نمی تواند بیشتر از میزان موجودی امتیاز شما باشد.']);
                        }
                    }
                    $("#commentTitleWW").val("");
                    $("#NewPostW").html("");
                    $('#pictureUpload')[0].files[0] = '';
                    var id = 0;
                    if (theResponse == parseInt(theResponse, 10))
                        id = theResponse;
                    if (id > 0) {
                        //                    jQuery.noticeAdd({
                        //                        text: 'انجام شد',
                        //                        stay: false,
                        //                        type: 'success'
                        //                    });
                        window.location.reload();
                        {{--@if(isset(auth()->user()->avatar))--}}
                            {{--var pic = "{{route('FileManager.DownloadFile',['type'=>'ID','id'=>enCode((int)(isset(auth()->user()->avatar) ? auth()->user()->avatar : ''))])}}";--}}
                            {{--var name = "{{Session::get('Name')}}" + "  " + "{{Session::get('Family')}}";--}}
                            {{--var newcom = '<div class="comment-contain"><div class="comment-box"><img class="avatar mCS_img_loaded" src="' + CurPics + '">';--}}
                            {{--newcom = newcom + '<div class="name">' + name + '</div><div class="text">';--}}
                            {{--newcom = newcom + title + '<br>' + desc + '<div style="margin:5px; "></div></div><div class="clear"></div></div><div class="like-box40">';--}}
                            {{--newcom = newcom + '<div class="firstRow"><span postid="' + id + '" like="1" class="PostLike">پسند </span>- <span class="Comment_Foc" postid="Comment_' + id + '">اظهار نظر</span> - <span>بازنشر</span><div class="pull-left left-detail">';--}}
                            {{--newcom = newcom + ' 0 ثانیه قبل</div></div></div><div class="addcomment"> <input type="hidden" value="' + id + '" class="Postid">';--}}
                            {{--newcom = newcom + ' <img src="' + CurPics + '" class="imgContain mCS_img_loaded">';--}}
                            {{--newcom = newcom + '  <div class="txtContain"><input type="text " place h older="نظرتان را بنویسی د " id="Comment_' + id + '" p o stid="' + id + '" class="CommentSend" onkeypress="CommentSend(this,event);"></div>';--}}
                            {{--newcom = newcom + '  </div></div></div>';--}}
                        {{--@endif--}}
                        {{--$(newcom).insertBefore(".comment-contain:first");--}}
                    } else {
                        jQuery.noticeAdd({
                            text: 'مشکل در انجام عملیات',
                            stay: false,
                            type: 'success'
                        });
                    }
                }
            });
        });

        function cleanHTML(input) {
            // 1. remove line breaks / Mso classes
            var stringStripper = /(\n|\r| class=(")?Mso[a-zA-Z]+(")?)/g;
            var output = input.replace(stringStripper, ' ');
            // 2. strip Word generated HTML comments
            var commentSripper = new RegExp('<!--(.*?)-->', 'g');
            var output = output.replace(commentSripper, '');
            var tagStripper = new RegExp('<(/)*(meta|link|span|\\?xml:|st1:|o:|font|a)(.*?)>', 'gi');
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
            output = output.replace(/<div>/g, '');
            output = output.replace(/<\/div>/g, '<br>');
            return output;
        }
    </script>
@endif