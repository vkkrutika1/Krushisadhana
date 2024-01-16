<!DOCTYPE html>
<html>
  <head>
    <title>QR Codes</title>
    <style type='text/css'>
      html { margin: 0px}
      @page { margin: 0px; }
      body { margin: 10px; text-align:center; }
    </style>
  </head>
  <body>  
    <?php 
      $totalQrCodes = count($qrCodesArray);
    ?> 
    @foreach ($qrCodesArray as $key=>$qrCodeData)  
    <table width="100%">
      <tr>
        <td>
          <strong>
          <?php   
            $svg = file_get_contents($qrCodeData["qrCode"]);  
            // echo DNS1D::getBarcodeHTML($qrCodeData['value'], 'C128A');
            // echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG('4', 'C39+',1,33) . '" alt="barcode"   />';
            // echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG('4', 'C39+',1,33,array(1,1,1), true) . '" alt="barcode"   />';
            echo DNS1D::getBarcodeHTML($qrCodeData['value'], 'C128A',0.52,33);
            // echo $html = '<img src="data:image/svg+xml;base64,'.base64_encode($svg). '" width="65" height="65" />';
           // echo '<img src="data:image/svg+xml;base64,' . DNS1D::getBarcodePNG('4', 'C39+',1,33) . '" alt="qrCode"   />';
          ?> 
        </strong>
        </td>
        <td>
          <strong><span style="font-family: 'arial';font-size:15px; text-align: center; ">{{$qrCodeData['prependQRCode']}}{{ $qrCodeData['value'] }} </span></strong>
        </td>
      </tr>
    </table>
    @if(($key+1) < $totalQrCodes)
      <div style="page-break-before:always;"></div> 
    @endif
    @endforeach
  </body>
</html>