@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
       
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                  
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Invoices</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a  class="btn btn-primary " href="{{ route('generate_invoice') }}"><i class="icon-copy fi-plus"></i> New Invoice</a>

                </div>
            </div>
        </div>
        <div class="container">
            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <table class="table table-sm table-hover table-striped">
                <thead>
                    <tr>
                        <th>Invoice Id</th>
                        <th>Agent</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Total Shipments</th>
                        <th>Amoumt</th>
                        <th>Comment</th>
                        <th>Date Added</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td class="text-center">{{ $invoice->id }}</td>
                            <td>{{ $invoice->Agent->name }}</td>

                            @if($invoice->status_id == 1)
                            <td class="text-danger text-center"><strong>Unpaid</strong></td>
                            @elseif($invoice->status_id == 2)
                            <td class="text-success text-center"><strong>Paid</strong></td>
                            @elseif($invoice->status_id == 3)
                            <td class="text-secondary text-center"><strong>Cancelled</strong></td>
                            @endif

                            <td class="text-center">{{ $invoice->TotalShipments }}</td>
                            <td>{{ $invoice->total }}</td>
                            <td>{{ $invoice->comment }}</td>
                            <td>{{ $invoice->created_at }}</td>
                            <td>
                                <a href="{{ route('invoice',['id'=>$invoice->id]) }}"><i class="icon-copy fa fa-pencil-square-o" aria-hidden="true"> Edit</i></a>
                                <a href="{{ route('printInvoice',['id'=>$invoice->id]) }}"><i class="icon-copy fa fa-print" aria-hidden="true"> Print</i></a>

                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
            <div class="w-100" >
                   
                {{ $invoices->appends($_GET)->links('vendor.pagination.default') }}
                <div class="float-right h-100" style="padding-top: 25px">
                    <strong>
                        Showing {{ $invoices->count() }} From {{ $invoices->total() }} Invoices
                    </strong>
                </div>

            </div>
        </div>
    </div>
   
</div>

@endsection
