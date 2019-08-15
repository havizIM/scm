<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Edit User</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#/user">User</a></li>
            <li class="breadcrumb-item active">Edit User</li>
        </ol>
    </div>
    <div class="col-md-7 col-4 align-self-center">
        
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="m-b-0 text-white">Form User</h4>
            </div>
            <div class="card-body">
                <form id="form_edit">
                    <div class="form-group">
                            <label for="nama_lengkap">Nama</label>
                        <input type="hidden" class="form-control id_user" name="id_user">
                        <input type="text" class="form-control nama_lengkap" name="nama_lengkap">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon</label>
                        <input type="number" class="form-control telepon" name="telepon">
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control jk" id="jk">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control alamat" name="alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="level">Level</label>
                        <select class="form-control level" name="level">
                            <option value=""> -- Pilih Level -- </option>
                            <option value="Finance">Finance</option>
                            <option value="Warehouse">Warehouse</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control status" name="status">
                            <option value=""> -- Pilih Status -- </option>
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <a href="#/user" class="btn btn-danger btn-md">Batal</a>
                        <button type="submit" class="btn btn-info btn-md" id="submit_edit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $.getScript(`${BASE_URL}source/int/admin/detail_user.js`)
</script>