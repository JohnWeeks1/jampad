<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Youtube extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'title', 'path'
    ];

    public function user()
    {
        $this->belongsTo('App/User');
    }
}
