<html>
    <head>
        <title>Menifest</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('/src/plugins/datatables/media/css/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{ asset('/vendors/styles/style.css') }}">
    </head>
    <body>
        <table class="table table-sm table-striped">
            <thead>
                <tr >
                    <td colspan="7" class="text-center p-2"><h3>KGSL - Shipments Menifest</h3></td>
                </tr>
                <tr>
                    <th class="text-center">ID</th>
                    <th>Agent</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Location</th>
                    <th>Directions</th>
                    <th>Comment</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody id="sortable">
                
                @foreach ($shipments as $shipment)
                    <tr>
                        <td class="text-center align-middle">
                            {{ $shipment->id }}<br>
                            Tracking: {{ $shipment->tracking_number }}<br>
                            Ref: {{ $shipment->reference }}<br>
                        </td>
                        <td class="align-middle">
                            {{ $shipment->Agent->name }}<br>
                            {{ $shipment->Agent->telephone }}<br>
                        </td>
                        <td class="p-2 align-middle">
                            {{ $shipment->customer_name }}<br>
                            <strong>{{ $shipment->customer_telephone }}</strong><br>
                        </td>
                        <td class="p-3 align-middle">
                           {{ $shipment->Currency->left_symbole }}{{ number_format($shipment->amount) }}{{ $shipment->Currency->right_symbole }}
                        </td>
                        <td class="p-3 align-middle">
                            {{ $shipment->customer_country }}<br>
                            {{ $shipment->customer_state }}, {{ $shipment->customer_region }}<br>
                            {{ $shipment->customer_city }}<br>
                        </td>
                        <td class="align-middle">
                            {{ $shipment->customer_directions }}
                        </td>
                        <td class="align-middle">
                            {{ $shipment->customer_comment }}<br>
                        </td>
                        <td class="align-bottom" style="color: #efefef">______________________________________________</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

        <script type="text/javascript">
            $( function() {
                $( "#sortable" ).sortable();
            } );

        </script>
    </body>
</html>