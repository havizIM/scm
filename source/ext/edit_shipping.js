$(function () {
    const renderUI = (() => {
        return {
            renderValue: function (data) {
                $('#no_shipping').val(data.no_shipping);
                $('#no_order').val(data.no_order);
                $('#tgl_shipping').val(data.tgl_shipping);
                $('#order').val(`${data.no_order} - ${data.supplier.nama_supplier}`);
            },
            renderDetail: (data) => {
                let html = '';

                $.each(data.detail, function (k, v) {
                    html += `
                        <tr>
                            <td>${v.id_product} - ${v.nama_product}</td>
                            <td>${v.qty} ${v.satuan}</td>
                            <td>
                                <input type="hidden" class="form-control" id="id_product" name="id_product[]" value="${v.id_product}" />
                                <input type="number" class="form-control" id="actual_qty" name="actual_qty[]" />
                            </td>
                        </tr>
                    `
                })

                $('#no_order').val(data.no_order);
                $('#order').val(`${data.no_order} - ${data.warehouse.nama_warehouse}`);
                $('#t_detail_order tbody').html(html);
                $('#modal_order').modal('hide');
            }
        }
    })()

    const detailController = ((UI) => {

        const renderOrder = (no_order) => {
            $.ajax({
                url: `${BASE_URL}ext/order?no_order=${no_order}`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
                },
                success: function (res) {
                    $.each(res.data, function (k, v) {
                        UI.renderDetail(v);
                    })
                },
                error: function (err) {
                    makeNotif('error', 'Failed', responseJSON.message, 'bottom-right')
                }
            })
        }
        
        const fetchData = () => {
            let ID_SHIPPING = location.hash.substr(16);

            $.ajax({
                url: `${BASE_URL}ext/shipping?no_shipping=${ID_SHIPPING}`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
                },
                success: function (res) {
                    $.each(res.data, function (k, v) {
                        UI.renderValue(v)
                        renderOrder(v.no_order);
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

        const submitForm = () => {
            $('#form_edit').validate({
                rules: {
                    no_shipping: "required",
                    no_order: "required",
                    tgl_shipping: "required"
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: `${BASE_URL}ext/shipping/edit`,
                        type: 'PUT',
                        dataType: 'JSON',
                        data: $(form).serialize(),
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
                            $('#submit_edit').html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        success: function (res) {
                            makeNotif('success', 'Success', res.message, 'bottom-right')
                            location.hash = '#/shipping'
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
                submitForm();
            }
        }

    })(renderUI)


    detailController.init();
})
