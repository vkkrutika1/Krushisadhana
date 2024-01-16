<x-layout bodyClass="g-sidenav-show  bg-gray-200">

  <x-navbars.sidebar activePage="primaries"></x-navbars.sidebar>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <x-navbars.navs.auth titlePage="Primary Label Management"></x-navbars.navs.auth>
    <!-- End Navbar -->
    <div class="container-fluid py-4" id="headerOveride">
      <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white mx-3">{{$primary->Product->ProductName}}</h6>
                    </div>
                </div>
                <div class=" me-3 my-3 text-end">
                  <!-- <a class="btn bg-gradient-dark mb-0" href="{{ route('primaries.create') }}"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Primary</a> -->
                  <a href="{{ route('primaries.printLabel', $primary->id) }}" class="btn bg-gradient-dark mb-0"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Print Label</a>
                </div>
                <div class="card-body px-0 pb-2">
                  <div class="row">
                    <div class="col-sm-3">
                      <h4 class="text-center">{{$primary->Product->ProductCode}}</h4>
                    </div>
                    <div class="col-sm-3">
                      <h4 class="text-center">{{$primary->ManufacturerName}}</h4>
                    </div>
                    <div class="col-sm-3">
                      <h4 class="text-center">{{$primary->SupplierName}}</h4>
                    </div>
                    <div class="col-sm-3">
                      <h4 class="text-center">{{$primary->Category->ItemCategoryName}}</h4>
                    </div>
                    <div class="col-sm-3">
                      <h4 class="text-center">{{$primary->SubCategoryName}}</h4>
                    </div>
                    <div class="col-sm-3">
                      <h4 class="text-center">{{$primary->quantity}}</h4>
                    </div>
                    <div class="col-sm-3">
                      <h4 class="text-center">{{$primary->Weight}}</h4>
                    </div>
                    <div class="col-sm-3">
                      <h4 class="text-center">{{$primary->BrandName}}</h4>
                    </div>
                    <div class="col-sm-3">
                      <h4 class="text-center">{{$primary->ManufactureDate}}</h4>
                    </div>
                    <div class="col-sm-3">
                      <h4 class="text-center">{{$primary->ExpiryDate}}</h4>
                    </div>
                    <div class="col-sm-3">
                      <h4 class="text-center">{{$primary->mrp}}</h4>
                    </div>
                    <div class="col-sm-3">
                        <h4 class="text-center">(Min.) 98%</h4>
                    </div>
                    <div class="col-sm-3">
                        <h4 class="text-center">(Max.)2.0%</h4>
                    </div>
                    <div class="col-sm-3">
                        <h4 class="text-center">(Max.)10/Kg</h4>
                    </div>
                    <div class="col-sm-3">
                        <h4 class="text-center">(Max.)10/Kg</h4>
                    </div>
                    <div class="col-sm-3">
                        <h4 class="text-center">(Min.)80%</h4>
                    </div>
                    <div class="col-sm-3">
                        <h4 class="text-center">(Min.)10%</h4>
                    </div>
                    <div class="col-sm-3">
                      <h4 class="text-center">
                        <img src="no" width="50px" alt="">
                      </h4>
                    </div>
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