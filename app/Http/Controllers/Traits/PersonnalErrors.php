<?php

namespace App\Http\Controllers\Traits;

use App\Exceptions\PersonnnalException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait PersonnalErrors
{

    /**
     * @param $field
     * @param $message
     * @throws PersonnnalException
     */
    public function revealError($field, $message){
        if (strlen($message)>0){
            $personnnalException = new PersonnnalException($message);
            $personnnalException->setField($field);
            throw $personnnalException;
        }
    }

 /**
     * @param $field
     * @param $message
     * @throws PersonnnalException
     */
    public function staticRevealError($field, $message){
        if (strlen($message)>0){
            $personnnalException = new PersonnnalException($message);
            $personnnalException->setField($field);
            throw $personnnalException;
        }
    }

    /**
     * @param $slug
     * @param $table
     * @throws ValidationException
     */
    public function validatedSlug($slug, $table){
        $validation = Validator::make(compact('slug'),['slug'=>'exists:'.$table.',slug']);
        if ($validation->fails()){
            throw new ValidationException($validation,$validation->errors()->messages());
        }
    }

    /**
     * Verifie si autorisé avec effectué action ou retourne erreur
     * @param $type
     * @param $id
     * @param $action
     * @return bool
     * @throws PersonnnalException
     */
    public function checkIfAuthorized($type, $id, $action){

        $isAuthor = checkIfIsAuthorOrIsAuthorized($type,$id,$action);

        if($isAuthor->getOriginalContent() == false){
            $this->revealAccesRefuse();
        }

        return true;
    }

    public function checkIfCanUpdated($type, $id, $action){

        $isAuthor = checkIfCanUpdated($type,$id,$action);

        if($isAuthor->getOriginalContent() == false){
            $this->revealAccesRefuse();
        }

        return true;
    }


    /**
     * @throws PersonnnalException
     */
    public function revealAccesRefuse(){
        $accessRefuse = "Vous n'êtes pas autorisé à effectuer cette action";
        $this->revealError('accessRefuse',$accessRefuse);
    }

    /**
     * @throws PersonnnalException
     */
    public function staticRevealAccesRefuse(){
        $accessRefuse = "Vous n'êtes pas autorisé à effectuer cette action";
        if (strlen($accessRefuse)>0){
            $personnnalException = new PersonnnalException($accessRefuse);
            $personnnalException->setField('accessRefuse');
            throw $personnnalException;
        }
    }
    /**
     * @throws PersonnnalException
     */
    public function revealNonTransmis(){
        $nonTransmis = "Ce resultat n'a pas encoré été transmis";
        $this->revealError('nonTransmis',$nonTransmis);
    }
 /**
     * @throws PersonnnalException
     */
    public static function staticRevealNonTransmis(){
        $nonTransmis = "Ce resultat n'a pas encoré été transmis";
        if (strlen($nonTransmis)>0){
            $personnnalException = new PersonnnalException($nonTransmis);
            $personnnalException->setField('nonTransmis');
            throw $personnnalException;
        }
    }

    public function revealDuplicateDossier($numeroDossier){
        $uniqueDossier = "Ce patient a déja un dossier: ".$numeroDossier;
        $this->revealError('uniqueDossier',$uniqueDossier);
    }
}
