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
                  <h6 class="mb-3">Download Primary Labels</h6>
                </div>
              </div>
            </div>
            <div class="card-body p-3">
            <form method="POST" action="{{ route('primaryprint', $primary->id) }}" enctype="multipart/form-data">
              @csrf      
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="input-group input-group-outline @error('to') is-filled @enderror">
                      <label class="form-label">From</label>
                      <input type="text" class="form-control" id=""  name="from" required value="{{ old('from') }}">
                    </div>
                    @error('from')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                  </div>
                  <div class="col-md-4">
                    <div class="input-group input-group-outline @error('to') is-filled @enderror">
                      <label class="form-label">To</label>
                      <input type="text" class="form-control" id="" name="to" required value="{{ old('to') }}">
                    </div>
                    @error('to')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                  </div>
                  <div class="col-md-4">
                    <div class="input-group input-group-outline mb-4 is-filled">
                      <label class="form-label">Total Primary Labels Available</label>
                      <input type="text" class="form-control" id="" value="{{ $primary->quantity }}" readonly>
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
  </div>
  <x-plugins></x-plugins>
</x-layout>
