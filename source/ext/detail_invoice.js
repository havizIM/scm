$(function () {
	const renderUI = (() => {
		return {
			renderDetail: function (data) {

				var html = '';
				var total_ppn = 0
				var sub_total = 0

			   html += `

         <div class="col-md-12">
           <div class="card card-body printableArea">
             <div class="row">
						 <div class="col-md-6"><h3> <b class="text-danger">No Invoice</b><span>#${data.no_invoice}</span></h3></div>
						 <div class="col-md-6"><img src="${BASE_URL}assets/image/scm/logo_full.png" alt="homepage" class="" style="width:200px; margin-bottom:50px; float:right;" /></div>
						 <hr>
               <div class="col-md-12">
                 <div class="pull-left">
								 <h5>From,</h5>
								 <address>
								 <h3> &nbsp;<b>${data.supplier.nama_supplier}</b></h3>
								 <p class="text-muted m-l-5">${data.supplier.alamat},
									 <br/> Telepon : ${data.supplier.telepon},
									 <br/> Fax : ${data.supplier.fax}
										 <p class="m-t-30"><b>Invoice Date :</b> <i class="fa fa-calendar"></i> ${data.tgl_invoice}</p>
										 <p class="m-t-30"><b>Due Date :</b> <i class="fa fa-calendar"></i> ${data.tgl_tempo}</p>
									 </address>
                   </div>
                   <div class="pull-right text-right">
									 <h5>To,</h5>
									 <address>
										 <h3> &nbsp;<b>${data.warehouse.nama_warehouse}</b></h3>
										 <p class="text-muted m-l-5">${data.warehouse.alamat},
											 <br/> Telepon : ${data.warehouse.telepon},
											 <br/> Fax : ${data.warehouse.fax}

											 <h3> <span class="pull-right">#${data.no_order}</span><b class="text-danger pull-right">No Order</b></h3>
										 </address>

                     </div>
                   </div>
                   <div class="col-md-12">
                     <div class="table-responsive m-t-40" style="clear: both;">
                       <table class="table table-hover">
                         <thead>
                           <tr>
                             <th>Produk</th>
                             <th>Qty</th>
                             <th>Price</th>
                             <th>Total</th>
                           </tr>
                         </thead>
                         <tbody>`
                         $.each(data.detail,function(k,v) {
													 total_ppn += parseInt(v.ppn)
													 sub_total += parseInt(v.total_harga)
                   html+= `<tr>
                             <td>${v.deskripsi}</td>
                             <td>${v.qty}</td>
                             <td>${v.harga}</td>
                             <td>${v.total_harga}</td>
                           </tr>`

                         });
                    html+= `</tbody>
                       </table>
                     </div>
                   </div>
                   <div class="col-md-12">
                   <div class="pull-left m-t-30 text-left">
                           <hr style="margin-bottom:200px;">
											<h3>(_____________________)</h3>
                     </div>
                   <div class="pull-right m-t-30 text-right">
										 <h5>Sub Total : Rp. ${sub_total}</h5>
										 <h5>Tax 10% : Rp. ${total_ppn}</h5>
                    	<hr>
											<h3>Grand Total : Rp. ${data.grand_total}</h3>
                     </div>
                     <div class="clearfix"></div>
                     <hr>
                     <div class="text-right">
                       <button id="print" class="btn btn-warning btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
                     </div>
                   </div>
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



		return {
			init: function () {
				fetchData();
			}
		}

	})(renderUI)


	detailController.init();
})
