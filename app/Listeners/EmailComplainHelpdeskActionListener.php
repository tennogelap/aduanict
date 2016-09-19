<?php

namespace App\Listeners;

use App\Events\ComplainHelpdeskActionEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
class EmailComplainHelpdeskActionListener
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
     * @param  ComplainHelpdeskActionEvent  $event
     * @return void
     */
    public function handle(ComplainHelpdeskActionEvent $event)
    {
        $status_complain = $event->complain->complain_status_id;

        //dapatkan nama pengadu
        $sender = 'ICT Helpdesk';
        //dapatkan emel pengadu
        $senderemailadd = 'icthelpdesk@zakat.com.my';
        //dapatkan ID aduan
        $complain_id = $event->complain->complain_id;
        //dapatkan maklumat aduan
        $complain_description = $event->complain->complain_description;
        //dapatkan status complain
        $status_complain_description = 'Baru';
        $rcptname='';
        if ($status_complain==3) // hantar email kepada pengadu untuk pengesahan
        {
            //$RcptEmailName = $event->complain->onBehalf_fk->name;
            $RcptEmailAdd = 'firdaus_aziz@zakat.com.my';
            $rcptname = $event->complain->onBehalf_fk->name;
            $hSubject   = 'Pengesahan Aduan';
            //get email pengadu
            //$RcptEmailAdd = $event->complain->onBehalf_fk->email;
            $emailbladename = 'email.complain_helpdesk_solve';
        }
        elseif ($status_complain==5) //tutup aduan, email ke pengadu & ketua unit
        {
            //get nama ketua unit
            //$RcptEmailName = $event->complain->onBehalf_fk->name;
            //$emailKetuaUnit = $event->complain->complain_unit_fk->ketuaUnit_fk->empMaster_fk->email;
            //$RcptEmailAdd1 = $event->complain->complain_unit_fk->ketuaUnit_fk->empMaster_fk->email;
//            dd($RcptEmailAdd1);
            //$RcptEmailAdd1 = 'firdaus_aziz@zakat.com.my';

            $rcptname1 = $event->complain->complain_unit_fk->ketuaUnit_fk->name;

            //get email pengadu
            $RcptEmailAdd2 = $event->complain->onBehalf_fk->email;
            //$RcptEmailAdd2 = 'firdaus_aziz@zakat.com.my';
            $rcptname2 = $event->complain->onBehalf_fk->name;

            $RcptEmailAdd = array($RcptEmailAdd1,$RcptEmailAdd2);
            $rcptname = array($rcptname1,$rcptname2);
            

            //$rcptname = $event->complain->onBehalf_fk->name;
            $emailbladename = 'email.complain_helpdesk_close';
            $hSubject   = 'Aduan telah ditutup.';
        }
         elseif ($status_complain==7)//email to ketua unit untuk agihan kakitangan
        {
            //get nama ketua unit
            //$RcptEmailName =  $event->complain->complain_unit_fk->emp_id_ketua;
            //get email ketua unit
            //$RcptEmailAdd = $event->complain->onBehalf_fk->email;
            $rcptname = 'Firdaus Abdul Aziz @ Ahmad';
            $RcptEmailAdd = 'firdaus_aziz@zakat.com.my';
            $emailbladename = 'email.complain_helpdesk_assign';
            $hSubject   = 'Terdapat aduan untuk diagihkan.';
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
            //'emailKetuaUnit'=>'$emailKetuaUnit',
        ];

        //send email to Pengadu if complain_status_id=3
        Mail::send($emailbladename, $data, function ($message)
        use($data,$senderemailadd,$sender,$RcptEmailAdd,$status_complain,$rcptname,$complain_id,$hSubject)  {
            $message->from($senderemailadd, $sender);
//            $message->from('email pengadu', 'Nama pengadu');
            $message->to($RcptEmailAdd, $rcptname)->subject($hSubject);
        });



    }
}
