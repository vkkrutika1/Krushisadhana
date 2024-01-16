<!DOCTYPE html>
<html>
  <head>
    <title>QR Codes</title>
    <style type='text/css'>
      html { margin: 0px}
      @page { margin: 0px; }
      body { margin: 10px; text-align:center; font-size:12px; font-weight:bold; border-spacing:0px; font-family: Arial, Helvetica, sans-serif;  }
      hr {
        border: 1px solid black;
      }
    </style>
  </head>
  <body>    
    <table style="margin: auto; text-align:center; font-size: 18px; position: absolute; top: 30%">
      <tr>
        <td><strong><span style="font-family: 'arial';text-align: center;">s- </span></strong></td>
        <td>
          <strong>
            <?php 
              $secQRFileName = public_path("qrcodes".DIRECTORY_SEPARATOR."secondary".DIRECTORY_SEPARATOR."$secondary->id").DIRECTORY_SEPARATOR."qrcode_".$secondary->QRCode.".svg";
              $svg = file_get_contents($secQRFileName);   
              echo $html = '<img src="data:image/svg+xml;base64,'.base64_encode($svg). '" width="80" height="80" />';   
              $primaryCodes = json_decode($secondary->SecondaryLabelDetail);
              $priFilePath = public_path("qrcodes".DIRECTORY_SEPARATOR."primary".DIRECTORY_SEPARATOR."$secondary->primary_label_id").DIRECTORY_SEPARATOR;
            ?>
          </strong>
        </td>
        <td>
          <strong><span style="font-family: 'arial'; text-align: center; ">{{$prependSecQRCode}}{{ $secondary->QRCode  }} </span></strong>
        </td>
      </tr>
    </table>
    <div style="page-break-before:always;"> </div>
    <?php
      $totalQrCodes = count($primaryCodes);
      $count = 0;
    ?>
    @foreach ($primaryCodes as $key=>$primaryCode)  
    <?php $count++; ?>  
      <table style="background-color: #ffffff; border:1px black solid; table-layout: fixed; width: 100%;" >
        <tr>
          <td colspan="2" style="text-align: center;">
            <strong>{{$secondary->PrimaryLabel->ManufacturerName}}</strong><br/>
            {{$userProfile->company_name}}<br/>
            {{$userProfile->company_state}}
            <hr style="border: 1px solid black;">
          </td>
        </tr>
        <tr>
          <td width="45%">
            <table><tr><td width="150px">Pure Seed (Min.)</td><td>: 98%</td></tr></table>
            <table><tr><td width="150px">Innert Metter (Max.)</td><td>: 2.0%</td></tr></table>
            <table><tr><td width="150px">Other Crop (Max.)</td><td>: 10/kg</td></tr></table>
            <table><tr><td width="150px">Weed Seed (Max.)</td><td>: 10% </td></tr></table>
            <table><tr><td width="150px">Gemination (Min.)</td><td>: 80% </td></tr></table>
            <table><tr><td width="150px">Moisture (Min.)</td><td>: 10% </td></tr></table>
            <table style="text-align:center; margin: auto; margin-top: 5px">
              <tr>
                <td style="text-align: center;">
                  <?php   
                    $priFileName = $priFilePath. "qrcode_".$primaryCode->QRCode.".svg";
                    $svg = file_get_contents($priFileName);   
                    echo $html = '<img src="data:image/svg+xml;base64,'.base64_encode($svg). '" width="80" height="80" />';   
                  ?> 
                </td>
              </tr>
            </table>
            <table style="text-align:center; margin: auto;">
              <tr>
                <td>
                  <strong>{{$prependPriQRCode}}{{ $primaryCode->QRCode }}</strong>
                </td>
              </tr>
            </table>
          </td>
          <td>
            <table><tr><td width="125px">Product Name</td><td>: {{$secondary->Product->ProductName}}</td></tr></table>
            <table><tr><td width="125px">Product Category</td><td>: {{$secondary->Product->Category->ItemCategoryName}}</td></tr></table>
            <table><tr><td width="125px">Sub Category</td><td>: {{$secondary->Product->SubCategory->SubCategoryName}}</td></tr></table>
            <table><tr><td width="125px">Brand Name</td><td>: {{$secondary->PrimaryLabel->BrandName}}</td></tr></table>
            <table><tr><td width="125px">Batch No.</td><td>: {{$secondary->PrimaryLabel->BatchNumber}}</td></tr></table>
            <table><tr><td width="125px">Date of Test</td><td>: 
              <?php
                echo date('d-m-Y', strtotime($secondary->PrimaryLabel->ManufactureDate));
              ?>
             </td></tr>
            </table>
            <table><tr><td width="125px">MFG.Date</td><td>: 
              <?php
                echo date('d-m-Y', strtotime($secondary->PrimaryLabel->ManufactureDate));
              ?>
             </td></tr>
            </table>
            <table><tr><td width="125px">Exp.Date</td><td>: 
                <?php
                  echo date('d-m-Y', strtotime($secondary->PrimaryLabel->ExpiryDate));
                ?>
               </td></tr>
            </table>
            <table><tr><td width="125px">Net Weight Per Packet</td><td>: {{$secondary->PrimaryLabel->Weight}} {{$secondary->primaryLabel->UnitOfMeasurement->UomName}}</td></tr>
            </table>
            <table><tr><td width="125px">MRP Rs.<br/>(Inclusive of all taxes)</td><td>: {{$secondary->PrimaryLabel->mrp}}
            </td></tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <hr style="border: 1px solid black;">
            Marketed By/RC Holder: {{$secondary->Product->MarketedBy}}
          </td>
        </tr>
      </table>
    @if(($count) < $totalQrCodes)
      <div style="page-break-before:always;"></div> 
    @endif
    @endforeach
  </body>
</html>