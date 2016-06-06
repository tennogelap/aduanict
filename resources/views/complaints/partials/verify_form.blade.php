{!! Form::open(array('route' => ['complain.verify',$complain->complain_id],'method'=>'put', 'class'=>"form-horizontal","id"=>"form1")) !!}
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Maklumbalas Pengguna</h3>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="col-sm-2 control-label">Aduan </label>
            <div class="col-sm-2">
                <p class="form-control-static" id="complain_id">{{$complain->complain_id}}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Tarikh </label>
            <div class="col-sm-2">
                <p class="form-control-static">{{$complain->created_at->format('d/m/Y H:i:s')}}</p>
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
        {{--Kategori--}}
        <div class="form-group">
            <label class="col-sm-2 control-label">Kategori</label>
            <div class="col-sm-2">
                <p class="form-control-static">{{$complain->complain_category_fk->description}}</p>
            </div>
        </div>
        {{--Cawangan--}}
        <div class="form-group">
            <label class="col-sm-2 control-label">Cawangan</label>
            <div class="col-sm-2">
                <p class="form-control-static">{{$complain->complain_category_fk->description}}</p>
            </div>
        </div>
        {{--Lokasi--}}
        <div class="form-group">
            <label class="col-sm-2 control-label">Lokasi</label>
            <div class="col-sm-2">
                {{--<p class="form-control-static">{{$complain->$locations->location_description}}</p>--}}
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
                <p class="form-control-static">{{$complain->complain_description}}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-6">
                <p class="form-control-static" id="complain_status_id">{{$complain->complain_status_fk->description}}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Tindakan</label>
            <div class="col-sm-6">
                <p class="form-control-static">{{$complain->action_comment}}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-xs-12 control-label">Sebab Tidak Selesai</label>
            <div class="col-sm-6 col-xs-10">
                <textarea class="form-control" rows="3" name="user_comment">{{$complain->user_comment}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" name="submit_type" value="{{ old('submit_type') }}" id="submit_type"/>
                @if($complain->complain_status_id==3)
                    <button type="button" id="submit_finish" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-ok"></span> Selesai</a>
                        <button type="button" id="submit_reject" class="btn btn-warning btn-lg"><span class="glyphicon glyphicon-remove"></span> Tidak Selesai</a>
                @endif

            </div>
        </div>
    </div>
</div>
<!--end-->
{!! Form::close() !!}