<?php

namespace DpdConnect\Sdk\Common;

use DpdConnect\Sdk\Exceptions;

class ResponseError implements \JsonSerializable
{
    const EXCEPTION_MESSAGE = 'Got error response from the server: %s';

    const SUCCESS = 1;

    const REQUEST_NOT_ALLOWED = 2;

    const MISSING_PARAMS = 9;

    const INVALID_PARAMS = 10;

    const NOT_FOUND = 20;

    const NOT_ENOUGH_CREDIT = 'Bad credentials';

    const CHAT_API_AUTH_ERROR = 1001;

    const ACCESS_DENIED = 401;

    public $errors = [];
    public $validation = [];

    /**
     * Load the error data into an array.
     * Throw an exception when important errors are found.
     *
     * @param $body
     *
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\BalanceException
     */
    public function __construct($body, $validation = [])
    {
        if (!empty($validation)) {
            $this->validation = $validation;
        }

        if (!empty($body['errors'])) {
            foreach ($body['errors'] as $error) {
                if (isset($error['code'])) {
                    if ($error['code'] === self::ACCESS_DENIED) {
                        throw new Exceptions\AuthenticateException($this->getExceptionMessage($error));
                    } elseif ($error['code'] === self::REQUEST_NOT_ALLOWED) {
                        throw new Exceptions\AuthenticateException($this->getExceptionMessage($error));
                    } elseif ($error['code'] === self::CHAT_API_AUTH_ERROR) {
                        throw new Exceptions\AuthenticateException($this->getExceptionMessage($error));
                    } else {
                    }
                }

                $this->errors[] = $error;
            }

            return;
        }

        if (isset($body['code'])) {
            if ($body['code'] === self::ACCESS_DENIED) {
                throw new Exceptions\AuthenticateException($body['message']);
            } elseif ($body['code'] === self::REQUEST_NOT_ALLOWED) {
                throw new Exceptions\AuthenticateException($body['message']);
            } elseif ($body['code'] === self::CHAT_API_AUTH_ERROR) {
                throw new Exceptions\AuthenticateException($body['message']);
            } else {
            }
        }

        if (!empty($body['message'])) {
            $this->errors[] = $body['message'];
        }

        $this->errors[] = $body['message'];
    }

    /**
     * Get the exception message for the provided error.
     *
     * @param $error
     *
     * @return string
     */
    private function getExceptionMessage($error)
    {
        return sprintf(self::EXCEPTION_MESSAGE, $error['description']);
    }

    /**
     * Get a string of all of this response's concatenated error descriptions.
     *
     * @return string
     */
    public function getErrorString()
    {
        $errorDescriptions = [];

        foreach ($this->validation as $error) {
            $errorDescriptions[] = $error['message'];
        }

        if (empty($errorDescriptions)) {
            foreach ($this->errors as $error) {
                $errorDescriptions[] = $error;
            }
        }

        return print_r($errorDescriptions, true);
    }

    /**
     * @return string[]
     */
    public function jsonSerialize()
    {
        $properties = get_object_vars($this);
        $properties = array_filter($properties, function ($value) {
            return ! empty($value);
        });
        return $properties;
    }
}
