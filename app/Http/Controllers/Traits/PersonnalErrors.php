<?php

namespace App\Http\Controllers\Traits;

use App\Exceptions\PersonnnalException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait PersonnalErrors
{
    protected $accessRefuse = "Vous n'êtes pas autorisé à mettre à jour cette element";

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
     * @throws PersonnnalException
     */
    public function checkIfAuthorized($type, $id, $action){

        $isAuthor = checkIfIsAuthorOrIsAuthorized($type,$id,$action);

        if($isAuthor->getOriginalContent() == false){
            $this->revealError('accessRefuse',$this->accessRefuse);
        }
    }
}
