<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Shipping</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Shipping</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="m-b-0 text-white">Data Shipping</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="t_shipping">
                        <thead>
                            <tr>
                                <th>No Shipping</th>
                                <th>No Order</th>
                                <th>Warehouse</th>
                                <th>Supplier</th>
                                <th>Tgl Shipping</th>
                                <th>Tgl Receive</th>
                                <th>Status</th>
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
    $.getScript(`${BASE_URL}source/int/finance/shipping.js`)
</script>
