@extends('layouts.app')
@section('content')
    @include('layouts.alert_message')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Senarai Aduan</h3>
        </div>
        <div class="panel-body">
            <br>
            <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>Pengadu</th>
                    <th>Aduan id</th>
                    <th>Aduan</th>
                    <th>Tarikh</th>
                    <th>Status</th>
                    <th>Tindakan</th>
                    <th></th>

                </tr>
                @foreach($complains as $complain)
                <tr>
                    {{--<td>{{ is_null($complain->user_emp_id) ? $complain->register_user_id : $complain->user_emp_id }}</td>--}}
                    <td>
                        @if(count($complain->employeeR_fk))
                            {{ $complain->employeeR_fk->short_name }}
                         @else
                            {{ $complain->employeeU_fk->short_name }}
                         @endif
                    </td>
                    <td>{{$complain->complain_id}}</td>
                    <td>{{str_limit($complain->complain_description,50)}}</td>
                    <td>{{$complain->created_at}}</td>
                    <td>
                        {{--tengok model function mutator--}}
                        {!! $complain->status !!}

                    </td>
                    <td>
                        @if(count($complain->employeeT_fk))
                            {{ $complain->employeeT_fk->short_name }}
                        @endif
                    </td>
                    <td>
                        {!! Form::open(array('route' => ['complain.assign_staff',$complain->complain_id],'method'=>'get', 'class'=>"form-horizontal")) !!}
                            @if(Entrust::can('assign_complain') AND $complain->complain_status_id==7)
                                <button type="submit" class="btn btn-default"><span  class="glyphicon glyphicon-edit"></span> Agihan</button>
                            @endif
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </table>
            <nav class="navbar-form navbar-right">
                {{ $complains->appends(Request::except('page'))->links() }}
            </nav>
        </div>
        </div>
    </div>
@endsection