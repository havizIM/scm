<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">User</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">User</li>
        </ol>
    </div>
    <div class="col-md-7 col-4 align-self-center">
        <a style="float: right;" href="#/user/add" class="btn btn-md btn-info">Add</a>
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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="t_user">
                        <thead>
                            <tr>
                                <th>ID User</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Jenis Kelamin</th>
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
    $.getScript(`${BASE_URL}source/int/admin/user.js`)
</script>