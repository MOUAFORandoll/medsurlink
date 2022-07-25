<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactAssurance extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contact_assurances';

    protected $fillable = [
        "nom",
        "prenom",
        "email",
        'pays',
        'telephone',
        'entreprise',
        'description'
    ];

}
