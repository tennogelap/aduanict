<?php
/**
 * Created by Firdaus.
 * User: 7PPZ
 * Date: 13/06/2016
 * Time: 2:21 PM
 */

namespace App\Helpers;
use Entrust;
use Auth;
class CustomHelper
{   //kat blade, cara panggil: {{ CustomHelper::format_action_button($complain->complain_status_id) }}
    public static function format_action_button($complain)
    {   $button = '';
        if ($complain->complain_status_id == 1)
        {   // --if members can edit complain when status is BARU--
            if (Entrust::can('action_complain')) // {{--<-untuk Helpdesk--}}
            {
                $url =route('complain.action',$complain->complain_id);
                $button = '<a href="'.$url.'" class="btn btn-warning">
                         <span class="glyphicon glyphicon-edit"></span> Kemaskini</a>';
            }
            else if (Entrust::can('edit_complain') && ($complain->register_user_id == Auth::user()->emp_id
                    || $complain->user_emp_id == Auth::user()->emp_id))    //<-untuk yang ada edit complain shj--
            {
                $url =route('complain.edit',$complain->complain_id);
                $button = '<a href="'.$url.'" class="btn btn-warning">
                         <span class="glyphicon glyphicon-edit"></span> Kemaskini</a>';
            }
            else  //{{--<-untuk orang lain--}}
            {
                $url =route('complain.show',$complain->complain_id);
                $button = '<a href="'.$url.'" class="btn btn-info">
                    <span class="glyphicon glyphicon-eye-open"></span>  Papar</a>';
            }

            if (Entrust::can('delete_complain') AND $complain->complain_status_id == 1) {
                $button = $button.' '.'<button type="button" class="btn btn-danger" data-destroy><span class="glyphicon glyphicon-trash"></span> Hapus</button>';
            }
        }
        else if ($complain->complain_status_id == 2)
        {//{{--if members can edit complain when status is TINDAKAN--}}
            if ((Entrust::can('technical_action_complain') && ($complain->register_user_id != Auth::user()->emp_id || $complain->user_emp_id != Auth::user()->emp_id))
                || (Entrust::can('action_complain') && ($complain->action_emp_id == Auth::user()->emp_id))
            ) //{{--<-untuk Technical team & Helpdesk--}}
            {
                $url =route('complain.technical_action',$complain->complain_id);
                $button = '<a href="'.$url.'" class="btn btn-warning">
                        <span class="glyphicon glyphicon-edit"></span> Kemaskini</a>';
            } else   //{{--orang lain xleh edit .. bagi tengok jer--}}
                //{{--<-untuk yang ada edit complain shj--}}
            {
                $url =route('complain.show',$complain->complain_id);
                $button = '<a href="'.$url.'" class="btn btn-info">
                         <span class="glyphicon glyphicon-eye-open"></span> Papar</a>';
            }
        }
        else if ($complain->complain_status_id == 3)
        {//{{--if members can edit complain when status is SAHKAN(P)--}}
            if (Entrust::can('verify_complain_action') && ($complain->register_user_id == Auth::user()->emp_id || $complain->user_emp_id == Auth::user()->emp_id))

                //{--<-untuk Pengesahan Pengadu--}}
                {
                    $url =route('complain.edit',$complain->complain_id);
                    $button = '<a href="'.$url.'" class="btn btn-warning">
                        <span class="glyphicon glyphicon-edit"></span> Pengesahan</a>';
                }
            else
                {
                    $url =route('complain.show',$complain->complain_id);
                    $button = '<a href="'.$url.'" class="btn btn-info">
                    <span class="glyphicon glyphicon-eye-open"></span> Papar</a>';
                }
        }
        else if ($complain->complain_status_id == 4)
        {//{{--if members can edit complain when status is SAHKAN(H)--}}
            if (Entrust::can('close_complain'))  //{{--<-untuk Pengesahan Pengadu--}}
            {
                $url =route('complain.action',$complain->complain_id);
                $button = '<a href="'.$url.'" class="btn btn-warning">
                <span class="glyphicon glyphicon-edit"></span> Pengesahan Helpdesk</a>';
            }
            else {
                $url =route('complain.show',$complain->complain_id);
                $button = '<a href="'.$url.'" class="btn btn-info">
                <span class="glyphicon glyphicon-eye-open"></span> Papar</a>';
            }
         }
        else if ($complain->complain_status_id == 6)
            {//{{--if members can edit complain when status is HAPUS--}}
            }
        else if ($complain->complain_status_id == 7)
        { //{{--if members can edit complain when status is HAPUS--}}
            if (Entrust::can('assign_complain'))  //{{--<-untuk Pengesahan Pengadu--}}
            {
                $url =route('complain.assign_staff',$complain->complain_id);
                $button = '<a href="'.$url.'" class="btn btn-warning">
                        <span class="glyphicon glyphicon-user"></span> Agihan</a>';
            }
            else
            {
                $url =route('complain.show',$complain->complain_id);
                $button = '<a href="'.$url.'" class="btn btn-info">
                            <span class="glyphicon glyphicon-eye-open"></span> Papar</a>';
            }
        }
        else {    //{{--can view only--}}
            $url =route('complain.show',$complain->complain_id);
            $button = '<a href="'.$url.'" class="btn btn-info">
            <span class="glyphicon glyphicon-eye-open"></span> Papar</a>';

            }

        return $button;
    }

}