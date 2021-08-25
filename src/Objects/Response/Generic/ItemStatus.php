<?php

namespace DpdConnect\Sdk\Objects\Response\Generic;

/**
 * Class ItemStatus
 *
 * @package DpdConnect\Sdk\Objects\Response\Generic
 */
class ItemStatus extends ResponseStatus implements ItemStatusInterface
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * ItemStatus constructor.
     *
     * @param string $identifier
     * @param int    $code
     * @param string $text
     * @param string $message
     */
    public function __construct($identifier, $code, $text, $message)
    {
        $this->identifier = $identifier;

        parent::__construct($code, $text, $message);
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}
