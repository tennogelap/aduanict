@extends('layouts.app')
@section('content')
    @include('layouts.alert_message')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Senarai Aduan</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-10 col-xs-2">
                    <a href="{{route('complain.create')}}" class="btn btn-warning">Tambah Aduan</a>
                    <a href="#" class="dropdown-toggle btn btn-default" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        10 <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="#">9</a></li>
                        <li><a href="#">8</a></li>
                        <li><a href="#">7</a></li>
                    </ul>
                </div>
                <div class="col-sm-2 col-xs-10">
                    <input type="text" class="form-control" placeholder="Cari..." aria-describedby="basic-addon1">
                </div>
            </div>
            <br>
            <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>Pengadu</th>
                    <th>Aduan id</th>
                    <th>Aduan / Tindakan</th>
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
                    <td>Aduan: {{str_limit($complain->complain_description,50)}}<br><hr>
                        Tindakan: {{$complain->action_comment}}
                    </td>
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
                        {!! Form::open(array('route' => ['complain.destroy',$complain->complain_id],'method'=>'delete', 'class'=>"form-horizontal")) !!}

                            @if(Entrust::can('action_complain'))
                            <a href="{{route('complain.action',$complain->complain_id)}}" class="btn btn-warning">
                                <span class="glyphicon glyphicon-edit"></span> Kemaskini</a>
                            @elseif (Entrust::can('edit_complain') && $complain->complain_status_id==1)
                                <a href="{{route('complain.edit',$complain->complain_id)}}" class="btn btn-warning">
                                    <span class="glyphicon glyphicon-edit"></span> Kemaskini</a>
                            @elseif (Entrust::can('verify_complain_action') && $complain->complain_status_id==3)
                                <a href="{{route('complain.edit',$complain->complain_id)}}" class="btn btn-warning">
                                    <span class="glyphicon glyphicon-edit"></span> Pengesahan</a>
                            @elseif (Entrust::can('technical_action_complain'))
                                <a href="{{route('complain.technical_action',$complain->complain_id)}}" class="btn btn-warning">
                                    <span class="glyphicon glyphicon-edit"></span> Tindakan</a>
                            @endif

                        {{-- Letak checking if role!= helpdesk, hide delete button--}}
                            @if(Entrust::can('delete_complain') AND $complain->complain_status_id==1)
                                <button type="button" class="btn btn-danger" data-destroy><span class="glyphicon glyphicon-trash"></span> Padam</button>
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