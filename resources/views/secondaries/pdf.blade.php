<!DOCTYPE html>
<html>
  <head>
    <title>QR Codes</title>
    <style type='text/css'>
      html { margin: 0px}
      @page { margin: 0px; }
      body { margin: 10px; text-align:center; font-size:13px; font-weight:bold; border-spacing:0px; font-family: Arial, Helvetica, sans-serif;  }
      hr {
        border: 1px solid black;
      }
    </style>
  </head>
  <body> 
    <table width="100%" style="margin:auto">
      <tr>
        <td><strong><span style="text-align: center; ">s- </span></strong></td>
        <td>
          <strong>
            <?php 
              $secQRFileName = public_path("qrcodes".DIRECTORY_SEPARATOR."secondary".DIRECTORY_SEPARATOR."$secondary->id").DIRECTORY_SEPARATOR."qrcode_".$secondary->QRCode.".svg";
              $svg = file_get_contents($secQRFileName);   
              echo $html = '<img src="data:image/svg+xml;base64,'.base64_encode($svg). '" width="65" height="65" />';   
              $primaryCodes = json_decode($secondary->SecondaryLabelDetail);
              $priFilePath = public_path("qrcodes".DIRECTORY_SEPARATOR."primary".DIRECTORY_SEPARATOR."$secondary->primary_label_id").DIRECTORY_SEPARATOR;
            ?>
          </strong>
        </td>
        <td>
          <strong><span style="text-align: center; ">{{$prependSecQRCode}}{{ $secondary->QRCode  }} </span></strong>
        </td>
      </tr>
    </table>
    <div style="page-break-before:always;"></div> 
    <?php 
      $totalQrCodes = count($primaryCodes);
    ?> 
    @foreach ($primaryCodes as $key=>$primaryCode) 
    <table width="100%" style="margin:auto;">
      <tr>
        <td><strong><span style="text-align: center; ">&nbsp;&nbsp;</span></strong></td>
        <td style="text-align: center;">
          <strong>
          <?php   
            $priFileName = $priFilePath. "qrcode_".$primaryCode->QRCode.".svg";
            $svg = file_get_contents($priFileName); 
            echo $html = '<img src="data:image/svg+xml;base64,'.base64_encode($svg). '" width="65" height="65" />';   
          ?> 
        </strong>
        </td>
        <td style="text-align: center;">
          <strong><span style="text-align: center; ">{{$prependPriQRCode}}{{ $primaryCode->QRCode }} </span></strong>
        </td>
      </tr>
    </table>  
    @if(($key+1) < $totalQrCodes)
      <div style="page-break-before:always;"></div> 
    @endif
    @endforeach
  </body>
</html>
  