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
                          <!--  <form id="import_excel_form" action="{{ route('importShipmentsExcel') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <a class="dropdown-item" onclick="importExcelFile();"><i class="icon-copy fa fa-file-excel-o" aria-hidden="true"></i> Import Excel File</a>
                                <input type="file" name="excelfile" id="excelfile" class="d-none"  enctype="multipart/form-data" />
                            </form>-->
                            <a  class="dropdown-item" href="{{ route('shipments',array_merge(Request::all(),['manifest'=>true]))}}" target="_blank"><i class="icon-copy fa fa-list-ul" aria-hidden="true"></i> Manifest</a>
                            <a class="dropdown-item" data-toggle="modal" data-target="#EmailModal"><i class="icon-copy fa fa-envelope-o" aria-hidden="true"></i> Send Email To Agents</a>
                            
                            <a class="dropdown-item" data-toggle="modal" data-target="#SMSModal"><i class="icon-copy fa fa-commenting-o" aria-hidden="true"></i> Send SMS To Customers</a>

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
                            <div class="d-none">
                                {{ app('request')->input('filter_country') != null ? $country = app('request')->input('filter_country') :  $country = old('customer_country') }}
                            </div>
                            <select class="form-control form-control-sm h-50 selectpicker" id="filter_country"  >
                                <option value="-1">--none--<option>
                                @foreach ($countries as $key => $value)
                                @if ((isset($value['name_en']) && !empty($value['name_en'])) && (isset($value['cca2']) && !empty($value['cca2'])))
                                    @if ($value['cca2'] == $country)
                                        <option value="{{ $value['cca2'] }}" selected="selected" >{{ $value['name_en'] }}</option>
                                    @else
                                        <option value="{{ $value['cca2'] }}" >{{ $value['name_en'] }}</option>
                                    @endif
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group form-group-sm col-md-2">
                            <small><label for="filter_state">State</label></small>
                           
                            <select class="form-control form-control-sm h-50 selectpicker" id="filter_state"  >
                                
                            </select>
                        </div>
                        <div class="form-group form-group-sm col-md-2">
                            <small><label for="filter_region">Region</label></small>
                            <select class="form-control form-control-sm h-50 selectpicker" id="filter_region"  data-actions-box="true" data-live-search="true">
                            </select>
                        </div>
                        <div class="form-group form-group-sm col-md-2">
                            <small><label for="filter_city">City</label></small>
                            <select class="form-control form-control-sm h-50 selectpicker" id="filter_city" data-actions-box="true" data-live-search="true">
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <small><label for="filter_pickup_type">Pickup Type</label></small>

                            <div class="d-none">
                                {{ app('request')->input('filter_pickup_type') != null ? $filter_pickup_type = app('request')->input('filter_pickup_type') :  $filter_pickup_type = old('filter_pickup_type') }}
                            </div>

                            <select class="form-control form-control-sm h-50" id="filter_pickup_type">
                                <option value="-1">-none--</option>
                                <option value="normal" @if($filter_pickup_type == 'normal') selected @endif>Normal</option>
                                <option value="pickup_from_shipper" @if($filter_pickup_type == 'pickup_from_shipper') selected @endif>Pickup From Shipper</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <small><label for="filter_driver">Driver</label></small>
                            <select class="form-control form-control-sm h-50" id="filter_driver">
                                <option value="-1">-none--</option>
                                @foreach($drivers as $driver)
                                    @if(app('request')->input('filter_driver') == $driver->id)
                                        <option value="{{ $driver->id }}" selected>{{ $driver->name}}</option>
                                    @else
                                        <option value="{{ $driver->id }}">{{ $driver->name}}</option>
                                    @endif
                                @endforeach
                            </select>
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

      

            <form id="form" method="POST" enctype="multipart/form-data">
                @csrf
                <hr>
                <div class="container">
                    <h4>Bulk Change</h4>
                    
                    <div class="row mt-4 mb-4">
                        <div class="col-sm-4 ">
                            <label for="shipment_status">Status</label>
                            <select name="shipment_status" id="shipment_status" class="form-control form-control-sm">
                                @foreach($shipment_status as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="drivers">Driver</label>
                            <select name="drivers" id="drivers" class="form-control  form-control-sm">
                                <option value="0">--none--</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <br>
                            <button type="submit" class="btn btn-primary">Assign</button>
                        </div>
                    </div>
                </div>
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
                            <th><small><strong>Driver</small></strong></th>
                            <th><small><strong>Note</small></strong></th>
                            <th><small><strong>Date Added</small></strong></th>
                            <th><small><strong>Date Modified</small></strong></th>
                            <th><small><strong>Action</small></strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shipments as $shipment)
                            <tr>
                                <td class="align-middle"><input type="checkbox" name="selected[]" value="{{ $shipment->id }}"/></td>
                                <td class="align-middle text-center">
                                    <small class="text-muted">{{ $shipment->id }}</small><br/>
                                    <small><strong >Ref: {{ $shipment->reference }}</strong></small><br/>
                                    <small>{{ $shipment->tracking_number }}</small>
                                </td>
                                <td class="align-middle text-center">
                                    @if($shipment->service_type_id ==1)
                                    <strong class="text-info">Normal</strong>
                                    @elseif($shipment->service_type_id ==2)
                                    <strong class="text-warning">Reverse</strong>
                                    @elseif($shipment->service_type_id ==3)
                                    <strong class="text-success">Exchange</strong>
                                    @endif
                                    <br>
                                    @if($shipment->pickup_type == 'pickup_from_shipper')
                                    <small>Pickup From Customer</small>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <strong><small>{{ $shipment->created_at }}</small></strong>
                                </td>
                                <td class="align-middle text-center">
                                    

                                    @if ($shipment->status_id == 19)
                                    <div class="text-white text-center p-1  rounded {{ $shipment->Status->StatusGroup->color }}" data-toggle="tooltip" data-placement="top" title="{{ $shipment->Status->name }}">
                                        <small>
                                            <strong >Awaiting To Paid</strong>
                                        </small>
                                    </div>
                                    @else
                                    <div class="text-white text-center p-1  rounded {{ $shipment->Status->StatusGroup->color }}" data-toggle="tooltip" data-placement="top" title="{{ $shipment->Status->name }}">
                                        <small>
                                            <strong >{{ $shipment->Status->StatusGroup->name }}</strong>
                                        </small>
                                    </div>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <small>{{ $shipment->agent->name }}</small><br/>
                                    <small>{{ $shipment->agent->website }}</small><br/>
                                    <small></small><br/>
                                </td>
                                <td class="align-middle">
                                    <small><strong>{{ $shipment->customer_name }}</strong></small><br/>
                                    <small>{{ $shipment->customer_telephone }}</small><br/>
                                </td>
                                <td class="align-middle">
                                    <small></small><br/>
                                    <small>{{ $shipment->customer_state }}, {{ $shipment->customer_region }}</span><br/>
                                    <small>{{ $shipment->customer_city }}</small><br/>
                                    <small>{{ $shipment->zip_code }}</small><br/>
                                </td>
                                <td class="align-middle">
                                    <strong>{{ $shipment->Currency->left_symbole }} {{ $shipment->FormatedAmount }} {{ $shipment->Currency->right_symbole }}</strong><br/>
                                </td>
                                <td class="align-middle">
                                    @if($shipment->Driver)
                                    <small>{{ $shipment->Driver->name }}</small>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <small>{{ $shipment->customer_comment }}</small><br/>
                                </td>
                                <td class="align-middle">
                                    <small>{{ $shipment->created_at }}</small><br/>
                                </td>
                                <td class="align-middle">
                                    <small>{{ $shipment->updated_at }}</small><br/>
                                </td>
                                <td class="align-middle">
                                
                                    <div class="btn-group ">
                                        <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          A
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">

                                          <a class="dropdown-item" href="{{ route('ShipmentA4Print',['id'=>$shipment->id]) }}" target="_blank"><i class="icon-copy fa fa-print" aria-hidden="true"></i>  Print</a>
                                          <a class="dropdown-item" href="{{ route('labelPrint',['id'=>$shipment->id]) }}" target="_blank"><i class="icon-copy fa fa-print" aria-hidden="true"></i>  Print Label</a>

                                          <a class="dropdown-item" href="{{ route('editShipment',array_merge(Request::all(),['id'=>$shipment->id])) }}"><i class="icon-copy fa fa-edit" aria-hidden="true"></i>  Edit</a>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="w-100" >
                   
                    {{ $shipments->appends($_GET)->links('vendor.pagination.default') }}
                    <div class="float-right h-100" style="padding-top: 25px">
                        <strong>
                            Showing {{ $shipments->count() }} From {{ $shipments->total() }} Shipments
                        </strong>
                    </div>

                </div>

            </form>
            <!--Email Model-->
            <div class="modal fade  bd-example-modal-lg" id="EmailModal" tabindex="-1" role="dialog" aria-labelledby="EmailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Send Email To Agents</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <textarea id="email_text" name="email_text">{{ $email_text }}</textarea>
                    </div>
                    <div class="modal-footer">
                      <button type="button" id="send_email_button" class="btn btn-primary" onclick="sendEmails()"><i class="icon-copy fa fa-envelope-o" aria-hidden="true"></i> Send email</button>
                      
                      <button id="send_email_loader" class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                      </button>

                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      
                    </div>
                  </div>
                </div>
            </div>
            <!--SMS Model-->
            <div class="modal fade  bd-example-modal-lg" id="SMSModal" tabindex="-1" role="dialog" aria-labelledby="SMSModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Send SMS To</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <textarea id="sms_text" name="sms_text" class="w-100">{{ $message_text }}</textarea>
                    </div>
                    <div class="modal-footer">
                      <button type="button" id="send_sms_button" class="btn btn-primary" onclick="sendSMS()"><i class="icon-copy fa fa-commenting-o" aria-hidden="true"></i> Send SMS</button>
                      <button id="send_sms_loader" class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                      </button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('/src/plugins/daterangpicker/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/src/plugins/daterangpicker/js/daterangepicker.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('/src/plugins/daterangpicker/css/daterangepicker.css') }}" />

<script src="//cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
<script type="text/javascript">
    makeCkEditor();
    var theEditor;

    function makeCkEditor(){


        CKEDITOR.replace('email_text');

        CKEDITOR.instances.email_text.on("change", function() {
            theEditor = this.getData()
        });
    
    }

    function getDataFromTheEditor() {
        return theEditor;
    }
</script>

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

        if($('#filter_country').val() != '-1' && $('#filter_country').val() != '' && $('#filter_country').val() != null  ){
            url += '&filter_country=' + encodeURIComponent($('#filter_country').val());
        }

        if($('#filter_state').val() != '-1' && $('#filter_state').val() != ''  && $('#filter_state').val() != null){
            url += '&filter_state=' + encodeURIComponent($('#filter_state').val());
        }

        if($('#filter_region').val() != '-1' && $('#filter_region').val() != ''  && $('#filter_region').val() != null){
            url += '&filter_region=' + $('#filter_region').val();
        }

        if($('#filter_city').val() != '-1' && $('#filter_city').val() != ''  && $('#filter_city').val() != null){
            url += '&filter_city=' + $('#filter_city').val();
        }

        if($('#filter_pickup_type').val() != '-1' && $('#filter_pickup_type').val() != ''  && $('#filter_pickup_type').val() != null){
            url += '&filter_pickup_type=' + $('#filter_pickup_type').val();
        }

        if($('#filter_driver').val() != '-1' && $('#filter_driver').val() != ''  && $('#filter_driver').val() != null){
            url += '&filter_driver=' + $('#filter_driver').val();
        }
        
        location.href = "{{ route('shipments',) }}/?" + url
    }

    function clearFilter(){
        location.href = "{{ route('shipments') }}"
    }
