<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $table = 'complains';
    protected $primaryKey = 'complain_id';
    protected $fillable = [
        'complain_id'          , 'register_user_id'  , 'user_emp_id'       ,
        'complain_description' , 'complain_level_id' , 'complain_source_id',
        'unit_id'              , 'ict_no'            , 'lokasi_id'         ,
        'complain_category_id' , 'complain_status_id', 'assign_date'       ,
        'helpdesk_delay_reason', 'complete_date'     , 'delay_reason'      ,
        'action_comment'       , 'action_emp_id'     , 'action_date'       ,
        'reference'            , 'verify_emp_id'     , 'verify_date'       ,
        'user_comment'         , 'verify_status'     , 'created_at'        ,
        'updated_at'           , 'deleted_at'        , 'branch_id'
    ];

    public function setUserEmpIdAttribute($value)
    {
        $this->attributes['user_emp_id'] = (string) $value;
    }

    public function getStatusAttribute()
    {
        switch ($this->complain_status_id) {
            case 1:
            case '1':
                return '<span class="label label-warning">Baru</span>';
                break;

            case 2:
            case '2':
                return '<span class="label label-primary">Tindakan</span>';
                break;

            case 3:
            case '3':
                return '<span class="label label-primary">Sahkan (P)</span>';
                break;

            case 4:
            case '4':
                return '<span class="label label-primary">Sahkan (H)</span>';
                break;

            case 5:
            case '5':
                return '<span class="label label-success">Selesai</span>';
                break;

            case 6:
            case '6':
                return '<span class="label label-warning">Dihapuskan</span>';
                break;

            case 7:
            case '7':
                return '<span class="label label-primary">Agihan</span>';
                break;

            default:
                return '<span class="label label-danger">???</span>';
        }
    }

    /**
     * Get complain belonging to the user.
     */
    public function user_fk()
    {
        return $this->belongsTo('App\Employee');
    }
    public function regUser_fk()
    {
        return $this->belongsTo('App\User','register_user_id','emp_id');
    }
    public function onBehalf_fk()
    {
        return $this->belongsTo('App\User','user_emp_id','emp_id');
    }
    public function complain_level_fk()
    {
        return $this->belongsTo('App\ComplainLevel','complain_level_id','level_id');
    }
    public function complain_source_fk()
    {
        return $this->belongsTo('App\ComplainSource','complain_source_id','source_id');
    }
    public function complain_category_fk()
    {
        return $this->belongsTo('App\ComplainCategory','complain_category_id','category_id');
    }
    public function complain_status_fk()
    {
        return $this->belongsTo('App\ComplainStatus','complain_status_id','status_id');
    }
    public function complain_unit_fk()
    {
        return $this->belongsTo('App\Unit','unit_id','kod');
    }
    public function action_user_fk()
    {
        return $this->belongsTo('App\User','action_emp_id','emp_id');
    }
    public function verify_user_fk()
    {
        return $this->belongsTo('App\User');
    }
    public function asset_fk()
    {
        return $this->belongsTo('App\Asset');
    }
    public function assets_location_fk()
    {
        return $this->belongsTo('App\AssetsLocation','lokasi_id','location_id');
    }
    public function complain_action_fk()
    {
        return $this->hasMany('App\ComplainAction','complain_id','complain_id');
    }
    public function branch_fk()
    {
        return $this->belongsTo('App\Branch','branch_id','id');
    }
    public function employeeR_fk()
    {
        return $this->belongsTo('App\Employee','register_user_id','emp_id');
    }
    public function employeeU_fk()
    {
        return $this->belongsTo('App\Employee','user_emp_id','emp_id');
    }
    public function employeeT_fk()
    {
        return $this->belongsTo('App\Employee','action_emp_id','emp_id');
    }
    public function attachments()
    {
        return $this->morphMany('App\ComplainAttachment', 'attachable')
            ->orderBy('attachment_ext', 'asc')
            ->orderBy('attachment_id', 'asc');
    }
//    automatically guna masa store
    public function setComplainDescriptionAttribute($value)
    {
        $this->attributes['complain_description'] = strtolower($value);
    }
}
