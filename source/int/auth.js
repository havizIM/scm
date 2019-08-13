
const authController = (() => {
    const DOM = {
        form: {
            login: '#login_form',
            forgot: '#recover_form'
        },
        btn: {
            login: '#submit_login',
            forgot: '#submit_forgot_password'
        },
        etc: {
            show_pass: '#show_password'
        }
    }

    const submitLogin = () => {
        let {form, btn} = DOM

        $(form.login).validate({
            rules: {
                username: "required",
                password: "required"
            },
            submitHandler: function(form){
                $.ajax({
                    url: `${BASE_URL}int/auth/login`,
                    type: 'POST',
                    dataType: 'JSON',
                    data: $(form).serialize(),
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                        $(btn.login).addClass('disabled').html('<i class="fa fa-spinner fa-spin"></i>')
                    },
                    success: function (res) {
                        sessionStorage.setItem('INT-TOKEN', res.key);
                        window.location.replace(`${BASE_URL}${res.level}/`)
                    },
                    error: function (err) {
                        const { error } = err.responseJSON
                        makeNotif('error', 'Failed', error, 'bottom-right')
                    },
                    complete: function(){
                        $(btn.login).removeClass('disabled').html('Log In');
                    }
                })
            }
        })
    }

    const showPass = () => {
        $('.show_pass').click(function () {
            if ($(this).is(':checked')) {
                $('#password').attr('type', 'text');
            } else {
                $('#password').attr('type', 'password');
            };
        });
    }

    return {
        init: () => {
            submitLogin()
            showPass()
        }
    }
})();

$(document).ready(function(){
    authController.init();
})
