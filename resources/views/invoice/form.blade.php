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
    <form method="POST" enctype="multipart/form-data" id="form">
        @if(isset($error))
        <div class="alert alert-danger" role="alert">
            {{ $error }}
          </div>
        @endif
        @csrf

        <input type="hidden" name="invoice_id" value="{{ $invoice->id }}" />

        <div class="row bg-white bordered m-1 p-4">
            <div class="col-md-8"></div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success w-100" data-toggle="modal" data-target="#mark_as_paid_modal"><i class="icon-copy fa fa-check" aria-hidden="true"></i> Mark as Paid</button>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger w-100" data-toggle="modal" data-target="#cancel_invoice_modal"><i class="icon-copy fa fa-close" aria-hidden="true"></i> Cancel</button>
            </div>
        </div>
        <table class="table table-sm table-striped table-hover bg-white m-1 mb-20" style="margin-bottom: 30px">
            @if($shipments)
                <thead>
                    <tr>
                        <th><input id="checkAll" type="checkbox" checked hidden/></th>
                        <th><small>ID</small></th>
                        <th><small>Tracking</small></th>
                        <th><small>Service</small></th>
                        <th><small>Zone</small></th>
                        <th><small>Customer</small></th>
                        <th class="text-center"><small>Weight</small></th>
                        <th><small>Amount</small></th>
                        <th><small>Shipping Cost</small></th>
                        <th><small>Weight Fees</small></th>
                        <th><small>Service Fees</small></th>
                        <th><small>Comment</small></th>
                    </tr>
                </thead>
            @endif
            <tbody>
                @foreach ($shipments as $shipment)
                    <tr>
                        <td class="align-middle"><input  type="checkbox" name="selected[]" value="{{ $shipment->Shipment->id }}" checked hidden/></td>

                        <td class="align-middle">{{ $shipment->Shipment->id }}</td>
                        <td class="align-middle">{{ $shipment->Shipment->tracking_number }}</td>
                        <td class="align-middle">{{ $shipment->Shipment->ServiceType->name }}</td>
                        <td class="align-middle">
                            {{ $shipment->Shipment->countryFlagImoji }} <br>
                            <span>{{ $shipment->Shipment->customer_state }}</span><br>
                            <strong> {{ $shipment->Shipment->customer_region }} </strong><br>
                            <small> {{ $shipment->Shipment->customer_city }} </small><br>
                        </td>
                        <td class="align-middle">
                            <span>{{ $shipment->Shipment->customer_name }}</span><br>
                            <small>{{ $shipment->Shipment->customer_telephone }}</small>
                        </td>
                        <td class="align-middle text-center">
                            {{ $shipment->weight }}
                        </td>
                        <td class="align-middle">{{ $shipment->Shipment->Currency->left_symbole }} {{ $shipment->Shipment->FormatedAmount }} {{ $shipment->Shipment->Currency->right_symbole }}</td>
                    
                        <td class="align-middle">
                            <input class="form-control" name="shipments[shipping_cost][{{ $shipment->Shipment->id }}]" type="number" value="{{ $shipment->shipping_cost }}"/>
                        </td>
                        <td class="align-middle">
                            <input class="form-control" name="shipments[weight_fees][{{ $shipment->Shipment->id }}]" type="number" value="{{ $shipment->weight_fees }}"/>
                        </td>
                        <td class="align-middle">
                            <input class="form-control" name="shipments[service_fees][{{ $shipment->Shipment->id }}]" type="number" value="{{ $shipment->service_fees }}"/>
                        </td>

                        <td class="align-middle">
                            <input class="form-control" name="shipments[comment][{{ $shipment->Shipment->id }}]" type="text" placeholder="Comment" value="{{ $shipment->comment }}"/>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            @if($shipments)
            <tfoot>
                <tr >
                    <td colspan="11" class="align-middle">
                        <input type="text" placeholder="Invoice Comment" name="comment" class="form-control" value="{{ $invoice->comment }}"/>
                    </td>
                    <td><button type="submit" class="btn btn-success w-100">Save</button></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </form>
</div>

  
  <!-- Modal -->
  <div class="modal fade" id="mark_as_paid_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Mark Invoice As Paid</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          do you want to confirm?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="markInvoiceAsPaid()">Save changes</button>
        </div>
      </div>
    </div>
  </div>

   <!-- Modal -->
   <div class="modal fade" id="cancel_invoice_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cancel Invoice</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          do you want to confirm?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="cancelInvoice()">Save changes</button>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">
function markInvoiceAsPaid(){
    $.ajax({
        type:'GET',
        url: "{{ route('payInvoice') }}",
        data: {
            id:$('input[name="invoice_id"]').val()
        },
        success:function(){
            location.href = "{{ route('invoices') }}"
        }
    })
}

function cancelInvoice(){
    $.ajax({
        type:'GET',
        url: "{{ route('cancelInvoice') }}",
        data: {
            id:$('input[name="invoice_id"]').val()
        },
        success:function(){
            location.href = "{{ route('invoices') }}"
        }
    })
}
</script>

@endsection
