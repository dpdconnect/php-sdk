<?php

namespace DpdConnect\Sdk\Common;

/**
 * Interface AuthenticationResourceInterface
 *
 * @package DpdConnect\Sdk\Common
 */
interface AuthenticationResourceInterface
{
    /**
     * Authenticates with the password grant type.
     *
     * @param string $username
     * @param string $password
     *
     * @return array
     */
    public function authenticateByPassword($username, $password);
}
