$(function () {
    const renderUI = (() => {
        return {
            renderDetail: function (data) {
                let html = '';
                console.log(data);

                $('#no_order').val(data.no_order);
                $('#id_supplier').val(data.supplier.id_supplier);
                $('#supplier').val(`${data.supplier.id_supplier} - ${data.supplier.nama_supplier}`);
                
                $.each(data.detail, function(k, v){
                    html += `
                        <tr class="row_${v.id_product}">
                            <td>
                                ${v.id_product} - ${v.nama_product}
                                <input type="hidden" name="id_product[]" id="id_product" value="${v.id_product}">
                            </td>
                            <td>
                                <input type="number" name="harga[]" id="harga" class="form-control" readonly value="${v.harga}">
                            </td>
                            <td>
                                <input type="number" name="qty[]" id="qty" class="form-control count" value="${v.qty}">
                            </td>
                            <td>
                                <input type="text" name="total[]" id="total" class="form-control" readonly value="${v.total}">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove" data-id="${v.id_product}"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    `;
                })

                $('#t_detail_product tbody').append(html);
            }
        }
    })()

    const detailController = ((UI) => {
        const fetchData = () => {
            let ID_ORDER = location.hash.substr(13);
            $.ajax({
                url: `${BASE_URL}int/order?no_order=${ID_ORDER}`,
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
                    supplier: "required"
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: `${BASE_URL}int/order/edit`,
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
                            location.hash = '#/order'
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
