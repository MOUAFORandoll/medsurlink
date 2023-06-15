<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        "name",
        "guard_name",
    ];

    protected $guard_name = 'web';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }

    public function feature()
    {
        return $this->belongsTo('App\Models\Feature');
    }
}
