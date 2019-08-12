$(function () {
    const mainController = (() => {
        const DOM = {
            page: '#page'
        }

        const loadContent = (link) => {
            let path = link.substr(2);
            $.get(`${BASE_URL}supplier/${path}`, function (html) {
                $(DOM.page).html(html);
            });
        }

        const setRoute = () => {
            let link;

            if (!location.hash) {
                location.hash = '#/dashboard';
            } else {
                link = location.hash;
                loadContent(link);
            }

            $(window).on('hashchange', function () {
                link = location.hash;
                loadContent(link);
            });
        }

        const btnLogout = () => {
            $('#logout').on('click', function () {
                sessionStorage.removeItem('EXT-TOKEN')
                window.location.replace(`${BASE_URL}`)
            })
        }

        const btnSetting = () => {
            $('#setting').on('click', function () {
                $('#form_pass')[0].reset();
                $('#modal_setting').modal('show');
            })
        }

        const submitPass = () => {
            $('#form_pass').validate({
                rules: {
                    old_password: "required",
                    new_password: "required",
                    conf_password: {
                        required: true,
                        equalTo: '#new_password'
                    }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: `${BASE_URL}ext/setting/change_pass`,
                        type: 'PUT',
                        dataType: 'JSON',
                        data: $(form).serialize(),
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
                            $('#submit_pass').addClass('disabled').html('<i class="fa fa-spinner fa-spin"></i>')
                        },
                        success: function (res) {
                            makeNotif('success', 'Success', res.message, 'bottom-right')
                            $('#modal_setting').modal('hide');
                        },
                        error: function (err) {
                            const { error } = err.responseJSON
                            makeNotif('error', 'Failed', error, 'bottom-right')
                        },
                        complete: function () {
                            $('#submit_pass').removeClass('disabled').html('Log In');
                        }
                    })
                }
            })
        }

        return {
            init: () => {
                setRoute();
                btnLogout();
                btnSetting();
                submitPass();
            }
        }
    })()

    mainController.init();
})
