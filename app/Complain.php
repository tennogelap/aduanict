<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $table = 'COMPLAINS';
    protected $primaryKey = 'COMPLAIN_ID';
    /**
     * Get complain belonging to the user.
     */
    public function user_fk()
    {
        return $this->belongsTo('App\User');
    }

    public function complain_level_fk()
    {
        return $this->belongsTo('App\ComplainLevel');
    }
    public function complain_source_fk()
    {
        return $this->belongsTo('App\ComplainSource');
    }
    public function complain_category_fk()
    {
        return $this->belongsTo('App\ComplainCategory');
    }
    public function complain_status_fk()
    {
    return $this->belongsTo('App\ComplainStatus');
    }
    public function action_user_fk()
    {
        return $this->belongsTo('App\User');
    }
    public function verify_user_fk()
    {
        return $this->belongsTo('App\User');
    }

}
