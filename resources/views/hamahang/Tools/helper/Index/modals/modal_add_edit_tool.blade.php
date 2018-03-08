<div>
    <div class="container" style="width: 95%">
        <div id="tools-form-errMsg"></div>
        <form id="new-tool-form">
            <input type="text" name="tool_id" value="{{ isset($tool) ? enCode($tool->id) : '' }}" hidden>
            <table class="table col-md-12">
                <tr>
                    <td class="col-md-2">{{trans('tools.tool_title')}}</td>
                    <td class="col-md-10"><input type="text" name="title" class="form-control" value="{{ isset($tool) ? $tool->title : '' }}"/></td>
                </tr>
                <tr>
                    <td class="col-md-2">{{trans('tools.categories')}}</td>
                    <td class="col-md-10">
                        <select id="tools_groups_list" class="select" name="group_id" placeholder="انتخاب دسته"></select>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2">{{trans('tools.url')}}</td>
                    <td class="col-md-10">
                        <label><input type="radio" name="url_type" id="internal" value="1">{{trans('tools.internal')}} </label>
                        <label><input type="radio" name="url_type" id="external" value="2">{{trans('tools.external')}} </label>
                        <div class="url_from_av">
                            <select id="tools_availables_list" class="select" name="available_id" placeholder="انتخاب دسته"></select>
                        </div>
                        <div class="url_from_user"><input type="text" name="url" class="form-control" value="{{ isset($tool) ? $tool->url : '' }}"/></div>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2">{{trans('tools.show_in')}}</td>
                    <td class="col-md-10">
                        {{--                        {{ dd($tool->options->toArray()) }}--}}
                        <div id="options_holders">
                            @foreach($options as $option)
                                <input type="checkbox" name="options[]" value="{{ $option->id }}"
                                @if(isset($tool))
                                    @foreach($tool->options as $tool_option)
                                        {{ $option->id == $tool_option->id ? 'checked' : '' }}
                                            @endforeach
                                        @endif
                                >{{ $option->description }}<br>
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2">{{trans('tools.position')}}</td>
                    <td class="col-md-10">
                        <div id="position_holders">
                            @foreach($positions as $position)
                                <input type="checkbox" name="positions[]" value="{{ $position->id }}"
                                @if(isset($tool))
                                    @foreach($tool->positions as $tool_position)
                                        {{ $position->id == $tool_position->id ? 'checked' : '' }}
                                            @endforeach
                                        @endif
                                >{{ $position->description }}
                            @endforeach
                        </div>
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
                        <input name="icon" value="{{ isset($tool) ? $tool->icon : '' }}" class="form-control"></td>
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
                        <select name="roles_list[]" multiple="multiple" class="form-control roles_list">
                            <option value="3">public عمومی</option>
                        </select>
                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>
