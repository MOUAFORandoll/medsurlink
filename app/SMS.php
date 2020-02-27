<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed telephone
 * @property mixed message
 */
class SMS extends Model
{
    use Notifiable;

    protected $fillable = [
        'telephone', 'type', 'message'
    ];
}
