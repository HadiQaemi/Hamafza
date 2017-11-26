<div class="text-content panel-light panel-body" style="padding: 10px;">
    <link href="{{App::make('url')->to('/')}}/theme/Content/css/magicsuggest.css" rel="stylesheet">
    <script src="{{App::make('url')->to('/')}}/theme/Scripts/magicsuggest-min.js"></script>
    <script type="text/javascript">
        $('.jsPanel-controlbar').append('<span class="jsPanel-btn help-icon-span" style="position: absolute;left: 116px;top: -3px;"><a href="<?php echo e(App::make('url')->to('/')); ?>/modals/helpview?id=17&tagname=abzartamas&hid=6" title="راهنمای اینجا" href="#" class="jsPanels icon-help HelpIcon" style="float: left;padding-left: 20px;" title="راهنمای اینجا" data-placement="top" data-toggle="tooltip"></a></span>');
//        function RemoveFile(obj) {
//            $(obj).parent().parent().parent().remove();
//        }
//        function FileName(obj, tar) {
//            var fileName = $(obj).val();
//            var fragment = fileName;
//            var array_fragment = fragment.split(/\\|\//);
//            fileName = $(array_fragment).last()[0];
//            pos = fileName.lastIndexOf('.');
//            fileName = fileName.substring(0, pos);
//            var top = $(obj).closest('span');
//            top.css("color", "red");
//            top.next('span').show();
//            top.next('span').children('input').val(fileName);
//            $(obj).closest('span').children('div').html('');
//            $(obj).closest('span').children('div').removeClass('btn');
//            $(obj).closest('span').children('div').removeClass('btn-default');
//            $(obj).closest('span').children('div').removeClass('btn-file');
//
//
//            //       $(obj).closest('span').children('div').addClass('icon-minus');
//
//
//            $("#add").trigger('click');
//        }
//
//        $('img#add').click(function () {
//            var i = parseInt($('#fileCount').val());
//            i++;
//
//            $('<tr><td style="padding-top: 5px;text-align:right;direction:rtl;border:none;"><span class=" btn-file" ><div id="FileTile[' + i + ']" class="btn btn-default btn-file" style="font-size:12pt;cursor: pointer" >افزودن فایل</div><input style="height: 30px;width: 100px" type="file" name="file[' + i + ']" onchange="FileName(this);" ></span><span class="descr" style="display:none;"><div class="DelFile icon-hazv" onclick="RemoveFile(this);" style="color: red;cursor: pointer !important;display: inline-block; height: 15px;width: 15px;"></div>  <input name="ftitle[' + i + ']" class="form-control" style="display: inline;max-width: 200px;" value="" /></span>  </td></tr>').appendTo('table#files');
//            $('#fileCount').val(i);
//
//        });
//        $('img#remove').click(function () {
//            var i = parseInt($('#fileCount').val());
//            if (i > 1) {
//                $('table#files tr:last').remove();
//                i--;
//            }
//        });
    </script>
    <form enctype="multipart/form-data" method="post" action="{{ route('hamafza.send_message') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

        {{--<span class="help-icon-span WindowHelpIcon">--}}
        {{--<a href="{{App::make('url')->to('/')}}/modals/helpview?id=17&tagname=abzartamas&hid=6" title="راهنمای اینجا" href="#" class="jsPanels icon-help HelpIcon" style="float: left;padding-left: 20px;" title="راهنمای اینجا"--}}
           {{--data-placement="top" data-toggle="tooltip">--}}
        {{--</a>--}}
    {{--</span>--}}

        <table class="table">
            <tr dir="rtl">
                <td dir="rtl" style="border:none;width: 100px">
                    گیرنده(گان)
                </td>
                <td style="border:none;">
                    <div class="col-xs-6" style="padding-right: 0; padding-left: 0">
                    <select id="message_jspanel_users_list" name="user_edits[]" data-placeholder="{{ trans('acl.select_user') }}" multiple="multiple" class="select-size-xs users_list col-xs-6"></select>
                    </div>
                    {{--<selecet id="manager" name="user_edits[]" multiple="multiple" required="" oninvalid="this.setCustomValidity('Please Enter valid email')" style="width: 350px;display: inline-block;"></selecet>--}}
                      {{--<script>--}}
                         {{--$('.users_list').magicSuggest({--}}
                             {{--data: "{{url('searchUser')}}",--}}
                             {{--dataUrlParams: {id: 34},--}}
                             {{--allowFreeEntries: false,--}}
                             {{--allowDuplicates: false,--}}
                             {{--hideTrigger: true,--}}
                             {{--required: true--}}
                         {{--});--}}

                         {{--var manager = $('.users_list').magicSuggest({});--}}
                     {{--</script>--}}


                    <div style="height: 10px; display: inline-block;">
                        <a href="{!! route('modals.setting_user_view', ['id_select'=>'message_jspanel_users_list']) !!}" title="انتخاب کاربران" class="jsPanels">
                            <span class="icon icon-afzoodane-fard fonts"></span>
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
                <td dir="rtl">
                    عنوان
                </td>
                <td>
                    <input type="text" name="title" required="" id="title" placeholder="" class="form-control">
                </td>
            </tr>
            <tr>
                <td style="border:none;">متن
                </td>
                <td style="border:none;">
                    <textarea name="comment" id="comment" class="form-control">سلام ! </textarea>
                </td>
            </tr>
            <tr>
                <td style="text-align:right;direction:rtl;" dir="rtl">
                    پیوست
                </td>
                <td style="text-align:right;direction:rtl;vertical-align:top;" dir="rtl">
                    <div class="col-lg-9">
                        <div class="row-fluid">
                            <div class="filemanager-buttons-client">
                                <div class="btn btn-default pull-right HFM_ModalOpenBtn" data-section="{{ enCode('message_file') }}" data-multi_file="Multi" style="margin-right: 5px;">
                                    <i class="glyphicon glyphicon-plus-sign" style="color: skyblue"></i>
                                    <span>{{trans('app.add_file')}}</span>
                                </div>
                                {{--<div data-section="{{ enCode(session('page_file')) }}"  class="HFM_RemoveAllFileFSS_SubmitBtn btn btn-default pull-left" style=" color:#555;">--}}
                                {{--<i class="glyphicon glyphicon-remove-sign" style=" color:#FF6600;"></i>--}}
                                {{--<span>{{trans('filemanager.remove_all_attachs')}}</span>--}}
                                {{--</div>--}}
                            </div>
                            <div class="pull-right filemanager-title-client">
                                {{--<h4 class="filemanager-title">{{trans('filemanager.attachs')}}</h4>--}}
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    {!! $HFM_message_file['ShowResultArea']['message_file'] !!}
                    {{--<input type="hidden" value="1" id="fileCount">--}}
                    {{--<table  class="atable" style="border:none;" width="100%" border="0" cellspacing="0" cellpadding="0" id="files">--}}
                    {{--<tr>--}}
                    {{--<td style="text-align:right;direction:rtl;border:none;">--}}
                    {{--<span  class="btn-file">--}}
                    {{--<div id="FileTile[1]" class="btn btn-default btn-file" style="font-size: 12pt;cursor: pointer" >افزودن فایل</div>--}}
                    {{--<input style="height: 30px;width: 100px" type="file" name="file[1]" onchange="FileName(this, '#FileTile[1]');">--}}
                    {{--</span>--}}
                    {{--<span class="descr" style="display: none;">--}}
                    {{--<div class="DelFile icon-hazv" onclick="RemoveFile(this);" style="color: red;cursor: pointer !important;display: inline-block; height: 15px;width: 15px;"></div>--}}
                    {{--<input name="ftitle[1]" class="form-control" style="display: inline;max-width: 200px;" value="" />--}}
                    {{--</span>--}}
                    {{--</td>--}}
                    {{--</tr>--}}
                    {{--</table>--}}
                    {{--<span style="display: none;"><img style="cursor:pointer" src="theme/images/add.png" id="add">&nbsp;<img style="cursor:pointer" id="remove" src="theme/images/remove.png"></span>--}}
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:left">
                    {{--<input type="hidden" name="fileCount" id="fileCount" value="1"/>--}}
                    <input type="submit" class="btn btn-primary FloatLeft primary_submit_btn_message hide" value="ارسال" name="measure_add">
                </td>
            </tr>
        </table>

    </form>
</div>
{!! $HFM_message_file['UploadForm'] !!}
{!! $HFM_message_file['JavaScripts'] !!}
<script>
    $(".users_list").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '100%',
        ajax: {
            url: "{{ route('auto_complete.users') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });
</script>