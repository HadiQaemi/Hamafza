<div>
    <div class="space-4"></div>
    <form id="tools_new_roles_form">
        <div class="col-xs-12 pull-left">
            <input type="text" class="form-control" placeholder="عنوان دسته" id="new_tools_group_name" name="new_tools_group_name">
            <input type="text" id="add_edit_tools_group" hidden>
            <input type="text" id="edit_tools_group_id" hidden>
            {{--<button class="btn btn-primary btn_grid_add_new_tools_group" type="button">--}}
                {{--<i ></i>--}}
                {{--{{ trans('app.register')}}--}}
            {{--</button>--}}
            {{--<button class="btn btn-default btn_grid_add_new_tools_group_cancel hide" type="button">' +--}}
                {{--<i ></i>--}}
                {{--{{ trans('app.cancel')}}--}}
            {{--</button>--}}
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        $(".jsPanel-content").css("height", "100px");
        $(".jsPanel").css("height", "200px");
    });
</script>