<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'spsm_employee';
    protected $primaryKey = 'PK_EMP_ID';
    public $timestamps = false;
}
