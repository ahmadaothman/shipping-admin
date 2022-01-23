<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ar" dir="rtl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

		<title>Shipment </title>
   

        <style>
        
            @page { margin: 10px; margin-top: 0px !important; }
            body { margin: 10px;  margin-top: 0px !important;}
        </style>
    </head>
    <body  style="font-family: 'dejavu sans', sans-serif;">

        <table>
           
            <tr >
                <td >
                    <img style="width: 100px;margin-top:5px" src="data:image/png;base64, {!! $qrcode !!}">
                </td>
                <td style="font-size: 8px;text-align:left;padding-left:-10px">
                    <strong style="width: 100%;margin-left:-15px;">KGSL</strong><br>
                    <small style="margin-left:-20px;">{{ $shipment->customer_name }}</small><br>
                    <small style="margin-left:-20px;">{{ $shipment->customer_telephone }}</small><br>
                    <small style="margin-left:-20px;">{{ $shipment->customer_country }}  </small><br>
                  
                    <small style="margin-left:-20px;">{{ $shipment->customer_state }}</small>
                    <small style="margin-left:-20px;">{{ $shipment->customer_region }}, {{ $shipment->customer_city }}</small>
                    </td>
            </tr>
          
           
        </table>
     
    </body>
</html>