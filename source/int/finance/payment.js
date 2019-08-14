console.log('Payment is running...')

$(function () {
    const paymentController = (() => {

        const MYTABLE = $('#t_payment').DataTable({
            columnDefs: [{
                targets: [],
                searchable: true
            }],
            autoWidth: true,
            responsive: true,
            processing: true,
            ajax: {
                url: `${BASE_URL}int/payment`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                }
            },
            columns: [
                { "data": null, 'render': function (data, type, row){
                    return `<a href="#/payment/${row.no_payment}">${row.no_payment}</a>`
                }  },
                { "data": 'supplier.nama_supplier' },
                {
                    "data": null, 'render': function (data, type, row) {
                        return `
                            ${row.account.nama_bank} - ${row.account.no_rekening}
                        `
                    }
                },
                { "data": 'tgl_payment' },
                { "data": 'total_bayar' },
                {
                    "data": null, 'render': function (data, type, row) {
                        return `
                            <a class="btn btn-sm btn-success" href="#/payment/edit/${row.no_payment}"><i class="fa fa-pencil"></i></a>
                            <button class="btn btn-sm btn-danger delete" data-id="${row.no_payment}"><i class="fa fa-trash"></i></button>
                        `
                    }
                },
            ],
            order: [
                [0, 'desc']
            ]
        });

        const BANK = $('#t_bank').DataTable({
            columnDefs: [{
                targets: [],
                searchable: true
            }],
            autoWidth: true,
            responsive: true,
            processing: true,
            ajax: {
                url: `${BASE_URL}int/bank`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                }
            },
            columns: [
                {
                    "data": null,
                    'render': function (data, type, row) {
                        return `
                            <button class="btn btn-sm btn-primary pilih_bank" data-id="${row.id_account}" data-name="${row.nama_bank}" data-no="${row.no_rekening}" data-id_supp="${row.id_supplier}" data-supplier="${row.nama_supplier}">Pilih</button>
                        `
                    }
                },
                {"data": 'nama_supplier'},
                {"data": 'nama_bank'},
                {"data": 'cabang'},
                {"data": 'pemilik_account'},
                {"data": 'no_rekening'},
            ],
            order: [
                [0, 'desc']
            ]
        });

        const INVOICE = $('#t_invoice').DataTable({
            columnDefs: [{
                targets: [],
                searchable: true
            }],
            autoWidth: true,
            responsive: true,
            processing: true,
            ajax: {
                url: `${BASE_URL}int/invoice`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                },
                dataSrc: function ({ data }) {
                    return data.filter(invoice => invoice.status_invoice === 'Close')
                }
            },
            columns: [
                {
                    "data": null, 'render': function (data, type, row) {
                        return `
                            <button class="btn btn-sm btn-primary pilih_invoice" data-id="${row.no_invoice}" data-name="${row.supplier.nama_supplier}" data-total="${row.grand_total}">Pilih</button>
                        `
                    }
                },
                { "data": 'no_invoice' },
                { "data": 'no_order' },
                { "data": 'tgl_invoice' },
                { "data": 'tgl_tempo' },
                { "data": 'supplier.nama_supplier' },
                { "data": 'warehouse.nama_warehouse' },
                { "data": 'grand_total' },
                { "data": 'status_invoice' },
            ],
            order: [[0, 'desc']]
        });

        const openModal = () => {

            $('#lookup_bank').on('click', function () {
                $('#modal_bank').modal('show');
            })

            $('.lookup_invoice').on('click', function () {
                let bank_account = $('#bank_account').val();

                if (bank_account === '') {
                    makeNotif('warning', 'Failed', 'Silahkan pilih account bank', 'bottom-right')
                } else {
                    $('#modal_invoice').modal('show');
                }

            })
        }

        const btnPilih = () => {
            $('#t_bank').on('click', '.pilih_bank', function () {
                let id = $(this).data('id')
                let no = $(this).data('no')
                let name = $(this).data('name')
                let id_supp = $(this).data('id_supp')
                let supplier = $(this).data('supplier')

                $('#id_account').val(id);
                $('#bank_account').val(`${supplier} (${no} - ${name})`);

                $('#t_detail_payment tbody').html('');
                INVOICE.ajax.url(`${BASE_URL}int/invoice?id_supplier=${id_supp}`).load();
                $('#modal_bank').modal('hide');
            })

            $('#t_invoice').on('click', '.pilih_invoice', function () {
                let id = $(this).data('id')
                let name = $(this).data('name')
                let total = $(this).data('total')
                let html = '';

                html += `
                    <tr class="row_${id}">
                        <td>
                            ${id} - ${name}
                            <input type="hidden" name="no_invoice[]" id="no_invoice" value="${id}">
                        </td>
                        <td>
                            <input type="number" name="total_hutang[]" id="total_hutang" class="form-control" readonly value="${total}">
                        </td>
                        <td>
                            <input type="number" name="jml_bayar[]" id="jml_bayar" class="form-control">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove" data-id="${id}"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                `;

                $('#t_detail_payment tbody').append(html);
                $('#modal_invoice').modal('hide');
            })
        }

        const deleteData = () => {
            $('#t_payment').on('click', '.delete', function () {
                let no_payment = $(this).data('id');
                let ask = confirm(`Are you sure delete this data ${no_payment} ?`);

                if (ask) {
                    $.ajax({
                        url: `${BASE_URL}int/payment/delete`,
                        type: 'DELETE',
                        dataType: 'JSON',
                        data: { no_payment },
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                        },
                        success: function (res) {
                            MYTABLE.ajax.reload();
                            makeNotif('success', 'Success', res.message, 'bottom-right')
                        },
                        error: function ({ responseJSON }) {
                            makeNotif('error', 'Failed', responseJSON.message, 'bottom-right')
                        }
                    })
                }
            });
        }

        const removeInvoice = () => {
            $('#t_detail_payment').on('click', '.remove', function () {
                let id = $(this).data('id');

                $('.row_' + id).remove();
            })
        }

        const submitAdd = () => {
            $('#form_add').validate({
                rules: {
                    "id_account": "required",
                    "tgl_payment": "required",
                    "total_bayar": "required",
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: `${BASE_URL}int/payment/add`,
                        type: 'POST',
                        dataType: 'JSON',
                        data: $(form).serialize(),
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                            $('#submit_add').html('<i class="fa fa-spin fa-spinner"></i>');
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
                            $('#submit_add').html('Simpan');
                        }
                    })
                }
            })
        }

        return {
            init: () => {
                MYTABLE;
                BANK;
                INVOICE;

                openModal();
                btnPilih();

                removeInvoice();
                deleteData();

                submitAdd();
            }
        }
    })();

    paymentController.init();
})
