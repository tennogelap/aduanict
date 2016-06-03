<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainAction extends Model
{
    public function complain(){
        return $this->belongsTo('App\Complain');
    }    
    public function user_action(){
        return $this->belongsTo('App\Employee','action_by','emp_id');
    }
    public function pengadu_fk(){
        return $this->belongsTo('App\User','user_emp_id','emp_id');
    }
    public function complain_action_status()
    {
        return $this->belongsTo('App\ComplainStatus','complain_status_id','status_id');
    }
}
