@extends('layouts.app')
@section('content')
    @include('layouts.alert_message')

    {{--include exit from--}}
    @if($complain->complain_status_id<=2)
        @include('complaints.partials.edit_form',['exclude_category'=>'N'])
    @endif

    {{--show--}}
    {!! Form::open(array('route' => ['complain.update_action',$complain->complain_id],'method'=>'put', 'class'=>"form-horizontal","id"=>"form1")) !!}
        @if($complain->complain_status_id>2)
            <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Maklumat Aduan - Tindakan Helpdesk</h3>
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
                        <div class="col-sm-4">
                            <p class="form-control-static">{{$complain->complain_category_fk->description}}</p>
{{--
                            {!! Form::select('complain_category_id',$complain_categories,$complain->complain_category_id,['class'=> 'form-control chosen'])!!}
--}}
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
                            {{--<p class="form-control-static">{{$complain->complain_source_id}}</p>--}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Aduan</label>
                        <div class="col-sm-6">
                            <p class="form-control-static">{{$complain->complain_description}}</p>
                            {{--<textarea class="form-control" rows="3" name="complain_description">{{$complain->complain_description}}</textarea>--}}
                        </div>
                    </div>
            </div>
        </div>
        @endif
    <!--end-->

        @if($complain->complain_status_id==4)
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Tindakan ICT Helpdeck</h3>
                </div>
                <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-2 control-label">Tarikh </label>
                <div class="col-sm-2">
                    {{--<p class="form-control-static">{{$complain->assign_date}}</p>--}}
                    <p class="form-control-static"><?php echo date('d/m/y H:i:s');?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-12 control-label">Status</label>
                <div class="col-sm-2 col-xs-10">
                    {{--{!! Form::select('complain_status_id', $statuses, $complain->complain_status_id, ['class' => 'form-control chosen']) !!}--}}
                    <p class="form-control-static">{{ $complain->complain_status_fk->description }} </p>
                </div>
                <label class="col-sm-1 col-xs-1 control-label">
                    <span class="pull-left symbol"> * </span>
                </label>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="hidden" name="submit_type" id="submit_type" value="{{ old('submit_type') }}"/>
                    <button type="submit" class="btn btn-primary" name="submit_finish" id="submit_finish">Tutup Aduan</button>
                </div>
            </div>
        </div>
        @elseif ($complain->complain_status_id!=7)
            <div class="panel panel-info">
                <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Tarikh </label>
                    <div class="col-sm-2">
                        {{--<p class="form-control-static">{{$complain->assign_date}}</p>--}}
                        <p class="form-control-static"><?php echo date('d/m/y H:i:s');?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Bahagian/Unit </label>
                    <div class="col-sm-4">
                        {!! Form::select('unit_id',$units,$complain->unit_id,['class'=> 'form-control chosen'])!!}
                        {{--<p class="form-control-static">{{$complain->complain_category_fk->kod_unit}}</p>--}}
                        {{--<p class="form-control-static">{{$complain->unit_id}}</p>--}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Status</label>
                    <div class="col-sm-2 col-xs-10">
                        {!! Form::select('complain_status_id', $statuses, $complain->complain_status_id, ['class' => 'form-control chosen']) !!}
                    </div>
                    <label class="col-sm-1 col-xs-1 control-label">
                        <span class="pull-left symbol"> * </span>
                    </label>
                </div>
                <div class="form-group hide_by_category">
                    <label class="col-sm-2 col-xs-12 control-label">Tindakan</label>
                    <div class="col-sm-6 col-xs-10">
                        <textarea class="form-control" rows="3" name="action_comment">{{old('action_comment',$complain->action_comment)}}</textarea>
                        {{--<textarea class="form-control" rows="3" name="action_comment">{{$complain->action_comment}}</textarea>--}}
                    </div>
                    <label class="col-sm-1 col-xs-1 control-label">
                        <span class="pull-left symbol"> * </span>
                    </label>
                </div>
                <div class="form-group hide_by_category">
                    <label class="col-sm-2 col-xs-12 control-label">Sebab Lewat</label>
                    <div class="col-sm-6 col-xs-10">
                        <textarea class="form-control" rows="3" name="helpdesk_delay_reason">{{$complain->helpdesk_delay_reason}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        @if($complain->complain_status_id==4)
                            <input type="hidden" id="submit_type" value="{{ old('submit_type') }}"/>
                            <button type="button" class="btn btn-primary" id="submit_finish">Tutup Aduan</button>
                        @else
                            <button type="submit" class="btn btn-primary">Hantar</button>
                            <a href="{{route('complain.index')}}" type="submit" class="btn btn-default">Kembali</a>
                        @endif
                    </div>
                </div>
        </div>
        @endif
    </div>
    {!! Form::close() !!}

    @include('complaints.partials.complain_action_log')

@endsection

@section('script')
    <script type="text/javascript">
        $( document ).ready(function() {
            $("#submit_finish").click( function() {
            var submit_type='finish';
                submit_form(submit_type);
            });

            function submit_form( submit_type) {
//            assign value to hidden field
                if(submit_type=='finish')
                {
                    $('#submit_type').val('finish');
                }

                //ask javascript to submit instead of submit button
                $('#form1').submit();
            };
        });
    </script>
@endsection