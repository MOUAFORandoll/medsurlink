<?php

namespace App\Models;

use Antonrom\ModelChangesHistory\Traits\HasChangesHistory;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * App\Models\AffiliationSouscripteur
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $cim_id
 * @property string|null $type_contrat
 * @property string|null $nombre_paye
 * @property string|null $nombre_restant
 * @property string|null $montant
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $date_paiement
 * @property-read \App\Models\CommandePackage $commande
 * @property-read mixed $generate_slug
 * @property-read \App\Models\Souscripteur|null $souscripteur
 * @property-read \App\Models\Package|null $typeContrat
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur newQuery()
 * @method static \Illuminate\Database\Query\Builder|AffiliationSouscripteur onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur query()
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereCimId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereDatePaiement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereNombrePaye($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereNombreRestant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereTypeContrat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliationSouscripteur whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|AffiliationSouscripteur withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AffiliationSouscripteur withoutTrashed()
 * @mixin \Eloquent
 */
class AffiliationSouscripteur extends Model
{
    use Notifiable;
    use SoftDeletes;
    use Sluggable;
    use HasChangesHistory;

    protected $fillable = [
        'user_id',
        'cim_id',
        'type_contrat',
        'nombre_paye',
        'nombre_restant',
        'montant',
        'date_paiement',
        'slug',
    ];

    protected $slackChannels= [
        'test' => 'https://hooks.slack.com/services/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',
        'souscription' => 'https://hooks.slack.com/services/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'
    ];

    protected $slack_url = null;

    public function routeNotificationForSlack(){
        $env = strtolower(config('app.env'));
        if ($env == 'production')
            return $this->slackChannels["souscription"];
        else
            return $this->slackChannels["test"];
    }


    public function getSlackChannel(){
        $env = strtolower(config('app.env'));
        if ($env == 'production')
            return $this->setSlackUrl($this->setSlackUrl($this->slackChannels["souscription"]));
        else
            return $this->setSlackUrl($this->setSlackUrl($this->slackChannels["test"]));
    }


    /**
     * @param $url
     * @return $this
     */
    public function setSlackUrl($url){
        $this->slack_url = $url;

        return $this;
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'generateSlug'
            ]
        ];
    }

    public function getGenerateSlugAttribute() {
        return Str::random(20).' '.Carbon::now()->timestamp;
    }

    public function souscripteur(){
        return $this->belongsTo(Souscripteur::class,'user_id','user_id');
    }
    public function typeContrat(){
        return $this->belongsTo(Package::class,'type_contrat','id');
    }

    public function commande(){
        return $this->belongsTo(CommandePackage::class, 'cim_id');
    }
}
