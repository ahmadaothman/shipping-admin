@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4><i class="fa fa-usd" aria-hidden="true"></i> Revenue Report</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Revenue Report</li>
                        </ol>
                    </nav>
                </div>
             
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group form-group-sm">
                        <small><label for="filter_date">Date</label></small>
                        <input type="text" class="form-control form-control-sm h-50" id="filter_date"  autocomplete="off" placeholder="Date">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group form-group-sm ">
                        <small><label for="filter_invoice_status">Invoice Status</label></small>
                        <div class="d-none">{{ $filter_invoice_status = app('request')->input('filter_invoice_status')}}</div>
                        <select class="form-control form-control-sm h-50 selectpicker" id="filter_invoice_status" >
                            <option value="-1">--none--</option>
                            <option value="1" {{ $filter_invoice_status == '1' ? 'selected' : '' }}>Unpaid</option>
                            <option value="2" {{ $filter_invoice_status == '2' ? 'selected' : '' }}>Paid</option>
                            <option value="3" {{ $filter_invoice_status == '3' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4 text-right">
                 
                    <button  type="button" id="btn_filter" class="btn btn-info btn-sm"> 
                        <i class="icon-copy fa fa-filter" aria-hidden="true"></i> Filters
                    </button>
                    <button  type="button" id="btn_clear_filter" class="btn btn-danger btn-sm" onclick="location.href = '{{ route('revenue_report') }}'"> 
                        <i class="icon-copy fa fa-filter" aria-hidden="true"></i> Clear Filter
                    </button>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-sm-4 text-center p-2">
                    <div class="w-100 bg-white pt-4">
                        <h5>Total Shipping Cost</h5>

                        <h4 class="text-success m-4 pb-4">{{ $shipping_cost }} L.L</h4>
                    </div>
                </div>
                <div class="col-sm-4 text-center p-2">
                    <div class="w-100 bg-white pt-4">
                        <h5>Total Weight Fees</h5>
                        <h4 class="text-success m-4 pb-4">{{ $weight_fees }} L.L</h4>
                    </div>
                </div>
                <div class="col-sm-4 text-center p-2">
                    <div class="w-100 bg-white pt-4">
                        <h5>Total Service Fees</h5>
                        <h4 class="text-success m-4 pb-4">{{ $service_fees }} L.L</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 text-center p-2">
                    <div class="w-100 bg-white pt-4">
                        <h5>Total LBP Expenses</h5>
                        <h4 class="text-danger m-4 pb-4">{{ $sum_lbp_expenses }} L.L</h4>
                    </div>
                </div>
                <div class="col-sm-6 text-center p-2">
                    <div class="w-100 bg-white pt-4">
                        <h5>Total USD Expenses</h5>
                        <h4 class="text-danger m-4 pb-4">{{ $sum_usd_expenses }} $</h4>
                    </div>
                </div>
            </div>
        </div>
       
  
    
        
     

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



$('#btn_filter').on('click',function(){
    filter()
})

function filter(){
    var url = '';
    if($('#filter_invoice_status').val() != '-1' ){
        url += '&filter_invoice_status=' + $('#filter_invoice_status').val();
    }

    if($('#filter_date').val() != '' ){
        url += '&filter_date=' + encodeURIComponent($('#filter_date').val());
    }

    location.href = "{{ route('revenue_report',) }}/?" + url
}


</script>
@endsection
