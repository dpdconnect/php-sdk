<?php

namespace DpdConnect\Sdk\Objects;

use JsonSerializable;

class ResourceResponse extends BaseObject implements JsonSerializable
{
    /**
     * @var string
     */
    protected $status;

    /**
     * @var string[]
     */
    protected $errors = [];

    /**
     * @var string[]
     */
    protected $validation = [];

    /**
     * @var string
     */
    protected $content;

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return ResourceResponse
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    public function hasErrors()
    {
        return (count($this->errors) >= 0);
    }

    /**
     * @param string[] $errors
     * @return ResourceResponse
     */
    public function setErrors(array $errors = [])
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * @param string[] $validation
     * @return ResourceResponse
     */
    public function setValidation(array $validation = [])
    {
        $this->validation = $validation;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return ResourceResponse
     */
    public function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }
}
