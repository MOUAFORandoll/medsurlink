<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Message
 *
 * @property-read mixed $self_message
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message query()
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $uuid
 * @property string $user_email
 * @property string $subject
 * @property int $creator_id
 * @property string $message_body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GroupeUtilisateur[] $groupes
 * @property-read int|null $groupes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereMessageBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUserEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUuid($value)
 */
	class Message extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ActionMotif
 *
 * @property int $id
 * @property string $actionable_type
 * @property int $actionable_id
 * @property int $motif_id
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $actionable
 * @property-read mixed $action_and_timestamp
 * @property-read \App\Models\Motif $motifs
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif newQuery()
 * @method static \Illuminate\Database\Query\Builder|ActionMotif onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif whereActionableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif whereActionableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif whereMotifId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionMotif whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ActionMotif withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ActionMotif withoutTrashed()
 * @mixin \Eloquent
 */
	class ActionMotif extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Activite
 *
 * @property int $id
 * @property int|null $groupe_id
 * @property int|null $creator
 * @property string|null $statut
 * @property string|null $date_cloture
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $createur
 * @property-read mixed $dossier_and_timestamp
 * @property-read \App\Models\GroupeActivite|null $groupe
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ActiviteMission[] $missions
 * @property-read int|null $missions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Activite findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Activite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activite newQuery()
 * @method static \Illuminate\Database\Query\Builder|Activite onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Activite query()
 * @method static \Illuminate\Database\Eloquent\Builder|Activite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activite whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activite whereDateCloture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activite whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activite whereGroupeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activite whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activite whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Activite withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Activite withoutTrashed()
 * @mixin \Eloquent
 */
	class Activite extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ActiviteAmaPatient
 *
 * @property int $id
 * @property int|null $activite_ama_id
 * @property int $etablissement_id
 * @property string|null $commentaire
 * @property int|null $creator
 * @property int|null $patient_id
 * @property string|null $statut
 * @property string|null $date_cloture
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $affiliation_id
 * @property int|null $ligne_temps_id
 * @property-read ActivitesAma|null $activitesAma
 * @property-read \App\Models\Affiliation|null $affiliation
 * @property-read User|null $createur
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DelaiOperation[] $delai_operations
 * @property-read int|null $delai_operations_count
 * @property-read \App\Models\EtablissementExercice $etablissement
 * @property-read mixed $dossier_and_timestamp
 * @property-read \App\Models\LigneDeTemps|null $ligne_temps
 * @property-read \App\Models\Motif $motif
 * @property-read \App\Models\Patient|null $patient
 * @property-read User $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient newQuery()
 * @method static \Illuminate\Database\Query\Builder|ActiviteAmaPatient onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereActiviteAmaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereAffiliationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereCommentaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereDateCloture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereLigneTempsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ActiviteAmaPatient withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ActiviteAmaPatient withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteAmaPatient activiteAmaSemaineMoisAnnee($intervalle_debut, $intervalle_fin)
 */
	class ActiviteAmaPatient extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ActiviteMission
 *
 * @property int $id
 * @property int|null $activite_id
 * @property int|null $dossier_medical_id
 * @property int|null $creator
 * @property int|null $description
 * @property string|null $commentaire
 * @property string|null $nom_partenaire
 * @property string|null $nom_activite
 * @property string|null $slug
 * @property string|null $statut
 * @property string|null $date_cloture
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\ActivitesAma $activite
 * @property-read User|null $createur
 * @property-read \App\Models\DossierMedical|null $dossier
 * @property-read mixed $dossier_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission newQuery()
 * @method static \Illuminate\Database\Query\Builder|ActiviteMission onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission whereActiviteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission whereCommentaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission whereDateCloture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission whereNomActivite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission whereNomPartenaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActiviteMission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ActiviteMission withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ActiviteMission withoutTrashed()
 * @mixin \Eloquent
 */
	class ActiviteMission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ActivitesAma
 *
 * @property int $id
 * @property string $description_fr
 * @property string $description_en
 * @property string|null $type
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|ActiviteAmaPatient[] $activites
 * @property-read int|null $activites_count
 * @property-read mixed $dossier_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma newQuery()
 * @method static \Illuminate\Database\Query\Builder|ActivitesAma onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma whereDescriptionFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesAma whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ActivitesAma withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ActivitesAma withoutTrashed()
 * @mixin \Eloquent
 */
	class ActivitesAma extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ActivitesControle
 *
 * @property int $id
 * @property int $patient_id
 * @property int|null $creator
 * @property string|null $statut
 * @property int|null $activite_id
 * @property string|null $commentaire
 * @property string|null $date_cloture
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $affiliation_id
 * @property int|null $ligne_temps_id
 * @property int|null $etablissement_id
 * @property-read ActivitesMedecinReferent|null $activitesMedecinReferent
 * @property-read \App\Models\Affiliation|null $affiliation
 * @property-read User|null $createur
 * @property-read \App\Models\EtablissementExercice|null $etablissement
 * @property-read mixed $dossier_and_timestamp
 * @property-read LigneDeTemps|null $ligne_temps
 * @property-read \App\Models\Motif $motif
 * @property-read \App\Models\Patient $patient
 * @property-read User $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle newQuery()
 * @method static \Illuminate\Database\Query\Builder|ActivitesControle onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle whereActiviteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle whereAffiliationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle whereCommentaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle whereDateCloture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle whereLigneTempsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ActivitesControle withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ActivitesControle withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesControle activiteMedControleMoisAnnee($intervalle_debut, $intervalle_fin)
 */
	class ActivitesControle extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ActivitesMedecinReferent
 *
 * @property int $id
 * @property string $description_fr
 * @property string $description_en
 * @property string $type
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ActivitesControle[] $activites
 * @property-read int|null $activites_count
 * @property-read mixed $dossier_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent newQuery()
 * @method static \Illuminate\Database\Query\Builder|ActivitesMedecinReferent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent whereDescriptionFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitesMedecinReferent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ActivitesMedecinReferent withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ActivitesMedecinReferent withoutTrashed()
 * @mixin \Eloquent
 */
	class ActivitesMedecinReferent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Affiliation
 *
 * @property int $id
 * @property int $patient_id
 * @property string $nom
 * @property string $date_debut
 * @property string|null $date_fin
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property int|null $souscripteur_id
 * @property int|null $package_id
 * @property int|null $paiement_id
 * @property string|null $date_signature
 * @property string $status_contrat
 * @property string $status_paiement
 * @property int $renouvelle
 * @property int $expire
 * @property string $code_contrat
 * @property int $niveau_urgence
 * @property int $nombre_envois_email
 * @property int $expire_email
 * @property string|null $plainte
 * @property string|null $contact_firstName
 * @property string|null $contact_name
 * @property string|null $contact_phone
 * @property string|null $paye_par_affilie
 * @property int $selected
 * @property-read \App\Models\Cloture|null $cloture
 * @property-read mixed $nom_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\Antonrom\ModelChangesHistory\Models\Change[] $historyChangesMorph
 * @property-read int|null $history_changes_morph_count
 * @property-read \Antonrom\ModelChangesHistory\Models\Change|null $latestChangeMorph
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LigneDeTemps[] $ligneTemps
 * @property-read int|null $ligne_temps_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Motif[] $motifs
 * @property-read int|null $motifs_count
 * @property-read \App\Models\Package|null $package
 * @property-read \App\Models\Patient $patient
 * @property-read \App\Models\Souscripteur|null $souscripteur
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation newQuery()
 * @method static \Illuminate\Database\Query\Builder|Affiliation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereCodeContrat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereContactFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereDateDebut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereDateFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereDateSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereExpire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereExpireEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereNiveauUrgence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereNombreEnvoisEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation wherePaiementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation wherePayeParAffilie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation wherePlainte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereRenouvelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereSelected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereSouscripteurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereStatusContrat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereStatusPaiement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Affiliation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Affiliation withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Affiliation whereDateBetween($fieldName, $fromDate, $todate)
 */
	class Affiliation extends \Eloquent {}
}

