@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4><i class="icon-copy fa fa-map-o" aria-hidden="true"></i></i> Regions</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Regions</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a type="button" class="btn btn-primary " href="regions/add"><i class="icon-copy fi-plus"></i> Add Region</a>
                    <button id="sa-warning" type="button" class="btn btn-danger" onclick="remove();"><i class="icon-copy fi-trash"></i> Remove</button>
                </div>
            </div>
        </div>
       
  
        <!-- multiple select row Datatable End -->
        <!-- Export Datatable start -->
        @if(session()->has('status'))
            
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! session()->get('status') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        
        <form id="from" action="{{ route('removeRegions') }}" method="POST" class="pd-20 bg-white border-radius-4 box-shadow mb-30">
          
           @csrf
            <div class="row">
                <table class="table table-striped  table-hover  data-table-export table-xs">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort"><input id="select-all" type="checkbox"/></th>
                            <th class="table-plus datatable-nosort">ID</th>
                            <th class="table-plus datatable-nosort">Name</th>
                            <th class="table-plus datatable-nosort">State</th>
                            <th class="table-plus datatable-nosort">Shipping Cost</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($regions->items() as $region)
                            <tr>
                                <td class="region-center align-middle">
                                    <input type="checkbox" name="selected[]" value="{{ $region['id'] }}" />
                                </td>
                                <td class="text-center align-middle">
                                    {{ $region['id'] }}
                                </td>
                                <td class="align-middle">
                                    {{ $region['name'] }}
                                </td>
                           
                                <td class="align-middle">
                                    {{ $region['state'] }}
                                </td>
                            
                                <td class="align-middle">
                                    {{ $region['shipping_cost'] }}
                                </td>
                              
                              
                                <td class="text-center align-middle">
                                    <a href="{{ route('editRegion',['id' => $region['id']]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="icon-copy fa fa-edit" aria-hidden="true"></i> Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                 
                </table>
                <div class="w-100" >
                   
                    {{ $regions->appends($_GET)->links('vendor.pagination.default') }}
                    <div class="float-right h-100" style="padding-top: 25px">
                        <strong>
                            Showing {{ $regions->count() }} From {{ $regions->total() }} Regions
                        </strong>
                    </div>

                </div>
            </div>
        </form>
        <!-- Export Datatable End -->
    </div>
</div>


<script type="text/javascript">
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


function remove(){
    
    swal({
        title: "Are you sure?",
        text: "Your will not be able to recover deleted regions!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes",
        closeOnConfirm: false
    },
    function(confirn){
        alert('ok')
    }).then(function (isConfirm) {
               if(isConfirm.value){
                document.getElementById('from').submit();
               }
               //success method
            },function(){});
 //   document.getElementById('from').submit();
}

$('#btn_filter').on('click',function(){
    filter()
})


</script>
@endsection
