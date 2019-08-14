$(function () {
	const renderUI = (() => {
		return {
			renderDetail: function (data) {
        console.log(data);
				var html = '';

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
                    <div class="col-md-12">
                        <table width="100%" border="0">
                          <tr>
                            <td>
                              <img src="${BASE_URL}assets/image/scm/logo_full.png" alt="homepage" class="light-logo mb-3" style="width:300px;" />
                            </td>
                            <td class="text-right">
                              <h2>Payment</h2>
                              <h3> &nbsp;<b class="text-danger">No Payment : ${data.no_payment}</b></h3>
                              <p class="">
                                <b>Payment Date :</b> ${data.tgl_payment}
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
                                <h3> &nbsp;<b>PT. Mitra Adi Perkasa</b></h3>
                                <p class="text-muted m-l-5">Sahid Sudirman Centre,  Karet Tengsin,
                                  <br> Jl. Jend. Sudirman No.Kav. 86, RT.10/RW.11,
                                  <br> Tanahabang, Kota Jakarta Pusat,
                                  <br> Daerah Khusus Ibukota Jakarta 10220</p>
                              </address>
                            </div>
                          </td>
                          <td style="width: 50%">
                            <div class="pull-right text-right">
                              <h5>To :</h5>
                              <address>
                                <h3> &nbsp;<b>${data.supplier.nama_supplier}</b></h3>
                                <p class="text-muted m-l-5"><b>${data.supplier.alamat},</b>
                                <br/> Telepon : ${data.supplier.telepon},
                                <br/> Fax : ${data.supplier.fax}
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
                             <th>No Invoice</th>
                             <th>No PO</th>
                             <th class="text-right">Total</th>
                           </tr>
                         </thead>
                         <tbody>`
                         $.each(data.detail,function(k,v) {

                   html+= `<tr>
                             <td>${v.no_invoice}</td>
                             <td>${v.no_order}</td>
                             <td class="text-right">Rp. ${parseInt(v.jml_bayar).toLocaleString(['ban', 'id'])}</td>
                           </tr>`

                         });
                    html+= `</tbody>
                       </table>
                     </div>
                   </div>

                   <div class="col-md-12">
                         <div class="text-right">
                              <span class="fa fa-money-check-alt fa-3x" style="margin-bottom: 10px; align-items:center;"></span>
                              <h4>${data.account.nama_bank}</h4>
                              <h5>Cabang ${data.account.cabang}</h5>
                              <h5>${data.account.no_rekening}</h5>
                              <h5>${data.account.pemilik_account}</h5>

                              <hr>

                              <h3><b>Total Payment :</b> Rp. ${parseInt(data.total_bayar).toLocaleString(['ban', 'id'])}</h3>
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
