<div class="modal-body">
    <div class="container " style="width: 95%">
        <div class="row">
            <form id="menu_item_form_created_new" class="form-horizontal" action="#">
                <input class="item_id" type="hidden" name="item_id" value="{{ isset($MenuItem) ? $MenuItem->id : '' }}">
                <input class="menu_id" type="hidden" name="menu_id" value="{{ isset($MenuItem) ? $MenuItem->menu_id : '' }}">
                <table class="table col-xs-12">
                    <tr>
                        <td class="col-xs-2">
                            <label class="control-label">{{trans('acl.parent')}}</label>
                        </td>
                        <td class="col-xs-10">
                            <select id="parent_list" class="select2 parent_list" name="parent" value="{{ isset($MenuItem) ? $MenuItem->parent_id : '' }}">
                                <option value="0">{{trans('acl.no_parent')}}</option>
                                {{--@foreach($menu_items as $menu_item)--}}
                                {{--<option value="{{ $menu_item->id }}">{{ $menu_item->title }}</option>--}}
                                {{--@endforeach--}}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-xs-2">
                            <label class="control-label">{{trans('menus.menu_title')}}</label>
                        </td>
                        <td class="col-xs-10">
                            <input name="title" type="text" class="form-control" placeholder="{{trans('menus.menu_title')}}" value="{{ isset($MenuItem) ? $MenuItem->title : '' }}">
                        </td>
                    </tr>
                    <tr>
                        <td class="col-xs-2">
                            <label class="control-label">{{trans('menus.menu_description')}}</label>
                        </td>
                        <td class="col-xs-10">
                            <input name="description" type="text" class="form-control added_date" placeholder="{{trans('menus.menu_description')}}" value="{{ isset($MenuItem) ? $MenuItem->description : '' }}">
                        </td>
                    </tr>
                    <tr>
                        <td class="col-xs-2 link_type">
                            <label class=" control-label">{{trans('menus.link_type')}}</label>
                        </td>
                        <td class="col-xs-10">
                            <label class="radio-inline">
                                <input type="radio" name="link_type" value="0" disabled>{{trans('menus.internal')}}<br>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="link_type" value="1" checked>{{trans('menus.external')}}<br>
                            </label>
                        </td>
                    </tr>
                    {{--<tr class="route_variables">--}}
                    {{--<td class="col-xs-2">--}}
                    {{--<label class="control-label">{{trans('menus.route_variables')}}</label>--}}

                    {{--</td>--}}
                    {{--<td class="col-xs-10">--}}
                    {{--<div id="route_variables"></div>--}}
                    {{--</td>--}}
                    {{--</tr>--}}
                    <tr class="route_name_div">
                        <td class="col-xs-2">
                            <label class="control-label">{{trans('menus.link_address')}}</label>
                        </td>
                        <td class="col-xs-10">
                            <input name="link_address" id="route_name" class="form-control link_address" placeholder="{{trans('menus.link_address')}}" value="{{ isset($MenuItem) ? $MenuItem->href : '' }}">
                        </td>
                    </tr>
                    <tr>
                        <td class="col-xs-2">
                            <label class="control-label">{{trans('menus.link_opening_type')}}</label>
                        </td>
                        <td class="col-xs-10">
                            <label class="radio-inline">
                                <input type="radio" name="target" value="_blank" checked>{{trans('menus.open_in_new_window')}}<br>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="target" value="_self">{{trans('menus.open_in_current_window')}}<br>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-xs-2">
                            <label class="control-label">{{trans('menus.show_status')}}</label>
                        </td>
                        <td class="col-xs-10">
                            <label>
                                <input name="status" type="checkbox" class="switchery" checked="checked">
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-xs-2">
                            <label class="control-label">{{trans('menus.icon')}}</label>
                        </td>
                        <td class="col-xs-10">
                            <input name="icon" id="" class="form-control" placeholder="{{trans('menus.icon')}}" value="{{ isset($MenuItem) ? $MenuItem->icon : '' }}">
                        </td>
                    </tr>
                    <tr>
                        <td class="col-xs-2">
                            <span style="color: blue; font-size: 14px;">مجوز ها: </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-xs-2">
                            <label class="control-label">کاربر</label>
                        </td>
                        <td class="col-xs-10">
                            {{--<select name="users_list[]" id="add_new_users_list" multiple="multiple" data-placeholder="{{ trans('menus.select_user') }}" class="select-size-xs form-control roles_list_setting_edit" >--}}
                            {{--@if(!empty($subjects->role_policies_edit))--}}
                            {{--@foreach($subjects->role_policies_edit as $subject)--}}
                            {{--<option selected="selected" value="{{ $subject->id }}">{{ $subject->name.' '.$subject->display_name }}</option>--}}
                            {{--@endforeach--}}
                            {{--@endif--}}
                            {{--</select>--}}
                            <a href="{!! route('modals.setting_user_view',['id_select'=>'roles_list_setting_edit']) !!}" title="انتخاب کاربران" class="jsPanels">
                                <span class="icon icon-afzoodane-fard fonts"></span>
                            </a>
                            <select name="users_list[]" id="add_new_users_list" multiple="multiple" data-placeholder="{{ trans('menus.select_user') }}" class="select-size-xs users_list"></select>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-xs-2">
                            <label class="control-label">نقش</label>
                        </td>
                        <td class="col-xs-10">
                            <select name="roles_list[]" id="add_new_roles_list" multiple="multiple" class="form-control roles_list"></select>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<script>

    $(document).ready(function () {

        $('.menu_id').val($('.add_edit_menu_items').attr('menu_id'));
        $(".parent_list").select2({
            minimumInputLength: 2,
            dir: "rtl",
            width: '100%',
            ajax: {
                url: "{{ route('auto_complete.menu_items') }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term.term,
                        menu_id: $('.menu_id').val()
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
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
        $(".roles_list").select2({
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
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        });
        $(".parent_list_for_filter").select2({
            minimumInputLength: 2,
            dir: "rtl",
            width: '100%',
            ajax: {
                url: "{{ route('auto_complete.menu_items') }}",
                dataType: 'json',
                type: "POST",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term.term,
                        menu_id: $('.menu_id').val(),
                        filter_items_by_parent:true
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
        var PermittedUsers = {!! json_encode($PermittedUsers) !!};
        $('#add_new_users_list').html('');
        var users_list = PermittedUsers;
        for (var k in users_list) {
            $("#add_new_users_list").select2("trigger", "select", {
                data: {id: users_list[k].user_id, text: users_list[k].Name + ' ' + users_list[k].Family}
            });
        }

        var PermittedRoles = {!! json_encode($PermittedRoles) !!};
        $('#add_new_roles_list').html('');
        var roles_list = PermittedRoles;
        for (var n in roles_list) {
            console.log(roles_list);
            $("#add_new_roles_list").select2("trigger", "select", {
                data: {id: roles_list[n].role_id, text: roles_list[n].name + ' (' + roles_list[n].display_name + ')'}
            });
        }
    });
</script>

