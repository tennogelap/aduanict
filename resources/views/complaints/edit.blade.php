@extends('layouts.app')
@section('content')
    @include('layouts.alert_message')

    @include('partials.complain_notification')

    @if ($complain->complain_status_id==1)
        @include('complaints.partials.edit_form')
    @elseif($complain->complain_status_id==2)
        @include('complaints.technical_action')
    @elseif($complain->complain_status_id==3)
        @include('complaints.partials.verify_form')
        @include('complaints.partials.complain_action_log')
    @endif


@endsection

@section('script')
<script type="text/javascript">
    $( document).ready(function() {
        $("#submit_finish").click( function() {
            var submit_type='finish';
            submit_form(submit_type);
        });
       $("#submit_reject").click( function() {
           var submit_type='reject';
           submit_form(submit_type);
        });
        function submit_form( submit_type) {
//            assign value to hidden field
            $('#submit_type').val(submit_type);
            //ask javascript to submit instead of submit button
            $('#form1').submit();
        };
    });
</script>
@endsection