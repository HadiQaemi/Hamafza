<div class="modal fade" tabindex="-1" id="tools_add" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span>ابزار جدید</span>:
                    <span class="bg-warning" id="modal_header_item_title" style="padding:2px 10px; margin-right: 10px;"></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="container " style="width: 95%">
                    <div id="tools-form-errMsg"></div>
                    <form id="new-tool-form">
                        <table class="table  col-md-12">
                            <tr>
                                <td class="col-md-2">{{trans('tools.tool_title')}}</td>
                                <td class="col-md-10"><input type="text" name="title" class="form-control"/></td>
                            </tr>
                            <tr>
                                <td class="col-md-2">{{trans('tools.categories')}}</td>
                                <td class="col-md-10"><select name="menuid"></select></td>
                            </tr>
                            <tr>
                                <td class="col-md-2">{{trans('tools.url')}}</td>
                                <td class="col-md-10">
                                    <label><input type="radio" name="url_type" checked value="1">{{trans('tools.internal')}} </label>
                                    <label><input type="radio" name="url_type" value="2">{{trans('tools.external')}} </label>
                                    <div class="url_from_av">
                                        <select name="available_id"></select>
                                    </div>
                                    <div class="url_from_user"><input type="text" name="url" class="form-control" /></div>


                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2">{{trans('tools.show_in')}}</td>
                                <td class="col-md-10 options_holders">


                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-2">{{trans('tools.postion')}}</td>
                                <td class="col-md-10 position_holders">

                                </td>
                            </tr>
                            {{--<tr>--}}
                            {{--<td class="col-md-2"></td>--}}
                            {{--<td class="col-md-10"><label><input type="checkbox" name="desktop"  />{{trans('tools.dessktop_lable')}}<lable></lable></td>--}}
                            {{--</tr>--}}
                            <tr>
                                <td class="col-md-2">{{trans('tools.icons')}}</td>
                                <td class="col-md-10">
                                    <p class="form-text text-muted">{{trans('tools.icon_sample')}}</p>
                                    <input name="icon" value="" class="form-control"> </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="col-xs-12">
                                    <span style="color: blue; font-size: 14px;">مدیریت سطح دسترسی: </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-xs-2">
                                    {{trans('menus.add_user')}}
                                </td>
                                <td class="col-xs-10">
                                    <select name="users_list[]" multiple="multiple" class="form-control users_list"></select>
                                </td>
                            </tr>

                            <tr>
                                <td class="col-xs-2">
                                    {{trans('menus.add_role')}}
                                </td>
                                <td class="col-xs-10">
                                    <select name="roles_list_tools[]" multiple="multiple" class="form-control roles_list_tools" >
                                        <option value="3">public عمومی</option>
                                    </select>
                                </td>
                            </tr>

                        </table>
                        <input name="edit_id" value="" type="hidden"/>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" name="saveTools" id="saveTools" value="save"
                        class="btn btn-info"
                        type="button">
                    <i class="glyphicon  glyphicon-save-file bigger-125"></i>
                    <span>ذخیره</span>
                </button>
            </div>
        </div>
    </div>
</div>

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
                console.log(data);
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });
    $(".roles_list_tools").select2({
        minimumInputLength: 2,
        dir: "rtl",
        width: '100%',
        ajax: {
            url: "{{ route('auto_complete.roles') }}",
            dataType: 'json',
            type: "POST",
            quietMillis: 50,
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                console.log(data);
                var a =true;
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });

</script>
