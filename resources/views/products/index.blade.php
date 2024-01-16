<x-layout bodyClass="g-sidenav-show  bg-gray-200">
  <x-navbars.sidebar activePage="products"></x-navbars.sidebar>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <x-navbars.navs.auth titlePage="Product Management"></x-navbars.navs.auth>
    <!-- End Navbar -->
    <div class="container-fluid py-4" id="headerOveride">
      <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white mx-3">Products List</h6>
                    </div>
                </div>
                <div class=" me-3 my-3 text-end">
                  <a class="btn bg-gradient-dark mb-0" href="{{ route('products.create') }}"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Product</a>
                </div>
                <div class="card-body px-0 pb-2">
                  <div class="table-responsive p-0">
                    <form id="target" action="/delete-products" method="POST">
                      @csrf
                      <table id="tableContent" class="table table-striped" style="width:100%"> 
                        <thead>
                          <tr>
                            <th>Company Name</th>
                            <th>Product Name</th>
                            <th>Is Secondary is there</th>
                            <th>Product Created Date</th>
                            <th>Product Code</th>
                            <th>Manufacturer Name</th>
                            <th>Supplier Name</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Brand Name</th>
                            <th>Weight</th>
                            <th>Unit of Measurement</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @if ($products->isNotEmpty())
                          @foreach ($products as $product)
                          <tr valign="middle" class="<?php echo $product->api_sync_status?'synced':'not_synced'?>">
                            <td>{{ $product->company_name}}</td>
                            <td>{{ $product->ProductName}}</td>
                            <td>
                              @if($product->is_secondary == 1)
                                Yes
                              @else
                                No
                              @endif
                            </td>
                            <td>{{ date('d-M-Y h:i:s a', strtotime($product->created_at))}}</td>
                            <td>{{ $product->ProductCode}}</td>
                            <td>{{ $product->ManufacturerName}}</td>
                            <td>{{ $product->SupplierName}}</td>
                            <td>{{ $product->Category->ItemCategoryName}}</td>
                            <td>{{ $product->SubCategoryName}}</td>
                            <td>{{ $product->BrandName}}</td>
                            <td>{{ $product->Weight}}</td>
                            <td>{{ $product->UnitOfMeasurement->UomName}}</td>
                            <td>
                              <a href="{{ route('products.view', $product->id) }}" class="btn btn-primary btn-sm">View</a>
                            </td>
                          </tr>
                          @endforeach
                          @endif
                        </tbody>
                      </table>
                    </form>
                    
                  </div>
                </div>
            </div>
        </div>
      </div>
      <x-footers.auth></x-footers.auth>
    </div>
    <script>
      $(document).ready(function() {
        $('#tableContent').DataTable( {
          scrollX: true,
          fixedHeader: false,
          dom: 'Bfrtip',
          language: {
            emptyTable: "Currently no data available in table"
          },
          aaSorting: [],
          columnDefs: [
            {
              targets: 1,
              className: 'noVis'
            }
          ],
          buttons: [
            {
              extend: 'colvis',
              columns: ':not(.noVis)'
            },
            'copy', 'excel', 'pdf'
          ]
        });
        $('#selectAll').click(function() {
          $('.dynamicCheckbox').prop('checked', $(this).prop('checked'));
        });
        $('.dynamicCheckbox').click(function() {
          if ($('.dynamicCheckbox:checked').length === $('.dynamicCheckbox').length) {
            $('#selectAll').prop('checked', true);
          } else {
            $('#selectAll').prop('checked', false);
          }
        });
      });

      function deleteproducts() {
        event.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
          buttonsStyling: false
        })

        Swal.fire({
          title: 'Are you sure?',
          text: 'You want to delete this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!'
        }).then((result) => {
          if (result.isConfirmed) {
            $("#target").submit();
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire(
              'Cancelled',
              'product is safe :)',
              'error'
            )
          }
        })
      }
    </script>
  </main>
  <x-plugins></x-plugins>
</x-layout>