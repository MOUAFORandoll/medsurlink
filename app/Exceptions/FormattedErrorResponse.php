<?php


namespace App\Exceptions;


class FormattedErrorResponse
{
    private  $field;
    private $ErrorMessage;

    /**
     * FormattedErrorResponse constructor.
     * @param $field
     * @param $message
     */
    public function __construct($field, $message)
    {
        $this->field = $field;
        $this->ErrorMessage = $message;
    }

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->ErrorMessage;
    }

    /**
     * @param mixed $ErrorMessage
     */
    public function setErrorMessage($ErrorMessage): void
    {
        $this->ErrorMessage = $ErrorMessage;
    }

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

    public function getArrayError(){
        $transmission = [];
        $transmission[$this->getField()][0] = $this->getErrorMessage();
        return $transmission;
    }
}
