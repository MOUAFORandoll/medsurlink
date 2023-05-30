<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Message
 *
 * @property-read mixed $self_message
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message query()
 * @mixin \Eloquent
 */
class Message extends Model
{
    protected $fillable = ['uuid', 'user_email','subject','creator_id','message_body'];
    protected $appends = ['selfMessage'];

    //
    public function user()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function getSelfMessageAttribute()
    {
        return $this->user_id === auth()->user()->id;
    }
}
