console.log('Order is running...')

$(function () {
    const orderController = (() => {

        const MYTABLE = $('#t_order').DataTable({
            columnDefs: [{
                targets: [],
                searchable: true
            }],
            autoWidth: true,
            responsive: true,
            processing: true,
            ajax: {
                url: `${BASE_URL}ext/order`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
                },
            },
            columns: [
                { "data": 'no_order' },
                { "data": 'warehouse.nama_warehouse' },
                { "data": 'supplier.nama_supplier' },
                { "data": 'status_order' },
                { "data": 'tgl_order' },

            ],
            order: [[0, 'desc']]
        });


        return {
            init: () => {
                MYTABLE;
            }
        }
    })();

    orderController.init();
})
