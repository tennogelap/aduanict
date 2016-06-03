<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainLevel extends Model
{
    protected $table = 'complains_level';
    protected $primaryKey = 'level_id';
    public $timestamps = false;
    /**
     * Relationship: 1 user has many Complain
     */
    public function comments()
    {
        return $this->hasMany('App\Complain');
    }
}
