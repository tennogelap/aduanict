{{--history table--}}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Tugasan Kakitangan</strong></h3>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Kakitangan</th>
                    <th>Aduan</th>
                    <th>Cawangan</th>
                    <th>Tindakan</th>
                </tr>
                @foreach($complain_actions as $complain_action)
                <tr>
                    <td>
                        <p class="form-control-static" >
                            @if($complain_action->user_action)
                                {{ $complain_action->user_action->short_name }}:
                            @endif
                    <td>
                        <p class="form-control-static">{{$complain_action->created_at}}</p>
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
                        {{$complain_action->action_comment}}
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
