<x-layout bodyClass="g-sidenav-show  bg-gray-200">
  <x-navbars.sidebar activePage="user-management"></x-navbars.sidebar>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
    <x-navbars.navs.auth titlePage="User Management"></x-navbars.navs.auth>
      <!-- End Navbar -->
    <div class="container-fluid py-4" id="headerOveride">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white mx-3"><strong> User List</h6>
              </div>
            </div>
            <div class=" me-3 my-3 text-end">
              <a class="btn bg-gradient-dark mb-0" href="{{ route('users.create') }}"><i
                        class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New
                    User</a>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th
                          class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                          S.No.
                      </th>
                      <th
                          class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                          Name</th>
                      <th
                          class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                          Email</th>
                      <th
                          class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                          Phone</th>
                      <th
                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                      Vendor ID</th>
                      <th
                          class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                          Creation Date
                      </th>
                      <th
                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                      
                  </th>
                      <!-- <th class="text-secondary opacity-7"></th> -->
                    </tr>
                  </thead>
                  <tbody>
                    @if (count($users))
                    @foreach($users as $key=>$user)
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <p class="mb-0 text-sm">{{$key + 1}}</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">{{$user->name}}</h6>

                        </div>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <p class="text-xs text-secondary mb-0">{{$user->email}}
                        </p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <p class="text-xs text-secondary mb-0">{{$user->UserProfile->phone}}
                        </p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <p class="text-xs text-secondary mb-0">{{$user->UserProfile->vendor_id}}
                        </p>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">
                          @php 
                              echo date('d-m-Y', strtotime($user->created_at))
                          @endphp
                        </span>
                      </td>

                      <td style="text-align: center">
                        @if ($user->status == 1)
                          <a href="{{route('users.status.update',['user_id'=> $user->id,
                          'status_code'=> 0])}}" class="btn btn-danger m-2">
                            Disable
                          </a>

                          @else

                        
                          <a href="{{route('users.status.update',['user_id'=> $user->id,
                            'status_code'=> 1])}}" class="btn btn-success m-2">
                              Enable
                            </a>

                        @endif 
                      </td>
                        
                      <!-- <td class="align-middle">
                          <a rel="tooltip" class="btn btn-success btn-link"
                              href="" data-original-title=""
                              title="">
                              <i class="material-icons">edit</i>
                              <div class="ripple-container"></div>
                          </a>
                          
                          <button type="button" class="btn btn-danger btn-link"
                          data-original-title="" title="">
                          <i class="material-icons">close</i>
                          <div class="ripple-container"></div>
                      </button>
                      </td> -->
                    </tr>
                    @endforeach
                    @else
                    <tr><td colspan="6" style="text-align: center;">Currently no users</td></tr>
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <x-footers.auth></x-footers.auth>
    </div>
  </main>
  <x-plugins></x-plugins>
</x-layout>
