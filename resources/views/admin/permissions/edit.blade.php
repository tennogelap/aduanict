@extends('admin.app')

@section('content')
    <h3 class="">Kemaskini Kebenaran</h3><br>

    {!! Form::open(['route' => ['admin.permissions.update',$permission->id],'method'=>'put']) !!}

    <div class="form-group {{ $errors->has('name') ? 'has-error' : false }}">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', $permission->name, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group {{ $errors->has('display_name') ? 'has-error' : false }}">
        {!! Form::label('display_name', 'Display Name') !!}
        {!! Form::text('display_name', $permission->display_name, ['class' => 'form-control']) !!}
    </div>

    <button type="submit" id="update" class="btn btn-labeled btn-primary"><span class="btn-label"><i class="fa fa-plus"></i></span> Hantar</button>

    <a class="btn btn-labeled btn-default" href="{{ route('admin.permissions.index') }}"><span class="btn-label"><i class="fa fa-chevron-left"></i></span> Kembali</a>

    {!! Form::close() !!}
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