</script>
<script type="text/javascript">
    var states_select = $('#filter_state');
    var regions_select = $('#filter_region');
    var cities_select = $('#filter_city');

    $('#filter_country').on('change', function() {
        getStates(this.value)
    });

    $('#filter_state').on('change', function() {
        getRegions(this.value)
    });

    $('#filter_region').on('change', function() {
        getCities(this.value)
    });

    getStates("{{ app('request')->input('filter_country') }}")

    var state = "";

    "@if(app('request')->input('filter_state') != null)"
        state = "{{ app('request')->input('filter_state') }}"
    "@else"
        state = ""
    "@endif"

    function getStates(country_code){
        states_select.empty()
        states_select.append(new Option("--none--", "-1"))
        $.ajax({
            url: "{{ route('shippingCountryStates') }}",
            type: 'GET',
            data:{
                'country':country_code
            },
            success:function(data){
                $.each(data,function(k,v){
                    if(state == v.extra.woe_name){
                        states_select.append(new Option(v.extra.woe_name, v.extra.woe_name,true))
                    }else{
                        states_select.append(new Option(v.extra.woe_name, v.extra.woe_name))
                    }
                  
                })
                $('#filter_state').val(state)
                $('#filter_state').selectpicker('refresh');
                getRegions(states_select.val())
                
            }
        })
    }

    var region = "";

    "@if(app('request')->input('filter_region') != null)"
        region = "{{ app('request')->input('filter_region') }}"
    "@else"
        region = ""
    "@endif"
    
    function getRegions(state){
        regions_select.empty()
        regions_select.append(new Option("--none--", "-1"))
        $.ajax({
            url: "{{ route('regionsBySate') }}",
            type: 'GET',
            data:{
                'state':state
            },
            success:function(data){
                $.each(data,function(k,v){
              
                    
                    regions_select.append(new Option(v.name, v.name))

                    if(region == v.name){
                   
                        regions_select.val(v.name)
                    }
                })

                $('#filter_region').val(region)
                $('#filter_region').selectpicker('refresh');
                getCities(regions_select.val())
                
            }
        })
    }

    var city = "";
   "@if(app('request')->input('filter_city') != null)"
        city = "{{ app('request')->input('filter_city') }}"
    "@else"
        city = ""
    "@endif"

    function getCities(region){
        cities_select.empty()

        $.ajax({
            url: "{{ route('getCitiesByRegion') }}",
            type: 'GET',
            data:{
                'region':region
            },
            success:function(data){
                $.each(data,function(k,v){
              
                    
                    cities_select.append(new Option(v.name, v.name))

                    if(city == v.name){
                        
                        cities_select.val(v.name)
                    }
                })

                $('#filter_city').val(city)
                $('#filter_city').selectpicker('refresh');
                
            }
        })
    }
