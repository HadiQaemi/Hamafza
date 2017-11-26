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

        $(document).on("click", ".submit_login", function () {
            var form_data = $('#login_form').serialize();
            $('.inner_login_div').hide();
            $('.login_div').addClass('loader');
            $.ajax({
                type: "POST",
                url: '{{ route('login_user')}}',
                dataType: "json",
                data: form_data,
                success: function (result) {
                    if (result.success) {
//                        $('#login_div').hide();
                        $('.login_div').addClass('loader');
                        window.location = "{{ route('home') }}";
                    }
                    else {
                        $('#form_login_captcha').val('');
                        $('.login_div').removeClass('loader');
                        $('.inner_login_div').show();
                        login_captcha_refresh();
                        if (result.error.captcha_code) {
                            $('#captcha_request_errors').html(result.error.captcha_code);
                        }
                        else {
                            $('#captcha_request_errors').html('');
                        }
                        if (result.error.username) {
                            $('#username_request_errors').html(result.error.username);
                        }
                        else {
                            $('#username_request_errors').html('');
                        }
                        if (result.error.password) {
                            $('#password_request_errors').html(result.error.password);
                        }
                        else {
                            $('#password_request_errors').html('');
                        }
                        if (result.error.login_failed) {
                            $('#login_fail_request_errors').html(result.error.login_failed);
                        }
                        else {
                            $('#login_fail_request_errors').html('');
                        }
                    }
//                        messageModal('alert', 'خطا در ورود', result.error);
                }
            });
        });

        $(document).on("click", ".submit_register", function () {
            var form_data = $('#register_form').serialize();
            $('.inner_register_div').hide();
            $('.register_div').addClass('loader');
            $.ajax({
                type: "POST",
                url: '{{ route('register_user')}}',
                dataType: "json",
                data: form_data,
                success: function (result) {
                    if (result.success) {
                        $('#register_div').addClass('loader');
                        window.location = "{{ route('home') }}";
                    }
                    else {
                        $('#form_register_captcha').val('');
                        $('.register_div').removeClass('loader');
                        $('.inner_register_div').show();
                        $('.register_error_inputs').css('color', 'red');
                        register_captcha_refresh();
                        if (result.error.captcha_code) {
                            $('#captcha_request_errors').html(result.error.captcha_code);
                        }
                        else {
                            $('#captcha_request_errors').html('');
                        }
                        if (result.error.username) {
                            $('#username_request_errors').html(result.error.username);
                        }
                        else {
                            $('#username_request_errors').html('');
                        }
                        if (result.error.email) {
                            $('#email_request_errors').html(result.error.email);
                        }
                        else {
                            $('#email_request_errors').html('');
                        }
                        if (result.error.password) {
                            $('#password_request_errors').html(result.error.password);
                        }
                        else {
                            $('#password_request_errors').html('');
                        }
                        if (result.error.name) {
                            $('#name_request_errors').html(result.error.name);
                        }
                        else {
                            $('#name_request_errors').html('');
                        }
                        if (result.error.family) {
                            $('#family_request_errors').html(result.error.family);
                        }
                        else {
                            $('#family_request_errors').html('');
                        }
                    }
//                        messageModal('alert', 'خطا در ثبت نام', result.error);
                }
            });
        });

        $(document).on("click", ".submit_remember_password", function () {
            var form_data = $('#remember_password_form').serialize();
            $('.inner_remember_password_div').hide();
            $('.remember_password_div').addClass('loader');
            $.ajax({
                type: "POST",
                url: '{{ route('reset_forgotten_password')}}',
                dataType: "json",
                data: form_data,
                success: function (result) {
                    if (result.success) {
                        $('.remember_password_div').addClass('loader');
                        window.location = "{{ route('home') }}";
                    }
                    else {
                        $('#form_remember_password_captcha').val('');
                        $('.remember_password_div').removeClass('loader');
                        $('.inner_remember_password_div').show();
                        remember_password_captcha_refresh();
                        if (result.error.password) {
                            $('#remember_password_request_errors').html(result.error.password);
                        }
                        else {
                            $('#remember_password_request_errors').html('');
                        }
                        if (result.error.captcha_code) {
                            $('#remember_captcha_request_errors').html(result.error.captcha_code);
                        }
                        else {
                            $('#remember_captcha_request_errors').html('');
                        }
//                        messageModal('alert', 'خطا در تغییر کلمه عبور!', result.error);
                    }
                }
            });
        });

        $(document).on("click", "#form_username_input", function () {
            $('#username_request_errors').css('color', 'blue');
            $('#username_request_errors').html('نام کاربری می‌تواند فقط شامل حروف و اعداد باشد.');
        });

        $(document).on("click", "#form_email_input", function () {
            $('#email_request_errors').css('color', 'blue');
            $('#email_request_errors').html('فیلد پست الکترونیکی الزامی است.');
        });

        $(document).on("click", "#form_password_input", function () {
            $('#password_request_errors').css('color', 'blue');
            $('#password_request_errors').html('کلمه عبور باید حداقل دارای یک حرف کوچک، یک حرف بزرگ و یک عدد باشد و کلمه عبور نباید کمتر از 6 کاراکتر باشد.');
        });

        $(document).on("click", "#form_name_input", function () {
            $('#name_request_errors').css('color', 'blue');
            $('#name_request_errors').html('فیلد نام الزامی است.');
        });

        $(document).on("click", "#form_family_input", function () {
            $('#family_request_errors').css('color', 'blue');
            $('#family_request_errors').html('فیلد نام خانوادگی الزامی است.');
        });

        $(document).on("click", "#form_register_captcha", function () {
            $('#captcha_request_errors').css('color', 'blue');
            $('#captcha_request_errors').html('فیلد کد امنیتی الزامی است.');
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