console.log('Detail Supplier is running...')

$(function () {
	const renderUI = (() => {
		return {
			renderDetail: function (data) {
				var html = '';

				html += `
                    <div class="col-md-6"> <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Data Supplier</h4>
                        </div>
                        <div class="card-body">
                            <center class="m-t-30"> <img src="${BASE_URL}assets/image/scm/logo_full.png" width="100%">
                                <h4 class="card-title m-t-10">${data.nama_supplier}</h4>
                                <h6 class="card-subtitle"></h6>
                            </center>
                        </div>
                        <div><hr></div>
                        <div class="card-body">
                            <small class="text-muted">ID Supplier </small>
                            <h6>${data.id_supplier}</h6>

                            <small class="text-muted">Alamat </small>
                            <h6>${data.alamat}</h6>
                            
                            <small class="text-muted p-t-20 db">Telepon</small>
                            <h6>${data.telepon}</h6>

                            <small class="text-muted p-t-20 db">Fax</small>
                            <h6>${data.fax}</h6>
                            
                            <small class="text-muted p-t-20 db">Email</small>
                            <h6>${data.email}</h6>

                            <small class="text-muted p-t-20 db">Tanggal Registrasi</small>
                            <h6>${data.tgl_reg_warehouse}</h6>

                            <small class="text-muted p-t-20 db">NPWP</small>
                            <h6>${data.npwp}</h6>

                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Data PIC</h4>
                            </div>
                            <div class="card-body">

                                    <small class="text-muted">ID Grup</small>
                                    <h6>${data.pic.id_pic}</h6>
                                    
                                    <small class="text-muted p-t-20 db">Nama Grup</small>
                                    <h6>${data.pic.nama_pic}</h6>

                                    <small class="text-muted p-t-20 db">Handphone</small>
                                    <h6>${data.pic.handphone}</h6> 

                                    <small class="text-muted p-t-20 db">Email Pic</small>
                                    <h6>${data.pic.email_pic}</h6> 

                                    <small class="text-muted p-t-20 db">Username</small>
                                    <h6>${data.pic.username}</h6>

                                    <small class="text-muted p-t-20 db">Tgl Registrasi</small>
                                    <h6>${data.pic.tgl_reg_pic}</h6> 
                                
                            </div>
                        </div>

                    <div class="table-responsive">
                <table class="table table-bordered mb-0 table-striped" style="font-size: 12px;">
                                <thead class="bg-success white">  
                                    <tr>
                                        <th>ID Group</th>
                                        <th>NNama Group</th>
                                        <th>Lokasi Group</th>
                                    </tr>
                                </thead> 

                    <tbody>`
				if (data.supply_group.length !== 0) {
					$.each(data.supply_group, function (k, v) {
						html += `
                        <tr>
                            <td>${v.id_group}</td>
                            <td>${v.nama_group}</td>
                            <td>${v.lokasi_group}</td>
                        </tr>
                        `


					});
				} else {
					html += `
                        <tr>
                            <td colspan="7"><center>Tidak ada peserta yang terdaftar</center></td>
                        </tr>
                        `
				}

				html += `</tbody>
        </table>
    </div>
                   
                    </div>

                        <div class="col-md-12">
                              <div class="table-responsive">
                <table class="table table-bordered mb-0 table-striped" style="font-size: 12px;">
                                <thead class="bg-success white">  
                                    <tr>
                                        <th>ID Account</th>
                                        <th>No Rekening</th>
                                        <th>Nama Bank</th>
                                        <th>Cabang</th>
                                        <th>Pemilik Account</th>
                                    </tr>
                                </thead> 

                    <tbody>`
				if (data.bank_account.length !== 0) {
					$.each(data.bank_account, function (k, v) {
						html += `
                        <tr>
                            <td>${v.id_account}</td>
                            <td>${v.no_rekening}</td>
                            <td>${v.nama_bank}</td>
                            <td>${v.cabang}</td>
                            <td>${v.pemilik_account}</td>
                        </tr>
                        `


					});
				} else {
					html += `
                        <tr>
                            <td colspan="7"><center>Tidak ada peserta yang terdaftar</center></td>
                        </tr>
                        `
				}

				html += `</tbody>
        </table>
    </div>
</div>
                `;

				$('#content_profile').html(html);
			},
			renderNoData: function () {
				$('#content_profile').html(`<h1>Data tidak ditemukan</h1>`);
			}
		}
	})()

	const detailController = ((UI) => {
		const fetchData = () => {
			let ID_SUPPLIER = location.hash.substr(11);
			// alert(ID_SUPPLIER)
			$.ajax({
				url: `${BASE_URL}int/supplier?id_supplier=${ID_SUPPLIER}`,
				type: 'GET',
				dataType: 'JSON',
				beforeSend: function (xhr) {
					xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
					xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
				},
				success: function (res) {
					$.each(res.data, function (k, v) {
						UI.renderDetail(v)
					})
				},
				error: function (err) {
					const {
						message
					} = err.responseJSON
					makeNotif('error', 'Failed', message, 'bottom-right')
				},
				complete: function () {

				}
			})
		}

		return {
			init: function () {
				fetchData();
			}
		}

	})(renderUI)

	detailController.init();
})
