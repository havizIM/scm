<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Payment</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Payment</li>
        </ol>
    </div>
    <div class="col-md-7 col-4 align-self-center">
        <a style="float: right;" href="#/payment/add" class="btn btn-md btn-info">Add</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="m-b-0 text-white">Data Payment</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="t_payment">
                        <thead>
                            <tr>
                                <th>No Payment</th>
                                <th>Nama Supplier</th>
                                <th>Bank</th>
                                <th>Tanggal</th>
                                <th>Total Bayar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $.getScript(`${BASE_URL}source/int/finance/payment.js`)
</script>
