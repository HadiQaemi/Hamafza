<div class="modal fade" id="modal_message_box" role="dialog" style="z-index:2147483647">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="modal_message">Msg</div>
            </div>
            <!--            <div class="modal-footer">-->
            <!--                <button type="button"  value="yes"-->
            <!--                        class="btn btn-success msg_modal_yes"-->
            <!--                        type="button">-->
            <!--                    <i class="glyphicon  glyphicon-save-file bigger-125"></i>-->
            <!--                    <span> بستن</span>-->
            <!--                </button>-->
            <!---->
            <!--            </div>-->
        </div>
    </div>
</div>
<script>


    $(document).ready(function () {
        $('#modal_message_box .msg_modal_yes').click(function () {
            $('#modal_message_box').modal('hide');
        });

    });


    function successFunc(lable, messages, selector, formId) {
        messageBox('success', lable, messages, selector, formId);
    }
    function errorsFunc(lable, messages, selector, formId) {
        messageBox('error', lable, messages, selector, formId);
    }
    /**
     @option    success or error
     @lable      title of modal
     @message    array of meeage to show
     **/
    function messageModal(option, lable, messages, onClose,onCloseData) {
        messageBox(option, lable, messages, 'modal',onCloseData);
        if (onClose) {
            $('#modal_message_box').on('hidden.bs.modal', function (onCloseData) {
                window[onClose](onCloseData);
            });
        }
    }
    /**
     @option    success or error
     @lable
     @message    array of meeage to show
     @selector  is object that  { 'class' :'className'} or {'id': 'idname'} else is empty this  in default msassagebox
     **/
    function messageBox(option, lable, messages, selector, formId) {
        var className = (option == 'success') ? 'alert  alert-success' : 'alert alert-danger';
        var modalTitleClassName = (option == 'success') ? 'bg-success' : 'bg-danger';
        var msg = messages;
        var msgStr = '';
        if ($.isArray(messages))
			msgStr = '<ul>';
        for (m in msg) {
            if (msg.hasOwnProperty(m)) {
				if ($.isArray(messages))
					msgStr += '<li>' + msg[m] + '</li>';
				else
					msgStr += msg[m];
            }
            $('#' + formId + ' input[name="' + m + '"]').css('borderColor', 'red');
        }
        if ($.isArray(messages))
			msgStr += '</ul>';
        var html = '<div id="alertMsg" class="' + className + ' fade in alert-dismissable" role="alert">' +
            '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>' +
            '<strong>' + lable + '</strong>' + msgStr + '</div>';
        var html_modal_alert = '<div id="alertMsg" class="' + className + ' fade in alert-dismissable" role="alert">' +
            msgStr + '</div>';

        if (selector == null) {
            // console.log(msgStr);
            $('.messageBox').html('');
            $('.messageBox').html(html);
        } else if (selector.class) {
            $('.' + selector.class).html('');
            $('.' + selector.class).html(html);
        } else if (selector.id) {
            $('#' + selector.class).html('');
            $('#' + selector.id).html(html);
        } else if (selector == 'modal') {
            $('#modal_message_box .modal-header').removeClass('bg-success');
            $('#modal_message_box .modal-header').removeClass('bg-danger');
            $('#modal_message_box .modal-header').addClass(modalTitleClassName);
            $('#modal_message_box .modal-title').text(lable);
            $('#modal_message_box .modal_message').html(html_modal_alert);
            $('#modal_message_box ul li').css({"list-style": "circle", "list-style-type": "circle", "margin-right": "15px"});
            $('#modal_message_box').modal({show: true});
        }
    }
    function closeBox(el) {
        $(el).parent().parent().html('');
    }
</script>
