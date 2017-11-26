<div class="modal fade" id="modal_access_error" role="dialog">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color:darkgreen;"></h4>
            </div>
            <div class="modal-body">
                <span id="modal_massage">Msg</span>
            </div>
            <div class="modal-footer">
                <button type="button"  value="yes"
                        class="btn btn-info msg_modal_yes"
                        type="button">
                    <i class="glyphicon  glyphicon-save-file bigger-125"></i>
                    <span> بستن</span>
                </button>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#modal_access_error .msg_modal_yes').click(function(){
            $('#modal_access_error').modal('hide');
        });

    });

</script>