namespace App\Models{
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Antonrom\ModelChangesHistory\Models\Change[] $historyChangesMorph
 * @property-read int|null $history_changes_morph_count
 * @property-read \Antonrom\ModelChangesHistory\Models\Change|null $latestChangeMorph
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 */
	class AffiliationSouscripteur extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Alerte
 *
 * @property int $id
 * @property string|null $uuid
 * @property int $patient_id
 * @property int|null $medecin_id
 * @property int $statut_id
 * @property int $niveau_urgence_id
 * @property int|null $teleconsultation_id
 * @property int $creator_id
 * @property string $plainte
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\User $creator
 * @property-read mixed $audio1
 * @property-read mixed $audio
 * @property-read mixed $size
 * @property-read \Illuminate\Database\Eloquent\Collection|\Antonrom\ModelChangesHistory\Models\Change[] $historyChangesMorph
 * @property-read int|null $history_changes_morph_count
 * @property-read \Antonrom\ModelChangesHistory\Models\Change|null $latestChangeMorph
 * @property-read \App\User|null $medecin
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\User $patient
 * @method static \Illuminate\Database\Eloquent\Builder|Alerte newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alerte newQuery()
 * @method static \Illuminate\Database\Query\Builder|Alerte onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Alerte query()
 * @method static \Illuminate\Database\Eloquent\Builder|Alerte whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alerte whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alerte whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alerte whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alerte whereMedecinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alerte whereNiveauUrgenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alerte wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alerte wherePlainte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alerte whereStatutId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alerte whereTeleconsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alerte whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alerte whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|Alerte withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Alerte withoutTrashed()
 */
	class Alerte extends \Eloquent implements \Spatie\MediaLibrary\HasMedia\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Allergie
 *
 * @property int $id
 * @property string $description
 * @property string|null $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DossierMedical[] $dossiers
 * @property-read int|null $dossiers_count
 * @property-read mixed $description_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie newQuery()
 * @method static \Illuminate\Database\Query\Builder|Allergie onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Allergie withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Allergie withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Allergie allergieSemaineMoisAnnee($intervalle_debut, $intervalle_fin)
 */
	class Allergie extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Anamnese
 *
 * @property int $id
 * @property string|null $fr_description
 * @property string|null $en_description
 * @property string|null $reference
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $dossier_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese newQuery()
 * @method static \Illuminate\Database\Query\Builder|Anamnese onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese query()
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese whereEnDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese whereFrDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anamnese whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Anamnese withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Anamnese withoutTrashed()
 * @mixin \Eloquent
 */
	class Anamnese extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Antecedent
 *
 * @property int $id
 * @property int $dossier_medical_id
 * @property string $description
 * @property string|null $date
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $slug
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read mixed $type_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent newQuery()
 * @method static \Illuminate\Database\Query\Builder|Antecedent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent query()
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Antecedent withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Antecedent withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Antecedent antecedentsSemaineMoisAnnee($intervalle_debut, $intervalle_fin)
 */
	class Antecedent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Assistante
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $creator
 * @property int|null $etablissement_id
 * @property string $sexe
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EtablissementExercice|null $etablissements
 * @property-read mixed $reference_and_timestamp
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante newQuery()
 * @method static \Illuminate\Database\Query\Builder|Assistante onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante query()
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistante whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Assistante withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Assistante withoutTrashed()
 * @mixin \Eloquent
 */
	class Assistante extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Association
 *
 * @property int $id
 * @property int|null $creator
 * @property int|null $responsable
 * @property string|null $region
 * @property string|null $ville
 * @property string|null $nom
 * @property string|null $telephone
 * @property string|null $localisation
 * @property string|null $email
 * @property string|null $contact
 * @property string|null $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read User|null $author
 * @property-read mixed $dossier_and_timestamp
 * @property-read User|null $userResponsable
 * @method static \Illuminate\Database\Eloquent\Builder|Association findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Association newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Association newQuery()
 * @method static \Illuminate\Database\Query\Builder|Association onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Association query()
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereLocalisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereResponsable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Association whereVille($value)
 * @method static \Illuminate\Database\Query\Builder|Association withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Association withoutTrashed()
 * @mixin \Eloquent
 */
	class Association extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Auteur
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $auteurable_type
 * @property int|null $auteurable_id
 * @property string|null $operationable_type
 * @property int|null $operationable_id
 * @property string $action
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $patient_id
 * @property-read Model|\Eloquent $auteurable
 * @property-read Model|\Eloquent $operationable
 * @property-read User|null $patient
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur newQuery()
 * @method static \Illuminate\Database\Query\Builder|Auteur onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur query()
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereAuteurableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereAuteurableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereOperationableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereOperationableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auteur whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Auteur withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Auteur withoutTrashed()
 * @mixin \Eloquent
 */
	class Auteur extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Avis
 *
 * @property int $id
 * @property int $dossier_medical_id
 * @property string|null $objet
 * @property string|null $slug
 * @property string $description
 * @property int|null $creator
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $creer_lien
 * @property string $code_urgence
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationFichier[] $consultationFichier
 * @property-read int|null $consultation_fichier_count
 * @property-read User|null $createur
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read mixed $name_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MedecinAvis[] $medecinAvis
 * @property-read int|null $medecin_avis_count
 * @method static \Illuminate\Database\Eloquent\Builder|Avis findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Avis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Avis newQuery()
 * @method static \Illuminate\Database\Query\Builder|Avis onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Avis query()
 * @method static \Illuminate\Database\Eloquent\Builder|Avis whereCodeUrgence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avis whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avis whereCreerLien($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avis whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avis whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avis whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avis whereObjet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avis whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Avis whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Avis withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Avis withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Avis avisSemaineMoisAnnee($intervalle_debut, $intervalle_fin)
 */
	class Avis extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cardiologie
 *
 * @property int $id
 * @property int $etablissement_id
 * @property int $dossier_medical_id
 * @property string|null $date_consultation
 * @property string|null $anamnese
 * @property string|null $facteur_de_risque
 * @property string|null $profession
 * @property string|null $situation_familiale
 * @property string $nbre_enfant
 * @property string $tabac
 * @property string $alcool
 * @property string|null $autres
 * @property string|null $conclusion
 * @property string|null $conduite_a_tenir
 * @property string|null $examen_clinique
 * @property string|null $rendez_vous
 * @property string|null $archieved_at
 * @property string|null $passed_at
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $nbreAnnee
 * @property string $nbreCigarette
 * @property int|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ActionMotif[] $actions
 * @property-read int|null $actions_count
 * @property-read User|null $author
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read \App\Models\EtablissementExercice $etablissement
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExamenCardio[] $examenCardios
 * @property-read int|null $examen_cardios_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read mixed $dossier_and_timestamp
 * @property-read \App\Models\LigneDeTemps $ligneDeTemps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contributeurs[] $operationables
 * @property-read int|null $operationables_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ParametreCommun[] $parametresCommun
 * @property-read int|null $parametres_commun_count
 * @property-read \App\Models\RendezVous|null $rdv
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie newQuery()
 * @method static \Illuminate\Database\Query\Builder|Cardiologie onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereAlcool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereAnamnese($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereArchievedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereAutres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereConclusion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereConduiteATenir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereDateConsultation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereExamenClinique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereFacteurDeRisque($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereNbreAnnee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereNbreCigarette($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereNbreEnfant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereRendezVous($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereSituationFamiliale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereTabac($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cardiologie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Cardiologie withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Cardiologie withoutTrashed()
 * @mixin \Eloquent
 */
	class Cardiologie extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CategoriePrestation
 *
 * @property int $id
 * @property string $nom
 * @property string $slug
 * @property int|null $creator
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $name_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Prestation[] $prestations
 * @property-read int|null $prestations_count
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriePrestation findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriePrestation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriePrestation newQuery()
 * @method static \Illuminate\Database\Query\Builder|CategoriePrestation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriePrestation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriePrestation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriePrestation whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriePrestation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriePrestation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriePrestation whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriePrestation whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriePrestation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CategoriePrestation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CategoriePrestation withoutTrashed()
 * @mixin \Eloquent
 */
	class CategoriePrestation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Categories
 *
 * @property int $id
 * @property string|null $nom
 * @property string|null $icon
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $name_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Suivi[] $suivis
 * @property-read int|null $suivis_count
 * @method static \Illuminate\Database\Eloquent\Builder|Categories findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categories newQuery()
 * @method static \Illuminate\Database\Query\Builder|Categories onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Categories query()
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categories whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Categories withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Categories withoutTrashed()
 * @mixin \Eloquent
 */
	class Categories extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cloture
 *
 * @property int $id
 * @property int $cloturable_id
 * @property string $cloturable_type
 * @property string|null $automatique
 * @property string|null $ama
 * @property string|null $medecin_referent
 * @property string|null $gestionnaire
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Model|\Eloquent $cloturable
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture newQuery()
 * @method static \Illuminate\Database\Query\Builder|Cloture onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereAma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereAutomatique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereCloturableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereCloturableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereGestionnaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereMedecinReferent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cloture whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Cloture withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Cloture withoutTrashed()
 * @mixin \Eloquent
 */
	class Cloture extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CommandePackage
 *
 * @property int $id
 * @property int $offres_packages_id
 * @property int $souscripteur_id
 * @property string $quantite
 * @property string $date_commande
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Package $offres_package
 * @property-read \App\Models\Souscripteur $souscripteur
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage newQuery()
 * @method static \Illuminate\Database\Query\Builder|CommandePackage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage query()
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage whereDateCommande($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage whereOffresPackagesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage whereQuantite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage whereSouscripteurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommandePackage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CommandePackage withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CommandePackage withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PaymentOffre[] $paymentOffres
 * @property-read int|null $payment_offres_count
 */
	class CommandePackage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Comptable
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $creator
 * @property int|null $etablissement_id
 * @property string $sexe
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EtablissementExercice|null $etablissements
 * @property-read mixed $reference_and_timestamp
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Comptable findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Comptable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comptable newQuery()
 * @method static \Illuminate\Database\Query\Builder|Comptable onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Comptable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comptable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comptable whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comptable whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comptable whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comptable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comptable whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comptable whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comptable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comptable whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Comptable withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Comptable withoutTrashed()
 * @mixin \Eloquent
 */
	class Comptable extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CompteRenduOperatoire
 *
 * @property int $id
 * @property int $etablissement_id
 * @property int $dossier_medical_id
 * @property int|null $creator
 * @property string|null $type_intervention
 * @property string|null $histoire_clinique
 * @property string|null $date_intervention
 * @property string|null $chirugiens
 * @property string|null $aides
 * @property string|null $circulants
 * @property string|null $anesthesistes
 * @property string|null $type_anesthesie
 * @property string|null $description
 * @property string|null $traitement_post_operatoire
 * @property string|null $archieved_at
 * @property string|null $passed_at
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $createur
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read \App\Models\EtablissementExercice $etablissement
 * @property-read mixed $dossier_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire newQuery()
 * @method static \Illuminate\Database\Query\Builder|CompteRenduOperatoire onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereAides($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereAnesthesistes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereArchievedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereChirugiens($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereCirculants($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereDateIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereHistoireClinique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereTraitementPostOperatoire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereTypeAnesthesie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereTypeIntervention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CompteRenduOperatoire withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CompteRenduOperatoire withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|CompteRenduOperatoire compteRenduSemaineMoisAnnee($intervalle_debut, $intervalle_fin)
 */
	class CompteRenduOperatoire extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Conclusion
 *
 * @property int $id
 * @property int $consultation_medecine_generale_id
 * @property string|null $reference
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $slug
 * @property-read \App\Models\ConsultationMedecineGenerale $consultationMedecine
 * @property-read mixed $reference_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion newQuery()
 * @method static \Illuminate\Database\Query\Builder|Conclusion onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion whereConsultationMedecineGeneraleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conclusion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Conclusion withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Conclusion withoutTrashed()
 * @mixin \Eloquent
 */
	class Conclusion extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ConduiteTenir
 *
 * @property-read \App\Models\LigneDeTemps $ligneDeTemps
 * @method static \Illuminate\Database\Eloquent\Builder|ConduiteTenir newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConduiteTenir newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConduiteTenir query()
 * @mixin \Eloquent
 */
	class ConduiteTenir extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ConsultationExamenValidation
 *
 * @property int $id
 * @property int|null $souscripteur_id
 * @property int|null $examen_complementaire_id
 * @property int|null $medecin_id
 * @property int|null $medecin_control_id
 * @property int|null $ligne_de_temps_id
 * @property int|null $etat_validation_medecin
 * @property int|null $etat_validation_souscripteur
 * @property string|null $date_validation_medecin
 * @property string|null $date_validation_souscripteur
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $consultation_general_id
 * @property int|null $version
 * @property int|null $etablissement_id
 * @property-read \App\Models\ConsultationMedecineGenerale|null $consultation
 * @property-read \App\Models\EtablissementExercice|null $etablissement
 * @property-read \App\Models\ExamenComplementaire|null $examenComplementaire
 * @property-read \Illuminate\Database\Eloquent\Collection|\Antonrom\ModelChangesHistory\Models\Change[] $historyChangesMorph
 * @property-read int|null $history_changes_morph_count
 * @property-read \Antonrom\ModelChangesHistory\Models\Change|null $latestChangeMorph
 * @property-read \App\Models\LigneDeTemps|null $ligneDeTemps
 * @property-read \App\Models\Souscripteur|null $souscripteur
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereConsultationGeneralId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereDateValidationMedecin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereDateValidationSouscripteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereEtatValidationMedecin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereEtatValidationSouscripteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereExamenComplementaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereLigneDeTempsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereMedecinControlId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereMedecinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereSouscripteurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationExamenValidation whereVersion($value)
 * @mixin \Eloquent
 */
	class ConsultationExamenValidation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ConsultationFichier
 *
 * @property int $id
 * @property string $name
 * @property int $dossier_medical_id
 * @property int $etablissement_id
 * @property int $creator
 * @property string|null $user_id
 * @property string|null $passed_at
 * @property string|null $archieved_at
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $date_consultation
 * @property string|null $praticien_externe
 * @property string|null $consultation_externe
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read \App\Models\EtablissementExercice $etablissement
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read mixed $dossier_and_timestamp
 * @property-read User|null $praticien
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier newQuery()
 * @method static \Illuminate\Database\Query\Builder|ConsultationFichier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereArchievedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereConsultationExterne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereDateConsultation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier wherePraticienExterne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|ConsultationFichier withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ConsultationFichier withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationFichier consultationFichierSemaineMoisAnnee($intervalle_debut, $intervalle_fin)
 */
	class ConsultationFichier extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ConsultationMedecineGenerale
 *
 * @property int $id
 * @property int $dossier_medical_id
 * @property string|null $date_consultation
 * @property string|null $anamese
 * @property string|null $mode_de_vie
 * @property string|null $examen_clinique
 * @property string|null $examen_complementaire
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string|null $archieved_at
 * @property string|null $passed_at
 * @property string|null $traitement_propose
 * @property string|null $profession
 * @property string|null $situation_familiale
 * @property string $nbre_enfant
 * @property string $tabac
 * @property string $alcool
 * @property string|null $autres
 * @property int|null $etablissement_id
 * @property string|null $file
 * @property string $nbreAnnee
 * @property string $nbreCigarette
 * @property int|null $creator
 * @property string|null $information
 * @property array $examens
 * @property array $diasgnostic
 * @property array $nutrition
 * @property array $lipide
 * @property array $glucide
 * @property array $anamneses
 * @property string|null $anthropometrie
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\TraitementPropose[] $traitements
 * @property string|null $complementaire
 * @property int|null $ligne_de_temps_id
 * @property-read User|null $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Conclusion[] $conclusions
 * @property-read int|null $conclusions_count
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read \App\Models\EtablissementExercice|null $etablissement
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read mixed $dossier_and_timestamp
 * @property-read \App\Models\LigneDeTemps|null $ligneDeTemps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Motif[] $motifs
 * @property-read int|null $motifs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Motif[] $n_motifs
 * @property-read int|null $n_motifs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contributeurs[] $operationables
 * @property-read int|null $operationables_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ParametreCommun[] $parametresCommun
 * @property-read int|null $parametres_commun_count
 * @property-read \App\Models\RendezVous|null $rdv
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RendezVous[] $rendez_vous
 * @property-read int|null $rendez_vous_count
 * @property-read int|null $traitements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationExamenValidation[] $validations
 * @property-read int|null $validations_count
 * @property-read \App\Models\VersionValidation|null $versionValidation
 * @method static Builder|ConsultationMedecineGenerale findSimilarSlugs($attribute, $config, $slug)
 * @method static Builder|ConsultationMedecineGenerale newModelQuery()
 * @method static Builder|ConsultationMedecineGenerale newQuery()
 * @method static \Illuminate\Database\Query\Builder|ConsultationMedecineGenerale onlyTrashed()
 * @method static Builder|ConsultationMedecineGenerale orderByDateConsultation()
 * @method static Builder|ConsultationMedecineGenerale passed()
 * @method static Builder|ConsultationMedecineGenerale query()
 * @method static Builder|ConsultationMedecineGenerale whereAlcool($value)
 * @method static Builder|ConsultationMedecineGenerale whereAnamese($value)
 * @method static Builder|ConsultationMedecineGenerale whereAnamneses($value)
 * @method static Builder|ConsultationMedecineGenerale whereAnthropometrie($value)
 * @method static Builder|ConsultationMedecineGenerale whereArchievedAt($value)
 * @method static Builder|ConsultationMedecineGenerale whereAutres($value)
 * @method static Builder|ConsultationMedecineGenerale whereComplementaire($value)
 * @method static Builder|ConsultationMedecineGenerale whereCreatedAt($value)
 * @method static Builder|ConsultationMedecineGenerale whereCreator($value)
 * @method static Builder|ConsultationMedecineGenerale whereDateConsultation($value)
 * @method static Builder|ConsultationMedecineGenerale whereDeletedAt($value)
 * @method static Builder|ConsultationMedecineGenerale whereDiasgnostic($value)
 * @method static Builder|ConsultationMedecineGenerale whereDossierMedicalId($value)
 * @method static Builder|ConsultationMedecineGenerale whereEtablissementId($value)
 * @method static Builder|ConsultationMedecineGenerale whereExamenClinique($value)
 * @method static Builder|ConsultationMedecineGenerale whereExamenComplementaire($value)
 * @method static Builder|ConsultationMedecineGenerale whereExamens($value)
 * @method static Builder|ConsultationMedecineGenerale whereFile($value)
 * @method static Builder|ConsultationMedecineGenerale whereGlucide($value)
 * @method static Builder|ConsultationMedecineGenerale whereId($value)
 * @method static Builder|ConsultationMedecineGenerale whereInformation($value)
 * @method static Builder|ConsultationMedecineGenerale whereLigneDeTempsId($value)
 * @method static Builder|ConsultationMedecineGenerale whereLipide($value)
 * @method static Builder|ConsultationMedecineGenerale whereModeDeVie($value)
 * @method static Builder|ConsultationMedecineGenerale whereNbreAnnee($value)
 * @method static Builder|ConsultationMedecineGenerale whereNbreCigarette($value)
 * @method static Builder|ConsultationMedecineGenerale whereNbreEnfant($value)
 * @method static Builder|ConsultationMedecineGenerale whereNutrition($value)
 * @method static Builder|ConsultationMedecineGenerale wherePassedAt($value)
 * @method static Builder|ConsultationMedecineGenerale whereProfession($value)
 * @method static Builder|ConsultationMedecineGenerale whereSituationFamiliale($value)
 * @method static Builder|ConsultationMedecineGenerale whereSlug($value)
 * @method static Builder|ConsultationMedecineGenerale whereTabac($value)
 * @method static Builder|ConsultationMedecineGenerale whereTraitementPropose($value)
 * @method static Builder|ConsultationMedecineGenerale whereTraitements($value)
 * @method static Builder|ConsultationMedecineGenerale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ConsultationMedecineGenerale withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ConsultationMedecineGenerale withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $diagnostic_complementaire
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationMedecineGenerale consultationSemaineMoisAnnee($intervalle_debut, $intervalle_fin)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationMedecineGenerale whereDiagnosticComplementaire($value)
 */
	class ConsultationMedecineGenerale extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ConsultationObstetrique
 *
 * @property int $id
 * @property int $dossier_medical_id
 * @property string $date_creation
 * @property int $numero_grossesse
 * @property string $ddr
 * @property string|null $antecedent_conjoint
 * @property string|null $serologie
 * @property string|null $groupe_sanguin
 * @property string|null $statut_socio_familiale
 * @property string|null $assuetudes
 * @property string|null $antecedent_de_transfusion
 * @property string|null $facteur_de_risque
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string|null $archieved_at
 * @property string|null $passed_at
 * @property string $pcr_gonocoque
 * @property string $pcr_chlamydia
 * @property string $rcc
 * @property string $glycemie
 * @property string $emu
 * @property string $tsh
 * @property string $anti_tpo
 * @property string $ft4
 * @property string $ft3
 * @property string|null $attention
 * @property string|null $info_prise_en_charge
 * @property int|null $etablissement_id
 * @property string $t1
 * @property string $nle_anle
 * @property string $sexe
 * @property int|null $creator
 * @property-read User|null $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationPrenatale[] $consultationPrenatales
 * @property-read int|null $consultation_prenatales_count
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Echographie[] $echographies
 * @property-read int|null $echographies_count
 * @property-read \App\Models\EtablissementExercice|null $etablissement
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read mixed $dossier_and_timestamp
 * @property-read \App\Models\LigneDeTemps $ligneDeTemps
 * @property-read \App\Models\RendezVous|null $rdv
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique newQuery()
 * @method static \Illuminate\Database\Query\Builder|ConsultationObstetrique onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique orderByDateDeRendezVous()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereAntecedentConjoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereAntecedentDeTransfusion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereAntiTpo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereArchievedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereAssuetudes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereAttention($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereDateCreation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereDdr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereEmu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereFacteurDeRisque($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereFt3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereFt4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereGlycemie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereGroupeSanguin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereInfoPriseEnCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereNleAnle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereNumeroGrossesse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique wherePcrChlamydia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique wherePcrGonocoque($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereRcc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereSerologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereStatutSocioFamiliale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereT1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereTsh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationObstetrique whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ConsultationObstetrique withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ConsultationObstetrique withoutTrashed()
 * @mixin \Eloquent
 */
	class ConsultationObstetrique extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ConsultationPrenatale
 *
 * @property int $id
 * @property int $consultation_obstetrique_id
 * @property string $date_creation
 * @property string $type_de_consultation
 * @property string|null $plaintes
 * @property string|null $recommandations
 * @property string|null $examen_clinique
 * @property string|null $examen_complementaire
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string|null $archieved_at
 * @property string|null $passed_at
 * @property-read \App\Models\ConsultationObstetrique $consultationObstetrique
 * @property-read mixed $type_de_consultation_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ParametreObstetrique[] $parametresObstetrique
 * @property-read int|null $parametres_obstetrique_count
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale newQuery()
 * @method static \Illuminate\Database\Query\Builder|ConsultationPrenatale onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereArchievedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereConsultationObstetriqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereDateCreation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereExamenClinique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereExamenComplementaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale wherePlaintes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereRecommandations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereTypeDeConsultation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationPrenatale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ConsultationPrenatale withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ConsultationPrenatale withoutTrashed()
 * @mixin \Eloquent
 */
	class ConsultationPrenatale extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ConsultationTraitement
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationTraitement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationTraitement newQuery()
 * @method static \Illuminate\Database\Query\Builder|ConsultationTraitement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationTraitement query()
 * @method static \Illuminate\Database\Query\Builder|ConsultationTraitement withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ConsultationTraitement withoutTrashed()
 * @mixin \Eloquent
 */
	class ConsultationTraitement extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ConsultationType
 *
 * @property int $id
 * @property int $profession_id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property-read mixed $name_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MedecinControle[] $medecinsControle
 * @property-read int|null $medecins_controle_count
 * @property-read \App\Models\Profession $profession
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType newQuery()
 * @method static \Illuminate\Database\Query\Builder|ConsultationType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType whereProfessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConsultationType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ConsultationType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ConsultationType withoutTrashed()
 * @mixin \Eloquent
 */
	class ConsultationType extends \Eloquent {}
}

namespace App\Models{
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
	class ContactAssurance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Contributeurs
 *
 * @property int $id
 * @property string|null $contributable_type
 * @property int|null $contributable_id
 * @property string|null $operationable_type
 * @property int|null $operationable_id
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Model|\Eloquent $contributable
 * @property-read mixed $type_and_timestamp
 * @property-read Model|\Eloquent $operationable
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs newQuery()
 * @method static \Illuminate\Database\Query\Builder|Contributeurs onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereContributableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereContributableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereOperationableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereOperationableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contributeurs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Contributeurs withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Contributeurs withoutTrashed()
 * @mixin \Eloquent
 */
	class Contributeurs extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DelaiOperation
 *
 * @property int $id
 * @property int|null $patient_id
 * @property int $delai_operationable_id
 * @property string $delai_operationable_type
 * @property string $date_heure_prevue
 * @property string $date_heure_effectif
 * @property string|null $observation
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Model|\Eloquent $delai_operationable
 * @property-read mixed $patient_id_and_timestamp
 * @property-read \App\Models\Patient|null $patient
 * @property-read \App\Models\TypeOperation $type_observation
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation newQuery()
 * @method static \Illuminate\Database\Query\Builder|DelaiOperation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation query()
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereDateHeureEffectif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereDateHeurePrevue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereDelaiOperationableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereDelaiOperationableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereObservation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DelaiOperation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|DelaiOperation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|DelaiOperation withoutTrashed()
 * @mixin \Eloquent
 */
	class DelaiOperation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DiagnosticValidation
 *
 * @property-read \App\Models\LigneDeTemps $ligneDeTemps
 * @property-read \App\Models\Praticien $medecin
 * @property-read \App\Models\MedecinControle $medecinControl
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosticValidation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosticValidation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiagnosticValidation query()
 * @mixin \Eloquent
 */
	class DiagnosticValidation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Dictionnaire
 *
 * @property int $id
 * @property string|null $fr_description
 * @property string|null $en_description
 * @property string|null $reference
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $dossier_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OffrePackageItem[] $packages
 * @property-read int|null $packages_count
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire newQuery()
 * @method static \Illuminate\Database\Query\Builder|Dictionnaire onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire whereEnDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire whereFrDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionnaire whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Dictionnaire withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Dictionnaire withoutTrashed()
 * @mixin \Eloquent
 */
	class Dictionnaire extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DossierAllergie
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DossierAllergie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DossierAllergie newQuery()
 * @method static \Illuminate\Database\Query\Builder|DossierAllergie onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DossierAllergie query()
 * @method static \Illuminate\Database\Query\Builder|DossierAllergie withTrashed()
 * @method static \Illuminate\Database\Query\Builder|DossierAllergie withoutTrashed()
 * @mixin \Eloquent
 */
	class DossierAllergie extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DossierMedical
 *
 * @property int $id
 * @property int $patient_id
 * @property string $date_de_creation
 * @property string $numero_dossier
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Allergie[] $allergies
 * @property-read int|null $allergies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Antecedent[] $antecedents
 * @property-read int|null $antecedents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Avis[] $avis
 * @property-read int|null $avis_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cardiologie[] $cardiologies
 * @property-read int|null $cardiologies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CompteRenduOperatoire[] $comptesRenduOperatoire
 * @property-read int|null $comptes_rendu_operatoire_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationFichier[] $consultationsManuscrites
 * @property-read int|null $consultations_manuscrites_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationMedecineGenerale[] $consultationsMedecine
 * @property-read int|null $consultations_medecine_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationObstetrique[] $consultationsObstetrique
 * @property-read int|null $consultations_obstetrique_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PatientSouscripteur[] $financeurs
 * @property-read int|null $financeurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Hospitalisation[] $hospitalisations
 * @property-read int|null $hospitalisations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Kinesitherapie[] $kinesitherapies
 * @property-read int|null $kinesitherapies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ordonance[] $ordonances
 * @property-read int|null $ordonances_count
 * @property-read \App\Models\Package $package
 * @property-read \App\Models\Patient $patient
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResultatImagerie[] $resultatsImagerie
 * @property-read int|null $resultats_imagerie_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ResultatLabo[] $resultatsLabo
 * @property-read int|null $resultats_labo_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TraitementActuel[] $traitements
 * @property-read int|null $traitements_count
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical newQuery()
 * @method static \Illuminate\Database\Query\Builder|DossierMedical onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical query()
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical whereDateDeCreation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical whereNumeroDossier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DossierMedical whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|DossierMedical withTrashed()
 * @method static \Illuminate\Database\Query\Builder|DossierMedical withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Affiliation[] $affiliations
 * @property-read int|null $affiliations_count
 */
	class DossierMedical extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Echographie
 *
 * @property int $id
 * @property int $consultation_obstetrique_id
 * @property string $date_creation
 * @property string $type
 * @property string $ddr
 * @property string $dpa
 * @property int|null $semaine_amenorrhee
 * @property string|null $biometrie
 * @property string|null $annexe
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string|null $archieved_at
 * @property string|null $passed_at
 * @property-read \App\Models\ConsultationObstetrique $consultation
 * @property-read mixed $type_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie newQuery()
 * @method static \Illuminate\Database\Query\Builder|Echographie onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereAnnexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereArchievedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereBiometrie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereConsultationObstetriqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereDateCreation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereDdr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereDpa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereSemaineAmenorrhee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Echographie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Echographie withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Echographie withoutTrashed()
 * @mixin \Eloquent
 */
	class Echographie extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EtablissementExercice
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $slug
 * @property string|null $logo
 * @property string|null $adresse
 * @property-read \Illuminate\Database\Eloquent\Collection|Assistante[] $assistantes
 * @property-read int|null $assistantes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comptable[] $comptables
 * @property-read int|null $comptables_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FactureAvis[] $factureAvis
 * @property-read int|null $facture_avis_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Facture[] $factures
 * @property-read int|null $factures_count
 * @property-read mixed $name_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MedecinControle[] $medecinControles
 * @property-read int|null $medecin_controles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Patient[] $patients
 * @property-read int|null $patients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Praticien[] $praticiens
 * @property-read int|null $praticiens_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EtablissementPrestation[] $prestations
 * @property-read int|null $prestations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RendezVous[] $rendezVous
 * @property-read int|null $rendez_vous_count
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice newQuery()
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice query()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercice withoutTrashed()
 * @mixin \Eloquent
 * @property-read mixed $image
 */
	class EtablissementExercice extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EtablissementExerciceMedecin
 *
 * @property int $id
 * @property int $etablissement_id
 * @property int $medecin_controle_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin newQuery()
 * @method static \Illuminate\Database\Query\Builder|EtablissementExerciceMedecin onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin query()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin whereMedecinControleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExerciceMedecin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|EtablissementExerciceMedecin withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EtablissementExerciceMedecin withoutTrashed()
 * @mixin \Eloquent
 */
	class EtablissementExerciceMedecin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EtablissementExercicePatient
 *
 * @property int $id
 * @property int $etablissement_id
 * @property int $patient_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient newQuery()
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercicePatient onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient query()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePatient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercicePatient withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercicePatient withoutTrashed()
 * @mixin \Eloquent
 */
	class EtablissementExercicePatient extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EtablissementExercicePraticien
 *
 * @property int $id
 * @property int $etablissement_id
 * @property int $praticien_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien newQuery()
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercicePraticien onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien query()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien wherePraticienId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementExercicePraticien whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercicePraticien withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EtablissementExercicePraticien withoutTrashed()
 * @mixin \Eloquent
 */
	class EtablissementExercicePraticien extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EtablissementPrestation
 *
 * @property int $id
 * @property int $etablissement_id
 * @property int $prestation_id
 * @property int|null $creator
 * @property string $prix
 * @property string|null $reduction
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EtablissementExercice $etablissement
 * @property-read mixed $name_and_timestamp
 * @property-read \App\Models\Prestation $prestation
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementPrestation findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementPrestation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementPrestation newQuery()
 * @method static \Illuminate\Database\Query\Builder|EtablissementPrestation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementPrestation query()
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementPrestation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementPrestation whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementPrestation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementPrestation whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementPrestation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementPrestation wherePrestationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementPrestation wherePrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementPrestation whereReduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementPrestation whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EtablissementPrestation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|EtablissementPrestation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EtablissementPrestation withoutTrashed()
 * @mixin \Eloquent
 */
	class EtablissementPrestation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExamenCardio
 *
 * @property int $id
 * @property int $cardiologie_id
 * @property string $nom
 * @property string $date_examen
 * @property string $description
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cardiologie $cardiologie
 * @property-read mixed $nom_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio newQuery()
 * @method static \Illuminate\Database\Query\Builder|ExamenCardio onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereCardiologieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereDateExamen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenCardio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ExamenCardio withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ExamenCardio withoutTrashed()
 * @mixin \Eloquent
 */
	class ExamenCardio extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExamenClinic
 *
 * @property int $id
 * @property string|null $fr_description
 * @property string|null $en_description
 * @property string|null $reference
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $dossier_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic newQuery()
 * @method static \Illuminate\Database\Query\Builder|ExamenClinic onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic whereEnDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic whereFrDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenClinic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ExamenClinic withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ExamenClinic withoutTrashed()
 * @mixin \Eloquent
 */
	class ExamenClinic extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExamenComplementaire
 *
 * @property int $id
 * @property string $slug
 * @property string $fr_description
 * @property string $reference
 * @property int $prix
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExamenEtablissementPrix[] $examenComplementairePrix
 * @property-read int|null $examen_complementaire_prix_count
 * @property-read mixed $dossier_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire newQuery()
 * @method static \Illuminate\Database\Query\Builder|ExamenComplementaire onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire whereFrDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire wherePrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenComplementaire whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ExamenComplementaire withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ExamenComplementaire withoutTrashed()
 * @mixin \Eloquent
 */
	class ExamenComplementaire extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExamenEtablissementPrix
 *
 * @property int $id
 * @property int $etablissement_exercices_id
 * @property int|null $examen_complementaire_id
 * @property int|null $other_complementaire_id
 * @property int $prix
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\EtablissementExercice $etablissement
 * @property-read \App\Models\ExamenComplementaire|null $examenComplementaire
 * @property-read \App\Models\OtherComplementaire|null $otherExamenComplementaire
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix whereEtablissementExercicesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix whereExamenComplementaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix whereOtherComplementaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix wherePrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamenEtablissementPrix whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ExamenEtablissementPrix extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Facture
 *
 * @property int $id
 * @property int|null $dossier_medical_id
 * @property int|null $etablissement_id
 * @property int|null $creator
 * @property string|null $total_hors_remise
 * @property string|null $total_avec_remise
 * @property string|null $remise
 * @property string|null $date_facturation
 * @property string|null $statut
 * @property string|null $motif
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $createur
 * @property-read \App\Models\DossierMedical|null $dossier
 * @property-read \App\Models\EtablissementExercice|null $etablissement
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read mixed $name_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FacturePrestation[] $prestations
 * @property-read int|null $prestations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Facture findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Facture newQuery()
 * @method static \Illuminate\Database\Query\Builder|Facture onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Facture query()
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereDateFacturation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereRemise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereTotalAvecRemise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereTotalHorsRemise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facture whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Facture withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Facture withoutTrashed()
 * @mixin \Eloquent
 */
	class Facture extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FactureAvis
 *
 * @property int $id
 * @property int $avis_id
 * @property int $dossier_medical_id
 * @property int $association_id
 * @property int $etablissement_id
 * @property int|null $creator
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Association $association
 * @property-read \App\Models\Avis $avis
 * @property-read User|null $createur
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read \App\Models\EtablissementExercice $etablissement
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FactureAvisDetail[] $factureDetail
 * @property-read int|null $facture_detail_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read mixed $name_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis newQuery()
 * @method static \Illuminate\Database\Query\Builder|FactureAvis onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis query()
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereAssociationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereAvisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvis whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|FactureAvis withTrashed()
 * @method static \Illuminate\Database\Query\Builder|FactureAvis withoutTrashed()
 * @mixin \Eloquent
 */
	class FactureAvis extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FactureAvisDetail
 *
 * @property int $id
 * @property int $medecin_avis_id
 * @property int $facture_avis_id
 * @property string|null $total_montant
 * @property string|null $medicasure_montant
 * @property string|null $association_montant
 * @property string|null $medecin_avis_montant
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EtablissementExercice $etablissement
 * @property-read \App\Models\FactureAvis $factureAvis
 * @property-read mixed $name_and_timestamp
 * @property-read \App\Models\MedecinAvis $medecinAvis
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvisDetail findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvisDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvisDetail newQuery()
 * @method static \Illuminate\Database\Query\Builder|FactureAvisDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvisDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvisDetail whereAssociationMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvisDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvisDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvisDetail whereFactureAvisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvisDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvisDetail whereMedecinAvisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvisDetail whereMedecinAvisMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvisDetail whereMedicasureMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvisDetail whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvisDetail whereTotalMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactureAvisDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|FactureAvisDetail withTrashed()
 * @method static \Illuminate\Database\Query\Builder|FactureAvisDetail withoutTrashed()
 * @mixin \Eloquent
 */
	class FactureAvisDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FacturePrestation
 *
 * @property int $id
 * @property int $facture_id
 * @property int $prestation_id
 * @property int|null $creator
 * @property string|null $date_prestation
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $statut
 * @property string|null $motif
 * @property-read \App\Models\Facture $facture
 * @property-read mixed $name_and_timestamp
 * @property-read \App\Models\EtablissementPrestation $prestation_etablissement
 * @method static \Illuminate\Database\Eloquent\Builder|FacturePrestation findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|FacturePrestation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FacturePrestation newQuery()
 * @method static \Illuminate\Database\Query\Builder|FacturePrestation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FacturePrestation query()
 * @method static \Illuminate\Database\Eloquent\Builder|FacturePrestation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacturePrestation whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacturePrestation whereDatePrestation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacturePrestation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacturePrestation whereFactureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacturePrestation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacturePrestation whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacturePrestation wherePrestationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacturePrestation whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacturePrestation whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacturePrestation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|FacturePrestation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|FacturePrestation withoutTrashed()
 * @mixin \Eloquent
 */
	class FacturePrestation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Feature
 *
 * @property int $id
 * @property string $nom_feature
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Feature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature newQuery()
 * @method static \Illuminate\Database\Query\Builder|Feature onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereNomFeature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Feature withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Feature withoutTrashed()
 */
	class Feature extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\File
 *
 * @property int $id
 * @property string $fileable_type
 * @property int $fileable_id
 * @property string $nom
 * @property string $extension
 * @property string $chemin
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $fileable
 * @property-read mixed $dossier_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|File findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File newQuery()
 * @method static \Illuminate\Database\Query\Builder|File onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|File query()
 * @method static \Illuminate\Database\Eloquent\Builder|File whereChemin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|File withTrashed()
 * @method static \Illuminate\Database\Query\Builder|File withoutTrashed()
 * @mixin \Eloquent
 */
	class File extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Gestionnaire
 *
 * @property string $slug
 * @property int|null $user_id
 * @property string $civilite
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auteur[] $auteurs
 * @property-read int|null $auteurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auteur[] $operations
 * @property-read int|null $operations_count
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire newQuery()
 * @method static \Illuminate\Database\Query\Builder|Gestionnaire onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire whereCivilite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gestionnaire whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Gestionnaire withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Gestionnaire withoutTrashed()
 * @mixin \Eloquent
 */
	class Gestionnaire extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GroupeActivite
 *
 * @property int $id
 * @property string $nom
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $dossier_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GroupeActiviteMission[] $missions
 * @property-read int|null $missions_count
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite newQuery()
 * @method static \Illuminate\Database\Query\Builder|GroupeActivite onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite query()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActivite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|GroupeActivite withTrashed()
 * @method static \Illuminate\Database\Query\Builder|GroupeActivite withoutTrashed()
 * @mixin \Eloquent
 */
	class GroupeActivite extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GroupeActiviteMission
 *
 * @property int $id
 * @property int $groupe_id
 * @property string $description
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $dossier_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission newQuery()
 * @method static \Illuminate\Database\Query\Builder|GroupeActiviteMission onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission query()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission whereGroupeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeActiviteMission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|GroupeActiviteMission withTrashed()
 * @method static \Illuminate\Database\Query\Builder|GroupeActiviteMission withoutTrashed()
 * @mixin \Eloquent
 */
	class GroupeActiviteMission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GroupeUtilisateur
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeUtilisateur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeUtilisateur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupeUtilisateur query()
 */
	class GroupeUtilisateur extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HospitalisationMotif
 *
 * @method static \Illuminate\Database\Eloquent\Builder|HospitalisationMotif newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HospitalisationMotif newQuery()
 * @method static \Illuminate\Database\Query\Builder|HospitalisationMotif onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|HospitalisationMotif query()
 * @method static \Illuminate\Database\Query\Builder|HospitalisationMotif withTrashed()
 * @method static \Illuminate\Database\Query\Builder|HospitalisationMotif withoutTrashed()
 * @mixin \Eloquent
 */
	class HospitalisationMotif extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Kinesitherapie
 *
 * @property int $id
 * @property int $etablissement_id
 * @property int|null $creator
 * @property int $dossier_medical_id
 * @property string|null $date_consultation
 * @property string|null $motifs
 * @property string|null $anamnese
 * @property string|null $profession
 * @property string|null $evaluation_globale
 * @property string|null $impression_diagnostique
 * @property string|null $examens_complementaires
 * @property string|null $conduite_a_tenir
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $archieved_at
 * @property string|null $passed_at
 * @property-read User|null $author
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read \App\Models\EtablissementExercice $etablissement
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read mixed $dossier_and_timestamp
 * @property-read \App\Models\LigneDeTemps $ligneDeTemps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contributeurs[] $operationables
 * @property-read int|null $operationables_count
 * @property-read \App\Models\RendezVous|null $rdv
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie newQuery()
 * @method static \Illuminate\Database\Query\Builder|Kinesitherapie onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie orderByDateConsultation()
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereAnamnese($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereArchievedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereConduiteATenir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereDateConsultation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereEvaluationGlobale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereExamensComplementaires($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereImpressionDiagnostique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereMotifs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Kinesitherapie withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Kinesitherapie withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Kinesitherapie kinesiSemaineMoisAnnee($intervalle_debut, $intervalle_fin)
 */
	class Kinesitherapie extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LigneDeTemps
 *
 * @property int $id
 * @property int $dossier_medical_id
 * @property int $etat
 * @property int $motif_consultation_id
 * @property string $date_consultation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $affiliation_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ActiviteAmaPatient[] $activites_ama_patients
 * @property-read int|null $activites_ama_patients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ActivitesControle[] $activites_referent_patients
 * @property-read int|null $activites_referent_patients_count
 * @property-read \App\Models\Affiliation|null $affiliation
 * @property-read \App\Models\Cardiologie $cardiologie
 * @property-read \App\Models\Cloture|null $cloture
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationMedecineGenerale[] $consultationGeneral
 * @property-read int|null $consultation_general_count
 * @property-read \App\Models\ConsultationObstetrique $consultationObstetrique
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read \App\Models\Kinesitherapie $kenesitherapie
 * @property-read \App\Models\Motif $motif
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Motif[] $motifs
 * @property-read int|null $motifs_count
 * @property-read \App\Models\PrescriptionValidation $prescriptionValidation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RendezVous[] $rendezVous
 * @property-read int|null $rendez_vous_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationExamenValidation[] $validations
 * @property-read int|null $validations_count
 * @method static \Illuminate\Database\Eloquent\Builder|LigneDeTemps newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LigneDeTemps newQuery()
 * @method static \Illuminate\Database\Query\Builder|LigneDeTemps onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LigneDeTemps query()
 * @method static \Illuminate\Database\Eloquent\Builder|LigneDeTemps whereAffiliationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LigneDeTemps whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LigneDeTemps whereDateConsultation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LigneDeTemps whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LigneDeTemps whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LigneDeTemps whereEtat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LigneDeTemps whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LigneDeTemps whereMotifConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LigneDeTemps whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|LigneDeTemps withTrashed()
 * @method static \Illuminate\Database\Query\Builder|LigneDeTemps withoutTrashed()
 * @mixin \Eloquent
 * @property int|null $creator
 * @property-read mixed $description
 * @method static \Illuminate\Database\Eloquent\Builder|LigneDeTemps notDeleted()
 * @method static \Illuminate\Database\Eloquent\Builder|LigneDeTemps whereCreator($value)
 */
	class LigneDeTemps extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MedecinAvis
 *
 * @property int $id
 * @property int $avis_id
 * @property int $medecin_id
 * @property string $slug
 * @property int $view
 * @property string|null $avis
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $set_opinion_at
 * @property string|null $statut
 * @property-read \App\Models\Avis $avisMedecin
 * @property-read mixed $name_and_timestamp
 * @property-read User $medecin
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis newQuery()
 * @method static \Illuminate\Database\Query\Builder|MedecinAvis onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereAvis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereAvisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereMedecinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereSetOpinionAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinAvis whereView($value)
 * @method static \Illuminate\Database\Query\Builder|MedecinAvis withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MedecinAvis withoutTrashed()
 * @mixin \Eloquent
 */
	class MedecinAvis extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MedecinControle
 *
 * @property string $slug
 * @property int $specialite_id
 * @property int|null $user_id
 * @property string $civilite
 * @property string|null $numero_ordre
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $signature
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auteur[] $auteurs
 * @property-read int|null $auteurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DelaiOperation[] $delai_operations
 * @property-read int|null $delai_operations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EtablissementExercice[] $etablissements
 * @property-read int|null $etablissements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Patient[] $patients
 * @property-read int|null $patients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RendezVous[] $rendezVous
 * @property-read int|null $rendez_vous_count
 * @property-read \App\Models\Specialite $specialite
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle newQuery()
 * @method static \Illuminate\Database\Query\Builder|MedecinControle onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereCivilite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereNumeroOrdre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereSpecialiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinControle whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|MedecinControle withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MedecinControle withoutTrashed()
 * @mixin \Eloquent
 * @property-read mixed $name
 */
	class MedecinControle extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MedecinDeSuivi
 *
 * @property int $id
 * @property int $user_id
 * @property int $suivi_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $dossier_and_timestamp
 * @property-read User $praticien
 * @property-read \App\Models\Suivi $suivi
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi newQuery()
 * @method static \Illuminate\Database\Query\Builder|MedecinDeSuivi onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi whereSuiviId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedecinDeSuivi whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|MedecinDeSuivi withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MedecinDeSuivi withoutTrashed()
 * @mixin \Eloquent
 */
	class MedecinDeSuivi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Medicament
 *
 * @property int $id
 * @property string|null $nom_commercial
 * @property string|null $principe_actif
 * @property string|null $classe_medicamenteuse
 * @property string|null $forme_et_dosage
 * @property string|null $conditionement
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $nom_specialite
 * @property string $nom_dci
 * @property-read mixed $medoc
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ordonance[] $ordonances
 * @property-read int|null $ordonances_count
 * @property-read \App\Models\Prescription|null $prescription
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament newQuery()
 * @method static \Illuminate\Database\Query\Builder|Medicament onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament query()
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereClasseMedicamenteuse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereConditionement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereFormeEtDosage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereNomCommercial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereNomDci($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereNomSpecialite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament wherePrincipeActif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medicament whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Medicament withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Medicament withoutTrashed()
 * @mixin \Eloquent
 */
	class Medicament extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Metrique
 *
 * @property int $id
 * @property float $temps_moyen
 * @property float $affiliation_et_affectation_medecin_referents
 * @property float $consultation_medecine_generale
 * @property float $consultation_fichier
 * @property float $resultat_labo
 * @property float $resultat_imagerie
 * @property float $avis_medicals
 * @property float $medecin_controle
 * @property float $consultation_examen_validation
 * @property float $activite_amas
 * @property float $nbre_patients
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique query()
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique semaineMoisAnnee($intervalle_debut, $intervalle_fin)
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique whereActiviteAmas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique whereAffiliationEtAffectationMedecinReferents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique whereAvisMedicals($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique whereConsultationExamenValidation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique whereConsultationFichier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique whereConsultationMedecineGenerale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique whereMedecinControle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique whereNbrePatients($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique whereResultatImagerie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique whereResultatLabo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique whereTempsMoyen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metrique whereUpdatedAt($value)
 */
	class Metrique extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Metting
 *
 * @property int $id
 * @property string $uuid
 * @property int $patient_id
 * @property int $medecin_id
 * @property int $statut
 * @property string|null $url
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Antonrom\ModelChangesHistory\Models\Change[] $historyChangesMorph
 * @property-read int|null $history_changes_morph_count
 * @property-read \Antonrom\ModelChangesHistory\Models\Change|null $latestChangeMorph
 * @property-read \App\User $medecin
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\User $patient
 * @method static \Illuminate\Database\Eloquent\Builder|Metting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Metting newQuery()
 * @method static \Illuminate\Database\Query\Builder|Metting onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Metting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Metting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metting whereMedecinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metting wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metting whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metting whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metting whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|Metting withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Metting withoutTrashed()
 */
	class Metting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Motif
 *
 * @property int $id
 * @property string $reference
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property-read Motif|null $actions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Affiliation[] $affiliations
 * @property-read int|null $affiliations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationMedecineGenerale[] $consultations
 * @property-read int|null $consultations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationMedecineGenerale[] $consultationsMedecines
 * @property-read int|null $consultations_medecines_count
 * @property-read mixed $reference_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Hospitalisation[] $hospitalisation
 * @property-read int|null $hospitalisation_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LigneDeTemps[] $ligneDeTemps
 * @property-read int|null $ligne_de_temps_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LigneDeTemps[] $nLigneDeTemps
 * @property-read int|null $n_ligne_de_temps_count
 * @method static \Illuminate\Database\Eloquent\Builder|Motif findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif newQuery()
 * @method static \Illuminate\Database\Query\Builder|Motif onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif query()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Motif withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Motif withoutTrashed()
 * @mixin \Eloquent
 */
	class Motif extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NotificationPaiement
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $code_contrat
 * @property string|null $pay_token
 * @property string|null $statut
 * @property string|null $reponse
 * @property string|null $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $generate_slug
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement newQuery()
 * @method static \Illuminate\Database\Query\Builder|NotificationPaiement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereCodeContrat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement wherePayToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereReponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationPaiement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|NotificationPaiement withTrashed()
 * @method static \Illuminate\Database\Query\Builder|NotificationPaiement withoutTrashed()
 * @mixin \Eloquent
 */
	class NotificationPaiement extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Offre
 *
 * @property int $id
 * @property string|null $description_fr
 * @property string|null $description_en
 * @property string|null $status
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Dictionnaire[] $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Package[] $packages
 * @property-read int|null $packages_count
 * @method static \Illuminate\Database\Eloquent\Builder|Offre findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Offre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Offre newQuery()
 * @method static \Illuminate\Database\Query\Builder|Offre onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Offre query()
 * @method static \Illuminate\Database\Eloquent\Builder|Offre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offre whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offre whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offre whereDescriptionFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offre whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offre whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Offre whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Offre withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Offre withoutTrashed()
 * @mixin \Eloquent
 */
	class Offre extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OffrePackageItem
 *
 * @property int $id
 * @property int|null $package_id
 * @property int|null $key
 * @property string|null $reference
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Dictionnaire|null $item
 * @property-read \App\Models\Package|null $packages
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem newQuery()
 * @method static \Illuminate\Database\Query\Builder|OffrePackageItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OffrePackageItem whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|OffrePackageItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OffrePackageItem withoutTrashed()
 * @mixin \Eloquent
 */
	class OffrePackageItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Ordonance
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $date_prescription
 * @property \Illuminate\Support\Carbon|null $archieved_at
 * @property \Illuminate\Support\Carbon|null $passed_at
 * @property int $dossier_medical_id
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $praticien_id
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read mixed $dossier_and_timestamp
 * @property-read \App\Models\LigneDeTemps $ligneDeTemps
 * @property-read User|null $praticien
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Prescription[] $prescriptions
 * @property-read int|null $prescriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance newQuery()
 * @method static \Illuminate\Database\Query\Builder|Ordonance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance whereArchievedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance whereDatePrescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance wherePraticienId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ordonance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Ordonance withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Ordonance withoutTrashed()
 * @mixin \Eloquent
 */
	class Ordonance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OtherComplementaire
 *
 * @property int $id
 * @property string|null $fr_description
 * @property string|null $en_description
 * @property string|null $reference
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $dossier_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire newQuery()
 * @method static \Illuminate\Database\Query\Builder|OtherComplementaire onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire whereEnDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire whereFrDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OtherComplementaire whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|OtherComplementaire withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OtherComplementaire withoutTrashed()
 * @mixin \Eloquent
 */
	class OtherComplementaire extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Package
 *
 * @property int $id
 * @property int $offre_id
 * @property string|null $description_fr
 * @property string|null $description_en
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\OffrePackageItem[] $items
 * @property string|null $status
 * @property string $montant
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Affiliation[] $affiliations
 * @property-read int|null $affiliations_count
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package newQuery()
 * @method static \Illuminate\Database\Query\Builder|Package onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDescriptionFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereOffreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Package withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Package withoutTrashed()
 * @mixin \Eloquent
 * @property int|null $fake_price
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereFakePrice($value)
 */
	class Package extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ParametreCommun
 *
 * @property int $id
 * @property int|null $consultation_medecine_generale_id
 * @property float|null $poids
 * @property float|null $taille
 * @property float|null $bmi
 * @property int|null $ta_systolique
 * @property int|null $ta_diastolique
 * @property float|null $temperature
 * @property int|null $frequence_cardiaque
 * @property int|null $frequence_respiratoire
 * @property int|null $sato2
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string|null $perimetre_abdominal
 * @property string|null $communable_type
 * @property int|null $communable_id
 * @property int|null $ta_systolique_d
 * @property int|null $ta_diastolique_d
 * @property-read Model|\Eloquent $communable
 * @property-read \App\Models\ConsultationMedecineGenerale|null $consultation
 * @property-read mixed $consultation_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun newQuery()
 * @method static \Illuminate\Database\Query\Builder|ParametreCommun onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun query()
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereBmi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereCommunableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereCommunableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereConsultationMedecineGeneraleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereFrequenceCardiaque($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereFrequenceRespiratoire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun wherePerimetreAbdominal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun wherePoids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereSato2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereTaDiastolique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereTaDiastoliqueD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereTaSystolique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereTaSystoliqueD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereTaille($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreCommun whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ParametreCommun withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ParametreCommun withoutTrashed()
 * @mixin \Eloquent
 */
	class ParametreCommun extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ParametreObstetrique
 *
 * @property int $id
 * @property int $consultation_prenatale_id
 * @property float|null $poids
 * @property int|null $ta_systolique
 * @property int|null $ta_diastolique
 * @property int|null $hauteur_urine
 * @property int|null $toucher_vaginal
 * @property int|null $bruit_du_coeur
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property-read \App\Models\ConsultationPrenatale $consultationPrenatale
 * @property-read mixed $consultation_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique newQuery()
 * @method static \Illuminate\Database\Query\Builder|ParametreObstetrique onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique query()
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereBruitDuCoeur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereConsultationPrenataleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereHauteurUrine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique wherePoids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereTaDiastolique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereTaSystolique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereToucherVaginal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParametreObstetrique whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ParametreObstetrique withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ParametreObstetrique withoutTrashed()
 * @mixin \Eloquent
 */
	class ParametreObstetrique extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Partenaire
 *
 * @property int $id
 * @property int|null $creator
 * @property string|null $region
 * @property string|null $ville
 * @property string|null $nom
 * @property string|null $telephone
 * @property string|null $localisation
 * @property string|null $email
 * @property string|null $contact
 * @property string|null $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read User|null $author
 * @property-read mixed $dossier_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire newQuery()
 * @method static \Illuminate\Database\Query\Builder|Partenaire onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereLocalisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partenaire whereVille($value)
 * @method static \Illuminate\Database\Query\Builder|Partenaire withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Partenaire withoutTrashed()
 * @mixin \Eloquent
 */
	class Partenaire extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Patient
 *
 * @property string $slug
 * @property int|null $user_id
 * @property int|null $souscripteur_id
 * @property string $date_de_naissance
 * @property string $sexe
 * @property int|null $age
 * @property int|null $consentement
 * @property int|null $restriction
 * @property string|null $nom_contact
 * @property string|null $tel_contact
 * @property string|null $lien_contact
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ActiviteAmaPatient[] $activitesAma
 * @property-read int|null $activites_ama_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Affiliation[] $affiliations
 * @property-read int|null $affiliations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auteur[] $auteurs
 * @property-read int|null $auteurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DelaiOperation[] $delai_operations
 * @property-read int|null $delai_operations_count
 * @property-read \App\Models\DossierMedical|null $dossier
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EtablissementExercice[] $etablissements
 * @property-read int|null $etablissements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PatientSouscripteur[] $financeurs
 * @property-read int|null $financeurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PatientMedecinControle[] $medecinReferent
 * @property-read int|null $medecin_referent_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RendezVous[] $rendezVous
 * @property-read int|null $rendez_vous_count
 * @property-read \App\Models\Souscripteur|null $souscripteur
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Patient findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newQuery()
 * @method static \Illuminate\Database\Query\Builder|Patient onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient restrictUser()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereConsentement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereDateDeNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereLienContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereNomContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereRestriction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereSouscripteurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereTelContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Patient withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Patient withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ActivitesControle[] $activitesMedecinReferent
 * @property-read int|null $activites_medecin_referent_count
 * @property-read \App\Models\Alerte|null $alerte
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Alerte[] $alertes
 * @property-read int|null $alertes_count
 * @property-read mixed $name
 * @method static \Illuminate\Database\Eloquent\Builder|Patient patientSemaineMoisAnnee($intervalle_debut, $intervalle_fin)
 */
	class Patient extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PatientMedecinControle
 *
 * @property int $id
 * @property int $medecin_control_id
 * @property int $patient_id
 * @property int|null $creator
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $createur
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DelaiOperation[] $delai_operations
 * @property-read int|null $delai_operations_count
 * @property-read mixed $consultation_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\Antonrom\ModelChangesHistory\Models\Change[] $historyChangesMorph
 * @property-read int|null $history_changes_morph_count
 * @property-read \Antonrom\ModelChangesHistory\Models\Change|null $latestChangeMorph
 * @property-read \App\Models\MedecinControle $medecinControles
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Patient $patients
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle newQuery()
 * @method static \Illuminate\Database\Query\Builder|PatientMedecinControle onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle query()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle whereMedecinControlId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|PatientMedecinControle withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PatientMedecinControle withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Affiliation[] $affiliations
 * @property-read int|null $affiliations_count
 * @method static \Illuminate\Database\Eloquent\Builder|PatientMedecinControle medRefSemaineMoisAnnee($intervalle_debut, $intervalle_fin)
 */
	class PatientMedecinControle extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PatientSouscripteur
 *
 * @property int $id
 * @property string $slug
 * @property string $financable_type
 * @property int $financable_id
 * @property int $patient_id
 * @property int|null $lien_de_parente
 * @property int $souscripteur_consentement
 * @property int $patient_consentement
 * @property int|null $restriction
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $financable
 * @property-read mixed $consultation_and_timestamp
 * @property-read \App\Models\Dictionnaire|null $lien
 * @property-read \App\Models\Patient $patients
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur newQuery()
 * @method static \Illuminate\Database\Query\Builder|PatientSouscripteur onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur query()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereFinancableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereFinancableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereLienDeParente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur wherePatientConsentement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereRestriction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereSouscripteurConsentement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientSouscripteur whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|PatientSouscripteur withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PatientSouscripteur withoutTrashed()
 * @mixin \Eloquent
 */
	class PatientSouscripteur extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $souscripteur_id
 * @property int $patient_id
 * @property string|null $amount
 * @property string|null $date_payment
 * @property string $method
 * @property string $motif
 * @property string $statut
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $date_facturation
 * @property-read \App\Models\Patient $patients
 * @property-read \App\Models\Souscripteur $souscripteur
 * @method static \Illuminate\Database\Eloquent\Builder|Payment findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Query\Builder|Payment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDateFacturation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDatePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereSouscripteurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Payment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Payment withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUuid($value)
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
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
 * @property-read \App\Models\Souscripteur $souscripteur
 */
	class PaymentOffre extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Pec
 *
 * @property-read User $createur
 * @property-read \App\Models\EtablissementExercice $etablissements
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Pec newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pec newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pec query()
 * @mixin \Eloquent
 */
	class Pec extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Pharmacien
 *
 * @property-read \App\Models\EtablissementExercice $etablissements
 * @property-read mixed $reference_and_timestamp
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacien findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacien newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacien newQuery()
 * @method static \Illuminate\Database\Query\Builder|Pharmacien onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Pharmacien query()
 * @method static \Illuminate\Database\Query\Builder|Pharmacien withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Pharmacien withoutTrashed()
 * @mixin \Eloquent
 */
	class Pharmacien extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Posologie
 *
 * @property int $id
 * @property int $prescription_id
 * @property float $dose
 * @property string $formulation
 * @property string $voieAdmin
 * @property int $nombre
 * @property string $par
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $name_and_timestamp
 * @property-read \App\Models\Prescription $prescription
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie newQuery()
 * @method static \Illuminate\Database\Query\Builder|Posologie onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereDose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereFormulation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie wherePar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie wherePrescriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posologie whereVoieAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|Posologie withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Posologie withoutTrashed()
 * @mixin \Eloquent
 */
	class Posologie extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Praticien
 *
 * @property int|null $user_id
 * @property int $specialite_id
 * @property string $civilite
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $numero_ordre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string|null $signature
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auteur[] $auteurs
 * @property-read int|null $auteurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EtablissementExercice[] $etablissements
 * @property-read int|null $etablissements_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RendezVous[] $rendezVous
 * @property-read int|null $rendez_vous_count
 * @property-read \App\Models\Specialite $specialite
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien newQuery()
 * @method static \Illuminate\Database\Query\Builder|Praticien onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien query()
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereCivilite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereNumeroOrdre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereSpecialiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Praticien whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Praticien withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Praticien withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TimeActivite[] $time
 * @property-read int|null $time_count
 */
	class Praticien extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Prescription
 *
 * @property int $id
 * @property int $medicament_id
 * @property int $ordonance_id
 * @property string|null $info_comp
 * @property string $date_fin
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $name_and_timestamp
 * @property-read \App\Models\Medicament $medicament
 * @property-read \App\Models\Ordonance $ordonnance
 * @property-read \App\Models\Posologie|null $posology
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription newQuery()
 * @method static \Illuminate\Database\Query\Builder|Prescription onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription query()
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereDateFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereInfoComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereMedicamentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereOrdonanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prescription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Prescription withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Prescription withoutTrashed()
 * @mixin \Eloquent
 */
	class Prescription extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PrescriptionValidation
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PrescriptionValidation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrescriptionValidation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrescriptionValidation query()
 * @mixin \Eloquent
 */
	class PrescriptionValidation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Prestation
 *
 * @property int $id
 * @property string $nom
 * @property string|null $prix
 * @property string $slug
 * @property int|null $creator
 * @property int|null $categorie_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CategoriePrestation|null $categorie
 * @property-read mixed $name_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|Prestation findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Prestation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prestation newQuery()
 * @method static \Illuminate\Database\Query\Builder|Prestation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Prestation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Prestation whereCategorieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prestation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prestation whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prestation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prestation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prestation whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prestation wherePrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prestation whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prestation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Prestation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Prestation withoutTrashed()
 * @mixin \Eloquent
 */
	class Prestation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Profession
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property-read mixed $name_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Specialite[] $specialites
 * @property-read int|null $specialites_count
 * @method static \Illuminate\Database\Eloquent\Builder|Profession findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Profession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profession newQuery()
 * @method static \Illuminate\Database\Query\Builder|Profession onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Profession query()
 * @method static \Illuminate\Database\Eloquent\Builder|Profession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profession whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profession whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profession whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profession whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profession whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Profession withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Profession withoutTrashed()
 * @mixin \Eloquent
 */
	class Profession extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Question
 *
 * @property int $id
 * @property string $intitule
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $type_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|Question findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Query\Builder|Question onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereIntitule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Question withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Question withoutTrashed()
 * @mixin \Eloquent
 */
	class Question extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RendezVous
 *
 * @property int $id
 * @property string|null $sourceable_type
 * @property int|null $sourceable_id
 * @property int $patient_id
 * @property int|null $praticien_id
 * @property User $initiateur
 * @property string|null $motifs
 * @property string $date
 * @property string|null $statut
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $nom_medecin
 * @property int|null $creator
 * @property int|null $consultation_id
 * @property int|null $etablissement_id
 * @property int|null $ligne_temps_id
 * @property-read \App\Models\ConsultationMedecineGenerale|null $consultationsMedecine
 * @property-read \App\Models\EtablissementExercice|null $etablissement
 * @property-read mixed $name_and_timestamp
 * @property-read \App\Models\LigneDeTemps|null $ligne_temps
 * @property-read User $patient
 * @property-read User|null $praticien
 * @property-read Model|\Eloquent $sourceable
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous newQuery()
 * @method static \Illuminate\Database\Query\Builder|RendezVous onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous query()
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereConsultationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereEtablissementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereInitiateur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereLigneTempsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereMotifs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereNomMedecin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous wherePraticienId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereSourceableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereSourceableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|RendezVous withTrashed()
 * @method static \Illuminate\Database\Query\Builder|RendezVous withoutTrashed()
 * @mixin \Eloquent
 * @property int|null $parent_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Antonrom\ModelChangesHistory\Models\Change[] $historyChangesMorph
 * @property-read int|null $history_changes_morph_count
 * @property-read \Antonrom\ModelChangesHistory\Models\Change|null $latestChangeMorph
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous effectues306090($date_debut, $date_fin)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous filtre($date_debut, $date_fin, $statut)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous jours306090($date_debut, $date_fin)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous rdvSemaineMoisAnnee($intervalle_debut, $intervalle_fin)
 * @method static \Illuminate\Database\Eloquent\Builder|RendezVous whereParentId($value)
 */
	class RendezVous extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReponseSecrete
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $question_id
 * @property string|null $reponse
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $type_and_timestamp
 * @property-read \App\Models\Question|null $question
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete newQuery()
 * @method static \Illuminate\Database\Query\Builder|ReponseSecrete onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete whereReponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReponseSecrete whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|ReponseSecrete withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ReponseSecrete withoutTrashed()
 * @mixin \Eloquent
 */
	class ReponseSecrete extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ResultatImagerie
 *
 * @property int $id
 * @property int $dossier_medical_id
 * @property string $consultation_medecine_generale_id
 * @property string $description
 * @property string $date
 * @property string|null $file
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $archived_at
 * @property \Illuminate\Support\Carbon|null $passed_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $praticien_id
 * @property-read \App\Models\ConsultationMedecineGenerale $consultation
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read mixed $type_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie newQuery()
 * @method static \Illuminate\Database\Query\Builder|ResultatImagerie onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereArchivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereConsultationMedecineGeneraleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie wherePraticienId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ResultatImagerie withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ResultatImagerie withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatImagerie resultImagerieSemaineMoisAnnee($intervalle_debut, $intervalle_fin)
 */
	class ResultatImagerie extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ResultatLabo
 *
 * @property int $id
 * @property int $dossier_medical_id
 * @property string $consultation_medecine_generale_id
 * @property string $description
 * @property string $date
 * @property string|null $file
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $archived_at
 * @property \Illuminate\Support\Carbon|null $passed_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $praticien_id
 * @property-read \App\Models\ConsultationMedecineGenerale $consultation
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read mixed $type_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo newQuery()
 * @method static \Illuminate\Database\Query\Builder|ResultatLabo onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo whereArchivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo whereConsultationMedecineGeneraleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo wherePassedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo wherePraticienId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ResultatLabo withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ResultatLabo withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ResultatLabo resultLaboSemaineMoisAnnee($intervalle_debut, $intervalle_fin)
 */
	class ResultatLabo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Souscripteur
 *
 * @property int|null $user_id
 * @property string|null $sexe
 * @property string|null $date_de_naissance
 * @property int|null $age
 * @property int $consentement
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AffiliationSouscripteur[] $affiliation
 * @property-read int|null $affiliation_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auteur[] $auteurs
 * @property-read int|null $auteurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PatientSouscripteur[] $financeurs
 * @property-read int|null $financeurs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Patient[] $patients
 * @property-read int|null $patients_count
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur newQuery()
 * @method static \Illuminate\Database\Query\Builder|Souscripteur onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur query()
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereConsentement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereDateDeNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Souscripteur whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Souscripteur withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Souscripteur withoutTrashed()
 * @mixin \Eloquent
 */
	class Souscripteur extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Specialite
 *
 * @property int $id
 * @property int $profession_id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property-read mixed $name_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MedecinControle[] $medecinsControle
 * @property-read int|null $medecins_controle_count
 * @property-read \App\Models\Profession $profession
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite newQuery()
 * @method static \Illuminate\Database\Query\Builder|Specialite onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite query()
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite whereProfessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Specialite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Specialite withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Specialite withoutTrashed()
 * @mixin \Eloquent
 */
	class Specialite extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SpecialiteSuivi
 *
 * @property int $id
 * @property int $suivi_id
 * @property User|null $responsable
 * @property int $specialite_id
 * @property int|null $creator
 * @property string|null $motifs
 * @property string $slug
 * @property string|null $etat
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $createur
 * @property-read mixed $name_and_timestamp
 * @property-read \App\Models\ConsultationType $specialite
 * @property-read \App\Models\Suivi $suivi
 * @method static \Illuminate\Database\Eloquent\Builder|SpecialiteSuivi findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|SpecialiteSuivi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SpecialiteSuivi newQuery()
 * @method static \Illuminate\Database\Query\Builder|SpecialiteSuivi onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SpecialiteSuivi query()
 * @method static \Illuminate\Database\Eloquent\Builder|SpecialiteSuivi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpecialiteSuivi whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpecialiteSuivi whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpecialiteSuivi whereEtat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpecialiteSuivi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpecialiteSuivi whereMotifs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpecialiteSuivi whereResponsable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpecialiteSuivi whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpecialiteSuivi whereSpecialiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpecialiteSuivi whereSuiviId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SpecialiteSuivi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SpecialiteSuivi withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SpecialiteSuivi withoutTrashed()
 * @mixin \Eloquent
 */
	class SpecialiteSuivi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Suivi
 *
 * @property int $id
 * @property int $dossier_medical_id
 * @property int|null $creator
 * @property string|null $motifs
 * @property string $slug
 * @property string|null $etat
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $categorie_id
 * @property-read \App\Models\Categories|null $categorie
 * @property-read User|null $createur
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read mixed $name_and_timestamp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MedecinDeSuivi[] $responsable
 * @property-read int|null $responsable_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SpecialiteSuivi[] $specialites
 * @property-read int|null $specialites_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SuiviToDoList[] $toDoList
 * @property-read int|null $to_do_list_count
 * @method static \Illuminate\Database\Eloquent\Builder|Suivi findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Suivi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Suivi newQuery()
 * @method static \Illuminate\Database\Query\Builder|Suivi onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Suivi query()
 * @method static \Illuminate\Database\Eloquent\Builder|Suivi whereCategorieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suivi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suivi whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suivi whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suivi whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suivi whereEtat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suivi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suivi whereMotifs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suivi whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suivi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Suivi withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Suivi withoutTrashed()
 * @mixin \Eloquent
 */
	class Suivi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SuiviToDoList
 *
 * @property int $id
 * @property string|null $listable_type
 * @property int|null $listable_id
 * @property string|null $intitule
 * @property string|null $description
 * @property string|null $statut
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $type_and_timestamp
 * @property-read Model|\Eloquent $listable
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList newQuery()
 * @method static \Illuminate\Database\Query\Builder|SuiviToDoList onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList query()
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereIntitule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereListableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereListableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuiviToDoList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SuiviToDoList withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SuiviToDoList withoutTrashed()
 * @mixin \Eloquent
 */
	class SuiviToDoList extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TimeActivite
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $date
 * @property string|null $start
 * @property string|null $stop
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $dossier_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|TimeActivite findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeActivite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeActivite newQuery()
 * @method static \Illuminate\Database\Query\Builder|TimeActivite onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeActivite query()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeActivite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeActivite whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeActivite whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeActivite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeActivite whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeActivite whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeActivite whereStop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeActivite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeActivite whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|TimeActivite withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TimeActivite withoutTrashed()
 * @mixin \Eloquent
 * @property int|null $temps_connecte
 * @property-read \Illuminate\Database\Eloquent\Collection|TimeActivite[] $time
 * @property-read int|null $time_count
 * @property-read \App\Models\Praticien|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|TimeActivite whereTempsConnecte($value)
 */
	class TimeActivite extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Traitement
 *
 * @property int $id
 * @property string $intitule
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConsultationMedecineGenerale[] $consultations
 * @property-read int|null $consultations_count
 * @property-read mixed $intitule_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement newQuery()
 * @method static \Illuminate\Database\Query\Builder|Traitement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereIntitule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Traitement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Traitement withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Traitement withoutTrashed()
 * @mixin \Eloquent
 */
	class Traitement extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TraitementActuel
 *
 * @property int $id
 * @property int $dossier_medical_id
 * @property string $slug
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\DossierMedical $dossier
 * @property-read mixed $description_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel newQuery()
 * @method static \Illuminate\Database\Query\Builder|TraitementActuel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel query()
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel whereDossierMedicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|TraitementActuel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TraitementActuel withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementActuel traitementSemaineMoisAnnee($intervalle_debut, $intervalle_fin)
 */
	class TraitementActuel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TraitementPropose
 *
 * @property int $id
 * @property int $consultation_medecine_generale_id
 * @property string $slug
 * @property string $intitule
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\ConsultationMedecineGenerale $consultation
 * @property-read mixed $intitule_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose newQuery()
 * @method static \Illuminate\Database\Query\Builder|TraitementPropose onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose query()
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose whereConsultationMedecineGeneraleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose whereIntitule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TraitementPropose whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|TraitementPropose withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TraitementPropose withoutTrashed()
 * @mixin \Eloquent
 */
	class TraitementPropose extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TypeOperation
 *
 * @property int $id
 * @property string $libelle
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DelaiOperation[] $delai_operations
 * @property-read int|null $delai_operations_count
 * @property-read mixed $type_and_timestamp
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation newQuery()
 * @method static \Illuminate\Database\Query\Builder|TypeOperation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation query()
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation whereLibelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TypeOperation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|TypeOperation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TypeOperation withoutTrashed()
 * @mixin \Eloquent
 */
	class TypeOperation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VersionValidation
 *
 * @property int $id
 * @property int $version
 * @property float $montant_prestation
 * @property float $montant_medecin
 * @property float $montant_souscripteur
 * @property float $montant_total
 * @property float $plus_value
 * @property int|null $consultation_general_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $ligne_de_temps_id
 * @property-read \App\Models\ConsultationMedecineGenerale|null $consultation
 * @property-read \Illuminate\Database\Eloquent\Collection|\Antonrom\ModelChangesHistory\Models\Change[] $historyChangesMorph
 * @property-read int|null $history_changes_morph_count
 * @property-read \Antonrom\ModelChangesHistory\Models\Change|null $latestChangeMorph
 * @property-read \App\Models\LigneDeTemps|null $ligneDeTemps
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation query()
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereConsultationGeneralId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereLigneDeTempsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereMontantMedecin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereMontantPrestation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereMontantSouscripteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereMontantTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation wherePlusValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VersionValidation whereVersion($value)
 * @mixin \Eloquent
 */
	class VersionValidation extends \Eloquent {}
}

namespace App{
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
	class SMS extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $nom
 * @property string|null $prenom
 * @property string|null $nationalite
 * @property string|null $quartier
 * @property string|null $code_postal
 * @property string|null $ville
 * @property string|null $pays
 * @property string $telephone
 * @property string|null $email
 * @property string|null $codeR
 * @property string|null $codeOTP
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $slug
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $adresse
 * @property int $isMedicasure
 * @property int $smsEnvoye
 * @property int $isNotice
 * @property string $decede
 * @property string|null $slack
 * @property-read Assistante|null $assistante
 * @property-read Association|null $association
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Contributeurs[] $contributeurs
 * @property-read int|null $contributeurs_count
 * @property-read DossierMedical|null $dossier
 * @property-read Gestionnaire|null $gestionnaire
 * @property-read mixed $nom_and_timestamp
 * @property-read mixed $signature
 * @property-read \Illuminate\Database\Eloquent\Collection|MedecinAvis[] $medecinAvis
 * @property-read int|null $medecin_avis_count
 * @property-read MedecinControle|null $medecinControle
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Patient|null $patient
 * @property-read \Illuminate\Database\Eloquent\Collection|Patient[] $patients
 * @property-read int|null $patients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Pharmacien|null $pharmacien
 * @property-read Praticien|null $praticien
 * @property-read ReponseSecrete|null $questionSecrete
 * @property-read \Illuminate\Database\Eloquent\Collection|RendezVous[] $rendezVous
 * @property-read int|null $rendez_vous_count
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read Souscripteur|null $souscripteur
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCodePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDecede($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsMedicasure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsNotice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNationalite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereQuartier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSlack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSmsEnvoye($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVille($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $last_activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $all_permissions
 * @property-read int|null $all_permissions_count
 * @property-read mixed $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GroupeUtilisateur[] $groupe_utilisateurs
 * @property-read int|null $groupe_utilisateurs_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCodeOTP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCodeR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastActivity($value)
 */
	class User extends \Eloquent implements \Spatie\MediaLibrary\HasMedia\HasMedia {}
}

