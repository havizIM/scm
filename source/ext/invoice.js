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
                { "data": 'supplier.nama_supplier' },
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

        return {
            init: () => {
                MYTABLE;
            }
        }
    })();

    invoiceController.init();
})
