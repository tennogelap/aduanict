{!! Form::open(array('route' => ['complain.update',$complain->complain_id],'method'=>'put', 'class'=>"form-horizontal","id"=>"form1")) !!}
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Maklumat Aduan</h3>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="col-sm-2 control-label">Aduan </label>
            <div class="col-sm-3">
                <p class="form-control-static" id="complain_id">{{$complain->complain_id}}</p>
            </div>
        {{--</div>--}}
        {{--<div class="form-group">--}}
            <label class="col-sm-2 control-label">Tarikh </label>
            <div class="col-sm-3">
                <p class="form-control-static">{{$complain->created_at->format('d/m/Y H:i:s')}}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Pendaftar Aduan </label>
            <div class="col-sm-3">
                <p class="form-control-static">{{$complain->register_user_id}} - {{$complain->regUser_fk->name}}</p>
            </div>
        {{--</div>--}}
        {{--<div class="form-group">--}}
            <label class="col-sm-2 control-label">Bagi Pihak</label>
            <div class="col-sm-3">
                <p class="form-control-static">{{$complain->user_emp_id}} - {{$complain->onBehalf_fk->name}}</p>
            </div>
        </div>
        {{--Kategori--}}
        <div class="form-group {{$errors->has('branch_id') ? 'has-error' : false}}">
            <label class="col-sm-2 col-xs-12 control-label">Kategori<span class="symbol"> * </span>                        </label>
            <div class="col-sm-3 col-xs-10">
                @if(!empty($exclude_category) && $exclude_category!='Y')
                    {!! Form::select('complain_category_id',$complain_categories,$complain->complain_category_id.'-'.$complain->unit_id,['class'=> 'form-control chosen','id'=>'complain_category_id'])!!}
                @else
                    <p class="form-control-static">{{$complain->complain_category_fk->description}}</p>
                    <input type="hidden" name="exclude_category" value="Y"/>
                @endif
            </div>
        {{--</div>--}}
        {{--<div class="form-group">--}}
            <label class="col-sm-2 control-label">Bahagian/Unit </label>
            <div class="col-sm-4 col-xs-10">
{{--                {!! Form::select('unit_id',$units,$complain->unit_id,['class'=> 'form-control chosen'])!!}--}}
                <p class="form-control-static">{{$complain->complain_unit_fk->butiran}}</p>
            </div>
        </div>
        <div class="form-group hide_by_category {{$errors->has('branch_id') ? 'has-error' : false}}">
            <label class="col-sm-2 col-xs-12 control-label">Cawangan<span class="symbol"> * </span></label>
            <div class="col-sm-3 col-xs-10">
                <p class="form-control-static">{{ $complain->branch_fk->branch_description }}</p>
            </div>
        </div>
        <div class="form-group hide_by_category {{$errors->has('lokasi_id') ? 'has-error' : false}}">
            <label class="col-sm-2 col-xs-12 control-label">Lokasi<span class="symbol"> * </span></label>
            <div class="col-sm-3 col-xs-10">
                {!! Form::select('lokasi_id',$locations,$complain->lokasi_id,['class'=> 'form-control chosen','id'=>'lokasi_id'])!!}
            </div>
        </div>
        <div class="form-group hide_by_category {{$errors->has('ict_no') ? 'has-error' : false}}">
            <label class="col-sm-2 control-label">Aset<span class="symbol"> * </span></label>
            <div class="col-sm-3 col-xs-10">
                {!! Form::select('ict_no',$assets,$complain->ict_no,['class'=> 'form-control chosen','id'=>'ict_no'])!!}
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
            <div class="col-sm-offset-2 col-sm-10">
                @if ($complain->complain_status_id <=2)
                    <button type="submit" class="btn btn-primary">Hantar</button>
                    <a href="{{route('complain.index')}}" type="submit" class="btn btn-default">Kembali</a>
                @endif
            </div>
        </div>
    </div>
</div>
<!--end-->
{!! Form::close() !!}