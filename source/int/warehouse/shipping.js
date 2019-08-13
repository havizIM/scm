console.log('Shipping is running...')

$(function () {
    const shippingController = (() => {

        const MYTABLE = $('#t_shipping').DataTable({
            columnDefs: [{
                targets: [],
                searchable: true
            }],
            autoWidth: true,
            responsive: true,
            processing: true,
            ajax: {
                url: `${BASE_URL}int/shipping`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                }
            },
            columns: [
                { "data": 'no_shipping' },
                { "data": 'no_order' },
                { "data": 'supplier.nama_supplier' },
                { "data": 'warehouse.nama_warehouse' },
                { "data": 'tgl_shipping' },
                { "data": 'tgl_receive' },
                { "data": 'status_shipping' },
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

    shippingController.init();
})
