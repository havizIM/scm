console.log('Warehouses is running...')

$(function () {
    const warehouseController = (() => {
        const MYTABLE = $('#t_warehouse').DataTable({
            columnDefs: [{
                targets: [],
                searchable: true
            }],
            autoWidth: true,
            responsive: true,
            processing: true,
            ajax: {
                url: `${BASE_URL}int/warehouse`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                }
            },
            columns: [
                { "data": 'id_warehouse' },
                { "data": 'nama_warehouse' },
                { "data": 'alamat' },
                { "data": 'telepon' },
                { "data": 'fax' },
                { "data": 'email' },
                {
                    "data": null, 'render': function (data, type, row) {
                        return `
                            <a class="btn btn-sm btn-success" href="#/warehouse/edit/${row.id_warehouse}"><i class="fa fa-pencil"></i></a>
                            <button class="btn btn-sm btn-danger delete" data-id="${row.id_warehouse}"><i class="fa fa-trash"></i></button>
                        `
                    }
                },
            ],
            order: [[0, 'desc']]
        });

        const GROUP_TABLE = $('#t_group').DataTable({
            columnDefs: [{
                targets: [],
                searchable: true
            }],
            autoWidth: true,
            responsive: true,
            processing: true,
            ajax: {
                url: `${BASE_URL}int/group`,
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
                            <button class="btn btn-sm btn-primary pilih_group" data-id="${row.id_group}" data-name="${row.nama_group}">Pilih</button>
                            <button class="btn btn-sm btn-danger delete" data-id="${row.id_group}">Hapus</button>
                        `
                    }
                },
                { "data": 'id_group' },
                { "data": 'nama_group' },
                { "data": 'lokasi_group' },
            ],
            order: [[0, 'desc']]
        });

        const USER_TABLE = $('#t_user').DataTable({
            columnDefs: [{
                targets: [],
                searchable: true
            }],
            autoWidth: true,
            responsive: true,
            processing: true,
            ajax: {
                url: `${BASE_URL}int/user?level=Warehouse`,
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
                            <button class="btn btn-sm btn-primary pilih_user" data-id="${row.id_user}" data-name="${row.nama_lengkap}">Pilih</button>
                        `
                    }
                },
                { "data": 'id_user' },
                { "data": 'nama_lengkap' },
                { "data": 'email' },
                { "data": 'telepon' },
                { "data": 'jenis_kelamin' },
            ],
            order: [[0, 'desc']]
        });

        const openModal = () => {
            $('#lookup_user').on('click', function(){
                $('#modal_user').modal('show');
            })

            $('#lookup_group').on('click', function () {
                $('#modal_group').modal('show');
            })
        }

        const submitGroup = () => {
            $('#form_group').validate({
                rules: {
                    nama_group: { required: true },
                    lokasi_group: { required: true },
                },
                submitHandler(form) {
                    $.ajax({
                        url: `${BASE_URL}int/group/add`,
                        type: 'POST',
                        dataType: 'JSON',
                        data: $(form).serialize(),
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                            $('#submit_group').html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        success: function (res) {
                            makeNotif('success', 'Failed', res.message, 'bottom-right')
                            $('#form_group')[0].reset();
                            GROUP_TABLE.ajax.reload();
                        },
                        error: function (err) {
                            const { message } = err.responseJSON
                            makeNotif('error', 'Failed', message, 'bottom-right')
                        },
                        complete: function () {
                            $('#submit_group').html('Simpan');
                        }
                    })
                }
            })
        }

        const submitAdd = () => {
            $('#form_add').validate({
                rules: {
                    id_group: { required: true },
                    id_user: { required: true },
                    nama_warehouse: { required: true },
                    alamat: { required: true },
                    telepon: { required: true },
                    fax: { required: true },
                    email: { required: true }
                },
                submitHandler(form) {
                    $.ajax({
                        url: `${BASE_URL}int/warehouse/add`,
                        type: 'POST',
                        dataType: 'JSON',
                        data: $(form).serialize(),
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                            $('#submit_add').html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        success: function (res) {
                            makeNotif('success', 'Failed', res.message, 'bottom-right')
                            location.hash = '#/warehouse'
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

        const btnPilih = () => {
            $('#t_user').on('click', '.pilih_user', function(){
                var id = $(this).data('id')
                var name = $(this).data('name')

                $('#id_user').val(id);
                $('#user').val(`${id} - ${name}`);

                $('#modal_user').modal('hide')
            })

            $('#t_group').on('click', '.pilih_group', function () {
                var id = $(this).data('id')
                var name = $(this).data('name')

                $('#id_group').val(id);
                $('#group').val(`${id} - ${name}`);

                $('#modal_group').modal('hide')
            })
        }


        const deleteData = () => {
            $('#t_warehouse').on('click', '.delete', function () {
                let id_warehouse = $(this).data('id');
                let ask = confirm(`Are you sure delete this data ${id_warehouse} ?`);

                if (ask) {
                    $.ajax({
                        url: `${BASE_URL}int/warehouse/delete`,
                        type: 'DELETE',
                        dataType: 'JSON',
                        data: { id_warehouse },
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                        },
                        success: function (res) {
                            MYTABLE.ajax.reload();
                            makeNotif('success', 'Failed', res.message, 'bottom-right')
                        },
                        error: function ({ responseJSON }) {
                            makeNotif('error', 'Failed', responseJSON.message, 'bottom-right')
                        }
                    })
                }
            });
        }

        const deleteGroup = () => {
            $('#t_group').on('click', '.delete', function () {
                let id_group = $(this).data('id');
                let ask = confirm(`Are you sure delete this data ${id_group} ?`);

                if (ask) {
                    $.ajax({
                        url: `${BASE_URL}int/group/delete`,
                        type: 'DELETE',
                        dataType: 'JSON',
                        data: { id_group },
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                        },
                        success: function (res) {
                            GROUP_TABLE.ajax.reload();
                            makeNotif('success', 'Failed', res.message, 'bottom-right')
                        },
                        error: function ({ responseJSON }) {
                            makeNotif('error', 'Failed', responseJSON.message, 'bottom-right')
                        }
                    })
                }
            });
        }


        return {
            init: () => {
                MYTABLE;
                GROUP_TABLE;
                USER_TABLE;

                openModal();
                btnPilih();

                submitAdd();
                submitGroup();

                deleteData();
                deleteGroup();
            }
        }
    })();

    warehouseController.init();
})

