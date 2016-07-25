@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row">
        <p align="center"><img src="{{ URL::asset('images/letterheadppz.jpg')}}" alt="letterheadppz"></p>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    Selamat Datang ke Sistem Aduan ICT. Sila Login @ daftar.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
