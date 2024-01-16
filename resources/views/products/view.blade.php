<x-layout bodyClass="g-sidenav-show  bg-gray-200">
  <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <x-navbars.navs.auth titlePage="Tables"></x-navbars.navs.auth>
    <!-- End Navbar -->
    <div class="container-fluid py-4" id="headerOveride">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Product Details</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table table-bordered text-nowrap table-responsive">
                  <tbody>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Company Name</th>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$product->company_name}}</p>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Product Code </th>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$product->ProductCode}}</p>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Manufacturing Name </th>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$product->ManufacturerName}}
                      </p>
                    </td>
                    </tr>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Supplier Name</th>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$product->SupplierName}}</p>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Product Name</th>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$product->ProductName}}</p>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Category Name</th>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$product->Category->ItemCategoryName}}</p>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Subcategory Name</th>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$product->SubCategory->SubCategoryName}}</p>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Brand Name</th>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$product->BrandName}}</p>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Weight</th>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$product->Weight}}</p>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Unit Of Measurement</th>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$product->UnitOfMeasurement->UomName}}</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <x-footers.auth></x-footers.auth>
    </div>
  </main>
  <x-plugins></x-plugins>
</x-layout>