</script>
<script type="text/javascript">
    $('#send_email_loader').hide();
    function sendEmails(){
        $('#send_email_button').hide();
        $('#send_email_loader').show();
        var email_content = typeof getDataFromTheEditor() != 'undefined' ? getDataFromTheEditor() : $('textarea#email_text').val();
        $.ajax({
            url:"{{ route('emailShipments') }}",
            type:'POST',
            data:
                $('#form input[type="checkbox"]:checked').serialize() + "&content=" + email_content + "&_token={{ csrf_token() }}"
            ,
            success:function(json){
                $('#send_email_button').show();
                $('#send_email_loader').hide();

                $('#EmailModal').modal('hide');

            },
            error: function (request, status, error) {
                $('#send_email_button').show();
                $('#send_email_loader').hide();

                $('#EmailModal').modal('hide');
            }
        })
    }

    $('#send_sms_loader').hide();
    function sendSMS(){
        $('#send_sms_button').hide();
        $('#send_sms_loader').show();
        var sms_content = $('textarea#sms_text').val();
        $.ajax({
            url:"{{ route('smsShipments') }}",
            type:'POST',
            data:
                $('#form input[type="checkbox"]:checked').serialize() + "&content=" + sms_content + "&_token={{ csrf_token() }}"
            ,
            success:function(json){
                $('#send_sms_button').show();
                $('#send_sms_loader').hide();

                $('#SMSModal').modal('hide');

            },
            error: function (request, status, error) {
                $('#send_sms_button').show();
                $('#send_sms_loader').hide();

                $('#SMSModal').modal('hide');
            }
        })
    }
</script>
@endsection
