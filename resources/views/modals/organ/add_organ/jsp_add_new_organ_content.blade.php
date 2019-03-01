<div class="row">
    <div class="base_tabs">
        <div id="alert_insert"></div>
        <form id="Form_Add_Organ" >
            <div class="row col-lg-12 margin-top-20">
                <div class="form-group col-xs-1 col-md-1 col-sm-1 line-height-35">
                    {{ trans('app.title') }}
                </div>
                <div class="form-group col-xs-11 col-md-11 col-sm-11">
                    <input placeholder="{{ trans('app.title') }}" name="organ_title" id="item_title" class="form-control" required placeholder=""/>
                </div>
            </div>
            <div class="row col-lg-12">
                <div class="form-group col-xs-1 col-md-1 col-sm-1 line-height-35">
                    {{ trans('org_chart.description') }}
                </div>
                <div class="form-group col-xs-11 col-md-11 col-sm-11">
                    <textarea placeholder="{{ trans('org_chart.description') }}" rows="4" name="organ_description" id="item_organ_description" class="form-control" required placeholder=""></textarea>
                </div>
            </div>
        </form>
    </div>
</div>

