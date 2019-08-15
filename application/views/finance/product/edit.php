<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Edit Product</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#/product">Product</a></li>
            <li class="breadcrumb-item active">Edit Product</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="m-b-0 text-white">Form Product</h4>
            </div>
            <div class="card-body">
                <form id="form_edit">
                    <div class="form-group">
                        <label for="user">Category</label>
                        <div class="input-group">
                            <input type="hidden" id="id_category" name="id_category">
                            <input type="text" id="category" name="category" class="form-control" placeholder="Pilih Category..." readonly>
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-md" type="button" id="lookup_category">Cari</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user">Supplier</label>
                        <div class="input-group">
                            <input type="hidden" id="id_supplier" name="id_supplier">
                            <input type="text" id="supplier" name="supplier" class="form-control" placeholder="Pilih Supplier..." readonly>
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-md" type="button" id="lookup_supplier">Cari</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Product</label>
                        <input type="text" id="nama_product" name="nama_product" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Satuan</label>
                        <input type="text" id="satuan" name="satuan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Harga</label>
                        <input type="text" id="harga" name="harga" class="form-control">
                    </div>
                    <input type="hidden" id="id_product" name="id_product" class="form-control">
                    <button class="btn btn-info btn-block btn-md" id="submit_edit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal_category" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Lookup Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="form_category">
                    <div class="form-group">
                        <label for="">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_category" name="nama_category">
                    </div>
                    <button class="btn btn-primary btn-block" id="submit_category">Simpan</button>
                </form>
            </div>
            <div class="modal-footer">
                <div class="table-responsive">
                    <table class="table table-striped" id="t_category" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>ID Category</th>
                                <th>Nama Category</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
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
    $.getScript(`${BASE_URL}source/int/finance/product.js`)
    $.getScript(`${BASE_URL}source/int/finance/detail_product.js`)
</script>