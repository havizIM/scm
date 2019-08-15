<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Edit Invoice</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#/invoice">Invoice</a></li>
            <li class="breadcrumb-item active">Edit Invoice</li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="m-b-0 text-white">Form Invoice</h4>
            </div>
            <div class="card-body">
                <form id="form_edit">
                    <div class="form-group">
                        <label for="user">Order</label>
                        <div class="input-group">
                            <input type="hidden" id="no_order" name="no_order">
                            <input type="text" id="order" name="order" class="form-control" placeholder="Pilih Order..." readonly>
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-md" type="button" id="lookup_order">Cari</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Tempo</label>
                        <input type="date" class="form-control" id="tgl_tempo" name="tgl_tempo">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="t_detail_order">
                                    <thead>
                                        <th style="width: 40%">Deskripsi</th>
                                        <th style="width: 25%">Harga</th>
                                        <th style="width: 10%">Qty</th>
                                        <th style="width: 25%">Total Harga</th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-info btn-block btn-md" id="submit_edit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal_order" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Lookup Order</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="t_order">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>No Order</th>
                                <th>Warehouse</th>
                                <th>Supplier</th>
                                <th>Status</th>
                                <th>Tanggal</th>
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
    $.getScript(`${BASE_URL}source/ext/invoice.js`)
    $.getScript(`${BASE_URL}source/ext/detail_invoice.js`)
</script>