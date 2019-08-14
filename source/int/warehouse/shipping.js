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
              { "data": null, 'render': function (data, type, row){
                  return `<a href="#/shipping/${row.no_shipping}">${row.no_shipping}</a>`
              }  },
                { "data": 'no_order' },
                { "data": 'warehouse.nama_warehouse' },
                { "data": 'supplier.nama_supplier' },
                { "data": 'tgl_shipping' },
                { "data": 'tgl_receive' },
                {
                    "data": null, 'render': function (data, type, row) {
                        if (row.status_shipping === 'Open') {
                            return `<span class="label label-info m-r-10">${row.status_shipping}</span>`;
                        } else {
                            return `<span class="label label-danger m-r-10">${row.status_shipping}</span>`;
                        }
                    }
                },
                {
                    "data": null, 'render': function (data, type, row) {
                        if (row.status_shipping === 'Open') {
                            return `
                                <button class="btn btn-sm btn-info approve" data-id="${row.no_shipping}"><i class="fa fa-check"></i> Approve</button>
                            `
                        } else {
                            return `-`;
                        }

                    }
                },
            ],
            order: [
                [0, 'desc']
            ]
        });

        const btnApprove = () => {
            $('#t_shipping').on('click', '.approve', function () {
                let no_shipping = $(this).data('id');
                let ask = confirm(`Are you sure approve this data ${no_shipping} ?`);

                if (ask) {
                    $.ajax({
                        url: `${BASE_URL}int/shipping/approve`,
                        type: 'PUT',
                        dataType: 'JSON',
                        data: { no_shipping },
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
            });
        }

        return {
            init: () => {
                MYTABLE;

                btnApprove()
            }
        }
    })();

    shippingController.init();
})
