$(function () {
	const renderUI = (() => {
		return {
			renderDetail: function (data) {
				var html = '';

				html += `
                    <div class="col-md-6"> <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Data Warehouse</h4>
                        </div>
                        <div class="card-body">
                            <center class="m-t-30"> <img src="${BASE_URL}assets/image/scm/logo_full.png" width="100%">
                                <h4 class="card-title m-t-10">${data.nama_warehouse}</h4>
                                <h6 class="card-subtitle"></h6>
                            </center>
                        </div>
                        <div><hr></div>
                        <div class="card-body">
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

                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Data Grup</h4>
                            </div>
                            <div class="card-body">

                                    <small class="text-muted">ID Grup</small>
                                    <h6>${data.group.id_group}</h6>
                                    
                                    <small class="text-muted p-t-20 db">Nama Grup</small>
                                    <h6>${data.group.nama_group}</h6>

                                    <small class="text-muted p-t-20 db">Lokasi Grup</small>
                                    <h6>${data.group.lokasi_group}</h6> 
                                
                            </div>
                        </div>
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Data User</h4>
                            </div>
                            <div class="card-body">

                                    <small class="text-muted">ID User</small>
                                    <h6>${data.user.id_user}</h6>
                                    
                                    <small class="text-muted p-t-20 db">Nama Lengkap</small>
                                    <h6>${data.user.nama_lengkap}</h6>

                                    <small class="text-muted p-t-20 db">Email User</small>
                                    <h6>${data.user.email_user}</h6> 

                                    <small class="text-muted p-t-20 db">Telepon</small>
                                    <h6>${data.user.tlp_user}</h6> 
                                
                            </div>
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
			let ID_WAREHOUSE = location.hash.substr(12);
			$.ajax({
				url: `${BASE_URL}int/warehouse?id_warehouse=${ID_WAREHOUSE}`,
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
