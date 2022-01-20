@extends('index')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="row clearfix progress-box">
        @foreach ($statuses as $status)
        <a href="{{ route('shipments',['filter_status_group'=>$status->id]) }}" class="col-lg-3 col-md-6 col-sm-12 mb-30">
            <div class="bg-white pd-20 box-shadow border-radius-5 height-100-p">
                <div class="project-info clearfix">
                    <div class="project-info-left">
                        <div class="icon box-shadow {{ $status->color }} text-white">
                            <i class="icon-copy fa fa-truck" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="project-info-right">
                        <span class="no text-blue weight-500 font-24">{{ $status->count_shipments }}</span>
                        <p class="weight-400 font-18">{{ $status->status_group_name }}</p>
                    </div>
                </div>
             
            </div>
        </a>
        @endforeach
        <hr>
        
        <!--<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
            <div class="bg-white pd-20 box-shadow border-radius-5 height-100-p">
                <div class="project-info clearfix">
                    <div class="project-info-left">
                        <div class="icon box-shadow bg-blue text-white">
                            <i class="fa fa-briefcase"></i>
                        </div>
                    </div>
                    <div class="project-info-right">
                        <span class="no text-blue weight-500 font-24">40</span>
                        <p class="weight-400 font-18">New</p>
                    </div>
                </div>
             
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
            <div class="bg-white pd-20 box-shadow border-radius-5 height-100-p">
                <div class="project-info clearfix">
                    <div class="project-info-left">
                        <div class="icon box-shadow bg-light-green text-white">
                            <i class="fa fa-handshake-o"></i>
                        </div>
                    </div>
                    <div class="project-info-right">
                        <span class="no text-light-green weight-500 font-24">50</span>
                        <p class="weight-400 font-18">Live</p>
                    </div>
                </div>
               
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
            <div class="bg-white pd-20 box-shadow border-radius-5 height-100-p">
                <div class="project-info clearfix">
                    <div class="project-info-left">
                        <div class="icon box-shadow bg-light-orange text-white">
                            <i class="fa fa-list-alt"></i>
                        </div>
                    </div>
                    <div class="project-info-right">
                        <span class="no text-light-orange weight-500 font-24">2 Lakhs</span>
                        <p class="weight-400 font-18">Cancelled</p>
                    </div>
                </div>
            
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
            <div class="bg-white pd-20 box-shadow border-radius-5 margin-5 height-100-p">
                <div class="project-info clearfix">
                    <div class="project-info-left">
                        <div class="icon box-shadow bg-light-purple text-white">
                            <i class="fa fa-podcast"></i>
                        </div>
                    </div>
                    <div class="project-info-right">
                        <span class="no text-light-purple weight-500 font-24">5.1 Lakhs</span>
                        <p class="weight-400 font-18">Completed</p>
                    </div>
                </div>
           
            </div>
        </div>-->
    </div>
    <hr>
    <div class="row clearfix progress-box">
        <div class="col-md-6">
            <label for="shipments_chart_date">Shipments Date</label>
            <input type="text" class="form-control mb-4" id="shipments_chart_date">
        </div>
        <div class="col-md-6">
        </div>
        <div class="col-md-6">
            
           
            

            <figure class="highcharts-figure">
                <div id="shipments_chart"></div>
         
            </figure>
        </div>
        <div class="col-md-6">
            <figure class="highcharts-figure">
                <div id="shipments_by_region_chart"></div>
                
            </figure>
        </div>
    </div>



