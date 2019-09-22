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

        const getOrder = () => {
            $.ajax({
                url: `${BASE_URL}ext/order`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
                },
                success: function(res){
                    let open_order = res.data.filter((order) => order.status_order === 'Open');

                    if(open_order.length !== 0){
                        let html = `
                            <a href="#/order" class="item_notif">
                                <div class="btn btn-info btn-circle"><i class="fas fa-inbox"></i></div>
                                <div class="mail-contnet">
                                    <h5>New Order</h5> <span class="mail-desc">Anda memiliki ${open_order.length} Order baru.</span>
                                </div>
                            </a>
                        `

                        $('#notif .remove_item').remove();
                        $('#notif').append(html);
                    }
                },
                error: function(err){
                    console.log(err);
                }
            })
        }

        const getPayment = () => {
            $.ajax({
                url: `${BASE_URL}ext/payment`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
                },
                success: function (res) {
                    let open_payment = res.data.filter((payment) => payment.status_payment === 'Open');

                    if (open_payment.length !== 0) {
                        let html = `
                            <a href="#/payment" class="item_notif">
                                <div class="btn btn-danger btn-circle"><i class="fas fa-file-invoice-dollar"></i></div>
                                <div class="mail-contnet">
                                    <h5>New Payment</h5> <span class="mail-desc">Anda memiliki ${open_payment.length} Payment baru.</span>
                                </div>
                            </a>
                        `

                        $('#notif .remove_item').remove();
                        $('#notif').append(html);
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            })
        }

        const cekItem = () => {
            let item = $('#notif .item_notif');

            if(item.length === 0){
                let html = `
                    <div class="text-center remove_item" style="margin-top: 100px"> 
                        <h4>Tidak ada Notifikasi</h4>
                    </div>
                `

                $('#notif').html(html);
            }
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

                getOrder();
                getPayment();

                cekItem();

                btnLogout();
                btnSetting();
                submitPass();
            }
        }
    })()

    mainController.init();
})
