$(function () {
	const renderUI = (() => {
		return {
			renderDetail: function (data) {
				let html = '';

			   html += `
					<div class="card">
						<div class="card-body">
							<div class="col-md-12">
								<div class="text-right">
									<button id="print" class="btn btn-default btn-success" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
								</div>
							</div>
						</div>
					</div>

           			<div class="card card-body printableArea">
             			<div class="row">
							<div class="col-md-12 mb-3">
								<table width="100%" border="0">
									<tr>
										<td>
											<img src="${BASE_URL}assets/image/scm/logo_full.png" alt="homepage" class="light-logo mb-3" style="width:300px;" />
										</td>
										<td class="text-right">
											<h2>Shipping</h2>
											<h3> &nbsp;<b class="text-danger">No Shipping : ${data.no_shipping}</b></h3>
											<p class="">
												<b>Shipping Date :</b> ${data.tgl_shipping} <br/>
												<b>Receive Date :</b> ${data.tgl_receive}
											</p>
										</td>
									</tr>
								</table>
							</div>

							<div class="col-md-12 mb-3">
								<table width="100%" border="0">
									<tr>
										<td style="width: 50%">
											<div class="pull-left">
												<h5 class="ml-2">From :</h5>
												<address>
													<h3> &nbsp;<b>${data.supplier.nama_supplier}</b></h3>
													<p class="text-muted m-l-5">${data.supplier.alamat},
													<br/> Telepon : ${data.supplier.telepon},
													<br/> Fax : ${data.supplier.fax}
												</address>
												
											</div>
										</td>
										<td style="width: 50%">
											<div class="pull-right text-right">
												<h5>To :</h5>
												<address>
													<h3> &nbsp;<b>${data.warehouse.nama_warehouse}</b></h3>
													<p class="text-muted m-l-5">${data.warehouse.alamat},
													<br/> Telepon : ${data.warehouse.telepon},
													<br/> Fax : ${data.warehouse.fax}
												</address>
											</div>
										</td>
									</tr>
								</table>
							</div>

							<div class="col-md-12">
								<div class="table-responsive" style="clear: both;">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>ID Product</th>
												<th>Nama Product</th>
												<th class="text-right">Qty</th>
											</tr>
										</thead>
										<tbody>`

										$.each(data.detail,function(k,v) {

											html+= `<tr>
														<td>${v.id_product}</td>
														<td>${v.nama_product}</td>
														<td class="text-right">${v.qty} ${v.satuan}</td>
													</tr>`
										});
						 
					html+= `
										</tbody>
									</table>
								</div>
							</div>

                   			<div class="col-md-12 mt-3 mb-3">
								<table width="100%">
									<tr>
										<td>
											<div class="text-center">
												<h4>Pengirim</h4>
												<br>
												<br>
												<br>
												<br>
												<br>
												(________________________)
											</div>
										</td>
										<td>
											<div class="text-center">
												<h4>Penerima</h4>
												<br>
												<br>
												<br>
												<br>
												<br>
												(_________________________)
											</div>
										</td>
									</tr>
								</table>
                   			</div>
                 		</div>
               		</div> `

				$('#content_profile').html(html);
			},
			renderNoData: function () {
				$('#content_profile').html(`<h1>Data tidak ditemukan</h1>`);
			}
		}
	})()

	const detailController = ((UI) => {
		const fetchData = () => {
			let ID_SHIPPING = location.hash.substr(11);
			// alert(ID_WAREHOUSE)
			$.ajax({
				url: `${BASE_URL}ext/shipping?no_shipping=${ID_SHIPPING}`,
				type: 'GET',
				dataType: 'JSON',
				beforeSend: function (xhr) {
					xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
					xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
				},
				success: function (res) {
					$.each(res.data, function (k,v) {
						UI.renderDetail(v)
					})
          console.log(res);
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

		const printAble = function () {
			$(document).on('click', '#print', function () {
				var mode = 'iframe'; //popup
				var close = mode == "popup";
				var options = {
					mode: mode,
					popClose: close
				};

				$('.printableArea').printArea(options);
			})
		}

		return {
			init: function () {
				fetchData();
				printAble();
			}
		}

	})(renderUI)


	detailController.init();
})
