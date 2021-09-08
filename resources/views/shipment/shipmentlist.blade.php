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
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
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
            </div>
            <div class="row">
                
            </div>
            <form id="form" method="POST" enctype="multipart/form-data">
                <table class="table table-sm table-hover table-hover table-striped">
                    <thead>
                        <tr>
                            <th><input id="select-all" type="checkbox"/></th>
                            <th class="text-center"><small><strong>ID</small></strong></th>
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
                                    <strong><small>{{ $shipment->created_at }}</small></strong>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="text-white text-center p-1  rounded {{ $shipment->Status->StatusGroup->color }}">
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
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
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
@endsection
