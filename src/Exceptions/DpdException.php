<?php

namespace DpdConnect\Sdk\Exceptions;

use DpdConnect\Sdk\Common\ResponseError;
use Exception;

/**
 * Class DpdException
 *
 * @package DpdConnect\Sdk\Exceptions
 */
class DpdException extends Exception
{
    /**
     * @var mixed
     */
    private $errorDetails;

    /**
     * DpdException constructor.
     *
     * @param     $error
     * @param int $code
     */
    public function __construct($error, $code = 0)
    {
        $this->errorDetails = $error;

        if ($error instanceof ResponseError) {
            parent::__construct($error->getErrorString());
        } elseif ($error instanceof Exception) {
            parent::__construct($error->getMessage(), $code, $error);
        } elseif (is_string($error)) {
            parent::__construct($error, $code);
        }
    }

    /**
     * @return mixed
     */
    public function getErrorDetails()
    {
        return $this->errorDetails;
    }
}
