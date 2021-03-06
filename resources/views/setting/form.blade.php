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
                <input name="max_weight" type="number" class="form-control" placeholder="Max Weight" value="{{ $max_weight }}"/>
            </div>
            
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <label>Fees per extra weight</label>
            </div>
           
            <div class="col-md-9">
                <input name="fees_per_extra_weight" type="number" class="form-control" placeholder="Extra Weight Fees" value="{{ $extra_weight_fees }}"/>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <label>Pickup from shipper cost</label>
            </div>
           
            <div class="col-md-9">
                <input name="pickup_from_shipper_cost" type="number" class="form-control" placeholder="Pickup from shipper cost"  value="{{ $pickup_from_customer_cost }}"/>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <label>SMS Text</label>
            </div>
           
            <div class="col-md-9">
                <input name="message_text" type="text" class="form-control" placeholder="SMS Text"  value="{{ $message_text }}"/>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <label>Email Text</label>
            </div>
           
            <div class="col-md-9">
                <textarea name="email_text" id="email_text"  class="form-control" placeholder="Email Text"  >{{ $email_text }}</textarea>
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
<script src="//cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
<script type="text/javascript">
        CKEDITOR.replace('email_text');
</script>
@endsection
