<x-layout bodyClass="g-sidenav-show bg-gray-200">
  <x-navbars.sidebar activePage="status"></x-navbars.sidebar>
  <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
      <!-- Navbar -->
      <x-navbars.navs.auth titlePage='Status check'></x-navbars.navs.auth>
      <!-- End Navbar -->
      <div class="container-fluid px-2 px-md-4">
        <div class="page-header min-height-300 border-radius-xl mt-4"
            style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
            <span class="mask  bg-gradient-primary  opacity-6"></span>
        </div>
        <div class="card card-body mx-3 mx-md-4 mt-n6">
         @include('statuscheck.includes.labelcheck')
         @include('statuscheck.includes.productcheck')
        <div class="card-footer">
         @if (session('result'))
          <div class="alert alert-primary text-white">
            <table>
            <?php 
              $result = session('result'); 
              $result = json_decode($result, true);
              foreach($result as $label=>$value) {
                echo "<tr><th>".$label."</th><td>".$value."</td></tr>";
              }

            ?>
          </table>
          </div>
          @endif 
        </div>
        </div>
      </div>
    <x-footers.auth></x-footers.auth>
  <x-plugins></x-plugins>
</x-layout>