</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">

    var start = moment("2010-01-01","YYYY-MM-DD");
    var end = moment();

    function cb(start, end) {

        getShipmentsChart(start.format('YYYY-MM-DD HH:mm:ss'),end.format('YYYY-MM-DD HH:mm:ss'))
    }

    
    $('#shipments_chart_date').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'All time': [moment("2010-01-01","YYYY-MM-DD").format("YYYY-MM-DD"), moment()],
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        },
        locale:{
            format: 'YYYY-MM-DD HH:mm',
            cancelLabel: 'Clear'
        }
    }, cb); cb(start, end);
    // Create the chart
    $('#shipments_chart_date').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm:ss'));
    });
   

    function getShipmentsChart(start,end){
        $.ajax({
            url:"{{ route('shipments_chart') }}?filter_date="+start + ' - ' + end,
            type:'GET',
            success:function(json_results){
                Highcharts.chart('shipments_chart', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Shipments by months'
                    },
                    subtitle: {
                        text: ''
                    },
                    accessibility: {
                        announceNewData: {
                            enabled: true
                        }
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            text: 'Count of shipments for every month'
                        }

                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '{point.y:.1f}'
                            }
                        }
                    },

                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
                    },

                    series: [
                        json_results
                    ],
                    drilldown: {
                        breadcrumbs: {
                            position: {
                                align: 'right'
                            }
                        },
                        series: [
                            {
                                name: "Chrome",
                                id: "Chrome",
                                data: [
                                    [
                                        "v65.0",
                                        0.1
                                    ],
                                    [
                                        "v64.0",
                                        1.3
                                    ],
                                    [
                                        "v63.0",
                                        53.02
                                    ],
                                    [
                                        "v62.0",
                                        1.4
                                    ],
                                    [
                                        "v61.0",
                                        0.88
                                    ],
                                    [
                                        "v60.0",
                                        0.56
                                    ],
                                    [
                                        "v59.0",
                                        0.45
                                    ],
                                    [
                                        "v58.0",
                                        0.49
                                    ],
                                    [
                                        "v57.0",
                                        0.32
                                    ],
                                    [
                                        "v56.0",
                                        0.29
                                    ],
                                    [
                                        "v55.0",
                                        0.79
                                    ],
                                    [
                                        "v54.0",
                                        0.18
                                    ],
                                    [
                                        "v51.0",
                                        0.13
                                    ],
                                    [
                                        "v49.0",
                                        2.16
                                    ],
                                    [
                                        "v48.0",
                                        0.13
                                    ],
                                    [
                                        "v47.0",
                                        0.11
                                    ],
                                    [
                                        "v43.0",
                                        0.17
                                    ],
                                    [
                                        "v29.0",
                                        0.26
                                    ]
                                ]
                            },
                            {
                                name: "Firefox",
                                id: "Firefox",
                                data: [
                                    [
                                        "v58.0",
                                        1.02
                                    ],
                                    [
                                        "v57.0",
                                        7.36
                                    ],
                                    [
                                        "v56.0",
                                        0.35
                                    ],
                                    [
                                        "v55.0",
                                        0.11
                                    ],
                                    [
                                        "v54.0",
                                        0.1
                                    ],
                                    [
                                        "v52.0",
                                        0.95
                                    ],
                                    [
                                        "v51.0",
                                        0.15
                                    ],
                                    [
                                        "v50.0",
                                        0.1
                                    ],
                                    [
                                        "v48.0",
                                        0.31
                                    ],
                                    [
                                        "v47.0",
                                        0.12
                                    ]
                                ]
                            },
                            {
                                name: "Internet Explorer",
                                id: "Internet Explorer",
                                data: [
                                    [
                                        "v11.0",
                                        6.2
                                    ],
                                    [
                                        "v10.0",
                                        0.29
                                    ],
                                    [
                                        "v9.0",
                                        0.27
                                    ],
                                    [
                                        "v8.0",
                                        0.47
                                    ]
                                ]
                            },
                            {
                                name: "Safari",
                                id: "Safari",
                                data: [
                                    [
                                        "v11.0",
                                        3.39
                                    ],
                                    [
                                        "v10.1",
                                        0.96
                                    ],
                                    [
                                        "v10.0",
                                        0.36
                                    ],
                                    [
                                        "v9.1",
                                        0.54
                                    ],
                                    [
                                        "v9.0",
                                        0.13
                                    ],
                                    [
                                        "v5.1",
                                        0.2
                                    ]
                                ]
                            },
                            {
                                name: "Edge",
                                id: "Edge",
                                data: [
                                    [
                                        "v16",
                                        2.6
                                    ],
                                    [
                                        "v15",
                                        0.92
                                    ],
                                    [
                                        "v14",
                                        0.4
                                    ],
                                    [
                                        "v13",
                                        0.1
                                    ]
                                ]
                            },
                            {
                                name: "Opera",
                                id: "Opera",
                                data: [
                                    [
                                        "v50.0",
                                        0.96
                                    ],
                                    [
                                        "v49.0",
                                        0.82
                                    ],
                                    [
                                        "v12.1",
                                        0.14
                                    ]
                                ]
                            }
                        ]
                    }
                });
            }
        })

        $.ajax({
            url:"{{ route('shipments_by_region_chart') }}?filter_date="+start + ' - ' + end,
            type:'GET',
            success:function(json_data){
                // Make monochrome colors
                var pieColors = (function () {
                    var colors = [],
                        base = Highcharts.getOptions().colors[0],
                        i;

                    for (i = 0; i < 10; i += 1) {
                        // Start out with a darkened base color (negative brighten), and end
                        // up with a much brighter color
                        colors.push(Highcharts.color(base).brighten((i - 3) / 7).get());
                    }
                    return colors;
                }());

                // Build the chart
                Highcharts.chart('shipments_by_region_chart', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Shipments by regions'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b> {point.y} Shipments</b>'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            colors: pieColors,
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                                distance: -50,
                                filter: {
                                    property: 'percentage',
                                    operator: '>',
                                    value: 4
                                }
                            }
                        }
                    },
                    series: [json_data]
                });
            }
        })
    }
</script>
@endsection
