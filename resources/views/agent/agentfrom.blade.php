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
                            <li class="breadcrumb-item active" aria-current="page">Agent</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <button type="submit" class="btn btn-primary " onclick="event.preventDefault();
                    document.getElementById('agent-form').submit();"><i class="icon-copy fi-save"></i> Save</button>
                    <a type="submit" class="btn btn-secondary text-white" ><i class="icon-copy fi-x"></i> Cancel</a>

                </div>
            </div>
        </div>
       
        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <div class="clearfix mb-20">
                <div class="pull-left">
                    <h5 class="text-blue">Agent Information</h5>
                </div>
            </div>
            <div class="container">
               
                <form id="agent-form" action="{{ $action }}" method="POST" >
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Name</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="name" type="text" placeholder="Agent Name" value="{{ isset($agent->name) ? $agent->name :  old('name') }}">
                           
                            @error('name')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Email</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="email" placeholder="Agent Email" type="email" value="{{ isset($agent->email) ? $agent->email :  old('email') }}">
                            @error('email')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                       
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Password</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="password" placeholder="Password" type="password" value="{{ isset($agent->password) ? $agent->password :  old('password') }}">
                            @error('password')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Telephone</label>
                        <div class="col-sm-12 col-md-10">
                         
                            <input class="form-control" id="telephone" name="telephone" placeholder="1-(111)-111-1111" type="tel" value="{{ isset($agent->telephone) ? $agent->telephone :  old('telephone') }}">
                            
                            @error('telephone')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Website</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="website" placeholder="https://example.com" type="url" value="{{ isset($agent->website) ? $agent->website :  old('website') }}">
                        </div>
                    </div>
                  
                 
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Country</label>
                        <div class="col-sm-12 col-md-10">
                            <div class="d-none">
                                {{ isset($agent->country) ? $country = $agent->country :  $country = old('country', $country_code ) }}
                                
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
                        <label class="col-sm-12 col-md-2 col-form-label">Address</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="address" type="text" placeholder="State, City, Street, Building, Floor...etc" value="{{ isset($agent->address) ? $agent->address :  old('address') }}">
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Status</label>
                        <div class="col-sm-12 col-md-10">
                            <div class="d-none">
                                {{ isset($agent->status) ? $status = $agent->status :  $status = old('status',1) }}
                            </div>
                            <select class="form-control" name="status">
                                @if ($status == 1)
                                    <option value="1" selected="selected">Enabled</option>
                                    <option value="0" >Disabled</option>
                                @else
                                    <option value="1" >Enabled</option>
                                    <option value="0" selected="selected">Disabled</option>
                                @endif
                              
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Sort Order</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="sort_order" type="number" placeholder="Sort Order" value="{{ isset($agent->sort_order) ? $agent->sort_order :  old('sort_order') }}">
                        </div>
                    </div>

                  
                </form>
							
            </div>
        </div>
        <!-- Export Datatable End -->
    </div>
</div>

@endsection
