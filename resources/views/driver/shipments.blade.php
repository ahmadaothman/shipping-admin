<!DOCTYPE html>
<html>
    <head>
        <title>KGSL | Driver</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="table-responsive">
            <input type="text" class="form-control m-2" placeholder="Search..." id="search" >
            <table class="table table-sm table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ref</th>
                        <th>Detais</th>
                        <th>Amount</th>
                        <th>status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shipments as $shipment)

                        @if ($shipment->status_id == '18')
                            <tr class="bg-success">
                        @elseif($shipment->status_id== '10' || $shipment->status_id== '11' || $shipment->status_id== '12')
                            <tr class="bg-warning">
                        @else
                            <tr>
                        @endif

                       
                            <td>{{ $shipment->id }} - {{ $shipment->tracking_number}}</td>
                            <td class="text-center">
                                {{ $shipment->customer_name }} - <strong>{{ $shipment->customer_telephone }}</strong>
                                <br>
                                {{ $shipment->customer_region }},  {{ $shipment->customer_directions }}
                            </td>
                            <td>
                                <strong> {{ $shipment->Currency->left_symbole}}{{ $shipment->FormatedAmount }}{{ $shipment->Currency->right_symbole}}</strong>
                            </td>
                            <th class="text-center">{{ $shipment->Status->name}}</th>
                            <td><button type="button" class="btn btn-primary" onclick="showModal({{ $shipment->id }})">Action</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script>
            $(document).ready(function(){
                $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
                });
            });
        </script>
        <!-- Modal -->
        <div class="modal fade" id="action_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Action</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <button type="button" class="btn btn-success  w-100 m-2" onclick="changeStatus(18)">Delivered</button><br>
                    <button type="button" class="btn btn-warning  w-100 m-2" onclick="changeStatus(10)">Postponed</button><br>
                    <button type="button" class="btn btn-danger  w-100 m-2" onclick="changeStatus(11)">No Answer</button><br>
                     <button type="button" class="btn btn-danger  w-100 m-2" onclick="changeStatus(12)">Rejected</button><br>
                </div>
                
                </div>
            </div>
        </div>
        <script type="text/javascript">
            var shipment_id = '';
            function showModal(id){
                shipment_id = id;
                $('#action_modal').modal('show')
            }
            function changeStatus(id){
                $.ajax({
                    type:'get',
                    url:'/driver/changeStatus',
                    data:{
                        status_id :id,
                        shipment_id: shipment_id
                    },
                    success:function(data){
                        $('#action_modal').modal('hide')
                        window.location.reload();

                    }
                })
            }
        </script>
</body>
</html>