<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $connection='oracle2';
    protected $table = 'spsm_employee';
    protected $primaryKey = 'emp_id';
    public $timestamps = false;
}
