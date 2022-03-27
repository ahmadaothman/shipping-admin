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
            <div class="col-md-4"></div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success w-100" data-toggle="modal" data-target="#mark_as_paid_modal"><i class="icon-copy fa fa-check" aria-hidden="true"></i> Mark as Paid</button>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger w-100" data-toggle="modal" data-target="#cancel_invoice_modal"><i class="icon-copy fa fa-close" aria-hidden="true"></i> Cancel</button>
            </div>
            <div class="col-md-2">
                @if($user->user_type_id == 1)
                <button type="button" class="btn btn-danger w-100" data-toggle="modal" data-target="#remove_invoice_modal"><i class="icon-copy fa fa-trash" aria-hidden="true"></i> Remove</button>
                @else
                <button type="button" class="btn btn-danger w-100" disabled><i class="icon-copy fa fa-trash" aria-hidden="true"></i> Remove</button>
                @endif
            </div>

            @if($invoice->status_id == "1")
              <div class="col-md-2">
                <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#add_shipment_modal"><i class="icon-copy fa fa-plus" aria-hidden="true"></i> Add Shipment</button>
              </div>
            @else
            <div class="col-md-2">
              <button type="button" disabled class="btn btn-primary w-100" data-toggle="modal" data-target="#add_shipment_modal"><i class="icon-copy fa fa-plus" aria-hidden="true"></i> Add Shipment</button>
            </div>
            @endif
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
            <tbody id="shipments_tbody">
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
                    <td colspan="3">Extra Fees</td>
                    <td>
                      <input type="text" placeholder="Invoice Extra Fees" name="extra_fees" class="form-control" value="{{ $invoice->extra_fees }}"/>
                    </td>
                    <td colspan="2">Extra Fees Note</td>
                    <td colspan="5" class="align-middle">
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

   <!--Remove Modal -->
   <div class="modal fade" id="remove_invoice_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Remove Invoice</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          do you want to remove invoice?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" onclick="removeInvoice()">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <!--Add Shipment Modal Modal -->
  <div class="modal fade" id="add_shipment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Shipment To Invoice</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" >
          <div class="row" id="add_shipment_body">
            <div class="col-md-2">Shipment:</div>
            <div class="col-md-10">
              <input type="text" id="search_shipment" class="form-control" placeholder="Enter Shipment Id/ Tracking Number">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button"  id="btn_add_shipment" class="btn btn-primary" onclick="addShipment()">Add</button>
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

function removeInvoice(){
    $.ajax({
        type:'GET',
        url: "{{ route('removeInvoice') }}",
        data: {
            id:$('input[name="invoice_id"]').val()
        },
        success:function(){
            location.href = "{{ route('invoices') }}"
        }
    })
}

function addShipment(){
  $('#btn_add_shipment').attr("disabled", true);
  $('#btn_add_shipment').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>');
  $.ajax({
    url:"{{ route('getShipmentToInvoice')}}",
    type:'get',
    data:{
      id:$('#search_shipment').val()
    },
    success:function(data){
      $('#btn_add_shipment').attr("disabled", false);
      $('#btn_add_shipment').html('Add')
      if(data.success){
          $('input[name="selected[]"]').each(function(){
            if($(this).val() == data.id){
              $('<div class="alert alert-danger" role="alert">You cannot add this shipment '+data.id+',it is already exists!</div>').insertBefore($('#add_shipment_body'));
              return;
            }

            
          })

          html = '<tr>';
          html += '<td class="align-middle"><input type="checkbox" name="selected[]" value="'+data.id+'" checked="" hidden=""></td>'
          html += '<td class="align-middle">'+data.id+'</td>'
          html += '<td class="align-middle">'+data.tracking_number+'</td>'
          html += '<td class="align-middle">'+data.service_type_name+'</td>'
          html += '<td class="align-middle">🇱'+data.coutry_flag_imoji+' <br><span>'+data.customer_state+'</span><br><strong> '+data.customer_region+' </strong><br><small>'+data.customer_city+'</small><br></td>'
          html += '<td class="align-middle"><span>'+data.customer_name+'</span><br><small>'+data.customer_telephone+'</small></td>'
          html += '<td class="align-middle text-center">'+data.weight+'</td>'
          html += '<td class="align-middle">'+data.formatted_amount+'</td>'
          html += '<td class="align-middle"><input class="form-control" name="shipments[shipping_cost]['+data.id+']" type="number" value="'+data.shipping_cost+'"></td>'
          html += '<td class="align-middle"><input class="form-control" name="shipments[weight_fees]['+data.id+']" type="number" value="'+data.weight_fees+'"></td>'
          html += '<td class="align-middle"><input class="form-control" name="shipments[service_fees]['+data.id+']" type="number" value="'+data.service_fees+'"></td>'
          html += '<td class="align-middle"><input class="form-control" name="shipments[comment]['+data.id+']" type="text" value=""></td>'

          html += '</tr>';
          $('#shipments_tbody').append(html);
          
          $.ajax({
            url:"{{ route('updateAddShipmentToInvoice') }}",
            type:'get',
            data:{
              id:data.id
            },
            success:function(data){
              $('#add_shipment_modal').modal('hide');
              location.reload();
            }
          })
      }else{
        $('<div class="alert alert-danger" role="alert">'+data.message+'</div>').insertBefore($('#add_shipment_body'));
       
      }
    }
  })
}
</script>

@endsection
