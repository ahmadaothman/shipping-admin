@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>List Of Shipments</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">List Of Shipments</li>
                        </ol>
                    </nav>
                </div>
                @error('file')
                <h1 >* {{ $message }}</h1>
            @enderror
                <div class="col-md-6 col-sm-12 text-right">
                    <div class="dropdown">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            Actions
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="/shipments/add"><i class="icon-copy fa fa-plus" aria-hidden="true"></i> Add Shipment</a>
                            <form id="import_excel_form" action="{{ route('importShipmentsExcel') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <a class="dropdown-item" onclick="importExcelFile();"><i class="icon-copy fa fa-file-excel-o" aria-hidden="true"></i> Import Excel File</a>
                                <input type="file" name="excelfile" id="excelfile" class="d-none"  enctype="multipart/form-data" />
                            </form>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        

        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <div class="clearfix mb-20">
                <div class="pull-left">
                    <h5 class="text-blue">Shipments</h5>
                </div>
                <p>
                    <a class="btn btn-outline-info float-right" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="icon-copy fa fa-filter" aria-hidden="true"></i> Filters
                    </a>
                  
                </p>
            </div>
       
            <div class="collapse mb-4" id="collapseExample" >
                <div class="card card-body">
                    <div class="row">
                        <div class="form-group form-group-sm col-md-2">
                            <small><label for="filter_reference">Reference</label></small>
                            <input type="text" class="form-control form-control-sm h-50" id="filter_reference"  placeholder="Reference" value="{{ app('request')->input('filter_reference') }}">
                        </div>
                        <div class="form-group form-group-sm col-md-2">
                            <small><label for="filter_traking_number">Tracking Number</label></small>
                            <input type="text" class="form-control form-control-sm h-50" id="filter_traking_number"  placeholder="Traking Number" value="{{ app('request')->input('filter_traking_number') }}">
                        </div>
                        <div class="form-group form-group-sm col-md-2">
                            <small><label for="filter_date">Date</label></small>
                            <input type="text" class="form-control form-control-sm h-50" id="filter_date"  autocomplete="off" placeholder="Date">
                        </div>
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
                            <small><label for="filter_status_group">Status Group</label></small>
                            <select class="form-control form-control-sm h-50 selectpicker" id="filter_status_group" multiple="multiple" data-actions-box="true" data-live-search="true">
                                @foreach ($status_groups as $group)
                                    @if(in_array($group->id,explode(",",app('request')->input('filter_status_group'))))
                                    <option value="{{ $group->id }}" selected>{{ $group->name }}</option>
                                    @else
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group form-group-sm col-md-2">
                            <small><label for="filter_agent">Status</label></small>
                            <select class="form-control form-control-sm h-50 selectpicker" id="filter_status"  multiple="multiple" data-actions-box="true" data-live-search="true">
                                @foreach ($status as $status)
                                @if(in_array($status->id,explode(",",app('request')->input('filter_status'))))
                                <option value="{{ $status->id }}" selected>{{ $status->name }}</option>
                                @else
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group form-group-sm col-md-2">
                            <small><label for="filter_name">Name</label></small>
                            <input type="text" class="form-control form-control-sm h-50" id="filter_name"  placeholder="Customer Name" value="{{ app('request')->input('filter_name') }}">
                        </div>
                        <div class="form-group form-group-sm col-md-2">
                            <small><label for="filter_telephone">Telephone</label></small>
                            <input type="text" class="form-control form-control-sm h-50" id="filter_telephone" placeholder="Customer Telephone" value="{{ app('request')->input('filter_telephone') }}">
                        </div>
                        <div class="form-group form-group-sm col-md-2">
                            <small><label for="filter_country">Country</label></small>
                            <select class="form-control form-control-sm h-50 selectpicker" id="filter_country"  >
                            </select>
                        </div>
                        <div class="form-group form-group-sm col-md-2">
                            <small><label for="filter_state">State</label></small>
                            <select class="form-control form-control-sm h-50 selectpicker" id="filter_state"  >
                            </select>
                        </div>
                        <div class="form-group form-group-sm col-md-2">
                            <small><label for="filter_region">Region</label></small>
                            <select class="form-control form-control-sm h-50 selectpicker" id="filter_region"  >
                            </select>
                        </div>
                        <div class="form-group form-group-sm col-md-2">
                            <small><label for="filter_city">City</label></small>
                            <select class="form-control form-control-sm h-50 selectpicker" id="filter_city"  >
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 text-right">
                            <button type="button" class="btn btn-primary btn-sm" onclick="filter()"><i class="icon-copy fa fa-filter" aria-hidden="true"></i> Filter</button>
                        </div>
                    </div>
                </div>
            </div>

            <form id="form" method="POST" enctype="multipart/form-data">
                <table class="table table-sm table-hover table-hover table-striped">
                    <thead>
                        <tr>
                            <th><input id="select-all" type="checkbox"/></th>
                            <th class="text-center"><small><strong>ID</small></strong></th>
                            <th class="text-center"><small><strong>Service</small></strong></th>
                            <th class="text-center"><small><strong>Date</small></strong></th>
                            <th class="text-center">Status</th>
                            <th class="text-center"><small><strong>Agent</small></strong></th>
                            <th><small><strong>Customer</small></strong></th>
                            <th><small><strong>Address</small></strong></th>
                            <th><small><strong>Amount</small></strong></th>
                            <th><small><strong>Note</small></strong></th>
                            <th><small><strong>Action</small></strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shipments as $shipment)
                            <tr>
                                <td class="align-middle"><input type="checkbox" name="selected[]"/></td>
                                <td class="align-middle text-center">
                                    <small class="text-muted">{{ $shipment->id }}</small><br/>
                                    <small><strong >Ref: {{ $shipment->reference }}</strong></small><br/>
                                    <small>{{ $shipment->tracking_number }}</small>
                                </td>
                                <td class="align-middle text-center">
                                    @if($shipment->service_type_id ==1)
                                    <small class="text-info"><strong>Normal</strong></small>
                                    @elseif($shipment->service_type_id ==2)
                                    <small class="text-warning"><strong>Reverse</strong></small>
                                    @elseif($shipment->service_type_id ==3)
                                    <small class="text-success"><strong>Exchange</strong></small>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <strong><small>{{ $shipment->created_at }}</small></strong>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="text-white text-center p-1  rounded {{ $shipment->Status->StatusGroup->color }}" data-toggle="tooltip" data-placement="top" title="{{ $shipment->Status->name }}">
                                        <small>
                                            <strong >{{ $shipment->Status->StatusGroup->name }}</strong>
                                        </small>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <small>{{ $shipment->agent->name }}</small><br/>
                                    <small>{{ $shipment->agent->website }}</small><br/>
                                    <small>{{ $shipment->agent->countryFlagImoji }}</small><br/>
                                </td>
                                <td class="align-middle">
                                    <small><strong>{{ $shipment->customer_name }}</strong></small><br/>
                                    <small>{{ $shipment->customer_telephone }}</small><br/>
                                </td>
                                <td class="align-middle">
                                    <small>{{ $shipment->countryFlagImoji }}</small><br/>
                                    <small>{{ $shipment->customer_state }}</span><br/>
                                    <small>{{ $shipment->customer_city }}</small><br/>
                                    <small>{{ $shipment->zip_code }}</small><br/>
                                </td>
                                <td class="align-middle">
                                    <strong>{{ $shipment->Currency->left_symbole }} {{ $shipment->FormatedAmount }} {{ $shipment->Currency->right_symbole }}</strong><br/>
                                </td>
                                <td class="align-middle">
                                    <small>{{ $shipment->customer_comment }}</small><br/>
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group ">
                                        <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          A
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                          <a class="dropdown-item" href="{{ route('ShipmentA4Print',['id'=>$shipment->id]) }}" target="_blank"><i class="icon-copy fa fa-print" aria-hidden="true"></i>  Print</a>
                                          <a class="dropdown-item" href="#"><i class="icon-copy fa fa-list-ul" aria-hidden="true"></i>  View</a>
                                          <a class="dropdown-item" href="{{ route('editShipment',['id'=>$shipment->id]) }}"><i class="icon-copy fa fa-edit" aria-hidden="true"></i>  Edit</a>
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#"><i class="icon-copy fa fa-minus-square-o" aria-hidden="true"></i>  Cancel</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
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
<script type="text/javascript">
    function importExcelFile(){
        $('#excelfile').trigger('click');   
   
    }

    $(document).ready(function(){
        $("#excelfile").change(function(){
            $('#import_excel_form').submit()        
        });
    });

    $('#select-all').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;                        
            });
        } else {
            $(':checkbox').each(function() {
                this.checked = false;                       
            });
        }
    });
</script>
<script type="text/javascript">
    function filter(){
        var url = '';

        if($('#filter_reference').val() != '' ){
            url += '&filter_reference=' + encodeURIComponent($('#filter_reference').val());
        }

        if($('#filter_traking_number').val() != '' ){
            url += '&filter_traking_number=' + encodeURIComponent($('#filter_traking_number').val());
        }

        if($('#filter_date').val() != '' ){
            url += '&filter_date=' + encodeURIComponent($('#filter_date').val());
        }

        if($('#filter_agent').val() != '' ){
            url += '&filter_agent=' + encodeURIComponent($('#filter_agent').val());
        }

        if($('#filter_status_group').val() != '' ){
            url += '&filter_status_group=' + encodeURIComponent($('#filter_status_group').val());
        }

        if($('#filter_status').val() != '' ){
            url += '&filter_status=' + encodeURIComponent($('#filter_status').val());
        }

        if($('#filter_name').val() != '' ){
            url += '&filter_name=' + encodeURIComponent($('#filter_name').val());
        }

        if($('#filter_telephone').val() != '' ){
            url += '&filter_telephone=' + encodeURIComponent($('#filter_telephone').val());
        }

        location.href = "{{ route('shipments',) }}/?" + url
    }
</script>
@endsection
