<x-layout bodyClass="g-sidenav-show bg-gray-200">
  <x-navbars.sidebar activePage="products"></x-navbars.sidebar>
  <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
      <!-- Navbar -->
      <x-navbars.navs.auth titlePage='Add Product'></x-navbars.navs.auth>
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
                          <h6 class="mb-3">Add Product</h6>
                      </div>
                  </div>
              </div>
              <div class="card-body p-3">
                  @if (session('status'))
                  <div class="row">
                      <div class="alert alert-success alert-dismissible text-white" role="alert">
                          <span class="text-sm">{{ Session::get('status') }}</span>
                          <button type="button" class="btn-close text-lg py-3 opacity-10"
                              data-bs-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                  </div>
                  @endif
                  @if (Session::has('demo'))
                          <div class="row">
                              <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                  <span class="text-sm">{{ Session::get('demo') }}</span>
                                  <button type="button" class="btn-close text-lg py-3 opacity-10"
                                      data-bs-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                          </div>
                  @endif

            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
              @csrf      
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                     <div class="input-group input-group-static mb-4">
                       <label class="ms-0">Is Secondary Label Needed</label>
                       <select name="is_secondary" class="form-control">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                      </select>
                      @error('is_secondary')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                      @enderror
                     </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group input-group-static mb-3">
                      <label class="ms-0">Application Id</label>
                      <select class="form-control" name="ApplicationID" id="jsApplicationID">
                      @if ($applications)
                      <option value="">Choose Application</option>
                      @foreach ($applications as $application)
                      <option value="{{ $application->ApplicationID }}">{{ $application->ApplicationName }}</option>
                      @endforeach
                      @endif
                    </select>
                     </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-group input-group-outline my-3 is-filled">
                      <label class="form-label">Company Name</label>
                      <input type="text" class="form-control" id="company_name"  name="company_name" value="{{Auth::user()->UserProfile->company_name}}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group input-group-outline my-3 is-filled">
                      <label class="form-label">Manufacturer Name</label>
                      <input type="text" class="form-control" id="ManufacturerName" name="ManufacturerName" value="{{Auth::user()->UserProfile->company_name}}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-group input-group-outline my-3 is-filled">
                      <label class="form-label">Supplier/RC Holder Name</label>
                      <input type="text" class="form-control" name="SupplierName" value="{{Auth::user()->UserProfile->company_name}}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group input-group-outline my-3 is-filled">
                      <label class="form-label">Marketed By</label>
                      <input type="text" class="form-control" id="MarketedBy" name="MarketedBy" value="{{Auth::user()->UserProfile->company_name}}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-group input-group-outline mb-4 mt-4">
                      <label class="form-label">Product Name</label>
                      <input type="text" class="form-control" id="ProductName" name="ProductName">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                      <label class="ms-0">Category Name</label>
                      <!-- <span id='jsCatContainer'> -->
                        <select name="ItemCategoryID" class="form-control" id="ItemCategoryID">
                          @if ($categories)
                          <option value="">Choose Category</option>
                          @foreach ($categories as $category)
                          <option value="{{ $category->ItemCategoryID }}">{{ $category->ItemCategoryName }}</option>
                          @endforeach
                          @endif
                        </select>
                      <!-- </div> -->
                      @error('is_secondary')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                      @enderror
                     </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                      <label class="ms-0">Subcategory Name</label>
                      <!-- <span id='jsCatContainer'> -->
                        <select name="SubCategoryID" id="SubCategoryID" class="form-control">
                          <option value="">Choose SubCategory</option>
                          @if ($subcategories)
                          @foreach ($subcategories as $subcategory)
                          <option value="{{ $subcategory->SubCategoryID }}">{{ $subcategory->SubCategoryName }}</option>
                          @endforeach
                          @endif
                        </select>
                      <!-- </div> -->
                      @error('is_secondary')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                      @enderror
                     </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group input-group-static mb-4 d-none">
                      <label class="ms-0">Item Name</label>
                      <!-- <span id='jsCatContainer'> -->
                        <select name="ItemID" class="form-control" id="ItemID">
                          <option value="">Choose Item</option>
                        </select>
                      <!-- </div> -->
                      @error('is_secondary')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                      @enderror
                    </div>
                    <div class="input-group input-group-outline my-3 mt-4 d-none">
                      <label class="form-label">Other</label>
                      <input type="text" class="form-control" id="jsSubOther" name="other">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-group input-group-outline my-3 mb-4">
                      <label class="form-label">Brand Name</label>
                      <input type="text" class="form-control" id="BrandName" name="BrandName">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group input-group-outline my-3">
                      <label class="form-label">Net Weight</label>
                      <input type="number" class="form-control" id="Weight" step="1" name="Weight" min="1">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                      <label class="ms-0">Unit of Measurement</label>
                      <!-- <span id='jsCatContainer'> -->
                        <select class="form-control" name="UomID" id="UomID">
                          <option value="">Choose Unit of Measurement</option>
                          @if ($guoms)
                          @foreach ($guoms as $guom)
                          <option value="{{ $guom->UomID }}">{{ $guom->UomName }}</option>
                          @endforeach
                          @endif
                        </select>
                      <!-- </div> -->
                      @error('is_secondary')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                      @enderror
                     </div>
                  </div>

                </div>

              </div>

             
              <div class="card-footer">
                <button type="submit" class="btn bg-gradient-dark">Submit</button>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    <x-footers.auth></x-footers.auth>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#jsApplicationID').change(function() {
          var applicationID = $(this).val();
          $.ajax({
            url: '/get-product-category',
            type: "GET",
            data: {
             applicationID : applicationID,
            },
            success: function(data, textStatus, jqXHR) {
              $('#ItemCategoryID').replaceWith(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
          });
        })
        $(document).on("change", '#SubCategoryID', function() {
          var subCategoryID = $(this).val();
          var applicationID = $('#jsApplicationID').val();
          console.log('came in', subCategoryID);
          console.log('came in', applicationID);
          if (applicationID == 'SD' && subCategoryID == 4) {
            $('#jsSubOther').parent().removeClass('d-none');
          } else {
            $('#jsSubOther').parent().addClass('d-none');
          }
        });
        $('#jsApplicationID').change(function() {
          var applicationID = $(this).val();
          $('#jsSubOther').parent().addClass('d-none');
          $.ajax({
            url: '/get-product-subcategory',
            type: "GET",
            data: {
              applicationID: applicationID,
            },
            success: function(data, textStatus, jqXHR) {
              $('#SubCategoryID').replaceWith(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
          });
        })
        $('#jsApplicationID').change(function() {
          var applicationID = $(this).val();
          $.ajax({
            url: '/get-product-items',
            type: "GET",
            data: {
              applicationID: applicationID,
            },
            success: function(data, textStatus, jqXHR) {
              if (data) {
                $('#ItemID').replaceWith(data);
                $('#ItemID').parent().removeClass('d-none');
              } else {
                $('#ItemID').parent().addClass('d-none');
              }
              
            },
            error: function(jqXHR, textStatus, errorThrown) {
            }
          });
        })
      })
    </script>
  </div>
  <x-plugins></x-plugins>
</x-layout>
