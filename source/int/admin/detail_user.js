$(function(){
    const renderUI = (() => {
        return {
            renderData: (data) => {
                const { alamat, email, id_user,
                    jenis_kelamin, level,
                    nama_lengkap, status,
                    telepon, username
                } = data;

                $('.nama_lengkap').val(nama_lengkap)
                $('.email').val(email)
                $('.telepon').val(telepon)
                $('.jk').val(jenis_kelamin)
                $('.alamat').val(alamat)
                $('.username').val(username)
                $('.level').val(level)
                $('.status').val(status)
                $('.id_user').val(id_user)
            }
        }
    })()

    const detailController = ((UI) => {
        const fetchData = () => {
            let ID_USER = location.hash.substr(12);

            $.ajax({
                url: `${BASE_URL}int/user?id_user=${ID_USER}`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                },
                success: function (res) {
                    $.each(res.data, function(k, v){
                        UI.renderData(v)
                    })
                },
                error: function (err) {
                    const { message } = err.responseJSON
                    makeNotif('error', 'Failed', message, 'bottom-right')
                },
                complete: function () {
                    
                }
            })
        }

        const submitEdit = () => {
            $('#form_edit').validate({
                rules: {
                    nama_lengkap: { required: true },
                    email: { required: true, email: true },
                    telepon: { required: true },
                    jenis_kelamin: { required: true },
                    alamat: { required: true },
                    username: { required: true },
                    level: { required: true },
                    status: { required: true }
                },
                submitHandler(form) {
                    $.ajax({
                        url: `${BASE_URL}int/user/edit`,
                        type: 'PUT',
                        dataType: 'JSON',
                        data: $(form).serialize(),
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                            $('#submit_edit').html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        success: function (res) {
                            makeNotif('success', 'Failed', res.message, 'bottom-right')
                            location.hash = '#/user'
                        },
                        error: function (err) {
                            const { message } = err.responseJSON
                            makeNotif('error', 'Failed', message, 'bottom-right')
                        },
                        complete: function () {
                            $('#submit_edit').html('Simpan');
                        }
                    })
                }
            })
        }

        return {
            init: () => {
                fetchData();
                submitEdit();
            }
        }
    })(renderUI)

    detailController.init();
})