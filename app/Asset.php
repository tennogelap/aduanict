<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $connection='oracle2';
    protected $table = 'smict_master';
    protected $primaryKey = 'ict_no';
}
