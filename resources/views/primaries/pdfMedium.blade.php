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
    <?php $totalQrCodes = count($qrCodesArray); ?>
    @foreach ($qrCodesArray as $key=>$qrCodeData)  
      <table style="background-color: #ffffff;border:1px black solid; table-layout: fixed; width: 100%;" >
        <tr>
          <td colspan="2" style="text-align: center;">
            <strong>{{$primary->ManufacturerName}}</strong><br/>
            {{$userProfile->company_state}}
            <hr style="border: 1px solid black;"/>
          </td>
        </tr>
        <tr>
          <td valign="top" width="65%">
            <strong><table><tr><td width="">Product Name</td><td>: {{$primary->Product->ProductName}}</td></tr></table></strong>
            <table><tr><td width="">UPC</td><td>: 49498818033408</td></tr></table> 
            <table><tr><td width="">Batch No.</td><td>: {{$primary->BatchNumber}}</td></tr></table>
             <table><tr><td width="">MFG.Date</td><td>: 
              <?php
                echo date('d-m-Y', strtotime($primary->ManufactureDate));
              ?>
             </td></tr>
            </table>
            <table><tr><td width="">Exp.Date</td><td>: 
              <?php
                echo date('d-m-Y', strtotime($primary->ExpiryDate));
              ?>
             </td></tr>
            </table>
            <table><tr><td width="">Serial No.</td><td>: {{$serialNos[$key]}}</td></tr>
            </table>
          </td>
          <td valign="bottom">
            <table style="text-align:center; margin: auto; margin-top: 5px">
              <tr>
                <td style="text-align: center;">
                  <?php   
                    $svg = file_get_contents($qrCodeData["qrCode"]);   
                    echo $html = '<img src="data:image/svg+xml;base64,'.base64_encode($svg). '" width="60" height="60" />'; 
                  ?> 
                </td>
              </tr>
            </table>
            <table style="text-align:center; margin: auto;">
              <tr>
                <td>
                  <strong>{{$qrCodeData['prependQRCode']}}{{ $qrCodeData['value'] }}</strong>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <hr style="border: 1px solid black;">
            Marketed By/RC Holder: {{$primary->Product->MarketedBy}}
          </td>
        </tr>
        </tr>
      </table> 
    @if(($key + 1) < $totalQrCodes)
    <div style="page-break-before:always;"> </div>
    @endif
    @endforeach
  </body>
</html>