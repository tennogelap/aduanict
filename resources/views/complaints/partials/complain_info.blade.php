 <form class="form-horizontal">
  <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Maklumat Aduan</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-2 control-label">Aduan :</label>
                <div class="col-sm-3">
                    <p class="form-control-static" name="complain_id">{{$complain->complain_id}}</p>
                </div>
                {{--</div>--}}
                {{--<div class="form-group">--}}
                <label class="col-sm-2 control-label">Tarikh :</label>
                <div class="col-sm-3">
                    <p class="form-control-static">{{$complain->created_at->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Pendaftar Aduan :</label>
                <div class="col-sm-3">
                    <p class="form-control-static">{{$complain->register_user_id}} - {{$complain->regUser_fk->name}}</p>
                </div>
                {{--</div>--}}
                {{--<div class="form-group">--}}
                <label class="col-sm-2 control-label">Bagi Pihak :</label>
                <div class="col-sm-3">
                    <p class="form-control-static">
                        @if ($complain->onBehalf_fk)
                            {{$complain->user_emp_id}} - {{$complain->onBehalf_fk->name}}
                        @else
                            {{$complain->user_emp_id}}
                        @endif
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Kategori :</label>
                <div class="col-sm-3">
                    <p class="form-control-static">{{$complain->complain_category_fk->description}}</p>
                </div>
                {{--</div>--}}
                {{--<div class="form-group">--}}
                <label class="col-sm-2 control-label">Aset :</label>
                <div class="col-sm-3">
                    <p class="form-control-static">{{$complain->ict_no}}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Bahagian/Unit :</label>
                <div class="col-sm-3">
                    <p class="form-control-static">{{$complain->complain_unit_fk->butiran}}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Kaedah :</label>
                <div class="col-sm-2">
                    <p class="form-control-static">{{$complain->complain_source_fk->description}}</p>
                    {{--<p class="form-control-static">{{$complain->complain_source_id}}</p>--}}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Aduan :</label>
                <div class="col-sm-10">
                    <p class="form-control-static">{{$complain->complain_description}}</p>
                    {{--<textarea class="form-control" rows="3" name="complain_description">{{$complain->complain_description}}</textarea>--}}
                </div>
            </div>
        </div>
  </div>
 </form>