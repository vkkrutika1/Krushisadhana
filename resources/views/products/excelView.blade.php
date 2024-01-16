@extends('layouts.defaultAdmin')
@section('content')
<br>
<div class="container">
  <div class="row justify-content-center">
    @if (Session::has('success'))
    <div class="alert alert-success">
      {{ Session::get('success') }}
    </div>
    @endif
    <br>
      <div class="row">
        <div class="col-lg-12">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
              </div>
              <div class="col-sm-6">
                <a href="{{ route('download-excel') }}" class="btn btn-primary">Download Excel</a>
              </div>
            </div>                                          
            <form action="https://sadukthi.co.in/product/import" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="hvongsHZ61f0CKQ62FN2HrN5xoSD9VD0eiJisHLT"> 
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                      <label for="">Import Product Data From Excel File</label>
                      <div class="custom-file text-left">
                        <input type="file" name="product_file" class="custom-file-input"
                              id="select_file">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
              <div class="progress" id="progress_bar" style="display:none;height:50px; line-height: 50px;">
                <div class="progress-bar" id="progress_bar_process" role="progressbar" style="width:0%;">0%</div>
              </div>
              <div id="uploaded_image" class="row mt-5"></div>
          </div>          
        </div>
      </div> 
      <div class="m-5">
        <div class="row justify-content-center">
          <div class="d-flex justify-content-between py-3"></div>
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form id="target" action="/delete-products" method="POST">
                  @csrf
                  <table id="myTable" class="table table-striped">
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
                    <tr valign="middle">
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
                      <td>{{ $product->SubCategory->SubCategoryName}}</td>
                      <td>{{ $product->BrandName}}</td>
                      <td>{{ $product->Weight}}</td>
                      <td>{{ $product->UnitOfMeasurement->UomName}}</td>
                      <td>
                        <a href="{{ route('products.view', $product->id) }}" class="btn btn-primary btn-sm">View</a>
                      </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                      <td colspan="6">Record Not Found</td>
                    </tr>
                    @endif
                  </tbody>
                  </table> 
                <div class="mt-3">
                  {{ $products->links() }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
@endsection
