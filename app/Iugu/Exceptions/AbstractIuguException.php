<?php

namespace CodeBills\Iugu\Exceptions;

abstract class AbstractIuguException extends \Exception
{
    /**
     * @var null
     */
    private $errors;

    /**
     * AbstractIuguException constructor.
     *
     * @param null $errors
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($errors = null, $message = "", $code = 0, \Exception $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return null
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
