console.log('Shipping is running...')

$(function () {

    const renderUI = (() => {
        return {
            renderDetail: (data) => {
                let html = '';

                $.each(data.detail, function(k, v){
                    html += `
                        <tr>
                            <td>${v.id_product} - ${v.nama_product}</td>
                            <td>${v.qty} ${v.satuan}</td>
                            <td>
                                <input type="hidden" class="form-control" id="id_product" name="id_product[]" value="${v.id_product}" />
                                <input type="number" class="form-control" id="actual_qty" name="actual_qty[]" />
                            </td>
                        </tr>
                    `
                })

                $('#no_order').val(data.no_order);
                $('#order').val(`${data.no_order} - ${data.warehouse.nama_warehouse}`);
                $('#t_detail_order tbody').html(html);
                $('#modal_order').modal('hide');
            }
        }
    })()

    const shippingController = ((UI) => {

        const MYTABLE = $('#t_shipping').DataTable({
            columnDefs: [{
                targets: [],
                searchable: true
            }],
            autoWidth: true,
            responsive: true,
            processing: true,
            ajax: {
                url: `${BASE_URL}ext/shipping`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
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
                {
                    "data": null, 'render': function (data, type, row) {
                        if (row.status_shipping === 'Open') {
                            return `
                                <a class="btn btn-sm btn-success" href="#/shipping/edit/${row.no_shipping}"><i class="fa fa-pencil"></i></a>
                                <button class="btn btn-sm btn-danger delete" data-id="${row.no_shipping}"><i class="fa fa-trash"></i></button>
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

        const SHIPPING = $('#t_order').DataTable({
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
                {
                    "data": null, 'render': function (data, type, row) {
                        return `
                            <button class="btn btn-sm btn-primary pilih_order" data-id="${row.no_order}">Pilih</button>
                        `
                    }
                },
                { "data": 'no_order' },
                { "data": 'warehouse.nama_warehouse' },
                { "data": 'supplier.nama_supplier' },
                { "data": 'status_order' },
                { "data": 'tgl_order' },

            ],
            order: [[0, 'desc']]
        });

        const openModal = () => {
            $('#lookup_order').on('click', function() {
                $('#modal_order').modal('show');
            })
        }

        const btnPilih = () => {
            $('#t_order').on('click', '.pilih_order', function(){
                let no_order = $(this).data('id');

                $.ajax({
                    url: `${BASE_URL}ext/order?no_order=${no_order}`,
                    type: 'GET',
                    dataType: 'JSON',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                        xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
                    },
                    success: function(res){
                        $.each(res.data, function(k, v){
                            UI.renderDetail(v);
                        })
                    },
                    error: function(err){
                        makeNotif('error', 'Failed', responseJSON.message, 'bottom-right')
                    }
                })
            })
        }

        const submitForm = () => {
            $('#form_add').validate({
                rules: {
                    no_order: "required",
                    tgl_shipping: "required"
                },
                submitHandler: function(form){
                    $.ajax({
                        url: `${BASE_URL}ext/shipping/add`,
                        type: 'POST',
                        dataType: 'JSON',
                        data: $(form).serialize(),
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
                            $('#submit_add').html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        success: function (res) {
                            makeNotif('success', 'Success', res.message, 'bottom-right')
                            location.hash = '#/shipping'
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

        const deleteShipping = () => {
            $('#t_shipping').on('click', '.delete', function(){
                let no_shipping = $(this).data('id');
                let valid = confirm('Apakah anda yakin ingin menghapus data ini ?');

                if (valid) {
                    $.ajax({
                        url: `${BASE_URL}ext/shipping/delete`,
                        type: 'DELETE',
                        dataType: 'JSON',
                        data: { no_shipping },
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
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

        return {
            init: () => {
                MYTABLE;
                SHIPPING;

                openModal();
                btnPilih();

                deleteShipping();

                submitForm();
            }
        }
    })(renderUI);

    shippingController.init();
})
