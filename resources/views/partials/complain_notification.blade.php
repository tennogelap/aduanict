@if ($complain->complain_status_id==4)
    @role('unit_manager')
    <div class="alert alert-warning">
        <h3>Aduan telah diagihkan kepada kakitangan.</h3>
    </div>
    @endrole
@elseif ($complain->complain_status_id==4)
    <div class="alert alert-warning">
        <h3>Aduan menunggu pengesahan dari Helpdesk</h3>
    </div>
@elseif($complain->complain_status_id==5)
    <div class="alert alert-warning">
        <h3>Aduan telah ditutup</h3>
    </div>
@elseif($complain->complain_status_id==7)
    <div class="alert alert-warning">
        <h3>Agihan Aduan sedang dilakukan</h3>
    </div>
@endif