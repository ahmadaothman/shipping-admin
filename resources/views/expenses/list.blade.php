@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4><i class="icon-copy fa fa-money" aria-hidden="true"></i> Expenses</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Expenses</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a type="button" class="btn btn-primary " href="expenses/add"><i class="icon-copy fi-plus"></i> Add Expense</a>
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
        
        <form id="from" action="{{ route('removeExpenses') }}" method="POST" class="pd-20 bg-white border-radius-4 box-shadow mb-30">
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

                        <div class="form-group form-group-sm col-md-2">
                            <small><label for="filter_type">Type</label></small>

                            <div class="d-none">{{ $filter_type = app('request')->input('filter_type')}}</div>

                            <select class="form-control form-control-sm h-50 selectpicker" id="filter_type" >
                                <option value="-1">--none--</option>

                                @foreach ($expenses_types as $type)
                                    <option value="{{ $type['id'] }}" {{ $filter_type == $type['id'] ? 'selected' : '' }}>{{ $type['name'] }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group form-group-sm col-md-2">
                            <small><label for="filter_currency">Currency</label></small>
                            <div class="d-none">{{ $filter_currency = app('request')->input('filter_currency')}}</div>
                            <select class="form-control form-control-sm h-50 selectpicker" id="filter_currency" >
                                <option value="-1">--none--</option>
                                <option value="lbp" {{ $filter_currency == 'lbp' ? 'selected' : '' }}>LBP</option>
                                <option value="usd" {{ $filter_currency == 'usd' ? 'selected' : '' }}>USD</option>
                            </select>
                        </div>

                        <div class="form-group form-group-sm col-md-4">
                            <small><label for="filter_reference">Reference</label></small>
                            <input type="text" class="form-control form-control-sm h-50" id="filter_reference"  autocomplete="off" placeholder="Reference" value="{{ app('request')->input('filter_reference')}}">
                        </div>

                        <div class="form-group form-group-sm col-md-4">
                            <small><label for="filter_date">Date</label></small>
                            <input type="text" class="form-control form-control-sm h-50" id="filter_date"  autocomplete="off" placeholder="Date">
                        </div>
                        
                        
                        
                    </div>
                    <div class="w-100 text-right ">
                        <button  type="button" id="btn_filter" class="btn btn-info btn-sm"> 
                            <i class="icon-copy fa fa-filter" aria-hidden="true"></i> Filters
                        </button>
                        <button  type="button" id="btn_clear_filter" class="btn btn-danger btn-sm" onclick="location.href = '{{ route('expenses') }}'"> 
                            <i class="icon-copy fa fa-filter" aria-hidden="true"></i> Clear Filter
                        </button>
                    </div>
                </div>
            </div>
           @csrf
            <div class="row">
                <table class="table table-striped  table-hover table-bordered  data-table-export table-xs">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort"><input id="select-all" type="checkbox"/></th>
                            <th class="table-plus datatable-nosort">ID</th>
                            <th class="table-plus datatable-nosort">Type</th>
                            <th class="table-plus datatable-nosort text-center">Description</th>
                            <th class="table-plus datatable-nosort">Reference</th>
                            <th class="table-plus datatable-nosort">Amount</th>
                            <th class="table-plus datatable-nosort">Currency</th>
                            <th class="table-plus datatable-nosort">Rate</th>
                            <th class="table-plus datatable-nosort">VAT</th>
                            <th class="table-plus datatable-nosort">Note</th>
                            <th class="table-plus datatable-nosort">Date</th>
                            <th class="table-plus datatable-nosort">User</th>
                            <th class="table-plus datatable-nosort">Created At</th>
                            <th class="table-plus datatable-nosort">Modified At</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses->items() as $expense)
                            <tr>
                                <td class="text-center align-middle">
                                    @if ($expense['id'] != 1)
                                    <input type="checkbox" name="selected[]" value="{{ $expense['id'] }}" />
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    {{ $expense['id'] }}
                                </td>
                                <td class="align-middle">
                                    {{ $expenses_types[$expense['type']]['name'] }}
                                </td>
                          
                                <td class="align-middle">
                                    {{ $expense['description'] }}
                                </td>

                                <td class="align-middle">
                                    {{ $expense['reference'] }}
                                </td>

                                <td class="align-middle">
                                    {{ $expense['amount'] }}
                                </td>

                                <td class="align-middle">
                                    {{ $expense['currency'] }}
                                </td>

                                <td class="align-middle">
                                    {{ $expense['currency_rate'] }}
                                </td>

                                <td class="align-middle">
                                    {{ $expense['vat'] }}
                                </td>

                                <td class="align-middle">
                                    {{ $expense['note'] }}
                                </td>

                                <td class="align-middle">
                                    {{ $expense['expense_date'] }}
                                </td>
                              
                                <td class="align-middle">
                                    {{ $expense['user_id'] }}
                                </td>

                                <td class="align-middle">
                                    {{ $expense['created_at'] }}
                                </td>
                                <td class="align-middle">
                                    {{ $expense['updated_at'] }}
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('editExpense',['id' => $expense['id']]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="icon-copy fa fa-edit" aria-hidden="true"></i> Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                 
                </table>
                <div class="w-100" >
                   
                    {{ $expenses->appends($_GET)->links('vendor.pagination.default') }}
                    <div class="float-right h-100" style="padding-top: 25px">
                        <strong>
                            Showing {{ $expenses->count() }} From {{ $expenses->total() }} Expenses
                        </strong>
                    </div>

                </div>
            </div>
        </form>
        <!-- Export Datatable End -->
    </div>
</div>
<script type="text/javascript" src="{{ asset('/src/plugins/daterangpicker/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/src/plugins/daterangpicker/js/daterangepicker.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('/src/plugins/daterangpicker/css/daterangepicker.css') }}" />
<script type="text/javascript">
    var start = moment("2010-01-01","YYYY-MM-DD").format("YYYY-MM-DD");
    var end = moment();
    
    var filter_date = "{{ app('request')->input('filter_date') }}";
    
    if(filter_date != "") {

        var dates = filter_date.split(" - ");

        start = moment(dates[0],"YYYY-MM-DD HH:mm").format("YYYY-MM-DD HH:mm");
        end = moment(dates[1],"YYYY-MM-DD HH:mm").format("YYYY-MM-DD HH:mm");

    }
        
    $('#filter_date').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'All time': [moment("2010-01-01","YYYY-MM-DD").format("YYYY-MM-DD"), moment()],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        locale:{
            format: 'YYYY-MM-DD HH:mm',
            cancelLabel: 'Clear'
        }
	});

    $('#filter_date').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm:ss'));
    });

    $('#filter_date').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

</script>

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
        text: "Your will not be able to recover deleted expenses!",
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
    if($('#filter_type').val() != '-1' ){
        url += '&filter_type=' + $('#filter_type').val();
    }

    if($('#filter_reference').val() != '' ){
        url += '&filter_reference=' + $('#filter_reference').val();
    }

    if($('#filter_currency').val() != '-1' ){
        url += '&filter_currency=' + $('#filter_currency').val();
    }

    if($('#filter_date').val() != '' ){
        url += '&filter_date=' + encodeURIComponent($('#filter_date').val());
    }

    location.href = "{{ route('expenses',) }}/?" + url
}

$('input').on('keyup', function (e) {
    if (e.key === 'Enter' || e.keyCode === 13) {
        filter()
    }
});
</script>
@endsection
