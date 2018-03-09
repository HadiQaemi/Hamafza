<div class="modal-body">
    <div class="container " style="width: 95%">
        <div class="row">
            <form id="add_edit_menu_form" class="form-horizontal" action="#" method="post">
                <table class="table col-xs-12">
                    <tr>
                        <td class="col-xs-2">
                            <label class="control-label">{{trans('menus.menu_title')}}</label>
                        </td>
                        <td class="col-xs-10">
                            <input name="title" id="title" type="text" class="form-control" placeholder="{{trans('menus.menu_title')}}" value="{{ isset($menu) ? $menu->title : '' }}">
                            <input id="edit_form_item_id" type="hidden" name="item_id" value="{{ isset($menu) ? $menu->id : '' }}">
                        </td>
                    </tr>
                    <tr>
                        <td class="col-xs-2">
                            <label class="control-label">{{trans('menus.menu_description')}}</label>
                        </td>
                        <td class="col-xs-10">
                            <input name="description" id="description" type="text" class="form-control added_date" placeholder="{{trans('menus.menu_description')}}"  value="{{ isset($menu) ? $menu->description : '' }}">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
