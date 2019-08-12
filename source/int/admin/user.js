console.log('User is running...')

$(function(){
    const userController = (() => {

        const MYTABLE = $('#t_user').DataTable({
            columnDefs: [{
                targets: [],
                searchable: true
            }],
            autoWidth: true,
            responsive: true,
            processing: true,
            ajax: {
                url: `${BASE_URL}int/user`,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                    xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                }
            },
            columns: [
                { "data": 'id_user' },
                { "data": 'nama_lengkap' },
                { "data": 'email' },
                { "data": 'telepon' },
                { "data": 'jenis_kelamin' },
                {
                    "data": null, 'render': function (data, type, row) {
                        return `
                            <a class="btn btn-sm btn-success" href="#/user/edit/${row.id_user}"><i class="fa fa-pencil"></i></a>
                            <button class="btn btn-sm btn-danger btn_delete" data-id="${row.id_user}"><i class="fa fa-trash"></i></button>
                        `
                    }
                },
            ],
            order: [[0, 'desc']]
        });

        const deleteData = () => {
            $('#t_user').on('click', '.btn_delete', function () {
                let id_user = $(this).data('id');
                let ask = confirm(`Are you sure delete this data ${id_user} ?`);

                if (ask) {
                    $.ajax({
                        url: `${BASE_URL}int/user/delete`,
                        type: 'DELETE',
                        dataType: 'JSON',
                        data: { id_user },
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                        },
                        success: function (res) {
                            MYTABLE.ajax.reload();
                            makeNotif('success', 'Failed', res.message, 'bottom-right')
                        },
                        error: function (err) {
                            const { error } = err.responseJSON
                            makeNotif('error', 'Failed', error, 'bottom-right')
                        }
                    })
                }
            });
        }
        
        const submitAdd = () => {
            $('#form_add').validate({
                rules: {
                    nama_lengkap: { required: true },
                    email: { required: true, email: true },
                    telepon: { required: true },
                    jenis_kelamin: { required: true },
                    alamat: { required: true },
                    username: { required: true },
                    level: { required: true },
                    status: { required: true }
                },
                submitHandler(form) {
                    $.ajax({
                        url: `${BASE_URL}int/user/add`,
                        type: 'POST',
                        dataType: 'JSON',
                        data: $(form).serialize(),
                        beforeSend: function(xhr){
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                            $('#submit_add').html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        success: function(res){
                            makeNotif('success', 'Failed', res.message, 'bottom-right')
                            location.hash = '#/user'
                        },
                        error: function(err){
                            const { message } = err.responseJSON
                            makeNotif('error', 'Failed', message, 'bottom-right')
                        },
                        complete: function(){
                            $('#submit_add').html('Simpan');
                        }
                    })
                }
            })
        }

        return {
            init: () => {
                MYTABLE;
                submitAdd();
                deleteData();
            }
        }
    })();

    userController.init();
})
