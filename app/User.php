<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait; // add this trait to your user model

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'emp_id','email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relationship: 1 user has many Complain
     */
    public function comments()
    {
        return $this->hasMany('App\Complain');
    }
    public function verify_user_pk()
    {
        return $this->belongsTo('App\User');
    }
    public function userEmp_fk()
    {
        return $this->belongsTo('App\Employee','emp_id','emp_id');
    }
    public function attachment_pk()
    {
        return $this->morphMany('App\ComplainAttachment','attachable');
    }
    public function getFullNameAttribute()
    {
        $full_name = $this->name.' '.$this->lastname;
        return ucwords($full_name);
    }
}
