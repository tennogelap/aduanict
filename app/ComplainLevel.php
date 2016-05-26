<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainLevel extends Model
{
    protected $table = 'COMPLAINS_LEVEL';
    protected $primaryKey = 'LEVEL_ID';
    public $timestamps = false;
    /**
     * Relationship: 1 user has many Complain
     */
    public function comments()
    {
        return $this->hasMany('App\Complain');
    }
}
