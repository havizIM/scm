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
                { "data": 'status_invoice' },
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
