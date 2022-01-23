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
                <td style="font-size: 8px;">
                    <strong style="width: 100%">KGSL</strong><br>
                    <small>{{ $shipment->customer_name }}</small><br>
                    <small>{{ $shipment->customer_telephone }}</small><br>
                    <p >{{ $shipment->customer_country }}, {{ $shipment->customer_state }}, {{ $shipment->customer_region }}, {{ $shipment->customer_city }}<br />
                        
                        
                        
                    </p>
                    
                    </td>
            </tr>
          
           
        </table>
     
    </body>
</html>