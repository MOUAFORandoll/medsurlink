<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * App\SMS
 *
 * @property mixed telephone
 * @property mixed message
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|SMS newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SMS newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SMS query()
 * @mixin \Eloquent
 */
class SMS extends Model
{
    use Notifiable;

    protected $fillable = [
        'telephone', 'type', 'message'
    ];
}
