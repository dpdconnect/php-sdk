<?php

namespace DpdConnect\Sdk\Api\Data\Response;

/**
 * Interface ResponseStatusInterface
 *
 * @package DpdConnect\Sdk\Api\Data\Response
 */
interface ResponseStatusInterface
{
    const STATUS_SUCCESS = 'SUCCESS';
    const STATUS_PARTIAL = 'PARTIALLY FAILED';
    const STATUS_FAILURE = 'FAILED';

    /**
     * @return string
     */
    public function getCode();

    /**
     * @return string
     */
    public function getText();

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return bool
     */
    public function isSuccess();

    /**
     * @return bool
     */
    public function isError();
}
