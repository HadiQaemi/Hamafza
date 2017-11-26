<link href="{{App::make('url')->to('/')}}/theme/Content/css/magicsuggest.css" rel="stylesheet">
<script src="{{App::make('url')->to('/')}}/theme/Scripts/magicsuggest-min.js"></script><link rel="StyleSheet" href="css/jquery.tagedit.css" type="text/css" media="all"/>

<link rel="StyleSheet" href="{{App::make('url')->to('/')}}/theme/Content/css/jquery.tagedit.css" type="text/css" media="all"/>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.autoGrowInput.js"></script>
<script type="text/javascript" src="{{App::make('url')->to('/')}}/theme/Scripts/jquery.tagedit.js"></script>
<script type="text/javascript">
    
    $('#tagform-full').submit(function() {
        
        $("#content").val($("#{{$post_id}}").html());
});
$(function() {

    // Fullexample
    $("#tagform-full").find('input.tag').tagedit({
        allowAdd: true,
        allowEdit: false
                //checkToDeleteURL: 'server/checkToDelete.php'
    });


});
</script>
<form action="{{ route('hamafza.share_post') }}" method="post" id="tagform-full">
                                   <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  <table class="table">

        <tr>
            <td>بازنشر در گروه / کانال</td>
            <td>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#ShareGroup").tokenInput("{{App::make('url')->to('/')}}/Groupsearch", {
                            preventDuplicates: true,
                            hintText: "عبارتی را وارد کنید",
                            noResultsText: "نتیجه‌ای یافت نشد، با زدن دکمه اینتر برچسب جدیدی ایجاد می‌شود",
                            searchingText: "در حال جستجو",
                            onAdd: function(item) {
                                //add the new label into the database
                                if (parseInt(item.id) == 0) {
                                    name = $("tester").text();
                                    if (name != null) {
                                        $.ajax({
                                            type: "POST",
                                            url: "tagmergeaction.php",
                                            dataType: 'html',
                                            data: ({New: 'OK', Name: name}),
                                            success: function(theResponse) {
                                                if (theResponse != 'NOK')
                                                    alert('بر چسب جدید با موفقیت تعریف شد');
                                                $("#PS_input-plugin-methods").tokenInput("remove", {name: name});
                                                $("#PS_input-plugin-methods").tokenInput("add", {id: theResponse, name: name});
                                            }
                                        });
                                    }
                                }
                            },
                            onResult: function(item) {
                                if ($.isEmptyObject(item)) {

                                    return [{id: '0', name: $("tester").text()}]
                                } else {
                                    return item
                                }

                            },
                        });



                    });
                </script>
                <input type="text" id="ShareGroup" name="ShareGroup" ttype="12"  />
                <input type="hidden"  name="post_id" value="{{$post_id}}" />


            </td>
        </tr>
        <tr>
            <td>بازنشر فقط برای</td>
            <td>
                <slecet  id="manager" multiple name="manager" style="width: 350px;display: inline-block;"></slecet>
               {{--  <script>
                    $('#manager').magicSuggest({
                        data: "{{App::make('url')->to('/')}}/searchUser",
                        dataUrlParams: {id: 34},
                        allowFreeEntries: false,
                        allowDuplicates: false,
                        hideTrigger: true
                    });
                    var manager = $('#manager').magicSuggest({});
                </script> --}}

                <div style="height: 10px; display: inline-block;">
                    <a href="{!! route('modals.setting_user_view',['id_select'=>'manager']) !!}" title="انتخاب کاربران" class="jsPanels">
                        <span class="icon icon-afzoodane-fard fonts"></span>
                    </a>
                </div>

            </td>
        </tr>
        <tr>
            <td>ارسال به رایانامه</td>
            <td><input type="text" name="emails[]"  class="tag"/>
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" name="inmypage">
                در زبانه مطالب خودم
            </td>
            <td></td>
        </tr>
        <tr>
            <td>توضیحات</td>
            <td>
                <textarea class="form-control" name="descr"></textarea>

            </td>
        </tr>
        <tr>
            <td colspan="2">
                @if (is_array($content))

                @foreach($content as $item)
                <!--<div class="addcomment-box"></div>-->
                <div class="comment-contain" id="{{ $item['id']}}">
                    <div class="comment-box">
                        <?php
                        if (array_key_exists('OrganPic', $item) && $item['OrganPic'] != '') {
                            $pic = 'pics/group/Groups.png';
                            if (trim($item['OrganPic']) != '' && file_exists('pics/group/' . $item['gid'] . '-' . $item['OrganPic']))
                                $pic = 'pics/group/' . $item['gid'] . '-' . $item['OrganPic'];
                            else if (trim($item['OrganPic']) != '' && file_exists('pics/group/' . $item['OrganPic']))
                                $pic = 'pics/group/' . $item['OrganPic'];
                            $name = $item['OrganName'];
                            $link = $item['Organlink'];
                        }
                        else {
                            $pic = 'pics/user/Users.png';
                            if (trim($item['Pic']) != '' && file_exists('pics/user/' . $item['uid'] . '-' . $item['Pic']))
                                $pic = 'pics/user/' . $item['uid'] . '-' . $item['Pic'];
                            else if (trim($item['Pic']) != '' && file_exists('pics/user/' . $item['Pic']))
                                $pic = 'pics/user/' . $item['Pic'];
                            $name = $item['Name'] . ' ' . $item['Family'];
                            $link = $item['Uname'];
                        }
                        ?>
                        <img src="{{App::make('url')->to('/')}}/{{$pic}}" class="avatar"  title="{{ $name}}" data-placement="top" data-toggle="tooltip">
                        <div class="name"><a href="{{App::make('url')->to('/')}}/{{ $link}}" target="_blank">{{ $name}}</a></div>
                        <div class="text">
                            @if($item['title']!='')
                            {{$item['type']}}:  {{ $item['title']}}
                            <br>

                            @endif
                            @if (!array_key_exists('OrganPic', $item) &&($item['InsertedGroup']!='' ||$item['InsertedOrgan']|| $item['InsertedSubject'] ) ) 

                            درج شده در
                            @if($item['InsertedGroup']!='')
                            گروه  <a target="_blank" href="{{App::make('url')->to('/')}}/{{$item['InsertedGrouplink']}}">{{$item['InsertedGroup']}}</a>،
                            @endif
                            @if($item['InsertedOrgan']!='')
                            کانال   <a target="_blank" href="{{App::make('url')->to('/')}}/{{$item['InsertedOrganlink']}}">{{$item['InsertedOrgan']}}</a>، 
                            @endif
                            @if($item['InsertedSubject']!='')
                            صفحه   <a target="_blank" href="{{App::make('url')->to('/')}}/{{$item['InsertedSubjectlink']}}">{{$item['InsertedSubject']}}</a>
                            @endif
                            <br>
                            @endif
                            @if($item['pic']!='')
                            <img src="{{App::make('url')->to('/')}}/uploads/{{ $item['pic']}}" style="max-width: 600px">
                            <br>
                            @endif
                            {{$item['desc']}}

                            <div style="margin:5px; ">
                                @if(array_key_exists("keywords",$item) && is_array($item['keywords']))
                                @foreach($item['keywords'] as $items)
                                <div class="FaqTags" id="Key_{{$items['id']}}">{{$items['keyword']}}</div>
                                @endforeach
                                @endif
                            </div>

                        </div>
                        <div class="clear"></div>

                    </div>
                    @endforeach

                    @endif

            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="hidden" id="content" name="content" value="" >

                <input type="submit" id="submit" name="addSubject" style=" float: left" value="تایید " class="btn btn-primary">
            </td>
        </tr>
    </table>
</form>
<script>
    $("#manager").select2({
        ajax: {
            type: "POST",
            url: '{!! route('auto_complete.users') !!}',
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: $.map(data, function (item, i) {
                        return {
                            text: item.text,
                            id: item.id
                        }
                    })
                };
            },

        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
    });
</script>