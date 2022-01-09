<html>
    <head>
        <meta charset="utf-8" />
		<title>Shipment </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="{{ asset('/src/scripts/jquery.qrcode.min.js ') }}"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
        <style>
       
        </style>
    </head>
    <body>
      
        <table>
            <tr >
                <td rowspan="4">
                    <div id="qrcode">
                        <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate('Make me into an QrCode!')) }} ">
                </td>
            </tr>
            <tr>
                <td><small>{{ $shipment->customer_name }}</small></td>
            </tr>
            <tr>
                <td><small>{{ $shipment->customer_telephone }}</small></td>
            </tr>
            <tr>
                <td>
                    <small>{{ $shipment->customer_country }}, {{ $shipment->customer_state }}, {{ $shipment->customer_region }}, {{ $shipment->customer_city }}<br />
                                    {{ $shipment->customer_directions }}</small>
                </td>
            </tr>
        </table>
        <script>
            $('#qrcode').qrcode({width: 10,height: 10,text: "https://kg-sl.com/tracking.html?tracking_number={{ $shipment->tracking_number }}"});


        </script>
    </body>
</html>