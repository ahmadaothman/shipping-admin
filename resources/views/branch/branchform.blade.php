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
                            <li class="breadcrumb-item active" aria-current="page">Branch</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <button type="submit" class="btn btn-primary " onclick="event.preventDefault();
                    document.getElementById('branch-form').submit();"><i class="icon-copy fi-save"></i> Save</button>
                    <a type="submit" class="btn btn-secondary text-white" ><i class="icon-copy fi-x"></i> Cancel</a>

                </div>
            </div>
        </div>
       
        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <div class="clearfix mb-20">
                <div class="pull-left">
                    <h5 class="text-blue">Branch Information</h5>
                </div>
            </div>
            <div class="container">
               
                <form id="branch-form" action="{{ $action }}" method="POST" >
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Name</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="name" type="text" placeholder="Branch Name" value="{{ isset($branch->name) ? $branch->name :  old('name') }}">
                           
                            @error('name')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    
                    </div>
                   
               
                    

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Country</label>
                        <div class="col-sm-12 col-md-10">
                            <div class="d-none">
                                {{ isset($branch->country) ? $country = $branch->country :  $country = old('country', $country_code ) }}
                                
                            </div>
                            <select class="form-control selectpicker" name="country" data-live-search="true">
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
                        <label class="col-sm-12 col-md-2 col-form-label">City</label>
                        <div class="col-sm-12 col-md-10">
                         
                            <input class="form-control" id="city" name="city" placeholder="City" type="tel" value="{{ isset($branch->city) ? $branch->city :  old('city') }}">
                            
                            @error('city')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Address</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="address" type="text" placeholder="State, City, Street, Building, Floor...etc" value="{{ isset($branch->address) ? $branch->address :  old('address') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Telephone</label>
                        <div class="col-sm-12 col-md-10">
                         
                            <input class="form-control" id="telephone" name="telephone" placeholder="1-(111)-111-1111" type="tel" value="{{ isset($branch->telephone) ? $branch->telephone :  old('telephone') }}">
                            
                            @error('telephone')
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

@endsection
