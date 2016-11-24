<?php

namespace App\Listeners;

use App\Events\ComplainUserVerifyEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class EmailComplainUserVerifyListener
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
     * @param  ComplainUserVerifyEvent  $event
     * @return void
     */
    public function handle(ComplainUserVerifyEvent $event)
    {
        $status_complain = $event->complain->complain_status_id;

        //dapatkan nama pengadu
        $sender = $event->complain->onBehalf_fk->name;
        //dapatkan emel pengadu
        $senderemailadd = $event->complain->onBehalf_fk->email;
        //dapatkan ID aduan
        $complain_id = $event->complain->complain_id;
        //dapatkan maklumat aduan
        $complain_description = $event->complain->complain_description;
        //dapatkan status complain
        $status_complain_description = 'Tindakan';

        if ($status_complain==2)// hantar email kepada action_emp_id,
                                // maklumkan penyelesaian tidak berjaya
        {
            //$RcptEmailName = $event->complain->onBehalf_fk->name;
            $rcptname = $event->complain->action_user_fk->name;
            $RcptEmailAdd = 'nargis@zakat.com.my';
            $hSubject   = 'Pengesahan Penyelesaian: Gagal';
            //get email pengadu
            //$RcptEmailAdd = $event->complain->onBehalf_fk->email;
            $emailbladename = 'email.complain_verify_reject';
        }
        elseif ($status_complain==4) //email ke Helpdesk untuk tutup aduan
        {
            //Helpdesk details
            $RcptEmailAdd = 'nargis@zakat.com.my';
            $rcptname = 'ICT Helpdesk';


            //$rcptname = $event->complain->onBehalf_fk->name;
            $emailbladename = 'email.complain_verify_success';
            $hSubject   = 'Pengesahan pihak Helpdesk.';
        }

        $data = [
            'complain_from'=>  $sender,
            'complain_from_email'=>  $senderemailadd,
            'helpdesk_email'=>  $RcptEmailAdd,
            'complain_status_description'=> $status_complain_description,
            'complain_status'=> $status_complain,
            'complain_description'=> $complain_description,
            'complain_id'=>$complain_id,
            'hSubject'=>$hSubject,
            'rcptname'=>$rcptname,
        ];

        //send email to Pengadu if complain_status_id=3
        Mail::send($emailbladename, $data, function ($message)
        use($data,$senderemailadd,$sender,$RcptEmailAdd,
            $status_complain,$rcptname,$complain_id,$hSubject)
        {
            $message->from($senderemailadd, $sender);
//            $message->from('email pengadu', 'Nama pengadu');
            $message->to($RcptEmailAdd, $rcptname)->subject($hSubject);
        });
    }
}
