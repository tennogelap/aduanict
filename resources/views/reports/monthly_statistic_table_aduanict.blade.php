@extends('layouts.app')

@section('filter')
    <div class="container">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Saringan (Filter)</strong></h3>
            </div>
            <div class="panel-body">
                {!! Form::open(array('route' => 'reports.monthly_statistic_table_aduanict', 'method'=>'GET', 'id'=>'form1')) !!}
                <div class="row">
                    <div class="col-md-2">
                        <label class="control-label">Tarikh Mula:</label>
                        {!! Form::text('start_date',Request::get('start_date'),array('class'=>'form-control datepicker','placeholder'=>'Tarikh Mula')) !!}
                    </div>
                    <div class="col-md-2">
                        <label class="control-label">Tarikh Akhir:</label>
                        {!! Form::text('end_date',Request::get('end_date'),array('class'=>'form-control datepicker','placeholder'=>'Tarikh Akhir')) !!}
                    </div>
                    <div class="col-md-2">
                        <input type="hidden" name="submit_type" id="submit_type" value="search"/>
                        <label class="control-label"> </label><br>
                        <button type="button" class="btn btn-primary" id="search" name="search">Filter Rekod</button>
                    </div>
                    <div class="col-md-1">
                        <label class="control-label"> </label><br>
                        <button type="button" class="btn btn-default" id="downloadpdf" name="downloadpdf">Download PDF</inputbutton>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Laporan Statistik Aduan Mengikut Kategori</strong></h3>
        </div>
        <div class="panel-body">
        <table class="table table-striped table-bordered">
        <tr>
            <th class="text-center">Kategori</th>
            <th class="text-center">Jan</th>
            <th class="text-center">Feb</th>
            <th class="text-center">Mac</th>
            <th class="text-center">Apr</th>
            <th class="text-center">Mei</th>
            <th class="text-center">Jun</th>
            <th class="text-center">Julai</th>
            <th class="text-center">Ogos</th>
            <th class="text-center">Sep</th>
            <th class="text-center">Okt</th>
            <th class="text-center">Nov</th>
            <th class="text-center">Dis</th>
        </tr>
        @foreach($complains as $complain)
            <tr>
                <td>{{$complain->description}}</td>
                <td class="text-right">{{$complain->jan or '0'}}</td>
                <td class="text-right">{{$complain->feb or '0'}}</td>
                <td class="text-right">{{$complain->mac or '0'}}</td>
                <td class="text-right">{{$complain->apr or '0'}}</td>
                <td class="text-right">{{$complain->mei or '0'}}</td>
                <td class="text-right">{{$complain->jun or '0'}}</td>
                <td class="text-right">{{$complain->jul or '0'}}</td>
                <td class="text-right">{{$complain->ogo or '0'}}</td>
                <td class="text-right">{{$complain->sep or '0'}}</td>
                <td class="text-right">{{$complain->okt or '0'}}</td>
                <td class="text-right">{{$complain->nov or '0'}}</td>
                <td class="text-right">{{$complain->dis or '0'}}</td>
            </tr>
        @endforeach
        <tfoot>
        <td class="text-right"><strong>Jumlah</strong></td>
        <td class="text-right">$sumJan</td>
        <td class="text-right">$sumFeb</td>
        <td class="text-right">$sumMac</td>
        <td class="text-right">$sumApr</td>
        <td class="text-right">$sumMei</td>
        <td class="text-right">$sumJun</td>
        <td class="text-right">$sumJulai</td>
        <td class="text-right">$sumOgos</td>
        <td class="text-right">$sumSep</td>
        <td class="text-right">$sumOkt</td>
        <td class="text-right">$sumNov</td>
        <td class="text-right">$sumDis</td>
        </tfoot>
    </table>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript">
        $( document ).ready(function() {

            $( "#search" ).click(function() {
                var submit_type = 'search';
                submit_form(submit_type);
            });

            $( "#downloadpdf" ).click(function() {
                var submit_type = 'downloadpdf';
                submit_form(submit_type);
            });

            function submit_form(submit_type) {
                $("#submit_type").val(submit_type);
                $("#form1").submit();
            }

        });
    </script>
@endsection