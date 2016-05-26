<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainSource extends Model
{
    public function complain_source()
    {
        return $this->hasMany('App\Complain');
    }}
