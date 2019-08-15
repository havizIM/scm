<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Edit Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#/order">Order</a></li>
            <li class="breadcrumb-item active">Edit Order</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="m-b-0 text-white">Form Order</h4>
            </div>
            <div class="card-body">
                <form id="form_edit">
                    <div class="form-group">
                        <label for="user">Supplier</label>
                        <div class="input-group">
                            <input type="hidden" id="id_supplier" name="id_supplier">
                            <input type="text" id="supplier" name="supplier" class="form-control" placeholder="Pilih supplier..." readonly>
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-md" type="button" id="lookup_supplier">Cari</button>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="t_detail_product">
                                    <thead>
                                        <th style="width: 40%">Nama Product</th>
                                        <th style="width: 20%">Harga</th>
                                        <th style="width: 10%">Qty</th>
                                        <th style="width: 20%">Total Harga</th>
                                        <th style="width: 10%"><button type="button" class="btn btn-info lookup_product"><i class="fa fa-plus"></i></button></th>
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

<div id="modal_product" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Lookup Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="t_product" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>ID Product</th>
                                <th>Nama Product</th>
                                <th>Nama Kategori</th>
                                <th>Satuan</th>
                                <th>Harga</th>
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

<div id="modal_supplier" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Lookup Supplier</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="t_supplier">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>ID Supplier</th>
                                <th>Nama Supplier</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Fax</th>
                                <th>Email</th>
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

<script>
    $.getScript(`${BASE_URL}source/int/warehouse/order.js`)
    $.getScript(`${BASE_URL}source/int/warehouse/detail_order.js`)
</script>