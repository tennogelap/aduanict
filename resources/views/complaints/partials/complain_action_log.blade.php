{{--history table--}}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Sejarah Tindakan</strong></h3>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Tarikh</th>
                    <th>Tindakan</th>
                    <th>Status</th>
                    <th>Komen Pengguna</th>
                </tr>
                @foreach($complain_actions as $complain_action)
                <tr>
                    <td>
                        <p class="form-control-static">{{$complain_action->created_at}}</p>
                    </td>
                    <td>
                        <p class="form-control-static" >
                            @if($complain_action->user_action)
                                {{ $complain_action->user_action->short_name }}:
                            @endif
                            <br>{{$complain_action->action_comment}}</p>
                    </td>
                    <td>
                        <p class="form-control-static" >
                            {{--{{$complain_action->complain_status_id}}--}}
                            @if($complain_action->complain_action_status)
                                {{$complain_action->complain_action_status->description}}
                            @endif
                        </p>
                    </td>
                    <td>
                        <p class="form-control-static" >
                            @if($complain_action->pengadu_fk)
                                {{ $complain_action->pengadu_fk->short_name }}:
                            @endif
                            <br>{{$complain_action->user_comment}}</p>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
