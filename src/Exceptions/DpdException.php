<?php

namespace DpdConnect\Sdk\Exceptions;

use Exception;
use DpdConnect\Sdk\Common\ResponseError;

abstract class DpdException extends Exception
{
    private $errorDetails;

    public function __construct($error, $code = 0)
    {
        $this->errorDetails = $error;

        if ($error instanceof ResponseError) {
            parent::__construct($error->getErrorString());
        } elseif ($error instanceof Exception) {
            parent::__construct($error->getMessage(), $code, $error);
        } elseif (is_string($error)) {
            parent::__construct($error, $code);
        } else {
            
        }
    }

    public function getErrorDetails()
    {
        return $this->errorDetails;
    }
}