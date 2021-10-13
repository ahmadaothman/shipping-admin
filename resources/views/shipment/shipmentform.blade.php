@extends('index')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('/src/plugins/jquery-steps/build/jquery.steps.css') }}">
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Shipments</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Shipment Form</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <div class="dropdown">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            January 2018
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Export List</a>
                  
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <div class="clearfix">
                <h4 class="text-blue">Shipment Information</h4>
            </div>
            <div class="wizard-content">
                <form id="form" class="tab-wizard wizard-circle wizard" action="{{ $action }}" method="POST" >
                    @csrf
                    <h5>Customer Info</h5>
                    <section>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label >Customer Name :</label>
                                    <input type="text" class="form-control customer-info" placeholder="Customer Name" name="customer_name" value="{{ isset($shipment->customer_name) ? $shipment->customer_name :  old('customer_name') }}" required>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label >Customer Email :</label>
                                    <input type="email" class="form-control customer-info" placeholder="name@mail.com" name="customer_email" value="{{ isset($shipment->customer_email) ? $shipment->customer_email :  old('customer_email') }}">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label >Customer Telephone :</label>
                                    <input type="tel" class="form-control customer-info" placeholder="000 000 0000" name="customer_telephone" value="{{ isset($shipment->customer_telephone) ? $shipment->customer_telephone :  old('customer_telephone') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label >Gander:</label>
                                    <div class="d-none">
                                        {{ isset($shipment->customer_gender) ? $gander = $shipment->customer_gender :  $gander = old('customer_gender' ) }}
                                        
                                    </div>
                                    <select name="customer_gender" class="form-control customer-info">
                                        <option value="-1">--none--</option>
                                        @if ($gander == 'm')
                                            <option value="m" selected>M</option>
                                        @else
                                            <option value="m">M</option>
                                        @endif

                                        @if ($gander == 'f')
                                            <option value="f" selected>F</option>
                                        @else
                                            <option value="f">F</option>
                                        @endif

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group" >
                                    <label>Country :</label>
                                    <div class="d-none">
                                        {{ isset($shipment->customer_country) ? $country = $shipment->customer_country :  $country = old('customer_country', $country_code ) }}
                                        
                                    </div>
                                    <select name="customer_country" id="customer_country" class="form-control select-picker  customer-info"  data-size="5" data-live-search="true" >
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
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group" >
                                    <label>State :</label>
                                    
                                    <select name="customer_state" id="customer_state" class="form-control select-picker  customer-info"  data-size="5" data-live-search="true" >
                                      
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label >Region :</label>
                                    <select name="customer_region" id="customer_region" class="form-control select-picker  customer-info"  data-size="5" data-live-search="true" >
                                      
                                    </select>                                
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label >City :</label>
                                    <select name="customer_city" id="customer_city" class="form-control select-picker  customer-info"  data-size="5" data-live-search="true" >
                                      
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label >Zip Code :</label>
                                    <input type="text" class="form-control customer-info" placeholder="0000 0000" name="zip_code" value="{{ isset($shipment->zip_code) ? $shipment->zip_code :  old('zip_code') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label >Building :</label>
                                    <input type="text" class="form-control customer-info" placeholder="Customer Building" name="customer_building" value="{{ isset($shipment->customer_building) ? $shipment->customer_building :  old('customer_building') }}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label >Floor :</label>
                                    <input type="text" class="form-control customer-info" placeholder="Customer Floor" name="customer_floor" value="{{ isset($shipment->customer_floor) ? $shipment->customer_floor :  old('customer_floor') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label >Directions :</label>
                                    <input type="text" class="form-control customer-info" placeholder="Street, Face to, Before...etc" name="customer_directions" value="{{ isset($shipment->customer_directions) ? $shipment->customer_directions :  old('customer_directions') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label >Latitude :</label>
                                    <input type="text" class="form-control customer-info" placeholder="##.######" name="latitude" value="{{ isset($shipment->latitude) ? $shipment->latitude :  old('latitude') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label >Longitude :</label>
                                    <input type="text" class="form-control customer-info" placeholder="###.######" name="longitude" value="{{ isset($shipment->longitude) ? $shipment->longitude :  old('longitude') }}">
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Shipment Info -->
                    <h5>Shipment Info</h5>
                    <section>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label >Agent :</label>
                                    <input type="text" id="agent_autocomplete" class="form-control shipment-info" required placeholder="Search for agent..." value="{{ isset($shipment->Agent->name) ? $shipment->Agent->name :  old('agent_name') }}" autocomplete="off">
                                    <input type="hidden" name="agent_id" value="{{ isset($shipment->agent_id) ? $shipment->agent_id :  old('agent_id') }}" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label >Shipment Reference :</label>
                                    <input type="text" class="form-control shipment-info" required placeholder="#Ref" name="reference" value="{{ isset($shipment->reference) ? $shipment->reference :  old('reference') }}">
                                    <input type="hidden" class="form-control " name="tracking_number" value="{{ isset($shipment->tracking_number) ? $shipment->tracking_number :  old('tracking_number') }}">
                                    <input type="hidden" class="form-control " name="status_id" value="{{ isset($shipment->status_id) ? $shipment->status_id :  old('status_id') }}">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Preferred Date :</label>
                                    <input type="date" name="preferred_date" class="form-control shipment-info" placeholder="Select Date" value="{{ isset($shipment->preferred_date) ? $shipment->preferred_date :  old('preferred_date') }}">
                                </div>
                               
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Preferred Time From:</label>
                                    <input class="form-control time-picker shipment-info" name="preferred_time_from" placeholder="Select time" type="text" value="{{ isset($shipment->preferred_time_from) ? $shipment->preferred_time_from :  old('preferred_time_from') }}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Preferred Time To:</label>
                                    <input class="form-control time-picker shipment-info" name="preferred_time_to" placeholder="Select time" type="text" value="{{ isset($shipment->preferred_time_to) ? $shipment->preferred_time_to :  old('preferred_time_to') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group shipment-info">
                                    <label>Currency :</label>
                                    <div class="d-none">
                                        {{ isset($shipment->currency_id) ? $currency_id = $shipment->currency_id :  $currency_id = old('currency_id', 'lbp' ) }}
                                        
                                    </div>
                                    <select class="form-control" name="currency_id">
                                       @foreach ($currencies as $currency)
                                           @if($currency->id == $currency_id)
                                            <option value="{{ $currency->id }}" selected>{{ $currency->title }}</option>
                                           @else
                                            <option value="{{ $currency->id }}" >{{ $currency->title }}</option>
                                           @endif
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group shipment-info">
                                    <label>Service Type :</label>
                                    <div class="d-none">
                                        {{ isset($shipment->service_type_id) ? $service_type_id = $shipment->service_type_id :  $service_type_id = old('service_type_id' ) }}
                                        
                                    </div>
                                    <select class="form-control shipment-info" name="service_type_id">
                                       @foreach ($service_types as $service_type)
                                           @if($service_type->id == $service_type_id)
                                            <option value="{{ $service_type->id }}" selected>{{ $service_type->name }}</option>
                                           @else
                                            <option value="{{ $service_type->id }}" >{{ $service_type->name }}</option>
                                           @endif
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group shipment-info">
                                    <label>Pickup type:</label>
                                    <div class="d-none">
                                        {{ isset($shipment->pickup_type) ? $pickup_type = $shipment->pickup_type :  $pickup_type = old('pickup_type') }}
                                    </div>
                                    <select class="form-control shipment-info" name="pickup_type">
                                        @if($pickup_type == 'normal'){
                                            <option value="normal" selected>Normal</option>
                                        @else
                                            <option value="normal">Normal</option>
                                        @endif

                                        @if($pickup_type == 'pickup_from_shipper'){
                                            <option value="pickup_from_shipper" selected>Pickup From Shipper</option>
                                        @else
                                            <option value="pickup_from_shipper">Pickup From Shipper</option>
                                        @endif

                                    </select>
                                </div>
                            </div>
                            
                        
                        </div>
                    </section>
                    <!-- Builing -->
                    <h5>Builing</h5>
                    <section>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label >Weight :</label>
                                    <input type="number" class="form-control" placeholder="00.00 $" name="weight" value="{{ isset($shipment->weight) ? $shipment->weight :  old('weight') }}">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label >Amount :</label>
                                    <input type="number" class="form-control" placeholder="00.00 $" name="amount" value="{{ isset($shipment->amount) ? $shipment->amount :  old('amount') }}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label >Payment method :</label>
                                    <div class="d-none">
                                        {{ isset($shipment->payment_method_id) ? $payment_method_id = $shipment->payment_method_id :  $payment_method_id = old('payment_method_id' ) }}

                                    </div>
                                    <select name="payment_method_id" class="form-control">
                                        @foreach ($payment_methods as $payment_method)
                                            @if($payment_method->id == $payment_method_id)
                                            <option value="{{ $payment_method->id }}" selected>{{ $payment_method->name }}</option>
                                        @else
                                            <option value="{{ $payment_method->id }}" >{{ $payment_method->name }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                          

        
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label >Customer Comment :</label>
                                    <input type="text" class="form-control" placeholder="Customer Comment" name="customer_comment" value="{{ isset($shipment->customer_comment) ? $shipment->customer_comment :  old('customer_comment') }}">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label >Shipper Comment :</label>
                                    <input type="text" class="form-control" placeholder="Shipper Comment" name="agent_comment" value="{{ isset($shipment->agent_comment) ? $shipment->agent_comment :  old('agent_comment') }}">
                                </div>
                            </div>

                            
                        </div>
                    </section>
                    <!-- Overview -->
                    <h5>Overview</h5>
                    <section>
                        <div class="row">
                            <table class="table table-bordered table-sm m-2">
                                <tr>
                                    <td class="text-center" colspan="6"><strong>Customer Info</strong></td>
                                </tr>
                                <tr>
                                    <td>Customer Name:</td>
                                    <td id="overview_customer_name"></td>
                                    <td>Email:</td>
                                    <td id="overview_email"></td>
                                    <td>Telephone:</td>
                                    <td id="overview_telephone"></td>
                                </tr>
                                <tr>
                                    <td>Country:</td>
                                    <td id="overview_country"></td>
                                    <td>Region:</td>
                                    <td id="overview_region"></td>
                                    <td>City:</td>
                                    <td id="overview_city"></td>
                                </tr>
                                <tr>
                                    <td>Zip Code:</td>
                                    <td id="overview_zip_code"></td>
                                    <td>Building:</td>
                                    <td id="overview_building"></td>
                                    <td>Floor:</td>
                                    <td id="overview_floor"></td>
                                </tr>
                                <tr>
                                    <td>Directions</td>
                                    <td colspan="5" id="overview_directions"></td>
                                </tr>
                            </table>
                            <table class="table table-bordered table-sm m-2">
                                <tr>
                                    <td class="text-center" colspan="4"><strong>Shipment Info</strong></td>
                                </tr>
                                <tr>
                                    <td>Agent:</td>
                                    <td id="overview_agent"></td>
                                    <td>Reference:</td>
                                    <td id="overview_ref"></td>
                                </tr>
                                <tr>
                                    <td>Currency:</td>
                                    <td id="overview_currency"></td>
                                    <td>Service Type:</td>
                                    <td id="overview_service_type"></td>
                                </tr>
                            </table>
                            <table class="table table-bordered table-sm m-2">
                                <tr>
                                    <td class="text-center" colspan="6"><strong>Builing</strong></td>
                                </tr>
                                <tr>
                                    <td>Weight:</td>
                                    <td id="overview_weight"></td>
                                    <td>Amount:</td>
                                    <td id="overview_amount"></td>
                                    <td>Payment Method:</td>
                                    <td id="overview_payment_method"></td>
                                </tr>
                                <tr>
                                    <td>Customer Comment</td>
                                    <td colspan="5" id="overview_customer_comment"></td>
                                </tr>
                                <tr>
                                    <td>Shipper Comment</td>
                                    <td colspan="5" id="overview_shipper_comment"></td>
                                </tr>
                            </table>
                        </div>
                    </section>
                </form>
            </div>
        </div>

 
        <!-- success Popup html Start -->
        <div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center font-18">
                        <h3 class="mb-20">Form Submitted!</h3>
                        <div class="mb-30 text-center"><img src="vendors/images/success.png"></div>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- success Popup html End -->
    </div>
</div>
<script src="{{ asset('/src/plugins/jquery-steps/build/jquery.steps.js') }}"></script>
<script>
    $(".tab-wizard").steps({
        headerTag: "h5",
        bodyTag: "section",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
            finish: "Submit"
        },
        onStepChanging:function(event, currentIndex, priorIndex){

            if(currentIndex == 0 && priorIndex == 1){
                var valid = true;
                $('.customer-info').removeClass("is-invalid");

                $('.customer-info').each(function(){
                    if($(this).prop('required') && $(this).val() == ""){
                        $(this).addClass("is-invalid")
                        valid = false
                    }
                })
                return valid
            }else if(currentIndex == 1 && priorIndex == 2){
                var valid = true;
                $('.shipment-info').removeClass("is-invalid");

                $('.shipment-info').each(function(){
                    if($(this).prop('required') && $(this).val() == ""){
                        $(this).addClass("is-invalid")
                        valid = false
                    }
                })
                var shipment_id = "{{ isset($shipment->id) ? $shipment->id : ''}}"

                if(shipment_id == ""){
                    $.ajax({
                    url:"{{ route('check_reference') }}",
                    type:'GET',
                    async: false,
                    data:{
                        agent_id:$('input[name="agent_id"]').val(),
                        reference:$('input[name="reference"]').val()
                    },
                    success:function(results){
                        if(results.id){
                            valid = false;
                            alert('The reference already used please enter another reference!')
                            $('input[name="reference"]').addClass("is-invalid")
                        }
                    }
                    })
                }
                return valid
            }else if(currentIndex == 2 && priorIndex == 3){
                $('#overview_customer_name').html($('input[name="customer_name"]').val());
                $('#overview_email').html($('input[name="customer_email"]').val());
                $('#overview_telephone').html($('input[name="customer_telephone"]').val());
                $('#overview_country').html($('select[name="customer_country"] option:selected').text());
                $('#overview_region').html($('select[name="customer_state"] option:selected').text() + ' - ' + $('select[name="customer_region"] option:selected').text());
                $('#overview_city').html($('select[name="customer_city"] option:selected').text());
                $('#overview_zip_code').html($('input[name="zip_code"]').val());
                $('#overview_building').html($('input[name="customer_building"]').val());
                $('#overview_floor').html($('input[name="customer_floor"]').val());
                $('#overview_directions').html($('input[name="customer_directions"]').val());
                $('#overview_agent').html($('#agent_autocomplete').val());
                $('#overview_ref').html($('input[name="reference"]').val());
                $('#overview_currency').html($('select[name="currency_id"] option:selected').text());
                $('#overview_service_type').html($('select[name="service_type_id"] option:selected').text());
                $('#overview_weight').html($('input[name="weight"]').val());
                $('#overview_amount').html($('input[name="amount"]').val());
                $('#overview_payment_method').html($('select[name="payment_method_id"] option:selected').text());
                $('#overview_customer_comment').html($('input[name="customer_comment"]').val());
                $('#overview_shipper_comment').html($('input[name="agent_comment"]').val());
            }

            return true;
        },
        onStepChanged: function (event, currentIndex, priorIndex) {
            $('.steps .current').prevAll().addClass('disabled');
        },
        onFinished: function (event, currentIndex) {
            $('#form').submit();
        }
    });
</script>
<script type="text/javascript">
    var states_select = $('select[name="customer_state"]');
    var regions_select = $('select[name="customer_region"]');
    var cities_select = $('select[name="customer_city"]');

    $('select[name="customer_state"]').on('change', function() {
        getRegions(this.value)
    });

    $('select[name="customer_region"]').on('change', function() {
        getCities(this.value)
    });

    var state = "";

    '@if(isset($shipment->customer_country))'
        state = "{{ $shipment->customer_state }}"
    '@else'
        state = "{{ old('customer_state','') }}"
    '@endif'

    getStates("{{ $country_code }}")
    
    $('#customer_country').on('change', function() {
        getStates(this.value)
    });

    function getStates(country_code){
        states_select.empty()
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
                getRegions(states_select.val())
                
            }
        })
    }

    var region = "";
    '@if(isset($shipment->customer_region))'
        region = "{{ $shipment->customer_region }}"
    '@else'
        region = "{{ old('customer_region','') }}"
    '@endif'
    function getRegions(state){
        regions_select.empty()

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
                getCities(regions_select.val())
                
            }
        })
    }

    var city = "";
    '@if(isset($shipment->customer_city))'
        city = "{{ $shipment->customer_city }}"
    '@else'
        city = "{{ old('customer_city','') }}"
    '@endif'

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

                
            }
        })
    }


</script>
<script src="{{ asset('/vendors/scripts/bootstrap3-typeahead.min.js') }}"></script>

<script type="text/javascript">
    var ids = new Object();
     $('#agent_autocomplete').typeahead({
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
