<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#/order">Order</a></li>
            <li class="breadcrumb-item active">Add Order</li>
        </ol>
    </div>
    <div class="col-md-7 col-4 align-self-center">
        <a style="float: right;" href="#/order/add" class="btn btn-md btn-info">Add</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Add Order</h4>
                <form id="form_add">
                    <div class="form-group">
                        <label for="user">Supplier</label>
                        <div class="input-group">
                            <input type="hidden" id="id_supplier" name="id_supplier">
                            <input type="text" id="supplier" name="supplier" class="form-control" placeholder="Pilih supplier..." readonly>
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-md" type="button" id="lookup_user">Cari</button>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table" id="t_detail_product">
                                    <thead>
                                        <th>Nama Product</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Total Harga</th>
                                        <th><button type="button" class="btn btn-info lookup_product"><i class="fa fa-plus"></i></button></th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-info btn-block btn-md">Submit</button>
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

<script>
    $.getScript(`${BASE_URL}source/int/warehouse/order.js`)
</script>