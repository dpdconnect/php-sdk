<?php

namespace DpdConnect\Sdk\Objects;

use DpdConnect\Sdk\Api\Data\Response\ResponseStatusInterface;

class ResponseStatus implements ResponseStatusInterface
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $message;

    /**
     * ResponseStatus constructor.
     *
     * @param int    $code
     * @param string $text
     * @param string $message
     */
    public function __construct($code, $text, $message)
    {
        $this->code = $code;
        $this->text = $text;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return ($this->code !== self::STATUS_FAILURE);
    }

    /**
     * @return bool
     */
    public function isError()
    {
        return ! $this->isSuccess();
    }
}
