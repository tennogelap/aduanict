@extends('layouts.app')
@section('content')
    @include('layouts.alert_message')

    {!! Form::open(array('route' => ['complain.update',$complain->ADUAN_ID],'method'=>'put', 'class'=>"form-horizontal")) !!}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Maklumat Aduan</h3>
            </div>
            <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Aduan </label>
                        <div class="col-sm-2">
                            <p class="form-control-static" name="ADUAN_ID">{{$complain->ADUAN_ID}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tarikh </label>
                        <div class="col-sm-2">
                            <p class="form-control-static">{{$complain->TKH_ADUAN}}</p>
                        </div>
                        <label class="col-sm-2 control-label">Masa </label>
                        <div class="col-sm-2">
                            <p class="form-control-static">{{$complain->MASA_ADUAN}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Pengadu </label>
                        <div class="col-sm-2">
                            <p class="form-control-static">Mohd Hafizullah</p>
                        </div>
                        <label class="col-sm-2 control-label">No. Pekerja </label>
                        <div class="col-sm-2">
                            <p class="form-control-static">{{$complain->EMP_ID_ADUAN}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Bagi Pihak</label>
                        <div class="col-sm-2">
                            <p class="form-control-static">- </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Kategori</label>
                        <div class="col-sm-2">
                            <p class="form-control-static">Perkakasan </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Aset</label>
                        <div class="col-sm-2">
                            <p class="form-control-static">{{$complain->ICT_NO}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Kaedah</label>
                        <div class="col-sm-2">
                            <p class="form-control-static">{{$complain->KOD_SUMBERADUAN}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Aduan</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" rows="3" name="ADUAN">{{$complain->ADUAN}}</textarea>
                        </div>
                    </div>
            </div>
        </div>
        <!--end-->
        <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Tindakan ICT Helpdeck</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-2 control-label">Tarikh </label>
                <div class="col-sm-2">
                    <p class="form-control-static">{{$complain->TKH_ASSIGN}}</p>
                </div>
                <label class="col-sm-2 control-label">Masa </label>
                <div class="col-sm-2">
                    <p class="form-control-static">{{$complain->MASA_ASSIGN}}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Bahagian/Unit </label>
                <div class="col-sm-2">
                    <p class="form-control-static">{{$complain->UNIT_ID_TINDAK}}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-12 control-label">Status</label>
                <div class="col-sm-3 col-xs-10">
                    <select class="form-control input-sm">
                        <option selected>Baru</option>
                        <option>Tindakan</option>
                        <option>Selesai</option>
                    </select>
                </div>
                <label class="col-sm-1 col-xs-1 control-label">
                    <span class="pull-left symbol"> * </span>
                </label>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-12 control-label">Tindakan</label>
                <div class="col-sm-6 col-xs-10">
                    <textarea class="form-control" rows="3" name="TINDAKAN">{{$complain->TINDAKAN}}</textarea>
                </div>
                <label class="col-sm-1 col-xs-1 control-label">
                    <span class="pull-left symbol"> * </span>
                </label>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-12 control-label">Sebab Lewat</label>
                <div class="col-sm-6 col-xs-10">
                    <textarea class="form-control" rows="3">{{$complain->SBB_HELPDESK_LEWAT}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Hantar</button>
                    <a href="{{route('complain.index')}}" type="submit" class="btn btn-default">Kembali</a>
                    {{--<button type="submit" class="btn btn-default">Kembali</button>--}}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
