
<x-layout bodyClass="g-sidenav-show  bg-gray-200">

  <x-navbars.sidebar activePage="secondaries"></x-navbars.sidebar>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <x-navbars.navs.auth titlePage="Secondary Label Management"></x-navbars.navs.auth>
    <!-- End Navbar -->
    <div class="container-fluid py-4" id="headerOveride">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white mx-3">Secondary ID Details: {{$secondary->SecondaryContainerCode}}</h6>
              </div>
            </div>
            <div class="card-body m-4 px-0 pb-2">
              <table width="100%">
                <thead>
                  <tr>
                    <th>PRIMARY LABELS ID</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $secLabelDetails = json_decode($secondary->SecondaryLabelDetail, true);
                  ?>
                  @foreach ($secLabelDetails as $secLabel)
                  <tr>
                    <td>{{$secLabel['QRCode']}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <x-footers.auth></x-footers.auth>
    </div>
  </main>
  <x-plugins></x-plugins>
</x-layout>