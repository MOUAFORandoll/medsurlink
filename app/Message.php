<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['body','sender_id','receiver_id','type'];
    protected $appends = ['selfMessage'];

    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getSelfMessageAttribute()
    {
        return $this->user_id === auth()->user()->id;
    }
}
