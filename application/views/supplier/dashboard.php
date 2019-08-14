<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
    </div>
</div>

<div class="container-fluid">
    <div class="text-center" style="margin-bottom:50px;">
        <h1 class=" animated bounceInDown" style="animation-delay:0.2s; letter-spacing:20px; text-transform:uppercase; font-weight:bold;"> Welcome</h1>
        <h4 class=" animated bounceInDown mb-2" style="animation-delay:0.1s;">Sistem Informasi Supply Chain Management</h2>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card animated bounceInLeft">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 fa-5x text-center">
                            <i class="fas fa-cart-plus text-danger"></i>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 text-center font-20">
                                    Total Order
                                </div>
                                <div class="col-md-12 text-center mt-2"  style="font-size:40px;" id="data1">0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card animated bounceInRight">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 fa-5x text-center">
                            <i class="fas fa-dolly-flatbed text-info"></i>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 mt-2 text-center font-20">
                            Total Shipping
                        </div>
                        <div class="col-md-12 mt-2 font-20 text-center mt-3" style="font-size:30px;" id="data2">0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card animated bounceInUp" style="animation-delay:0.1s;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 fa-3x text-center">
                            <i class="fas fa-file-invoice-dollar text-warning"></i>
                        </div>
                        <div class="col-md-6 mt-2 text-center" style="border-right: 2px solid black">
                            Total Invoice
                        </div>
                        <div class="col-md-6 mt-2 font-20 text-center" id="data3">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card animated bounceInUp" style="animation-delay:0.2s;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 fa-3x text-center">
                            <i class="fas fa-box text-success"></i>
                        </div>
                        <div class="col-md-6 mt-2 text-center" style="border-right: 2px solid black">
                            Total Product
                        </div>
                        <div class="col-md-6 mt-2 font-20 text-center" id="data4">0</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 animated bounceInUp" style="animation-delay:0.3s;">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 fa-3x text-center">
                            <i class="fas fa-paste text-danger"></i>
                        </div>
                        <div class="col-md-6 mt-2 text-center" style="border-right: 2px solid black">
                            Total Payment
                        </div>
                        <div class="col-md-6 mt-2 font-20 text-center" id="data5">0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
   $.getScript(`${BASE_URL}source/ext/dashboard.js`)
</script>
