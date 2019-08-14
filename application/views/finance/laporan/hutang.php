<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Laporan Hutang</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Laporan Hutang</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="m-b-0 text-white">Filter Laporan Hutang</h4>
            </div>
            <div class="card-body">
                <form id="form_lap_hutang">
                    <div class="form-group">
                        <label for="">Bulan</label>
                        <select name="bulan" id="bulan" class="form-control">
                            <option value="">-</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tahun</label>
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="">-</option>
                            <option value="2019">2019</option>
                            <option value="2018">2018</option>
                            <option value="2017">2017</option>
                        </select>
                    </div>
                    <button class="btn btn-md btn-block btn-info" id="submit_hutang">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12" id="content_hutang">

        <!-- LOAD CONTENT -->
        
    </div>
</div>

<script>
    $.getScript(`${BASE_URL}source/int/finance/laporan.js`)
</script>