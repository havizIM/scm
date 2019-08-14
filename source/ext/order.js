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
                { "data": null, 'render': function (data, type, row){
                    return `<a href="#/order/${row.no_order}">${row.no_order}</a>`
                }  },
                { "data": 'warehouse.nama_warehouse' },
                { "data": 'supplier.nama_supplier' },
                { "data": 'status_order' },
                { "data": 'tgl_order' },
                {
                    "data": null, 'render': function (data, type, row) {
                        if (row.status_order === 'Open') {
                            return `
                                <button class="btn btn-sm btn-info approve" data-id="${row.no_order}"><i class="fa fa-check"></i> Approve</button>
                            `
                        } else {
                            return `-`;
                        }

                    }
                },

            ],
            order: [[0, 'desc']]
        });

        const btnApprove = () => {
            $('#t_order').on('click', '.approve', function () {
                let no_order = $(this).data('id');
                let ask = confirm(`Are you sure approve this data ${no_order} ?`);

                if (ask) {
                    $.ajax({
                        url: `${BASE_URL}ext/order/approve`,
                        type: 'PUT',
                        dataType: 'JSON',
                        data: { no_order },
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
            });
        }


        return {
            init: () => {
                MYTABLE;

                btnApprove()
            }
        }
    })();

    orderController.init();
})
