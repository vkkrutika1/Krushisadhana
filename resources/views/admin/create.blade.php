<x-layout bodyClass="g-sidenav-show bg-gray-200">
  <x-navbars.sidebar activePage="user-management"></x-navbars.sidebar>
  <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
      <!-- Navbar -->
      <x-navbars.navs.auth titlePage='Add User'></x-navbars.navs.auth>
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
                      <h6 class="mb-3">Add User</h6>
                    </div>
                    <!-- <div class="col-md-4 my-2 text-end">
                      <a class="btn bg-gradient-dark mb-2" href="{{ route('users.index') }}"><i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center"></i>&nbsp;&nbsp;User List</a>
                    </div> -->
                  </div>
              </div>
              <div class="card-body p-3">
            <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
              @csrf      
              <div class="card-body">
               <div class="row">
                  <div class="col-md-4">
                    <div class="input-group input-group-outline my-1 @if (old('name')) is-filled @endif">
                      <label class="form-label">Name</label>
                      <input type="text" name="name" class="form-control" value='{{ old('name') }}'>
                    </div>
                    @error('name')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                  </div>
                  <div class="col-md-4">
                    <div class="input-group input-group-outline my-1 @if (old('email')) is-filled @endif">
                      <label class="form-label">Email Address</label>
                      <input type="email" name="email" class="form-control" value='{{ old('email') }}'>
                    </div>
                    @error('email')
                    <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                  </div>
                  <div class="col-md-4">
                    <div class="input-group input-group-outline my-1 @if(old('phone')) is-filled @endif">
                      <label class="form-label">Phone number</label>
                      <input type="text" name="phone" class="form-control" value='{{ old('phone') }}'>
                    </div>
                    @error('phone')
                    <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-group input-group-outline my-3 @if(old('password')) is-filled @endif">
                      <label class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" value='{{ old('password') }}'>
                    </div>
                    @error('password')
                    <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                  </div>
                  <div class="col-md-6">
                    <div class="input-group input-group-outline my-3 @if(old('password_confirmation')) is-filled @endif">
                      <label class="form-label">Confirm Password</label>
                      <input type="password" name="password_confirmation" class="form-control border border-2 p-2" value='{{ old('password_confirmation') }}'>
                    </div>
                    @error('password_confirmation')
                    <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                  </div>
                </div>
                <button type="submit" class="btn bg-gradient-dark">Submit</button>
              </div>
              <div class="card-footer">
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    <x-footers.auth></x-footers.auth>
  <x-plugins></x-plugins>
</x-layout>
