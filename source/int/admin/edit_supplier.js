$(function () {

    const renderUI = (() => {
        return {
            renderData: (data) => {
                let group = '';
                let bank = '';

                $('#id_supplier').val(data.id_supplier)
                $('#nama_supplier').val(data.nama_supplier)
                $('#alamat').val(data.alamat)
                $('#telepon').val(data.telepon)
                $('#fax').val(data.fax)
                $('#npwp').val(data.npwp)
                $('#status_supplier').val(data.status_supplier)
                $('#email').val(data.email)

                $('#nama_pic').val(data.pic.nama_pic)
                $('#handphone').val(data.pic.handphone)
                $('#email_pic').val(data.pic.email_pic)
                $('#username').val(data.pic.username)

                $.each(data.supply_group, function(k, v){
                    group += `
                        <tr class="row_${v.id_group}">
                            <td>
                                ${v.nama_group}
                            </td>
                            <td>${v.lokasi_group}</td>
                            <td>
                                <input type="hidden" name="id_group[]" id="id_group" value="${v.id_group}">
                                <input type="hidden" name="nama_group[]" id="nama_group" value="${v.nama_group}">
                                <input type="hidden" name="lokasi_group[]" id="lokasi_group" value="${v.lokasi_group}">
                                <button class="btn btn-danger btn-sm remove_group" data-id="${v.id_group}"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    `
                })

                $.each(data.bank_account, function (k, v) {
                    bank += `
                        <tr class="row_bank_${v.no_rekening}">
                            <td> <input type="text" name="nama_bank[]"  id="nama_bank" class="form-control" value="${v.nama_bank}"> </td>
                            <td> <input type="text" name="cabang[]"  id="cabang" class="form-control" value="${v.cabang}"> </td>
                            <td> <input type="text" name="pemilik_account[]"  id="pemilik_account" class="form-control" value="${v.pemilik_account}"> </td>
                            <td> <input type="text" name="no_rekening[]"  id="no_rekening" class="form-control" value="${v.no_rekening}"> </td>
                            <td>
                                <button type="button" name="remove" class="btn btn-danger remove_bank" data-id="${v.no_rekening}"><span class="fa fa-minus"></span></button>
                            </td>
                        </tr>
                    `
                })

                $('#t_detail_group tbody').append(group)
                $('#t_detail_bank tbody').append(bank)
            }
        }
    })()

    const detailController = ((UI) => {
        const fetchData = () => {
            let ID_SUPPLIER = location.hash.substr(16);

            $.ajax({
                url: `${BASE_URL}int/supplier?id_supplier=${ID_SUPPLIER}`,
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
                    id_supplier: { required: true },
                    nama_supplier: { required: true },
                    alamat: { required: true },
                    telepon: { required: true },
                    fax: { required: true },
                    npwp: { required: true },
                    status_supplier: { required: true },
                    email: { required: true },

                    nama_pic: { required: true },
                    handphone: { required: true },
                    email_pic: { required: true },
                    username: { required: true }
                },
                submitHandler(form) {
                    $.ajax({
                        url: `${BASE_URL}int/supplier/edit`,
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
                            location.hash = '#/supplier'
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