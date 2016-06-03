@extends('layouts.app')
@section('content')
    @include('layouts.alert_message')

    @if($complain->complain_status_id==7)
    {{--show--}}
    {!! Form::open(array('route' => ['complain.update_assign_staff',$complain->complain_id],'method'=>'put', 'class'=>"form-horizontal","id"=>"form1")) !!}
    @include('complaints.partials.complain_info')

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Agihan Tugasan</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Tarikh :</label>
                    <div class="col-sm-3">
                        <p class="form-control-static" name="assign_date">{{date('d/m/y H:i:s')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Senarai Staff Unit :</label>
                    <div class="col-sm-3">
                        {!! Form::select('action_emp_id',$unit_staff_list,'',['class'=> 'form-control chosen'])!!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                            <input type="hidden" id="submit_type" value="{{ old('submit_type') }}"/>
                            <button type="button" id="submit_assign" class="btn btn-primary btn-lg">Agih</button>
                            <a href="{{route('complain.assign')}}" type="submit" class="btn btn-default">Kembali</a>
                    </div>
                </div>
            </div>
        </div>

    {!! Form::close() !!}
    @endif

    @include('complaints.partials.complain_action_log')

@endsection

@section('script')
    <script type="text/javascript">
        $( document ).ready(function() {
            $("#submit_assign").click( function() {
            var submit_type='assign';
                submit_form(submit_type);
            });

            function submit_form( submit_type) {
//            assign value to hidden field
                if(submit_type=='assign')
                {
                    $('#submit_type').val('assign');
                }

                //ask javascript to submit instead of submit button
                $('#form1').submit();
            };
        });
    </script>
@endsection