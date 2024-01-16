<x-layout bodyClass="bg-gray-200">

  <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css
  " rel="stylesheet">

  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100"
        style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container mt-5" id="headerOveride">
        <div class="row signin-margin">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in</h4>
                </div>
              </div>
                

<!-- Your regular login form HTML here -->
@if (session('error'))
<div id="ERROR_COPY" style="display:none;" class="alert alert-info">
<span class="text-danger"> {{ session('error') }}</span>
</div>
@endif 

              <div class="card-body">
                <form role="form" method="POST" action="{{ route('login') }}" class="text-start">
                  @csrf
                  @if (Session::has('status'))
                  <div class="alert alert-success alert-dismissible text-white" role="alert">
                    <span class="text-sm">{{ Session::get('status') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10"data-bs-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif
                  <div class="input-group input-group-outline mt-3">
                      <label class="form-label">Email</label>
                      <input type="email" class="form-control" name="email" value="">
                  </div>
                  @error('email')
                  <p class='text-danger inputerror'>{{ $message }} </p>
                  @enderror
                  <div class="input-group input-group-outline mt-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" value="">
                  </div>
                  @error('password')
                  <p class='text-danger inputerror'>{{ $message }} </p>
                  @enderror
                  <div class="form-check form-switch d-flex align-items-center my-3">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label mb-0 ms-2" for="rememberMe">Remember
                          me</label>
                  </div>
                  <div class="text-center">
                      <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Sign
                          in</button>
                  </div>
                  <!-- <p class="mt-4 text-sm text-center">
                      Don't have an account?
                      <a href="{{-- route('register') --}}"
                          class="text-primary text-gradient font-weight-bold">Sign up</a>
                  </p> -->
                  <p class="text-sm text-center">
                    Forgot your password? Reset your password
                    <a href="{{ route('verify') }}" class="text-primary text-gradient font-weight-bold">here</a>
                  </p>
                </form>

                <Script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></Script>
                <script src="
                    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js
                "></script>

                <script>

                 // var has_errors={{'error' ? 'true':'false'}};
                 var has_errors=document.querySelector('#ERROR_COPY');

                  if(has_errors!==null){
                    Swal.fire({
                    title: 'Account Suspended',
                    icon: 'error',
                    html:
                      'Your Account is Suspended, Please Contact Your Admin',
                    showCloseButton: true,
  
                      });
                  }
                
                </script>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  @push('js')
<script src="{{ asset('assets') }}/js/jquery.min.js"></script>
<script>
  $(function() {
    var text_val = $(".input-group input").val();
    if (text_val === "") {
      $(".input-group").removeClass('is-filled');
    } else {
      $(".input-group").addClass('is-filled');
    }
  });
</script>
@endpush
</x-layout>