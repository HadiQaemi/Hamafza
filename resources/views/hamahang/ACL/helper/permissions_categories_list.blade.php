<div class="repeat">
    <div class="panel panel-body border-top-teal-300">
        <fieldset>
            <legend>
                <h6 class="panel-title">{{ $item['title'] }}<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
            </legend>
            <div class="row">
                <form id="form_get_Permission_roles" class="form-horizontal" action="#">
                    <input id="form{{ $type }}_id" type="hidden" name="item_id" value="{{ $type_id }}">

                    @foreach($item['permissions'] as $permission)

                        <div class="col-sm-3">
                            <div class="checkbox">
                                {{--{{$permissions}}--}}
                                @if(stristr($permissions," ".$permission['id']." "))
                                    <input id="selected_permission_roles{{ $permission['id'] }}" data-item_id="{{ $permission['id'] }}"
                                           value="{{ $permission['id'] }}" name="selected_permission_roles[]" disabled checked type="checkbox" data-type_id="{{ $type_id }}"
                                           class="styled checkbox_permissions" {!! checked_permission($permission["$type"], $type_id) !!}
                                    >
                                    <label>
                                @else
                                    {{--{{$permission['id']}}--}}
                                    {{--{{$permissions}}--}}
                                    {{--<br>--}}
<!--                                        --><?php //die();?>
                                    <input id="selected_permission_{{ $permission['id'] }}" data-item_id="{{ $permission['id'] }}"
                                           value="{{ $permission['id'] }}" name="selected_permission[]" type="checkbox" data-type_id="{{ $type_id }}"
                                           class="styled checkbox_permissions" {!! checked_permission($permission["$type"], $type_id) !!}
                                    >
                                    <label>
                                @endif

                                    {{ $permission['display_name'] }}
                                </label>
                            </div>
                        </div>
                    @endforeach

                    <div class="clearfixed"></div>
                </form>
            </div>
            <div class="children" style="margin-top: 15px; margin-right: 15px;">
                @if(isset($children))
                    {!! $children !!}
                @endif
            </div>
        </fieldset>
    </div>
</div>