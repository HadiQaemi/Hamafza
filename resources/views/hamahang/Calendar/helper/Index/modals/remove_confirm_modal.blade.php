<div class="modal fade" id="remove_confirm_modal" role="dialog">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color:red;">{{ trans('app.alert') }}</h4>
            </div>
            <div class="modal-body">
                <span id="modal_massage">{{ trans('app.sure_to_delete') }}</span>
            </div>
            <div class="modal-footer">
                <button type="button"  value="yes"
                        class="btn btn-info yes_no_btn"
                        type="button">
                    <i class="glyphicon  glyphicon-save-file bigger-125"></i>
                    <span>{{ trans('app.yes') }}</span>
                </button>
                <button type="button"  value="no"
                        class="btn btn-danger yes_no_btn"
                        type="button">
                    <i class="glyphicon  glyphicon-save-file bigger-125"></i>
                    <span>{{ trans('app.no') }}</span>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.yes_no_btn').click(function(){
            if($(this).val()=='no')
            {
                $('#remove_confirm_modal').modal('hide');
            }

        });
        /*$('#remove_confirm_modal').on('show.bs.modal', function () {
            var lastZIndex = getLastZIndex();
            //console.log(lastZIndex);
            $('#remove_confirm_modal').css('z-index',lastZIndex+150);
        });*/

    });

    /*function getLastZIndex(){
        var maxZ = Math.max.apply(null,$.map($('body > *'), function(e,n){
                    if($(e).css('position')=='absolute')
                        return parseInt($(e).css('z-index'))||1 ;
                })
        );
        return (maxZ);
    }*/
</script>