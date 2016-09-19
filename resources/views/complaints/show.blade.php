@extends('layouts.app')
@section('content')
    @include('layouts.alert_message')

    @include('complaints.partials.complain_info')

    @include('complaints.partials.complain_action_log')

      <a href="{{route('complain.index')}}" type="submit" class="btn btn-default">Kembali</a>

@endsection