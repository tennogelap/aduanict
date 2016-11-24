<?php

namespace App\Listeners;

use App\Events\ComplainCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class EmailComplainCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ComplainCreated  $event
     * @return void
     */
    public function handle(ComplainCreatedEvent $event)
    {
        //dapatkan nama pengadu
        $sender = $event->complain->onBehalf_fk->name;
        //dapatkan emel pengadu
        $senderemailadd = $event->complain->onBehalf_fk->email;
        //dapatkan ID aduan
        $complain_id = $event->complain->complain_id;
        //dapatkan maklumat aduan
        $complain_description = $event->complain->complain_description;
        //dapatkan status complain
        $status_complain = 'Baru';
//        $status_complain = $event->complain->complain_status_fk->description;

        $RcptEmailAdd = 'nargis@zakat.com.my';
//        $RcptEmailAdd = 'icthelpdesk@zakat.com.my';

        $data = [
          'complain_from'=>  $sender,
          'complain_from_email'=>  $senderemailadd,
          'helpdesk_email'=>  $RcptEmailAdd,
          'complain_status'=> $status_complain,
          'complain_description'=> $complain_description,
          'complain_id'=>$complain_id,
        ];

        //send email to Helpdesk
        Mail::send('email.complain_created', $data, function ($message)
            use($data,$senderemailadd,$sender,$RcptEmailAdd,$status_complain)  {
            $message->from($senderemailadd, $sender);
//            $message->from('email pengadu', 'Nama pengadu');
            $message->to($RcptEmailAdd, 'ICT Helpdesk')->subject('Aduan Baru');
        });

    }
}
