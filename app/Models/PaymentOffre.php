<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PaymentOffre
 *
 * @property int $id
 * @property int $commande_id
 * @property int $souscripteur_id
 * @property string $date_payment
 * @property string $montant
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\CommandePackage $commande
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentOffre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentOffre newQuery()
 * @method static \Illuminate\Database\Query\Builder|PaymentOffre onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentOffre query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentOffre whereCommandeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentOffre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentOffre whereDatePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentOffre whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentOffre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentOffre whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentOffre whereSouscripteurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentOffre whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentOffre whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|PaymentOffre withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PaymentOffre withoutTrashed()
 * @mixin \Eloquent
 */
class PaymentOffre extends Model
{
    use SoftDeletes;

    protected $table = "offres_payments";

    protected $fillable = [
        "date_payment",
        "montant",
        'status',
        'commande_id',
        'souscripteur_id'
    ];
    public function commande(){
        return $this->belongsTo(CommandePackage::class,'commande_id','id');
    }
    public function souscripteur(){
        return $this->belongsTo(Souscripteur::class,'souscripteur_id','user_id');
    }
}
