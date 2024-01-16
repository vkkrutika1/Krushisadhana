<div class="card card-plain h-100">
  <div class="card-header pb-0 p-3">
        <div class="row">
          <div class="col-md-8 d-flex align-items-center">
            <h6 class="mb-3">Check Product</h6>
          </div>
          <!-- <div class="col-md-4 my-2 text-end">
            <a class="btn bg-gradient-dark mb-2" href="{{ route('users.index') }}"><i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center"></i>&nbsp;&nbsp;User List</a>
          </div> -->
        </div>
  </div>
  <div class="card-body p-3">
      <form method="POST" action="{{ route('status.checkProduct') }}" enctype="multipart/form-data">
        @csrf      
        <div class="card-body">
         <div class="row">
            <div class="col-md-4">
              <div class="input-group input-group-outline my-1 @if (old('productCode')) is-filled @endif">
                <label class="form-label">Product Code</label>
                <input type="text" name="productCode" class="form-control" value='{{ old('productCode') }}'>
              </div>
              @error('productCode')
                <p class='text-danger inputerror'>{{ $message }} </p>
              @enderror
            </div>
            <div class="col-md-4">
              <button type="submit" class="btn bg-gradient-dark">Submit</button>
            </div>
          </div>
        </div>
      </form>
  </div>
</div>