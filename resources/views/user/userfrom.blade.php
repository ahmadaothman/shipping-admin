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
                            <li class="breadcrumb-item active" aria-current="page">User</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <button type="submit" class="btn btn-primary " onclick="event.preventDefault();
                    document.getElementById('user-form').submit();"><i class="icon-copy fi-save"></i> Save</button>
                    <a type="submit" class="btn btn-secondary text-white" ><i class="icon-copy fi-x"></i> Cancel</a>

                </div>
            </div>
        </div>
       
        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <div class="clearfix mb-20">
                <div class="pull-left">
                    <h5 class="text-blue">User Information</h5>
                </div>
            </div>
            <div class="container">
               
                <form id="user-form" action="{{ $action }}" method="POST" >
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Name</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="name" type="text" placeholder="User Name" value="{{ isset($user->name) ? $user->name :  old('name') }}">
                           
                            @error('name')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Email</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="email" placeholder="User Email" type="email" value="{{ isset($user->email) ? $user->email :  old('email') }}">
                            @error('email')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                       
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Password</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="password" placeholder="Password" type="password" value="{{ isset($user->password) ? $user->password :  old('password') }}">
                            @error('password')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Telephone</label>
                        <div class="col-sm-12 col-md-10">
                         
                            <input class="form-control" id="telephone" name="telephone" placeholder="1-(111)-111-1111" type="tel" value="{{ isset($user->telephone) ? $user->telephone :  old('telephone') }}">
                            
                            @error('telephone')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
          
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Branch</label>
                        <div class="col-sm-12 col-md-10">
                            
                            <select class="form-control selectpicker" name="branch" data-live-search="true" >
                                @foreach ($branches as $branch)
                                    @if (isset($user->branch_id) && $branch['id'] == $user->branch_id)
                                        <option value="{{ $branch['id'] }}" selected="selected">{{ $branch['name'] }}</option>
                                    @else
                                        <option value="{{ $branch['id'] }}">{{ $branch['name'] }}</option>
                                    @endif
                                @endforeach                              
                            </select>
                        </div>
                    </div>
                  
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Status</label>
                        <div class="col-sm-12 col-md-10">
                            <div class="d-none">
                                {{ isset($user->status) ? $status = $user->status :  $status = old('status',1) }}
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

             
                  
                </form>
							
            </div>
        </div>
        <!-- Export Datatable End -->
    </div>
</div>

@endsection
