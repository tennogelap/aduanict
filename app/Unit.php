<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $connection='oracle2';
    protected $table = 'spsm_kod_unit';
}
