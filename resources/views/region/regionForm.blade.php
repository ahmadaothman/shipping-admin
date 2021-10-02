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
                            <li class="breadcrumb-item active" aria-current="page">Region</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <button type="submit" class="btn btn-primary " onclick="event.preventDefault();
                    document.getElementById('region-form').submit();"><i class="icon-copy fi-save"></i> Save</button>
                    <a type="submit" class="btn btn-secondary text-white" ><i class="icon-copy fi-x"></i> Cancel</a>

                </div>
            </div>
        </div>
       
        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <div class="clearfix mb-20">
                <div class="pull-left">
                    <h5 class="text-blue">Region Information</h5>
                </div>
            </div>
            <div class="container">
               
                <form id="region-form" action="{{ $action }}" method="POST" >
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Name</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="name" type="text" placeholder="Region Name" value="{{ isset($region->name) ? $region->name :  old('name') }}">
                           
                            @error('name')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    
                    </div>
                   
               
                    

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Country</label>
                        <div class="col-sm-12 col-md-10">
                            <div class="d-none">
                                {{ isset($region->country) ? $country = $region->country :  $country = old('country', $country_code ) }}
                                
                            </div>
                            <select class="form-control selectpicker" name="country" id="country" data-live-search="true">
                                @foreach ($countries as $key => $value)
                                @if ((isset($value['name_en']) && !empty($value['name_en'])) && (isset($value['cca2']) && !empty($value['cca2'])))
                                    @if ($value['cca2'] == $country)
                                        <option value="{{ $value['cca2'] }}" selected="selected">{{ $value['name_en'] }}</option>
                                    @else
                                        <option value="{{ $value['cca2'] }}">{{ $value['name_en'] }}</option>
                                    @endif
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">State</label>
                        <div class="col-sm-12 col-md-10">
                  
                            <select name="state" class="form-control">
                            </select>
                        </div>
                    
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Shipping Cost</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="shipping_cost" type="number" placeholder="Shipping Cost" value="{{ isset($region->shipping_cost) ? $region->shipping_cost :  old('shipping_cost') }}">
                           
                            @error('shipping_cost')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    
                    </div>
           
                </form>
							
            </div>
        </div>
        <!-- Export Datatable End -->
    </div>
</div>
<script type="text/javascript">
     var states_select = $('select[name="state"]')

    '@if(isset($region->state))'
        state = "{{ $region->state }}"
    '@else'
        state = "{{ old('state','') }}"
    '@endif'

  
    getStates("{{ $country_code }}")

    $('#country').on('change', function() {
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
              
                    
                    states_select.append(new Option(v.extra.woe_name, v.extra.woe_name))

                    if(state == v.extra.woe_name){
                        
                        states_select.val(v.extra.woe_name)
                    }
                })

                
            }
        })
    }

</script>
@endsection
