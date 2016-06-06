<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $connection='oracle2';
    protected $table = 'spsm_kod_unit';

    public function ketuaUnit_fk()
    {
        return $this->belongsTo('App\Employee','emp_id_ketua','emp_id');
    }
}
