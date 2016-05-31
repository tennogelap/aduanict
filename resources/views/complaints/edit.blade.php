@extends('layouts.app')
@section('content')
    @include('layouts.alert_message')

    {!! Form::open(array('route' => ['complain.update',$complain->complain_id],'method'=>'put', 'class'=>"form-horizontal")) !!}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Maklumat Aduan</h3>
            </div>
            <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Aduan </label>
                        <div class="col-sm-2">
                            <p class="form-control-static" name="complain_id">{{$complain->complain_id}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tarikh </label>
                        <div class="col-sm-2">
                            <p class="form-control-static">{{$complain->created_at}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Pendaftar Aduan </label>
                        <div class="col-sm-6">
                            <p class="form-control-static">{{$complain->register_user_id}} - {{$complain->regUser_fk->name}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Bagi Pihak</label>
                        <div class="col-sm-6">
                            <p class="form-control-static">{{$complain->user_emp_id}} - {{$complain->onBehalf_fk->name}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Kategori</label>
                        <div class="col-sm-2">
                            {!! Form::select('complain_category_id',$complain_categories,$complain->complain_category_id,['class'=> 'form-control chosen'])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Aset</label>
                        <div class="col-sm-2">
                            <p class="form-control-static">{{$complain->ict_no}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Kaedah</label>
                        <div class="col-sm-2">
                            <p class="form-control-static">{{$complain->complain_source_fk->description}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Aduan</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" rows="3" name="complain_description">{{$complain->complain_description}}</textarea>
                        </div>
                    </div>
            </div>
        </div>
        <!--end-->
    </div>
    {!! Form::close() !!}
@endsection
