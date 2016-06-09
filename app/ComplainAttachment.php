<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainAttachment extends Model
{
    protected $table ='complain_attachments';
    protected $primaryKey ='attachment_id';
    public $timestamps = false;
//
    public function attachable()
    {
        return $this->morphTo();
    }
}
