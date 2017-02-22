<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name','user_id','json','response_time'];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
