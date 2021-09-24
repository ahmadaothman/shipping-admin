@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4><i class="icon-copy fa fa-group" aria-hidden="true"></i> {{ $user_type }}</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $user_type }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a type="button" class="btn btn-primary " href="/users/add?user_type_id={{ app('request')->input('user_type_id') }}"><i class="icon-copy fi-plus"></i> Add {{ $user_type }}</a>
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
        
        <form id="from" action="{{ route('removeUsers') }}" method="POST" class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <p class="text-right">
                <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <i class="icon-copy fa fa-filter" aria-hidden="true"></i> Filters
                </a>
            
            </p>

            @if (app('request')->input('filter_name') || app('request')->input('filter_telephone') || app('request')->input('filter_email') || app('request')->input('filter_status') || app('request')->input('filter_status') == "0")
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
                        <!--Filter Telephone -->
                        <div class="col-sm-3">
                            <label for="filter_telephone">Filter Telephone:</label>
                            <input type="text" id="filter_telephone" class="form-control form-control-sm" placeholder="Filter Telephone" value="{{ app('request')->input('filter_telephone') }}"/>
                        </div>
                         <!--Filter Email -->
                         <div class="col-sm-3">
                            <label for="filter_email">Filter Email:</label>
                            <input type="text" id="filter_email" class="form-control form-control-sm" placeholder="Filter Email" value="{{ app('request')->input('filter_email') }}"/>
                        </div>
                        <!--Filter Branches -->
                        <div class="col-sm-3">
                        <label for="filter_status">Filter Branch:</label>
                        <select type="text" id="filter_branch" class="form-control form-control-xs selectpicker" data-live-search="true" >
                            <option value="-1">--none--</option>
                                @foreach ($branches as $branch)
                                    @if ($branch['id']  == app('request')->input('filter_branch'))
                                        <option value="{{ $branch['id'] }}" selected="selected">{{ $branch['name'] }}</option>
                                    @else
                                        <option value="{{ $branch['id'] }}" >{{ $branch['name'] }}</option>
                                    @endif
                                @endforeach
                            @foreach ($branches as $branch)
                                
                            @endforeach
                        </select>
                        </div>
                         <!--Filter Status -->
                         <div class="col-sm-3">
                            <label for="filter_status">Filter Status:</label>
                            <select type="text" id="filter_status" class="form-control form-control-xs" >
                                <option value="-1">--none--</option>
                                <option value="1" @if(app('request')->input('filter_status') == 1) selected="selected" @endif>Enabled</option>
                                <option value="0" @if(app('request')->input('filter_status') != '' &&  app('request')->input('filter_status') == '0') selected="selected" @endif>Disabled</option>
                            </select>
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
                <table class="table table-striped  table-hover  data-table-export table-xs ">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort"><input id="select-all" type="checkbox"/></th>
                            <th class="table-plus datatable-nosort">ID</th>
                            <th class="table-plus datatable-nosort">Name</th>
                            <th class="table-plus datatable-nosort">Telephone</th>
                            <th class="table-plus datatable-nosort">Email</th>
                            <th class="table-plus datatable-nosort">Branch</th>
                            <th class="table-plus datatable-nosort">Status</th>
                            <th class="table-plus datatable-nosort">Created At</th>
                            <th class="table-plus datatable-nosort">Modified At</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users->items() as $user)
                            <tr>
                                <td class="text-center align-middle">
                                    <input type="checkbox" name="selected[]" value="{{ $user['id'] }}" />
                                </td>
                                <td class="text-center align-middle">
                                    {{ $user['id'] }}
                                </td>
                                <td class="align-middle">
                                    {{ $user['name'] }}
                                </td>
                                <td class="align-middle">
                                    {{ $user['telephone'] }}
                                </td>
                                <td class="align-middle">
                                    {{ $user['email'] }}
                                </td>
                                <td class="align-middle">
                                    {{ $user['branch'] }}
                                </td>
                                <td class="align-middle">
                                    @if ($user['status'] == 1)
                                        <span class="bg-success color-white p-1 rounded">Enabled</span>
                                    @else
                                        <span class="bg-danger color-white p-1 rounded">Disabled</span>
                                    @endif
                                    
                                </td>
                          
                                <td class="align-middle">
                                    {{ $user['created_at'] }}
                                </td>
                                <td class="align-middle">
                                    {{ $user['updated_at'] }}
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('editUser',['id' => $user['id'],'user_type_id'=>app('request')->input('user_type_id')]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="icon-copy fa fa-edit" aria-hidden="true"></i> Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                 
                </table>
                <div class="w-100" >
                   
                    {{ $users->appends($_GET)->links('vendor.pagination.default') }}
                    <div class="float-right h-100" style="padding-top: 25px">
                        <strong>
                            Showing {{ $users->count() }} From {{ $users->total() }} Users
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
        text: "Your will not be able to recover deleted users!",
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
    
    var url = "&user_type_id=" + {{ app('request')->input('user_type_id') }}

    if($('#filter_name').val() != '' ){
        url += '&filter_name=' + $('#filter_name').val();
    }

    if($('#filter_telephone').val() != '' ){
        url += '&filter_telephone=' + $('#filter_telephone').val();
    }

    if($('#filter_email').val() != '' ){
        url += '&filter_email=' + $('#filter_email').val();
    }

    if($('#filter_status').val() != '-1' ){
        url += '&filter_status=' + $('#filter_status').val();
    }

    if($('#filter_branch').val() != '-1' ){
        url += '&filter_branch=' + $('#filter_branch').val();
    }

    location.href = "{{ route('users',) }}/?" + url
}

$('input').on('keyup', function (e) {
    if (e.key === 'Enter' || e.keyCode === 13) {
        filter()
    }
});
</script>
@endsection
