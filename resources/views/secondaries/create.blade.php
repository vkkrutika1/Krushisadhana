<x-layout bodyClass="g-sidenav-show bg-gray-200">
  <x-navbars.sidebar activePage="secondaries"></x-navbars.sidebar>
  <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
      <!-- Navbar -->
      <x-navbars.navs.auth titlePage='Add Secondary Label'></x-navbars.navs.auth>
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
                  <h6 class="mb-3">Add Secondary Label</h6>
                </div>
              </div>
            </div>
            <div class="card-body p-3">
            <form method="POST" action="{{ route('secondaries.store') }}" enctype="multipart/form-data">
              @csrf      
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                     <div class="input-group input-group-static mb-4">
                       <label class="ms-0">Choose Product with Batch Number</label>
                       <select name="labelid" id="labelid" class="form-control">
                        <option value="">Choose Product with Batch Number</option>
                        @foreach ($primaries as $primary)
                          <option value="{{ $primary->id }}">{{ $primary->Product->ProductName }} ({{ $primary->BatchNumber }}) ({{ date('d-M-Y h:i:s a', strtotime($primary->created_at)) }})</option>
                        @endforeach
                      </select>
                      @error('is_secondary')
                      <p class='text-danger inputerror'>{{ $message }} </p>
                      @enderror
                     </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group input-group-outline mb-4 mt-4">
                      <label class="form-label">Total No. of Primary Labels Available</label>
                      <input type="text" class="form-control" id="quantity" name="quantity" readonly>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-group input-group-outline my-3">
                      <label class="form-label">Required No. of Primary Labels in One Secondary</label>
                      <input type="text" class="form-control" id="" name="label_numbers">
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
    <script>
      $(document).ready(function() {
        $('#labelid').change(function() {
          var id = $(this).val();
            if (id != "") {
            $.ajax({
              url: '/get-srelated-data',
              type: "GET",
              data: {
                id: id,
              },
              success: function(data, textStatus, jqXHR) {
                if (data != "") {
                  $('#quantity').val(data);
                  $('#quantity').parent().addClass('is-filled');
                }
              },
              error: function(jqXHR, textStatus, errorThrown) {
              }
            });
          } else {
            $('#quantity').empty();
          }
        })
      })
    </script>
  </div>
  <x-plugins></x-plugins>
</x-layout>
