console.log('Invoice is running...')

$(function () {
    const invoiceController = (() => {

        const MYTABLE = $('#t_invoice').DataTable({
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
                }
            },
            columns: [
              { "data": null, 'render': function (data, type, row){
                  return `<a href="#/invoice/${row.no_invoice}">${row.no_invoice}</a>`
              }  },
                { "data": 'no_order' },
                { "data": 'supplier.nama_supplier' },
                { "data": 'warehouse.nama_warehouse' },
                { "data": 'tgl_invoice' },
                { "data": 'tgl_tempo' },
                { "data": 'grand_total' },
                {
                    "data": null, 'render': function (data, type, row) {
                        if (row.status_invoice === 'Open') {
                            return `<span class="label label-info m-r-10">${row.status_invoice}</span>`;
                        } else {
                            return `<span class="label label-danger m-r-10">${row.status_invoice}</span>`;
                        }
                    }
                },
                {
                    "data": null, 'render': function (data, type, row) {
                        if (row.status_invoice === 'Open') {
                            return `
                                <button class="btn btn-sm btn-info approve" data-id="${row.no_invoice}"><i class="fa fa-check"></i> Approve</button>
                            `
                        } else {
                            return `-`;
                        }

                    }
                },
            ],
            order: [
                [0, 'desc']
            ]
        });

        const btnApprove = () => {
            $('#t_invoice').on('click', '.approve', function () {
                let no_invoice = $(this).data('id');
                let ask = confirm(`Are you sure approve this data ${no_invoice} ?`);

                if (ask) {
                    $.ajax({
                        url: `${BASE_URL}int/invoice/approve`,
                        type: 'PUT',
                        dataType: 'JSON',
                        data: { no_invoice },
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
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
            });
        }

        return {
            init: () => {
                MYTABLE;
                btnApprove();
            }
        }
    })();

    invoiceController.init();
})
