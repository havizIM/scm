<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Edit Warehouse</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#/warehouse">Warehouse</a></li>
            <li class="breadcrumb-item active">Edit Warehouse</li>
        </ol>
    </div>
    <div class="col-md-7 col-4 align-self-center"></div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="form_edit">
                    <div class="form-group">
                        <label for="group">Group</label>
                        <div class="input-group">
                            <input type="hidden" id="id_group" name="id_group">
                            <input type="text" id="group" name="group" class="form-control" placeholder="Pilih group..." readonly>
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-md" type="button" id="lookup_group">Cari</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user">User</label>
                        <div class="input-group">
                            <input type="hidden" id="id_user" name="id_user">
                            <input type="text" id="user" name="user" class="form-control" placeholder="Pilih user..." readonly>
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-md" type="button" id="lookup_user">Cari</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_warehouse">Nama Warehouse</label>
                        <input type="text" class="form-control" name="nama_warehouse" id="nama_warehouse">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon</label>
                        <input type="text" class="form-control" name="telepon" id="telepon">
                    </div>
                    <div class="form-group">
                        <label for="fax">Fax</label>
                        <input type="text" class="form-control" name="fax" id="fax">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>

                    <div class="form-group">
                        <input type="hidden" id="id_warehouse" name="id_warehouse">
                        <a href="#/warehouse" class="btn btn-danger btn-md">Batal</a>
                        <button type="submit" class="btn btn-info btn-md" id="submit_edit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal_group" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Lookup Group</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="form_group">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="nama_group" name="nama_group" placeholder="Nama Group"> 
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="lokasi_group" name="lokasi_group" placeholder="Lokasi Group">
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block" id="submit_group">
                        Simpan
                    </button>
                </form>
            </div>
            <div class="modal-footer">
                <div class="table-responsive">
                    <table class="table table-striped" id="t_group" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>ID Group</th>
                                <th>Nama Group</th>
                                <th>Lokasi</th>
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

<div id="modal_user" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Lookup User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="t_user" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>ID User</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Jenis Kelamin</th>
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
    $.getScript(`${BASE_URL}source/int/admin/warehouse.js`)
    $.getScript(`${BASE_URL}source/int/admin/edit_warehouse.js`)
</script>