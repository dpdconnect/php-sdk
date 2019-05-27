<?php

namespace DpdConnect\Sdk\Common;

interface AuthenticationResourceInterface
{
    /**
     * Authenticates with the password grant type.
     *
     * @param string $clientId
     * @param string $secret
     * @param string $username
     * @param string $password
     *
     * @return array
     */
    public function authenticateByPassword($username, $password);
}
