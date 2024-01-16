<x-layout bodyClass="g-sidenav-show bg-gray-200">
  <x-navbars.sidebar activePage="primaries"></x-navbars.sidebar>
  <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
      <!-- Navbar -->
      <x-navbars.navs.auth titlePage='Primary'></x-navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid px-2 px-md-4">
        <div class="page-header min-height-300 border-radius-xl mt-4"
            style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
            <span class="mask  bg-gradient-primary  opacity-6"></span>
        </div>
        <div class="card card-body mx-3 mx-md-4 mt-n6">
          <div class="card card-plain h-100">
              <div class="card-header pb-0 p-3">
                  <div class="row">
                      <div class="col-md-8 d-flex align-items-center">
                          <h6 class="mb-3">Add Primary Label</h6>
                      </div>
                  </div>
              </div>
              <div class="card-body p-3">
            <form method="POST" action="{{ route('primaries.store') }}" enctype="multipart/form-data">
              @csrf      
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="input-group input-group-static mb-4">
                      <label class="ms-0">Product</label>
                      <select name="product_id" id="productid" class="form-control">
                        <option value="">Choose Product</option>
                         @foreach ($products as $product)
                           <option value="{{ $product->ProductCode }}">{{ $product->ProductName }}({{ date('d-M-Y h:i:s a', strtotime($product->created_at)) }})</option>
                         }
                         }
                         @endforeach
                      </select>
                    </div>
                    @error('is_secondary')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                  </div>
                  <div class="col-md-4">
                    <div class="input-group input-group-outline mt-4 mb-4">
                      <label class="form-label">Manufacturer Name</label>
                      <input type="text" class="form-control" id="manufacturer_name"  name="manufacturer_name" value="" readonly>
                    </div>
                    @error('manufacturer_name')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                  </div>
                  <div class="col-md-4">
                    <div class="input-group input-group-outline mb-4 mt-4">
                      <label class="form-label">Supplier Name</label>
                      <input type="text" class="form-control" id="supplier_name"  name="supplier_name" value="">
                      <input type="hidden" class="form-control" id="application_id"  name="application_id" readonly>
                    </div>
                    @error('supplier_name')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                 </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="input-group input-group-outline mb-4 mt-1">
                      <label class="form-label">Category Name</label>
                      <input type="text" class="form-control" id="category_name"  name="category_name" readonly>
                      <input type="hidden" class="form-control" id="category_id"  name="category_id" readonly>
                    </div>
                    @error('is_secondary')
                      <p class='text-danger category_name'>{{ $message }} </p>
                    @enderror
                  </div>
                  <div class="col-md-4">
                    <div class="input-group input-group-outline mb-4 mt-1">
                      <label class="form-label">SubCategory Name</label>
                      <input type="text" class="form-control" id="sub_category_name" name="sub_category_name" readonly>
                      <input type="hidden" class="form-control" id="sub_category_id" name="sub_category_id" readonly>
                    </div>
                    @error('sub_category_name')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                 </div>
                 <div class="col-md-4">
                    <div class="input-group input-group-outline mb-4 mt-1">
                      <label class="form-label">Brand Name</label>
                      <input type="text" class="form-control" id="brand_name" name="brand_name" readonly>
                    </div>
                 </div>
                  @error('brand_name')
                    <p class='text-danger inputerror'>{{ $message }} </p>
                  @enderror
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="input-group input-group-outline mb-4">
                      <label class="form-label">Weight</label>
                      <input type="text" class="form-control" id="weight" name="weight" readonly>
                    </div>
                    @error('weight')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                  </div>
                  <div class="col-md-4">
                    <div class="input-group input-group-outline mb-4">
                      <label class="form-label">Unit Of Measurement</label>
                      <input type="text" class="form-control" id="uom_name" name="uom_name" readonly>
                      <input type="hidden" class="form-control" id="uom_id" name="uom_id" readonly>
                    </div>
                    @error('uom_name')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                 </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="input-group input-group-static mb-4">
                      <label class="ms-0">Category Name</label>
                      <select name="type" class="form-control">
                       <option>Choose Type of Label:</option>
                       @foreach ($types as $type)
                         <option value="{{ $type->id }}">{{ $type->display_name }}</option>
                       @endforeach
                     </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group input-group-outline my-3 mt-4">
                      <label class="form-label">Batch Number</label>
                      <input type="text" class="form-control" id="" name="batch_no" value="">
                    </div>
                    @error('batch_no')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                 </div>
                 <div class="col-md-4">
                    <div class="input-group input-group-static mb-4">
                      <label>Manufacture Date</label>
                      <input type="date" class="form-control" id="mfg_date" name="mfg_date" onchange="checkDate(this)">
                    </div>
                 </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="input-group input-group-static mb-4">
                      <label>Expiry Date</label>
                      <input type="date" class="form-control" id="exp_date" name="exp_date" onchange="checkDate(this)">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group input-group-outline mb-4 mt-4">
                      <label class="form-label">Number of Labels</label>
                      <input type="text" class="form-control" id=""  name="quantity">
                    </div>
                    @error('quantity')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                 </div>
                 <div class="col-md-4">
                    <div class="input-group input-group-outline mb-4 mt-4">
                      <label class="form-label">MRP Price</label>
                      <input type="text" class="form-control" id="" name="mrp">
                    </div>
                    @error('mrp')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                 </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="input-group input-group-static mb-4">
                      <label class="ms-0">Choose Print or Save</label>
                      <select class="form-control" name="work">
                        <option>Select Print Or Save</option>
                        <option value="1">Save</option>
                      </select>
                    </div>
                  </div>
                </div>                                 
              </div>
              <button type="submit" class="btn bg-gradient-dark">Save</button>
            </form>
            </div>
          </div>
        </div>
      </div>
    <x-footers.auth></x-footers.auth>
    <script>
      function checkDate() {
        var mfg_date = new Date($('#mfg_date').val());
        var exp_date = new Date($('#exp_date').val());
        if (mfg_date > exp_date) {
          Swal.fire({
            icon: "error",
            title: "Expiry Date Error",
            text: "Manufacturing Date Can not Be Greater Than Expiry Date",
            showConfirmButton: true,
            dangerMode: true,
            timer: 10000
          });
          $("#exp_date").val(new Date());
        }
      }
      $(document).ready(function() {
        $('#productid').change(function() {
          var productCode = $(this).val();
          $.ajax({
            url: '/get-related-data',
            type: "GET",
            data: {
              productCode: productCode,
            },
            success: function(data, textStatus, jqXHR) {
              if (data.status = true) {
                console.log(data[0]);
                $('#application_id').val(data[0]['ApplicationID']);
                $('#manufacturer_name').val(data[0]['ManufacturerName']);
                $('#manufacturer_name').parent().addClass('is-filled');
                $('#supplier_name').val(data[0]['SupplierName']);
                $('#supplier_name').parent().addClass('is-filled');
                $('#category_id').val(data[0]['ItemCategoryID']);
                $('#category_name').val(data[0]['category']['ItemCategoryName']);
                $('#category_name').parent().addClass('is-filled');
                $('#sub_category_id').val(data[0]['SubCategoryID']);
                $('#sub_category_name').val(data[0]['SubCategoryName']);
                $('#sub_category_name').parent().addClass('is-filled');
                $('#brand_name').val(data[0]['BrandName']);
                $('#brand_name').parent().addClass('is-filled');
                $('#weight').val(data[0]['Weight']);
                $('#weight').parent().addClass('is-filled');
                $('#uom_name').val(data[0]['unit_of_measurement']['UomName']);
                $('#uom_name').parent().addClass('is-filled');
                $('#uom_id').val(data[0]['UomID']);
              } else {

              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
          });
        })
      })




      
                // --- Fz for product api --- //
    </script>
  </div>
  <x-plugins></x-plugins>
</x-layout>
