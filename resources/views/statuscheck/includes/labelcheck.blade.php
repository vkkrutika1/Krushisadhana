<div class="card card-plain h-100">
  <div class="card-header pb-0 p-3">
    <div class="row">
      <div class="col-md-8 d-flex align-items-center">
        <h6 class="mb-3">Check Primary/Secondary Label Status</h6>
      </div>
        <!-- <div class="col-md-4 my-2 text-end">
          <a class="btn bg-gradient-dark mb-2" href="{{ route('users.index') }}"><i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center"></i>&nbsp;&nbsp;User List</a>
        </div> -->
    </div>
  </div>
  <div class="card-body p-3">
    <form method="POST" action="{{ route('status.checkLabel') }}" enctype="multipart/form-data">
      @csrf      
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="input-group input-group-outline mt-4 @if (old('qrCode')) is-filled @endif">
              <label class="form-label">QrCode</label>
              <input type="text" name="qrCode" class="form-control" value='{{ old('qrCode') }}'>
            </div>
            @error('qrCode')
              <p class='text-danger inputerror'>{{ $message }} </p>
            @enderror
          </div>
          <div class="col-md-4">
            <div class="input-group input-group-static @if (old('type')) is-filled @endif">
              <label>Type</label>
              <select name="type" class="form-control">
                <option value="primary">Primary</option>
                <option value="secondary">Secondary</option>
              </select>
            </div>
            @error('type')
              <p class='text-danger inputerror'>{{ $message }} </p>
            @enderror
          </div>
          <div class="col-md-4 mt-4">
            <button type="submit" class="btn bg-gradient-dark">Submit</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>