<div class="modal fade" id="confirm_modal" role="dialog"  style="z-index:2147483647">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color:red;">{{ trans('master.alert') }} </h4>
            </div>
            <div class="modal-body">
                <span class="modal_massage">{{ trans('master.sure_to_delete') }} </span>
            </div>
            <div class="modal-footer" style="border-top: 0px">
                <button type="button"  value="yes"
                        class="btn btn-danger yes_btn"
                        type="button">
                   {{-- <i class="glyphicon  glyphicon-save-file bigger-125"></i>--}}
                    <span>بلی</span>
                </button>
                <button type="button"  value="no"
                        class="btn no_btn"
                        type="button" style="background-color: #c0c0c0">
                   {{-- <i class="glyphicon  glyphicon-save-file bigger-125"></i>--}}
                    <span>{{ trans('app.no') }} </span>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
var confirmModal = function(options)
{
    $('#confirm_modal .yes_btn').off();
    $('#confirm_modal .no_btn').off();

    $('#confirm_modal .modal-title').html(options.title);
    $('#confirm_modal .modal_massage').html(options.message);
    $('#confirm_modal').modal('show');
    init= function(options)
    {
        $('#confirm_modal .yes_btn').bind('click',options,function(event){

         if(event.data.hasOwnProperty('onConfirm'))
         {
             event.data.onConfirm();
         }

           if( event.data.hasOwnProperty('afterConfirm') && event.data.afterConfirm=='close')
           {
               $('#confirm_modal').modal('hide');
           }
        });
        $('#confirm_modal .no_btn').bind('click',options,function(event){
           // console.log(event.data.hasOwnProperty('unConfirm'));
            if(event.data.hasOwnProperty('unConfirm'))
            {
                event.data.unConfirm();
            }else{

                $('#confirm_modal').modal('hide');
            }


        });
    };
    init(options);
};
</script>