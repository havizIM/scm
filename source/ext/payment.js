console.log('Payment is running...')

$(function () {
    const paymentController = (() => {

        const MYTABLE = $('#t_payment').DataTable({
            columnDefs: [{
                targets: [],
                searchable: true
            }],
            autoWidth: true,
            responsive: true,
            processing: true,
            ajax: {
                url: `${BASE_URL}ext/payment`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
                }
            },
            columns: [
                {
                    "data": null, 'render': function (data, type, row) {
                        return `<a href="#/payment/${row.no_payment}">${row.no_payment}</a>`
                    }
                },
                {
                    "data": null, 'render': function (data, type, row) {
                        return `
                            ${row.account.nama_bank} - ${row.account.no_rekening}
                        `
                    }
                },
                { "data": 'tgl_payment' },
                { "data": 'total_bayar' },
                { "data": 'status_payment' },
                {
                    "data": null, 'render': function (data, type, row) {
                        if (row.status_payment === 'Open') {
                            return `
                                <button class="btn btn-sm btn-info approve" data-id="${row.no_payment}"><i class="fa fa-check"></i> Approve</button>
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
            $('#t_payment').on('click', '.approve', function () {
                let no_payment = $(this).data('id');
                let ask = confirm(`Are you sure approve this data ${no_payment} ?`);

                if (ask) {
                    $.ajax({
                        url: `${BASE_URL}ext/payment/approve`,
                        type: 'PUT',
                        dataType: 'JSON',
                        data: { no_payment },
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

    paymentController.init();
})
