@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="">
       
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                  
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Generate Invoice</li>
                        </ol>
                    </nav>
                </div>
                
            </div>
        </div>
    </div>
    <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row bg-white bordered m-1 p-4">
            <div class="col-md-1">
                <label>Agent</label>    
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
                    <input type="text" class="form-control" placeholder="Search Agents" id="agent" name="agent" value="{{ $agent ? $agent : old('agent') }}" autocomplete="off"/>
                    <input type="hidden" class="form-control"  id="agent_id" name="agent_id" value="{{ $agent_id ? $agent_id : old('agent_id') }}"/>

                </div>
            
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Get Shipments</button>
            </div>
        </div>
        <table class="table table-sm table-striped table-hover bg-white m-1 mb-20" style="margin-bottom: 30px">
            @if($shipments)
                <thead>
                    <tr>
                        <th><input type="checkbox" /></th>
                        <th>ID</th>
                        <th>Tracking Number</th>
                        <th>Service</th>
                        <th>Zone</th>
                        <th>Customer</th>
                        <th class="text-center">Weight</th>
                        <th>Amount</th>
                        <th>Shipping Cost</th>
                        <th>Weight Fees</th>
                        <th>Service Fees</th>
                    </tr>
                </thead>
            @endif
            <tbody>
                @foreach ($shipments as $shipment)
                    <tr>
                        <td class="align-middle"><input type="checkbox" name="selected[]" /></td>
                        <td class="align-middle">{{ $shipment->id }}</td>
                        <td class="align-middle">{{ $shipment->tracking_number }}</td>
                        <td class="align-middle">{{ $shipment->ServiceType->name }}</td>
                        <td class="align-middle">
                            {{ $shipment->countryFlagImoji }} <br>
                            <span>{{ $shipment->customer_state }}</span><br>
                            <strong> {{ $shipment->customer_region }} </strong><br>
                            <small> {{ $shipment->customer_city }} </small><br>
                        </td>
                        <td class="align-middle">
                            <span>{{ $shipment->customer_name }}</span><br>
                            <small>{{ $shipment->customer_telephone }}</small>
                        </td>
                        <td class="align-middle">{{ $shipment->Currency->left_symbole }} {{ $shipment->FormatedAmount }} {{ $shipment->Currency->right_symbole }}</td>
                        <td class="align-middle text-center">
                            {{ $shipment->weight }}
                        </td>
                        <td class="align-middle">
                            <input class="form-control" type="number" value="0"/>
                        </td>
                        <td class="align-middle">
                            <input class="form-control" type="number" value="0"/>
                        </td>
                        <td class="align-middle">
                            <input class="form-control" type="number" value="0"/>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            @if($shipments)
            <tfoot>
                <tr >
                    <td colspan="10"></td>
                    <td style="padding: 30px"><button type="submit" class="btn btn-success w-100">Generate Invoice</button></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </form>
</div>
<script src="{{ asset('/vendors/scripts/bootstrap3-typeahead.min.js') }}"></script>

<script type="text/javascript">
    var ids = new Object();
     $('#agent').typeahead({
        source: function (query, process) {
            ids = new Object();
            $.ajax({
                    url: "{{ route('search_agent') }}",
                    type: 'GET',
                    dataType: 'JSON',
                    data: 'query=' + query,
                    success: function(data) {
                        var newData = [];
                        $.each(data, function(){
                            newData.push(this.name);
                            ids[this.name] = this.id
                            });
                        return process(newData);
                        }
                });

            
        },
            afterSelect: function(args){
                $('input[name="agent_id"]').val(ids[args])
            }

        });
       
</script>
@endsection
