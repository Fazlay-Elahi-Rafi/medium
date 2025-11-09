<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = ['follower_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class); // The person being followed
    }

    public function follower()
    {
        return $this->belongsTo(User::class); // The one who follows
    }
}
