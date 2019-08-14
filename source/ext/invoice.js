console.log('Invoice is running...')

$(function () {
    const renderUI = (() => {
        return {
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

    const invoiceController = ((UI) => {

        const MYTABLE = $('#t_invoice').DataTable({
            columnDefs: [{
                targets: [],
                searchable: true
            }],
            autoWidth: true,
            responsive: true,
            processing: true,
            ajax: {
                url: `${BASE_URL}ext/invoice`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
                }
            },
            columns: [
                {
                    "data": null, 'render': function (data, type, row) {
                        return `
                            <a href="#/invoice/${row.no_invoice}">${row.no_invoice}</a>
                        `
                    }
                },
                { "data": 'no_order' },
                { "data": 'warehouse.nama_warehouse' },
                { "data": 'tgl_invoice' },
                { "data": 'tgl_tempo' },
                { "data": 'grand_total' },
                { "data": 'status_invoice' },
                {
                    "data": null, 'render': function (data, type, row) {
                        if (row.status_invoice === 'Open') {
                            return `
                                <a class="btn btn-sm btn-success" href="#/invoice/edit/${row.no_invoice}"><i class="fa fa-pencil"></i></a>
                                <button class="btn btn-sm btn-danger delete" data-id="${row.no_invoice}"><i class="fa fa-trash"></i></button>
                            `
                        } else {
                            return ``;
                        }

                    }
                },
            ],
            order: [
                [0, 'desc']
            ]
        });

        const ORDER = $('#t_order').DataTable({
            columnDefs: [{
                targets: [],
                searchable: true
            }],
            autoWidth: true,
            responsive: true,
            processing: true,
            ajax: {
                url: `${BASE_URL}ext/shipping`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
                },
            },
            columns: [
                {
                    "data": null, 'render': function (data, type, row) {
                        return `
                            <button class="btn btn-sm btn-primary pilih_order" data-id="${row.no_order}">Pilih</button>
                        `
                    }
                },
                { "data": 'no_order' },
                { "data": 'warehouse.nama_warehouse' },
                { "data": 'supplier.nama_supplier' },
                { "data": 'status_shipping' },
                { "data": 'tgl_shipping' },

            ],
            order: [[0, 'desc']]
        });

        const openModal = () => {
            $('#lookup_order').on('click', function () {
                $('#modal_order').modal('show');
            })
        }

        const btnPilih = () => {
            $('#t_order').on('click', '.pilih_order', function () {
                let no_order = $(this).data('id');

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
            })
        }

        const submitForm = () => {
            $('#form_add').validate({
                rules: {
                    no_order: "required",
                    tgl_tempo: "required"
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: `${BASE_URL}ext/invoice/add`,
                        type: 'POST',
                        dataType: 'JSON',
                        data: $(form).serialize(),
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
                            $('#submit_add').html('<i class="fa fa-spin fa-spinner"></i>');
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
                            $('#submit_add').html('Simpan');
                        }
                    })
                }
            })
        }

        const deleteInvoice = () => {
            $('#t_invoice').on('click', '.delete', function () {
                let no_invoice = $(this).data('id');
                let valid = confirm('Apakah anda yakin ingin menghapus data ini ?');

                if (valid) {
                    $.ajax({
                        url: `${BASE_URL}ext/invoice/delete`,
                        type: 'DELETE',
                        dataType: 'JSON',
                        data: { no_invoice },
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
                        },
                        success: function (res) {
                            MYTABLE.ajax.reload();
                            makeNotif('success', 'Success', res.message, 'bottom-right')
                        },
                        error: function (err) {
                            const { error } = err.responseJSON
                            makeNotif('error', 'Failed', error, 'bottom-right')
                        }
                    })
                }

            })
        }

        return {
            init: () => {
                MYTABLE;
                ORDER;

                openModal();
                btnPilih();

                deleteInvoice();

                submitForm();
            }
        }
    })(renderUI);

    invoiceController.init();
})
