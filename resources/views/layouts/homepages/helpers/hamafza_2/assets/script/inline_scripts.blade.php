<script>
    $(document).ready(function () {

        $(document).on("click", ".login_captcha_refresh", function () {
            login_captcha_refresh();
        });

        $(document).on("click", ".register_captcha_refresh", function () {
            register_captcha_refresh();
        });

        $(document).on("click", ".remember_password_captcha_refresh", function () {
            remember_password_captcha_refresh();
        });

        $(document).on("click", ".homepage_modal_remember_password_form", function () {
            $('#forgetpas').modal('show');
        });

        $(document).on("click", ".homepage_modal_register_form", function () {
            $('#register').modal('show');
        });

        $(document).on("click", ".homepage_modal_login_form", function () {
            $('#login').modal('show');
        });

        $(document).on("click", ".btn_homepage_login", function () {
            var form_data = $('#homepage_login_form').serialize();
            $('.inner_login_div').hide();
            $('.login_div').addClass('loader')
            $.ajax({
                type: "POST",
                url: '{{ route('login_user')}}',
                dataType: "json",
                data: form_data,
                success: function (result) {
                    if (result.success) {
                        $('#login_div').hide();
                        window.location = "{{ route('home') }}";
                    }
                    else
                        $('.login_div').removeClass('loader');
                    $('.inner_login_div').show();
                    login_captcha_refresh();
                    if(result.error.captcha_code){
                        $('#captcha_request_errors').html(result.error.captcha_code);
                    }
                    else{
                        $('#captcha_request_errors').html('');
                    }
                    if(result.error.username){
                        $('#username_request_errors').html(result.error.username);
                    }
                    else{
                        $('#username_request_errors').html('');
                    }
                    if(result.error.password){
                        $('#password_request_errors').html(result.error.password);
                    }
                    else{
                        $('#password_request_errors').html('');
                    }
                    if(result.error.login_failed){
                        $('#login_fail_request_errors').html(result.error.login_failed);
                    }
                    else{
                        $('#login_fail_request_errors').html('');
                    }
//                        messageModal('alert', 'خطا در ورود', result.error);
                }
            });
        });

        $(document).on("click", ".submit_register", function () {
            var form_data = $('#register_form').serialize();
            $('.inner_register_div').hide();
            $('.register_div').addClass('loader')
            $.ajax({
                type: "POST",
                url: '{{ route('register_user')}}',
                dataType: "json",
                data: form_data,
                success: function (result) {
                    if (result.success) {
                        $('#register_div').hide();
                        window.location = "{{ route('home') }}";
                    }
                    else
                        $('.register_div').removeClass('loader');
                    $('.inner_register_div').show();
                    register_captcha_refresh();
                    if(result.error.captcha_code){
                        $('#captcha_request_errors').html(result.error.captcha_code);
                    }
                    else{
                        $('#captcha_request_errors').html('');
                    }
                    if(result.error.username){
                        $('#username_request_errors').html(result.error.username);
                    }
                    else{
                        $('#username_request_errors').html('');
                    }
                    if(result.error.email){
                        $('#email_request_errors').html(result.error.email);
                    }
                    else{
                        $('#email_request_errors').html('');
                    }
                    if(result.error.password){
                        $('#password_request_errors').html(result.error.password);
                    }
                    else{
                        $('#password_request_errors').html('');
                    }
                    if(result.error.name){
                        $('#name_request_errors').html(result.error.name);
                    }
                    else{
                        $('#name_request_errors').html('');
                    }
                    if(result.error.family){
                        $('#family_request_errors').html(result.error.family);
                    }
                    else{
                        $('#family_request_errors').html('');
                    }
//                        messageModal('alert', 'خطا در ثبت نام', result.error);
                }
            });
        });

        $(document).on("click", ".submit_remember_password", function () {
            var form_data = $('#remember_password_form').serialize();
            $.ajax({
                type: "POST",
                url: '{{ route('reset_forgotten_password')}}',
                dataType: "json",
                data: form_data,
                success: function (result) {
                    register_captcha_refresh();
                    if (result.success)
                        window.location = "{{ route('home') }}";
                    else
                        messageModal('alert', 'خطا در ثبت نام', result.error);
                }
            });
        });

    });

    function login_captcha_refresh() {
        $('.login_captcha_image').attr('src', '{{ route('captcha', 'login') }}' + '?' + Math.random());
    }

    function register_captcha_refresh() {
        $('.register_captcha_image').attr('src', '{{ route('captcha', 'register') }}' + '?' + Math.random());
    }

    function remember_password_captcha_refresh() {
        $('.remember_password_captcha_image').attr('src', '{{ route('captcha', 'remember_password') }}' + '?' + Math.random());
    }
</script>