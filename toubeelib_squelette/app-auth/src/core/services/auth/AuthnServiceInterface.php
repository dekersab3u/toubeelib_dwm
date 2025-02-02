<?php

namespace toubeelib\core\services\auth;

use toubeelib\core\dto\CredentialDTO;
use toubeelib\core\dto\UserDTO;

interface AuthnServiceInterface
{
    public function createUser(CredentialDTO $c,string $login,int $role);

    public function byCredentials(CredentialDTO $c): UserDTO;
}