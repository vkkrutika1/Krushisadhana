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
                        <h6 class="text-white mx-3">Secondary Label List</h6>
                    </div>
                </div>
                <div class=" me-3 my-3 text-end">
                  <a class="btn bg-gradient-dark mb-0" href="{{ route('secondaries.create') }}"><i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Secondary</a>
                </div>
                <div class="card-body px-0 pb-2">
                  <div class="table-responsive p-0">
                   <table id="tableContent" class="table table-striped table-fixed">
                     <thead>
                       <tr>
                         <th>S.No.</th>
                         <th>Secondary ID</th>
                         <th>Secondary QR Code</th>
                         <th>Primary QR Codes</th>
                         <th>Product Name & Batch Number</th>
                         <th>Label Type</th>
                         <th>Action</th>
                       </tr>
                     </thead>
                     <tbody>
                       @if ($secondaries->isNotEmpty())
                       <?php $counter = 1; ?>
                       @foreach ($secondaries as $key=>$secondary)
                       <?php 
                         $secLabelDetails = json_decode($secondary->SecondaryLabelDetail, true);
                         // echo '<pre>';
                         // print_r($secLabelDetails);
                         $QRCodes = array_column($secLabelDetails, 'QRCode');
                         $serialNumbers = array_column($secLabelDetails, 'SerialNumber');
                         $totSerialNums = count($serialNumbers);
                         $labelRange = $serialNumbers[0]."-".$serialNumbers[$totSerialNums-1];
                         // print_r($serialNumbers);
                         // echo '</pre>';
                       ?>
                       <tr valign="middle" class="<?php echo $secondary->api_sync_status?'synced':'not_synced'?>">
                         <td>{{$counter++}}</td>
                         <td>{{ $secondary->SecondaryContainerCode}}
                         <br/> 
                           <?php echo date('(d-m-Y)', strtotime($secondary->created_at)); ?>
                           <br/>
                           <?php echo date('(H:s:i)', strtotime($secondary->created_at)); ?>
                         </td>
                         <td> 
                           <?php
                             $filePath = public_path("qrcodes".DIRECTORY_SEPARATOR."secondary".DIRECTORY_SEPARATOR."$secondary->id");
                             $fileName = $filePath.DIRECTORY_SEPARATOR."qrcode_$secondary->QRCode.svg";
                             $svg = file_get_contents($fileName);   
                             echo $html = '<img src="data:image/svg+xml;base64,'.base64_encode($svg). '" width="75" height="75" />'; 
                           ?>
                           <br/>
                           QR Code: {{$secondary->QRCode}}<br/>labels-Range: {{$labelRange}}</td>
                         <td>
                         <?php echo implode('<br/>', $QRCodes);?>
                         </td>
                         <td>{{ $secondary->Product->ProductName}} <br/> {{ $secondary->PrimaryLabel->BatchNumber}}</td>
                         <td>{{ $secondary->LabelType->name}}</td>
                         <td>
                           <a href="{{ route('secondaries.view', $secondary->id) }}" class="btn btn-primary btn-sm">View</a>
                           <br/><br/>
                           <a href="{{ route('secondaryPrint', $secondary->id) }}" class="btn btn-primary btn-sm">Print Label</a>
                         </td>
                       </tr>
                       @endforeach
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
    <script>
      $(document).ready(function() {
        $('#tableContent').DataTable( {
          sorting:false,
          fixedHeader: false,
          scrollX: true,
          dom: 'Bfrtip',
          language: {
            emptyTable: "Currently no data available in table"
          },
          aaSorting: [],
          columnDefs: [
            {
              targets: 1,
              className: 'noVis'
            }
          ],
          buttons: [
            {
              extend: 'colvis',
              className: 'btn-primary',
              columns: ':not(.noVis)'
            },
            'copy', 'excel', 'pdf'
          ]
        });
        $('#selectAll').click(function() {
          $('.dynamicCheckbox').prop('checked', $(this).prop('checked'));
        });
        $('.dynamicCheckbox').click(function() {
          if ($('.dynamicCheckbox:checked').length === $('.dynamicCheckbox').length) {
            $('#selectAll').prop('checked', true);
          } else {
            $('#selectAll').prop('checked', false);
          }
        });
      });

      function deleteproducts() {
        event.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
          buttonsStyling: false
        })

        Swal.fire({
          title: 'Are you sure?',
          text: 'You want to delete this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!'
        }).then((result) => {
          if (result.isConfirmed) {
            $("#target").submit();
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire(
              'Cancelled',
              'product is safe :)',
              'error'
            )
          }
        })
      }
    </script>
  </main>
  <x-plugins></x-plugins>
</x-layout>