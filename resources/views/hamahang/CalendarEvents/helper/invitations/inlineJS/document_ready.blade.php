<script>
    $(document).ready(function () {
        $("#add_seesion_dialog").on('hidden.bs.modal', function () {
            $("#form-event-content").css('display','block');
        });
        $("#add_invitation_dialog").on('hidden.bs.modal', function () {
            $("#form-user-event-invitation").css('display','block');
        });
        $("#new_reminder_dialog").on('hidden.bs.modal', function () {
            $("#form-reminder-content").css('display','block');
        });

    });
</script>