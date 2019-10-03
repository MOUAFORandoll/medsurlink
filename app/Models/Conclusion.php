<?php

namespace App\Models;

use App\Models\Traits\SlugRoutable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conclusion extends Model
{
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use SlugRoutable;
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'ReferenceAndTimestamp'
            ]
        ];
    }
    public function getReferenceAndTimestampAttribute() {
        return $this->reference . ' ' .Carbon::now()->timestamp;
    }
    protected $fillable = [
        "consultation_medecine_generale_id",
        "reference",
        "description",
        'slug'
    ];

    public function consultationMedecine(){
        return $this->belongsTo(ConsultationMedecineGenerale::class,'consultation_medecine_generale_id','id');
    }

    public function updateConclusionItem(){
        $isAuthor = checkIfIsAuthorOrIsAuthorized("Conclusion",$this->id,"create");
        $this['isAuthor'] = $isAuthor->getOriginalContent();
    }
}
