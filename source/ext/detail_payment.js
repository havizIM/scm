$(function () {
	const renderUI = (() => {
		return {
			renderDetail: function (data) {
				var html = '';

			   html += `

         <div class="col-md-12">
           <div class="card card-body printableArea">
           <img src="${BASE_URL}assets/image/scm/logo_full.png" alt="homepage" class="light-logo" style="width:200px; margin-bottom:0px;" />
             <hr>
             <div class="row">
               <div class="col-md-12">
                 <div class="pull-left">
                   <address>
									 		<h5> From,</h5>
                     <h3> &nbsp;<b>PT.Dominos Pizza Indonesia</b></h3>
                     <p class="text-muted m-l-5">Jl. Tomang Raya No.32 Blok B.11 Kav.No.39 Kel. Jatipulo Kec. Palmerah,
                       <br/> Telepon :  021-2933 6741
                     </address>
                   </div>
                   <div class="pull-right text-right">
                     <address>
										 <h5> To,</h5>
                     <h3> &nbsp;<b>${data.supplier.nama_supplier}</b></h3>
                     <p class="text-muted m-l-5">${data.supplier.alamat},
                       <br/> Telepon : ${data.supplier.telepon},
                       <br/> Fax : ${data.supplier.fax}
                       </address>
                     </div>
                   </div>
                   <div class="col-md-12">
                     <div class="table-responsive m-t-40" style="clear: both;">
                       <table class="table table-hover">
                         <thead>
                           <tr>
                             <th>No Invoice</th>
                             <th>No PO</th>
                             <th>Supplier</th>
                             <th>Total</th>
                           </tr>
                         </thead>
                         <tbody>`
                         $.each(data.detail,function(k,v) {

                   html+= `<tr>
                             <td>${v.no_invoice}</td>
                             <td>${v.no_order}</td>
                             <td>${v.nama_supplier}</td>
                             <td>${v.jml_bayar}</td>
                           </tr>`

                         });
                    html+= `</tbody>
                       </table>
                     </div>
                   </div>
                   <div class="col-md-12">

                     <div class="pull-left m-t-30 text-left">
                         <span class="fa fa-money-check-alt fa-3x" style="margin-bottom: 10px; align-items:center;"></span>
                         <h4>${data.account.nama_bank}</h4>
                         <h5>Cabang ${data.account.cabang}</h5>
                         <h5>${data.account.no_rekening}</h5>
                         <h5>${data.account.pemilik_account}</h5>
                     </div>
                     <div class="pull-right m-t-30 text-right">
                           <hr>
                         <h3><b>Grand Total :</b> Rp. ${data.total_bayar}</h3>
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
			let ID_PAYMENT = location.hash.substr(10);
			// alert(ID_WAREHOUSE)
			$.ajax({
				url: `${BASE_URL}ext/payment?no_payment=${ID_PAYMENT}`,
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
