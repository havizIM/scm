<div class="row page-titles">
    <div class="col-md-6 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Invoice</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Invoice</li>
        </ol>
    </div>
    <div class="col-md-6 col-8 text-right">
        <a href="#/invoice/add" class="btn btn-md btn-info">Add</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="m-b-0 text-white">Data Invoice</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="t_invoice">
                        <thead>
                            <tr>
                                <th>No Invoice</th>
                                <th>No Order</th>
                                <th>Warehouse</th>
                                <th>Supplier</th>
                                <th>Tgl Invoice</th>
                                <th>Tgl Tempo</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
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
    $.getScript(`${BASE_URL}source/ext/invoice.js`)
</script>