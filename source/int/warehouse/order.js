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
                { "data": null, 'render': function (data, type, row){
                    return `<a href="#/order/${row.no_order}">${row.no_order}</a>`
                }  },
                { "data": 'warehouse.nama_warehouse' },
                { "data": 'supplier.nama_supplier' },
                { "data": 'status_order' },
                { "data": 'tgl_order' },
                {
                    "data": null, 'render': function (data, type, row) {
                        if(row.status_order === 'Open'){
                            return `
                                <a class="btn btn-sm btn-success" href="#/order/edit/${row.no_order}"><i class="fa fa-pencil"></i></a>
                                <button class="btn btn-sm btn-danger delete" data-id="${row.no_order}"><i class="fa fa-trash"></i></button>
                            `
                        } else {
                            return ``;
                        }

                    }
                },
            ],
            order: [[0, 'desc']]
        });

        const SUPPLIER = $('#t_supplier').DataTable({
            columnDefs: [{
                targets: [],
                searchable: true
            }],
            autoWidth: true,
            responsive: true,
            processing: true,
            ajax: {
                url: `${BASE_URL}int/supplier`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                }
            },
            columns: [
                {
                    "data": null, 'render': function (data, type, row) {
                        return `
                            <button class="btn btn-sm btn-primary pilih_supplier" data-id="${row.id_supplier}" data-name="${row.nama_supplier}">Pilih</button>
                        `
                    }
                },
                { "data": 'id_supplier' },
                { "data": 'nama_supplier' },
                { "data": 'alamat' },
                { "data": 'telepon' },
                { "data": 'fax' },
                { "data": 'email' },
                { "data": 'status_supplier' },
            ],
            order: [[0, 'desc']]
        });

        const PRODUCT = $('#t_product').DataTable({
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
                let supplier = $('#supplier').val();

                if(supplier === ''){
                    makeNotif('warning', 'Failed', 'Silahkan pilih supplier', 'bottom-right')
                } else {
                    $('#modal_product').modal('show');
                }
            })

            $('#lookup_supplier').on('click', function(){
                $('#modal_supplier').modal('show');
            })
        }

        const pilihSupplier = () => {
            $('#t_supplier').on('click', '.pilih_supplier', function(){
                let id = $(this).data('id')
                let name = $(this).data('name')

                $('#id_supplier').val(id);
                $('#supplier').val(`${id} - ${name}`);

                $('#t_detail_product tbody').html('')
                PRODUCT.ajax.url(`${BASE_URL}int/product?id_supplier=${id}`).load();

                $('#modal_supplier').modal('hide');
            })
        }

        const pilihProduct = () => {
            $('#t_product').on('click', '.pilih_product', function(){
                let id = $(this).data('id')
                let name = $(this).data('name')
                let harga = $(this).data('harga')
                let html = '';

                html += `
                    <tr class="row_${id}">
                        <td>
                            ${id} - ${name}
                            <input type="hidden" name="id_product[]" id="id_product" value="${id}">
                        </td>
                        <td>
                            <input type="number" name="harga[]" id="harga" class="form-control" readonly value="${harga}">
                        </td>
                        <td>
                            <input type="number" name="qty[]" id="qty" class="form-control count">
                        </td>
                        <td>
                            <input type="text" name="status[]" id="status" class="form-control" readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove" data-id="${id}"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                `;

                $('#t_detail_product tbody').append(html);
                $('#modal_product').modal('hide');
            })
        }

        const countTotal = () => {
            $(document).on('keyup', '.count', function () {
                let qty = $(this).val()

                let harga = $(this).parent().prev().children().val()
                let jml = $(this).parent().next().children()

                //
                let total = qty * harga

                jml.val(total)

            })
        }

        const removeProduct = () => {
            $('#t_detail_product').on('click', '.remove', function(){
                let id = $(this).data('id');

                $('.row_'+id).remove();
            })
        }

        const deleteOrder = () => {
            $('#t_order').on('click', '.delete', function(){
                let no_order    = $(this).data('id');
                let valid       = confirm('Apakah anda yakin ingin menghapus data ini ?');

                if(valid){
                    $.ajax({
                        url: `${BASE_URL}int/order/delete`,
                        type: 'DELETE',
                        dataType: 'JSON',
                        data: { no_order },
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

            })
        }

        const submitAdd = () => {
            $('#form_add').validate({
                rules: {
                    supplier: "required"
                },
                submitHandler: function(form){
                    $.ajax({
                        url: `${BASE_URL}int/order/add`,
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
                            location.hash = '#/order'
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
                PRODUCT;
                SUPPLIER;

                openModal();
                pilihProduct();
                pilihSupplier();

                removeProduct();
                deleteOrder();
                countTotal();
                submitAdd();
            }
        }
    })();

    orderController.init();
})
