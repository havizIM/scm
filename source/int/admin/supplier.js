console.log('Supplier is running...')

$(function(){
    const supplierController = (() => {
        var count = 0;
        var count_row = 0;

        const MYTABLE = $('#t_supplier').DataTable({
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
                { "data": null, 'render': function (data, type, row){
                    return `<a href="#/supplier/${row.id_supplier}">${row.id_supplier}</a>`
                }  },
                { "data": 'nama_supplier' },
                { "data": 'alamat' },
                { "data": 'telepon' },
                { "data": 'fax' },
                { "data": 'email' },
                { "data": 'status_supplier' },
                {
                    "data": null, 'render': function (data, type, row) {
                        return `
                            <a class="btn btn-sm btn-success" href="#/supplier/edit/${row.id_supplier}"><i class="fa fa-pencil"></i></a>
                            <button class="btn btn-sm btn-danger delete" data-id="${row.id_supplier}"><i class="fa fa-trash"></i></button>
                        `
					}
				},
			],
			order: [
				[0, 'desc']
			]
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
			columns: [{
					"data": null,
					'render': function (data, type, row) {
						return `
                            <button class="btn btn-sm btn-primary pilih_group" data-id="${row.id_group}" data-name="${row.nama_group}" data-lokasi="${row.lokasi_group}">Pilih</button>
                            <button class="btn btn-sm btn-danger delete" data-id="${row.id_group}">Hapus</button>
                        `
					}
				},
				{
					"data": 'id_group'
				},
				{
					"data": 'nama_group'
				},
				{
					"data": 'lokasi_group'
				},
			],
			order: [
				[0, 'desc']
			]
		});

		const openModal = () => {

			$('#lookup_group').on('click', function () {
				$('#modal_group').modal('show');
			})
		}

		const btnPilih = () => {
			$('#t_group').on('click', '.pilih_group', function () {
				var id = $(this).data('id');
				var name = $(this).data('name');
				var lokasi = $(this).data('lokasi');
				var html = '';

				count = count + 1;

				html += `
                    <tr class="row_${count}">
                        <td>
                            <input type="hidden" name="id_group[]" id="id_group" value="${id}">
                            ${name}
                        </td>
                        <td>${lokasi}</td>
                        <td>
                            <button class="btn btn-danger btn-sm remove_group" data-id="${count}"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                `;

                $('#t_detail_group').append(html)

                $('#modal_group').modal('hide')
            })
        }

        const removeRow = () => {
            $('#t_detail_group').on('click', '.remove_group', function(){
                var id = $(this).data('id');

                $('.row_'+id).remove();
            })

            $('#t_detail_bank').on('click', '.remove_bank', function(){
                var id = $(this).data('id');

                $('.row_bank_' + id).remove();
            })
        }


        const deleteData = () => {
            $('#t_supplier').on('click', '.delete', function () {
                let id_supplier = $(this).data('id');
                let ask = confirm(`Are you sure delete this data ${id_supplier} ?`);

                if (ask) {
                    $.ajax({
                        url: `${BASE_URL}int/supplier/delete`,
                        type: 'DELETE',
                        dataType: 'JSON',
                        data: { id_supplier },
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

        const addRow = () => {
            $('.add_row').on('click', function(){
                let html = '';
                
                count_row = count_row + 1;

                html += `
                    <tr class="row_bank_${count_row}">
                        <td> <input type="text" name="nama_bank[]"  id="nama_bank" class="form-control"> </td>
                        <td> <input type="text" name="cabang[]"  id="cabang" class="form-control"> </td>
                        <td> <input type="text" name="pemilik_account[]"  id="pemilik_account" class="form-control"> </td>
                        <td> <input type="text" name="no_rekening[]"  id="no_rekening" class="form-control"> </td>
                        <td> <button type="button" name="remove" class="btn btn-danger remove_bank" data-id="${count_row}"><span class="fa fa-minus"></span></button> </td>
                    </tr>
                `;

                $('#t_detail_bank tbody').append(html)
            })
        }



        const submitAdd = () => {
            $('#form_add').validate({
                rules: {
                    "nama_supplier": "required",
                    "alamat": "required",
                    "telepon": "required",
                    "fax": "required",
                    "npwp": "required",
                    "email": "required",
                    "status_supplier": "required",
                    "nama_pic": "required",
                    "handphone": "required",
                    "email_pic": "required",
                    "username": "required",
                    "nama_bank[]": "required",
                    "cabang[]": "required",
                    "pemilik_account[]": "required",
                    "no_rekening[]": "required"
                },
                checkForm: function () {
                    this.prepareForm();
                    for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
                        if (this.findByName(elements[i].name).length != undefined && this.findByName(elements[i].name).length > 1) {
                            for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
                                this.check(this.findByName(elements[i].name)[cnt]);
                            }
                        } else {
                            this.check(elements[i]);
                        }
                    }
                    return this.valid();
                },
                submitHandler: function(form){
                    $.ajax({
                        url: `${BASE_URL}int/supplier/add`,
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
                            location.hash = '#/supplier';
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
                GROUP_TABLE;

                openModal();
                btnPilih();
                addRow();

                removeRow();

                submitAdd();
                deleteData();
            }
        }
    })();

    supplierController.init();
})
