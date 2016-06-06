<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeDetail extends Model
{
    protected $connection='oracle2';
    protected $table = 'spsm_employee_detail';
    protected $primaryKey = 'emp_id';
    public $timestamps = false;

    public function empDetail_fk()
    {
        return $this->belongsTo('App\Employee','emp_id','emp_id');
    }
}
