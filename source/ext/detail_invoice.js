$(function () {
	const renderUI = (() => {
		return {
			renderDetail: function (data) {

				var html = '';
				var total_ppn = 0
				var sub_total = 0

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
										<h2>Invoice</h2>
										<h3> &nbsp;<b class="text-danger">No Invoice : ${data.no_invoice}</b></h3>
										<p class="">
											<b>No Order :</b> ${data.no_order} <br/>
											<b>Invoice Date :</b> ${data.tgl_invoice}
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
												<h3> &nbsp;<b>PT. Mitra Adi Perkasa</b></h3>
												<p class="text-muted m-l-5">Sahid Sudirman Centre,  Karet Tengsin,
													<br> Jl. Jend. Sudirman No.Kav. 86, RT.10/RW.11,
													<br> Tanahabang, Kota Jakarta Pusat,
													<br> Daerah Khusus Ibukota Jakarta 10220</p>
											</address>
										</div>
									</td>
								</tr>
							</table>
						</div>


							<div class="col-md-12">
								<div class="table-responsive m-t-40" style="clear: both;">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>Deskripsi</th>
												<th class="text-right">Price</th>
												<th class="text-right">Qty</th>
												<th class="text-right">Total</th>
											</tr>
										</thead>
										<tbody>`
										$.each(data.detail,function(k,v) {
											total_ppn += parseInt(v.ppn)
											sub_total += parseInt(v.total_harga)

											html+= `
												<tr>
													<td>${v.deskripsi}</td>
													<td class="text-right">Rp. ${parseInt(v.harga).toLocaleString(['ban', 'id'])}</td>
													<td class="text-right">${v.qty}</td>
													<td class="text-right">Rp. ${parseInt(v.total_harga).toLocaleString(['ban', 'id'])}</td>
												</tr>`

										});
					html+= `
										</tbody>
									</table>
								</div>
							</div>


							<div class="col-md-12 mt-3">
								<table width="100%">
									<tr>
										<td class="text-left">
											<div class="text-center">
												<h4>Pembuat</h4>
												<br>
												<br>
												<br>
												<br>
												<br>
												(________________________)
											</div>
										</td>
										<td class="text-right">
											<h5 class="mt-3">Sub Total : Rp. ${sub_total.toLocaleString(['ban', 'id'])}</h5>
											<h5>Tax 10% : Rp. ${total_ppn.toLocaleString(['ban', 'id'])}</h5>
											<hr>
											<h3>Grand Total : Rp. ${data.grand_total.toLocaleString(['ban', 'id'])}</h3>
										</td>
									<tr>
								</table>

							<div class="clearfix"></div>
						</div>
                 	</div>
               </div>

         `

				$('#content_profile').html(html);
			},
			renderNoData: function () {
				$('#content_profile').html(`<h1>Data tidak ditemukan</h1>`);
			}
		}
	})()

	const detailController = ((UI) => {
		const fetchData = () => {
			let ID_INVOICE = location.hash.substr(10);
			// alert(ID_WAREHOUSE)
			$.ajax({
				url: `${BASE_URL}ext/invoice?no_invoice=${ID_INVOICE}`,
				type: 'GET',
				dataType: 'JSON',
				beforeSend: function (xhr) {
					xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
					xhr.setRequestHeader("SCM-EXT-KEY", TOKEN)
				},
				success: function (res) {
					$.each(res.data, function (k, v) {
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
