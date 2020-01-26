<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'following_user_id',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'following_user_id');
    }
}
