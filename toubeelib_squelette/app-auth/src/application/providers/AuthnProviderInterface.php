<?php

namespace toubeelib\application\providers;

use PhpParser\Token;
use toubeelib\core\dto\CredentialDTO;
use toubeelib\core\dto\UserDTO;

interface AuthnProviderInterface
{
    public function register(CredentialDTO $c,string $login,int $role);
    public function signin(CredentialDTO $c): UserDTO;
    public function refresh(Token $token): UserDTO;
    public function getSignedInUser(string $token): UserDTO;

    public function validateToken(string $token): array;
}