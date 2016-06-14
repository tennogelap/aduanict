@extends('layouts.app')

@section('filter')
    <div class="container">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Saringan (Filter)</strong></h3>
            </div>
            <div class="panel-body">
                {!! Form::open(array('route' => 'reports.monthly_statistic_aduan_ict', 'method'=>'GET')) !!}
                <div class="row">
                    <div class="col-md-3">
                        <label class="control-label">Kategori:</label>
                            {!! Form::select('complain_category_id',$complain_categories,Request::get('complain_category_id'),['class'=> 'form-control chosen','id'=>'complain_category_id'])!!}
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">Cawangan:</label>
                        {!! Form::select('branch_id',$branches,Request::get('branch_id'),['class'=> 'form-control chosen','id'=>'branch_id'])!!}
                    </div>
                    <div class="col-md-2">
                        <label class="control-label">Tarikh Mula:</label>
                        {!! Form::text('start_date',Request::get('start_date'),array('class'=>'form-control datepicker','placeholder'=>'Tarikh Mula')) !!}
                    </div>
                    <div class="col-md-2">
                        <label class="control-label">Tarikh Akhir:</label>
                        {!! Form::text('end_date',Request::get('end_date'),array('class'=>'form-control datepicker','placeholder'=>'Tarikh Akhir')) !!}
                    </div>
                    <div class="col-md-1">
                        <label class="control-label"> </label>
                        <button type="submit" class="btn btn-primary">Filter Rekod</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="col-sm-5">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Laporan Statistik Aduan ICT</strong></h3>
        </div>
        <div class="panel-body">

            <canvas id="monthly_statistic_aduan_ict" width="100" height="100"></canvas>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script>
        var ctx = document.getElementById("monthly_statistic_aduan_ict");

        var chartdata = {
            labels: {!! $month_name !!},
            datasets: [
                {
                    label: "Data Aduan",
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(200, 100, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(100, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(100, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(222, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                    hoverBackgroundColor: "rgba(255,99,132,0.4)",
                    hoverBorderColor: "rgba(255,99,132,1)",
                    data: {{ $monthly_total  }},
                }
            ]
        };

        var monthly_statistic_aduan_ict = new Chart(ctx, {
            type: 'bar',
            data: chartdata ,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                },
                title: {
                    display: true,
                    {{--text: 'Statistik Aduan ICT dari {{ $start_date->format('d/m/Y') }} hingga {{ $end_date->format('d/m/Y')}}'--}}
                    text: 'Statistik Aduan ICT dari {{ $start_date }} hingga {{ $end_date }}'
                }
            }
        });
    </script>
@endsection