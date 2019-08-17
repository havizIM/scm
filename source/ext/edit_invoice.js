$(function () {
    const renderUI = (() => {
        return {
            renderValue: function (data) {
                $('#no_invoice').val(data.no_invoice);
                $('#no_order').val(data.no_order);
                $('#order').val(`${data.no_order} - ${data.supplier.nama_supplier}`);
                $('#tgl_tempo').val(data.tgl_tempo);
            },
            renderDetail: (data) => {
                let html = '';
                let subtotal = 0;
                let ppn = 0;
                let grandtotal = 0;

                $.each(data.detail, function (k, v) {
                    let total = parseInt(v.qty * v.harga);
                    subtotal += parseInt(total);

                    html += `
                        <tr>
                            <td>${v.id_product} - ${v.nama_product}</td>
                            <td class="text-right">Rp. ${v.harga}</td>
                            <td class="text-right">${v.qty} ${v.satuan}</td>
                            <td class="text-right">
                                Rp. ${total}

                                <input type="hidden" class="form-control" id="deskripsi" name="deskripsi[]" value="${v.id_product} - ${v.nama_product}" />
                                <input type="hidden" class="form-control" id="harga" name="harga[]" value="${v.harga}"/>
                                <input type="hidden" class="form-control" id="qty" name="qty[]" value="${v.qty}"/>
                                <input type="hidden" class="form-control" id="total_harga" name="total_harga[]" value="${v.harga * v.qty}" />
                            </td>
                        </tr>
                    `
                })

                html += `
                    <tr>
                        <th colspan="3" class="text-right">Sub Total</th>
                        <td class="text-right">Rp. ${subtotal}</td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">Tax</th>
                        <td class="text-right">Rp. ${ppn = subtotal * 0.10}</td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">Grand Total</th>
                        <td class="text-right">Rp.${parseInt(subtotal + ppn)} </td>
                    </tr>
                `

                $('#no_order').val(data.no_order);
                $('#order').val(`${data.no_order} - ${data.warehouse.nama_warehouse}`);
                $('#t_detail_order tbody').html(html);
                $('#modal_order').modal('hide');
            }
        }
    })()

    const detailController = ((UI) => {

        const fetchOrder = (no_order) => {
            $.ajax({
                url: `${BASE_URL}ext/shipping?no_order=${no_order}`,
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
            let ID_INVOICE = location.hash.substr(15);

            $.ajax({
                url: `${BASE_URL}ext/invoice?no_invoice=${ID_INVOICE}`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
                },
                success: function (res) {
                    $.each(res.data, function (k, v) {
                        UI.renderValue(v)
                        fetchOrder(v.no_order)
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
                    no_order: "required",
                    tgl_tempo: "required"
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: `${BASE_URL}ext/invoice/edit`,
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
                            location.hash = '#/invoice'
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
