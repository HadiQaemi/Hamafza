<link href="{{App::make('url')->to('/')}}/theme/Content/css/magicsuggest.css" rel="stylesheet">
<script src="{{App::make('url')->to('/')}}/theme/Scripts/magicsuggest-min.js"></script>
<form action="{{ route('hamafza.share_page') }}" method="post" name="comment_form" id="comment_form">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <span class="help-icon-span WindowHelpIcon">

<a href="{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=abzarbaznashr&hid=6" title="راهنمای اینجا" href="#" class="jsPanels icon-help HelpIcon" style="float: left;padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip">
</a></span>
<br>
    <table class="table" dir="ltr">
      @if($uid !='0')

        <tr dir="rtl">
            <td dir="rtl" style="border:none;">
                <select   id="selected_user" name="user_edits"   multiple style="width: 350px;display: inline-block;">

                </select>
                   {{-- <script>
                               $('#manager').magicSuggest({
                       data: "{{App::make('url')->to('/')}}/searchUser",
                               dataUrlParams: { id: 34 },
                               allowFreeEntries: false,
                               allowDuplicates: false,
                               hideTrigger: true
                       });
                               var manager = $('#manager').magicSuggest({});
                                         
                   </script> --}}

                   <div style="height: 10px; display: inline-block;">
                       <a href="{!! route('modals.setting_user_view',['id_select'=>'selected_user']) !!}" title="انتخاب کاربران" class="jsPanels">
                           <span class="icon icon-afzoodane-fard fonts"></span>
                       </a>
                   </div>

            </td>
            </td>
            <td style="width:150px ;border:none;">بازنشر فقط برای  </td> 
        </tr>
        @endif
        @if($uid=='0')
        <tr dir="rtl">
            <td dir="rtl" style="border:none;">
                <div style="width:450px;float:right;display: inline">
                    <input type="text"  class="form-control" name="recipientmail2" id="recipientmail2" placeholder="رایانامه را وارد کنید" class="chzn-select chzn-rtl" >
                    <input type="hidden"  class="text" name="recipientmail" id="recipientmail" ></div>
            </td>
            <td style="width:150px ;border:none;">ارسال به رایانامه </td> 
        </tr>
        @endif
 <tr>
            <td align="left" style="text-align:left">
                <!--<a target="_blank" href="{{App::make('url')->to('/')}}/{{$pid}}">{{App::make('url')->to('/')}}/{{$pid}}</a>-->
                
            </td>
            <td  align="right" >باز نشر صفحه: 
            
            @if(isset($_GET['title']) && $_GET['title']!='')
            {{$_GET['title']}}
            @endif
            </td>
        </tr>
        <tr>
            <td><textarea name="comment" id="comment" class="form-control "style="width:100%; height:120px; direction: rtl; text-align: justify; ">سلام ! 
                    <?php
                    if ($type == 'user') {
                        if ($uid == Session::get('uid'))
                            echo 'از شما دعوت می کنم صفحه شخصی من را در سامانه ببینید!';
                        else
                            echo 'سوابق و تخصص های این فرد ممکن است با موضوعات کاری و علاقه مندی های شما ارتباط داشته باشد،'
                            . ' صفحه شخصی او را در سامانه ببینید!';
                    }
                    elseif ($type == 'group') {
                        echo 'مباحث این گروه ممکن است با موضوعات کاری و علاقه مندی های شما ارتباط داشته باشد،'
                        . ' صفحه این گروه را در سامانه ببینید!';
                    } elseif ($type == 'subject') {
                        echo 'پیشنهاد می کنم این صفحه را ببینید!';
                        if(isset($_GET['seltext']) &&$_GET['seltext'] )
                            echo ' '.$_GET['seltext'];
                    } else {
                        echo Config::get('constants.SiteTitle') . ' قابلیت ها و مطالب ارزشمندی دارد، پیشنهاد می کنم این سامانه را ببینید و عضو آن شوید!';
                    }
                    ?>     
     
                    <?php
                    if ($select != '') {
                        echo $select;
                    }
                    ?></textarea></td>
            <td style="width:150px;text-align: right;">توضیح</td>
        </tr>
       
        <?php
        if ($uid == 0) {
            ?>                   
            <tr>
                <td dir="rtl">
                    <input type="text" class="form-control" name="sendername" id="sendername" placeholder="نام شما (برای اطلاع گیرنده)" >
                    <input type="text" class="form-control" name="sendermail" id="sendermail" placeholder="رایانامه شما (برای اطلاع گیرنده)" >
                </td>
                <td width="120">فرستنده</td>
            </tr>
            <?php
        }
       
        ?>
        <tr>
            <td colspan="2" style="text-align:left">

                @if ($uid != 0)
                <input type="hidden" name="sendername" id="sendername" value="{{ Session::get('Name')}}  {{ Session::get('Family')}}"  />
                <input type="hidden" name="sendermail" id="sendermail" value="{{Session::get('email')}}" />
                @endif
                <input type="hidden" name="suggest_add" id="suggest_add" value="suggest_add" />
                <input type="hidden" name="link" value="{{App::make('url')->to('/')}}/{{$pid}}">
                <input type="hidden" name="type" id="type" value="{{ $type}}" />
                <input type="hidden" name="tid" id="tid" value="{{ $sid }}" />
                <input type="hidden" name="tname" id="tname" value="" />
                <input type="submit" class="btn btn-primary" name="submit" value="ارسال "/>
            </td>

        </tr>
    </table>
</form>
<script>
    $("#selected_user").select2({
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