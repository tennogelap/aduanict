<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $connection='oracle2';
    protected $table = 'SMICT_MASTER';
    protected $primaryKey = 'ICT_NO';
}
