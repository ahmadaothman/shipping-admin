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
                            <form id="import_excel_form" action="{{ route('importShipmentsExcel') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <a class="dropdown-item" onclick="importExcelFile();"><i class="icon-copy fa fa-file-excel-o" aria-hidden="true"></i> Import Excel File</a>
                                <input type="file" name="excelfile" id="excelfile" class="d-none"  enctype="multipart/form-data" />
                            </form>
                            <a class="dropdown-item" href="#">Policies</a>
                            <a class="dropdown-item" href="#">View Assets</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        

        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <div class="clearfix mb-20">
                <div class="pull-left">
                    <h5 class="text-blue"></h5>
                </div>
            </div>
            <div class="row">
                @if ($file_errors)
                    <div class="alert alert-danger alert-dismissible fade show col-12  " role="alert">
                        <strong>warning!</strong> You have invalid data in your Excel File! please fix issues and upload file again.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @else
                    <div class="col-12 text-right mb-30">
                        <form method="POST" action="{{ route('confirmShipmentExcel') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="file_name" value="{{ $file_name }}"/>
                            <button type="submit" class="btn btn-success"><i class="icon-copy fa fa-check" aria-hidden="true"></i> Confirm Data</button>
                        </form>
                    </div>
                @endif
                <table class="table table-bordered table-responsive table-sm table-striped table-hover">
                    @foreach ($rows as $row)
                        <tr>
                            @foreach ($row as $cell)
                                @if(is_array($cell))
                                    <td class="bg-danger text-white align-middle text-center">
                                        <div class="d-none">
                                            {{ $error_html = "" }}
                                            @foreach ($cell['errors'] as $error)
                                                {{ $error_html = $error_html . "-" . $error . "</br>" }}
                                            @endforeach
                                        </div>

                                        <span class="d-inline-block w-100 h-100"  data-toggle="popover" data-content="{{ $error_html  }}"  data-html="true" data-placement="top">
                                            <div class="w-100 h-100">
                                                @if (empty($cell['value']))
                                                    NULL
                                                @else
                                                    {{ $cell['value'] }}   
                                                @endif
                                            </div>
                                        </span>
                                    </td>
                                @else
                                    <td class="align-middle text-center">{{ $cell }}</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
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

    
</script>
@endsection
