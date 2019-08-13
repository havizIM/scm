<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Detail Order</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#/order">Order</a></li>
            <li class="breadcrumb-item active">Detail Order</li>
        </ol>
    </div>
    <!-- <div class="col-md-7 col-4 align-self-center">
        <a style="float: right;" href="#/product/add" class="btn btn-md btn-info">Add</a>
    </div> -->
</div>

<div class="row" id="content_profile">
  <div class="col-md-12">
    <div class="card card-body printableArea">
      <h3><b>No Order</b> #</h3>
      <hr>
      <div class="row">
        <div class="col-md-12">
          <div class="pull-left">
            <address>
              <h3> &nbsp;<b class="text-danger">Nama Gudang</b></h3>
              <!-- <p class="text-muted m-l-5">E 104, Dharti-2,
                <br/> Nr' Viswakarma Temple,
                <br/> Talaja Road,
                <br/> Bhavnagar - 364002</p> -->
              </address>
            </div>
            <div class="pull-right text-right">
              <address>
                <h3>Nama Supplier</h3>
                <!-- <p class="text-muted m-l-30">E 104, Dharti-2,
                  <br/> Nr' Viswakarma Temple,
                  <br/> Talaja Road,
                  <br/> Bhavnagar - 364002</p> -->
                  <p class="m-t-30"><b>Invoice Date :</b> <i class="fa fa-calendar"></i> 23rd Jan 2017</p>
                  <p><b>Due Date :</b> <i class="fa fa-calendar"></i> 25th Jan 2017</p>
                </address>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive m-t-40" style="clear: both;">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Description</th>
                      <th class="text-right">Quantity</th>
                      <th class="text-right">Unit Cost</th>
                      <th class="text-right">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-center">1</td>
                      <td>Milk Powder</td>
                      <td class="text-right">2 </td>
                      <td class="text-right"> $24 </td>
                      <td class="text-right"> $48 </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-md-12">

              <hr>
              <div class="text-right">
                <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
<script>
   $.getScript(`${BASE_URL}source/int/finance/detail_order.js`)
</script>
