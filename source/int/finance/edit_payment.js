$(function () {
    const renderUI = (() => {
        return {
            renderDetail: function (data) {
                console.log(data);
                let html = '';

                $('#no_payment').val(data.no_payment);
                $('#id_account').val(data.account.id_account);
                $('#tgl_payment').val(data.tgl_payment);
                $('#total_bayar').val(data.total_bayar);
                $('#bank_account').val(`${data.supplier.nama_supplier} (${data.account.no_rekening} - ${data.account.nama_bank})`);

                $.each(data.detail, function(k, v){
                    html += `
                        <tr class="row_${v.no_invoice}">
                            <td>
                                ${v.no_invoice} - ${v.nama_supplier}
                                <input type="hidden" name="no_invoice[]" id="no_invoice" value="${v.no_invoice}">
                            </td>
                            <td>
                                <input type="number" name="total_hutang[]" id="total_hutang" class="form-control" readonly value="${v.hutang}">
                            </td>
                            <td>
                                <input type="number" name="jml_bayar[]" id="jml_bayar"  value="${v.jml_bayar}" class="form-control">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove" data-id="${v.no_invoice}"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    `
                })

                $('#t_detail_payment tbody').append(html);
            }
        }
    })()

    const detailController = ((UI) => {
        const fetchData = () => {
            let ID_PAYMENT = location.hash.substr(15);

            $.ajax({
                url: `${BASE_URL}int/payment?no_payment=${ID_PAYMENT}`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                },
                success: function (res) {
                    $.each(res.data, function (k, v) {
                        UI.renderDetail(v)
                    })
                },
                error: function (err) {
                    const {
                        message
                    } = err.responseJSON
                    makeNotif('error', 'Failed', message, 'bottom-right')
                },
                complete: function () {

                }
            })
        }

        const submitEdit = () => {
            $('#form_edit').validate({
                rules: {
                    "id_account": "required",
                    "tgl_payment": "required",
                    "total_bayar": "required",
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: `${BASE_URL}int/payment/edit`,
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
                            location.hash = '#/payment';
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
            init: function () {
                fetchData();
                submitEdit();
            }
        }

    })(renderUI)


    detailController.init();
})
