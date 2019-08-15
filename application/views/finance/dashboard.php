
<style media="screen">
  .welcome{
    text-transform: uppercase;
    letter-spacing:20px;
    font-weight:bold;
    text-align: center;
  }
</style>


<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>

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
<div class="row" style="margin-top:75px;">
  <div class="col-md-12" style="margin-bottom:50px;">
    <h1 class="welcome animated bounceInDown" style="animation-delay:0.1s;">Selamat datang</h1>
    <h4 class="text-center animated bounceInDown">Sistem Informasi Suply Chain Management</h4>
  </div>
  <div class="col-md-3">
    <div class="card animated bounceInRight">
      <div class="card-body">
        <div class="d-flex flex-row">
          <div class="round round-lg align-self-center round-danger"><i class="fas fa-inbox"></i></div>
          <div class="m-l-10 align-self-center">
            <h3 class="m-b-0 font-lgiht" id="data1">0</h3>
            <h5 class="text-muted m-b-0">Total Order</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card animated bounceInRight" style="animation-delay:0.1s;">
      <div class="card-body">
        <div class="d-flex flex-row">
          <div class="round round-lg align-self-center round-warning"><i class="fas fa-inbox"></i></div>
          <div class="m-l-10 align-self-center">
            <h3 class="m-b-0 font-lgiht" id="data2">0</h3>
            <h5 class="text-muted m-b-0">Total Shipping</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card animated bounceInRight" style="animation-delay:0.2s;">
      <div class="card-body">
        <div class="d-flex flex-row">
          <div class="round round-lg align-self-center round-primary"><i class="fas fa-file"></i></div>
          <div class="m-l-10 align-self-center">
            <h3 class="m-b-0 font-lgiht" id="data3">0</h3>
            <h5 class="text-muted m-b-0">Total Invoice</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card animated bounceInRight" style="animation-delay:0.3s;">
      <div class="card-body">
        <div class="d-flex flex-row">
          <div class="round round-lg align-self-center round-success"><i class="fas fa-money"></i></div>
          <div class="m-l-10 align-self-center">
            <h3 class="m-b-0 font-lgiht" id="data4">0</h3>
            <h5 class="text-muted m-b-0">Total Payment</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $.getScript(`${BASE_URL}source/int/finance/dashboard.js`)
</script>
