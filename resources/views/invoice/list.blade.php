@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="clearfix mb-20">
          
            <p class="float-right">
                <a class="btn btn-outline-info " data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <i class="icon-copy fa fa-filter" aria-hidden="true"></i> Filters
                </a>
                <a  class="btn btn-primary " href="{{ route('generate_invoice') }}"><i class="icon-copy fi-plus"></i> New Invoice</a>

            </p>
        </div>
        <div class="collapse mb-4" id="collapseExample" >
            <div class="card card-body">
                <div class="row">
                    
                    <div class="form-group form-group-sm col-md-2">
                        <small><label for="filter_agent">Agent</label></small>

                        <select class="form-control form-control-sm h-50 selectpicker" id="filter_agent"  multiple="multiple" data-actions-box="true" data-live-search="true">
                            @foreach ($agents as $agent)
                                @if(in_array($agent->id,explode(",",app('request')->input('filter_agent'))))
                                <option value="{{ $agent->id }}" selected>{{ $agent->name }}</option>
                                @else
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    

                    <div class="form-group form-group-sm col-md-2">
                        <small><label for="filter_agent">Status</label></small>
                        <select class="form-control form-control-sm h-50 selectpicker" id="filter_status"  >
                            <option value="">--none--</option>
                            @foreach ($status as $status)
                            @if(in_array($status['id'],explode(",",app('request')->input('filter_status'))))
                            <option value="{{ $status['id'] }}" selected>{{ $status['name'] }}</option>
                            @else
                            <option value="{{ $status['id'] }}">{{ $status['name'] }}</option>
                            @endif
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group form-group-sm col-md-4">
                        <small><label for="filter_date">Date</label></small>
                        <input type="text" class="form-control form-control-sm h-50" id="filter_date"  autocomplete="off" placeholder="Date">
                    </div>
                </div>
            
                
                <hr>
                <div class="row">
                    <div class="col-12 text-right">
                        <button type="button" class="btn btn-primary btn-sm" onclick="filter()"><i class="icon-copy fa fa-filter" aria-hidden="true"></i> Filter</button>

                        <button type="button" class="btn btn-danger btn-sm" onclick="clearFilter()"><i class="icon-copy fa fa-close" aria-hidden="true"></i> Clear Filter</button>
                    </div>
                </div>
                
            </div>
        </div>
        
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
<script type="text/javascript" src="{{ asset('/src/plugins/daterangpicker/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/src/plugins/daterangpicker/js/daterangepicker.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('/src/plugins/daterangpicker/css/daterangepicker.css') }}" />
<script type="text/javascript">
    var start = moment("2010-01-01","YYYY-MM-DD").format("YYYY-MM-DD");
    var end = moment();
    
    var filter_date = "{{ app('request')->input('filter_date') }}";
    
    if(filter_date != "") {

        var dates = filter_date.split(" - ");

        start = moment(dates[0],"YYYY-MM-DD HH:mm").format("YYYY-MM-DD HH:mm");
        end = moment(dates[1],"YYYY-MM-DD HH:mm").format("YYYY-MM-DD HH:mm");

    }
        
    $('#filter_date').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'All time': [moment("2010-01-01","YYYY-MM-DD").format("YYYY-MM-DD"), moment()],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        locale:{
            format: 'YYYY-MM-DD HH:mm',
            cancelLabel: 'Clear'
        }
	});

    $('#filter_date').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm:ss'));
    });

    $('#filter_date').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

</script>
<script>
    function filter(){
        var url = '';

        if($('#filter_agent').val() != '' ){
            url += '&filter_agent=' + encodeURIComponent($('#filter_agent').val());
        }

        if($('#filter_status').val() != '' ){
            url += '&filter_status=' + encodeURIComponent($('#filter_status').val());
        }

        if($('#filter_date').val() != '' ){
            url += '&filter_date=' + encodeURIComponent($('#filter_date').val());
        }

      
        
        location.href = "{{ route('invoices',) }}/?" + url
    }
     function clearFilter(){
        location.href = "{{ route('invoices') }}"
    }
</script>
@endsection
