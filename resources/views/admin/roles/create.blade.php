@extends('admin.app')

@section('content')
    <h3 class="">Tambah Peranan</h3><br>

    {!! Form::open(['route' => 'admin.roles.store']) !!}

    <div class="form-group {{ $errors->has('name') ? 'has-error' : false }}">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group {{ $errors->has('display_name') ? 'has-error' : false }}">
        {!! Form::label('display_name', 'Display Name') !!}
        {!! Form::text('display_name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group {{ $errors->has('permissions') ? 'has-error' : false }}">
        {!! Form::label('permissions', 'Permissions') !!}
        {!! Form::select('permissions[]', $permissions, null, ['class' => 'form-control', 'multiple'=>'multiple', 'size'=>$permissions->count()]); !!}
    </div>


    <button type="submit" id="create" class="btn btn-labeled btn-primary"><span class="btn-label"><span class="glyphicon glyphicon-plus"></span> Tambah</button>

    <a class="btn btn-labeled btn-default" href="{{ route('admin.roles.index') }}"><span class="btn-label"><span class="glyphicon glyphicon-arrow-left"></span> Batal/Kembali</a>

    {!! Form::close() !!}
@endsection