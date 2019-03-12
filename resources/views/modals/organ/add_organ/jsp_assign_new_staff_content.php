<div class="row">
    <div class="base_tabs">
        <div id="alert_insert"></div>
        <form id="Form_Add_Organ" >سسسسسسسسسسس
            <div class="row-fluid">
                <div class="form-group col-md-12">
                    <label>
                        <span class="required">*</span>
                        <span>{{ trans('app.title') }}</span>
                    </label>
                    <input name="organ_title" id="root_item_title" class="form-control" required placeholder=""/>
                </div>
                <div class="form-group col-md-12">
                    <label>
                        <span class="required">*</span>
                        <span>{{ trans('org_chart.parent') }}</span>
                    </label>
                    <select id="organ_parent" name="parent_organ" class="js-states form-control">

                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label> <span>{{ trans('app.description') }}</span></label>
                    <textarea name="organ_description" id="organ_description" class="form-control" placeholder=""></textarea>
                </div>
            </div>
        </form>
    </div>
</div>

