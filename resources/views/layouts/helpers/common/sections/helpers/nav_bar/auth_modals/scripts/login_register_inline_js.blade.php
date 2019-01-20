<script>
    $(document).ready(function () {

        $(document).on("click", ".login_captcha_refresh", function () {
            login_captcha_refresh();
        });

        $(document).on("click", ".uru_login_captcha_refresh", function () {
            uru_login_captcha_refresh();
        });

        $(document).on("click", ".homepage_login_captcha_refresh", function () {
            homepage_login_captcha_refresh();
        });

        $(document).on("click", ".homepage_forget_password_user", function () {
            $('#forgetpas').modal('show');
        });

        $(document).on("click", ".homepage_register_user", function () {
            alert('asdasdasda');
            $('#register').modal('show');
            // calendarModal = $.jsPanel({
            //     position: {my: "center-top", at: "center-top", offsetY: 80},
            //     // contentSize: {width: 1000, height: 600},
            //     panelSize: {width: 1000, height: 650},
            //     headerTitle: $('#register .modal-header').html(),
            //     content : $('#register .modal-body').html()
            // });
        });

        $(document).on("click", ".register_captcha_refresh", function () {
            register_captcha_refresh();
        });

        $(document).on("click", ".remember_pass_captcha_refresh", function () {
            remember_pass_captcha_refresh();
        });

        $(document).on("click", "#btn_modal_login", function () {
            var form_data = $('#modal_login_form').serialize();
            $('.inner_login_div').hide();
            $('.login_div').addClass('loader')
            $.ajax({
                type: "POST",
                url: '{{ route('login_user')}}',
                dataType: "json",
                data: form_data,
                success: function (result) {
                    if (result.success) {
                        $('.login_div').addClass('loader');
                        window.location = result.previous_url;
                    }
                    else {
                        $('#modal_login_captcha').val('');
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
                            $('#modal_login_fail_request_errors').html(result.error.login_failed);
                        }
                        else {
                            $('#modal_login_fail_request_errors').html('');
                        }
                    }
//                        messageModal('alert', 'خطا در ورود', result.error);
                }
            });
        });

        $(document).on("click", "#uru_btn_modal_login", function () {
            var form_data = $('#uru_modal_login_form').serialize();
            $('.uru_inner_login_div').hide();
            $('.uru_login_div').addClass('loader')
            $.ajax({
                type: "POST",
                url: '{{ route('login_user')}}',
                dataType: "json",
                data: form_data,
                success: function (result) {
                    if (result.success) {
                        $('.uru_login_div').addClass('loader');
                        window.location = result.previous_url;
                    }
                    else {
                        $('#uru_modal_login_captcha').val('');
                        $('.uru_login_div').removeClass('loader');
                        $('.uru_inner_login_div').show();
                        uru_login_captcha_refresh();
                        if (result.error.captcha_code) {
                            $('#uru_captcha_request_errors').html(result.error.captcha_code);
                        }
                        else {
                            $('#uru_captcha_request_errors').html('');
                        }
                        if (result.error.username) {
                            $('#uru_username_request_errors').html(result.error.username);
                        }
                        else {
                            $('#uru_username_request_errors').html('');
                        }
                        if (result.error.password) {
                            $('#uru_password_request_errors').html(result.error.password);
                        }
                        else {
                            $('#uru_password_request_errors').html('');
                        }
                        if (result.error.login_failed) {
                            $('#uru_modal_login_fail_request_errors').html(result.error.login_failed);
                        }
                        else {
                            $('#uru_modal_login_fail_request_errors').html('');
                        }
                    }
//                        messageModal('alert', 'خطا در ورود', result.error);
                }
            });
        });

        $(document).on('keydown', '#homepage_form_login', function(e)
        {
            if (13 == e.keyCode)
            {
                $('#btn_homepage_login_form').click();
            }
        });

        $(document).on('keydown', '#modal_login_form', function(e)
        {
            if (13 == e.keyCode)
            {
                $('#btn_modal_login').click();
            }
        });

        $(document).on("click", "#btn_homepage_login_form", function () {
            var form_data = $('#homepage_form_login').serialize();
            // $('.homepage_inner_login_div').hide();
            // $('.homepage_login_div').addClass('loader');
            $.ajax({
                type: "POST",
                url: '{{ route('login_user')}}',
                dataType: "json",
                data: form_data,
                success: function (result) {
                    if (result.success) {
                        $('.homepage_login_div').hide();
                        window.location = result.previous_url;
                    }
                    else
                        $('.homepage_login_div').removeClass('loader');
                    $('.homepage_inner_login_div').show();
                    homepage_login_captcha_refresh();
                    if (result.error.captcha_code) {
                        $('#homepage_captcha_request_errors').html(result.error.captcha_code);
                    }
                    else {
                        $('#homepage_captcha_request_errors').html('');
                    }
                    if (result.error.username) {
                        $('#homepage_username_request_errors').html(result.error.username);
                    }
                    else {
                        $('#homepage_username_request_errors').html('');
                    }
                    if (result.error.password) {
                        $('#homepage_password_request_errors').html(result.error.password);
                    }
                    else {
                        $('#homepage_password_request_errors').html('');
                    }
                    if (result.error.login_failed) {
                        $('#homepage_login_fail_request_errors').html(result.error.login_failed);
                    }
                    else {
                        $('#homepage_login_fail_request_errors').html('');
                    }
//                        messageModal('alert', 'خطا در ورود', result.error);
                }
            });
        });

        $(document).on("click", ".btn_modal_register", function () {
            var form_data = $('#modal_register_form').serialize();
            $('.inner_register_div').hide();
            $('.register_div').addClass('loader');
            $.ajax({
                type: "POST",
                url: '{{ route('register_user')}}',
                dataType: "json",
                data: form_data,
                success: function (result) {
                    if (result.success) {
                        $('.register_div').addClass('loader');
                        window.location = result.user_profile_url;
                    }
                    else {
                        $('#modal_register_captcha').val('');
                        $('.register_div').removeClass('loader');
                        $('.inner_register_div').show();
                        $('.modal_register_error_inputs').html('');
                        $('.modal_register_error_inputs').css('color', 'red');
                        console.log(result);
                        register_captcha_refresh();
                        if (result.error.captcha_code) {
                            $('#reg_captcha_request_errors').html(result.error.captcha_code);
                        }
                        else {
                            $('#reg_captcha_request_errors').html('');
                        }
                        if (result.error.username) {
                            $('#reg_username_request_errors').html(result.error.username);
                        }
                        else {
                            $('#reg_username_request_errors').html('');
                        }
                        if (result.error.email) {
                            $('#reg_email_request_errors').html(result.error.email);
                        }
                        else {
                            $('#reg_email_request_errors').html('');
                        }
                        if (result.error.password) {
                            $('#reg_password_request_errors').html(result.error.password);
                        }
                        else {
                            $('#reg_password_request_errors').html('');
                        }
                        if (result.error.name) {
                            $('#reg_name_request_errors').html(result.error.name);
                        }
                        else {
                            $('#reg_name_request_errors').html('');
                        }
                        if (result.error.family) {
                            $('#reg_family_request_errors').html(result.error.family);
                        }
                        else {
                            $('#reg_family_request_errors').html('');
                        }
                    }
//                        messageModal('alert', 'خطا در ثبت نام', result.error);
                }
            });
        });

        $(document).on("click", "#btn_modal_send_pass", function () {
            var form_data = $('#modal_remember_pass_form').serialize();
            $('.inner_remember_div').hide();
            $('.remember_div').addClass('loader');
            $.ajax({
                type: "POST",
                url: '{{ route('send_remember_password_email')}}',
                dataType: "json",
                data: form_data,
                success: function (result) {
                    if (result.success) {
                        $('.remember_div').addClass('loader');
                        window.location = "{{ route('home') }}";
                    }
                    else {
                        $('#modal_remember_password_captcha').val('');
                        $('.remember_div').removeClass('loader');
                        $('.inner_remember_div').show();
                        remember_pass_captcha_refresh();
                        if (result.error.captcha_code) {
                            $('#remember_captcha_request_errors').html(result.error.captcha_code);
                        }
                        else {
                            $('#remember_captcha_request_errors').html('');
                        }
                        if (result.error.email) {
                            $('#remember_email_request_errors').html(result.error.email);
                        }
                        else {
                            $('#remember_email_request_errors').html('');
                        }
                        if (result.error.login_failed) {
                            $('#homepage_login_fail_request_errors').html(result.error.login_failed);
                        }
                        else {
                            $('#homepage_login_fail_request_errors').html('');
                        }
//                        messageModal('alert', 'خطا در ارسال ایمیل', result.error);
                    }
                }
            });
        });

        $(document).on("click", "#modal_username_input", function () {
            $('#reg_username_request_errors').css('color', 'blue');
            $('#reg_username_request_errors').html('نام کاربری می‌تواند فقط شامل حروف و اعداد باشد.');
        });

        $(document).on("click", "#modal_email_input", function () {
            $('#reg_email_request_errors').css('color', 'blue');
            $('#reg_email_request_errors').html('فیلد پست الکترونیکی الزامی است.');
        });

        $(document).on("click", "#modal_password_input", function () {
            $('#reg_password_request_errors').css('color', 'blue');
            $('#reg_password_request_errors').html('کلمه عبور باید حداقل 8 کاراکتر باشد.');
        });

        $(document).on("click", "#modal_name_input", function () {
            $('#reg_name_request_errors').css('color', 'blue');
            $('#reg_name_request_errors').html('فیلد نام الزامی است.');
        });

        $(document).on("click", "#modal_family_input", function () {
            $('#reg_family_request_errors').css('color', 'blue');
            $('#reg_family_request_errors').html('فیلد نام خانوادگی الزامی است.');
        });

        $(document).on("click", "#modal_register_captcha", function () {
            $('#reg_captcha_request_errors').css('color', 'blue');
            $('#reg_captcha_request_errors').html('فیلد کد امنیتی الزامی است.');
        });
    });

    function login_captcha_refresh() {
        $('.login_captcha_image').attr('src', '{{ route('captcha', 'login') }}' + '?' + Math.random());
    }

    function uru_login_captcha_refresh() {
        $('.uru_login_captcha_image').attr('src', '{{ route('captcha', 'login') }}' + '?' + Math.random());
    }

    function homepage_login_captcha_refresh() {
        $('.homepage_login_captcha_image').attr('src', '{{ route('captcha', 'login') }}' + '?' + Math.random());
    }

    function register_captcha_refresh() {
        $('.register_captcha_image').attr('src', '{{ route('captcha', 'register') }}' + '?' + Math.random());
    }

    function remember_pass_captcha_refresh() {
        $('.remember_pass_captcha_image').attr('src', '{{ route('captcha', 'remember_password') }}' + '?' + Math.random());
    }
</script>