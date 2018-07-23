<?php

namespace App\Exceptions;

use Throwable;

class DataWrongException extends \Exception
{
    /**
     * @var array
     */
    private $data = [];

    public function __construct(array $data, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->data = $data;
        if (!$message && count($data) > 0) {
            $message = current($data);
        }
        parent::__construct($message, $code, $previous);
    }


    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}