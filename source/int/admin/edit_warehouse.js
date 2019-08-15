$(function () {
    const renderUI = (() => {
        return {
            renderData: (data) => {

                $('#id_warehouse').val(data.id_warehouse)

                $('#id_group').val(data.group.id_group)
                $('#group').val(`${data.group.id_group} - ${data.group.nama_group}`)

                $('#id_user').val(data.user.id_user)
                $('#user').val(`${data.user.id_user} - ${data.user.nama_lengkap}`)

                $('#nama_warehouse').val(data.nama_warehouse)
                $('#alamat').val(data.alamat)
                $('#telepon').val(data.telepon)
                $('#fax').val(data.fax)
                $('#email').val(data.email)
            }
        }
    })()

    const detailController = ((UI) => {
        const fetchData = () => {
            let ID_WAREHOUSE = location.hash.substr(17);

            $.ajax({
                url: `${BASE_URL}int/warehouse?id_warehouse=${ID_WAREHOUSE}`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                },
                success: function (res) {
                    $.each(res.data, function (k, v) {
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
                    id_warehouse: { required: true },
                    id_group: { required: true },
                    id_user: { required: true },
                    nama_warehouse: { required: true },
                    alamat: { required: true },
                    telepon: { required: true },
                    fax: { required: true },
                    email: { required: true }
                },
                submitHandler(form) {
                    $.ajax({
                        url: `${BASE_URL}int/warehouse/edit`,
                        type: 'PUT',
                        dataType: 'JSON',
                        data: $(form).serialize(),
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                            $('#submit_edit').html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        success: function (res) {
                            makeNotif('success', 'Success', res.message, 'bottom-right')
                            location.hash = '#/warehouse'
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