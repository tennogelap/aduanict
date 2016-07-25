@extends('layouts.app')
@section('content')
    @include('layouts.alert_message')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Hantar Aduan</h3>
            </div>
            <div class="panel-body">
                {{--<form class="form-horizontal">--}}
                    {!! Form::open(array('route' => 'complain.store', 'class'=>"form-horizontal", 'files'=>true)) !!}
                    <div class="form-group">
                        <label class="col-sm-2 col-xs-2 control-label">Tarikh:</label>
                        <div class="col-sm-2 col-xs-10">
                            <p class="form-control-static">{{date('d/m/y')}}</p>
                        </div>
                    {{--</div>
                    <div class="form-group">--}}
                       <label class="col-sm-2 col-xs-2 control-label">Masa:</label>
                        <div class="col-sm-2 col-xs-10">
                            {{--<p class="form-control-static">{{date('h:i:s a')}}</p>--}}
                            <div id="clock"></div>
                            <input type="hidden" id="servertime" value="{{ time() }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Pengadu:</label>
                        <div class="col-sm-3">
                            <p class="form-control-static" >{{ Auth::user()->name }}</p>
                        </div>
                        <label class="col-sm-2 col-xs-2 control-label">No. Pekerja:</label>
                        <div class="col-sm-2">
                            <p class="form-control-static">{{ Auth::user()->emp_id }}</p>
                            <input type="hidden" name="register_user_id" value="{{ Auth::user()->emp_id }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Aduan bagi pihak?</label>
                        <div class="col-sm-1">
                            <div class="checkbox">
                                <label>
                                    {{ Form::checkbox('bagipihak', 'Y',false,['id'=>"bagi_pihak"]) }} Ya
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4 hide_div" id="pilih_bagi_pihak">
                            <div class="input-group">
                                {!! Form::select('user_emp_id',$users,'user_emp_id',['class'=> 'form-control','id'=>'user_emp_id'])!!}
                            </div><!-- /input-group -->
                        </div>
                    </div>
                    <div class="form-group {{$errors->has('complain_category_id') ? 'has-error' : false}}">
                        <label class="col-sm-2 col-xs-12 control-label">Kategori<span class="symbol"> * </span>                        </label>
                        <div class="col-sm-3 col-xs-10">
                            {!! Form::select('complain_category_id',$complain_categories,'',['class'=> 'form-control chosen','id'=>'complain_category_id'])!!}
                        </div>
                    </div>
                    <div class="form-group hide_by_category {{$errors->has('branch_id') ? 'has-error' : false}}">
                        <label class="col-sm-2 col-xs-12 control-label">Cawangan<span class="symbol"> * </span></label>
                        <div class="col-sm-3 col-xs-10">
                            {!! Form::select('branch_id',$branches,'',['class'=> 'form-control chosen','id'=>'branch_id'])!!}
                        </div>
                    </div>
                    <div class="form-group hide_by_category {{$errors->has('lokasi_id') ? 'has-error' : false}}">
                        <label class="col-sm-2 col-xs-12 control-label">Lokasi<span class="symbol"> * </span></label>
                        <div class="col-sm-3 col-xs-10">
                            {!! Form::select('lokasi_id',$locations,'',['class'=> 'form-control chosen','id'=>'lokasi_id'])!!}
                        </div>
                    </div>
                    <div class="form-group hide_by_category {{$errors->has('ict_no') ? 'has-error' : false}}">
                        <label class="col-sm-2 control-label">Aset<span class="symbol"> * </span></label>
                        <div class="col-sm-3 col-xs-10">
                            {!! Form::select('ict_no',$assets,'',['class'=> 'form-control chosen','id'=>'ict_no'])!!}
                        </div>
                    </div>
                    <div class="form-group {{$errors->has('complain_source_id') ? 'has-error' : false}}">
                        <label class="col-sm-2 control-label">Kaedah<span class="symbol"> * </span></label>
                        <div class="col-sm-3">
                            {!! Form::select('complain_source_id',$complain_sources,'',['class'=> 'form-control chosen','id'=>'complain_source_id'])!!}

                        </div>
                    </div>
                    <div class="form-group {{$errors->has('complain_description') ? 'has-error' : false}}">
                        <label class="col-sm-2 control-label">Aduan<span class="symbol"> * </span></label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name='complain_description' rows="3">{{old('complain_description')}}</textarea>
                        </div>
                    </div>
                    <div class="form-group {{$errors->has('complain_attachment') ? 'has-error' : false}}">
                        <label class="col-sm-2 control-label">Muatnaik Gambar / Fail</label>
                        <div class="col-sm-6">
                            {!! Form::file('complain_attachment') !!}
                        </div>
                    </div>
                    <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Hantar</button>
                        <a href="{{route('complain.index')}}" class="btn btn-default">Kembali</a>
                    </div>
                </div>
                {!! Form::close() !!}
                {{--</form>--}}
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Large modal -->
    <div id="bagiPihak" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Bagi Pihak</h4>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item active">
                            Firdaus
                        </a>
                        <a href="#" class="list-group-item">Syahril</a>
                        <a href="#" class="list-group-item">Ruzaini</a>
                        <a href="#" class="list-group-item">Rahmat</a>
                        <a href="#" class="list-group-item">Mohammad</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('complaints.partials.form_script')
@endsection