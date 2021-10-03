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
                            <li class="breadcrumb-item active" aria-current="page">Setting</li>
                        </ol>
                    </nav>
                </div>
                
            </div>
        </div>
    </div>
    <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <label>Max Weight</label>
            </div>
            <div class="col-md-9">
                <input type="number" class="form-control" placeholder="Max Weight" value="{{ $max_weight }}"/>
            </div>
            
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <label>Fees per extra weight</label>
            </div>
           
            <div class="col-md-9">
                <input type="number" class="form-control" placeholder="Extra Weight Fees" value="{{ $extra_weight_fees }}"/>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <label>Pickup from shipper cost</label>
            </div>
           
            <div class="col-md-9">
                <input type="number" class="form-control" placeholder="Pickup from shipper cost"  value="{{ $pickup_from_customer_cost }}"/>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</div>

@endsection
