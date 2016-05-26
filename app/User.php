<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
    public function attachment_pk()
    {
        return $this->morphMany('App\ComplainAttachment','attachable');
    }
}
