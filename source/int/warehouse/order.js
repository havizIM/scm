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
                url: `${BASE_URL}int/order`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                },
            },
            columns: [
                { "data": 'no_order' },
                { "data": 'warehouse.nama_warehouse' },
                { "data": 'supplier.nama_supplier' },
                { "data": 'status_order' },
                { "data": 'tgl_order' },
                {
                    "data": null, 'render': function (data, type, row) {
                        return `
                            <a class="btn btn-sm btn-success" href="#/order/edit/${row.no_order}"><i class="fa fa-pencil"></i></a>
                            <button class="btn btn-sm btn-danger delete" data-id="${row.no_order}"><i class="fa fa-trash"></i></button>
                        `
                    }
                },
            ],
            order: [[0, 'desc']]
        });

        const PRODUCT_GROUP = $('#t_product').DataTable({
            columnDefs: [{
                targets: [],
                searchable: true
            }],
            autoWidth: true,
            responsive: true,
            processing: true,
            ajax: {
                url: `${BASE_URL}int/product`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                },
            },
            columns: [
                {
                    "data": null, 'render': function (data, type, row) {
                        return `
                            <button class="btn btn-sm btn-primary pilih_product" data-id="${row.id_product}" data-name="${row.nama_product}" data-harga="${row.harga}">Pilih</button>
                        `
                    }
                },
                { "data": 'id_product' },
                { "data": 'nama_product' },
                { "data": 'nama_category' },
                { "data": 'satuan' },
                { "data": 'harga' },
            ],
            order: [[0, 'desc']]
        });

        const openModal = () => {
            $('.lookup_product').on('click', function(){
                $('#modal_product').modal('show');
            })
        }

        const pilihProduct = () => {
            $('#t_product').on('click', '.pilih_product', function(){
                var id = $(this).data('id')
                var name = $(this).data('name')
                var harga = $(this).data('harga')
                var html = '';

                html += `
                    <tr class="row_${id}">
                        <td>
                            ${id} - ${name}
                        </td>
                        <td>
                            Rp. ${harga}
                        </td>
                        <td>
                            <input type="text" name="qty[]" id="qty" class="form-control">
                        </td>
                        <td>    
                            <input type="number" name="total_harga[]" id="total_harga" class="form-control">
                        </td>
                        <td>
                            <button class="btn btn-danger btn-md remove" data-id="${id}"></button>
                        </td>
                    </tr>
                `;
                
                $('#t_detail_product').append(html);
                $('#modal_product').modal('hide');
            })
        }


        return {
            init: () => {
                MYTABLE;
                PRODUCT_GROUP;

                openModal();
                pilihProduct();
            }
        }
    })();

    orderController.init();
})


