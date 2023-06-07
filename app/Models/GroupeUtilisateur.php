<?php

namespace App\Models;

use App\Message;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class GroupeUtilisateur extends Model
{

    protected $table = 'groupe_utilisateurs';

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */

    protected $fillable = ["nom", "description"];

    public function messages()
    {
        return $this->morphToMany(Message::class, 'messageable');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }


}
