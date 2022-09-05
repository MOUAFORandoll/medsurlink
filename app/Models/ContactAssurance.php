<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ContactAssurance
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $email
 * @property string $pays
 * @property string $telephone
 * @property string $entreprise
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAssurance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAssurance newQuery()
 * @method static \Illuminate\Database\Query\Builder|ContactAssurance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAssurance query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAssurance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAssurance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAssurance whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAssurance whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAssurance whereEntreprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAssurance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAssurance whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAssurance wherePays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAssurance wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAssurance whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactAssurance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ContactAssurance withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ContactAssurance withoutTrashed()
 * @mixin \Eloquent
 */
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
