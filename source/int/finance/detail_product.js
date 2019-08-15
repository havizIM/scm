$(function () {
    const renderUI = (() => {
        return {
            renderData: (data) => {

                $('#id_product').val(data.id_product)

                $('#id_category').val(data.id_category)
                $('#category').val(`${data.id_category} - ${data.nama_category}`)

                $('#id_supplier').val(data.id_supplier)
                $('#supplier').val(`${data.id_supplier} - ${data.nama_supplier}`)

                $('#nama_product').val(data.nama_product)
                $('#satuan').val(data.satuan)
                $('#harga').val(data.harga)
            }
        }
    })()

    const detailController = ((UI) => {
        const fetchData = () => {
            let ID_PRODUCT = location.hash.substr(15);

            $.ajax({
                url: `${BASE_URL}int/product?id_product=${ID_PRODUCT}`,
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
                    id_category: { required: true },
                    id_supplier: { required: true },
                    id_product: { required: true },
                    nama_product: { required: true },
                    satuan: { required: true },
                    harga: { required: true }
                },
                submitHandler(form) {
                    $.ajax({
                        url: `${BASE_URL}int/product/edit`,
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
                            location.hash = '#/product'
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