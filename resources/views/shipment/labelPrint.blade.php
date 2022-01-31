<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ar" dir="rtl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

		<title>Shipment </title>
   

        <style>
        
            @page { margin: 8px; }
            body { margin: 8px; }
        </style>
    </head>
    <body  style="font-family: 'dejavu sans', sans-serif;">

        <table>
            <tr>
                <td >
                    <img style="width: 55px;margin-top:5px" src="data:image/png;base64, {!! $qrcode !!}">
                </td>
                <td style="font-size: 12px;text-align:left;padding-left:-10px">
                    <strong style="width: 100%;margin-left:-10px;">KGSL</strong><br>
                    <small style="margin-left:-10px;text-aligh-left">{{ $shipment->customer_name }}</small><br>
                    <small style="margin-left:-10px;">{{ $shipment->customer_telephone }}, {{ $shipment->customer_country }} </small><br>
                  
                    <small style="margin-left:-10px;">{{ $shipment->customer_state }}</small><br>
                    <small style="margin-left:-10px;">{{ $shipment->customer_region }}, {{ $shipment->customer_city }}</small>
                </td>
            </tr>
          
           
        </table>
     
    </body>
</html>