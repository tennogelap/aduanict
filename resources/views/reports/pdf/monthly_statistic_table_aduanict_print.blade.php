@extends('layouts.appprint')

@section('content')

    <h3><strong>Laporan Statistik Aduan Mengikut Kategori</strong></h3>

        <table border="1" class="display" cellspacing="0">
        <tr class="warning">
            <th>Kategori</th>
            <th>Jan</th>
            <th>Feb</th>
            <th>Mac</th>
            <th>Apr</th>
            <th>Mei</th>
            <th>Jun</th>
            <th>Julai</th>
            <th>Ogos</th>
            <th>Sep</th>
            <th>Okt</th>
            <th>Nov</th>
            <th>Dis</th>
        </tr>
        @foreach($complains as $complain)
            <tr>
                <td>{{$complain->description}}</td>
                <td>{{$complain->jan or '0'}}</td>
                <td>{{$complain->feb or '0'}}</td>
                <td>{{$complain->mac or '0'}}</td>
                <td>{{$complain->apr or '0'}}</td>
                <td>{{$complain->mei or '0'}}</td>
                <td>{{$complain->jun or '0'}}</td>
                <td>{{$complain->jul or '0'}}</td>
                <td>{{$complain->ogo or '0'}}</td>
                <td>{{$complain->sep or '0'}}</td>
                <td>{{$complain->okt or '0'}}</td>
                <td>{{$complain->nov or '0'}}</td>
                <td>{{$complain->dis or '0'}}</td>
            </tr>
        @endforeach
        <tfoot>
            <tr class="info">
                <td>Jumlah</td>
                <td>$sumJan</td>
                <td>$sumFeb</td>
                <td>$sumMac</td>
                <td>$sumApr</td>
                <td>$sumMei</td>
                <td>$sumJun</td>
                <td>$sumJulai</td>
                <td>$sumOgos</td>
                <td>$sumSep</td>
                <td>$sumOkt</td>
                <td>$sumNov</td>
                <td>$sumDis</td>
            </tr>
        </tfoot>
    </table>

@endsection
