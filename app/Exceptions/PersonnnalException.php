<?php


namespace App\Exceptions;


class PersonnnalException extends \Exception
{
    private $field;

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param mixed $field
     */
    public function setField($field): void
    {
        $this->field = $field;
    }


   public function getErrorMessage(){
       $responseError = new FormattedErrorResponse($this->getField(),$this->getMessage());
       return $responseError->getArrayError();
   }

}
