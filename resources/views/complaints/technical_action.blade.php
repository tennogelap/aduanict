@extends('layouts.app')
@section('content')
    @include('layouts.alert_message')

    {{--include exit from--}}

    {{--show--}}

    @include('complaints.partials.technical_edit_form',['exclude_category'=>'Y'])

{{--
    @if($complain->complain_status_id=2)
        @include('complaints.partials.edit_form')
    @else
        @include('complaints.partials.complain_info')
    @endif
--}}
    {!! Form::open(array('route' => ['complain.update_technical_action',$complain->complain_id],'method'=>'put', 'class'=>"form-horizontal","id"=>"form1")) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Maklumat Aduan - Tindakan Kakitangan Teknikal</h3>
        </div>
        <div class="panel panel-info">
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Tarikh :</label>
                    <div class="col-sm-2">
                        {{--<p class="form-control-static">{{$complain->assign_date}}</p>--}}
                        <p class="form-control-static"><?php echo date('d/m/y H:i:s');?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Bahagian/Unit :</label>
                    <div class="col-sm-4">
                        {{--{!! Form::select('unit_id',$units,$complain->unit_id,['class'=> 'form-control chosen'])!!}--}}
                        <p class="form-control-static">{{$complain->complain_unit_fk->butiran}}</p>
                        {{--<p class="form-control-static">{{$complain->unit_id}}</p>--}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Status :</label>
                    <div class="col-sm-2 col-xs-10">
                        {!! Form::select('complain_status_id', $statuses, $complain->complain_status_id, ['class' => 'form-control chosen']) !!}
                    </div>
                    <label class="col-sm-1 col-xs-1 control-label">
                        <span class="pull-left symbol"> * </span>
                    </label>
                </div>
                <div class="form-group hide_by_category">
                    <label class="col-sm-2 col-xs-12 control-label">Tindakan :</label>
                    <div class="col-sm-6 col-xs-10">
                        <textarea class="form-control" rows="3" name="action_comment">{{old('action_comment',$complain->action_comment)}}</textarea>
                    </div>
                    <label class="col-sm-1 col-xs-1 control-label">
                        <span class="pull-left symbol"> * </span>
                    </label>
                </div>
                <div class="form-group hide_by_category">
                    <label class="col-sm-2 col-xs-12 control-label">Sebab Lewat :</label>
                    <div class="col-sm-6 col-xs-10">
                        <textarea class="form-control" rows="3" name="delay_reason">{{$complain->delay_reason}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="hidden" name="exclude_category" value="Y"/>
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
        </div>
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