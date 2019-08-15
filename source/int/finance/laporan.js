console.log('Laporan is Running..')

$(function(){
    const renderUI = (() => {
        return {
            renderHutang: data => {
                let html = '';
                let list_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                let bulan = $('#bulan').val();
                let tahun = $('#tahun').val();

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
                                <div class="pull-left">
                                    <address>
                                        <img src="${BASE_URL}assets/image/scm/logo_full.png" alt="homepage" class="light-logo mb-3" style="width:200px;" /><br/>
                                        <h3> &nbsp;<b class="text-danger">PT. Mitra Adi Perkasa</b></h3>
                                        <p class="text-muted m-l-5">Sahid Sudirman Centre,  Karet Tengsin,
                                            <br> Jl. Jend. Sudirman No.Kav. 86, RT.10/RW.11,
                                            <br> Tanahabang, Kota Jakarta Pusat,
                                            <br> Daerah Khusus Ibukota Jakarta 10220</p>
                                    </address>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h4 class="mt-3">Laporan Hutang Periode ${list_bulan[bulan - 1]} ${tahun}</h4>
                                <div class="table-responsive m-t-40" style="clear: both;">
                                    <table class="table table-hover" style="font-size: 12px">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Supplier</th>
                                                <th>No Invoice</th>
                                                <th>Tgl Invoice</th>
                                                <th>Tgl Tempo</th>
                                                <th class="text-right">Jumlah Hutang</th>
                                                <th class="text-right">Jumlah Terbayar</th>
                                                <th class="text-right">Sisa Hutang</th>
                                            </tr>
                                        </thead>
                                        <tbody>`

                                        let no = 1;
                                        let sub_total = 0;
                                        let total_dibayar = 0;
                                        let sisa_hutang = 0;

                                        $.each(data, function(k, v){
                                            let dibayar = 0;

                                            $.each(v.payment, function(k1, v1){
                                                dibayar += parseInt(v1.jml_bayar);
                                            })

                                            let sisa = v.grand_total - dibayar;
                                            

                                            html += `
                                                <tr>
                                                    <td class="text-center">${no++}</td>
                                                    <td>${v.supplier.nama_supplier}</td>
                                                    <td>${v.no_invoice}</td>
                                                    <td>${v.tgl_invoice}</td>
                                                    <td>${v.tgl_tempo}</td>
                                                    <td class="text-right">Rp. ${v.grand_total.toLocaleString(['ban', 'id'])}</td>
                                                    <td class="text-right">Rp. ${dibayar.toLocaleString(['ban', 'id'])}</td>
                                                    <td class="text-right">Rp. ${sisa.toLocaleString(['ban', 'id'])}</td>
                                                </tr>
                                            `

                                            sub_total = parseInt(v.grand_total);
                                            total_dibayar += parseInt(dibayar);
                                            sisa_hutang += parseInt(sisa);
                                        })
                                            
                html +=
                                        `</tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="pull-right m-t-30 text-right">
                                    <p>Total Hutang: Rp. ${sub_total.toLocaleString(['ban', 'id'])}</p>
                                    <p>Total Terbayar : Rp. ${total_dibayar.toLocaleString(['ban', 'id'])} </p>
                                    <hr>
                                    <h3><b>Total Sisa Hutang :</b> Rp. ${sisa_hutang.toLocaleString(['ban', 'id'])}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $('#content_hutang').html(html);
            },
            renderPayment: data => {
                console.log(data);
                let html = '';
                let list_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                let bulan = $('#bulan').val();
                let tahun = $('#tahun').val();

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
                                <div class="pull-left">
                                    <address>
                                        <img src="${BASE_URL}assets/image/scm/logo_full.png" alt="homepage" class="light-logo mb-3" style="width:200px;" /><br/>
                                        <h3> &nbsp;<b class="text-danger">PT. Mitra Adi Perkasa</b></h3>
                                        <p class="text-muted m-l-5">Sahid Sudirman Centre,  Karet Tengsin,
                                            <br> Jl. Jend. Sudirman No.Kav. 86, RT.10/RW.11,
                                            <br> Tanahabang, Kota Jakarta Pusat,
                                            <br> Daerah Khusus Ibukota Jakarta 10220</p>
                                    </address>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h4 class="mt-3">Laporan Payment Periode ${list_bulan[bulan - 1]} ${tahun}</h4>
                                <div class="table-responsive m-t-40" style="clear: both;">
                                    <table class="table table-hover" style="font-size: 12px">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Tgl Payment</th>
                                                <th>Supplier</th>
                                                <th>Bank</th>
                                                <th>Invoice</th>
                                                <th class="text-right">Total Bayar</th>
                                            </tr>
                                        </thead>
                                        <tbody>`
                                            let no = 1;
                                            let total_payment = 0;
                                            let total_invoice = 0;

                                            $.each(data, function(k, v){
                                                total_payment += parseInt(v.total_bayar);

                                                html += `
                                                    <tr>
                                                        <td class="text-center">${no++}</td>
                                                        <td>${v.tgl_payment}</td>
                                                        <td>${v.supplier.nama_supplier}</td>
                                                        <td>${v.account.nama_bank} - ${v.account.no_rekening}</td>
                                                        <td>`
                                                            $.each(v.detail, function(k1, v1){
                                                                total_invoice++;
                                                                html += `
                                                                    ${v1.no_invoice}<br/>
                                                                `
                                                            })
                                                html +=
                                                        `</td>
                                                        <td class="text-right">Rp. ${parseInt(v.total_bayar).toLocaleString(['ban', 'id'])}</td>
                                                    </tr>
                                                `
                                            })

                html +=
                                        `</tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="pull-right m-t-30 text-right">
                                    <p>Total Invoice: ${total_invoice} Invoice </p>
                                    <p>Total Payment : Rp. ${total_payment.toLocaleString(['ban', 'id'])}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $('#content_payment').html(html);
            },
            renderNoData: (content) => {
                let html = '';

                html += `
                    <div class="text-center">
                        <h4>Data tidak tersedia</h4>
                        <img src="${BASE_URL}assets/image/no_data.svg" style="height: 500px">
                    </div>
                `

                $(content).html(html);
            }
        }
    })();

    const laporanController = ((UI) => {

        const submitHutang = () => {
            $('#form_lap_hutang').validate({
                rules: {
                    bulan: "required",
                    tahun: "required"
                },
                submitHandler: function(form){
                    $.ajax({
                        url: `${BASE_URL}int/invoice/laporan`,
                        type: 'POST',
                        dataType: 'JSON',
                        data: $(form).serialize(),
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                            $('#submit_hutang').html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        success: function (res) {
                            if(res.data.length === 0){
                                UI.renderNoData('#content_hutang')
                            } else {
                                UI.renderHutang(res.data);
                            }
                        },
                        error: function (err) {
                            const { message } = err.responseJSON
                            makeNotif('error', 'Failed', message, 'bottom-right')
                        },
                        complete: function () {
                            $('#submit_hutang').html('Simpan');
                        }
                    })
                }
            })
        }

        const submitPayment = () => {
            $('#form_lap_payment').validate({
                rules: {
                    bulan: "required",
                    tahun: "required"
                },
                submitHandler: function(form){
                    $.ajax({
                        url: `${BASE_URL}int/payment/laporan`,
                        type: 'POST',
                        dataType: 'JSON',
                        data: $(form).serialize(),
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Basic " + btoa(USERNAME + ":" + PASSWORD))
                            xhr.setRequestHeader("SCM-INT-KEY", TOKEN)
                            $('#submit_payment').html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        success: function (res) {
                            if (res.data.length === 0) {
                                UI.renderNoData('#content_payment')
                            } else {
                                UI.renderPayment(res.data);
                            }
                        },
                        error: function (err) {
                            const { message } = err.responseJSON
                            makeNotif('error', 'Failed', message, 'bottom-right')
                        },
                        complete: function () {
                            $('#submit_payment').html('Simpan');
                        }
                    })
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
            init: () => {
                submitHutang();
                submitPayment();
                printAble();
            }
        }
    })(renderUI)

    laporanController.init();
})