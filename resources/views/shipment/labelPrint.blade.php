<!DOCTYPE html>
<html>
    <head>

		<title>Shipment </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <style>
            @font-face {
                font-family: Custommm;
                src: url('{{ asset('src/fonts/xfont/XB Riyaz.tff') }}');
            }
            @page { margin: 0px;}
            body { margin: 0px; }
        </style>
    </head>
    <body >

        <table>
            <tr>
                <td colspan="2" style="text-align: center">KGSL</td>
            </tr>
            <tr >
                <td >
                    <img style="width: 100px;margin-top:5px" src="data:image/png;base64, {!! $qrcode !!}">
                </td>
                <td style="font-size: 12px;text-align: left;">
                    <small>{{ $shipment->customer_name }}</small><br>
                    <small>{{ $shipment->customer_telephone }}</small><br>
                    <span>{{ $shipment->customer_country }}, {{ $shipment->customer_state }}, {{ $shipment->customer_region }}, {{ $shipment->customer_city }}<br />
                        {{ $shipment->customer_directions }}</span>
                </td>
            </tr>
          
           
        </table>
     
    </body>
</html>