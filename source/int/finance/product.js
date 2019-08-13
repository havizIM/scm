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
                url: `${BASE_URL}int/product`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
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
                            <a class="btn btn-sm btn-success" href="#/product/edit/${row.id_product}"><i class="fa fa-pencil"></i></a>
                            <button class="btn btn-sm btn-danger delete" data-id="${row.id_product}"><i class="fa fa-trash"></i></button>
                        `
                    }
                },
            ],
            order: [
                [0, 'desc']
            ]
        });

        const CATEGORY = $('#t_category').DataTable({
            columnDefs: [{
                targets: [],
                searchable: true
            }],
            autoWidth: true,
            responsive: true,
            processing: true,
            ajax: {
                url: `${BASE_URL}int/category`,
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
                            <button class="btn btn-sm btn-primary pilih_category" data-id="${row.id_category}" data-name="${row.nama_category}">Pilih</button>
                            <button class="btn btn-sm btn-danger delete" data-id="${row.id_category}">Hapus</button>
                        `
                }
            },
            {
                "data": 'id_category'
            },
            {
                "data": 'nama_category'
            },
            ],
            order: [
                [0, 'desc']
            ]
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

        const openModal = () => {

            $('#lookup_category').on('click', function () {
                $('#modal_category').modal('show');
            })

            $('#lookup_supplier').on('click', function () {
                $('#modal_supplier').modal('show');
            })
        }

        const btnPilih = () => {
            $('#t_category').on('click', '.pilih_category', function () {
                let id = $(this).data('id')
                let name = $(this).data('name')

                $('#id_category').val(id);
                $('#category').val(`${id} - ${name}`);

                $('#modal_category').modal('hide');
            })

            $('#t_supplier').on('click', '.pilih_supplier', function () {
                let id = $(this).data('id')
                let name = $(this).data('name')

                $('#id_supplier').val(id);
                $('#supplier').val(`${id} - ${name}`);

                $('#modal_supplier').modal('hide');
            })
        }

        const deleteCategory = () => {
            $('#t_category').on('click', '.delete', function () {
                let id_category = $(this).data('id');
                let ask = confirm(`Are you sure delete this data ${id_category} ?`);

                if (ask) {
                    $.ajax({
                        url: `${BASE_URL}int/category/delete`,
                        type: 'DELETE',
                        dataType: 'JSON',
                        data: { id_category },
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

        const deleteData = () => {
            $('#t_product').on('click', '.delete', function () {
                let id_product = $(this).data('id');
                let ask = confirm(`Are you sure delete this data ${id_product} ?`);

                if (ask) {
                    $.ajax({
                        url: `${BASE_URL}int/product/delete`,
                        type: 'DELETE',
                        dataType: 'JSON',
                        data: { id_product },
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

        const submitCategory = () => {
            $('#form_category').validate({
                rules: {
                    "nama_category": "required",
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: `${BASE_URL}int/category/add`,
                        type: 'POST',
                        dataType: 'JSON',
                        data: $(form).serialize(),
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                            $('#submit_category').html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        success: function (res) {
                            makeNotif('success', 'Success', res.message, 'bottom-right')
                            $('#form_category')[0].reset();
                            CATEGORY.ajax.reload();
                        },
                        error: function (err) {
                            const { message } = err.responseJSON
                            makeNotif('error', 'Failed', message, 'bottom-right')
                        },
                        complete: function () {
                            $('#submit_category').html('Simpan');
                        }
                    })
                }
            })
        }

        const submitAdd = () => {
            $('#form_add').validate({
                rules: {
                    "nama_product": "required",
                    "supplier": "required",
                    "category": "required",
                    "satuan": "required",
                    "harga": "required"
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: `${BASE_URL}int/product/add`,
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
                            location.hash = '#/product';
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
                CATEGORY;
                SUPPLIER;

                openModal();
                btnPilih();

                deleteCategory();
                deleteData();

                submitCategory();
                submitAdd();
            }
        }
    })();

    productController.init();
})
