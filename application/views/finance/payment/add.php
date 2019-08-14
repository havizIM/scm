<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Add Payment</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#/payment">Payment</a></li>
            <li class="breadcrumb-item active">Add Payment</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="m-b-0 text-white">Form Payment</h4>
            </div>
            <div class="card-body">
                <form id="form_add">
                    <div class="form-group">
                        <label for="user">Bank Account</label>
                        <div class="input-group">
                            <input type="hidden" id="id_account" name="id_account">
                            <input type="text" id="bank_account" name="bank_account" class="form-control" placeholder="Pilih Bank..." readonly>
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-md" type="button" id="lookup_bank">Cari</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Payment</label>
                        <input type="date" class="form-control" id="tgl_payment" name="tgl_payment"> 
                    </div>
                    <div class="form-group">
                        <label for="">Total Bayar</label>
                        <input type="number" class="form-control" id="total_bayar" name="total_bayar"> 
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="t_detail_payment"> 
                                    <thead>
                                        <th style="width: 30%">No Invoice</th>
                                        <th style="width: 30%">Total Hutang</th>
                                        <th style="width: 30%">Total Dibayar</th>
                                        <th style="width: 10%"><button type="button" class="btn btn-info lookup_invoice"><i class="fa fa-plus"></i></button></th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-info btn-block btn-md" id="submit_add">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal_invoice" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Lookup Invoice</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="t_invoice" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>No Invoice</th>
                                <th>No Order</th>
                                <th>Tgl Tempo</th>
                                <th>Tgl Invoice</th>
                                <th>Supplier</th>
                                <th>Warehouse</th>
                                <th>Total Hutang</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="modal_bank" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Lookup Bank</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="t_bank" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Nama Supplier</th>
                                <th>Nama Bank</th>
                                <th>Cabang</th>
                                <th>Pemilik Account</th>
                                <th>No Rekening</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $.getScript(`${BASE_URL}source/int/finance/payment.js`)
</script>