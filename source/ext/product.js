console.log('Supplier is running...')

$(function () {
    const productController = (() => {

        const MYTABLE = $('#t_product').DataTable({
            columnDefs: [{
                targets: [],
                searchable: true
            }],
            autoWidth: true,
            responsive: true,
            processing: true,
            ajax: {
                url: `${BASE_URL}ext/product`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
                }
            },
            columns: [
                { "data": 'id_product' },
                { "data": 'nama_product' },
                { "data": 'nama_category' },
                { "data": 'nama_supplier' },
                { "data": 'satuan' },
                { "data": 'harga' },
                {
                    "data": null, 'render': function (data, type, row) {
                        return `
                            <a class="btn btn-sm btn-success" href="#/product/edit/${row.id_product}"><i class="mdi mdi-grease-pencil"></i></a>
                            <button class="btn btn-sm btn-danger delete" data-id="${row.id_product}"><i class="fa fa-trash"></i></button>
                        `
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

    productController.init();
})
