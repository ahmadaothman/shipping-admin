@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4><i class="icon-copy fa fa-group" aria-hidden="true"></i> Branches</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Branches</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a type="button" class="btn btn-primary " href="branches/add"><i class="icon-copy fi-plus"></i> Add Branch</a>
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
        
        <form id="from" action="{{ route('removeBranches') }}" method="POST" class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <p class="text-right">
                <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <i class="icon-copy fa fa-filter" aria-hidden="true"></i> Filters
                </a>
            
            </p>

            @if (app('request')->input('filter_name') || app('request')->input('filter_telephone') || app('request')->input('filter_city') || app('request')->input('filter_country') || app('request')->input('filter_address') == "0")
                <div class="collapse mb-20 show" id="collapseExample">
            @else
                <div class="collapse mb-20 " id="collapseExample">
            @endif
          
                <div class="card card-body">
                    <div class="row mb-20">
                        <!--Filter Name-->

                        <div class="col-sm-3">
                            <label for="filter_name">Filter Name:</label>
                            <input type="text" id="filter_name" class="form-control form-control-sm" placeholder="Filter Name" value="{{ app('request')->input('filter_name') }}"/>
                        </div>
                         <!--Filter Country -->
                         <div class="col-sm-3">
                            <label for="filter_country">Filter Coutry:</label>
                            <select type="text" id="filter_country" class="form-control form-control-xs selectpicker" data-live-search="true">
                                <option value="-1">--none--</option>
                                @foreach ($countries as $country)
                                    @if ((isset($country['name_en']) && !empty($country['name_en'])) && (isset($country['cca2']) && !empty($country['cca2'])))
                                        @if (app('request')->input('filter_country') == $country['cca2'])
                                            <option value="{{ $country['cca2'] }}" selected="selected">{{ $country['name_en'] }}</option>
                                        @else   
                                            <option value="{{ $country['cca2'] }}" >{{ $country['name_en'] }}</option>>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>
                         <!--Filter City -->
                         <div class="col-sm-3">
                            <label for="filter_city">Filter City:</label>
                            <input type="text" id="filter_city" class="form-control form-control-sm" placeholder="Filter City" value="{{ app('request')->input('filter_city') }}"/>
                        </div>
                         <!--Filter City -->
                         <div class="col-sm-3">
                            <label for="filter_city">Filter Address:</label>
                            <input type="text" id="filter_address" class="form-control form-control-sm" placeholder="Filter Address" value="{{ app('request')->input('filter_address') }}"/>
                        </div>
                        <!--Filter Telephone -->
                        <div class="col-sm-3">
                            <label for="filter_telephone">Filter Telephone:</label>
                            <input type="text" id="filter_telephone" class="form-control form-control-sm" placeholder="Filter Telephone" value="{{ app('request')->input('filter_telephone') }}"/>
                        </div>
                        
                        
                    </div>
                    <div class="w-100 text-right ">
                        <button  type="button" id="btn_filter" class="btn btn-info btn-sm"> 
                            <i class="icon-copy fa fa-filter" aria-hidden="true"></i> Filters
                        </button>
                    </div>
                </div>
            </div>
           @csrf
            <div class="row">
                <table class="table table-striped  table-hover  data-table-export table-xs">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort"><input id="select-all" type="checkbox"/></th>
                            <th class="table-plus datatable-nosort">ID</th>
                            <th class="table-plus datatable-nosort">Name</th>
                            <th class="table-plus datatable-nosort text-center">Country</th>
                            <th class="table-plus datatable-nosort">City</th>
                            <th class="table-plus datatable-nosort">Address</th>
                            <th class="table-plus datatable-nosort">Telephone</th>
                            <th class="table-plus datatable-nosort">Created At</th>
                            <th class="table-plus datatable-nosort">Modified At</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($branches->items() as $branch)
                            <tr>
                                <td class="text-center align-middle">
                                    @if ($branch['id'] != 1)
                                    <input type="checkbox" name="selected[]" value="{{ $branch['id'] }}" />
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    {{ $branch['id'] }}
                                </td>
                                <td class="align-middle">
                                    {{ $branch['name'] }}
                                </td>
                                <td class="align-middle text-center">
                                    {{ $branch->countryFlagImoji }}
                                    <br/>
                                    {{ $branch->countryName }}
                                </td>
                                <td class="align-middle">
                                    {{ $branch['city'] }}
                                </td>
                                <td class="align-middle">
                                    {{ $branch['address'] }}
                                </td>
                                <td class="align-middle">
                                    {{ $branch['telephone'] }}
                                </td>
                              
                                <td class="align-middle">
                                    {{ $branch['created_at'] }}
                                </td>
                                <td class="align-middle">
                                    {{ $branch['updated_at'] }}
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('editBranch',['id' => $branch['id']]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="icon-copy fa fa-edit" aria-hidden="true"></i> Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                 
                </table>
                <div class="w-100" >
                   
                    {{ $branches->appends($_GET)->links('vendor.pagination.default') }}
                    <div class="float-right h-100" style="padding-top: 25px">
                        <strong>
                            Showing {{ $branches->count() }} From {{ $branches->total() }} Branches
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
        text: "Your will not be able to recover deleted branches!",
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

function filter(){
    var url = '';
    if($('#filter_name').val() != '' ){
        url += '&filter_name=' + $('#filter_name').val();
    }

    if($('#filter_telephone').val() != '' ){
        url += '&filter_telephone=' + $('#filter_telephone').val();
    }

    if($('#filter_city').val() != '' ){
        url += '&filter_city=' + $('#filter_city').val();
    }

    if($('#filter_address').val() != '' ){
        url += '&filter_address=' + $('#filter_address').val();
    }

    if($('#filter_country').val() != '-1' ){
        url += '&filter_country=' + $('#filter_country').val();
    }

    location.href = "{{ route('branches',) }}/?" + url
}

$('input').on('keyup', function (e) {
    if (e.key === 'Enter' || e.keyCode === 13) {
        filter()
    }
});
</script>
@endsection
